<?php

// "hack" PHP

// print $_SERVER['HTTP_USER_AGENT'];


// "enterprise" (yikes) PHP

class TellAll{
	private $userAgent;
	public function __construct(){
		$this->userAgent=$_SERVER['HTTP_USER_AGENT'];
		print $this->userAgent;
	}
}
$tellAll=new TellAll();


 ?>
