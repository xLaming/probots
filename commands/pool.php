<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "botowner") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(!Isset($args[1]) || !is_numeric($args[1]))
		return $core->function->sendMsg("Example: !pools [1/2/3...]", $mType, $user->id);
		
	$args[1] = (Int)$args[1];
	If(!in_array($args[1], $core->pools))
		return $core->function->sendMsg("Available pools: ".implode(', ', $core->pools), $mType, $user->id);
		
	$core->sockets->send('<w'.intval($args[1] - 1).' />');
};
