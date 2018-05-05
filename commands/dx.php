<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "guest") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If($args[1] > 1000000)
		return $core->function->sendMsg('Max 1000000 xats.', $mType, $user->id);
	
	If(!is_numeric($args[1]))
	   return $core->function->sendMsg('Amount must be numeric.', $mType, $user->id);
	
	$args[1] = round($args[1]);
	$core->function->sendMsg($args[1]." days worth ".($args[1] * 13)." - ".($args[1] * 14)." xats", $mType, $user->id);
};