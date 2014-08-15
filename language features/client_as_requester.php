<?php

ini_set("display_errors","1");
ERROR_REPORTING(E_ALL);
include_once('mobile_sniffer.php');

class Client{
	private $mobileSniffer;
	public function __construct(){
		$this->mobileSniffer=new MobileSniffer();
		print "Device = " . $this->mobileSniffer->findDevice() . "<br/>";
		print "Browser = " . $this->mobileSniffer->findBrowser() . "<br/>";
	}
}
$client=new Client();

 ?>
