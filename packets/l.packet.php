<?php
$user = $this->function->parseUser($packet["u"]);
If(Empty($user)) { return False; }

If(Isset($this->users[$user]))
	unset($this->users[$user]);
	
If(Isset($this->notSend[$user]))
	unset($this->notSend[$user]);