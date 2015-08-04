<?php 
require 'BaseController.php';

class Loader {
	private $controller;
	private $action = 'index';
	private $urlvalues = array('action'=>'index','controller'=>'');
	
	
	//store the URL values on object creation
	public function __construct($urlvalues) {
	
	
		if(!empty($urlvalues))
		$this->urlvalues = $urlvalues;
		
		$this->__Valid();

		if ($this->urlvalues['controller'] == "") {
			$this->controller = "Home";
		} else {
			$this->controller = $this->urlvalues['controller'];
		}

		if ((!isset($this->urlvalues['action']))) {
			$this->action = "index";
		} else {
			$this->action = $this->urlvalues['action'];
		}
		
		
		
	}
	
	protected function __Valid(){
		$session = new Session();
		// if(((!$session->getSession())) && ($this->urlvalues['action'] != 'login')){
			// $this->urlvalues['controller'] = 'user';
			// $this->urlvalues['action'] = 'invalid';
		// } 
	}
	
	//establish the requested controller as an object
	public function CreateController() {
		// echo ucfirst($this->controller).'.php';
		//if(file_exists(ucfirst($this->controller).'.php')){
			require ucfirst($this->controller.'.php');
		// } else {
			// $this->controller = 'Error';
			// $this->action = "index";
			// require ucfirst('Error.php');
		// }
		
		
		//require("person.php");
		if (class_exists($this->controller)) {
			$parents = class_parents($this->controller);
			
			//does the class extend the controller class?
			if (in_array("BaseController",$parents)) {
				//does the class contain the requested method?
				if (method_exists($this->controller,$this->action)) {
					$controller = new $this->controller($this->action,$this->urlvalues);
					$action = $this->action;
					return $controller->$action($this->urlvalues);
				} else {
					//bad method error
					return new Error("badUrl",$this->urlvalues);
					
				}
			} else {
				//bad controller error
				return new Error("badUrl",$this->urlvalues);
			}
		} else {
			//bad controller error
			return new Error("badUrl",$this->urlvalues);
		}
	}
}
?>
