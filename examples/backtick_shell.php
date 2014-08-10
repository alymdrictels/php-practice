<?php

//backtick experiments
//
$output=escapeshellarg(`php class_identifiers.php`);
// apparently it's possible to run an external php
// script from within the shell, escapeshellarg() for
// safety in parametrized queries
echo "<pre>$output</pre>";


$output=escapeshellarg(`dir`);
// apparently it's possible to run an external php
// script from within the shell, escapeshellarg() for
// safety in parametrized queries
echo "<pre>$output</pre>";

 ?>
