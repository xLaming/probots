<?php
class Translations {
	public $parent;
	public $lang       = Array(0 => 'english', 1 => 'spanish', 2 => 'portuguese'); // Language IDs
	public $trans      = Array();
	public $translated = Array();
	
	public function __construct($parent, $translations, $lang) {
		$this->parent = $parent;
		$this->trans = json_decode($translations, True);
		$default = $this->parent->sql->fetch_array("SELECT * FROM `translations`;");
		Foreach($default AS $i) {
			$this->translated[$i['string']] = $i[$this->lang[$lang]];
			If(array_key_exists($i['string'], $this->trans))
				$this->translated[$i['string']] = $this->trans[$i['string']];
		}
	}
	
	public function __r($string) {
		return array_key_exists($string, $this->translated) ? $this->translated[$string] : 'Invalid arg[1]';
	}
	
	public function __($string, $args=Array()) {
		If(!is_array($args) || Empty($string))
			return 'Invalid arg[2]';
		Else {
			$t = array_key_exists($string, $this->translated) ? $this->translated[$string] : False;
			If(Empty($t))
				return 'Invalid arg[3]';
			$final = str_replace('[x]', '%s', $t);
			return vsprintf($final, $args);
		}
	}
	
}
?>