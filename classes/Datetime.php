<?php

/**
 * 
 * Class Datetime handles date and time manipulation
 * from setting timezone, converting time and setting time.
 *
 */
namespace Classes;

class Datetime{
	
	protected function __construct(){
		date_default_timezone_set(SET_TIMEZONE);
	}

	public static function timeTranslate($timestamp){
		new self();
		$time_ago = strtotime($timestamp);
		$current_time = time();
		$time_difference = $current_time - $time_ago;
		$seconds = $time_difference;
		$minutes = round($seconds / 60);
		$hours = round($seconds / 3600);
		$days = round($seconds / 86400);
		$weeks = round($seconds / 604800);
		$months = round($seconds / 2629440);
		$years = round($seconds / 31553280);
		if($seconds <= 60){
			return "Just now";
		}elseif($minutes <= 60){
			if($minutes == 1){
				return "One minute ago";
			}else{
				return "$minutes minutes ago";
			}
		}elseif($hours <= 24){
			if($hours == 1){
				return "One hour ago";
			}else{
				return "$hours hours ago";
			}
		}elseif($days <= 7){
			if($days == 1){
				return "Yesterday";
			}else{
				return "$days days ago";
			}
		}elseif($weeks <= 4.3){
			if($weeks == 1){
				return "One week ago";
			}else{
				return "$weeks weeks ago";
			}
		}elseif($months <= 12){
			if($months == 1){
				return "One month ago";
			}else{
				return "$months months ago";
			}
		}else{
			if($years == 1){
				return "One year ago";
			}else{
				return "$years years ago";
			}
		}
	}

	public static function timestamp(){
		new self();
		return date('Y-m-j H:i:s');
	}

	public static function getDateTime(){
		new self();
		return date('M j Y \a\t h:ia T');
	}
}
