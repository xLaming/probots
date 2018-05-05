<?php
class Functions {
	public $parent;
	public $latestU;
	public $kickToBan = Array();
	public $usersFlood = Array();
	
	public function __construct(&$parent) {
		$this->parent = $parent;
	}
	
	public function getFiles($url,$ssl=False) {
		$curl = curl_init($url);
		$request_headers = Array();
		$request_headers[] = 'User-Agent: Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_8; pt-pt) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27';
		$request_headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
		curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
		If($ssl != False)
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 3);
		$current = curl_exec($curl);
		curl_close($curl);
		return $current;
	}
	
	public function Post($url, $values) {
		$info = Array();
		$agent = "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_8; pt-pt) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt($ch, CURLOPT_POST, True);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $values);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 4);
		$info["content"] = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$info["status"] = $httpcode >= 200 && $httpcode < 300 ? True : False;
		return $info;
	}
	
	public function restart() {
		$packetToSend = $this->createPacket('l', Array('u' => $this->parent->login["i"]));
		$this->parent->sockets->send($packetToSend);
		$this->parent->sockets->shutdown();
		$this->parent->sockets->connect();
		$this->parent->joinRoom($this->parent->roomInfo["id"], False);
		unset($this->parent->gameVar);
		$this->parent->gameRunning = False;
		$this->parent->away = False;
		$this->parent->typing = False;
	}
	
	public function expl0de($input, $first, $second) {
		$start = @stripos($input, $first ) + strlen($first);
		$end = @stripos($input, $second, $start);
		return @substr($input, $start, $end - $start);
	}
	
	public function createPacket($type, $values) {
		$xml = Array();
		Foreach($values AS $n => $v) {
			If($v !== False)
				$xml[] = "{$n}=\"{$this->sanatize($v)}\"";
		}
		return "<{$type} ".implode(chr(32), $xml)." />";
	}
	
	public function stotime($seconds, $final='') {
		$days = intval(intval($seconds) / (3600*24));
		If($days > 0) $final .= $days." days ";
		
		$hours = (intval($seconds) / 3600) % 24;
		If($hours > 0) $final .= $hours." hours ";
		
		$minutes = (intval($seconds) / 60) % 60;
		If($minutes > 0) $final .= $minutes." minutes ";
		
		$seconds = intval($seconds) % 60;
		If($seconds > 0) $final .= $seconds." seconds";
		
		return $final;
	}
	
	public function sendMsg($message, $v=3, $to=0) {

		$type = $this->parent->config["filters"]["stfu"] > 0 ? 1 : $v; // Only work if na_type is disabled

		If($this->parent->allreverse == True)
			$message = strrev($message);
		
		$this->latestU = 0;
		
		$message = $this->replaceInapp($message, $this->parent->config['badwords']);
		$message = str_replace(Array("\'", '\"'), Array("'", '"'), $message);
		
		If($v == 1 || $v == 2)
			$to = $this->parseUser($to);

		Switch($type) {
			case 1: // PM
				If(Empty($to)) { return False; }
				$packetToSend = $this->createPacket('p', Array('u' => $to, 't' => '_'.$message));
				$this->parent->sockets->send($packetToSend);
			break;
			
			case 2: // PVT
				If(Empty($to)) { return False; }
				$packetToSend = $this->createPacket('p', Array('u' => $to, 't' => '_'.$message, 's' => 2, 'd' => $this->parent->login['i']));
				$this->parent->sockets->send($packetToSend);
			break;
			
			case 3: // MAIN
				$packetToSend = $this->createPacket('m', Array('t' => '_'.$message, 'u' => $this->parent->login['i']));
				$this->parent->sockets->send($packetToSend);
			break;
		}
	}
	
	public function replaceInapp($str, $censored=Array()) {
		$censored = (Array)$censored;
		return preg_replace_callback('/' . implode('|', $censored) . '/i',function ($r) {
			return substr($r[0], 0, 1).str_repeat('*', strlen($r[0])-1);
		},$str);
	}
	
	public function parseUrl($url) {
		If(!preg_match("~^(?:f|ht)tps?://~i", $url))
			$url = "http://".$url;
		return $url;
	}
	
	public function getPort() {
		If($this->parent->roomInfo["id"] < 8)
			$port = 10000 - 1 + $this->parent->roomInfo["id"];  
		Else
			$port = 10000 + 7 + ($this->parent->roomInfo["id"] % 32);
		#OLD HAHA return $port
		return 80;
	}
	
	public function getIP() {
		/*I FORGOT BLA BLA... 
		If($this->parent->roomInfo["id"] < 8)
			$ip = 3;
		Else
			$ip = ($this->parent->roomInfo["id"] & 96)>>5;*/
		return 'fwdelb01-1365137239.us-east-1.elb.amazonaws.com';
	}
	
	public function sanatize($var) {
		$string = htmlspecialchars($var);
		$string = str_replace(Array("\t", "\n", "\r", "\0", "\x0B"), "", $string);
		return $string;
	}
	
	public function getID($var) {
		If(is_numeric($var)) {
			$check = $this->getFiles('http://xat.me/web_gear/chat/profile.php?id='.$var);
			If(Empty($check))
				return False;
			$id = $var;
		} Else {
			$check = $this->getFiles('http://xat.me/web_gear/chat/profile.php?name='.$var);
			If($check <= 0 || Empty($check))
				return False;
			$id = $check;
		}
		return $id;
	}
	
	public function f2rank($f) {
		$f = $this->parseRank($f);
		If($f == -1) 
			return 0; // Guest
		If((16 & $f)) 
			return -1; // Banned
		If((1 & $f) && (2 & $f)) 
			return 1; // Member
		If((2 & $f) && !(1 & $f)) 
			return 2; // Moderator
		If((4 & $f)) 
			return 3; // Owner
		If((32 & $f) && (1 & $f) && !(2 & $f)) 
			return 4; // Main Owner
		If(1 & $f) 
			return 4; // Main Owner
		return 0; // Guest
	}
	
	public function b2rank($f) {
		if(($f & 7) == 1) 
			return  4; // Main Owner
		if(($f & 7) == 2) 
			return  2; // Moderator
		if(($f & 7) == 3)
			return  1; // Member
		if(($f & 7) == 4) 
			return  3; // Owner
		if($f & 16)       
			return -1; // Banned     
		return  0; // Guest
	}
	
	public function f2rankName($f) {
		$f = $this->parseRank($f);
		If($f == -1) 
			return 'Guest';
		If((16 & $f)) 
			return 'Banned';
		If((1 & $f) && (2 & $f)) 
			return 'Member';
		If((2 & $f) && !(1 & $f)) 
			return 'Moderator';
		If((4 & $f)) 
			return 'Owner';
		If((32 & $f) && (1 & $f) && !(2 & $f)) 
			return 'Main Owner';
		If(1 & $f) 
			return 'Main Owner';
		return 'Guest';
	}
	
	public function protection($old) {
		$data = htmlspecialchars($old);
		$data = str_replace(Array("\t", "\n", "\r", "\0", "\x0B"), "", $data);
		return $data;
	}
	
	public function restartBot($packets=Array()) {
		$packets['u'] = $this->parent->login['i'];
		$send = $this->createPacket('l', $packets);
		$this->parent->sockets->send($send);
		exec("nohup php {$this->parent->cmdFolder} \"{$this->parent->botID}\" 0 > /dev/null 2>&1 &");
		die();
	}
	
	public function filterSystem($xml) {
		$user = $this->getUser($xml['u']);
		If(!is_object($user)) { return False; }
		If($this->checkRank($user->f) == False) { return False; }
		If($user->id == $this->parent->botInfo['botowner'] || in_array($user->id, $this->parent->config["allowedlist"]) || in_array($user->id, $this->parent->config["trusted"])) { return False; }
		If($this->parent->botInfo["mod_status"] == 0) { return False; }
		/* CAPS LOCK */
		If($this->parent->config["moderation"]["capsLockDetect"] != 0) {
			$text = trim(@preg_replace('/\s*\([^)]*\)/', '', $xml['t']));
			If(preg_match_all('/\b[A-Z]+\b/', $text, $lamingaum) > $this->parent->config["moderation"]["capsLockMax"])
				$reason = "You can't use more than {$this->parent->config["moderation"]["capsLockMax"]} letters with Caps Lock.";
			unset($text);
		}
		/* Flood */
		If($this->parent->config["moderation"]["floodDetect"] != 0) {
			If($this->latestU != $user->id)
				unset($this->usersFlood);
			If(substr($xml['t'], 0, 1) != '/') {
				If(!Isset($this->usersFlood[$user->id]))
					$this->usersFlood[$user->id] = 0;
				@$this->usersFlood[$user->id]++;
				If($this->usersFlood[$user->id] > $this->parent->config["moderation"]["linesMax"]) {
					$this->usersFlood[$user->id] = 0;
					$reason = "You can't flood the chat.";
				}
			}
		}
		/* Spam */
		If($this->parent->config["moderation"]["spamDetect"] != 0) {
			$text = trim(@preg_replace('/\s*\([^)]*\)/', '', $xml['t']));
			Foreach(explode(' ',trim($text)) AS $word) {
				$word = strtolower($word);
				$word = str_replace(Array('-',' ',' ','=','+','*','~','.',',','?','!','|','&','%','[',']','{','}','k'), '', $word); // Whitelist
				If($word!='') {
					If(preg_match('~(.)\1{'.$this->parent->config["moderation"]["maxLetters"].',}~', $word)) //$reason = "You can't spam the chat({$word}).";
						$reason = "You can't spam the chat, max consecutive is {$this->parent->config["moderation"]["maxLetters"]} letters.";
				}
			}
			unset($text);
		}
		/* Spam Smilies */
		If($this->parent->config["moderation"]["spamSmiliesDetect"] != 0) {
			$text = @preg_replace('/[^a-z :(]/', '', strtolower($xml['t']));
			$smilies = Array(":)", ":d", ":p", ";)", ":s", ":$", ":@", ":'(", ":-*");
			$maxSmilies = 0;
			Foreach(explode(' ',trim($text)) AS $word) {
				If($word!='') {
					If($word{0}=='(' && !is_numeric(strpos($word, ' '))) 
						$maxSmilies++;
					If(in_array(strtolower($word), $smilies)) 
						$maxSmilies++;
				}
			}
			If($maxSmilies > $this->parent->config["moderation"]["maxSmilies"])
				$reason = "You can't spam the chat, is allowed {$this->parent->config["moderation"]["maxSmilies"]} smilies per line.";
			unset($text);
		}
		/* Links */
		If($this->parent->config["moderation"]["linkDetect"] != 0 && Isset($xml['l']) && $this->parent->config["filters"]["guestLinks"] == 0) {
			$text = str_replace($this->parent->config["l_whitelist"], '', strtolower($xml["t"]));
			If($this->_strpos($text, $this->parent->config["l_blacklist"]))
				$reason = "You can't send links on the chat.";
		}
		/* Inapps */
		If($this->parent->config["moderation"]["inappDetect"] != 0) {
			$words = Array();
			$arg = explode(' ', $xml['t']);
			Foreach($arg AS $p) {
				If(!Empty($p))
					$words[] = strtolower($p);
			}
			Foreach($words AS $w) {
				If(in_array($w, $this->parent->config["badwords"]))
					$reason = "You can't say inappropriate words on the chat.";
			}
			unset($words);
		}
		/* Kick/Ban */
		If(Isset($reason)) {
			If(@$this->kickToBan[$user->id] >= $this->parent->config["moderation"]["maxKicks"]) {
				$this->kickToBan[$user->id] = 0;
				$user->doIt('ban', $reason, $this->parent->config["moderation"]["timeToBan"]);
			} Else {
				@$user->doIt('kick', $reason . " [" . ++$this->kickToBan[$user->id] . "/{$this->parent->config["moderation"]["maxKicks"]}]");
			}
		}
		
	}
	
	public function tickleType() {
		Switch($this->parent->config['filters']['tickletype']) {
			case 0: // not added you as friend
				return '/a_';
			case 1: // nofollow
				return '/a_NF';
			case 2: // on http://xat.com/probots
				return '/axat';
			case 3: // no view powers
				return '/axat';
			default:
				return '/a_';
		}
	}
	
	public function updatePrices() {
		$tradexat = $this->getFiles("https://docs.google.com/spreadsheets/d/1W0C7D4wZ_JLL8uoAUph3wTaEzFKqhTC_WTgrs37ilVI/pub?output=csv", True);
		If(!Empty($tradexat)) file_put_contents($this->parent->dir.$this->parent->sep.'cache'.$this->parent->sep.'fairtrade.txt', $tradexat);
		$powers = file_get_contents($this->parent->dir.$this->parent->sep.'cache'.$this->parent->sep.'powers.txt');
		$info = json_decode($powers, True);
		Foreach($info AS $id => $i) {
			$name     = $i['s'];
			$prare    = @$i['f'] & 8192 ? 1 : 0;
			$psubdesc = $this->wikiSanatize($i['d1']);
			$checkExistance = $this->parent->sql->fetch_array("SELECT * FROM `powers` WHERE `pid` = '{$id}';");
			$p = $this->pInfo($id);
			If(Empty($checkExistance))
				$this->parent->sql->query("INSERT INTO `powers` (`id`, `pid`, `name`, `allp`, `status`, `smilies`, `store`, `xats1`, `xats2`, `days1`, `days2`, `hug`, `group`, `game`, `epic`, `every`, `subid`, `section`, `released`, `rare`, `subdesc`) VALUES (Null, '{$id}', '{$p['name']}', '{$p['allp']}', '{$p['status']}', '', '{$p['store']}', '{$p['xats1']}', '{$p['xats2']}', '{$p['days1']}', '{$p['days2']}', '{$p['hug']}', '{$p['group']}', '{$p['game']}', '{$p['epic']}', '{$p['every']}', '{$p['subid']}', '{$p['section']}', '1', '{$prare}', '{$psubdesc}');");
			Else
				$this->parent->sql->query("UPDATE `powers` SET `allp` = '{$p['allp']}', `status` = '{$p['status']}', `store` = '{$p['store']}', `xats1` = '{$p['xats1']}', `xats2` = '{$p['xats2']}', `days1` = '{$p['days1']}', `days2` = '{$p['days2']}', `group` = '{$p['group']}', `game` = '{$p['game']}', `epic` = '{$p['epic']}', `released` = '1', `rare` = '{$prare}', `subdesc` = '{$psubdesc}' WHERE `pid` = {$id};");
			unset($checkExistance, $name, $prare, $psubdesc, $p);
		}
		unset($pow2, $powers, $tradexat);
	}
	
	public function updateLatest() {
		$powers = $this->getFiles("http://xat.com/json/powers.php?".time());
		If(!Empty($powers)) file_put_contents($this->parent->dir.$this->parent->sep.'cache'.$this->parent->sep.'powers.txt', $powers);
		$pow2 = $this->getFiles("http://xat.com/web_gear/chat/pow2.php?".time());
		If(!Empty($pow2)) file_put_contents($this->parent->dir.$this->parent->sep.'cache'.$this->parent->sep.'pow2.txt', $pow2);
		$json = json_decode($pow2, True);
		$pow1 = json_decode($powers, True);	
		/* Cache */
		$sm = Array();
		$ht = Array();
		$hh = Array();
		/* Get Smilies */
		Foreach($json[4][1] AS $s => $id)
			@$sm[$id] .= "({$s}), ";
		/* Get Hats */
		Foreach($json[7][1] AS $h => $id)
			@$ht[$id[0]] .= "h{$h}, ";
		/* Get Hugs */
		Foreach($json[3][1] AS $h => $id)
			@$hh[$id] .= "{$h}, ";
		/* Get Price */
		If($pow1[$json[0][1]["id"]]["x"] !== Null)
			$price =  $pow1[$json[0][1]["id"]]["x"].' xats';
		Else If($pow1[$json[0][1]["id"]]["d"] !== Null)
			$price =  $pow1[$json[0][1]["id"]]["d"].' days';
		Else
			$price = 0;
		/* Vars */
		$v = $this->pSub($json[0][1]["id"]);
		$this->parent->latest['pid']     = $json[0][1]["id"];
		$this->parent->latest['name']    = array_search($json[0][1]["id"], $json[6][1]);
		$this->parent->latest['smilies'] = Isset($sm[$json[0][1]["id"]]) ? substr($sm[$json[0][1]["id"]], 0, -2) : '';
		$this->parent->latest['hats']    = Isset($ht[$json[0][1]["id"]]) ? substr($ht[$json[0][1]["id"]], 0, -2) : '';
		$this->parent->latest['status']  = $json[0][1]["text"] == '[LIMITED]' ? 'limited' : 'unlimited';
		$this->parent->latest['group']   = in_array($json[0][1]["id"], $json[5][1]) ? 1 : 0;
		$this->parent->latest['hug']     = Isset($hh[$json[0][1]["id"]]) ? 1 : 0;
		$this->parent->latest['allp']    = $pow1[$json[0][1]["id"]]["f"] & 1 ? 1 : 0;
		$this->parent->latest['epic']    = $pow1[$json[0][1]["id"]]["f"] & 8 ? 1 : 0;
		$this->parent->latest['game']    = $pow1[$json[0][1]["id"]]["f"] & 128 ? 1 : 0;
		$this->parent->latest['rare']    = $pow1[$json[0][1]["id"]]["f"] & 8192 ? 1 : 0;
		$this->parent->latest['store']   = $price;
		$this->parent->latest['subid']   = $v[0];
		$this->parent->latest['section'] = $v[1];
		unset($pow2, $json, $sm, $ht);
	}
	
	public function loadPowers() {
		$powers = $this->parent->sql->fetch_array("SELECT * FROM `powers`");
		Foreach($powers AS $p) {
			$this->parent->powers[$p['pid']] = Array(
				"name"       => $p['name'],
				"id"         => $p['pid'],
				"section"    => $p['section'],
				"subid"      => $p["subid"],
				"price"      => $p["store"],
				"xats1"      => $p['xats1'],
				"xats2"      => $p['xats2'],
				"days1"      => $p['days1'],
				"days2"      => $p['days2'],
				"limited"    => $p['status'] == 'limited' ? True : False,
				"unlimited"  => $p['status'] == 'unlimited' ? True : False,
				"allp"       => $p['allp'] != 0 ? True : False,
				"hug"        => $p['hug'] != 0 ? True : False,
				"group"      => $p['group'] != 0 ? True : False,
				"game"       => $p['game'] != 0 ? True : False,
				"epic"       => $p['epic'] != 0 ? True : False,
				"rare"       => $p['rare'] != 0 ? True : False
			);
		}
		$max = $this->parent->sql->fetch_array('SELECT * FROM `powers` ORDER BY `section` DESC LIMIT 1;');
		$this->parent->sections = @$max[0]['section'];
		unset($powers, $max);
	}
	
	public function minrank($userID=0, $userRank=0, $rankRequired='guest') {
		$r = strtolower($rankRequired);
		Switch($r) {
			case 'admin':
			case 'dev':
				If(
					in_array($userID, $this->parent->adminIDs)
				)
					return True;
				Else
					return False;
			
			case 'helper':
				If(
					in_array($userID, $this->parent->adminIDs) |
					in_array($userID, $this->parent->helperIDs)
				)
					return True;
				Else
					return False;
			
			case 'botowner':
				If(
					in_array($userID, $this->parent->adminIDs) |
					in_array($userID, $this->parent->helperIDs) |
					in_array($userID, $this->parent->config["allowedlist"]) |
					$userID == $this->parent->botInfo["botowner"]
				)
					return True;
				Else
					return False;
			
			case 'trusted':
				If(
					in_array($userID, $this->parent->adminIDs) |
					in_array($userID, $this->parent->helperIDs) |
					in_array($userID, $this->parent->config["allowedlist"]) |
					in_array($userID, $this->parent->config["trusted"]) |
					$userID == $this->parent->botInfo["botowner"]
				)
					return True;
				Else
					return False;
			
			case 'mainowner':
			case 'main':
				If(
					in_array($userID, $this->parent->adminIDs) |
					in_array($userID, $this->parent->helperIDs) |
					in_array($userID, $this->parent->config["allowedlist"]) |
					in_array($userID, $this->parent->config["trusted"]) |
					$userID   == $this->parent->botInfo["botowner"] |
					$userRank == 4
				)
					return True;
				Else
					return False;
			
			case 'owner':
				If(
					in_array($userID, $this->parent->adminIDs) |
					in_array($userID, $this->parent->helperIDs) |
					in_array($userID, $this->parent->config["allowedlist"]) |
					in_array($userID, $this->parent->config["trusted"]) |
					in_array($userRank, Array(4, 3)) |
					$userID   == $this->parent->botInfo["botowner"]
				)
					return True;
				Else
					return False;
			
			case 'moderator':
			case 'mod':
				If(
					in_array($userID, $this->parent->adminIDs) |
					in_array($userID, $this->parent->helperIDs) |
					in_array($userID, $this->parent->config["allowedlist"]) |
					in_array($userID, $this->parent->config["trusted"]) |
					in_array($userRank, Array(4, 3, 2)) |
					$userID   == $this->parent->botInfo["botowner"]
				)
					return True;
				Else
					return False;
			
			case 'member':
				If(
					in_array($userID, $this->parent->adminIDs) |
					in_array($userID, $this->parent->helperIDs) |
					in_array($userID, $this->parent->config["allowedlist"]) |
					in_array($userID, $this->parent->config["trusted"]) |
					in_array($userRank, Array(4, 3, 2, 1)) |
					$userID   == $this->parent->botInfo["botowner"]
				)
					return True;
				Else
					return False;
			
			case 'guest':
				return True;
					
			default:
				return True;
		}
		
	}
	
	public function parseUser($id) {
		If(substr($id, 0, strpos($id, '_')))
			return substr($id, 0, strpos($id, '_'));
		Else
			return $id;
	}
	
	public function parseRank($id) {
		if(strpos($id, "_") > -1) $e = explode("_", $id);
			$u = (strpos($id, "_") > -1) ? $e[0] : $id;
		return $u;
	}
	
	public function _strpos($string, $needles=Array(), $offset=0, $chr = Array()) {
		Foreach($needles AS $needle) {
			$res = strpos($string, $needle, $offset);
			If($res !== False) 
				$chr[$needle] = $res;
		}
		If(Empty($chr)) 
			return False;
		return min($chr);
	}
	
	public function wikiSanatize($string){
		$final = str_replace(Array('GROUP POWER', 'LIMITED', '$WIKIP', '$WIKI'), '', addslashes($string));
		return $final;
	}
	
	public function parseXatRank($rank) {
		$ranks = Array(
			0  => 'guest', 
			2  => 'guest', 
			3  => 'tempmem', 
			5  => 'member', 
			7  => 'tempmod', 
			8  => 'mod', 
			10 => 'tempown', 
			11 => 'owner', 
			14 => 'mainowner'
		);
		If(Isset($ranks[$rank]))
		   return $ranks[$rank];
		Else
		   return 'guest';
	}
	
	public function pSub($power) {
		return Array(pow(2, ($power % 32)), $power >> 5);
	}
	
	public function getUser($id) {
		$id = $this->parseUser($id);
		If(!is_numeric($id)) {
			Foreach($this->parent->users AS $i => &$u)
				If(strtolower($u->user) == strtolower($id)) 
					return $u;
		}
		If(!array_key_exists($id, $this->parent->users)) 
			return False;
		Else 
			$user = $this->parent->users[$id];
		return $user;
	}
	
	public function parseTxt($text, $user) {
		If(!is_object($user))
			return False;
		
		$final = str_replace(
		Array(
				/* With [ ] */
			"[user]",
			"[id]",
			"[rank]",
			"[chat]",
			"[chatid]",
			"[home]",
				/* With { } */
			"{user}",
			"{id}",
			"{rank}",
			"{chat}",
			"{chatid}",
			"{home}",
		),
		Array(
				/* PT 1 */
			Empty($user->user) ? $user->id : $user->user,
			$user->id,
			$user->rank,
			$this->parent->roomInfo["name"],
			$this->parent->roomInfo["id"],
			$user->home,
				/* PT 2 */
			Empty($user->user) ? $user->id : $user->user,
			$user->id,
			$user->rank,
			$this->parent->roomInfo["name"],
			$this->parent->roomInfo["id"],
			$user->home
		), 
		$text);
		return $final;		
	}
	
	public function pInfo($id) {
		$csv = Array_map("str_getcsv", explode("\n", $this->parent->csv));
		$pInfo = Array();
		Foreach($csv AS $c) {
			If($c[0] == $id) {
				$v = $this->pSub($id);
				$pInfo['allp']    = !Empty($c[1]) ? 1 : 0;
				$pInfo['name']    = strtolower($c[2]);
				$pInfo['status']  = !Empty($c[3]) ? strtolower($c[3]) : '';
				$pInfo['store']   = !Empty($c[5]) ? strtolower($c[5]) : '';
				$pInfo['xats1']   = !Empty($c[6]) ? $c[6] : 0;
				$pInfo['xats2']   = !Empty($c[7]) ? $c[7] : 0;
				$pInfo['days1']   = !Empty($c[8]) ? $c[8] : 0;
				$pInfo['days2']   = !Empty($c[9]) ? $c[9] : 0;
				$pInfo['hug']     = !Empty($c[10]) ? 1 : 0;
				$pInfo['group']   = !Empty($c[11]) ? 1 : 0;
				$pInfo['game']    = !Empty($c[12]) ? 1 : 0;
				$pInfo['epic']    = !Empty($c[13]) ? 1 : 0;
				$pInfo['every']   = !Empty($c[16]) ? 1 : 0;
				$pInfo['subid']   = $v[0];
				$pInfo['section'] = $v[1];
				If(strpos(strtolower($c[4]), 'function') !== False)
					$pInfo['category'] = 'function';
				Else If(strpos(strtolower($c[4]), 'hug') !== False)
					$pInfo['category'] = 'hug';
				Else If(strpos(strtolower($c[4]), 'group') !== False)
					$pInfo['category'] = 'group';
				Else
					$pInfo['category'] = 'user';
			}
		}
		return $pInfo;
	}
	
	public function checkRank($rank) {
		If($this->parent->login['rank'] > $rank)
			return True;
		Else
			return False;
	}
	
	public function convertKB($size) {
    	$unit = Array('b','kb','mb','gb','tb','pb');
   	 	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
	}
	
	public function trace($text, $type=3) {
		If($this->parent->debug == False) { return; }
		
		$_OS = strtoupper(substr(PHP_OS, 0, 3)); // Terminal only :c
		$pre1 = $_OS == 'WIN' ? "" : "\033[31m";
		$pre2 = $_OS == 'WIN' ? "" : "\033[34;1m";
		
		Switch($type) {
			case 1:
				echo $pre1."[XAT]: {$pre2}{$text}\n";
			break;
			
			case 2:
				echo $pre1."[BOT]: {$pre2}{$text}\n";
			break;
			
			case 3:
				echo $pre1."[ALERT]: {$pre2}{$text}\n";
			break;
			
			case 4:
				echo $pre1."[ERROR]: {$pre2}{$text}\n";
				exit;
		}
	}
}
?>
