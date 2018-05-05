<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('test');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "guest") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(Empty($args[1]))
		return $core->function->sendMsg("Example: !test cool,flip,red", $mType, $user->id);

	$args = array_map('trim', explode(',', str_replace(')','',str_replace('(','',$args[1]))));
	$final = implode('#', $args);
	
	$core->function->sendMsg("({$final})", $mType, $user->id);
};