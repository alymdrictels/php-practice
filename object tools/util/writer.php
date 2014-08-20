<?php 

namespace util; // will not collide with other writer.php!
print basename(dirname(__FILE__));
class Writer{
	function Write(){
		print basename(dirname(__FILE__)). " writer autoloaded!\r\n";
	} // this works for the first child directory namespace
}

?>