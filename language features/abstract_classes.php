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
	

}

	// redefining of previously defined class
	// this method cannot be instantiated
	abstract class ShopProductWriter{
		protected $product=array();
		public function addProduct(ShopProduct $shopProduct){
			$this->products[]=$shopProduct;
		}
		// abstract methods cannot have implementations
		abstract public function write();
		
	}
	// BUT
	// 		class ErrorShopProductWriter extends ShopProductWriter{}
	// causes
	// Fatal error: Class ErrorShopProductWriter contains
	// 1 abstract method and must therefore be declared abstract
	// or implement the remaining methods (ShopProductWriter::write)
	// therefore
	// any class that EXTENDS an abstract class must implement
	// ALL abstract methods, or be abstract itself
	// not only that, but it must reproduce the method signature
	// i.e. access control cannot be stricter in the implementing method
	// the implementing method should also require the same # of args

	// XML writer and string writer classes:
	
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

// initialize writer instance
$writer=new XmlProductWriter();
// add the objects to be written
$writer->addProduct($object1); $writer->addProduct($object2);
$writer->write();

// outputs nicely formatted XML

 ?>
