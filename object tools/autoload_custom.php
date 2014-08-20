<?php

function includeWithCase($classname){
    $file="{$classname}.php";
	print "init autoloader...\r\n";
	if (file_exists($file)){
	    require_once($file);
	}
	// well, at least it triggers
	else die ("{$classname} not found!");
}

spl_autoload_register('includeWithCase'); // this function receives
// name strings for all non-included classes called

// now we try to get spl_autoload_register to trigger:
$product=new ShopProduct();



?>