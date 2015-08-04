<?php 
class Criteria extends BaseController{

	public $data = array();

	function index(){
		$criterias = $this->loadmodel('CriteriaModel');
		$this->data['title'] = "Aspek";
		$this->data['header'] = 'Aspek';
		$this->data['criterias'] = $criterias->all();
		$this->view('criteria/index',$this->data);
	}
	
	function addnew($data=array()){
		$data['title'] = lang('Tambah Aspek');	
		$data['header'] = lang('Tambah Aspek');
		$this->view('criteria/addnew',$data);
	}
	
	function save(){
		$request = Core::Request();
		if(!empty($request)){
			$criteria = $this->loadmodel('criteriaModel');
			$criteria->criteria = $request['criteria'];
			$criteria->persentase = $request['persentase'];
			$criteria->ncf = $request['ncf'];
			$criteria->nsf = $request['nsf'];
			if($criteria->Create()){
				$this->data['msg'] = addSuccess(lang('Your new criteria has been saved.'));
				$this->index();
			}
		}
		//pre($request);exit;
	}
	
	function delete($post){
		//pre($post);exit;
		$criteria = $this->loadmodel('CriteriaModel');
		$criteria->id = $post['params'];
		if($criteria->Delete()){
			$data['msg'] = addSuccess(lang('1 criteria has been deleted.'));
		} else {
			$data['msg'] = addError(lang('Unsuccess delete this criteria.'));
		}
		
		$data['title'] = lang('Management criteria');	
		$data['header'] = lang('Management criteria');
		$this->data = $data;
		$this->index();
		$criteria->All();
		$data['criteria'] = $criteria->variables;
			
	}
	
	function edit(){
		$params =  Core::Request();
		$criteria = $this->loadmodel('CriteriaModel');
		$criteria->id = $params['params'];
		$criteria->Find();
		$data['title'] = lang('Edit Aspek');	
		$data['header'] = lang('Edit Aspek');
		$data['request'] = $criteria->variables;
		$this->view('criteria/edit',$data);
		
	}
	
	function update(){
		$request = Core::Request();
		
		if(!empty($request)){
			//$this->__validusername($request['username']);			
			$criteria = $this->loadmodel('CriteriaModel');
			$criteria->id = $request['params'];
			$criteria->criteria = $request['criteria'];
			$criteria->persentase = $request['persentase'];
			$criteria->ncf = $request['ncf'];
			$criteria->nsf = $request['nsf'];
			if($criteria->Save()){
				$this->data['msg'] = addSuccess(lang('This criteria has been updated.'));
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