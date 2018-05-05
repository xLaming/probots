<?php
class Sockets {
	public $parent;
	
	public function __construct(&$parent, &$function) {
		$this->parent = $parent;
		$this->function = $function;
	}
	
	public function connect() {
		$this->parent->socket[1] = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		socket_set_option($this->parent->socket[1], SOL_SOCKET, SO_RCVTIMEO, Array("sec" => 3, "usec" => 0));
		$checkConn = socket_connect($this->parent->socket[1], $this->parent->conn["ip"], $this->parent->conn["port"]);
		If($checkConn === False) { $this->function->trace("Failed to connect.", 4); } Else { $this->function->trace("Connected to xat.", 3); }
	}
	
	public function shutdown() {
		socket_close($this->parent->socket[1]);
		#socket_close($this->parent->socket[2]);
	}
	
	public function connectServerBind($myIP=0, $myPort=10090) {	
		$this->parent->socket[2] = socket_create(AF_INET, SOCK_STREAM, 0);
		socket_bind($this->parent->socket[2], $myIP, $myPort);
		socket_set_option($this->parent->socket[2], SOL_SOCKET, SO_RCVTIMEO, Array("sec" => 3, "usec" => 0));
		socket_listen($this->parent->socket[2]);
	}
	
	public function read() {
		While(True) {
			Foreach($this->parent->socket AS $socket => $conn) {
				@socket_set_nonblock($conn);
				/* Bot Time Finished */
				If($this->parent->times['subscription'] < time() && $this->parent->premiumBot == True && $this->parent->times['special'] == False) {
					$this->parent->premiumBot = False;
					$this->parent->times['subscription'] = 0;
					$this->parent->satanBot = True;
					$this->parent->botInfo['homepage'] = 'PROBots_Free_Version';
					$allpowers = $this->parent->sql->fetch_array("SELECT * FROM `powers`");
					Foreach($allpowers AS $p) {
						If(!in_array($p['pid'], $this->parent->config['disabled_powers']))
							Array_push($this->parent->config['disabled_powers'], $p['pid']);
					}
					$this->parent->sql->query("UPDATE `accounts` SET `subscription` = '0' WHERE `id` = '{$this->parent->botID}';");
					$this->function->sendMsg("My time finished, I will run free version, for buy more time, transfer me :)");
					$this->function->restart();
				}
				/* Update Bot */
				If(time() > $this->parent->settings['filetime']) { 
					$this->function->updateLatest();
					$checkExistance = $this->parent->sql->fetch_array("SELECT * FROM `powers` WHERE `pid` = '{$this->parent->latest['pid']}';");
					If(Empty($checkExistance))
						$this->parent->sql->query("INSERT INTO `powers` (`pid`, `name`, `allp`, `status`, `smilies`, `store`, `xats1`, `xats2`, `days1`, `days2`, `hug`, `group`, `game`, `epic`, `every`, `subid`, `section`, `released`, `rare`, `subdesc`) VALUES ('{$this->parent->latest['pid']}', '{$this->parent->latest['name']}', '{$this->parent->latest['allp']}', '{$this->parent->latest['status']}', '{$this->parent->latest['smilies']}', '0', '0', '0', '0', '0', '{$this->parent->latest['hug']}', '{$this->parent->latest['group']}', '{$this->parent->latest['game']}', '{$this->parent->latest['epic']}', '1', '{$this->parent->latest['subid']}', '{$this->parent->latest['section']}', '0', '{$this->parent->latest['rare']}', '');");
					$this->function->updatePrices();
					$this->function->loadPowers();
					$this->parent->settings['filetime'] = strtotime("+24 hours");
					$this->parent->sql->query("UPDATE `settings` SET `filetime` = '".strtotime("+24 hours")."' WHERE `index` = 1");
				}
				Switch($socket) {
					case 1: // XAT
						$buff = "";
						Do {
							$buff .= socket_read($conn, 1204);
						} 
						While(substr($buff, -1) != chr(0)  && $buff !== "");
						
						If($buff != '') {
							Foreach(explode(chr(0), $buff) AS $xml) {
								If(!Empty($xml)) {
									$this->function->trace($xml, 1);
									$this->parent->xmlArray($xml);
								}
							}
							unset($buff);
						}
					break;
					
					case 2: // API
						$this->parent->socket[3] = @socket_accept($conn);
						$read = @socket_read($this->parent->socket[3], 1204);
												
						If($read != '')
							$this->parent->xmlArrayApi($read);
					break;
				}
			}
		}
	}
	
	public function send($data, $sock=1) {
		If($data{strlen($data)-1}!=chr(0)) 
			$data.=chr(0);
		$this->function->trace($data, 2);
		return socket_write($this->parent->socket[$sock], $data);
	}
	
	public function socketDebug() {
		$socket = @fsockopen('127.0.0.1', 10090, $e, $e, 1);
		@fwrite($socket, '<update />'.chr(0));
	}
}
?>