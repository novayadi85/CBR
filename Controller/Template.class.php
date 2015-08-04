<?php
class Template {
    protected $file;
    protected $values = array();
	public $title = 'Title Page';
	public $header  = 'Header Page';

	public $layout = 'frontend';
  
    public function __construct($file) {
        $this->file = $file;
    }

	public function set($key, $value) {
    $this->values[$key] = $value;
	}
	  
	public function output2() {
		if (!file_exists($this->file)) {
			 return "Error loading template file ($this->file).";
		}
		$output = file_get_contents($this->file);
	  
		foreach ($this->values as $key => $value) {
			$tagToReplace = "[@$key]";
			$output = str_replace($tagToReplace, $value, $output);
		}
	  
		return $output;
	}

	public function render($output){
		$Core = new Core();
		$this->dir = $_SERVER['DOCUMENT_ROOT'] . DS . $Core->path;
		
		//print_r($this->values);
		if(isset($this->values['layout'])) $this->layout = $this->values['layout'];
		$base_url = $Core->site($this->layout) ;
		$site_url = $Core->site_url();
		$title = (isset($this->values['title'])) ? $this->values['title']: $this->title;
		$header = (isset($this->values['header'])) ? $this->values['header']: $this->header;
		$content = $output;
		include ($this->dir .DS. 'Layout'.DS.$this->layout.DS.'default.phtml');
	}

	public function output() {
		//echo $this->file;
		if (!file_exists($this->file)) {
			 return "Error loading template file ($this->file).";
		}		

		foreach($this->values as $k => $v) {
			$$k = $v;
		}

		ob_start();		
		include($this->file);
		$str = ob_get_contents();
		ob_end_clean();
		return $str;
	}
}
?>