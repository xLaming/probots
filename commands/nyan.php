<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "mod") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(Empty($args[1]))
		return $core->function->sendMsg('Example: !nyan [url]', $mType, $user->id);

	$urls = Array(
		'original',
		'grumpy',
		'nyancoin',
		'gb',
		'technyancolor',
		'jazz',
		'mexinyan',
		'j5',
		'nyaninja',
		'pirate',
		'manyan',
		'elevator',
		'pikanyan',
		'zombie',
		'mummy',
		'pumpkin',
		'wtf',
		'jamaicnyan',
		'america',
		'retro',
		'vday',
		'sad',
		'tacnayn',
		'dub',
		'slomo',
		'xmas',
		'newyear',
		'fiesta',
		'easter',
		'bday',
		'daft',
		'paddy',
		'breakfast',
		'melon',
		'star',
		'balloon'
	);
	
	$newUrl = strtolower($args[1]);
	
	If(!in_array($newUrl, $urls))
		return $core->function->sendMsg('Invalid url!', $mType, $user->id);
	
	$core->function->sendMsg('http://nyan.cat/'.$newUrl.'.html', $mType, $user->id);
};