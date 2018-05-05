<?php
If(@$this->times['subscription'] >= time())
	$this->sql->query("UPDATE `accounts` SET `subscription` = '0', `freezed`= '".($this->times['subscription'] - time())."' WHERE `id` = '{$this->botID}';");
die();