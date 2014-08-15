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


class Person{
	private $_name;
	private $_age;
	function __set($property,$value){ 	// magic method which takes non-defined
		$property=ucfirst($property);
		$method="set{$property}";
		// property and value as arguments, and returns their calls
		// print $method; // for debug
		if (method_exists($this,$method)){
			return $this->$method($value);
		}
	}
	function setName($name){
		
		$this->_name=$name;
		
		if (!is_null($name)){
			$this->_name=strtoupper($this->_name); // we check
			// whether the magic setter did something
			// by capitalizing the _name var
		}
	}
	function setAge($age){
		$this->_age=strtoupper($age);
	}
	function getName(){
		return $this->_name;
	}
	function __unset($property){
		print $this ."::". $property ." is attempted to be unset!";
		
	
	}
	function __toString(){
		return "Person";
	}
	
}
$person=new Person;
$person->name="Marcus"; 	
//print $person->getName(); // prints "MARCUS"

// just as the name implies, interceptor methods can capture
// variables as they are defined or set and filter them							
							
// i'll admit that these seem VERY situational to me at the moment
// case in point,
// the next magic method is __unset, called when unset()
// is called							



unset($person->_name); // cannot unset private properties




							
							
 ?>
