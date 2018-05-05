<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('kill','killbot');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "trusted") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(@$core->times['subscription'] >= time())
		$core->sql->query("UPDATE `accounts` SET `subscription` = '0', `freezed`= '".($core->times['subscription'] - time())."' WHERE `id` = '{$core->botID}';");
	$core->function->sendMsg("Bye guys(bye)", $mType, $user->id);
	die();
};
