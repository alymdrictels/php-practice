<?php

// all comments for previous additions are left out

class ShopProduct implements Chargeable,IdentityObject{
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
	use IdentityTrait;

}


interface Chargeable {
	public function getPrice();
}


abstract class Service{}


class UtilityService extends Service{

	use PriceUtilities,IdentityTrait;
	use TaxTools{
	TaxTools::calculateTax insteadof PriceUtilities;
	// aliasing of overridden trait method
	//
	// object::overriddenMethod as [object]::methodAlias
	PriceUtilities::calculateTax as basicTax;
	}
	// a conflicting trait method must first be overridden,
	// then it can be aliased
	// non-conflicting trait methods can be aliased, of course

}

trait PriceUtilities{
	static $taxRate=22; // added static
	
	static function calculateTax($price){ // added static
		return ( (self::$taxRate/100 ) * $price);
	// $this-> replaced with self::$
	// do not forget the "$" sign
	}
}
trait IdentityTrait{
	public function generateId(){
		usleep(1);
	
		return uniqid();
	}
	public function __toString(){
		return "What the heck";
	}
}
trait TaxTools{
	function calculateTax($price){
		return "9000";
	}
}

interface IdentityObject{
	public function generateId();
}

function storeIdentityObject(IdentityObject $idobj){
	return $idobj;
}


print UtilityService::basicTax(100) . "\n";

 


 ?>
