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
		// echo '<pre>';
		// print_r($root);
		// echo '</pre>';
		$request = Core::request();
		if(!empty($request)){
			$year = $request['tahun'];
			$dosen = $request['dosen'];
			$jenis = $request['jenis'];
			//$JurnalModel = $this->loadmodel('JurnalModel');
			$ndb = new DB();
			$Jurnals = $ndb->query("SELECT `filetext` FROM `jurnals` WHERE `YEAR` = '{$year}' AND `lecturer_ids` LIKE '%{$dosen}%'");
			$_Jurnals = $Jurnals;
			if(!empty($_Jurnals)){
				foreach($_Jurnals as $k => $_Jurnal){
					$filetext[] = $_Jurnal['filetext'];
				}
			}
			
			// echo '<pre>';
			// print_r($_Jurnals);
			// echo '</pre>';
		}
		
		// echo '<pre>';
		// print_r($filetext);
		// echo '</pre>';
		
		foreach($root as $value)
		{
			if($value === '.' || $value === '..') {continue;}
			
			if(!in_array($value,$filetext)) {continue;}			
			
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
		
		// print_r($request);
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