<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('bot');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "main") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$args = explode(chr(32), $args[1], 2);
	
	$noRestart = Array(
		'welcome',
		'cc',
		'ticklemsg'
	);
	$strings = Array(
		'nick'        => 255,
		'avatar'      => 255,
		'status'      => 255,
		'statusglow'  => 8,
		'statuscolor' => 8,
		'commandchar' => 1,
		'nameglow'    => 8,
		'namecolor'   => 8,
		'hatcode'     => 2,
		'hatcolor'    => 8,
		'pcback'      => 255,
		'homepage'    => 255,
		'ticklemsg'   => 148,
		'welcome'     => 148
	);
	$aliases = Array(
		'name'        => 'nick',
		'nickname'    => 'nick',
		'tickle'      => 'ticklemsg',
		'autowelcome' => 'welcome',
		'cc'          => 'commandchar',
		'pic'         => 'avatar'
	);
	
	If(Empty($args[1]) || count($args) < 2)
		return $core->function->sendMsg($core->translate->__r('example')." !edit [option] [new value]", $mType, $user->id);
	
	$string = strtolower(str_replace('_', '', $args[0]));
	
	If(!Empty($aliases[$string]))
		$string = $aliases[$string];
		
	If(Empty($strings[$string]))
		return $core->function->sendMsg($core->translate->__r('option-not-found'), $mType, $user->id);
	
	If(in_array($string, Array('nick','nickname','avatar','pic','status')))
		$args[1] = str_replace(' ',' ',str_replace('<','',str_replace('>','',str_replace('##', '', $args[1]))));
		
	If(in_array($string, Array('statusglow','statuscolor','pcback','nameglow','namecolor')))
		$args[1] = str_replace('#', '', $args[1]);
		
	If(strlen($args[1]) > $strings[$string])
		return $core->function->sendMsg($core->translate->__('max-chars', Array($strings[$string])), $mType, $user->id);

	$args[1] = $core->sql->protection($args[1]);
	$core->botInfo[$string] = $args[1];
	$core->refreshBot($string);
	$core->function->sendMsg($core->translate->__('edit-sucess', Array($string, $args[1])), $mType, $user->id);
	If(!in_array($string, $noRestart))
		$core->function->restart();
};
