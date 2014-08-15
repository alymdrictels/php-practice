<?php

interface IMethodHolder{
	public function getInfo($info);
	public function sendInfo($info);
	public function calculate($first,$second);
}

class ImplementAlpha implements IMethodHolder{
	public function getInfo($info){
		print "Some {$info} for everyone!<br/>";
	}	
	public function sendInfo($info){
		return $info;
	}
	public function calculate($first,$second){
		$calculated=$first*$second;
		return $calculated;
	}
	public function useMethods(){
		$this->getInfo("orcs");
		print $this->sendInfo("Orcs and humans, yo!"). "<br/>";
		print $this->calculate(20,15)." but squirrels.";
	}
	
}

$alpha=new ImplementAlpha();
$alpha->useMethods();

 ?>
