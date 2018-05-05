<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "member") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$_user = $core->function->getFiles('http://xat.me/web_gear/chat/profile.php?id='.$args[1]);
	If(Empty($_user))
		return $core->function->sendMsg("User not found.", $mType, $user->id);
	$core->function->sendMsg("User for ID[{$args[1]}] is: ".$_user, $mType, $user->id);
};
