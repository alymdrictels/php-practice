<?php



class ShopProduct{
	private $title;
	private $prodName;
	private $price;
	private $id=0;
	protected $discount=0;

	function __construct($title="Default", $prodName="Default producer",$price=0){
		$this->title=$title; $this->prodName=$prodName;
		$this->price=$price; 
	}
	function getProducer(){
		return "{$this->prodName }";
	}
	function getSummary(){
		$output="{$this->getTitle()} ({$this->getProducer()})";
		return $output;
	}
	public function getTitle(){
		return $this->title;
	}
	public function setId($id){
		$this->id=$id;
	}
	public function setDiscount($discount){
		$this->discount=$discount;
	}
	
	public function getPrice(){
		return ($this->price - $this->discount);
	}

	
	

}

abstract class Service{}



trait PriceUtilities{
	function calculateTax($price){
		return ( ($this->getTaxRate()/100 ) * $price);
	}

	abstract function getTaxRate();
}

class UtilityService extends Service{
	use PriceUtilities{
		PriceUtilities::calculateTax as private;
		// with $u->calculateTax(100) this causes 
		// Fatal error: Call to private method
		// UtilityService::calculateTax() from context
	}
	private $price;
	// change class parametrization to accept price
	function __construct($price){
		$this->price=$price;
	}
	function getTaxRate(){
		return 22;
	}
	function getFinalPrice(){
		return ($this->price+$this->calculateTax($this->price));
	}
	
}


$u=new UtilityService(100);
// getFinalPrice can use calculateTax from within the class
// but the client cannot
print $u->getFinalPrice()."\n";



 ?>
