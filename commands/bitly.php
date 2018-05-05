<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "mod") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(Empty($args[1]))
		return $core->function->sendMsg("Usage: !bitly [URL]", $mType, $user->id);	
	
	$json = $core->function->getFiles('http://api.bit.ly/shorten?version=2.0.1&longUrl='.urlencode($core->function->parseUrl($args[1])).'&login=mobster92&apiKey=R_9b553db4c0fc178198d972de73f39656&format=json');
	$new = $core->function->expl0de($json, '"shortUrl": "', "\"");
	
	If(Empty($new) || filter_var($new, FILTER_VALIDATE_URL) === False)
		return $core->function->sendMsg("Invalid URL.", $mType, $user->id);
	Else{
		$test = explode('/',$new);
		return $core->function->sendMsg("Your url is: {$new} | you can use on power LINK: word,{$test[3]}" , $mType, $user->id);
	}
};
