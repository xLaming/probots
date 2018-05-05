<?php
class User {
	public $parent, $function;
	public $d0, $d2, $botrank;
	public $po, $pInfo, $powers=Array();
	public $id, $nick, $avatar, $home, $user;
	public $away, $banned, $sinbined, $forever;
	public $am_tries, $am_answer, $am_incorrect;
	public $null, $sub, $rank, $f, $active, $next_read;
	public $dunced, $muted, $yellow, $naughty, $redcard, $badge;
	
	public function __construct($packet, &$parent, &$function) {
		$this->parent = $parent;
		$this->function = $function;
		/* Check if it's null user */
		If(Empty($packet['n']) && Empty($packet['a']) && Empty($packet['h']))
			return $this->null = True;
		If(Empty($packet['q']) && Empty($packet['n']))
			return $this->null = True;
		/* Information */
		$nValue         = explode("##", $packet["n"], 2);
		$this->id       = Isset($packet["u"]) ? $packet["u"] : '';
		$this->nick     = Isset($nValue[0]) ? $nValue[0] : '';
		$this->avatar   = Isset($packet["a"]) ? $packet["a"] : '';
		$this->status   = Isset($nValue[1]) ? $nValue[1] : '';
		$this->home     = Isset($packet["h"]) ? $packet["h"] : '';
		$this->user     = Isset($packet["N"]) ? $packet["N"] : '';
		$this->d0       = Isset($packet["d0"]) ? $packet["d0"] : '';
		$this->d2       = Isset($packet["d2"]) ? $packet["d2"] : '';
		$this->f        = Isset($packet["f"]) ? $this->function->f2rank($packet["f"]) : 0;
		$this->rank     = Isset($packet["f"]) ? $this->function->f2rankName($packet["f"]) : 'Guest';
		$this->sub      = Isset($packet['q']) && ($packet['q'] & 2) ? True : False;
		$this->away     = Isset($packet['f']) && $packet['f'] & 16384 ? True : False;
		$this->banned   = Isset($packet['f']) && $packet['f'] & 16 ? True : False;
		$this->sinbined = Isset($packet['f']) && $packet['f'] & 512 ? True : False;
		$this->forever  = Isset($packet['f']) && $packet['f'] & 64 ? True : False;
		$this->dunced   = Isset($packet['f']) && $packet['f'] & 0x8000 ? True : False;
		$this->muted    = Isset($packet['f']) && $packet['f'] & 256 ? True : False;
		$this->yellow   = Isset($packet['f']) && $packet['f'] & 1048576 ? True : False;
		$this->naughty  = Isset($packet['f']) && $packet['f'] & 524288 ? True : False;
		$this->redcard  = Isset($packet['f']) && $packet['f'] & 2097152 ? True : False;
		$this->badge    = Isset($packet['f']) && $packet['f'] & 262144 ? True : False;
		$this->active   = time();
		/* Load user powers */
		For($i=0; $i <= $this->parent->sections; $i++) {
			$sect = Isset($packet["p{$i}"]) ? $packet["p{$i}"] : False;
			$this->pInfo[$i] = $sect ? $sect : 0;
		}
		$this->getPowers();
		/* Autorank*/
		$this->autorank();
		/* Save user cache */
		If(!Empty($this->user)) {
			$user = $this->parent->sql->fetch_array("SELECT * FROM `users` WHERE `id` = '{$this->id}';");
			If(Empty($user)) {
				$this->parent->sql->query("INSERT INTO `users` (`idx`, `id`, `user`, `avatar`, `home`, `nick`, `status`, `powers`, `extrapowers`, `lastseen`, `d0`, `d2`, `optout`) VALUES (
				'Null',
				'{$this->id}', 
				'{$this->user}', 
				'{$this->avatar}', 
				'{$this->home}', 
				'{$this->nick}', 
				'{$this->status}', 
				'".json_encode($this->pInfo)."', 
				'', 
				'".json_encode(Array('time' => time(), 'chatname' => $this->parent->roomInfo["name"], 'chatid' => $this->parent->roomInfo["id"]))."', 
				'{$this->d0}', 
				'{$this->d2}',
				'0');");
			} Else {
				$this->parent->sql->query("UPDATE `users` SET 
					`user` = '{$this->user}',
					`avatar` = '{$this->avatar}',
					`home` = '{$this->home}',
					`nick` = '{$this->nick}',
					`status` = '{$this->status}',
					`powers` = '".json_encode($this->pInfo)."',
					`lastseen` = '".json_encode(Array('time' => time(), 'chatname' => $this->parent->roomInfo["name"], 'chatid' => $this->parent->roomInfo["id"]))."',
					`d0` = '{$this->d0}',
					`d2` = '{$this->d2}'
				WHERE `id` = '{$this->id}';");
			}
		}
		/* Autowelcome */
		If(!in_array($this->id, $this->parent->notSend) && $this->parent->done == True && !Empty($this->parent->botInfo["welcome"]) && $this->parent->botInfo["welcome"] != '[off]') {
			$this->function->sendMsg($this->function->parseTxt($this->parent->botInfo["welcome"], $this), ($this->parent->config['filters']['welcome_type'] > 1 ? 2 : 1), $this->id);
			/* Mail System */
			$mail = $this->parent->sql->fetch_array("SELECT count(*) FROM `mail` WHERE `user` = '{$this->id}' AND `ready` = '0';");
			If($mail[0]["count(*)"] > 0) {
				sleep(1);
				$this->function->sendMsg("You have {$mail[0]["count(*)"]} new messages, use !mail read.", 1, $this->id);
			}
			$this->parent->notSend[$this->id] = $this->id;
		}
		/* Select Bot Rank */
		If($this->function->minrank($this->id, $this->f, 'admin') == True)
			$this->botrank = 8;
		Else If($this->function->minrank($this->id, $this->f, 'helper') == True)
			$this->botrank = 7;
		Else If($this->function->minrank($this->id, $this->f, 'botowner') == True)
			$this->botrank = 6;
		Else If($this->function->minrank($this->id, $this->f, 'trusted') == True)
			$this->botrank = 5;
		Else
			$this->botrank = $this->f;
	}
	
	public function pm($message) {
		If(Empty($message))
			return False;
		$this->function->sendMsg($message, 1, $this->id);
	}
	
	public function pc($message) {
		If(Empty($message))
			return False;
		$this->function->sendMsg($message, 2, $this->id);
	}
	
	public function autorank() {
		If($this->parent->done && $this->f == 0) {
			Switch($this->parent->config['filters']['autorank']) {
				case 1: // All
					$this->doIt('member');
				break;

				case 2: // Registered
					If($this->user == False) { return; }
					$this->doIt('member');
				break;

				case 2: // Subscribers
					If($this->sub == False) { return; }
					$this->doIt('member');
				break;

				case 4: // Math
					$sum_a = rand(1,10); 
					$sum_b = rand(1,10);
					$this->am_answer = $sum_a+$sum_b;
					$this->pc("To become a member, what the result of {$sum_a} + {$sum_b}?");
				break;

				case 5: // No toon
					If(in_array(strtolower($this->nick), $this->parent->xnDefault)) { return; }
					$this->doIt('member');
				break;

				default: break;
			}
		}
	}
	
	public function reset($packet, $powers=False) {
		If(False === $powers) {	
			$nValue         = explode("##", $packet["n"], 2);
			$this->nick     = Isset($nValue[0]) ? $nValue[0] : '';
			$this->avatar   = Isset($packet["a"]) ? $packet["a"] : '';
			$this->status   = Isset($nValue[1]) ? $nValue[1] : '';
			$this->home     = Isset($packet["h"]) ? $packet["h"] : '';
			$this->user     = Isset($packet["N"]) ? $packet["N"] : '';
			$this->f        = Isset($packet["f"]) ? $this->function->f2rank($packet["f"]) : 0;
			$this->rank     = Isset($packet["f"]) ? $this->function->f2rankName($packet["f"]) : 'Guest';
			$this->away     = Isset($packet['f']) && $packet['f'] & 16384 ? True : False;
		}
		/* Load user powers */
		For($i=0; $i <= $this->parent->sections; $i++) {
			$sect = Isset($packet["p{$i}"]) ? $packet["p{$i}"] : False;
			$this->pInfo[$i] = $sect ? $sect : 0;
		}
		$extra = @$this->getPowers($packet['po']);;
		/* Update user cache */
		If(Empty($this->user)) { return False; }
		$this->parent->sql->query("UPDATE `users` SET 
			`user` = '{$this->user}',
			`avatar` = '{$this->avatar}',
			`home` = '{$this->home}',
			`nick` = '{$this->nick}',
			`status` = '{$this->status}',
			`powers` = '".json_encode($this->pInfo)."',
			`extrapowers` = '".json_encode($extra)."',
			`lastseen` = '".json_encode(Array('time' => time(), 'chatname' => $this->parent->roomInfo["name"], 'chatid' => $this->parent->roomInfo["id"]))."',
			`d0` = '{$this->d0}',
			`d2` = '{$this->d2}'
		WHERE `id` = '{$this->id}';");
	}
	
	public function temp($type, $time=0, $packets=Array()) {
		/* Errors:
		  @return 1 = rank not found
		*/
		$t = strtolower($type);
		Switch($t) {
			/* Ranks */
			case 'tempown':
			case 'tempmod':
			case 'tempmem': // @type, @userid, @time
				$ranks = Array("tempmem" => "/mb", "tempmod" => "/m", "tempown" => "/mo");
				If(!Isset($ranks[$t])) 
					return 1;
				$packets['u'] = $this->id;
				$packets['t'] = $ranks[$t].$time;
				$packets['s'] = 2;
				$packets['d'] = $this->parent->login['i'];
				$send = $this->function->createPacket('p', $packets);
				$this->parent->sockets->send($send);
			break;			
			default: break;
		}
	}
	
	public function doIt($type, $reason='', $time=0, $chat='', $packets=Array()) {
		/* Errors:
		  @return 1 = chat not indentified
		  @return 2 = rank not found
		  @return 3 = it's not banned
		*/
		$t = strtolower($type);
		Switch($t) {
			/* Kick/Bans */
			case 'kick': // @reason, @userid
				If(Isset($reason)) 
					$packets['p'] = $reason;
				$packets['u'] = $this->id;
				$packets['t'] = '/k';
				$send = $this->function->createPacket('c', $packets);
				$this->parent->sockets->send($send);
			break;
			
			case 'zap': // @reason, @userid
				$packets['p'] = (Isset($reason) ? $reason."#laserfire3" : "#laserfire3");
				$packets['u'] = $this->id;
				$packets['t'] = '/k';
				$send = $this->function->createPacket('c', $packets);
				$this->parent->sockets->send($send);
			break;
			
			case 'boot': // @chat, @reason, @userid
				If(!Isset($chat)) 
					return 1;
				$packets['p'] = (Isset($reason) ? $reason . "#" . $chat : "#" . $chat);
				$packets['u'] = $this->id;
				$packets['t'] = '/k';
				$send = $this->function->createPacket('c', $packets);
				$this->parent->sockets->send($send);
			break;
			
			case 'ban': // @reason, @userid, @time
				If($this->banned == True)
					return 3;
				If(Isset($reason))
					$packets['p'] = $reason;
				$packets['u'] = $this->id;
				$packets['t'] = ($time > 0 ? '/g'.@ceil($time * 3600) : '/g0');
				$send = $this->function->createPacket('c', $packets);
				$this->parent->sockets->send($send);
			break;
			
			case 'gag': // @reason, @userid, @time
				If($this->gagged == True)
					return 3;
				If(Isset($reason)) 
					$packets['p'] = $reason;
				$packets['u'] = $this->id;
				$packets['t'] = ($time > 0 ? '/gg'.@ceil($time * 3600) : '/g0');
				$send = $this->function->createPacket('c', $packets);
				$this->parent->sockets->send($send);
			break;
			
			case 'mute': // @reason, @userid, @time
				If($this->muted == True)
					return 3;
				If(Isset($reason)) 
					$packets['p'] = $reason;
				$packets['u'] = $this->id;
				$packets['t'] = ($time > 0 ? '/gm'.@ceil($time * 3600) : '/g0');
				$send = $this->function->createPacket('c', $packets);
				$this->parent->sockets->send($send);
			break;
			
			case 'yellowcard': // @reason, @userid
				If($this->yellow == True)
					return 3;
				If(Isset($reason)) 
					$packets['p'] = $reason;
				$packets['u'] = $this->id;
				$packets['t'] = '/gy3600';
				$send = $this->function->createPacket('c', $packets);
				$this->parent->sockets->send($send);
			break;
			
			case 'naughtystep': // @reason, @userid
				If($this->naughty == True)
					return 3;
				If(Isset($reason)) 
					$packets['p'] = $reason;
				$packets['u'] = $this->id;
				$packets['t'] = '/gn3600';
				$send = $this->function->createPacket('c', $packets);
				$this->parent->sockets->send($send);
			break;
			
			case 'dunce': // @reason, @userid
				If($this->dunced == True)
					return 3;
				If(Isset($reason)) 
					$packets['p'] = $reason;
				$packets['u'] = $this->id;
				$packets['t'] = '/gd3600';
				$send = $this->function->createPacket('c', $packets);
				$this->parent->sockets->send($send);
			break;
			
			case 'badge': // @reason, @userid
				If($this->badge == True)
					return 3;
				$packets['u'] = $this->id;
				$packets['t'] = (Isset($reason) ? '/nb'.$reason : '/nb');
				$send = $this->function->createPacket('c', $packets);
				$this->parent->sockets->send($send);
			break;
			
			/* Ranks */
			case 'owner':
			case 'moderator':
			case 'mod': // @type, @userid
			case 'member':
			case 'guest':
				$ranks = Array("guest" => "r", "member" => "e", "moderator" => "m", "mod" => "m", "owner" => "M");
				If(!Isset($ranks[$t])) 
					return 2;
				$packets['u'] = $this->id;
				$packets['t'] = '/'.$ranks[$t];
				$send = $this->function->createPacket('c', $packets);
				$this->parent->sockets->send($send);
			break;
			
			/* Unban/sinbin */
			case 'unban': // @userid
				$packets['u'] = $this->id;
				$packets['t'] = '/u';
				$send = $this->function->createPacket('c', $packets);
				$this->parent->sockets->send($send);
			break;
			
			case 'sinbin': // @userid, @time
				If($this->sinbined == True)
					return 3;
				$packets['u'] = $this->id;
				$packets['t'] = ($time > 0 ? '/n'.@ceil($time * 3600) : '/g3600');
				$packets['s'] = 2;
				$packets['d'] = $this->parent->login['i'];
				$send = $this->function->createPacket('p', $packets);
				$this->parent->sockets->send($send);
			break;
			
			default: break;
		}
	}
	
	public function getPowers($po='', $extra=Array())
	{
		If(!Empty($po)) {
			$extras = explode('|', $po);
			Foreach($extras AS $v => $p) {
				If(!Empty($p)) {
					$pid = is_numeric(strpos($p, '=')) ? substr($p, 0, strpos($p, '=')) : $p;
					$pam = is_numeric(strpos($p, '=')) ? substr($p, strpos($p, '=') + 1) : 1;
					$extra[$pid] = $pam;
				}
			}
		}
		Foreach($this->parent->powers AS $p) {
			$sect = $this->pInfo[$p['section']];
			If($sect & $p['subid'] || Isset($extra[$p['id']]))
				$this->powers[$p['name']] = Isset($extra[$p['id']]) ? $extra[$p['id']] + 1 : 1;
		}
		return $extra;
	}
}
?>