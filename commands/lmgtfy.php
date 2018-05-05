<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "mod") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(!Isset($args[1]))
		return $core->function->sendMsg("You need put the phrase to search.", $mType, $user->id);

	$core->function->sendMsg('Your link, click here: http://lmgtfy.com/?q='.urlencode($args[1]), $mType, $user->id);
};
