<?php 
session_start();

class Session {

	public $session;
	
	function __construct(){
		$this->session = $_SESSION;		
		
	}
	function getSession($var = 'loggedIn'){
		if(isset($_SESSION[$var])){
			return $this->session[$var];
		} else {
			return false;
		}
	}
}