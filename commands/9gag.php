<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "mod") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$file = $core->function->getFiles("http://9gag.com/");
	preg_match_all('@<a href="/gag/(.*?)"@i', $file, $string);
	
	$test = $string[array_rand($string)];
	$choosed = $test[array_rand($test)];
	
	$core->function->sendMsg("http://9gag.com".str_replace(Array('<a href="', '"'), '', $choosed), $mType, $user->id);
};