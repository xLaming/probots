<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "member") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(time() > 1480032000)
		return $core->function->sendMsg('Blackfriday has already started.', $mType, $user->id);
	Else
		return $core->function->sendMsg($core->function->stotime(1480032000 - time())." left until Blackfriday ".date("Y")."!", $mType, $user->id);
};
