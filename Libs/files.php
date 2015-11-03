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
		$req = false;
		$request = Core::request();
		// print_r($request);
		
		if(($request)){
			
			$from = ($request['from'])?$request['from']: '2000';
			$to = ($request['to'])?$request['to']: date("Y");
		
			$jenis = $request['jenis'];
			$penulis = strtolower($request['penulis']);
			$aSql = array();
			
			// if($tahun != 0){
				// $aSql[]= " `year` = $tahun ";			
			// }
			
			if($penulis){
				$aSql[]= " `writer_1` LIKE '%{$penulis}' OR `writer_2` LIKE '%{$penulis}'";			
			}
			if($jenis){
				$aSql[]= " `jenis` = '{$jenis}' ";			
			}
			
			// print_r($aSql);
			
			$ndb = new DB();
			
			$sql = "SELECT `filetext` FROM `jurnals`";
		
			if(count($aSql)){
				$where_clause = implode(' AND ', $aSql);
				$where_clause .= " AND `year` between $from and $to";
				$sql .= " WHERE ". $where_clause;
			} else {
				$where_clause .= " `year` between $from and $to";
				$sql .= " WHERE ". $where_clause;
			}
			// echo $sql;
			// exit();
			$Jurnals = $ndb->query($sql);
			$_Jurnals = $Jurnals;
			
			if(!empty($_Jurnals)){
				foreach($_Jurnals as $k => $_Jurnal){
					$filetext[] = $_Jurnal['filetext'];
				}
			}

		} 
		
		// echo '<pre>';
		// print_r($filetext);
		// echo '</pre>';
		// exit();
		
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
		// echo '<pre>';
		// print_r($result);
		// echo '</pre>';
		
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
		// echo '<pre>';
		// print_r($collection);
		// echo '</pre>';
		// exit();
		return $collection;
	}
	
}
?>