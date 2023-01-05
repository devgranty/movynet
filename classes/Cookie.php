<?php

/**
 * 
 * Handle cookie manipulation easily using this
 * Cookie class.
 * 
 */
namespace Classes;
use Classes\Datetime;

class Cookie extends Datetime{

	public static function set($name, $value, $expiry){
		new parent();
		if(setCookie($name, $value, strtotime($expiry), '/')){
			return true;
		}
		return false;
	}

	public static function delete($name){
		self::set($name, '', 10);
	}

	public static function get($name){
		return $_COOKIE[$name];
	}

	public static function exists($name){
		return isset($_COOKIE[$name]);
	}
}
