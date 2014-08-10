<?php 

// below is a standard function commenting schema

/** 
* Outputs a list of addresses.
* If $resolve is true then each address will be resolved
* @param	$resolve	Boolean		Resolve the address?
*/
function outputAddresses($resolve){
	if (!is_bool($resolve)){ // strict output checking
		die("outPutAddresses() requires a Boolean argument\n");
	}
	// else ...
	
	// php implicit type conversions are problematic
	// need to balance type testing, (explicit)
	// conversions and documentation
}

?>