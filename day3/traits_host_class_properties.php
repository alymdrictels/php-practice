<?php

// an example of BAD design - you should enforce certain properties
// for your classes

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
	public static function getInstance($id, PDO $pdo){
		$statement=$pdo->prepare("SELECT * FROM products WHERE id=?;");
		$result=$statement->execute(array($id));
		$row=$statement->fetch();
		if (empty($row)) { return null;}
		if ($row['type']=="toy"){
			$product=new ToyProduct(
								$row['title'],
								$row['prodname'],
								$row['price'],
								$row['appropriateages']
			);
		}else if ($row['type']=="sketchbook"){
			$product=new SketchBookProduct(
								$row['title'],
								$row['prodname'],
								$row['price'],
								$row['numpages']
			); 
		} else {
			$product=new ShopProduct(
								$row['title'],
								$row['prodname'],
								$row['price']
			);
		}			
		$product->setId(		$row['id']);
		$product->setDiscount(	$row['discount']);
		return $product;
		
	}
	public function getPrice(){
		return ($this->price - $this->discount);
	}

	use PriceUtilities;
	

}


abstract class Service{}


class UtilityService extends Service{
	public $taxRate=22;
	use PriceUtilities;
}

trait PriceUtilities{
	function calculateTax($price){
		return ( ($this->taxRate/100 ) * $price);
	
	}
}



$u=new UtilityService();
print $u->calculateTax(100)."\n";
 


 ?>
