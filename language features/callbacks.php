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
			call_user_func($callback, $product);
		}
	}
}

class Mailer{
	function doMail($product){
		print "   mailing ()";
	}
}

// now to figure out how to use all of these for
// creating a callback function

// the book used create_function
// and php.net does not reccommend it so I rewrote using this syntax
$logger=function($product){print " logging ({$product->name})\r\n";};


$ps=new ProcessSale(); 

$ps->registerCallback($logger);
// lambda function logger added to callback array

$ps->sale(new Product("Shaving cream", "$30"));
print "\r\n";
$ps->sale(new Product("Panda repellent", "$20"));





 ?>
