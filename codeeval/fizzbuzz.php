<?php


$a=function ($param_array,$offset){
$fizz=$param_array[$offset];
$buzz=$param_array[$offset+1];
$limiter=$param_array[$offset+2];
	for ($i=1; $i<=$limiter; $i++){
		if (($i%$fizz==0) && ($i%$buzz==0)) print 'FB';
		elseif ($i%$fizz==0) print 'F';
		elseif ($i%$buzz==0) print 'B';
		else print $i;
		if ($i<$limiter) print ' ';
	}
};

$params = file_get_contents($argv[1]);
$onelineparams=str_replace("\n",' ', $params);
$param_array=explode(' ', $onelineparams);
$ti=0;

while (isset($param_array[$ti])){
	print $a($param_array,$ti) . "\n";	
	$ti+=3;
}




?>



