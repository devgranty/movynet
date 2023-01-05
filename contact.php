<?php

# Require config file.
require_once __DIR__.'/config/config.php';

# Require functions and helpers.
require_once __DIR__.'/functions/functions.php';

# Require autoload.
require_once __DIR__.'/functions/autoload.php';

if($_POST){
	$mail_to = 'contact@movynet.com';

	$mail = "Name: ".$_POST['name']."\r\n";
	$mail .= "From: ".$_POST['email']."\r\n";
	$mail .= "Type: ".$_POST['contact_type']."\r\n";
	$mail .= $_POST['message'];

	$from = $_POST['email']."\r\n";
	if(send_mail($mail_to, $_POST['subject'], $mail, $from, false)){
		$_message = "Message successfully sent.";
		$_message = alert_feedback($_message);
	}else{
		$_message = "Unable to send message, something went wrong.";
		$_message = alert_feedback($_message);
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once __DIR__.'/includes/google_analytics.php'; ?>
	<title>Contact &#8208; <?=SITE_NAME?></title>
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
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="main-container">
		<?php include_once __DIR__.'/includes/nav.php'; ?>
		<?php if(!empty($_message)) echo $_message; ?>

		<div class="content-container">
			<div class="formContainer" style="margin-top:-20px;">
				<form action="" method="post" enctype="multipart/form-data">
					<h2>Contact</h2>
					<ul class="notice">
						<li>All fields are required</li>
						<li>Why do we require this information? <a href="<?=SROOT?>docs/privacy.php">Learn why</a></li>
					</ul>

					<label for="name"><span>*</span>Name</label>
					<input type="text" name="name" pattern="[a-zA-Z ]{0,50}" required placeholder="Your name" title="Must contain letters and spaces only">

					<label for="email address"><span>*</span>Email address</label>
					<input type="email" name="email" maxlength="50" required placeholder="Your email address">

					<label for="subject"><span>*</span>Subject</label>
					<input type="text" name="subject" maxlength="70" required placeholder="Subject">

					<label for="message"><span>*</span>Message</label>
					<textarea name="message" maxlength="250" rows="5" required placeholder="Message"></textarea>

					<input type="hidden" name="contact_type" value="Contact">
					<button>Submit</button>
				</form>
			</div>

			<div style="margin:20px auto; max-width:700px;">
				<h2 style="text-align:center;">OR</h2>
				<div style="padding:10px;">
					<h3 style="text-align:center;">Send a direct mail to: <a href="mailto:contact@movynet.com" style="color:#0089ff;">contact@movynet.com</a></h3>
				</div>
			</div>
		</div>
	</div>

	<?php include_once __DIR__.'/includes/footer.php'; ?>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript" src="<?=SROOT?>assets/js/script.js"></script>
</body>
</html>