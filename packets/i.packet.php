<?php
$ci = explode(';=', $packet["b"]);
$this->chatinfo = Array(
	'bg'                =>	$ci[0],
	'tabbedchat'        =>	$ci[1],
	'tabbedchatid'      =>	$ci[2],
	'lang'  	        =>	$ci[3],
	'radio'		        =>	str_replace('https://','',str_replace('http://','',$ci[4])),
	'buttons'	        =>	$ci[5],
	'botid' 	        =>	$packet["B"],
	'storemsg'    	    =>	($packet['f'] & 256 ? 0 : 1),
	'deleted'	   		=>	($packet['f'] & 33554432 ? 1 : 0),
	'memberosnly' 	    =>	($packet['f'] & 128 ? 1 : 0),
	'connected'    	    =>	time()
);

$this->login['rank'] = (Isset($packet['r']) ? $this->function->b2rank($packet['r']) : 0); // Get bot rank :p

$this->sql->query("UPDATE `accounts` SET `chatinfo` = '".json_encode($this->chatinfo)."' WHERE `id` ='{$this->botID}';");
If($this->login["i"] != $this->chatinfo["botid"])
	$this->function->trace("You need setup power bot correctly on your chat.", 4);