<?php
If($packet["key"] == $this->config["api"]["key"]) {
	$this->sockets->send("OK",3); // Send response OK
	socket_close($this->socket[3]); // Not forget this...
	If(@$this->times['subscription'] >= time())
		$this->sql->query("UPDATE `accounts` SET `subscription` = '0', `freezed`= '".($this->times['subscription'] - time())."' WHERE `id` = '{$this->botID}';");
	#$this->function->sendMsg("Bye guys (bye)");
	die();
} Else {
	$this->sockets->send("INVALID KEY",3); // Send response OK
	socket_close($this->socket[3]); // Not forget this...
}