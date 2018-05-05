<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "botowner") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$args = array_map('trim', explode(' ', $args[1], 2));
	$args = array_map('strtolower', $args);
	
	If(Empty($args[0]))
		return $core->function->sendMsg('Example: !away [on/off]', $mType, $user->id);
	
	Switch(str_replace('_', '', strtolower($args[0]))){
		case 'on':
			If($core->away == True)
				return $core->function->sendMsg('Away is current enabled.', $mType, $user->id); 
			$core->sockets->send($core->function->createPacket('m', Array('t' => '/away', 'u' => $core->login['i'])));
			$core->function->sendMsg('Away enabled.', $mType, $user->id);
			$core->away = True;
		break;
		
		case 'off':
			If($core->away == False)
				return $core->function->sendMsg('Away is current disabled.', $mType, $user->id);
			$core->function->sendMsg('Away disabled.', $mType, $user->id);
			$core->sockets->send($core->function->createPacket('m', Array('t' => '/back', 'u' => $core->login['i'])));
			$core->away = False;
		break;
		
		default:
			$core->function->sendMsg('Example: !away [on/off]', $mType, $user->id);
		break;
	}
};