<?php
$user = $this->function->getUser($packet["u"]);
If(!is_object($user)) { return False; }
/* Autorank Math */
If($this->config["filters"]["autorank"] == 4 && Isset($packet['s']) && !Empty($user->am_answer) && $user->am_incorrect != True) {
	If($packet['t'] != $user->am_answer) {
		@$user->am_tries++;
		If($user->am_tries >= 3) 
			$user->am_incorrect = True;
		$user->pc("Incorrect anser. You have ".(3-$user->am_tries)." attempts left.");
	} Else {
		$user->doIt('member');
		unset($user->am_answer, $user->am_tries);
	}
}
/* Commands */
If($packet["t"][0] == '/' || $packet["t"] == '!') { return False; }
If($packet["t"][0] == $this->botInfo["commandchar"] && $packet["t"] != '!' && ctype_alpha($packet["t"][1])) {
	If($this->config["filters"]["disable_cmds_pvt"] != 0 && $user->botrank != 8) { return $this->function->sendMsg("Commands on private are disabled.", (Empty($packet["s"]) ? 1 : 2), $user->id); }
	$packet["t"] = substr($packet["t"], 1);
	$args = array_map("trim", explode(chr(32), trim($packet["t"]), 2));
	$cmd = str_replace('_','',strtolower($args[0]));
	$alias = Isset($this->alias[$cmd]) ? $this->alias[$cmd] : $cmd;
	$mType = Empty($packet["s"]) ? 1 : 2;
	If(Isset($this->commands[$cmd]))
		$this->commands[$cmd]($this, $args, $packet, ($this->config['filters']['na_type'] != 1 && $this->config['filters']['na_type'] != 2 ? $mType : $this->config['filters']['na_type']), $mType, $alias, $user);
	Else
		$this->function->sendMsg("Command not found.", $mType, $user->id);
}
/* Snitch */
If($this->config["filters"]["snitch"] != 0) {
	Foreach($this->config['snitch_list'] AS $u) {
		If($u != $user->id && substr($packet['t'], 0, 1) != '/') {
			$_user = $this->function->getUser($u);
			If($_user !== False)
				$_user->pc("[".(Isset($packet['s']) ? "PC" : "PM")."] - ".($user->user ? $user->user : $user->id).": {$packet['t']}");
		}
		sleep(1);
	}
}
