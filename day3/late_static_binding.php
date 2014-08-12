<?php

abstract class DomainObject{
	public static function create(){
		return new static();
		// the above line will return a new member
		// of the invoking method (owner)
	}

}

class User extends DomainObject{
	// old implementation:
	//
	//public static function create(){
	//	return new User();
	//}
}

// the implementation would look like
// $user=User::create();

class Document extends DomainObject{
	
	
	// old implementation:
	//
	//public static function create(){
	//	return new Document();
	//}
	// the above structure can be useful for the Identity Map
	// pattern (- return target object if exists, if not, create)
}

// the implementation would look like
// $document=Document::create();

print_r(Document::create()); 		// OK
print_r(User::create());			// OK
//print_r(DomainObject::create());	// error, abstract

 ?>
