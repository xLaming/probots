<?php
$socket = @fsockopen('127.0.0.1', 10090, $e, $e, 1);
If($socket === False) {
	die('Bot offline.');
} Else {
	fwrite($socket, "<cmd t=\"!say HELLO\" key=\"aax23b236c326k\" />"); // Command
	#fwrite($socket, "<say t=\"Hello\" key=\"aax23b236c326k\" />"); // Say a message
	#fwrite($socket, "<die key=\"aax23b236c326k\" />"); // Turn bot off
	$read = fread($socket, 4096);
	fclose($socket);
	die('Response: '.$read);
}
?>