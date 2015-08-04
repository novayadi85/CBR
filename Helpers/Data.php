<?php 

function redirect($location=''){
	
}

function pre($var) {
	echo '<pre>';
	print_r($var);
	echo '</pre>';

}

function site($dir){
	return BASE_URL . $dir;
}

function lang($var=''){
	return $var;
}

function __($var=''){
	return $var;
}

function addError($msg=''){
	$html[] = '<div class="alert alert-danger alert-dismissable">';
    $html[] = '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
    $html[] = $msg;
    $html[] = '</div>';
	
	return join($html);

}

function addSuccess($msg=''){
	$html[] = '<div class="alert alert-success alert-dismissable">';
    $html[] = '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
    $html[] = $msg;
    $html[] = '</div>';
	return join($html);

}


function object2Array($d) { 
	if (is_object($d)) { $d = get_object_vars($d); } 
	 
	if (is_array($d)) { 
		return array_map(__FUNCTION__, $d); 
	} else { 
		return $d; 
	} 
 
 } 
 
 function array2Object($d) {
 
	if (is_array($d)) { 
		return (object) array_map(__FUNCTION__, $d); 
	} else { 
		return $d; 
	} 
 
 } 