<?php 
class Problem extends BaseController{
	public $data = array();
	
	function __construct(){
		parent::__construct();
		$this->data['layout'] = 'adminhtml';
	}
	
	function index(){
		$this->data['title'] = "Data History";
		$this->data['header'] = "Data History";
		$this->data['Model'] =  $this->loadmodel('LecturerModel');
		$problemModel = $this->loadmodel('SearchModel');
		$this->data['problems'] = $problemModel->all();
		$this->view('problems/index',$this->data);
	}
	
	function delete(){
		$params =  Core::Request();
		$problemModel = $this->loadmodel('SearchModel');
		$problemModel->id_problem = $params['params'];
		if($problemModel->Delete()){
			$data['msg'] = addSuccess(lang('1 history has been deleted.'));
		} else {
			$data['msg'] = addError(lang('Unsuccess delete this history.'));
		}		
		$this->index();

			
	}
	function deleteall(){
		$params =  Core::Request();
		$problemModel = $this->loadmodel('SearchModel');
		if($problemModel->query("DELETE FROM `problems`")){
			$data['msg'] = addSuccess(lang('history has been deleted.'));
		} else {
			$data['msg'] = addError(lang('Unsuccess delete this history.'));
		}		
		$this->index();

			
	}
	
}