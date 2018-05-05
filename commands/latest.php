<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('latestpower');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "guest") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$json = json_decode(file_get_contents($core->dir.$core->sep.'cache'.$core->sep.'pow2.txt'), True);

	/* Cache */
	$sm = Array();
	$ht = Array();
	$hh = Array();

	/* Get Smilies */
	Foreach($json[4][1] AS $s => $id)
		@$sm[$id] .= "{$s}, ";
	/* Get Hats */
	Foreach($json[7][1] AS $h => $id)
		@$ht[$id[0]] .= "h{$h}, ";
	/* Get Hugs */
	Foreach($json[3][1] AS $h => $id)
		@$hh[$id] .= "{$h}, ";
	
	/* Vars */
	$info  = Array(
		'pid'     => $json[0][1]["id"],
		'name'    => array_search($json[0][1]["id"], $json[6][1]),
		'smilies' => Isset($sm[$json[0][1]["id"]]) ? substr($sm[$json[0][1]["id"]], 0, -2) : 'No',
		'hats'    => Isset($ht[$json[0][1]["id"]]) ? substr($ht[$json[0][1]["id"]], 0, -2) : 'No',
		'type'    => in_array($json[0][1]["id"], $json[5][1]) ? 'Group power' : 'User power',
		'price'   => Isset($core->powers[$json[0][1]["id"]]) ? $core->powers[$json[0][1]["id"]]['price'] : 'Not released yet',
		'status'  => $json[0][1]["text"] == '[LIMITED]' ? 'Limited' : 'Unlimited',
	);

	$core->function->sendMsg(ucfirst($info['name'])."[{$info['pid']}]: Smilies: {$info['smilies']}. Hats: {$info['hats']}. {$info['status']} - {$info['type']}. Price: {$info['price']}.", $mType, $user->id);
};