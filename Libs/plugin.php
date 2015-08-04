<?php

class Plugin extends Application {

    public $name;
    public $enable = 1;
    public $description;
    public $version;
    public $author;
    public $html;
    public $hook;
    
    function __setFile($param){
         $this->hook = 'Hook'.$param;
    }
    
    function __get($param){
         $this->__setFile($param);
         return $this->hook;
    }
    
   

}

?>
