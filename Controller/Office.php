<?php 
class Office extends BaseController{

	public $data = array();

	function index(){
		$offices = $this->loadmodel('OfficeModel');
		$this->data['title'] = "Management office";
		$this->data['header'] = 'Office';
		$this->data['offices'] = $offices->all();
		$this->view('office/index',$this->data);
	}
	
	function addnew($data=array()){
		$data['title'] = lang('Add new office');	
		$data['header'] = lang('Add new office');
		$this->view('office/addnew',$data);
	}
	
	function save(){
		$request = Core::Request();
		if(!empty($request)){
			$office = $this->loadmodel('OfficeModel');
			$office->name = $request['name'];
			$office->telp = $request['telp'];
			$office->address = $request['address'];
			if($office->Create()){
				$this->data['msg'] = addSuccess(lang('Your new office has been saved.'));
				$this->index();
			}
		}
		//pre($request);exit;
	}
	
	function delete($post){
		//pre($post);exit;
		$office = $this->loadmodel('OfficeModel');
		$office->id = $post['params'];
		if($office->Delete()){
			$data['msg'] = addSuccess(lang('1 office has been deleted.'));
		} else {
			$data['msg'] = addError(lang('Unsuccess delete this office.'));
		}
		
		$data['title'] = lang('Management office');	
		$data['header'] = lang('Management office');
		$this->data = $data;
		$this->index();
		$office->All();
		$data['office'] = $office->variables;
			
	}
	
	function edit(){
		$params =  Core::Request();
		$office = $this->loadmodel('OfficeModel');
		$office->id = $params['params'];
		$office->Find();
		$data['title'] = lang('Edit office');	
		$data['header'] = lang('Edit new office');
		$data['request'] = $office->variables;
		$this->view('office/edit',$data);
		
	}
	
	function update(){
		$request = Core::Request();
		
		if(!empty($request)){
			//$this->__validusername($request['username']);			
			$office = $this->loadmodel('OfficeModel');
			$office->id = $request['params'];
			$office->name = $request['name'];
			$office->address = $request['address'];
			$office->telp = $request['telp'];
			if($office->Save()){
				$this->data['msg'] = addSuccess(lang('This office has been updated.'));
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