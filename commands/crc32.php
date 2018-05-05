<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "member") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(Empty($args[1]))
		return $core->function->sendMsg("What I need encrypt?", $mType, $user->id);
	
	If(strlen($args[1]) > 128)
		return $core->function->sendMsg("Max 128 chars is allowed.", $mType, $user->id);
		
	$core->function->sendMsg('String encrypted: '.crc32($args[1]), $mType, $user->id);
};
