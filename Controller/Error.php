<?php 

class Error extends BaseController{
	
	function index(){
		$data['title'] = "Error";
		$data['layout'] = 'error';
		$this->view('error/index',$data);
	}
}