<?php
If($packet["key"] == $this->config["api"]["key"]) {
	$packet["t"] = substr($packet["t"], 1);
	$args = array_map("trim", explode(chr(32), trim($packet["t"]), 2));
	$cmd = str_replace("_", "",strtolower($args[0]));
	If(Isset($this->commands[$cmd])) {
		$user = Array("id" => $this->botInfo["botowner"], "nick" => "commands", "avatar" => 1, "home" => 1, "user" => "bot", "f" => 4);
		$u = (Object) $user;
		$this->commands[$cmd]($this, $args, $packet, 3, 3, $cmd, $u);
		$this->sockets->send("OK",3); // Send response OK
		socket_close($this->socket[3]); // Not forget this...
		return;
	}
	$this->sockets->send("COMMAND NOT FOUND",3); // Send response FAIL
	socket_close($this->socket[3]); // Not forget this...
} Else {
	$this->sockets->send("INVALID KEY",3); // Send response OK
	socket_close($this->socket[3]); // Not forget this...
}