<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('time');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "main") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(@$core->times['special'] == True)
		$type = 'FREE PREMIUM';
		#$type = 'Special Bot';
	Else If(@$core->times['promoted'] == True)
		$type = 'Free Time, your chat is promoted for '.($core->times['subscription'] - time() < 60 ? 'less than 1 minute' : $core->function->stotime($core->times['subscription'] - time()));
	Else If(@$core->times['subscription'] >= time())
		$type = 'Paid for '.($core->times['subscription'] - time() < 60 ? 'less than 1 minute' : $core->function->stotime($core->times['subscription'] - time()));
	Else
		$type = 'Free';
	
	$core->function->sendMsg("Your bot is: ".$type, $mType, $user->id);
};
