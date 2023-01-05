<?php

/**
 * 
 * Handle session manipulation easily using this
 * Session class.
 * 
 */
namespace Classes;

class Session{

	public static function set($name, $value){
		return $_SESSION[$name] = $value;
	}

	public static function exists($name){
		return (isset($_SESSION[$name])) ? true : false;
	}

	public static function get($name){
		return $_SESSION[$name];
	}
	
	public static function delete(){
		session_unset();
		session_destroy();
	}
}
