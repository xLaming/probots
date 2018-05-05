<?php
$packet["u"] = $this->function->parseUser($packet["u"]);
If(Empty($packet["u"])) { return False; }

If(Isset($this->users[$packet["u"]]))
	unset($this->users[$packet["u"]]);

$this->users[$packet["u"]] = new User($packet, $this, $this->function);

$packetToSend = $this->function->createPacket('z', Array('d' => $packet['u'], 'u' => $this->login['i'], 't' => '/l'));
$this->sockets->send($packetToSend);
unset($packetToSend);