<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "guest") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$admins = Array('xat', 'tom2', 'paulo'); // List of admins
	
	If(Empty($user->user))
		return $core->function->sendMsg('You must be registered.', ($pmm == 3 ? 1 : $pmm), $user->id);
	
	$args = @array_map('trim', explode(' ', $args[1], 3));
	If(Empty($args[0]))
		return $core->function->sendMsg("Example: !mail [read / clear / send / delete / stats / block / unblock]", $mType, $user->id);
	
	Switch(str_replace( "_", "", $args[0])) {
		case 'read':
			If(Isset($user->next_read) && $user->next_read - time() >= 1)
				return $core->function->sendMsg('You can read your messages again in '.($user->next_read - time()).' seconds.', $mType, $user->id);
			
			$mail = $core->sql->fetch_array("SELECT * FROM `mail` WHERE `user` = '{$user->id}' ORDER BY `time` DESC LIMIT 0, 10;");
			
			If(Empty($mail))
				return $core->function->sendMsg("You don't have any message.", $mType, $user->id);

			$core->sql->query("UPDATE `mail` SET `ready`= '1' WHERE `user` = '{$user->id}';");
		
			Foreach($mail AS $m) {
				$core->function->sendMsg(($m['ready'] == 0 ? "[New]" : "")."[".date("d/m/y", $m['time'])."][MID:{$m['mid']} From:{$m['sender']}]: {$m['text']} @".$m['chat'], ($pmm == 3 ? 1 : $pmm), $user->id);
				sleep(1);
			}
			$core->function->sendMsg('End of messages.', ($pmm == 3 ? 1 : $pmm), $user->id);
			$user->next_read = time() + 5;
		break;
		
		case 'send':
		case 'new':
			If(Empty($args[1]) || Empty($args[2]))
				return $core->function->sendMsg("Both fields are required to send messages!", $mType, $user->id);
		
			If(in_array(strtolower($args[1]), $admins))
				return $core->function->sendMsg("This user will not allow you to send any message.", $mType, $user->id);
		
			$id = $core->function->getID($args[1]);
		
			If(Empty($id))
				return $core->function->sendMsg("User not found/must be registered.", $mType, $user->id);
				
			If($id == $user->id)
				return $core->function->sendMsg("You can't send yourself a message.", $mType, $user->id);
		
			$check = $core->sql->fetch_array("SELECT * FROM `mailblocks` WHERE `userid` = '{$id}' AND `blocked_id` = '{$user->id}';");
			If(!Empty($check))
				return $core->function->sendMsg("This user has blocked you.", $mType, $user->id);
		
			$core->sql->query("INSERT INTO `mail` (`id`, `mid`, `sender`, `user`, `text`, `ready`, `chat`, `time`) VALUES (Null, ".rand(1,99999).", '{$user->user}', '{$id}', '{$args[2]}', '0', '{$core->roomInfo["name"]}', '".time()."');");
			$packetToSend = $core->function->createPacket('z', Array('d' => $id, 'u' => $this->login["i"], 't' => $user->user.' sent you mail, use !mail read', 's' => 2));
			$core->sockets->send($packetToSend);
			$core->function->sendMsg("Message sent!", $mType, $user->id);
		break;
		
		case "clear":
		case "empty":
			$mail = $core->sql->fetch_array("SELECT * FROM `mail` WHERE `user` = '{$user->id}' ORDER BY `time` DESC LIMIT 0, 1;");
			
			If(Empty($mail))
				return $core->function->sendMsg("You don't have any message.", $mType, $user->id);
		
			$core->sql->query("DELETE FROM `mail` WHERE `user` = '{$user->id}';");
			$core->function->sendMsg("All mail has been cleared!", $mType, $user->id);
		break;
		
		case "block":
			If(Empty($args[1]))
				return $core->function->sendMsg("What user?", $mType, $user->id);
		
			$id = $core->function->getID($args[1]);
		
			If(Empty($id))
				return $core->function->sendMsg("User not found/must be registered.", $mType, $user->id);
				
			If($id == $user->id)
				return $core->function->sendMsg("You can't block/unblock yourself.", $mType, $user->id);
		
			$check = $core->sql->fetch_array("SELECT * FROM `mailblocks` WHERE `userid` = '{$user->id}' AND `blocked_id` = '{$id}';");
		
			If(!Empty($check))
				return $core->function->sendMsg("User is already blocked.", $mType, $user->id);
		
			$core->sql->query("INSERT INTO `mailblocks` (`id`, `userid`, `blocked_id`) VALUES (NULL, '{$user->id}', '{$id}');");
			$core->function->sendMsg("User has blocked!", $mType, $user->id);
		break;
		
		case "unblock":
			If(Empty($args[1]))
				return $core->function->sendMsg("What user?", $mType, $user->id);
		
			$id = $core->function->getID($args[1]);
		
			If(Empty($id))
				return $core->function->sendMsg("User not found/must be registered.", $mType, $user->id);
				
			If($id == $user->id)
				return $core->function->sendMsg("You can't block/unblock yourself.", $mType, $user->id);
		
			$check = $core->sql->fetch_array("SELECT * FROM `mailblocks` WHERE `userid` = '{$user->id}' AND `blocked_id` = '{$id}';");
		
			If(Empty($check))
				return $core->function->sendMsg("User isn't blocked.", $mType, $user->id);
		
			$core->sql->query("DELETE FROM `mailblocks` WHERE `userid` = '{$user->id}' AND `blocked_id` = '{$id}'");
			$core->function->sendMsg("User has unblocked!", $mType, $user->id);
		break;
		
		case "stats":
			$message = $core->sql->fetch_array("SELECT * FROM `mail` WHERE `user` = '{$user->id}';");
			$new = 0;
			Foreach($message AS $m) {
				If($m['ready'] == 0)
					$new++;
			}
			If(count($message) == 0)
				return $core->function->sendMsg("You don't have any message.", $mType, $user->id);
		
			$core->function->sendMsg("You have {$new} new message/s, ".count($message)." in total.", $mType, $user->id);
		break;
		
		case "delete":
			If(Empty($args[1]) || !is_numeric($args[1]))
				return $core->function->sendMsg("TMessage id invalid.", $mType, $user->id);

			$check = $core->sql->fetch_array("SELECT * FROM `mail` WHERE `mid` = '{$args[1]}';");
		
			If(Empty($check))
				return $core->function->sendMsg("Message id not found.", $mType, $user->id);
		
			$check2 = $core->sql->fetch_array("SELECT * FROM `mail` WHERE `mid` = '{$args[1]}' AND `user` = '{$user->id}';");
		
			If(!Empty($check2)) {
				$core->sql->query("DELETE FROM `mail` WHERE `mid` = '{$args[1]}';");
				return $core->function->sendMsg("That message has been deleted!", $mType, $user->id);
			}
		
			$core->function->sendMsg("You aren't owner of that message.", $mType, $user->id);
		break;
	}
};
