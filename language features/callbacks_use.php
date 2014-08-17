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
class Totalizer{
	static function warnAmount($amt){
		$count=0;
		// $count will persist in all calls
		return function ($product) use ($amt, &$count){
			$count+=$product->price;
			print "   count: $count\r\n";
			if ($count>$amt){
				print "   high price reached: {$count}\r\n";
			
			}
			
		};
	}
}


$ps=new ProcessSale(); 
print "<pre>";

$ps->registerCallback(Totalizer::warnAmount(8));
 // static callback reference

 $ps->sale(new Product("Shaving cream", 5));
print "\r\n";
$ps->sale(new Product("Panda repellent", 9));
/* output:

Shaving cream: processing 
   count: 5

Panda repellent: processing 
   count: 14
   high price reached: 14

*/


print "</pre>";

 ?>
