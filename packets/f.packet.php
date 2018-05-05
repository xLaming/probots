<?php
If($this->config["filters"]["friendalert"] != 0 && Isset($packet['t'])) {
	$userID = $this->function->parseUser($packet["u"]);
	$values = explode(',', $packet['t']);
	If($values[1] == 1 && Empty($this->added[$userID])) { // Added friend
		$this->function->sendMsg($this->config["friend_alert"]["yes"], 1, $userID);
		$this->added[$userID] = True;
	}
	
	If($values[1] == 2) { // Removed fiend
		$this->function->sendMsg($this->config["friend_alert"]["no"], 1, $userID);
		If(in_array($userID, $this->added))
		   unset($this->added[$userID]);
	}
}

$this->online = explode(',', $packet['v']);