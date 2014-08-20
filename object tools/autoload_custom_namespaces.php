<?php

function myNamespaceAutoload($path){
	
    if (preg_match('/\\\\/',$path)){
		$path=str_replace('\\',DIRECTORY_SEPARATOR, $path);
	}
	// print $path;
	if (file_exists("{$path}.php")){
	
		require_once("{$path}.php");
	} else die ("{$path}.php not found!");
}
spl_autoload_register('myNamespaceAutoload');
// if I were to add spl_autoload_register('myUnderscoreAutoload')
// it would try the first one, then the second one if it failed

// there's an overhead to stacking autoloads

$dino=new util\Dinosaur();
$dino->rawr();
?>