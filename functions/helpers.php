<?php

# Helper functions used in entire application.
function dnd($data){
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	exit();
}

function emptyHandler($variable){
	if(!empty($variable)) return $variable;
	return 'N/A';
}

function paginate($pageName, $page, $last, $additionalQuery = []){
	$links = 2;
	$start = (($page - $links) > 0) ? $page - $links : 1;
	$end = (($page + $links) < $last) ? $page + $links : $last;
	if(is_array($additionalQuery)){
		if(!empty($additionalQuery)){
			$additionalQueries = '';
			foreach($additionalQuery as $key => $value){
				$additionalQueries .= "$key=$value&";
			}
			$query = $additionalQueries;
		}else{
			$query = '';
		}
	}else{
		return "Array required on parameter 4.";
	}
	$html = "<ul class='site-paginate'>";
	$addClass = ($page == 1) ? 'class="disabled"' : '';
	$html .= "<li $addClass><a href='$pageName?".$query."page=".($page-1)."'>&laquo;</li>";

	if($start > 1){
		$html .= "<li><a href='$pageName?".$query."page=1'>1</a></li>";
		$html .= "<li class='disabled'><span>...</span></li>";
	}
	for($i=$start; $i <= $end; $i++){
		$addClass = ($page == $i) ? 'class="active"' : "";
		$html .= "<li $addClass><a href='$pageName?".$query."page=".($i)."'>$i</a></li>";
	}
	if($end < $last){
		$html .= "<li class='disabled'><span>...</span></li>";
		$html .= "<li><a href='$pageName?".$query."page=".($last)."'>$last</a></li>";
	}

	$addClass = ($page >= $last) ? 'class="disabled"' : "";
	$html .= "<li $addClass><a href='$pageName?".$query."page=".($page+1)."'>&raquo;</a></li>";
	$html .= "</ul>";

	return $html;
}

function send_mail($to, $subject, $message, $headers, $boolean = true){
	if(is_bool($boolean)){
		if($boolean){
			$headers .= "MIME-Version: 1.0"."\r\n";
			$headers .= "Content-type: text/html;charset=UTF-8"."\r\n";
		}
	}else{
		return "Boolean required on parameter 4.";
	}
	if(mail($to, $subject, $message, $headers)) return true;
	return false;
}

function alert_feedback($message){
	return "<div class='feedbackModal' id='feedbackContainer' style='display:block;'>
			<div class='feedback'><span id='closeFeedbackModal' title='Close'><i class='fa fa-times'></i></span><div class='clearfloat'></div>$message</div></div>";
}

function alert_message($message, $type){
	switch ($type) {
		case 'success':
			$alert = "<div class='alert alert-success alert-dismissible fade in'><button class='close' data-dismiss='alert' aria-lable='close'>&times;</button><strong>Success! </strong>$message</div>";
			break;

		case 'info':
			$alert = "<div class='alert alert-info alert-dismissible fade in'><button class='close' data-dismiss='alert' aria-lable='close'>&times;</button><strong>Info! </strong>$message</div>";
			break;

		case 'warning':
			$alert = "<div class='alert alert-warning alert-dismissible fade in'><button class='close' data-dismiss='alert' aria-lable='close'>&times;</button><strong>Warning! </strong>$message</div>";
			break;

		case 'danger':
			$alert = "<div class='alert alert-danger alert-dismissible fade in'><button class='close' data-dismiss='alert' aria-lable='close'>&times;</button><strong>Danger! </strong>$message</div>";
			break;

		default:
			$alert = "<div class='alert alert-info alert-dismissible fade in'><button class='close' data-dismiss='alert' aria-lable='close'>&times;</button><strong>Info! </strong>$message</div>";
			break;
	}
	return $alert;
}

function encodeUserId($userInt){
	$userInt = $userInt * 595836;
	return $userInt + 256749;
}

function resolveUserId($userInt){
	$userInt = $userInt - 256749;
	return $userInt / 595836;
}

function languageDecode($code){
	$languageCodeArray = ['ab'=>'Abkhazian', 'aa'=>'Afar', 'af'=>'Afrikaans', 'sq'=>'Albanian', 'am'=>'Amharic', 'ar'=>'Arabic', 'an'=>'Aragonese', 'hy'=>'Armenian', 'as'=>'Assamese', 'ae'=>'Avestan', 'ay'=>'Aymara', 'az'=>'Azerbaijani', 'ba'=>'Basgkir', 'eu'=>'Basque', 'be'=>'Belarusian', 'bn'=>'Bengali', 'bh'=>'Bihari', 'bi'=>'Bislama', 'bs'=>'Bosnian', 'br'=>'Breton', 'bg'=>'Bulgarian', 'my'=>'Burmese', 'ca'=>'Catalan', 'ch'=>'Chamorro', 'ce'=>'Chechen', 'zh'=>'Chinese', 'cu'=>'Church Slavic; Salvonic; Old Bulgarian', 'cv'=>'Chuvash', 'kw'=>'Cornish', 'co'=>'Corsican', 'hr'=>'Croatian', 'cs'=>'Czech', 'da'=>'Danish', 'dv'=>'Divehi; Dhivehi; Maldivian', 'nl'=>'Dutch', 'dz'=>'Dzongkha', 'en'=>'English', 'eo'=>'Esperanto', 'et'=>'Estonian', 'fo'=>'Faroese', 'fj'=>'Fijian', 'fi'=>'Finnish', 'fr'=>'French', 'gd'=>'Gaelic; Scottish Gaelic', 'gl'=>'Galician', 'ka'=>'Georgian', 'de'=>'German', 'el'=>'Greek, Modern (1453-)', 'gn'=>'Guarani', 'gu'=>'Gujarati', 'ht'=>'Haitian; Haitian Creole', 'ha'=>'Hausa', 'He'=>'Hebrew', 'hz'=>'Herero', 'hi'=>'Hindi', 'ho'=>'Hiri Motu', 'hu'=>'Hungarian', 'is'=>'Icelandic', 'io'=>'Ido', 'id'=>'Indonesian', 'ia'=>'Interligua(International Auxiliary Language Association)', 'ie'=>'Interligua', 'iu'=>'Inuktitut', 'ik'=>'Inupiaq', 'ga'=>'Irish', 'it'=>'Italian', 'ja'=>'Japanese', 'jv'=>'Javanese', 'kl'=>'Kalaallisut', 'kn'=>'kannada', 'ks'=>'Kashmiri', 'kk'=>'Kazakh', 'km'=>'Khmer', 'ki'=>'Kikuyu; Gikuyu', 'rw'=>'Kinyarwanda', 'ky'=>'Kirghiz', 'kv'=>'Komi', 'ko'=>'Korean', 'kj'=>'Kuanyama; Kwanyama', 'ku'=>'Kurdish', 'lo'=>'Lao', 'la'=>'Latin', 'lv'=>'Latvian', 'li'=>'Limburgan; Limburger; Limburgish', 'ln'=>'Lingala', 'lt'=>'Lithuanian', 'lb'=>'Luxembourgish; Letzeburgesch', 'mk'=>'Macedonian', 'mg'=>'Malagasy', 'ms'=>'Malay', 'mt'=>'Malayalam', 'gv'=>'Manx', 'mi'=>'Maroi', 'mr'=>'Marathi', 'mh'=>'Marshallese', 'mo'=>'Moldavian', 'mn'=>'Mongolian', 'na'=>'Nauru', 'nv'=>'Navaho; Navajo', 'nd'=>'Ndebele, North', 'nr'=>'Ndebele, South', 'ng'=>'Ndonga', 'ne'=>'Nepali', 'se'=>'Northern Sami', 'no'=>'Norwegian', 'nb'=>'Norwegian Bokmal', 'nn'=>'Norwegian Nynorsk', 'ny'=>'Nyanja; Chichewa; Chewa', 'oc'=>'Occitan(post 1500); Provencal', 'or'=>'Oriya', 'om'=>'Oromo', 'os'=>'Ossetian; Ossetic', 'pi'=>'Pali', 'pa'=>'Panjabi', 'fa'=>'Persian', 'pl'=>'Polish', 'pt'=>'Portuguese', 'ps'=>'Pushto', 'qu'=>'Quechua', 'rm'=>'Raeto-Romance', 'rn'=>'Rundi', 'ru'=>'Russian', 'sm'=>'Samoan', 'sg'=>'Sango', 'sa'=>'Sanskirt', 'sc'=>'Sardinian', 'sr'=>'Serbian', 'sn'=>'Shona', 'ii'=>'Sichuan Yi', 'sd'=>'Sindhi', 'si'=>'Sinhala; Sinhalese', 'sk'=>'Slovak', 'sl'=>'Slovenian', 'so'=>'Somali', 'st'=>'Sotho, Southern', 'es'=>'Spanish; Castilian', 'su'=>'Sundanese', 'sw'=>'Swahili', 'ss'=>'Swati', 'sv'=>'Swedish', 'tl'=>'Tagalog', 'ty'=>'Tahitian', 'tg'=>'Tajik', 'ta'=>'Tamil', 'tt'=>'Tatar', 'te'=>'Telugu', 'th'=>'Thai', 'bo'=>'Tibetan', 'ti'=>'Tigrinya', 'to'=>'Tonga(Tonga Islands)', 'ts'=>'Tsongo', 'tn'=>'Tswana', 'tr'=>'Turkish', 'tk'=>'Turkmen', 'tw'=>'Twi', 'ug'=>'Uighur', 'uk'=>'Ukrainian', 'ur'=>'Urdu', 'uz'=>'Uzbek', 'vi'=>'Vietnamese', 'vo'=>'Volapuk', 'wa'=>'Walloon', 'cy'=>'Welsh', 'fy'=>'Western Frisian', 'wo'=>'Wolof', 'xh'=>'Xhosa', 'yi'=>'Yiddish', 'yo'=>'Yoruba', 'za'=>'Zhuang; Chuang', 'zu'=>'Zulu'];
	if(array_key_exists($code, $languageCodeArray)) return $languageCodeArray[$code];
	return $code;
}
