<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('ml');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "member") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$core->function->sendMsg('That phrase has '.strlen($args[1]).' characters.', $mType, $user->id);
};