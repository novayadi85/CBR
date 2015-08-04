<?php 
	function __autoload($class_name) {
	$path = 'Sinov_Framework';
	// if(file_exists($path . '/Classes/' . $class_name . '.php')) {
		
        // require_once($path . '/Classes/' . $class_name . '.php');

		// if(method_exists($class_name,'init')) {
			// call_user_func(array($class_name,'init'));
		// }

    // }

	$models = 'Models';
	$controllers = 'Controllers';

	if(file_exists($controllers . DS . ucfirst($class_name) . '.php')) {
		
        require_once($controllers . DS .ucfirst($class_name) . '.php');
		if(method_exists($class_name,'init')) {
			call_user_func(array($class_name,'init'));
		}

    }
	
    if(file_exists($models . DS . $class_name . '_Model.php')) {
		
        require_once($models . DS .$class_name . '_Model.php');
		if(method_exists($class_name,'init')) {
			call_user_func(array($class_name,'init'));
		}

    } else {
        //throw new Exception("Unable to load $class_name.");
		return false;
    }
}
 
