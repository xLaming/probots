<?php
If($packet["key"] == $this->config["api"]["key"]) {
	$this->function->sendMsg($packet["t"]);
	$this->sockets->send("OK",3); // Send response FAIL
	socket_close($this->socket[3]); // Not forget this...
} Else {
	$this->sockets->send("INVALID KEY",3); // Send response OK
	socket_close($this->socket[3]); // Not forget this...
}
