<?php 
class Admin extends BaseController{

	function index(){
		$data['title'] = "Backend";
		$data['layout'] = 'adminhtml';
		$this->view('admin/index',$data);
	}
	
}