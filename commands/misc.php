<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "member") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$args = explode(chr(32), $args[1], 2);
	Switch(str_replace('_','',strtolower($args[0]))) {
		case 'chatid':
			$chatid = $core->function->getFiles('http://xat.com/web_gear/chat/roomid.php?d='.$args[1]);
			If($chatid <= 0)
				return $core->function->sendMsg("Chat not found.", $mType, $user->id);
			$core->function->sendMsg("ID for chat [".ucfirst(strtolower($args[1]))."] is: ".$chatid, $mType, $user->id);
		break;
		
		case 'id':
		case 'userid':
			$userid = $core->function->getFiles('http://xat.me/web_gear/chat/profile.php?name='.$args[1]);
			If($userid <= 0 || Empty($userid))
				return $core->function->sendMsg("User not found.", $mType, $user->id);
			$core->function->sendMsg("ID for user [".ucfirst(strtolower($args[1]))."] is: ".$userid, $mType, $user->id);
		break;
		
		case 'reg':
			$_user = $core->function->getFiles('http://xat.me/web_gear/chat/profile.php?id='.$args[1]);
			If(Empty($_user))
				return $core->function->sendMsg("User not found.", $mType, $user->id);
			$core->function->sendMsg("User for ID[{$args[1]}] is: ".$_user, $mType, $user->id);
		break;
		
		default: $core->function->sendMsg("That option doesn't exist!", $mType, $user->id); break;
	}
};
