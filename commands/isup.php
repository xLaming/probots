<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "member") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(Empty($args[1]))
		return $core->function->sendMsg("Example: !isup [website]", $mType, $user->id);
	
	$website = $core->function->getFiles("http://isup.me/".urlencode($args[1]));
	If(strpos($website, "It's just you"))
		return $core->function->sendMsg("Website online (y#)", $mType, $user->id);
	
	$core->function->sendMsg("Website offline (n#)", $mType, $user->id);
};
