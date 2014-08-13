<?php

interface IProduct{
	function apples();
	function oranges();
}

class fruitStore implements IProduct{
	public function apples(){
		return "We have apples";
	}
	
	public function oranges(){
		return "We do not sell oranges";
	}
}
class citrusStore implements IProduct{
	public function apples(){
		return "We do not sell apples";
	}
	public function oranges(){
		return "We have oranges";
	}
}

class UseProducts{
	public function __construct(){
		$fruitStore=new fruitStore();
		$citrusStore=new citrusStore();
		$this->doInterface($fruitStore);
		$this->doInterface($citrusStore);
	}
	function doInterface(IProduct $product){
		print $product->apples();
		print $product->oranges();
	}
}

// after all that boilerplate code, we print 16 words
// again, interfaces are used to enforce data types
// no primitives, only arrays, objects and classes

$worker=new UseProducts();

 ?>
