<?php
$user = $this->function->getUser($packet["u"]);
Switch(substr($packet["t"], 1, 1)) {
	case 'l':
		If(Isset($this->botInfo['ticklemsg']) && $this->botInfo['ticklemsg'] != '[off]' && @$this->ticked[$user->id] < time()) { 
			If(is_object($user)) {
				$user->pm($this->function->parseTxt($this->botInfo['ticklemsg'], $user)); 
				$this->ticked[$user->id] = time()+5;
			}
		}
		If(@$this->times['subscription'] >= time() || @$this->times['promoted'] == True || @$this->times['special'] == True) {
			$packetToSend = $this->function->createPacket('z', Array('d' => $packet["u"], 'u' => $this->login["i"], 't' => $this->function->tickleType()));
			$this->sockets->send($packetToSend);
			unset($packetToSend);
		}
		If(!is_object($user)) {
			$packetToSend = $this->function->createPacket('z', Array('d' => $packet["u"], 'u' => $this->login["i"], 't' => 'You\'ve added me, thank you! Access: PROBots.org ;)', 's' => 2));
			$this->sockets->send($packetToSend);
		}
	break;
	
	case 'a':
		If(is_object($user) && !Empty($packet['po']))
			$user->reset($packet, True);
	break;
	
	default: break;
}
