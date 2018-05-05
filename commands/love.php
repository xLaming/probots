<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('lovetest');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "guest") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$names = Array('xlaming & ana', 'ana & xlaming', 'paulo & ana', 'ana & paulo', 'laming & ana', 'ana & laming', 'lam & ana', 'ana & lam');
	$ex = explode(' & ', $args[1]);
	
	If(Empty($ex[0]) || Empty($ex[1]))
		return $core->function->sendMsg("Example: !love One & Two", $mType, $user->id);
	
	$x_1 = Array('Nothing in common!','Can\'t continue with relationship.');
	$x_20 = Array('Love is not in the air!','I don\'t really know what\'s going on.');
	$x_40 = Array('Maybe love is true!','I really believe it\'s true.');
	$x_60 = Array('Yes, yes, great, the love is true!','The perfect couple.');
	$x_80 = Array('The Almost Perfect Relationship!','Little time to get married.');
	$x_100 = Array('This is a totally perfect relationship!','Just get married.','Perfect *-*');
	
	If($percentage >= 1) 
		$phrase = $x_1[array_rand($x_1)];
	If($percentage >= 20) 
		$phrase = $x_20[array_rand($x_20)];
	If($percentage >= 40) 
		$phrase = $x_40[array_rand($x_40)];
	If($percentage >= 60) 
		$phrase = $x_60[array_rand($x_60)];
	If($percentage == 100) 
		$phrase = $x_100[array_rand($x_100)];
		
	If(!in_array(strtolower($args[1]), $names)) {
		$percentage = rand(1, 100);
		$phrase = 'Perfect marriage (L#)';
	} Else {
		$percentage = 100;
		$phrase = 'Perfect marriage (L#)';
	}
	
	$core->function->sendMsg($ex[0]." & {$ex[1]} {$percentage}% - ".$phrase, $mType, $user->id);

};
