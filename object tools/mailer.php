<?php
$to = "my email address";
$subject = "Hi!";
$body="test".PHP_EOL;
$body.="Hello World. Sending some mail from my PHP".PHP_EOL;


$headers = "From: root@localhost.com";

if (mail($to, $subject, $body, $headers)) {
echo("Message successfully sent!
");
} else {
echo("Message delivery failed.");
}
  
 

?>
