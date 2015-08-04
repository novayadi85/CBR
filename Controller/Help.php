<?php 
class Help extends BaseController{

	function index(){
		// $users = array(
			// array("username" => "monk3y", "location" => "Portugal"),
			// array("username" => "Sailor", "location" => "Moon"),
			// array("username" => "Treix!", "location" => "Caribbean Islands"),
			// array("username" => "KOmang!", "location" => "Caribbean Islands")
		// );
		$data['title'] = "Help";
		$this->view('help/index',$data);
	}

}