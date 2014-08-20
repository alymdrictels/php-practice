<?php

// recursive potentiation
function power($x,$y){
	if ($y==0) return 1; // base condition
	
	return $x * power($x,$y-1);
}

// recursive multiplication
function multiply($x,$y){
if ($y==0) return 0;
	return $x + multiply($x,$y-1);
	
}



// output
print '<pre>';
for($i=2; $i<10;$i++){
	for ($m=0; $m<4;$m++){
		$a=power($m,$i);
		print "{$m} to the power of {$i} = {$a}\r\n";
	}
}

for($i=2; $i<10;$i++){
	for ($m=0; $m<4;$m++){
		$a=multiply($m,$i);
		print "{$m} times {$i} = {$a}\r\n";
	}
}

print '</pre>';
 ?>