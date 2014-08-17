<?php

// packages are a set of related classes
// namespaces are used to constrain them in order to avoid duplication,
// verbosity etc.
/* 
namespace my;

require_once "useful/Outputter3.php";

class Outputter{
	// does some work
}

// useful/Outputter3.php
namespace useful;

class Outputter{
	// does some other work
}
 */
 
 namespace project\getInstance\util;
 
 class Debug{
	static function helloWorld(){
		print "Hello from Debug\r\n";
	}
 }
 
 Debug::helloWorld(); // from within the namespace
 
  // relative namespace:
 //project\getInstance\util\Debug::helloWorld(); // from another namespace
 
  
    // absolute namespace:
  namespace main; // can't use relative namespace to access helloWorld()
  // relative would search main\project\getInstance...
  \project\getInstance\util\Debug::helloWorld();

  
  
  
  // aliasing namespaces:
  
  namespace main;
  use project\getInstance\util; // implicitly aliased to util
  util\Debug::helloWorld(); // so this will work
  
  // can also import only one class:
  
  namespace main;
  use project\getInstance\util\Debug;
  Debug::helloWorld();
  
  // aliasing explicitly:
  
  namespace main;
  use project\getInstance\util\Debug as uDebug;
  // allows us to have another class named Debug so they don't conflict
  
  // you can access non-namespaced space by using \
  // like this:
  
  // global.php, without namespace
  
  class ParseParser{
    public static function helloWorld(){
		print "hello from global\n";
	}
  }
  // namespaced file:
  
  namespace project\getInstance\util;
  require_once 'global.php';
  class ParseParser{
      public static function helloWorld(){
        print "hello from" . __NAMESPACE__ . " \n";
	  }
  }
  ParseParser::helloWorld(); // local namespaced method
  \ParseParser::helloWorld(); // global method
   
  // multiple namespaces can exist in the same file
  // comment out EVERYTHING above for this to work
  // bracketed namespace syntax, that is, multiple namespaces
  // in the same file is not best practice
  namespace main{
	class Debug{
		static function helloWorld(){
			print "hello from Debug!\n";
		}
	}
  }
  namespace project\getInstance\util{
	\main\Debug::helloWorld(); // proper referencing
	// bracketed namespaces and unbracketed ones
	// cannot be mixed - fatal error
	
  }
  
  // global namespace in bracket syntax:
  namespace {
    main\Debug::helloWorld();
  }
  
 
?>