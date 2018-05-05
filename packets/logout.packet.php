<?php
If(@$this->times['subscription'] >= time())
	$this->sql->query("UPDATE `accounts` SET `subscription` = '0', `freezed`= '".($this->times['subscription'] - time())."' WHERE `id` = '{$this->botID}';");
$this->sql->query("INSERT INTO `errors` (`index`, `error`, `botid`, `type`, `time`) VALUES (NULL, 'logout', '{$this->botID}', '".json_encode($packet)."', '".time()."');");
die();