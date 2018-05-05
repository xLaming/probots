<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('tempmember');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "mod") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$args = explode(chr(32), $args[1], 2);
	
	If(!Isset($args[0]))
		return $core->function->sendMsg("Who is the user?", $mType, $user->id);
		
	If(!Isset($args[1]) || $args[1] > 24)
		return $core->function->sendMsg("Invalid time!", $mType, $user->id);
		
	$_user = $core->function->getUser($args[0]);
	
	If(!is_object($_user))
		return $core->function->sendMsg("User must be online.", $mType, $user->id);
		
	$_user->temp('tempmem', $args[1]);
};
