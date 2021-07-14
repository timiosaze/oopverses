<?php 

function autoload($class_name){
	$the_path = "app/" . strtolower($class_name) . ".php";
	if(file_exists($the_path)){
		require $the_path;
	}
}

spl_autoload_register('autoload');


 ?>