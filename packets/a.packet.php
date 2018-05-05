<?php
// Gifts[LATER]:  <a u="956544769" k="Gifts" t="PAULO (956544769) has bought icLeon (15551996)  a card" b="15551996"  />
Switch($packet["k"]) {
	case 'T':
		$amount = (Int) $packet['x'] + ($packet['s'] * 14);
		$userID = $this->function->parseUser($packet['u']);
		$bought = ($amount % $this->settings['time_price'] == 0 ? strtotime("+ " . ($amount / $this->settings['time_price']) . " months") : strtotime("+ " . ($amount * $this->settings['hour_price']) . " hours")) - time();
		$newtime = $this->times["subscription"] > time() ? $this->times["subscription"] - time() : 0;		
		$count = $bought+$newtime;
		$this->function->sendMsg("User ({$userID}) bought {$this->function->stotime($count)} for bot currently on here.");
		$this->sql->query("UPDATE `accounts` SET `freezed`= '{$count}' WHERE `id` = '{$this->botID}';");
		$this->sql->query("INSERT INTO `transfer` (`index`, `userid`, `xats`, `days`, `text`, `time`) VALUES (NULL, '{$userID}', '{$packet['x']}', '{$packet['s']}', '{$packet['t']}', '".time()."');");
		$this->sockets->shutdown();
		$this->sockets->connect();
		$this->joinRoom($this->roomInfo["id"], True);
	break;
	
	default: break;
}