<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "owner") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$args = explode(chr(32), $args[1], 2);
	If(Empty($args[0]) || Empty($args[1]))
		return $core->function->sendMsg("Example: !hush [rank] [time: 10-60]", $mType, $user->id);
	
	$rank = strtolower(str_replace( "_", "", $args[0]));
	$allowed = Array(
		'guest'       => 'g',
		'guests'      => 'g',
		'member'      => 'm',
		'members'     => 'm',
		'mod'         => 'd',
		'moderator'   => 'd',
		'moderators'  => 'd',
		'mods'        => 'd',
		'owner'       => 'o',
		'owners'      => 'o'
	);
	
	If(Empty($allowed[$rank]))
		return $core->function->sendMsg("Incorrect rank!", $mType, $user->id);
	
	If(!is_numeric($args[1]))
		return $core->function->sendMsg("Time must be numeric!", $mType, $user->id);
	
	If($args[1] < 10 || $args[1] > 60)
		return $core->function->sendMsg("Time must be 10 - 60 seconds!", $mType, $user->id);
	
	$core->sockets->send($core->function->createPacket('m', Array('t' => '/h'.$allowed[$args[0]].$args[1], 'u' => $core->login['i'])));
};
