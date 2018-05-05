<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "member") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$fml = $core->function->expl0de($core->function->getFiles('http://www.fmylife.com/'), 'class="fmllink">', 'FML</a>');
	$xx = explode(" ", htmlspecialchars_decode($fml));
	
	$test = '';
	$c = 0;
	
	Foreach($xx AS $f) {
		If(!Empty($f)) {
			$c = $c+1;
			$test .= $f.' ';
			If($c == 21) {
				$test .= "<!--LINE--!>";
				$c=0;
			}
		}
	}
	
	$repeat = explode("<!--LINE--!>", $test);
	
	Foreach($repeat AS $i => $rep) {
		$core->function->sendMsg($rep, $mType, $user->id);
		$i++;
		sleep(1);
	}
	unset($c, $test);
};
