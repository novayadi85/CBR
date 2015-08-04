<?php 
class Search extends BaseController{
	public $data = array();
	
	function __construct(){
		parent::__construct();
		$this->data['layout'] = 'results';
	}
	function index(){
		$start = microtime(true);
		$request = Core::Request();
		//print_r($request);
		if(empty($request['q'])){
			$request['q'] = '';
		}
		$this->data['title'] = "Homepage";
		$term = $request['q'];
		$error = false;
		$terms = explode(' ',$term);
		$e = $this->library('pencarian');
		$problemModel = $this->loadmodel('SearchModel');
		$stemmer = new stemmer();
		if(count($terms) == 1){
			$term = trim($term);
			$problems = $problemModel->query("SELECT * FROM `problems` WHERE `term` = '{$term}' GROUP BY term ORDER BY `problems`.`id_problem` DESC");
			$results = $problems[0];
			$this->data['created'] = $results['created'];		
			//$this->pre($results);
			$this->data['result'] = unserialize($results['result']);
			$this->data['looping'] = unserialize($results['result']);
			$this->data['cache'] = true;
			$results['result'] = $problems;
		} else if(count($terms) > 1){
			$problems = $problemModel->query("SELECT * FROM `problems` GROUP BY term ORDER BY `problems`.`id_problem` DESC");
			$solution = array();
			foreach($problems as $problem){			
				$words = str_replace('.',' ',$problem['term']);
				$words = explode(' ',$words);
				$solution[$problem['id_problem']] = $words;
				$words = '';
			}
			
			$results = $e->gethasil($term,$solution);
			if(!empty($results['result'])){
				$first_key = key($results['result']);
				$persen = ($results['result'][$first_key] * 100);
				if((int)$persen >= 90){
					$problemModel = $this->loadmodel('SearchModel');
					$problemModel->id_problem = $first_key;
					$data = $problemModel->find();
					//$this->pre($problemModel->variables);
					$this->data['created'] = $problemModel->variables['created'];
					$this->data['looping'] = unserialize($problemModel->variables['result']);
					$this->data['result'] = unserialize($problemModel->variables['result']);
					$this->data['cache'] = true;
					$old_problems = $problemModel->query("SELECT * FROM `problems` WHERE `term` = '{$term}' GROUP BY term ORDER BY `problems`.`id_problem` DESC");
					if(empty($old_problems[0])){
						$solution = $this->loadmodel('SearchModel');
						$solution->term = $request['q'];
						$solution->result = $problemModel->variables['result'];
						$solution->created = date("Y-m-d");
						if(count($this->data['result']) >=1){
							$solution->Create();
						}
					}
					
					$error = false;
				} else {
					$error = true;
				}
			} else {
				$error = true;
			}
		
		} else {
			$error = true;
		}
		
		if(!$error && !$this->__valid($this->data['created'])){
			$error = true;
		}
		
		if($error){
			$this->data['cache'] = false;
			$e = $this->library('pencarian');
			$results = $e->gethasil($term);
			if(isset($results['result']) && !empty($results['result'])){
				$this->data['result'] = $results['result'];
				$this->data['total'] =  $results['total'];
				$this->data['request'] =  $request;
				$ids = array_keys($this->data['result']);
				$jurnal = $this->loadmodel('JurnalModel');
				$looping = $jurnal->in(array_values($ids));
				$hasil = array();
				foreach($looping as $key => $value){
					$hasil[$value['id_jurnal']] = $value;
				}
				$this->data['looping'] = $hasil;
				
				$solution = $this->loadmodel('SearchModel');
				$solution->term = $request['q'];
				$solution->result = serialize($hasil);
				$solution->created = date("Y-m-d");
				if(count($results['result']) >=1){
					$solution->Create();
				}
			} else {
				$this->data['total'] =  $results['total'];
				$this->data['request'] =  $request;
				$this->data['looping'] = '';
			}
			
			$this->data['title'] = "Hasil Baru";
		}
		//$this->pre($results);
		$this->data['debug'] =  $results['result'];
		$this->data['total'] = round((microtime(true)-$start),3);
		$this->data['request'] =  $request;
		$this->data['html'] = $this->library('basic');
		$this->view('search/result',$this->data);
			
	}
	private function __valid($date=null)
	{
		$jurnal = $this->loadmodel('JurnalModel');			
		$modified = $jurnal->query("SELECT `modified` FROM `jurnals` ORDER BY `created` ASC");
		$created = $jurnal->query("SELECT `created` FROM `jurnals` ORDER BY `created` ASC");
		// echo ($created[0]['created']);
		// echo '<br>';
		// echo ($date);
		
		if (strtotime($created[0]['created']) > strtotime($date)) {
			//echo 'false';
			return false;
		}
		if (strtotime($modified[0]['modified']) > strtotime($date)) {
			return false;
		}
		return true;
	}
	function index2(){
		$request = Core::Request();
		$this->data['title'] = "Homepage";
		$term = $request['q'];
		$terms = explode(' ',$term);
		$e = $this->library('pencarian');
		$results = $e->gethasil($term);
		if(isset($results['result']) && !empty($results['result'])){
			$this->data['result'] = $results['result'];
			$this->data['total'] =  $results['total'];
			$this->data['request'] =  $request;
			$ids = array_keys($this->data['result']);
			$jurnal = $this->loadmodel('JurnalModel');
			$looping = $jurnal->in(array_values($ids));
			$hasil = array();
			foreach($looping as $key => $value){
				$hasil[$value['id_jurnal']] = $value;
			}
			$this->data['looping'] = $hasil;
			
			$solution = $this->loadmodel('SearchModel');
			$solution->term = $request['q'];
			$solution->result = serialize($hasil);
			$solution->created = date("Y-m-d");
			if(count($results['result']) >=1){
				$solution->Create();
			}
		} else {
			$this->data['total'] =  $results['total'];
			$this->data['request'] =  $request;
			$this->data['looping'] = '';
		}
		
		$this->data['html'] = $this->library('basic');
		$this->view('search/result',$this->data);
	}
	function detail(){
		$request = Core::Request();
		$params =  Core::Request();
		
		$jurnals = $this->loadmodel('SearchModel');
		$data = $jurnals->query("SELECT students.* , jurnals.* from jurnals inner join students ON jurnals.nim = students.nim WHERE jurnals.id_jurnal = '{$params['params']}'");
		//$this->pre($data);
		$this->data['jurnals'] = $data;
		$this->view('search/detail',$this->data);
	}



}