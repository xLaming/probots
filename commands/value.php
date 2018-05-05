<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "member") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$IDs = Array('paulo'); // All ids with 666 haha
	
	If(!Empty($args[1])) { // Check user
	   $_user = $core->sql->fetch_array("SELECT * FROM `users` WHERE `id` = '{$core->function->sanatize($args[1])}' OR `user` = '{$core->function->sanatize($args[1])}';");
	   If(Empty($_user))
	  	 return $core->function->sendMsg("User not found on database.", $mType, $user->id);
	} Else { // No no...
	   $_user = $core->sql->fetch_array("SELECT * FROM `users` WHERE `id` = '{$user->id}';");
	   If(Empty($_user))
	  	 return $core->function->sendMsg("You wasn't saved on database.", $mType, $user->id);
	}
	$upowers  = (Array)  json_decode($_user[0]["powers"]);
	$extra  = (Object) json_decode($_user[0]["extrapowers"]);
	$powers  = json_decode(file_get_contents($core->dir.$core->sep.'cache'.$core->sep.'powers.txt'));
	/* Cache only */
	$allpowers = Array();
	$dpowers = Array();
	$count   = 0;
	$doubles = 0;
	$xats1   = 0;
	$xats2   = 0;
	$days1   = 0;
	$days2   = 0;
	$store   = 0;
	
	/* Get power list */
	Foreach($powers AS $i => $u) {
		$u->id    = $i;
		$u->subid = pow(2, $i % 32);
		$u->sect  = $i >> 5;
		If((Isset($upowers[$u->sect]) && $upowers[$u->sect] & $u->subid) || array_key_exists($u->id, $extra)){
			If(!array_key_exists($u->id, $extra))
				$allpowers[$u->id] = Isset($extra->{$u->id}) ? $extra->{$u->id} + 1 : 1;
			$count += Isset($extra->{$u->id}) ? $extra->{$u->id} + 1 : 1;
		}
	}
	
	Foreach($allpowers AS $i => $x) {
		If($x > 1) $dpowers[$i] = $x;
	}
	
	Foreach($allpowers AS $i => $x) {
		$xats1 += $core->powers[$i]["xats1"];
		$xats2 += $core->powers[$i]["xats2"];
		$days1 += $core->powers[$i]["days1"];
		$days2 += $core->powers[$i]["days2"];
		@$store += (substr($core->powers[$i]["price"], -5) == ' days' ? (str_replace(' days','',$core->powers[$i]["price"]) * 13) : str_replace(' xats','',$core->powers[$i]["price"]));
	}
								
	Foreach($dpowers AS $i => $x) {
		$sum    = $x - 1;
		$xats1 += ($x <= 2 ? $core->powers[$i]["xats1"] : $core->powers[$i]["xats1"]*$sum);
		$xats2 += ($x <= 2 ? $core->powers[$i]["xats2"] : $core->powers[$i]["xats2"]*$sum);
		$days1 += ($x <= 2 ? $core->powers[$i]["days1"] : $core->powers[$i]["days1"]*$sum);
		$days2 += ($x <= 2 ? $core->powers[$i]["days2"] : $core->powers[$i]["days2"]*$sum);
		$test = (substr($core->powers[$i]["price"], -4) == 'days' ? (str_replace(' days','',$core->powers[$i]["price"]) * 13) : str_replace(' xats','',$core->powers[$i]["price"]));
		@$store += ($x <= 2 ? $test : $test*$sum);
		$doubles += ($x <= 2 ? 1 : $x-1);
	}
	
	$xats1 = number_format($xats1);
	$xats2 = number_format($xats2);
	$days1 = number_format($days1);
	$days2 = number_format($days2);
	$store = number_format($store);
	
	If(in_array(strtolower($_user[0]['user']), $IDs)) {
		$xats1 = number_format(666666);
		$xats2 = number_format(666666);
		$days1 = number_format(666666);
		$days2 = number_format(666666);
		$store = number_format(666666);
		$count = 666;
		$doubles = 0;
	}
	   
	unset($dpowers, $allpowers, $test, $sum); // Space only :p
	
	If($count == 0)
	   return $core->function->sendMsg("User does not have powers or days.", $mType, $user->id);
	
	$core->function->sendMsg("{$_user[0]['user']}'s have [{$count}] powers, [{$doubles}] are doubles, all worth {$xats1} - {$xats2} xats, or {$days1} - {$days2} days. Store: {$store} xats.", $mType, $user->id);
};