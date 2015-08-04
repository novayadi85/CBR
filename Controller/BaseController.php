<?php 

include("Template.class.php");
	
class BaseController {
	
	public $data;
	public $dir;
	public $theme = 'admin';
	public $output;
	private $model ='BaseModel';
	// public $layout = 'admin';
	
	function pre($var=array()){
		echo '<pre>';
		print_r($var);
		echo '</pre>';
	}
	
	public function __construct(){
		$Core = new Core();
		$this->dir = $_SERVER['DOCUMENT_ROOT'] . DS . $Core->path;		
		$layout = new Template($this->dir.DS."layout.tpl");
		$layout->set("title", "TA NOVI");
		$this->loadmodel($this->model);
		//$this->loadmodel($this->model);
		$this->output =   $layout->output();

	}

	public function view($file,$data=array()){
		
		$view = ($this->dir .DS.'Views'.DS.$file . '.phtml');
		$profile = new Template($view);
		
		foreach($data as $key => $assign){
			$profile->set($key, $assign);
		}
					
		//$layout = new Template($this->dir .DS."layout".DS."layout.phtml");
		//$layout->set("content", $profile->output());
		
		echo $profile->render($profile->output());

		// return $view->render();
		
	}

	public function load($file){
		
		if(file_exists($this->dir .DS. $file.'.phtml')){
			include ($this->dir .DS. $file.'.phtml');
		}
	}
	
	public function library($file){
		
		if(file_exists($this->dir .DS. 'Libs' .DS . $file.'.php')){
			include_once ($this->dir .DS. 'Libs' .DS . $file.'.php');
			return new $file;
		}
	}
	
	public function loadmodel($file){
		
		if(file_exists($this->dir .DS. 'Models' .DS . $file.'.php')){
			include_once ($this->dir .DS. 'Models' .DS . $file.'.php');
			return new $file;
		}
	}

	public function helper($file){
		
		if(file_exists($this->dir .DS. 'Helpers' .DS . $file.'.php')){
			include_once ($this->dir .DS. 'Helpers' .DS . $file.'.php');
		}
	}

	public function element($file){
		$this->load('Views'.DS.$file);
	}

}