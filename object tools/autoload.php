<?php

spl_autoload_register(); // signals the system to call spl_autoload()
// if an unknown class is attempted to be instantiated
print('<pre>');
$writer = new Writer();
$writer->Write(); // works!

// this supports namespaces, so:
$writer2 = new util\Writer();
$writer2->Write();
// will search for the directory util\ and file writer.php (lower case)
// because it assumes that the class name = file name

print('</pre>');

?>