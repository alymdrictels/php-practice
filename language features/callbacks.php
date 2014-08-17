<?php

class Product{
	public $name;
	public $price;
	
	function __construct($name,$price){
		$this->name=$name;
		$this->price=$price;
	}
}

class ProcessSale{
	private $callbacks;
	
	function registerCallback($callback){
		if (!is_callable($callback)){
			throw new Exception("callback not callable");
		}
		$this->callbacks[]=$callback;
	}
	function sale($product){
		print "{$product->name}: processing \r\n";
		foreach ($this->callbacks as $callback){
			print (call_user_func($callback, $product));
		}
	}
}

class Mailer{
	function doMail($product){
		return "   mailing ({$product->name})\r\n";
	}
}

// now to figure out how to use all of these for
// creating a callback function

// the book used create_function
// and php.net does not reccommend it so I rewrote using this syntax
$logger=function($product){return "   logging ({$product->name})\r\n";};


$ps=new ProcessSale(); 
print "<pre>";
$ps->registerCallback($logger); // add normal callback
$ps->registerCallback(array(new Mailer(),"doMail")); // add method callback
// callback = array (new Class(), "methodname")

$ps->sale(new Product("Shaving cream", "$30"));
print "\r\n";
$ps->sale(new Product("Panda repellent", "$20"));


print "</pre>";

 ?>
