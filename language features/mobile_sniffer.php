<?php

class MobileSniffer{
	private $userAgent;
	private $device;
	private $browser;
	private $deviceOffset;
	private $browserOffset;
	
	public function __construct(){
		$this->userAgent=strtolower($_SERVER['HTTP_USER_AGENT']);
		
		$this->device=array('windows','iphone', 'ipad','android', 'blackberry', 'touch');
		$this->browser=array('firefox','chrome', 'opera','msie','safari','blackberry');
		
		$this->deviceOffset=count($this->device);
		$this->browserOffset=count($this->browser);
	}
	public function findDevice(){
		for($i=0; $i < $this->deviceOffset;$i++){
			if (strstr($this->userAgent,$this->device[$i])){
				return $this->device[$i];
			}
		}
	}
	public function findBrowser(){
		for($i=0; $i < $this->browserOffset;$i++){
			if (strstr($this->userAgent,$this->browser[$i])){
				return $this->browser[$i];
			}
		}
	}	
}

 ?>
