<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('snc');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "guest") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(Empty($args[1])) 
		return $core->function->sendMsg("What group?", $mType, $user->id);
	
	$return = $core->function->Post("http://xat.com/web_gear/chat/BuyShortName.php","GroupName=".urlencode($args[1])."&agree=ON&Quote=Get+cost");
	
	If(Empty($return['content']) || strpos($return['content'], 'DDoS protection by CloudFlare'))
		return $core->function->sendMsg('Xat is down for maintenance or can not connect to the specified page, try again later!', $mType, $user->id);
	
	If(strpos($return['content'], '**')) {
		$return['content'] = str_replace(Array('(',')'), Array('[',']'), $return['content']);
		$return['content'] = substr($return['content'], strpos($return['content'], '**') + 2);
		$return['content'] = substr($return['content'], 0, strpos($return['content'], '**'));
		return $core->function->sendMsg(strip_tags($return['content']), $mType, $user->id);
	}
	
	preg_match('/Xats" value="([0-9].*?)"/i', $return['content'], $price);
	$core->function->sendMsg('Shortname '.$args[1].' worth '.$price[1].' xats.', $mType, $user->id);
};
