<?php

class stemmer
{
	
	var $dict;
	var $rules;
	var $options;
	
	function __construct()
	{	
		error_reporting(E_ALL & ~E_NOTICE);
		//ini_set('display_errors', 0);
		$dict = file_get_contents(FILE_DIR .'kamus/kamus.txt');
		$tmp = explode("\n", $dict);
		foreach ($tmp as $entry)
		{
			$attrib = explode("\t", strtolower($entry)); 
			$key = str_replace(' ', '', $attrib[1]);
			$this->dict[$key] = array('class' => $attrib[0], 'lemma' => $attrib[1]);
		}
		// Options
		$this->options = array(
			'SORT_INSTANCE'	=> false, // sort by number of instances
			'NO_NO_MATCH'	=> false, // hide no match entry
			'NO_DIGIT_ONLY'	=> true, // hide digit only
			'STRICT_CONFIX'	=> false, // use strict disallowed_confixes rules
		);
		// Define rules
		$VOWEL = 'a|i|u|e|o'; // vowels
		$CONSONANT = 'b|c|d|f|g|h|j|k|l|m|n|p|q|r|s|t|v|w|x|y|z'; // consonants
		$ANY = $VOWEL . '|' . $CONSONANT; // any characters
		$this->rules = array(
			'affixes' => array(
				array(1, array('kah', 'lah', 'tah', 'pun')),
				array(1, array('mu', 'ku', 'nya')),
				array(0, array('ku', 'kau')),
				array(1, array('i', 'kan', 'an')),
			),
			'prefixes' => array(
				array(0, "(di|ke|se)({$ANY})(.+)", ""), // 0
				array(0, "(ber|ter)({$ANY})(.+)", ""), // 1, 6 normal
				array(0, "(be|te)(r)({$VOWEL})(.+)", ""), // 1, 6 be-rambut
				array(0, "(be|te)({$CONSONANT})({$ANY}?)(er)(.+)", ""), // 3, 7 te-bersit, te-percaya
				array(0, "(bel|pel)(ajar|unjur)", ""), // ajar, unjur
				array(0, "(me|pe)(l|m|n|r|w|y)(.+)", ""), // 10, 20: merawat, pemain
				array(0, "(mem|pem)(b|f|v)(.+)", ""), // 11 23: membuat, pembuat
				array(0, "(men|pen)(c|d|j|z)(.+)", ""), // 14 27: mencabut, pencabut
				array(0, "(meng|peng)(g|h|q|x)(.+)", ""), // 16 29: menggiring, penghasut
				array(0, "(meng|peng)({$VOWEL})(.+)", ""), // 17 30 meng-anjurkan, peng-anjur
				array(0, "(mem|pem)({$VOWEL})(.+)", "p"), // 13 26: memerkosa, pemerkosa
				array(0, "(men|pen)({$VOWEL})(.+)", "t"), // 15 28 menutup, penutup
				array(0, "(meng|peng)({$VOWEL})(.+)", "k"), // 17 30 mengalikan, pengali
				array(0, "(meny|peny)({$VOWEL})(.+)", "s"), // 18 31 menyucikan, penyucian
				array(0, "(mem)(p)({$CONSONANT})(.+)", ""), // memproklamasikan
				array(0, "(pem)({$CONSONANT})(.+)", "p"), // pemrogram
				array(0, "(men|pen)(t)({$CONSONANT})(.+)", ""), // mentransmisikan pentransmisian
				array(0, "(meng|peng)(k)({$CONSONANT})(.+)", ""), // mengkristalkan pengkristalan
				array(0, "(men|pen)(s)({$CONSONANT})(.+)", ""), // mensyaratkan pensyaratan
				array(0, "(menge|penge)({$CONSONANT})(.+)", ""), // swarabakti: mengepel
				array(0, "(mempe)(r)({$VOWEL})(.+)", ""), // 21
				array(0, "(memper)({$ANY})(.+)", ""), // 21
				array(0, "(pe)({$ANY})(.+)", ""), // 20
				array(0, "(per)({$ANY})(.+)", ""), // 21
				array(0, "(pel)({$CONSONANT})(.+)", ""), // 32 pelbagai, other?
				array(0, "(mem)(punya)", ""), // Exception: mempunya
				array(0, "(pen)(yair)", "s"), // Exception: penyair > syair
			),
			'disallowed_confixes' => array(
				array('ber-', '-i'),
				array('ke-', '-i'),
				array('pe-', '-kan'),
				array('di-', '-an'),
				array('meng-', '-an'),
				array('ter-', '-an'),
				array('ku-', '-an'),
			),
			'allomorphs' => array(
				'be' => array('be-', 'ber-', 'bel-'),
				'te' => array('te-', 'ter-', 'tel-'),
				'pe' => array('pe-', 'per-', 'pel-', 'pen-', 'pem-', 'peng-', 'peny-', 'penge-'),
				'me' => array('me-', 'men-', 'mem-', 'meng-', 'meny-', 'menge-'),
			),
		);

	}

	/**
	 * Tokenization
	 */
	function stem($query)
	{
		$words = array();
		$raw = preg_split('/[^a-zA-Z0-9\-]/', $query, -1, PREG_SPLIT_NO_EMPTY);
		echo $query;
		foreach ($raw as $r)
		{
			// Remove all digit "word" if necessary
			if ($this->options['NO_DIGIT_ONLY'] && preg_match('/^\d+$/', $r))
				continue;
			$key = strtolower($r);
			$words[$key]['count']++;
		}
		foreach ($words as $key => $word)
		{
			$words[$key]['roots'] = $this->stem_word($key);
			// If NO_NO_MATCH, remove words that has no root
			if (count($words[$key]['roots']) == 0 && $this->options['NO_NO_MATCH'])
			{
				unset($words[$key]);
				continue;
			}
			$instances[$key] = $word['count'];
		}
		$word_count = count($words);
		if ($this->options['SORT_INSTANCE'])
		{
			$keys = array_keys($words);
			array_multisort($instances, SORT_DESC, $keys, SORT_ASC, $words);
		}
		else
			ksort($words);
		return($words);
	}

	/**
	 * Stem individual word
	 */
	function stem_word($word)
	{
		// Preprocess: Create empty affix if original word is in lexicon
		$word = trim($word);
		$roots = array($word => '');
		if (array_key_exists($word, $this->dict))
			$roots[$word]['affixes'] = array();
		// Has dash? Try to also find root for each element
		if (strpos($word, '-'))
		{
			$dash_parts = explode('-', $word);
			foreach ($dash_parts as $dash_part)
				$roots[$dash_part]['affixes'] = array();
		}
		//echo $word;
		// Process: Find suffixes, pronoun prefix, and other prefix (3 times, Asian)
		foreach ($this->rules['affixes'] as $group)
		{
			$is_suffix = $group[0];
			$affixes = $group[1];
			foreach ($affixes as $affix)
			{
				$pattern = $is_suffix ? "(.+)({$affix})" : "({$affix})(.+)";
				$this->add_root($roots, array($is_suffix, $pattern, ''));
			}
		}
		//print_r($roots);
		for ($i = 0; $i < 3; $i++)
			foreach ($this->rules['prefixes'] as $rule)
				$this->add_root($roots, $rule);
		//print_r($roots);
		// Postprocess 1: Select valid affixes
		foreach ($roots as $lemma => $attrib)
		{
			// Not in dictionary? Unset and exit
			if (!array_key_exists($lemma, $this->dict))
			{
				unset($roots[$lemma]);
				continue;
			}
			// Escape if we don't have to check valid confix pairs
			if (!$this->options['STRICT_CONFIX'])
				continue;
			// Check confix pairs
			$affixes = $attrib['affixes'];
			foreach ($this->rules['disallowed_confixes'] as $pair)
			{
				$prefix = $pair[0];
				$suffix = $pair[1];
				$prefix_key = substr($prefix, 0, 2);
				if (array_key_exists($prefix_key, $this->rules['allomorphs']))
				{
					foreach ($this->rules['allomorphs'][$prefix_key] as $allomorf)
						if (in_array($allomorf, $affixes) && in_array($suffix, $affixes))
							unset($roots[$lemma]);
				}
				else
					if (in_array($prefix, $affixes) && in_array($suffix, $affixes))
						unset($roots[$lemma]);
			}
		}
		
		return($roots);
	}

	/**
	 * Greedy algorithm: add every possible branch
	 */
	function add_root(&$roots, $rule)
	{
		
		$is_suffix = $rule[0];
		$pattern = '/^' . $rule[1] . '$/i';
		$variant = $rule[2];
		foreach ($roots as $lemma => $attrib)
		{
			preg_match($pattern, $lemma, $matches);
			if (count($matches) > 0)
			{
				unset($new_lemma); unset($new_affix);
				$affix_index = $is_suffix ? 2 : 1;

				// Lemma
				for ($i = 1; $i < count($matches); $i++)
					if ($i != $affix_index)
						$new_lemma .= $matches[$i];
				if ($variant)
					$new_lemma = $variant . $new_lemma;

				// Affix, add - before (suffix), after (prefix)
				$new_affix .= $is_suffix ? '-' : '';
				$new_affix .= $matches[$affix_index];
				$new_affix .= $is_suffix ? '' : '-';
				$new_affix = array($new_affix); // make array
				if (isset($attrib['affixes']) && is_array($attrib['affixes'])) // merge
					$new_affix = array_merge($attrib['affixes'], $new_affix);

				// Push
				$roots[$new_lemma] = array('affixes' => $new_affix);
			}
		}
	}
	
	public function Root($word=null){
		$arr = $this->stem_word(strtolower($word));
		if(empty($arr)){
			return $word;
		} else {
			return $this->firstRoot($arr);
		}
		
	}
	public function Root2($word=null){
		//$arr = $this->stem_word(strtolower($word));
		// if(empty($arr)){
			// return $word;
		// } else {
			// return $this->firstRoot($arr);
		// }
		return $word;
		
	}
	
	private function firstRoot($array){
		foreach($array as $ar => $val){
			return $ar;
			break;
		}
	}
	
}


?>
