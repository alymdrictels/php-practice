<?php



class ShopProduct{
	private $title;
	private $prodName;
	private $price;
	private $id=0;
	protected $discount=0;
	
	function __construct($title, $prodName,$price){
		$this->title=$title; $this->prodName=$prodName;
		$this->price=$price; 
	}
	
	// getter methods
	function getProducer(){
		return "{$this->prodName }";
	}
	
	// function in common with the two child classes
	function getSummary(){
		$output="{$this->getTitle()} ({$this->getProducer()})";
		return $output;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	// setter methods
	public function setId($id){
		$this->id=$id;
	}
	public function setDiscount($discount){
		$this->discount=$discount;
	}
	// PDO utilizing static function
	public static function getInstance($id, PDO $pdo){
	
		// PDO operations
		$statement=$pdo->prepare("SELECT * FROM products WHERE id=?;");
		$result=$statement->execute(array($id));
		$row=$statement->fetch();
		// print_r ($row); for debugging
		
		// saving output to instances
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
		} else { // generic ShopProduct, type not set
			$product=new ShopProduct(
								$row['title'],
								$row['prodname'],
								$row['price']
			);
		}			// below are properties common to ALL instances
		$product->setId(		$row['id']);
		$product->setDiscount(	$row['discount']);
		return $product;
		
	}
	
	abstract class 
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
	function getAppropriateAges(){
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
		$output.=", ages {$this->getAppropriateAges()}";
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
		$output.=", total of {$this->getNumPages()} pages";
		return $output;
	}
}

// might as well learn PDO now

// the first argument is the DSN (pdo configuration),
// then comes username, password (and options, if needed)
$db = new PDO(
 'mysql:host=localhost;dbname=php-practice; charset=utf8',
 'root',
 'secret'
 );

 /*
 sqlite can be used instead:
 
$db = new PDO(
 'sqlite:C:\Users\6715b\DB\products.db',
 null,
 null
 );
 
 */

// show errors
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// the following can be extended to iterate for any ID,
// but it's not what this assignment is about
$object1=ShopProduct::getInstance(1,$db);
$object2=ShopProduct::getInstance(2,$db);
// some ternary fun, check both objects
$message=!is_null($object1) ? $object1->getSummary() . "<br/>" : "The object is null";
$message.=!is_null($object2) ? $object2->getSummary() : "The object is null";
print $message;

// after all that magnificent code, the script returns:
//
// My first amazing PDO (Sunny Books Ltd.), total of 23 pages
// Dinosaur trouble (Bandi), ages 4-11

// this script implements a "factory" method, ShopProduct::getInstance
// however, the design is incomplete and potentially problematic


// NOTE:
// this file pre-supposes the existence of:
// "php-practice" mysql database
// using
/* CREATE TABLE products(
		id INTEGER PRIMARY KEY AUTOINCREMENT;
		type TEXT,
		prodname TEXT,
		title TEXT,
		price float,
		discount int,
		numpages int,
		appropriateages TEXT
	)
	
* Here is a custom data set for this file:

 INSERT INTO `php-practice`.`products` (
 `id`, `type`, `prodname`, `title`, `price`, `discount`, `numpages`, `appropriateages`
 ) VALUES (
 '1', 'sketchbook', 'Sunny Books Ltd.', 'My first amazing PDO', '9001', '0', '23', NULL
 ), (
 '2', 'toy', 'Bandi', 'Dinosaur trouble', '8999.99', '1', NULL, '4-11'
 );	

*/

 ?>
