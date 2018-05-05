<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Command */
	If(strtolower($core->roomInfo["name"]) != "probot") 
		return;
		
	If(Empty($args[1]) || strlen($args[1]) < 9 || strlen($args[1]) > 13)
		return $core->function->sendMsg('Please provide a valid code.', $mType, $user->id);
	
	$bot = $core->sql->fetch_array("SELECT * FROM `accounts` WHERE `enabled` = '".str_replace(' ','',$args[1])."' AND `enabled` != '1' LIMIT 1;");
	If(!Empty($bot)) {
		If(Empty($bot[0]['chat']) && Empty($bot[0]['chat_id']))
			return $core->function->sendMsg('Please configure your chat name at your panel.', $mType, $user->id);
		If(Empty($bot[0]['botowner']))
			return $core->function->sendMsg('Please configure your id as bot owner at your panel.', $mType, $user->id);
			
		$content = $core->function->getFiles("http://xat.com/".$bot[0]['chat'].'?t'.time());
		preg_match_all('@og:url" content="(.*?)"@i', $content, $chaturl);
		preg_match_all('@xat:bot" content="(.*?)"@i', $content, $botid);
		
		If(Empty($chaturl[1][0]))
			return $core->function->sendMsg('Chat not found, you need to configure it at your panel.', $mType, $user->id);
		If($botid[1][0] != $core->login['i'])
			return $core->function->sendMsg('You need to configure the bot id '.$core->login['i'].' on your chat, Settings / Edit / Bot ID.', $mType, $user->id);
			
		$core->sql->query("UPDATE `accounts` SET `enabled` = '1', `botowner` = '{$user->id}' WHERE `id` = {$bot[0]["id"]};");
		return $core->function->sendMsg('Hey, your bot is now enabled :)', $mType, $user->id);
	} Else {
		return $core->function->sendMsg('Your code was used.', $mType, $user->id);
	}
};