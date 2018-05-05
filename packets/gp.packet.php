<?php
Foreach($packet AS $p => $v) {
	Switch ($p) {
		case 'g74':
			$this->chatgp['gline'] = $v;
		break;
		case 'g90':
			$this->chatgp['bad'] = $v;
		break;
		case 'g100':
			$this->chatgp['link'] = $v;
		break;
		case 'g106':
			$this->chatgp['gscol'] = $v;
		break;
		case 'g112':
			$this->chatgp['announce'] = $v;
		break;
		case 'g114':
			$json = json_decode(str_replace('\'', '"', $v), True);
			$this->chatgp['rankpool'] = Array(
				'mainpool' => $json['m'], 
				'banpool'  => $json['b'], 
				'secpool'  => $json['t'], 
				'secrank'  => $this->function->parseXatRank($json['rnk']), 
				'banrank'  => $this->function->parseXatRank($json['brk'])
			);
		break;
	}
}
$this->sql->query("UPDATE `accounts` SET `chatgp` = '".json_encode($this->chatgp)."' WHERE `id` ='{$this->botID}';");