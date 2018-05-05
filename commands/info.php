<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Command only */
	$core->function->sendMsg("PROBots - PROBots.org xat Professional Bots.", $pmm, $user->id);
};
