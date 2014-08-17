<?php
print ('<pre>');
if (require_once('Date\Calc.php')) print "PEAR package imported!\r\n";
 
 $dc=new Date_Calc;
 print $dc->dateToDays(2,12,2003) . " <-- number of days from Unix epoch to 2/12/2003";
 
print ('</pre>');
?>