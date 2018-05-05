<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "owner") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$args = explode(chr(32), $args[1], 2);
	Switch(strtolower(str_replace('_','',$args[0]))) {
		case 'reverse':
			If(Empty($args[1]))
				return $core->function->sendMsg("What message?", $mType, $user->id);
			$core->function->sendMsg(strrev($args[1]), $mType, $user->id);
		break;
		
		case 'mix':
			If(Empty($args[1]))
				return $core->function->sendMsg("What message?", $mType, $user->id);
			$msg = explode(' ', $args[1]);
			$word = '';
			Foreach($msg AS $mc)
				$word .= str_shuffle($mc).' ';
			$core->function->sendMsg($word, $mType, $user->id);
		break;
		
		case 'ends':
			If(Empty($args[1]))
				return $core->function->sendMsg("What message?", $mType, $user->id);
			$msg = explode(' ', $args[1]);
			$word = '';
			Foreach($msg AS $mc) {
				$first = $mc[0];
				$last  = substr($mc, -1);
				$word .= $last.substr($mc, 1, strlen($mc) -2).$first.' ';
			}
			$core->function->sendMsg($word, $mType, $user->id);
		break;
		
		case 'middle':
			If(Empty($args[1]))
				return $core->function->sendMsg("What message?", $mType, $user->id);
			$msg = explode(' ', $args[1]);
			$word = '';
			Foreach($msg AS $mc) {
				$first = $mc[0];
				$last  = substr($mc, -1);
				$word .= $first.str_shuffle(substr($mc, 1, strlen($mc) -2)).$last.' ';
			}
			$core->function->sendMsg($word, $mType, $user->id);
		break;
		
		default: $core->function->sendMsg("That option doesn't exist!", $mType, $user->id); break;
	}
};