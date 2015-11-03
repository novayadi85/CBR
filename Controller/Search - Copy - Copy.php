<?php 
class Search extends BaseController{
	public $data = array();
	
	function __construct(){
		parent::__construct();
		$this->data['layout'] = 'results';
	}
	
	function ajax(){		
		$this->data['layout'] = 'ajax';
		$this->cari();
		$this->view('search/result',$this->data);
	}
	
	function cari(){
		$start = microtime(true);
		$request = Core::Request();
		print_r($request);
		if(empty($request['q'])){
			$request['q'] = '';
		}
		$this->data['title'] = "Homepage";
		$term = $request['q'];
		
		$tahun = $request['tahun'];
		$jenis = $request['jenis'];
		//$dosen = $request['lecturer_ids'];
		$lecturer_ids = $request['dosen'];
		
		$aSql = '';
		
		if($tahun){
			$aSql .= " AND `tahun` = $tahun ";			
		}
		if($lecturer_ids){
			$aSql .= " AND `lecturer_ids` LIKE '%{$lecturer_ids}%' ";			
		}
		if($jenis){
			$aSql .= " AND `jenis` = '{$jenis}' ";			
		}
		
		$error = false;
		$terms = explode(' ',$term);
		$e = $this->library('pencarian');
		$problemModel = $this->loadmodel('SearchModel');
		$stemmer = new stemmer();
		if(count($terms) == 1){
			$term = trim($term);
			$problems = $problemModel->query("SELECT * FROM `problems` WHERE `term` = '{$term}' $aSql GROUP BY term ORDER BY `problems`.`id_problem` DESC");
			$results = $problems[0];
			$this->data['created'] = $results['created'];		
			$this->data['result'] = unserialize($results['result']);
			$this->data['looping'] = unserialize($results['result']);
			$this->data['cache'] = true;
			$results['result'] = $problems;
		} else if(count($terms) > 1){			
			$od_problems = $problemModel->query("SELECT * FROM `problems` WHERE `term` = '{$term}' $aSql GROUP BY term ORDER BY `problems`.`id_problem` DESC");
			$results = $od_problems[0];
			$this->data['created'] = $results['created'];		
			//echo 'tes';$this->pre($results);
			$this->data['result'] = unserialize($results['result']);
			$this->data['looping'] = unserialize($results['result']);
			$this->data['cache'] = true;
			$results['result'] = $od_problems;
			
			if(empty($results['result'])){
				$old = false;
				$problems = $problemModel->query("SELECT * FROM `problems` GROUP BY term ORDER BY `problems`.`id_problem` DESC");
				$solution = array();
				foreach($problems as $problem){			
					$words = str_replace('.',' ',$problem['term']);
					$words = explode(' ',$words);
					$solution[$problem['id_problem']] = $words;
					$words = '';
				}
				
				$results = $e->gethasil($term,$solution);
				//echo 'testt';
			} else {
				$old = true;
			}
			// echo '<pre>';
			// print_r($results);
			// echo '</pre>';
			
			if(!$old && !empty($results['result'])){
				
				$first_key = key($results['result']);
				//echo $persen = ($results['result'][$first_key] * 100);
				if((int)$persen >= 90){
					$problemModel = $this->loadmodel('SearchModel');
					$problemModel->id_problem = $first_key;
					$data = $problemModel->find();
					//$this->pre($problemModel->variables);
					$this->data['created'] = $problemModel->variables['created'];
					$this->data['looping'] = unserialize($problemModel->variables['result']);
					$this->data['result'] = unserialize($problemModel->variables['result']);
					$this->data['cache'] = true;
					$old_problems = $problemModel->query("SELECT * FROM `problems` WHERE `term` = '{$term}' $aSql GROUP BY term ORDER BY `problems`.`id_problem` DESC");
					
					//$this->pre($this->data);
					
					if(empty($old_problems[0])){
						$solution = $this->loadmodel('SearchModel');
						$solution->term = $request['q'];
						$solution->result = $problemModel->variables['result'];
						$solution->created = date("Y-m-d");
						$solution->tahun = $request['tahun'];
						$solution->lecturer_ids  = $request['dosen'];
						$solution->jenis  = $request['jenis'];
						if(count($this->data['result']) >=1){
							// $solution->Create();
						}
					}
					
					$error = false;
				} else {
					$error = true;
				}
			} else {
				$error = false;
				
			}
		
		} else {
			$error = true;
		}
		
		if(!$error && !$this->__valid($this->data['created'])){
			$error = true;
		}
		
		if($error && !$old){
			
			$this->data['cache'] = false;
			$e = $this->library('pencarian');
			$results = $e->gethasil($term);
	
			if(isset($results['result']) && !empty($results['result'])){
				$this->data['result'] = $results['result'];
				$this->data['total'] =  $results['total'];
				$this->data['request'] =  $request;
				$ids = array_keys($this->data['result']);
				
				$jurnal = $this->loadmodel('JurnalModel');
				$looping = $jurnal->IN(array_values($ids),'nim');
				$hasil = array();
				foreach($looping as $key => $value){
					$hasil[$value['nim']] = $value;
				}
				$this->data['looping'] = $hasil;
				
				$solution = $this->loadmodel('SearchModel');
				$solution->term = $request['q'];
				$solution->result = serialize($hasil);
				$solution->tahun = $request['tahun'];
				$solution->lecturer_ids  = $request['dosen'];
				$solution->jenis  = $request['jenis'];
				$solution->created = date("Y-m-d");
				if(count($results['result']) >=1){
					//$solution->Create();
				}
			} else {
				$this->data['total'] =  $results['total'];
				$this->data['request'] =  $request;
				$this->data['looping'] = '';
			}
			
			$this->data['title'] = "Hasil Baru";
		}
		
		if($this->data['cache']){
			$ids = $results['result'][0]['id_problem'];
			$problemModel->query("UPDATE problems SET `count` = `count`+1 WHERE `id_problem` = $ids");
			
		}
		
		$this->data['debug'] =  $results['result'];
		$this->data['total'] = round((microtime(true)-$start),3);
		$this->data['request'] =  $request;
		$this->data['html'] = $this->library('basic');
		$lecturer = $this->loadmodel('LecturerModel');
		$this->data['lecturer'] =  $lecturer->all();
	}
	
	function paging($input, $page, $show_per_page) {
		$start = ($page-1) * $show_per_page;
		$end = $start + $show_per_page;
		$count = count($input);
		$newData = array();
		$pageData = array();
		// Conditionally return results
		if ($start < 0 || $count <= $start)
			// Page is out of range
			return array(); 
		else if ($count <= $end) 
			// Partially-filled page
			$newData = array_slice($input, $start);
		else
			// Full page 
		$newData = array_slice($input, $start, $end - $start);
		foreach($newData as $k => $v){
			$pageData[$v['nim']] = $v;
		}
		return $pageData;
	}
	
	
	function index(){
		$request = Core::Request();
		if(!isset($request['page'])){
			$p = 1;
		} else {
			$p = $request['page'];
		}
		$this->cari();
		//$this->pre($this->data);
		$this->data['result'] = $this->paging($this->data['result'],$p,2);
		
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
			$solution->tahun = $request['tahun'];
			$solution->lecturer_ids  = $request['dosen'];
			$solution->jenis  = $request['jenis'];
			$solution->result = serialize($hasil);
			$solution->created = date("Y-m-d");
			
			
			
			if(count($results['result']) >=1){
				// $solution->Create();
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
		$this->data['layout'] = 'modal';
		$request = Core::Request();
		$params =  Core::Request();
		
		$jurnals = $this->loadmodel('SearchModel');
		$data = $jurnals->query("SELECT students.* , jurnals.* from jurnals inner join students ON jurnals.nim = students.nim WHERE jurnals.id_jurnal = '{$params['params']}'");
		//$this->pre($data);
		$this->data['jurnals'] = $data;
		$this->view('search/detail',$this->data);
	}



}