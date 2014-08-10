<?php

// look up 
// http://lzone.de/preg_match%20Solutions%20for%20Typical%20Tasks

$string="Ivan je rođen 23/01/2002. godine";
preg_match('/(?P<month>\d{2})\/(?P<day>\d{2})\/(?P<year>\d{4})/', $string, $result);
echo "<pre>";
var_dump($result);
echo "</pre>";
 ?>
