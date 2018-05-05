<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "member") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$msg  = preg_replace('/[^0-9+-\/¹²³*%.]+/i', '', str_replace(',', '.', $args[1]));
	
	If(Empty($msg))
		return $core->function->sendMsg($core->translate->__r('what-e'), $mType, $user->id);
	
	$msg = preg_replace_callback('/([0-9]+)([¹|²|³]+)/', function ($a) {
		$a[2] = str_replace(array('¹','²','³'), array(1,2,3), $a[2]);
		return pow($a[1], $a[2]);
	}, $msg);
	
	$calc = @create_function("", "return({$msg});") OR $return = True;
	
	If(Isset($return))
		return $core->function->sendMsg($core->translate->__r('invalid-e'), $mType, $user->id);
	
	$core->function->sendMsg($msg.' = '.$calc(), $mType, $user->id);
	unset($msg, $calc);
};
