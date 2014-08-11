<?php

class ShopProduct{
	public $title;
	public $prodName;
	public $price;
	
	function __construct($title, $prodName,$price){
		$this->title=$title; $this->prodName=$prodName;
		$this->price=$price; 
	}
	
	function getProducer(){
		return "{$this->prodName }";
	}
	
	// function in common with the two child classes
	function getSummary(){
		$output="{$this->title} ({$this->prodName})";
		return $output;
	}
}

class ToyProduct extends ShopProduct{
	public $appropriateAges;
	function __construct($title,$prodName,$price, $appropriateAges){
		// when you invoke a constructor in a child class
		// you become responsible for the parent constructor as well
		parent::__construct($title, $prodName,$price); // puts these defaults into the parent constructor
		$this->appropriateAges=$appropriateAges; // sets the child property
		}
		// child-specific getter function, not used
	function getApproproateAges(){
		return $this->appropriateAges;
	}
		// overridden parent method
	function getSummary(){
		// instead of repeating stuff present in the
		// parent method, we can invoke it
		// so, instead of:
		// $output="{$this->title} ({$this->prodName}), ages {$this->appropriateAges}";
		// we can write:
		$output=parent::getSummary();
		$output.=", ages {$this->appropriateAges}";
		return $output;
	}
	
}

class SketchBookProduct extends ShopProduct{
	public $numPages;
	function __construct($title, $prodName, $price, $numPages){
		parent::__construct($title, $prodName, $price);
		$this->numPages=$numPages;
	}
	// child-specific getter function, not used
	function getNumPages(){
		return $this->numPages;
	}
	// overridden parent method
	function getSummary(){
		// instead of repeating stuff present in the
		// parent method, we can invoke it
		// so, instead of:
		// $output="{$this->title} ({$this->prodName}), total of {$this->numPages} pages";
		// we can write:
		$output=parent::getSummary();
		$output.=", total of {$this->numPages} pages";
		return $output;
	}
}

$product1=new ToyProduct("Plastic horse", "Toys Inc.", "$100 bln.", "0-2");
$product2=new SketchBookProduct("Buzz Lightyear coloring book", "Andy's sketchbooks", "$10 mln.", "25");

print $product1->getSummary() . "<br/>";
print $product2->getSummary();
// here, ShopProduct is a generic class, never instantiated
// the above getSummary functions are polymorphic via method overriding
// returns:
//
// Plastic horse (Toys Inc.), ages 0-2
// Buzz Lightyear coloring book (Andy's sketchbooks), total of 25 pages
 
 
 
 
 ?>
