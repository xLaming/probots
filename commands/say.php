<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('talk','speak');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "owner") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(!Isset($args[1]))
		return $core->function->sendMsg("What message?", $mType, $user->id);
	If(strlen($args[1]) > 80)
		return $core->function->sendMsg("Max allowed 80 chars per message!", $mType, $user->id);
	
	$core->function->sendMsg(($pmm == 1 || $pmm == 2 ? "[{$user->id}]: " : "").$core->function->protection($args[1]), $mType, $user->id);
};
