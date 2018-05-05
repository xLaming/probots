<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('dev');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, "admin") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$args = explode(chr(32), $args[1], 2);
	Switch(str_replace('_','',strtolower($args[0]))) {
		case 'update':
		case 'reload':
			Switch(str_replace('_', '', strtolower($args[1]))) {
				case 'smilies':
					$core->function->sendMsg("Please wait, updating...", $mType, $user->id);
					$started = time();
					$smilies = Array();
					$powers = $core->sql->fetch_array("SELECT * FROM `powers`");
					Foreach($powers AS $p){
						If(Empty($p['smilies']) && $p['name'] != 'hat') {
							$link = $core->function->getFiles("http://util.xat.com/wiki/index.php?title=".ucfirst($p['name']));
							If(!Empty($link)) {
								file_put_contents($core->dir.$core->sep.'cache'.$core->sep.'wiki'.$core->sep.'powers'.$core->sep.$p['name'].'.txt', $link);
								preg_match_all("!http://www.xatech.com/web_gear/flash/smiliesshow.swf(.*?)\"!", $link, $smil);
								Foreach($smil[1] AS $v) {
									$smiley = strtolower(str_replace('?r=', '', $v));
									If(substr($smiley, 0, 2) != 'p1')
										$smilies[] = "({$smiley})";
								}
								$core->sql->query("UPDATE `powers` SET `smilies`='".@implode(", ", $smilies)."' WHERE `pid` =' {$p['pid']}';");
								unset($smilies);
							}					
						}
					}
					$core->function->loadPowers();
					$core->function->sendMsg("Smilies list updated in ".$core->function->stotime(time() - $started).".", $mType, $user->id);
					unset($started);
				break;

				case 'prices':
					$core->function->sendMsg("Please wait, updating...", $mType, $user->id);
					$started = time();
					$core->function->updateLatest();
					$core->function->updatePrices();
					$core->function->loadPowers();
					$core->function->sendMsg("Prices updated in ".$core->function->stotime(time() - $started).".", $mType, $user->id);
					unset($started);
				break;
				
				case 'latest':
					$core->function->sendMsg("Please wait, updating...", $mType, $user->id);
					$started = time();
					$core->function->updateLatest();
					$checkExistance = $core->sql->fetch_array("SELECT * FROM `powers` WHERE `pid` = '{$core->latest['pid']}';");
					If(Empty($checkExistance))
						$core->sql->query("INSERT INTO `powers` (`id`, `pid`, `name`, `allp`, `status`, `smilies`, `store`, `xats1`, `xats2`, `days1`, `days2`, `hug`, `group`, `game`, `epic`, `every`, `subid`, `section`, `released`, `rare`, `subdesc`) VALUES (Null, '{$core->latest['pid']}', '{$core->latest['name']}', '{$core->latest['allp']}', '{$core->latest['status']}', '{$core->latest['smilies']}', '0', '0', '0', '0', '0', '{$core->latest['hug']}', '{$core->latest['group']}', '{$core->latest['game']}', '{$core->latest['epic']}', '1', '{$core->latest['subid']}', '{$core->latest['section']}', '0', '{$core->latest['rare']}', '');");
					$core->function->updatePrices();
					$core->function->loadPowers();
					$core->function->sendMsg("Latest power updated in ".$core->function->stotime(time() - $started).".", $mType, $user->id);
					unset($started, $checkExistance);
				break;
				
				case 'external':
					$core->function->sendMsg("Please wait, updating...", $mType, $user->id);
					$started = time();
					$chats      = $core->function->getFiles("http://util.xat.com/wiki/index.php?title=Chats");
					$volunteers = $core->function->getFiles("http://util.xat.com/wiki/index.php?title=Volunteers");
					file_put_contents($core->dir.$core->sep.'cache'.$core->sep.'wiki'.$core->sep.'special_chats.txt', $chats);
					file_put_contents($core->dir.$core->sep.'cache'.$core->sep.'wiki'.$core->sep.'volunteers.txt', $volunteers);
					$core->function->sendMsg("External cache updated in ".$core->function->stotime(time() - $started).".", $mType, $user->id);
				break;
				
				default: $core->function->sendMsg("Option not found.", $mType, $user->id); break;
			}
		break;
		
		case 'test':
			If($user->id != 956544769) {return $core->function->sendMsg("Only xLaming can use this command ;)", $mType, $user->id);} 
			Switch(str_replace('_', '', strtolower($args[1]))) {
				case 1:
					For($i=1; True; $i++) {
						$packetToSend = $core->function->createPacket('x', Array('i' => 17777, 'u' => $core->login['i'], 't' => 'AQA='));
						$core->sockets->send($packetToSend);
						unset($packetToSend);
						$packetToSend = $core->function->createPacket('x', Array('i' => 16666, 'u' => $core->login['i'], 't' => 'AQA='));
						$core->sockets->send($packetToSend);
						unset($packetToSend);
						sleep(1);
					}
				break;
				
				case 2:
					For($i=1; True; $i++) {
						$packetToSend = $core->function->createPacket('x', Array('i' => rand(1000000,66666666), 'u' => $$core->login['i'], 't' => 'AQA='));
						$core->sockets->send($packetToSend);
						unset($packetToSend);
						sleep(1);
					}
				break;
				
				case 3:
					$ids = Array("10001","10000","20010","30004","30008","20034","60201","60193","60189","60195");
					For($i=1; True; $i++) {
						$packetToSend = $core->function->createPacket('x', Array('i' => $ids[array_rand($ids)], 'u' => $core->login['i'], 't' => 'AQA='));
						$core->sockets->send($packetToSend);
						unset($packetToSend);
						sleep(1);
					}
				break;
				
				case 4:
					For($i = 60; $i > 0; $i--){
					$packetToSend = $core->function->createPacket('x', Array('i' => (80000+$i), 'u' => $this->login['i'], 't' => 'AQA='));
						$core->sockets->send($packetToSend);
						unset($packetToSend);
						sleep(1);
					}
					$core->function->sendMsg("Time finished :)", $mType, $user->id);
					$packetToSend = $core->function->createPacket('x', Array('i' => 30004, 'u' => $this->login['i'], 't' => 'AQA='));
					$core->sockets->send($packetToSend);
					unset($packetToSend);
				break;
				
				case 5:
					$packetToSend = $core->function->createPacket('x', Array('i' => 6, 'u' => $this->login['i'], 't' => 'AQA='));
					$core->sockets->send($packetToSend);
					unset($packetToSend);
				break;
				
				default: $core->function->sendMsg("Option not found.", $mType, $user->id); break;
			}
		break;
		
		case 'relogin':
			$core->function->sendMsg("Please wait, I will relogin...", $mType, $user->id);
			$core->sockets->shutdown();
			$core->sockets->connect();
			$core->joinRoom($core->roomInfo["id"], True);
		break;
		
		case 'exorcism':
			$packetToSend = $core->function->createPacket('x', Array('i' => 1, 'u' => $this->login['i'], 't' => 'AQA='));
			$core->sockets->send($packetToSend);
			unset($packetToSend);
			$core->function->sendMsg("The satan was exorcised! (6#)", $mType, $user->id);
		break;
		
		case 'ram':
			$free = shell_exec('free');
			$free = (string)trim($free);
			$free_arr = explode("\n", $free);
			$mem = explode(" ", $free_arr[1]);
			$core->function->sendMsg("Bot currently using: ".$core->function->convertKB(memory_get_usage()).".", $mType, $user->id);
		break;
		
		case 'say':
			$core->function->sendMsg("[DEV]: ".$args[1]);
		break;

		case 'countcmd':
			$core->sql->query("UPDATE `settings` SET `countcmd` = '" . count($core->commands) . "' WHERE `index` = '1';");
			$core->function->sendMsg("There are ".count($core->commands)." commands (NO SUB-COMMANDS).");
		break;
		
		case 'bank':
			$core->function->sendMsg("I have {$core->botInfo['bank']['xats']} xats and {$core->botInfo['bank']['days']} days.", $mType, $user->id);
		break;
		
		case "pcalc":
			$v = $core->function->pSub($args[1]);
			$core->function->sendMsg("Power ID [{$args[1]}] :--: Section: p{$v[1]}, SubID: ".$v[0], $mType, $user->id);
		break;
		
		case 'website':
			Switch(str_replace('_', '', strtolower($args[1]))) {
				case 'on':
					shell_exec('service php-fpm restart');
					sleep(1);
					shell_exec('service nginx restart');
					$core->function->sendMsg("Ok, Nginx's started.", $mType, $user->id);
				break;
				
				case 'off':
					shell_exec('service php-fpm stop');
					sleep(1);
					shell_exec('service nginx stop');
					$core->function->sendMsg("Nginx's dead.", $mType, $user->id);
				break;
				
				default: $core->function->sendMsg("Option not found.", $mType, $user->id); break;
			}
		break;
		
		case 'ftp':
			Switch(str_replace('_', '', strtolower($args[1]))) {
				case 'on':
					shell_exec('service vsftpd restart');
					$core->function->sendMsg("Ok, FTP Server's started.", $mType, $user->id);
				break;
				
				case 'off':
					shell_exec('service vsftpd stop');
					$core->function->sendMsg("FTP Server's dead.", $mType, $user->id);
				break;
				
				default: $core->function->sendMsg("Option not found.", $mType, $user->id); break;
			}
		break;
		
		case 'startall':
			$bots = $core->sql->fetch_array("SELECT * FROM `accounts`");
			Foreach($bots AS $b) {
				If($b['id'] != 1) {
					shell_exec("nohup php {$core->cmdFolder} \"{$bo['id']}\" > /dev/null 2>&1 &");
				}
			}
			$core->function->sendMsg("All bots were started.", $mType, $user->id);
		break;
		
		case "online":
			exec("ps aux | grep bot.php | grep -v grep", $bots);
			$core->function->sendMsg("There are ".count($bots)." bots online.", $mType, $user->id);
		break;
		
		default: $core->function->sendMsg("That option doesn't exist!", $mType, $user->id); break;
	}
};
