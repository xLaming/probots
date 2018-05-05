<?php
function sendCmd($cmd) {
	$socket = @fsockopen('127.0.0.1', 120907, $e, $e, 1);
	If($socket === False)
		die('--> Bot offline.');
	fwrite($socket, "<cmd t=\"{$cmd}\" key=\"eb5245f2e\" />");
	$read = fread($socket, 4096);
	echo "<-- RESPONSE: {$read}\n";	
	fclose($socket);
}

While(1) {
	echo "--> Command: ";
	sendCmd(trim(fgets(STDIN)));
}
?>