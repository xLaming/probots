<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "member") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$args = @explode(chr(32), $args[1], 2);

	If(Empty($args[0])) 
		return;
	
	$ranks = Array(0 => 'guest', 1 => 'member', 2 => 'moderator', 3 => 'owner', 4 => 'mainowner', 5 => 'trusted', 6 => 'botowner', 7 => 'helper', 8 => 'admin');
	
	$toSend = Array(
		'cmd'   => @$args[0],
		'text'  => @$args[1],
		'uid'   => $user->id,
		'uname' => $user->user,
		'uav'   => $user->avatar,
		'uhome' => $user->home,
		'cname' => $core->roomInfo["name"],
		'rank'  => $ranks[$user->botrank],
		'type'  => $pmm
	);
	
	$info = $core->function->Post($core->botInfo["ecmd_url"],"recv=".base64_encode(json_encode($toSend)));
	$xInf = json_decode(base64_decode($info["content"]), True);
	
	If($info["status"] != True)
		return $core->function->sendMsg('Website offline or script not uploaded!', $mType, $user->id);
	If($xInf['PBauth'] != 'yes')
		return $core->function->sendMsg('Authentication invalid.', $mType, $user->id);
	If(Empty($xInf['text'])) 
		return;
	If(is_numeric($xInf['uid']) && ($xInf['type'] == 1 || $xInf['type'] == 2))
		return $core->function->sendMsg($xInf['text'], $xInf['type'], $xInf['uid']);
	Else 
		return $core->function->sendMsg($xInf['text'], $mType, $user->id);
};