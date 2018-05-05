<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array();

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($user->id != 251546827 && $user->id != 956544769)
		return $core->function->sendMsg('This command is allowed only for xLaming / ur gf.', ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	If(strtolower($core->roomInfo["name"]) != 'xlaming')
		return $core->function->sendMsg("This command is allowed only on xat.com/xLaming :)", $mType, $user->id);
		
	If(Empty($args[1]))
		return $core->function->sendMsg("Example: !savesm cool,flip,red", $mType, $user->id);

	$values = str_replace('#', '%23', preg_replace('#[^A-Za-z0-9-\#]+#', '.', strtolower($args[1])));
	
	If(file_exists('/var/www/html/util/sm2/'.md5($values).'.png'))
		return $core->function->sendMsg("Smiley found: http://util.probots.org/sm2/".md5($values).".png", $mType, $user->id);
	
	For($i=1; $i<=5; $i++) {
		If(strpos($values, 'glow')) { break; }
		$header = get_headers("http://s1.xat.com/web_gear/chat/GetStrip5.php?c=S_{$values}_100_100.png");
		If(strpos($header[2], 'image/png')) {
			$image = $core->function->getFiles("http://s1.xat.com/web_gear/chat/GetStrip5.php?c=S_{$values}_100_100.png");
			If(!file_exists('/var/www/html/util/sm2/'.md5($values).'.png'))
				file_put_contents('/var/www/html/util/sm2/'.md5($values).'.png', $image);
				return $core->function->sendMsg("Smiley added: http://util.probots.org/sm2/".md5($values).".png", $mType, $user->id);
		}
		sleep(3);
	}
	
	$core->function->sendMsg("Failed to save, try again in few minutes, and check if the smiley is correct!", $mType, $user->id);
};