<?php 
class Report extends BaseController{

	public $data = array();

	function index(){	
		$this->view('report/index',$this->data);
	}
	
}