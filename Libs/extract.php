<?php
Class extract {
	
	function word2txt($filename)
	{
		$lastpoint=strrpos($filename,".");
		$extension=substr($filename,$lastpoint,5);
		//echo $filename;
		switch ($extension){
			case ".doc":
				return $this->doc2text($filename);
			break;
			case ".docx":
				return $this->docx2text($filename);
			break;
			case ".rtf":
				return $this->rtf2text($filename);
			break;
			
			case ".odt":
				return $this->odt2text($filename);
			break;
			case ".txt":
				return $this->txt2text($filename);
			break;
			default:
				return false;
			break;
		}
		
	}
	
	function odt2text($filename) {
		return $this->readZippedXML($filename, "content.xml");
	}
	
	public function docx2text($filename) {
		return $this->readZippedXML($filename, "word/document.xml");
	}
	
	public function doc2text($filename)
	{
		if (file_exists($filename) )
		{
			if ( ($fh = fopen($filename, 'r')) !== false )
			{
				$headers = fread($fh, 0xA00);
				# 1 = (ord(n)*1) ; Document has from 0 to 255 characters
				$n1 = (ord($headers[0x21C]) - 1 );
				# 1 = ((ord(n)-8)*256) ; Document has from 256 to 63743 characters
				$n2 = ((ord($headers[0x21D]) - 8 ) * 256 );
				# 1 = ((ord(n)*256)*256) ; Document has from 63744 to 16775423 characters
				$n3 = ((ord($headers[0x21E]) * 256 ) * 256 );
				# (((ord(n)*256)*256)*256) ; Document has from 16775424 to 4294965504 characters
				$n4 = (((ord($headers[0x21F]) * 256 ) * 256 ) * 256 );
				# Total length of text in the document
				$textLength = ($n1 + $n2 + $n3 + $n4);
				$extracted_plaintext = fread($fh, $textLength);
				# if you want the plain text with no formatting, do this
				//echo $extracted_plaintext;
				# if you want to see your paragraphs in a web page, do this
				return nl2br($extracted_plaintext);
			}
		}
	}

	function readZippedXML($archiveFile, $dataFile) {
		// Create new ZIP archive
		$zip = new ZipArchive;
		// Open received archive file
		if (true === $zip->open($archiveFile)) {
			// If done, search for the data file in the archive
			if (($index = $zip->locateName($dataFile)) !== false) {
				// If found, read it to the string
				$data = $zip->getFromIndex($index);
				// Close archive file
				$zip->close();
				// Load XML from a string
				// Skip errors and warnings
				$xml = DOMDocument::loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
				// Return data without XML formatting tags
				return strip_tags($xml->saveXML());
			}
			$zip->close();
		}

		// In case of failure return empty string
		return "";
	}

	function rtf_isPlainText($s) {
		$arrfailAt = array("*", "fonttbl", "colortbl", "datastore", "themedata");
		for ($i = 0; $i < count($arrfailAt); $i++)
			if (!empty($s[$arrfailAt[$i]])) return false;
		return true;
	}

	function rtf2text($filename) {
		// Read the data from the input file.
		$text = file_get_contents($filename);
		if (!strlen($text))
			return "";

		// Create empty stack array.
		$document = "";
		$stack = array();
		$j = -1;
		// Read the data character-by- character�
		for ($i = 0, $len = strlen($text); $i < $len; $i++) {
			$c = $text[$i];

			// Depending on current character select the further actions.
			switch ($c) {
				// the most important key word backslash
				case "\\":
					// read next character
					$nc = $text[$i + 1];

					// If it is another backslash or nonbreaking space or hyphen,
					// then the character is plain text and add it to the output stream.
					if ($nc == '\\' && $this->rtf_isPlainText($stack[$j])) $document .= '\\';
					elseif ($nc == '~' && $this->rtf_isPlainText($stack[$j])) $document .= ' ';
					elseif ($nc == '_' && $this->rtf_isPlainText($stack[$j])) $document .= '-';
					// If it is an asterisk mark, add it to the stack.
					elseif ($nc == '*') $stack[$j]["*"] = true;
					// If it is a single quote, read next two characters that are the hexadecimal notation
					// of a character we should add to the output stream.
					elseif ($nc == "'") {
						$hex = substr($text, $i + 2, 2);
						if ($this->rtf_isPlainText($stack[$j]))
							$document .= html_entity_decode("&#".hexdec($hex).";");
						//Shift the pointer.
						$i += 2;
					// Since, we�ve found the alphabetic character, the next characters are control word
					// and, possibly, some digit parameter.
					} elseif ($nc >= 'a' && $nc <= 'z' || $nc >= 'A' && $nc <= 'Z') {
						$word = "";
						$param = null;

						// Start reading characters after the backslash.
						for ($k = $i + 1, $m = 0; $k < strlen($text); $k++, $m++) {
							$nc = $text[$k];
							// If the current character is a letter and there were no digits before it,
							// then we�re still reading the control word. If there were digits, we should stop
							// since we reach the end of the control word.
							if ($nc >= 'a' && $nc <= 'z' || $nc >= 'A' && $nc <= 'Z') {
								if (empty($param))
									$word .= $nc;
								else
									break;
							// If it is a digit, store the parameter.
							} elseif ($nc >= '0' && $nc <= '9')
								$param .= $nc;
							// Since minus sign may occur only before a digit parameter, check whether
							// $param is empty. Otherwise, we reach the end of the control word.
							elseif ($nc == '-') {
								if (empty($param))
									$param .= $nc;
								else
									break;
							} else
								break;
						}
						// Shift the pointer on the number of read characters.
						$i += $m - 1;

						// Start analyzing what we�ve read. We are interested mostly in control words.
						$toText = "";
						switch (strtolower($word)) {
							// If the control word is "u", then its parameter is the decimal notation of the
							// Unicode character that should be added to the output stream.
							// We need to check whether the stack contains \ucN control word. If it does,
							// we should remove the N characters from the output stream.
							case "u":
								$toText .= html_entity_decode("&#x".dechex($param).";");
								$ucDelta = @$stack[$j]["uc"];
								if ($ucDelta > 0)
									$i += $ucDelta;
							break;
							// Select line feeds, spaces and tabs.
							case "par": case "page": case "column": case "line": case "lbr":
								$toText .= "\n";
							break;
							case "emspace": case "enspace": case "qmspace":
								$toText .= " ";
							break;
							case "tab": $toText .= "\t"; break;
							// Add current date and time instead of corresponding labels.
							case "chdate": $toText .= date("m.d.Y"); break;
							case "chdpl": $toText .= date("l, j F Y"); break;
							case "chdpa": $toText .= date("D, j M Y"); break;
							case "chtime": $toText .= date("H:i:s"); break;
							// Replace some reserved characters to their html analogs.
							case "emdash": $toText .= html_entity_decode("&mdash;"); break;
							case "endash": $toText .= html_entity_decode("&ndash;"); break;
							case "bullet": $toText .= html_entity_decode("&#149;"); break;
							case "lquote": $toText .= html_entity_decode("&lsquo;"); break;
							case "rquote": $toText .= html_entity_decode("&rsquo;"); break;
							case "ldblquote": $toText .= html_entity_decode("&laquo;"); break;
							case "rdblquote": $toText .= html_entity_decode("&raquo;"); break;
							// Add all other to the control words stack. If a control word
							// does not include parameters, set &param to true.
							default:
								$stack[$j][strtolower($word)] = empty($param) ? true : $param;
							break;
						}
						// Add data to the output stream if required.
						if ($this->rtf_isPlainText($stack[$j]))
							$document .= $toText;
					}

					$i++;
				break;
				// If we read the opening brace {, then new subgroup starts and we add
				// new array stack element and write the data from previous stack element to it.
				case "{":
					array_push($stack, $stack[$j++]);
				break;
				// If we read the closing brace }, then we reach the end of subgroup and should remove
				// the last stack element.
				case "}":
					array_pop($stack);
					$j--;
				break;
				// Skip �trash�.
				case '\0': case '\r': case '\f': case '\n': break;
				// Add other data to the output stream if required.
				default:
					if ($this->rtf_isPlainText($stack[$j]))
						$document .= $c;
				break;
			}
		}
		// Return result.
		return $document;
	} 

	function decodeAsciiHex($input) {
		$output = "";

		$isOdd = true;
		$isComment = false;

		for($i = 0, $codeHigh = -1; $i < strlen($input) && $input[$i] != '>'; $i++) {
			$c = $input[$i];

			if($isComment) {
				if ($c == '\r' || $c == '\n')
					$isComment = false;
				continue;
			}

			switch($c) {
				case '\0': case '\t': case '\r': case '\f': case '\n': case ' ': break;
				case '%': 
					$isComment = true;
				break;

				default:
					$code = hexdec($c);
					if($code === 0 && $c != '0')
						return "";

					if($isOdd)
						$codeHigh = $code;
					else
						$output .= chr($codeHigh * 16 + $code);

					$isOdd = !$isOdd;
				break;
			}
		}

		if($input[$i] != '>')
			return "";

		if($isOdd)
			$output .= chr($codeHigh * 16);

		return $output;
	}
	function decodeAscii85($input) {
		$output = "";

		$isComment = false;
		$ords = array();
		
		for($i = 0, $state = 0; $i < strlen($input) && $input[$i] != '~'; $i++) {
			$c = $input[$i];

			if($isComment) {
				if ($c == '\r' || $c == '\n')
					$isComment = false;
				continue;
			}

			if ($c == '\0' || $c == '\t' || $c == '\r' || $c == '\f' || $c == '\n' || $c == ' ')
				continue;
			if ($c == '%') {
				$isComment = true;
				continue;
			}
			if ($c == 'z' && $state === 0) {
				$output .= str_repeat(chr(0), 4);
				continue;
			}
			if ($c < '!' || $c > 'u')
				return "";

			$code = ord($input[$i]) & 0xff;
			$ords[$state++] = $code - ord('!');

			if ($state == 5) {
				$state = 0;
				for ($sum = 0, $j = 0; $j < 5; $j++)
					$sum = $sum * 85 + $ords[$j];
				for ($j = 3; $j >= 0; $j--)
					$output .= chr($sum >> ($j * 8));
			}
		}
		if ($state === 1)
			return "";
		elseif ($state > 1) {
			for ($i = 0, $sum = 0; $i < $state; $i++)
				$sum += ($ords[$i] + ($i == $state - 1)) * pow(85, 4 - $i);
			for ($i = 0; $i < $state - 1; $i++)
				$ouput .= chr($sum >> ((3 - $i) * 8));
		}

		return $output;
	}
	function decodeFlate($input) {
		return @gzuncompress($input);
	}

	function getObjectOptions($object) {
		$options = array();
		if (preg_match("#<<(.*)>>#ismU", $object, $options)) {
			$options = explode("/", $options[1]);
			@array_shift($options);

			$o = array();
			for ($j = 0; $j < @count($options); $j++) {
				$options[$j] = preg_replace("#\s+#", " ", trim($options[$j]));
				if (strpos($options[$j], " ") !== false) {
					$parts = explode(" ", $options[$j]);
					$o[$parts[0]] = $parts[1];
				} else
					$o[$options[$j]] = true;
			}
			$options = $o;
			unset($o);
		}

		return $options;
	}
	function getDecodedStream($stream, $options) {
		$data = "";
		if (empty($options["Filter"]))
			$data = $stream;
		else {
			$length = !empty($options["Length"]) ? $options["Length"] : strlen($stream);
			$_stream = substr($stream, 0, $length);

			foreach ($options as $key => $value) {
				if ($key == "ASCIIHexDecode")
					$_stream = $this->decodeAsciiHex($_stream);
				if ($key == "ASCII85Decode")
					$_stream = $this->decodeAscii85($_stream);
				if ($key == "FlateDecode")
					$_stream = $this->decodeFlate($_stream);
			}
			$data = $_stream;
		}
		return $data;
	}
	function getDirtyTexts(&$texts, $textContainers) {
		for ($j = 0; $j < count($textContainers); $j++) {
			if (preg_match_all("#\[(.*)\]\s*TJ#ismU", $textContainers[$j], $parts))
				$texts = array_merge($texts, @$parts[1]);
			elseif(preg_match_all("#Td\s*(\(.*\))\s*Tj#ismU", $textContainers[$j], $parts))
				$texts = array_merge($texts, @$parts[1]);
		}
	}
	function getCharTransformations(&$transformations, $stream) {
		preg_match_all("#([0-9]+)\s+beginbfchar(.*)endbfchar#ismU", $stream, $chars, PREG_SET_ORDER);
		preg_match_all("#([0-9]+)\s+beginbfrange(.*)endbfrange#ismU", $stream, $ranges, PREG_SET_ORDER);

		for ($j = 0; $j < count($chars); $j++) {
			$count = $chars[$j][1];
			$current = explode("\n", trim($chars[$j][2]));
			for ($k = 0; $k < $count && $k < count($current); $k++) {
				if (preg_match("#<([0-9a-f]{2,4})>\s+<([0-9a-f]{4,512})>#is", trim($current[$k]), $map))
					$transformations[str_pad($map[1], 4, "0")] = $map[2];
			}
		}
		for ($j = 0; $j < count($ranges); $j++) {
			$count = $ranges[$j][1];
			$current = explode("\n", trim($ranges[$j][2]));
			for ($k = 0; $k < $count && $k < count($current); $k++) {
				if (preg_match("#<([0-9a-f]{4})>\s+<([0-9a-f]{4})>\s+<([0-9a-f]{4})>#is", trim($current[$k]), $map)) {
					$from = hexdec($map[1]);
					$to = hexdec($map[2]);
					$_from = hexdec($map[3]);

					for ($m = $from, $n = 0; $m <= $to; $m++, $n++)
						$transformations[sprintf("%04X", $m)] = sprintf("%04X", $_from + $n);
				} elseif (preg_match("#<([0-9a-f]{4})>\s+<([0-9a-f]{4})>\s+\[(.*)\]#ismU", trim($current[$k]), $map)) {
					$from = hexdec($map[1]);
					$to = hexdec($map[2]);
					$parts = preg_split("#\s+#", trim($map[3]));
					
					for ($m = $from, $n = 0; $m <= $to && $n < count($parts); $m++, $n++)
						$transformations[sprintf("%04X", $m)] = sprintf("%04X", hexdec($parts[$n]));
				}
			}
		}
	}
	function getTextUsingTransformations($texts, $transformations) {
		$document = "";
		for ($i = 0; $i < count($texts); $i++) {
			$isHex = false;
			$isPlain = false;

			$hex = "";
			$plain = "";
			for ($j = 0; $j < strlen($texts[$i]); $j++) {
				$c = $texts[$i][$j];
				switch($c) {
					case "<":
						$hex = "";
						$isHex = true;
					break;
					case ">":
						$hexs = str_split($hex, 4);
						for ($k = 0; $k < count($hexs); $k++) {
							$chex = str_pad($hexs[$k], 4, "0");
							if (isset($transformations[$chex]))
								$chex = $transformations[$chex];
							$document .= html_entity_decode("&#x".$chex.";");
						}
						$isHex = false;
					break;
					case "(":
						$plain = "";
						$isPlain = true;
					break;
					case ")":
						$document .= $plain;
						$isPlain = false;
					break;
					case "\\":
						$c2 = $texts[$i][$j + 1];
						if (in_array($c2, array("\\", "(", ")"))) $plain .= $c2;
						elseif ($c2 == "n") $plain .= '\n';
						elseif ($c2 == "r") $plain .= '\r';
						elseif ($c2 == "t") $plain .= '\t';
						elseif ($c2 == "b") $plain .= '\b';
						elseif ($c2 == "f") $plain .= '\f';
						elseif ($c2 >= '0' && $c2 <= '9') {
							$oct = preg_replace("#[^0-9]#", "", substr($texts[$i], $j + 1, 3));
							$j += strlen($oct) - 1;
							$plain .= html_entity_decode("&#".octdec($oct).";");
						}
						$j++;
					break;

					default:
						if ($isHex)
							$hex .= $c;
						if ($isPlain)
							$plain .= $c;
					break;
				}
			}
			$document .= "\n";
		}

		return $document;
	}

	function txt2text($filename) {
		return @file_get_contents($filename);
	}
	function pdf2text($filename) {
		$infile = @file_get_contents($filename, FILE_BINARY);
		if (empty($infile))
			return "";

		$transformations = array();
		$texts = array();

		preg_match_all("#obj(.*)endobj#ismU", $infile, $objects);
		$objects = @$objects[1];

		for ($i = 0; $i < count($objects); $i++) {
			$currentObject = $objects[$i];

			if (preg_match("#stream(.*)endstream#ismU", $currentObject, $stream)) {
				$stream = ltrim($stream[1]);

				$options = $this->decodeFlate($currentObject);
				if (!(empty($options["Length1"]) && empty($options["Type"]) && empty($options["Subtype"])))
					continue;

				$data = $this->decodeFlate($stream, $options); 
				if (strlen($data)) {
					if (preg_match_all("#BT(.*)ET#ismU", $data, $textContainers)) {
						$textContainers = @$textContainers[1];
						$this->decodeFlate($texts, $textContainers);
					} else
						$this->getCharTransformations($transformations, $data);
				}
			}
		}

		return $this->getTextUsingTransformations($texts, $transformations);
	}

	function find_all_files($dir)
	{
		$root = scandir($dir);
		foreach($root as $value)
		{
			if($value === '.' || $value === '..') {continue;}
			if(is_file("$dir/$value")) {
				$result[]="$dir/$value";
				continue;
			}
			foreach(find_all_files("$dir/$value") as $value)
			{
				$result[]=$value;
			}
		}
		return $result;
	}
}	
?>