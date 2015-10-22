<?php

include 'files.php';

Class vsm {
	function pr($var=array()){
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
	
	public function testing(){
		$collection = new files;
		return $collection->test();
	}
	
	public function normlize($serialize){
		return unserialize(urldecode($serialize));
	}
	
	function getCollection(){
		$collection = new files;
		//$a = BaseController::loadmodel('SearchModel');
		return $collection->getCollection();
	}
	function getIndex($collection=null) {
		if($collection==null){
			$collection = $this->getCollection();
		}
			//$this->pr($collection);
			$dictionary = array();
			$docCount = array();
			
			foreach($collection as $docID => $doc) {
					$terms = $doc;
					$docCount[$docID] = count($doc);
					
					foreach($terms as $term) {
							$term = strtolower($term);
							if(!isset($dictionary[$term])) {
							   $dictionary[$term] = array('df' => 0, 
							   'postings' => array());
							}
							if(!isset($dictionary[$term]['postings'][
							$docID])) {
									$dictionary[$term]['df']++;
									$dictionary[$term]['postings'][$docID] 
									= array('tf' => 0);
							}

							$dictionary[$term]['postings'][$docID]['tf']++;
					}
			}

			$return =  array('docCount' => $docCount, 'dictionary' => $dictionary);
			//$this->pr($return);
			return $return;
	}

	function getKeyword($array) {
			$collection = $array;
			
			$dictionary = array();
			$docCount = array();

			foreach($collection as $docID => $doc) {
					$terms = explode(' ', $doc);
					$docCount[$docID] = count($terms);

					foreach($terms as $term) {
							if(!isset($dictionary[$term])) {
									$dictionary[$term] = array('df' => 0, 'postings' => array());
							}
							if(!isset($dictionary[$term]['postings'][$docID])) {
									$dictionary[$term]['df']++;
									$dictionary[$term]['postings'][$docID] = array('tf' => 0);
							}

							$dictionary[$term]['postings'][$docID]['tf']++;
					}
			}

			return array('docCount' => $docCount, 'dictionary' => $dictionary);
	}


	function getTfidf($terms,$index=null) {
		if($index==null){ $index = $this->getIndex(); }
			$docCount = count($index['docCount']);
			foreach($terms as $term){
			$entry = $index['dictionary'][$term];
				if(!empty($entry['df'])){
					//foreach($entry['postings'] as  $docID => $postings) {
					if($temp!=$term){
						$kk += pow((1 * log(($docCount+1) / $entry['df'], 10)),2);
						$temp = $term;
					} else {
						$kk += 0;
					}
					
					//}
				}
			}

			return sqrt($kk);
			
	}
	
	function getW($terms,$index=null) {
		if($index==null){ $index = $this->getIndex(); }
			$docCount = count($index['docCount']);
			$entry = $index['dictionary'][$terms];
				if(!empty($entry['df'])){
				//echo $docID;
					foreach($entry['postings'] as  $docID => $postings) {
						$kk[$docID] = (1 * log(($docCount+1) / $entry['df'], 10));
					}

					}
			return ($kk);
			
	}
	
	function normalise($doc) {
			foreach($doc as $entry) {
					$total += $entry*$entry;
			}
			$total = sqrt($total);
			foreach($doc as &$entry) {
					$entry = $entry/$total;
			}
			return $doc;
	}
	function cosineSim($docA, $docB) {
			$result = 0;
			foreach($docA as $key => $weight) {
					$result += $weight * $docB[$key];
			}
			return $result;
	}

	function coSim($sqrtDi,$kkdotDi,$sqrtkk){
		if($sqrtkk!=0){
			$cos = $kkdotDi/((sqrt($sqrtDi))*($sqrtkk));
			return $cos;
		} else {
			return false;
		}
		
	}
}
?>