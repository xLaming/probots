<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('fullscreen');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "member") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$chatid = $core->function->getFiles('http://xat.com/web_gear/chat/roomid.php?d='.$args[1]);
	If($chatid <= 0)
		return $core->function->sendMsg($core->translate->__r('chat-not-found'), $mType, $user->id);
	$core->function->sendMsg("http://www.xatech.com/web_gear/chat/chat.swf?id=".$chatid, $mType, $user->id);
};
