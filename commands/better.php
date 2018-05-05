<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "guest") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$ex = explode(' or ', $args[1]);
	
	If(Empty($ex[0]) || Empty($ex[1]))
		return $core->function->sendMsg("Example: !better THIS or THAT", $mType, $user->id);
	
	$exec = Array();
	$exec[] .= $ex[0];
	$exec[] .= $ex[1];

	$core->function->sendMsg("The better is: ".$exec[array_rand($exec)], $mType, $user->id);
};
