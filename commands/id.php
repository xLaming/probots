<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('userid');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "member") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$userid = $core->function->getFiles('http://xat.me/web_gear/chat/profile.php?name='.$args[1]);
	If($userid <= 0 || Empty($userid))
		return $core->function->sendMsg("User not found.", $mType, $user->id);
	$core->function->sendMsg("ID for user [".ucfirst(strtolower($args[1]))."] is: ".$userid, $mType, $user->id);
};
