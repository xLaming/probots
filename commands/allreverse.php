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
		return $core->function->sendMsg('Example: !allreverse [on/off]', $mType, $user->id);
	
	Switch(str_replace('_', '', strtolower($args[0]))){
		case 'on':
			If($core->allreverse == True)
				return $core->function->sendMsg('All reverse is current enabled.', $mType, $user->id); 
			$core->function->sendMsg('All reverse enabled.', $mType, $user->id);
			$core->allreverse = True;
		break;
		
		case 'off':
			If($core->allreverse == False)
				return $core->function->sendMsg('All reverse is current disabled.', $mType, $user->id);
			$core->function->sendMsg('All reverse disabled.', $mType, $user->id);
			$core->allreverse = False;
		break;
		
		default:
			$core->function->sendMsg('Example: !allreverse [on/off]', $mType, $user->id);
		break;
	}
};