<?php

class Conf  {
	private $file;
	private $xml;
	private $lastMatch;
	
	function __construct($file){
		$this->file=$file;
		$this->xml=simplexml_load_file($file); // populates the object with xml values		
	}
	function write(){
		file_put_contents($this->file, $this->xml->asXML());
		// replaces fopen(), fwrite() and fclose()
		// int file_put_contents
		// ( string $filename , mixed $data [, int $flags = 0 [, resource $context ]] )
		// this writes data back to the xml file invoked
	}
	function get($str){
		$matches=$this->xml->xpath("/conf/item[@name=\"$str\"]");
		// the xpath passes the conf node and searches for "item [str]"
		if (count($matches)){
			$this->lastMatch=$matches[0];
			return (string)$matches[0];
		}
		return null;
	}
	
	function set($key,$value){
		if (!is_null($this->get($key))){
			$this->lastMatch[0]=$value;
			return;
		}
		$conf=$this->xml->conf;
		$this->xml->addChild('item', $value)->addAttribute('name', $key);
	}	
}

$conf=new Conf("error_handling.xml");
print $conf->get("user");
$conf->set("database","php-practice"); // adds new local xml
$conf->write(); // appends the local xml into the file
print $conf->get("database"); // gets the new local xml

// the write() function will not produce duplicates
// because duplicate keys are overwritten

// however there is no error handling here

 ?>
