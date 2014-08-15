<?php

// all comments for previous additions are left out

class ShopProduct implements Chargeable{
	private $title;
	private $prodName;
	private $price;
	private $id=0;
	protected $discount=0;
	
	function __construct($title, $prodName,$price){
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
	
	// not implementing the above interface (Chargeable) results in:
	//
	// Fatal error: Class ShopProduct contains 1
	// abstract method and must therefore be declared abstract
	// or implement the remaining methods (Chargeable::getPrice)
	//
	// this can be useful for exploiting method scope:
	//
	// public function addChargeableItem( Chargeable $item) {
	// 		# insert code here
	// }
	// by implementing any number of interfaces in a class,
	// the interfaces can link unrelated object types:
	//
	// class Shipping implements Chargeable{
	//		public function getPrice{
	//			#insert code here
	//		}
	// }
	//
	// other possible variations:
	//
	// class Consultancy extends TimedService implements Bookable, Chargeable{
	//		# insert code here
	// }
	// 
	// only 1 parent class, multiple possible interfaces
	//
}

	abstract class ShopProductWriter{
		protected $product=array();
		public function addProduct(ShopProduct $shopProduct){
			$this->products[]=$shopProduct;
		}
		// abstract methods cannot have implementations
		abstract public function write();
		
	}

	class XmlProductWriter extends ShopProductWriter{
		public function write(){
			$writer=new XMLWriter();
			$writer->openMemory();
			$writer->startDocument('1,0','UTF-8');
			$writer->startElement("products");
			foreach ($this->products as $shopProduct){
				$writer->startElement("product");
				$writer->writeAttribute("title",$shopProduct->getTitle());
				$writer->startElement("summary");
				$writer->text($shopProduct->getSummary());
				$writer->endElement(); // for summary
				$writer->endElement(); // for product
			}
			$writer->endElement(); // for products
			$writer->endDocument();
			print $writer->flush(); // regurgitate the whole thing
			}
		}
	
	class TextProductWriter extends ShopProductWriter{
		public function write(){
			$output="PRODUCTS:\n";
			foreach($this->products as $shopProduct){
				$output .= $shopProduct->getSummary() . "\n";
			}
			print $output;
		}
	}

// abstract classes let you provide some implementation
// such as public functions (ShopProductWriter->addProduct())
//
// interfaces are pure templates
// any class that implements this interface must implement all
// the methods it defines, or be declared abstract
	
interface Chargeable {
	public function getPrice();
}

	
class ToyProduct extends ShopProduct{
	public $appropriateAges;
	function __construct($title,$prodName,$price, $appropriateAges){
		parent::__construct($title, $prodName,$price); // puts these defaults into the parent constructor
		$this->appropriateAges=$appropriateAges; // sets the child property
		}
	function getAppropriateAges(){
		return $this->appropriateAges;
	}
	function getSummary(){
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
	function getNumPages(){
		return $this->numPages;
	}
	function getSummary(){
		$output=parent::getSummary();
		$output.=", total of {$this->getNumPages()} pages";
		return $output;
	}
}

$db = new PDO(
 'mysql:host=localhost;dbname=php-practice; charset=utf8',
 'root',
 'secret'
 );

// show errors
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// instantiate objects for each Product
$object1=ShopProduct::getInstance(1,$db);
$object2=ShopProduct::getInstance(2,$db);


 ?>
