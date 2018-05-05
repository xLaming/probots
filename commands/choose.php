<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "guest") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(Empty($args[1]))
		return $core->function->sendMsg("Example: !choose cool, flip, smile", $mType, $user->id);
	
	$args = array_map('trim', explode(', ', $args[1]));
	
	if(count($args) == 1)
		return $core->function->sendMsg("Example: !choose cool, flip, smile", $mType, $user->id);
	
	$core->function->sendMsg("I choose: ".$args[array_rand($args)], $mType, $user->id);
};
