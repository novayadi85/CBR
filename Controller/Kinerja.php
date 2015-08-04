<?php 
class Kinerja extends BaseController{

	public $data = array();

	function index(){
		$kinerjas = $this->loadmodel('KinerjaModel');
		$this->data['title'] = "Kinerja";
		$this->data['header'] = 'Kinerja';
		$this->data['kinerjas'] = $kinerjas->all();
		$this->view('kinerja/index',$this->data);
	}
	
	function addnew($data=array()){
		$data['title'] = lang('Add new kinerja');	
		$data['header'] = lang('Add new kinerja');
		$this->view('kinerja/addnew',$data);
	}
	
	function save(){
		$request = Core::Request();
		if(!empty($request)){
			$kinerja = $this->loadmodel('KinerjaModel');
			$kinerja->name = $request['name'];
			$kinerja->telp = $request['telp'];
			$kinerja->address = $request['address'];
			if($kinerja->Create()){
				$this->data['msg'] = addSuccess(lang('Your new kinerja has been saved.'));
				$this->index();
			}
		}
		//pre($request);exit;
	}
	
	function delete($post){
		//pre($post);exit;
		$kinerja = $this->loadmodel('KinerjaModel');
		$kinerja->id = $post['params'];
		if($kinerja->Delete()){
			$data['msg'] = addSuccess(lang('1 kinerja has been deleted.'));
		} else {
			$data['msg'] = addError(lang('Unsuccess delete this kinerja.'));
		}
		
		$data['title'] = lang('Management kinerja');	
		$data['header'] = lang('Management kinerja');
		$this->data = $data;
		$this->index();
		$kinerja->All();
		$data['kinerja'] = $kinerja->variables;
			
	}
	
	function edit(){
		$params =  Core::Request();
		$kinerja = $this->loadmodel('OfficeModel');
		$kinerja->id = $params['params'];
		$kinerja->Find();
		$data['title'] = lang('Edit kinerja');	
		$data['header'] = lang('Edit new kinerja');
		$data['request'] = $kinerja->variables;
		$this->view('kinerja/edit',$data);
		
	}
	
	function update(){
		$request = Core::Request();
		
		if(!empty($request)){
			//$this->__validusername($request['username']);			
			$kinerja = $this->loadmodel('OfficeModel');
			$kinerja->id = $request['params'];
			$kinerja->name = $request['name'];
			$kinerja->address = $request['address'];
			$kinerja->telp = $request['telp'];
			if($kinerja->Save()){
				$this->data['msg'] = addSuccess(lang('This kinerja has been updated.'));
				$this->index();
			}

		}
		//pre($request);exit;
	}
	
	private function __validusername($username){
		$office = $this->loadmodel('OfficeModel');
		$office->username = $username;
		$office->Find();
		
		if($office->variables){
			return false;
		} 
		
		return true;
	}
}