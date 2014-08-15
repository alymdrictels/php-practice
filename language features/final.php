<?php

// final class Accountant{}

// class ExtremelyCoolAccountant extends Accountant{}

/*
Fatal error: Class ExtremelyCoolAccountant
may not inherit from final class (Accountant)
*/

class Accountant{
	final function getSummary(){}
}

class ExtremelyCoolAccountant extends Accountant{
	function getSummary(){}
}

/*
Fatal error: Cannot override final method
Accountant::getSummary()
*/



 ?>
