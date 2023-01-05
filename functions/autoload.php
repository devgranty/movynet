<?php

# Lets autoload our classes using the autoload function.
function autoload($classname){
	$classArray = explode('\\', $classname);
	$class = array_pop($classArray);
	$dirname = strtolower(implode('/', $classArray));
	$path = __DIR__.'/../'.$dirname.'/'.$class.'.php';
	if(file_exists($path)){
		require_once $path;
	}
}

spl_autoload_register('autoload');
