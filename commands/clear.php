<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('cls');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "mainowner") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If($core->chatinfo['storemsg'] == 0)
		return $core->function->sendMsg("This chat not store messages.", $mType, $user->id);
	
	If($core->login['rank'] < 2)
		return $core->function->sendMsg("I can't do that.", $mType, $user->id);
		
	$core->function->sendMsg($core->translate->__('chat-cleared'), $mType, $user->id);
	For($i=1; $i<=25; $i++)
		$core->sockets->send($core->function->createPacket('m', Array('t' => '/d', 'u' => $this->login['i'])));
};
