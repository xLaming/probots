<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('mylevel','myrank');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "guest") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$ranks = Array(0 => 'guest', 1 => 'member', 2 => 'moderator', 3 => 'owner', 4 => 'main owner', 5 => 'trusted', 6 => 'bot owner', 7 => 'helper', 8 => 'admin');
	$core->function->sendMsg($core->translate->__('your-level', Array($ranks[$user->botrank])), $mType, $user->id);
};
