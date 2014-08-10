<?php

class Proizvod{
	public $ime;
	public $imeProizvođača;
	public $prezimeProizvođača;
	public $cijena;
	
	// constructor setter with defaults
	function __construct(
		$ime="Proizvod",
		$imep="DefaultIme",
		$pimep="DefaultPrezime",
		$cijena=0
		){
		$this->ime=$ime; $this->imeProizvođača=$imep;
		$this->prezimeProizvođača=$pimep; $this->cijena=$cijena;
	}
	function Proizvod(){} 	// constructor format for php 4
							// constructorName=className
	function getAllFromProizvod(){
		return $this->ime . "&nbsp" . $this->imeProizvođača . "&nbsp" 
		. $this->prezimeProizvođača . "&nbsp" . $this->cijena;
	}
}
$prod1=new Proizvod("Lopata", "Mate", "Bulić d.o.o.", "Miljon kuna");
$prod2=new Proizvod();

echo $prod1->getAllFromProizvod(); echo "<br/>";
echo $prod2->getAllFromProizvod();


//backtick experiments
//
$output=escapeshellarg(`php class_identifiers.php`);
// apparently it's possible to run an external php
// script from within the shell, escapeshellarg for
// safety in parametrized queries
echo "<pre>$output</pre>";


 ?>
