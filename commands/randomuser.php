<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "mod") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$_users = Array();
	Foreach($core->users AS $u) {
		If(is_object($u)) {
			If(!Empty($u->user))
				$_users[] = $u->user."({$u->id})";
			Else
				$_users[] = "Unregistered({$u->id})";
		}
	}
	$core->function->sendMsg($_users[array_rand($_users)], $mType, $user->id);
};
