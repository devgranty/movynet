<?php

# Require config file.
require_once __DIR__.'/config/config.php';

# Require functions and helpers.
require_once __DIR__.'/functions/functions.php';

# Require autoload.
require_once __DIR__.'/functions/autoload.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once __DIR__.'/includes/google_analytics.php'; ?>
	<title>Error 403 (Forbidden)</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex">
	<meta name="theme-color" content="#dd0404">
	<link rel="icon" href="<?=SROOT?>favicon.png" sizes="32x32" type="image/png">
	<link rel="apple-touch-icon" href="<?=SROOT?>assets/icons/icon-72x72.png" type="image/png">
	<link rel="apple-touch-icon" href="<?=SROOT?>assets/icons/icon-144x144.png" sizes="144x144" type="image/png">
	<link rel="apple-touch-icon" href="<?=SROOT?>assets/icons/icon-152x152.png" sizes="152x152" type="image/png">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
	<link rel="stylesheet" type="text/css" href="<?=SROOT?>assets/css/style.css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?=SROOT?>assets/css/media.style.css" media="screen" title="no title" charset="utf-8">
	<style type="text/css">
		html, body{font-family:'Roboto', sans-serif;}
		.error-id-message{background-color:#fff; width:100%; margin-top:-20px; padding:20px 10px;}
		.error-id-message h1{color:#dd0404; font-size:10em;}
		.error-id-message > p{color:#000; margin-bottom:20px;}
		.error-id-message > a{text-decoration:none; color:#dd0404; float:right; border:1px solid #888; padding:10px 6px; border-radius:4px; background-color:#fff;}
		.error-id-message > a:hover{text-decoration:underline; color:#333;}
	</style>
</head>
<body>
	<div class="main-container">

		<div class="content-container">
			<div class="error-id-message">
				<h1>403</h1>
				<p>You are not authorized to access the requested file or directory. Access forbidden. <code>ERR 403</code></p>
				<a href="<?=SROOT?>">Go home</a>
				<div class="clearfloat"></div>
			</div>
		</div>

	</div>
</body>
</html>