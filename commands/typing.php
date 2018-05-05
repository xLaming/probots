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
		return $core->function->sendMsg('Example: !typing [on/off]', $mType, $user->id);
	
	Switch(str_replace('_', '', strtolower($args[0]))){
		case 'on':
			If($core->typing == True)
				return $core->function->sendMsg('Typing is current enabled.', $mType, $user->id); 
			$core->sockets->send($core->function->createPacket('m', Array('t' => '/RTypeOn', 'u' => $core->login['i'])));
			$core->function->sendMsg('Typing enabled.', $mType, $user->id);
			$core->typing = True;
		break;
		
		case 'off':
			If($core->typing == False)
				return $core->function->sendMsg('Typing is current disabled.', $mType, $user->id);
			$core->function->sendMsg('Typing disabled.', $mType, $user->id);
			$core->sockets->send($core->function->createPacket('m', Array('t' => '/RTypeOff', 'u' => $core->login['i'])));
			$core->typing = False;
		break;
		
		default:
			$core->function->sendMsg('Example: !typing [on/off]', $mType, $user->id);
		break;
	}
};