<?php

class Product{
	// some properties or methods
	function __toString(){
	return "Proizvod"; // defines an echoable
				       // value for a given instance
	}
}
$prod1=new Product();
$prod2=new Product();

var_dump($prod1);
echo "<br/>";
echo($prod2); // echoes the object using __toString

 ?>
