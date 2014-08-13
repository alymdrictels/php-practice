<?php

class Conf  {
	private $file;
	private $xml;
	private $lastMatch;
	
	function __construct($file){
		$this->file=$file;
		if (!file_exists($file)){
			throw new Exception("file '$file' does not exist");
		} // the above function will result in a fatal error
		// if the called file is not found
		$this->xml=simplexml_load_file($file);
	}
	function write(){
		if (!is_writable($this->file)){
			throw new Exception("file '{$this->file}' is not writeable");
		}
		// the above function will result in a fatal error
		// if the input xml file is read-only
		file_put_contents($this->file, $this->xml->asXML());
	}
	function get($str){
		$matches=$this->xml->xpath("/conf/item[@name=\"$str\"]");
	
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

try{
$conf=new Conf("error_handling.xml");
$conf->set("database","php-practice");
$conf->write(); 
print $conf->get("database"); 
} catch (Exception $e){
	die($e->__toString());
}

// the "throw new Exception" exception object is forwarded into the
// catch (Exception $variable) in the invoking scope


 ?>
