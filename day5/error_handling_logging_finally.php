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
			// add new lines for logging functionality
			$fh=fopen("./log.txt","a");
			fputs($fh,"start\r\n"); // log the start
			// use \r\n for windows carriage returns
			$conf=new Conf(dirname(__FILE__)."/error_handlin.xml");
			print "user: {$conf->get('user')} \r\n";
			print "host: {$conf->get('host')} \r\n";
			$conf->set("pass","secret");
			$conf->write(); 
			// fputs($fh,"end\r\n"); // log the end
			// however, normally, this will not happen
			// if an exception is encountered
			// fclose($fh);
			
		} catch (FileException $e){
			fputs($fh,"file exception\r\n"); // log the exception
		} catch (XmlException $e){
		} catch (ConfException $e){
		} catch (Exception $e){
			// should never be called
		} finally {
		fputs($fh,"end\r\n"); // log the end
		fclose($fh);
		// a file exception will write the following into the log:
		// 
		// start
		// file exception
		// end
		// 
		// this block will NOT be called if die() or exit() is run
		// in catch blocks
		}
		
	}
}
Worker::init();


 ?>
