<?php
$cmdName = preg_replace('/\.[^.]+$/','',basename(__FILE__));
$alias = Array('h');

$this->commands[$cmdName] = function($core, $args, $packet, $mType, $pmm, $alias, $user) {
	/* Minrank */
	If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "guest") == False)
		return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
	/* Command */
	$word = explode(' ',strtolower(@$args[1]).' ',2);
	$used = '';
	If(!Isset($GLOBALS['hangman'])) @$GLOBALS['hangman'] = false;
	
	switch($word[0]) {
		case "start":
			If($core->gameRunning !== False)
				return $core->function->sendMsg("A game is already running... [{$core->gameRunning}]", $mType, $user->id);	
			
			$core->gameRunning = 'hangman';
			$words = $core->hangman;
			
			$core->gameVar['unguessed'] = 'abcdefghijklmnopqrstuvwxyz';
			$core->gameVar['wrongCount'] = 0;
			$core->gameVar['guessed'] = '';
			$core->gameVar['word'] = $words[array_rand($words)];
			
			unset($words);
			
			$core->gameVar['display'] = array();
			$core->gameVar['blocked'] = array();
			
			unset($core->gameVar['time']);
			$core->gameVar['time'] = time();
			
			Foreach(str_split($core->gameVar['word']) AS $c) 
				$core->gameVar['display'][] = '-';
			
			$core->function->sendMsg("Word: ".implode($core->gameVar['display'],''), $mType, $user->id);
		break;
		
		case "guess":
		case "word":
			If($core->gameRunning != 'hangman') 
				return;
			
			If(!Isset($word[1]) || Empty($word[1]))
				return $core->function->sendMsg("You must guess something.", $mType, $user->id);
			
			If(in_array($user->id, $core->gameVar['blocked']))
				return $core->function->sendMsg("You can not play this game, wait for the next round.", $mType, $user->id);
			
			If (strtolower(trim($word[1])) != $core->gameVar['word']) {
				$core->function->sendMsg("Sorry that is incorrect. You are out and can no longer guess.", $mType, $user->id);
				$core->gameVar['blocked'][] = $user->id;
			} Else {
				$core->function->sendMsg("Congratulations!({$user->id}) you won. The word was: ".$core->gameVar['word']."(clap)", $mType, $user->id);
				sleep(1);
				unset($core->gameVar);   
				$core->gameRunning = False;
			}
		break;
		
		case "show":
			If($core->gameRunning != 'hangman') 
				return;
			
			If(in_array($user->id, $core->gameVar['blocked']))
				return $core->function->sendMsg("You can not play this game, wait for the next round.", $mType, $user->id);
			
			$core->function->sendMsg("Remaining: ".implode($core->gameVar['display'],' ')." Used letters: ".substr($core->gameVar['guessed'], 0, -2), $mType, $user->id);
		break;
		
		case 'stop':
			If($core->gameRunning != 'hangman')
				return $core->function->sendMsg("Hangman is not currently running.", $mType, $user->id);
							
			If($core->gameVar['time'] + 60 > time())
				return $core->function->sendMsg("I will not end the game unless there has been atleast 1 minute without a guess.", $mType, $user->id);

			$core->function->sendMsg("The answer was '{$core->gameVar['word']}'", $mType, $user->id);
			
			unset($core->gameVar) ;
			
			$core->gameRunning = False;
		break;
		
		case 'solution':
			If($core->gameRunning!='hangman') 
				return;
			
			If($core->function->minrank($user->id, $user->f, Isset($core->config["minrank"][$alias]) ? $core->config["minrank"][$alias] : "owner") == False) 
				return $core->function->sendMsg($core->translate->__r('not-allowed'), ($pmm == 3 ? 1 : $pmm), $user->id);
			Else
				$core->function->sendMsg("Hangman word: ".$core->gameVar['word'], ($pmm == 3 ? 1 : $pmm), $user->id);
		break;
		
		default:
			If($core->gameRunning != 'hangman') 
				return;
			
			If(!Isset($word[0]) || Empty($word[0]))
				return $core->function->sendMsg("You must guess something.", $mType, $user->id);
			
			If(in_array($user->id, $core->gameVar['blocked']))
				return $core->function->sendMsg("You can not play this game, wait for the next round.", $mType, $user->id);
			
			$core->gameVar['time'] = time();
			$posn = strpos($core->gameVar['unguessed'],$word[0] {0});
			
			If($posn === False)	
				return $core->function->sendMsg("'{$word[0]}' has already been guessed.", $mType, $user->id);
			
			$core->gameVar['unguessed'] = str_replace($word[0] {0},'',$core->gameVar['unguessed']);
			$core->gameVar['guessed'] .= $word[0] {0}.', ';
			$posn2 = array_search($word[0] {0},str_split($core->gameVar['word']));
			
			If($posn2 === False) {
				$max = 7;
				$core->gameVar['wrongCount']++;
				If($core->gameVar['wrongCount'] >= $max) {
					$core->function->sendMsg("You have made too many wrong guesses. You lose. The word was: ".$core->gameVar['word'], $mType, $user->id);
					$core->gameRunning = false;
					unset($core->gameVar);
					$core->gameRunning = false;
				} Else 
					$core->function->sendMsg("'{$word[0]}' was not found in the word. You have ".($max - $core->gameVar['wrongCount'])." lives left.", $mType, $user->id);
				return;
			} Else {
				For($i=0; $i<strlen($core->gameVar['word']); $i++) {
					If($core->gameVar['word'] {$i}==$word[0] {0}) 
						$core->gameVar['display'][$i] = $word[0] {0};
				}
				If(in_array('-',$core->gameVar['display'])) 
					$core->function->sendMsg("Remaining: ".implode($core->gameVar['display'],' '), $mType, $user->id);
				Else {
					$core->function->sendMsg("Congratulations!({$user->id}) you won. The word was: ".$core->gameVar['word']."(clap)", $mType, $user->id);
					sleep(1);
					unset($core->gameVar);
					$core->gameRunning = False;
				}
			}
		break;
	}
};
