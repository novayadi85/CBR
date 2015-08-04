<?php
	ini_set('display_errors',1);
	ini_set('memory_limit','1032M');
	require("Core.php");
	require("Helpers/Data.php");
	require("Classes/Session.php");
	require("Classes/ProfileMatching.php");
	require("Log.class.php");	
	require("PDO.class.php");
	require_once("Classes/CRUD.php");
	require("Classes/View.class.php");
	require_once("Controller/Loader.php");
	
	$db = new Db();
	//$session = new Session();
	// Require the person class file
   
	require("Classes/Sinov.class.php");
	$loader = new Loader($_GET);
	$controller = $loader->CreateController();
?>
