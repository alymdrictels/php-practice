<?php
$to = "alymdrictels@gmail.com";
$subject = "Hi!";
$body="test".PHP_EOL;
$body.="Hello World. Šaljem mail iz PHP filea".PHP_EOL;


$headers = "From: root@localhost.com";

if (mail($to, $subject, $body, $headers)) {
echo("Message successfully sent!
");
} else {
echo("Message delivery failed.");
}
  
 

?>