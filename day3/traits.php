<?php

// all comments for previous additions are left out

class ShopProduct implements Chargeable,IdentityObject{
	private $title;
	private $prodName;
	private $price;
	private $id=0;
	protected $discount=0;
	
	// private $taxRate=22; // new addition
	//
	// instead of above, use a trait
	
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
	// function calculateTax($price){
	// 		return ( ($this->taxRate/100 ) * $price);
	// }
	//
	// instead of above, use a trait
	use PriceUtilities;
	use IdentityTrait; // comment this out in order to see
	// what happens when the interface IdentityObject tied to
	// the trait IdentityTrait is not implemented - BOOM
}


interface Chargeable {
	public function getPrice();
}

// traits change the structure of a class, but not its type
// they can be considered includes for classes



	


// the following class is new
abstract class Service{}

// the following class is also new
// this repetition should be avoided

class UtilityService extends Service{
	/*private $taxRate=22;
	
	function calculateTax($price){
		return ( ($this->taxRate/100 ) * $price);
	}
	*/ // use a trait instead
	use PriceUtilities,IdentityTrait;
	use TaxTools{TaxTools::calculateTax insteadof PriceUtilities;}
	// for opposite effect, interchangeable with 
	// {PriceUtilities::calculateTax insteadof TaxTools;}
	//
	// object::method insteadof overlappingObject[::sameMethodName]
	//
	// without the "insteadof" statement this results in
	/*
	Fatal error: Trait method calculateTax
	has not been applied, because there are
	collisions with other trait methods on UtilityService
	*/
}

// the meat of the traits lesson
trait PriceUtilities{
	private $taxRate=22;
	
	function calculateTax($price){
		return ( ($this->taxRate/100 ) * $price);
	}
}
// however, more than 1 trait can be used, similar to includes
trait IdentityTrait{
	public function generateId(){
		usleep(1);
		// was getting duplicate uids, stackoverflow said
		// it works fine on linux, and that for some reason
		// the windows version does not use execution delaying
		// for seed generation based on microseconds
		//
		// usleep(1) delays execution by 1 microsecond
		// => the ids generated are never the same
		return uniqid();
	}
	public function __toString(){
		return "What the heck";
		// apparently traits can be used for magic function wizardry
	}
}

// in the case of method name conflicts in traits
trait TaxTools{
	function calculateTax($price){
		return "9000";
	}
}


// unfortunately we cannot group classes for their use of traits
// however, interfaces can be made so that they require trait methods

interface IdentityObject{
	public function generateId();
}

// now we can type hint IdentityObject interfaces and KNOW
// that they also implement IdentityTrait

function storeIdentityObject(IdentityObject $idobj){
	return $idobj;
}


// the following works and all subclasses get to use calculateTax()
$p=new ShopProduct();
print $p->calculateTax(100) . "\n" . "{$p->generateId()} \n";
print "<br/>";

// these should work the same thanks to the PriceUtilities trait
$u=new UtilityService();
print $u->calculateTax(100) . "\n" . "{$u->generateId()} \n";

$p=new ShopProduct();
storeIdentityObject($p); // uses a type hinted IdentityTrait


 ?>
