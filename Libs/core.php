<?php

class Core extends Application {

    public $templates;
    private $result;
    public $pages;
    public $error;
    public $breadcrumbs;
    public $polling;
    public $extra;
    public $plugins;
    public $config = array();
    public $admin;

    function __construct() {
        parent::__construct();
        $this->templates = 'templates';
        $this->error = 'Sory, your code not complete!';
    }

}