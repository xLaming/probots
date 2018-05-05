<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('la');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "guest") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(ctype_alnum($args[1]) || is_numeric($args[1]))
		$id = $core->function->getID($args[1]);
	Else
		$id = $user->id;
	   
	$info = $core->sql->fetch_array("SELECT * FROM `users` WHERE `id` = '{$id}';");   
	   
	If($info[0]['optout'] == 1)
		return $core->function->sendMsg("User has opted out that service.", $mType, $user->id);  
	   
	If(Empty($info))
		return $core->function->sendMsg('User not found on our database.', $mType, $user->id);
	   
	$la = json_decode($info[0]['lastseen'], True);
	$core->function->sendMsg($info[0]['user']."'s lastseen: ".date("g:i A d F Y", $la['time'])." @".$la['chatname'], $mType, $user->id);
};
