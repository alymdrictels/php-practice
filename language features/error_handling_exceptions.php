<?php

class XmlException extends Exception{
	private $error;
	function __construct(LibXmlError $error){
		$shortfile=basename($error->file);
		$message="[{$shortfile}], line {$error->line},
		col {$error->column} {$error->message}";
		$this->error=$error;
		
		// complete the XmlException class constructor
		// so the remaining initialization is not missed
		parent::__construct($message,$error->code);
	}
	function getLivXmlError(){
		return $this->error;
	}
}
class FileException extends Exception{}
class ConfException extends Exception{}

class Conf  {
	private $file;
	private $xml;
	private $lastMatch;
	
	function __construct($file){
		$this->file=$file;
		if (!file_exists($file)){
			throw new FileException("file '$file' does not exist");
		} // the above function will result in a fatal error
		// if the called file is not found
		// optional flags to suppress simplexml_load_file default error
		$this->xml=simplexml_load_file($file,null,LIBXML_NOERROR);
		// if the xml parsing failed for some reason
		// such as malformed xml files
		if (!is_object($this->xml)){
		// utilize libxml error hook
			throw new XmlException(libxml_get_last_error());
		}
		// print gettype($this->xml); // returns "object"
		// check for /conf xpath
		$matches=$this->xml->xpath("/conf");
		// if there are none
		if (!count($matches)){
			throw new ConfException("could not find root element: conf");
		}
		
	}
	function write(){
		if (!is_writable($this->file)){
			throw new FileException("file '{$this->file}' is not writeable");
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

class Worker{
	static function init(){
		try{
			$conf=new Conf(dirname(__FILE__)."/error_handling.xml");
			print "user: {$conf->get('user')} \n";
			print "host: {$conf->get('host')} \n";
			$conf->set("pass","secret");
			$conf->write(); 
			
		} catch (FileException $e){
			// permissions, file does not exist
		} catch (XmlException $e){
			// xml parsing failed, broken?
		} catch (ConfException $e){
			// unexpected xml format
		} catch (Exception $e){
			// should not be called if all cases are caught properly
			// useful in the case that new Exception types will be created later
			// "throw $e;" inside the catch stmt can be used to
			// further enhance reporting
			//
			// errors should be thrown IF there is not enough
			// contextual information to handle it
		}
		
	}
}

// the "throw new Exception" exception object is forwarded into the
// catch (Exception $variable) in the invoking scope

// the Exception class can be extended:
// to expand the class's functionality
// to aid error handling by sub-classing

 ?>
