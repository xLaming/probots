<?php
class DataBase {		
    public $link, $host, $user, $pass, $db;
	 
    public function __construct($host, $user, $pass, $db) {
        $this->link = @mysqli_connect($host, $user, $pass, $db) OR die("<-ERROR-> Failed to connect MYSQL SERVER: [Check connection details].");
		@mysqli_set_charset($this->link,"utf8");
    }
	
    public function query($query = '') {
        If(!is_string($query))return False;
        $final = @mysqli_query($this->link, $query);
        return $final ? $final : False;
    }
	
	public function num_rows($query = '') {
        If(!is_string($query))return False;
        $final = @mysqli_num_rows($this->link, $query);
        return $final ? $final : False;
    }
	
    public function fetch_array($query, $final = Array()) {
        If(!is_string($query) || !($cont = $this->query($query))) return Array();
        While($content = mysqli_fetch_assoc($cont))
           $final[] = $content;
        return !Empty($final) ? $final : Array();
    }
	
    public function protection($content) {
        If(is_array($content)) return Array_map(Array($this,'protection'), $content);
        If(function_exists("mb_convert_encoding")) $content = @mb_convert_encoding($content, "UTF-8", 'auto');
        return $this->link->real_escape_string($content);
    }
     
}