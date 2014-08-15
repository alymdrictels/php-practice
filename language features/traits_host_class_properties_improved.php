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

class UtilityService extends Service{
	use PriceUtilities;
	function getTaxRate(){
		return 22;
	}
	
}

// getTaxRate() is called, it is implemented for sure because
// it is set as abstract
trait PriceUtilities{
	function calculateTax($price){
		return ( ($this->getTaxRate()/100 ) * $price);
	}
	// first we require getTaxRate, then implement it in the class
	// that requires it
	abstract function getTaxRate();
}



$u=new UtilityService();
print $u->calculateTax(100)."\n";
 


 ?>
