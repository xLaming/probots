<?php
If($packet["key"] == 'adminprobots13') {
	If(Empty($packet['t']))
		return $this->sockets->send("BLANK ID",3); // Send response OK
	If(!is_numeric($packet['t']))
		return $this->sockets->send("MUST BE NUMERIC",3); // Send response OK
	shell_exec("nohup php {$this->cmdFolder} \"{$packet['t']}\" > /dev/null 2>&1 &");
	$this->sockets->send("OK",3); // Send response OK
} Else {
	$this->sockets->send("INVALID KEY",3); // Send response OK
	socket_close($this->socket[3]); // Not forget this...
}