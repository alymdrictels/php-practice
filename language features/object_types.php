<?php

class ShopProduct{
	public $title;
	public $producerName;
	public $price;
	
	function __construct(
		$title="Product",
		$prodname="Producer",
		$price=0
		){
		$this->title=$title; $this->producerName=$prodname;
		$this->price=$price; 
	}
	
	function getProducer(){
		return "{$this->producerName }";
	}
}

// ShopProduct instantiation
// 
// product1=new ShopProduct("Plastic horse", "Toys Inc.", "$100 bln.");
// print "Producer name: {$product1->getProducer()}";

// separation of responsibilities =>
// the following class only writes
class WrongClass{}
class ShopProductWriter{
	public function write(ShopProduct $shopProduct=null){
	// null object defaults are a feature from php 5.1
		$output=
		"{$shopProduct->title}" .
		" {$shopProduct->getProducer()}" .
		" {$shopProduct->price}";
		print $output;
	}
}


// init product manager
$product1=new ShopProduct("Plastic horse", "Toys Inc.", "$100 bln.");
// init product writer
$writer=new ShopProductWriter();
$writer->write($product1);

// however:
// 		$writer->write(new WrongClass() );
/* returns:
Catchable fatal error: Argument 1 passed to ShopProductWriter::write()
must be an instance of ShopProduct, instance of WrongClass given

due to automated type checking. however, this only happens at runtime
also, type hinting can not be used for enforcing primitives in arguments
however, you CAN enforce array arguments (type hinting is a php 5.1 feature)
	function setArray(array $storearray){
		$this->array=$storearray;
	}
*/
 ?>
