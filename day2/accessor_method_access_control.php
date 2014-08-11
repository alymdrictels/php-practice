<?php

class ShopProduct{
	private $title; // set to private
	private $prodName;
	protected $price; // we want to allow the discount to be overridden
	private $discount;
	
	// constructor / setter method
	function __construct($title, $prodName,$price){
		$this->title=$title; $this->prodName=$prodName;
		$this->price=$price; 
	}
	
	// getter methods
	public function getProducer(){
		return $this->prodName;
	}
	public function getDiscount(){
		return $this->discount;
	}
	public function getTitle(){
		return $this->title;
	}
	public function getPrice(){
		return $this->price;
	}
	// getter methods area accessed instead of the properties directly
	function getSummary(){
		$output="{$this->getTitle} ({$this->getProdName})";
		return $output;
	}
}

class ShopProductWriter{
	private $products=array();
	// object type enforcement / hinting
	public function addProduct(ShopProduct $shopProduct){	
		$this->products[]=$shopProduct;
	}
	public function write(){
		$output=""; // initialize printable string to empty
		foreach ($this->products as $shopProduct){
		// instead of accessing the properties,
		// we access the getter methods
			$output.="{$shopProduct->getTitle()}: ";
			$output.="{$shopProduct->getProducer()}, ";
			$output.="{$shopProduct->getPrice()} <br/>";
		}
		print $output;
	}
	
}



$product1=new ShopProduct("Plastic horse", "Toys Inc.", "$100 bln.");
$product2=new ShopProduct("Buzz Lightyear coloring book", "Andy's sketchbooks", "$10 mln.");

$shopProductWriter=new shopProductWriter();

$shopProductWriter->addProduct($product1);
$shopProductWriter->addProduct($product2);
$shopProductWriter->write();
 
 
 ?>
