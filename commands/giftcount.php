<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "member") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(Empty($args[1]))
		return $core->function->sendMsg("What user?", $mType, $user->id);
	
	$id = $core->function->getID($args[1]);
	
	If(Empty($id))
		return $core->function->sendMsg("User not found.", $mType, $user->id);
	
	$file = $core->function->getFiles("http://xat.com/web_gear/chat/gifts.php?id=".$id);
	$j = json_decode($file, True);

	If(Empty($file) || $file == 'No gifts.')
		return $core->function->sendMsg("User has no gifts.", $mType, $user->id);

	$total   = 0;
	$private = 0;

	Foreach($j AS $v) {
		If(Isset($v["id"])) {
			++$total;
			If(Empty($v["m"]))
				++$private;
		}
	}
	
	If($private == $total)
		return $core->function->sendMsg("All gifts user have are private.", $mType, $iser->id);
	Else
		return $core->function->sendMsg("User has {$total} gifts, and {$private} are private.", $mType, $user->id);
};