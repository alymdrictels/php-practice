<?php

class StaticBaseClass{
	function printDuke(){
		print "Duke";
	}
}

// ClassName::$classProperty
// ClassName::classFunction()
// syntax
class StaticExample extends StaticBaseClass{
	static public $number = 0;
	static public function sayHello(){
		self::$number++;
		print " Hello (" . self::$number . ")";
		parent::printDuke(); // parent syntax
		// a method call using "parent" is the only circumstance where
		// you should use a static reference to a nonstatic method
	}
}
 
 print StaticExample::$number . "<br/>";
 StaticExample::sayHello();
 StaticExample::sayHello();
 StaticExample::sayHello(); // StaticExample::$number is 3 now
 
 // returns:
 //
 // 0
 // Hello (1)Duke Hello (2)Duke Hello (3)Duke
 
 // static methods access STATIC properties only
 // because otherwise they'd belong to an object
 // also
 // the "self" keyword is used for classes similar to the way
 // the "this" keyword is used for instances, cannot be used
 
 // benefits of static methods:
 // 1. available anywhere in the script, no instances need to be passed
 // 2. every instance can access a static property
 // 3. you do not need to instantiate an object for simple functions
 
 ?>
