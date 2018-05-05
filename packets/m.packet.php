<?php
If($packet["t"][0] == '/' || @$packet["u"] == $this->login['i']) { return False; }
If($this->done == True) {
	/* Not load old messages */
	If(Isset($packet['i']) && $packet['i'] > 0) { return False; }
	
	/* Get User */
	$user = $this->function->getUser($packet["u"]);
	If(!is_object($user)) { return False; }
	
	/* Filter All */
	$this->function->filterSystem($packet);
	
	/* Debug ONLY */
	$this->function->latestU = $user->id;
	
	/* Direct Lightshot */
	If($this->config['filters']['directLightshot'] != 0 && Isset($packet['l'])) { 
		preg_match('/prntscr.com\/([^ ]++)/', $packet['t'], $url);
		If(Isset($url[1]))
			return $this->function->sendMsg("Direct link to prntscr: http://prntscr.com/{$url[1]}/direct");
	}
	
	/* Resend Guest Links */
	If($this->config['filters']['guestLinks'] != 0 && Isset($packet['l']) && $user->f == 0) { 
		preg_match_all('/(http(s)?\:\/\/)?([A-z0-9_]+)\.([a-z.]{2,}+)([^\s]+)?/i', $packet["t"], $urlFinal);
		If(Isset($urlFinal[0][0]))      
			return $this->function->sendMsg("Guest User(" . $this->function->parseUser($packet["u"]) . ") sent url: {$urlFinal[0][0]}");
	}
	
	/* Commands */
	If($packet["t"][0] == $this->botInfo["commandchar"] && $packet["t"] != '!' && (ctype_alpha($packet["t"][1]) || is_numeric($packet["t"][1]))) {
		$packet["t"] = substr($packet["t"], 1);		
		$args = array_map("trim", explode(chr(32), trim($packet["t"]), 2));
		$cmd = str_replace('_','',strtolower($args[0]));
		$alias = Isset($this->alias[$cmd]) ? $this->alias[$cmd] : $cmd;
		If(Isset($this->commands[$cmd]))
			return $this->commands[$cmd]($this, $args, $packet, ($this->config['filters']['na_type'] != 1 && $this->config['filters']['na_type'] != 2 ? 3 : $this->config['filters']['na_type']), 3, $alias, $user);
		Else If(Isset($this->customs[$cmd]))
			return $this->function->sendMsg($this->customs[$cmd]);
		Else
			return $this->function->sendMsg("Command not found.");
	}
	
	/* Responses */
	Foreach($this->responses AS $w => $r) {
		If(is_numeric(stripos($packet['t'], $w))) {
			Foreach(explode(' ', $packet['t']) AS $t) {
				If(substr($r, 0, 4) == 'cmd_') { // With command
					$t = substr($r, 4);
					$args = array_map("trim", explode(chr(32), trim($t), 2));
					$cmd = str_replace('_','',$args[0]);
					$alias = Isset($this->alias[$cmd]) ? $this->alias[$cmd] : $cmd;
					If(Isset($this->commands[$cmd]))
						return $this->commands[$cmd]($this, $args, $packet, ($this->config['filters']['na_type'] != 1 && $this->config['filters']['na_type'] != 2 ? 3 : $this->config['filters']['na_type']), 3, $alias, $user);
				} Else { // Normal
					return $this->function->sendMsg($this->function->parseTxt($r, $user));
				}
			}
		}
	}
}