<?php

// also known as overloading, with distinct differences

/*
	__get($property)
	__set($property,$value)
	__isset($property)
	__unset($property)
	__call($method,$args_array)
	__callStatic($method,$args_array)

*/

// this is nifty :D
class Person{
// private $cornflakes="1";
	function __get($property){ 	// magic method which takes non-defined
								// properties as arguments, and returns their calls
		return $property;
	}
}
$person=new Person;
print $person->cornflakes; 	// prints "cornflakes" for private $cornflakes
							// prints "1" for public $cornflakes
// can be used to call a method by checking whether it exists
// then constructing a method call string $this->$nameOfMethod
							
 ?>
