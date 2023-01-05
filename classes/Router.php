<?php

/**
 * Handle routing request such as redirects
 * and get url contents using this class.
 *
 */
namespace Classes;

class Router{
	public static function redirect($url){
		if(!headers_sent()){
			header("Location:$url");
			exit();
		}else{
			echo "<meta http-equiv='refresh' content='0;url=$url'/>";
			exit();
		}
	}

	public static function get_file_contents_curl($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
}
