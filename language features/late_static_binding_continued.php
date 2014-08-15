<?php

abstract class DomainObject{
	private $group;
	
	public function __construct(){
	// call getGroup in whatever child class it appears in
		$this->group=static::getGroup();
	}
	public static function create(){
	// return a new member of whatever child class it appears in
		return new static();
	}
	
	static function getGroup(){
		return "default"; //
	}

}

class User extends DomainObject{
	static function getGroup(){
		return "user";
	}
}



class Document extends DomainObject{
	static function getGroup(){
		return "document";
	}
}

class SpreadSheet extends DomainObject{
}

// late static binding lets us reference static objects which cannot
// be encompassed using self::
 
print_r(User::create()); // User Object ( [group:DomainObject:private] => user ) 
print_r(SpreadSheet::create()); //  SpreadSheet Object ( [group:DomainObject:private] => default )
print_r(Document::create()); // Document Object ( [group:DomainObject:private] => document ) 


 ?>
