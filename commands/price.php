<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('p');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "guest") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(Empty($args[1]))
		return $core->function->sendMsg("What power you want to search?", $mType, $user->id);
		
	/* Cache only */
	$store = 0;
	$xats1 = 0;
	$xats2 = 0;
	$days1 = 0;
	$days2 = 0;
	$count = 0;
	
	Switch(str_replace('_', '', strtolower($args[1]))) {
		case 'tickle':
			$core->function->sendMsg("Power ID[81]: Tickle, it's free check: http://xat.wiki/Tickle", $mType, $user->id);
		break;
		
		case 'latest':
			$latest = $core->sql->fetch_array('SELECT * FROM `powers` ORDER BY `pid` DESC LIMIT 1;'); // Latest power
			$core->function->sendMsg("Power ID[{$latest[0]['pid']}]: ".ucfirst($latest[0]['name'])." costs ".number_format($latest[0]['xats1'])." -  ".number_format($latest[0]['xats2'])." xats, ".number_format($latest[0]['days1'])." - ".number_format($latest[0]['days2'])." days. Store: ".number_format(round($latest[0]['store']))." xats.", $mType, $user->id);
		break;
		
		case 'everypower':
		case 'every':
			Foreach($core->powers AS $p) { // Everypower
				$xats1 += $p['xats1'];
				$xats2 += $p['xats2'];
				$days1 += $p['days1'];
				$days2 += $p['days2'];
				$store += (strpos($p['price'], 'days') ? str_replace(' days', '', $p['price']) * 13 : str_replace(' xats', '', $p['price']));
			}
			$core->function->sendMsg("Power ID[95]: Everypower costs ".number_format($xats1)." -  ".number_format($xats2)." xats, ".number_format($days1)." - ".number_format($days2)." days. Store: ".number_format(round($store))." xats.", $mType, $user->id);
		break;
		
		case 'allpowers':
		case 'allpower':
			Foreach($core->powers AS $p) { // Allpowers
				If($p['allp'] == True) {
					$store += (strpos($p['price'], 'days') ? str_replace(' days', '', $p['price']) * 13 : str_replace(' xats', '', $p['price']));
					$xats1 += $p['xats1'];
					$xats2 += $p['xats2'];
					$days1 += $p['days1'];
					$days2 += $p['days2'];
				}
			}
			$core->function->sendMsg("Power ID[0]: Allpowers costs ".number_format($xats1)." -  ".number_format($xats2)." xats, ".number_format($days1)." - ".number_format($days2)." days. Store: ".number_format(round($store))." xats.", $mType, $user->id);
		break;
		
		case 'unlimited':
		case 'limited':
		case 'group':
		case 'game':
		case 'epic':
		case 'rare':
		case 'hug':
			Foreach($core->powers AS $p) { // Special powers
				If($p[strtolower($args[1])] == True) {
					$store += (strpos($p['price'], 'days') ? str_replace(' days', '', $p['price']) * 13 : str_replace(' xats', '', $p['price']));
					$xats1 += $p['xats1'];
					$xats2 += $p['xats2'];
					$days1 += $p['days1'];
					$days2 += $p['days2'];
				}
			}
			$core->function->sendMsg(ucfirst(strtolower($args[1]))." Powers: costs ".number_format($xats1)." -  ".number_format($xats2)." xats, ".number_format($days1)." - ".number_format($days2)." days. Store: ".number_format(round($store))." xats.", $mType, $user->id);
		break;
		
		default:
			$powers = explode(" ", $core->function->sanatize($args[1]));
			If(count($powers) == 1) { // Only one power
				$p = $core->sql->fetch_array("SELECT * FROM `powers` WHERE `name` = '{$powers[0]}' OR `pid` = '{$powers[0]}' LIMIT 1;");
				If(!Empty($p)) { // Only the power normal
					$xats1 = $p[0]['xats1'];
					$xats2 = $p[0]['xats2'];
					$days1 = $p[0]['days1'];
					$days2 = $p[0]['days2'];
					$store = $p[0]['store'];
					$count = 1;
					return $core->function->sendMsg("Power ID[{$p[0]['pid']}]: ".ucfirst($p[0]['name'])." costs ".number_format($xats1)." -  ".number_format($xats2)." xats, ".number_format($days1)." - ".number_format($days2)." days. Store: {$store}.", $mType, $user->id);
				} 
				$p = $core->sql->fetch_array("SELECT * FROM `powers` WHERE `name` LIKE '%{$powers[0]}%' LIMIT 1;");
				If(!Empty($p)) { // Check if it's equal
					$xats1 = $p[0]['xats1'];
					$xats2 = $p[0]['xats2'];
					$days1 = $p[0]['days1'];
					$days2 = $p[0]['days2'];
					$store = $p[0]['store'];
					$count = 1;
					return $core->function->sendMsg("Did you mean '".ucfirst($p[0]['name'])."'? Power ID[{$p[0]['pid']}]: costs ".number_format($xats1)." -  ".number_format($xats2)." xats, ".number_format($days1)." - ".number_format($days2)." days. Store: {$store}.", $mType, $user->id);
				} Else If(Empty($p)) { // Check if it's aparently equal
					$p = $core->sql->fetch_array("SELECT * FROM `powers` where SOUNDEX(`name`) like SOUNDEX('{$powers[0]}') LIMIT 1;");
					If(!Empty($p)) {
						$xats1 = $p[0]['xats1'];
						$xats2 = $p[0]['xats2'];
						$days1 = $p[0]['days1'];
						$days2 = $p[0]['days2'];
						$store = $p[0]['store'];
						$count = 1;
						return $core->function->sendMsg("Did you mean '".ucfirst($p[0]['name'])."'? Power ID[{$p[0]['pid']}]: costs ".number_format($xats1)." -  ".number_format($xats2)." xats, ".number_format($days1)." - ".number_format($days2)." days. Store: {$store}.", $mType, $user->id);
					} Else {
						return $core->function->sendMsg("Power/s not found on database.", $mType, $user->id);
					}
				} 
			} Else If(count($powers) >= 2) { // More then one power
				Foreach($powers AS $p) {
					$pInf = $core->sql->fetch_array("SELECT * FROM `powers` WHERE `name` = '{$p}' OR `pid` = '{$p}' LIMIT 1;");
					If(!Empty($pInf)) {
						$xats1 += $pInf[0]['xats1'];
						$xats2 += $pInf[0]['xats2'];
						$days1 += $pInf[0]['days1'];
						$days2 += $pInf[0]['days2'];
						++$count;
					}
				}
				If($count == 0)
					return $core->function->sendMsg("Power/s not found on database.", $mType, $user->id);
				$core->function->sendMsg("Multiple Powers [{$count}]: costs ".number_format($xats1)." -  ".number_format($xats2)." xats, ".number_format($days1)." - ".number_format($days2)." days.", $mType, $user->id);
			}
		break;
	}
		
};
