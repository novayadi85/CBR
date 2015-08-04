<?php
Class files{

	public function test(){
		echo BASE_URL;
	}

	function allxml(){
		$directory = @opendir(FILE_DIR .'xml');
		$te = @readdir($directory);
		$files = $this->find_all_files(FILE_DIR .'xml');
		return $files;
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
			foreach($this->find_all_files("$dir/$value") as $value)
			{
				$result[]=$value;
			}
		}
		return $result;
	}
	function getCollection(){
		$files = $this->allxml();
		$ii=0;
		foreach($files as $file){
			$XML_string = $file;
			
			$xml = simplexml_load_file($XML_string);
			if ($xml) {
				$a = (int) $xml->Detail->ID;
				$array = $xml->xpath('//Words');
				$array = (array) $array[0];
				foreach($array as $word=>$val){
					$collection[$a] = $val;
				}
			}
		}
		return $collection;
	}
	
}
?>