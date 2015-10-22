<?php 
require_once ('stemmer.php');
require_once ('vsm.php');
class pencarian{
	
	var $q = "manfaat metode penelitian";
	
	public $globals = array();
	public $corpus_terms = array();
	public $num_docs = 0;
	
	
	function pre($var=array()){
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
	
	
	function search(){
		$stemmer = new stemmer();
		$this->globals = explode(' ',strtolower($this->q));
		$collection=array();
		
		foreach($this->globals as $q){
            $queryafter[$q] = $stemmer->Root($q);
        }
        $query = array_values($queryafter);
		$this->pre($query);
		//$keyword = $vsm->getTfidf($queryafter,$index);
	}
	
	function getIndex($collection) {

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
	
	
	function gethasil($_getTerm , $collections = null){
		//print_r($_getTerm);
		//print_r($collections);
		$start = microtime(true);
		$the_cache = FILE_DIR .'cache/temp/cache.txt';
		file_put_contents($the_cache,(string) $_getTerm, FILE_APPEND | LOCK_EX);
		$params = explode(' ',strtolower($_getTerm));

		$stemmer = new stemmer();	
		$vsm = new vsm();
		
		
		$collection= array();
		$this->globals = $params;
		foreach($this->globals as $q){
            $queryafter[$q] = $stemmer->Root($q);
        }
        $query = array_values($queryafter);
		$fileIndex = FILE_DIR .'cache/index/test.txt';
		
		// $terindex = file_get_contents($fileIndex);
		// $index = $vsm->normlize($terindex);
		
		$index = $vsm->getIndex($collections);
		//$this->pre($index);
		$matchDocs = array();
		$docCount = count($index['docCount']);
		$dictionary = $index['dictionary'];
		// $this->pre($dictionary);
		foreach($dictionary as $word=>$array){
			//array_unshift($collection,$word);
			$collection[] = $word;
		}
		if($docCount) $docCount = 2;
		
		//$this->pre($collection);
		
			foreach($collection as $key => $qterm) {
				
			$entry = $index['dictionary'][$qterm];
			//echo $qterm . $this->pre($entry);
			if(!empty( $entry)){
				foreach($entry['postings'] as $docID => $posting) {
					$matchDocs[$docID][$qterm] += pow($posting['tf'] *
						log10(($docCount + 1 ) / ($entry['df'])), 2);
						
					$matchDocs[$docID][$qterm.'_q'] += $posting['tf'] *
						log10(($docCount + 1 ) / ($entry['df']));
					//echo $posting['tf'];	 
					// $matchDocs[$docID][$qterm] =  2;
					// $matchDocs[$docID][$qterm.'_q'] = 2;
				}
			}
					
			}
		    //$this->pre($matchDocs);
			$sum = array();
			foreach($query as $term){
            $term = strtolower($term);
				$term = $stemmer->Root($term);
				//$this->pre($term);
				
				$keys = array_keys($matchDocs);
				foreach($keys as $key){

					foreach($matchDocs[$key] as $docs=>$doc){
						if((strtolower($docs))==($term.'_q')){
							$tf = $index['dictionary'][$term]['postings']
							[$key]['tf'];
							$df = 1;
							$k = $vsm->getW($term,$index);
							$match[$term][$key] = ($tf*$doc);				
							$sum[$key]['kkdotDi'] += ($doc*$k[$key]);													
						}
					}
					
				}
			}
			
			//$this->pre($match);
			
			if(count($match)>=1){
				
				$keys = array_keys($matchDocs);

				foreach($keys as $key){
					foreach($matchDocs[$key] as $docs=>$doc){
						
						$text = explode('_',$docs);
						if(empty($text[1])){
							$sum[$key]['sqrtDi'] += $doc;
						}
						
					}
				}
				
				
				
				//keyword
				$keyword = $vsm->getTfidf($queryafter,$index);
				//
				// VSM
				$keyss = array_keys($matchDocs);
				//$this->pre($keyword);
				foreach($keyss as $key){
					$kkdotDi = $sum[$key]['kkdotDi'];
					$sqrtDi = $sum[$key]['sqrtDi'];
					if($kkdotDi!=null){
					//$cos = $kkdotDi/((sqrt($sqrtDi))*($sqrtkk));
						if($vsm->coSim($sqrtDi,$kkdotDi,$keyword)!=0){
							$hasil[$key] = $vsm->coSim($sqrtDi,
							$kkdotDi,$keyword);
						}
					}
				}
				
				

			} else {
				$hasil = null;
			}

			if($hasil!=null){
				arsort($hasil);
				
			}
			
			//$this->pre($sum);
			
			//$this->pre($hasil);
			return array('total' => round((microtime(true)-$start),3) , 'result'=>$hasil);	
	}
	
	function getTfidf($col, $term) {
		
        $index = $this->getIndex($col);
		//$this->pre( $index);
        $docCount = count($index['docCount']);
        $entry = $index['dictionary'][$term];
		//$this->pre( $entry);
		$matchDocs = array();
        foreach($entry['postings'] as  $docID => $posting) {
			$entry['postings'][$docID]['Ddf'] =	($docCount /$entry['df']);  
			$entry['postings'][$docID]['tfidf'] = $entry['postings'][$docID]['tf'] * (log($docCount / $entry['df'],10));
			$matchDocs[$docID] = $entry['postings'][$docID]['tf'] * (log($docCount / $entry['df'],10));
			//$matchDocs[$docID] += $entry['postings'][$docID]['tf'] * (log($docCount / $entry['df'],10));
		
		}
		
		$entry['term'] = $term;
		
		return  $matchDocs;
	}
	
	

	
}