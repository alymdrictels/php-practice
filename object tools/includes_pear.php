<?php
print ('<pre>');
// windows path for XAMPP PEAR is C:\xampp\php\pear
// that's why I can do 'Date\Calc.php'

// commenting the next line checks whether the function existed previously
// or you could use function_exists if you're a buzzkill
if (require_once('Date\Calc.php')) print "PEAR package imported!\r\n";
 
 
 // the php.ini include can be changed using set_include_path
  set_include_path(get_include_path() . PATH_SEPARATOR . "C:\\xampp\php\custom");
 if (require_once('test.php')) print "Custom package imported!\r\n";
 
 
 
 $dc=new Date_Calc;
 print $dc->dateToDays(2,12,2003) . " <-- number of days from Unix epoch to 2/12/2003";
 
print ('</pre>');
?>