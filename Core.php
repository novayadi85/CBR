<?php 
Class Core {
	public $path = '/new-cbr/';
	public $base_url = "http://localhost";
	public $layout = "Layout";
	
	public function __construct(){
		if (!defined('DEBUG')) 
			define('DEBUG', false);
		
		
		
		if (!defined('FILE_DIR')) 
			define('FILE_DIR', $_SERVER['DOCUMENT_ROOT'] . DS . $this->path  .DS. 'files' . DS);
		
		if (!defined('BASE_URL'))  
			define('BASE_URL', $this->base_url . $this->path );
		
		if (!defined('FILE_PATH'))  
			define('FILE_PATH', $_SERVER['DOCUMENT_ROOT'] . DS . $this->path . DS . 'Media' . DS);
	}

	function load(){ echo 'test'; }

	function site($layout=null){
		return $this->base_url . $this->path . $this->layout .'/'.$layout.'/';
	}
	
	function site_url(){
		return $this->base_url . $this->path;
	}
	
	function Request($param=null){
	
		if($param != null){
			return $_REQUEST[$param];
		}
		return $_REQUEST;
	}
	
}