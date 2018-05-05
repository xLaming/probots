<?php
If(Empty($packet['k1']) || Empty($packet['k3'])) {
	$this->sql->query("INSERT INTO `errors` (`index`, `type`, `botid`, `error`, `time`) VALUES (NULL, 'login', '{$this->botID}', '".json_encode($packet)."', '".time()."');");
	die();
} Else {
	$this->login = $packet;
}