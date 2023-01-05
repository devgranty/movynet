<?php
session_start();

use Classes\Session;
use Classes\Router;
use Classes\Database;
use Classes\Validate;

# Require config file.
require_once __DIR__.'/../config/config.php';

# Require functions and helpers.
require_once __DIR__.'/../functions/functions.php';

# Require autoload.
require_once __DIR__.'/../functions/autoload.php';

$validator = new Validate();
$db = Database::getInstance();

# If post method is ran, execute code block.
if($_POST){
	if($validator->validateEmail($_POST['email'])){
		$selectQuery = $db->selectQuery('_users', ['id', 'username', 'email'], [
			'WHERE' => ['email' => sanitize_email($_POST['email'])]
		]);
		if($selectQuery->row_count() > 0){
			$data = $selectQuery->results();

			$encodedUserId = encodeUserId($data['id']);
			$expiryId = strtotime('+ 24 hours');
			$password_reset_url = SITE_URL.AROOT."reset_password.php?euid=$encodedUserId&expid=$expiryId";
			$subject = SITE_NAME.' admin password reset request.';
			$mail = "
			<!DOCTYPE html>
			<html>
			<head>
				<meta name='viewport' content='width=device-width, initial-scale=1'>
				<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto&display=swap'>
				<style type='text/css'>
					body{font-family:'Roboto', sans-serif;}
					div.container{border:2px solid #ccc; border-radius:7px; word-wrap:break-word;}
					h1.brand{text-align:center; margin:0; padding:0;}
					h2.header{color:#555; text-align:center; font-weight:400; margin:0; padding:5px;}
					p.to-user{color:#777; margin:0; padding-bottom:10px; text-align:center;}
					div.content{text-align:left; border-top:2px solid #ccc; padding:10px 5px 20px 5px; font-size:15px; line-height:1.2;}
					div.content > a{color:#006aff; text-decoration:none; font-size:14px;}
				</style>
			</head>
			<body>
				<div class='container'>
					<h1 class='brand'>".SITE_NAME."</h1>
					<h2 class='header'>".$subject."</h2>
					<p class='to-user'>Hi ".$data['username']."</p>
					<div class='content'>
						We received a recent password reset request from an account with email: ".$data['email'].". If this was you, use this link: <a href='".$password_reset_url."'>".$password_reset_url."</a>(if clicking the link did not work, try copying and pasting it into your browser) to reset your password. 
						<br><br> If this was not from you, please disregard this email. 
						<br><br> This link will automatically expire within 24 hours. 
						<br><br> Thanks, From ".SITE_NAME." admin team.
					</div>
				</div>
			</body>
			</html>";
			$header = "From: noreply@".strtolower(SITE_NAME).".com"."\r\n";
			if(send_mail($data['email'], $subject, $mail, $header, true)){
				$updateQuery = $db->updateQuery('_users', ['reset_password_expiry' => $expiryId], [
					'id' => $data['id']
				]);
				if(!$updateQuery->error()){
					$_message = "Password reset was successful, kindly check your email at $data[email] to complete password reset. Can't find email? - Kindly check in your spam folder.";
					$_message = alert_message($_message, 'success');
				}else{
					$_message = $updateQuery->error_info()[2]." Password reset unsuccessful.";
					$_message = alert_message($_message, 'danger');
				}
			}else{
				$_message = "Failed to send email, password reset unsuccessful.";
				$_message = alert_message($_message, 'warning');
			}
		}else{
			$_message = "This email address does not exist.";
			$_message = alert_message($_message, 'warning');
		}
	}else{
		$_message = "Invalid email address.";
		$_message = alert_message($_message, 'warning');
	}	
}

# If user session still exists, then redirect to index.
if(Session::exists('id')) Router::redirect('index.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Forgot password &#8208; <?=SITE_NAME?> Admin</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex">
	<meta name="theme-color" content="#dd0404">
	<link rel="icon" href="<?=SROOT?>favicon.png" sizes="32x32" type="image/png">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
	<link rel="stylesheet" type="text/css" href="<?=SROOT?>assets/css/bootstrap.min.css" media="screen" title="no title" charset="utf-8">
	<link rel="dns-prefetch" href="//fonts.googleapis.com">
	<style type="text/css">
		html, body{font-family:'Roboto', sans-serif;}
	</style>
</head>
<body>
	<?php if(!empty($_message)) echo $_message; ?>

	<h1 class="text-center">Password recovery</h1>
	
	<div class="col-md-4 col-md-offset-4 well">

		<h2 class="text-center">Enter your email address.</h2>

		<form role="form" action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="email">Email address</label>
				<input type="email" name="email" required placeholder="Enter your email address" class="form-control" minlength="3" maxlength="150" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-z]{3,150}">
			</div>

			<div class="form-group">
				<input type="submit" value="Submit" class="btn btn-primary">
			</div>

			<div class="text-right">
				<a href="<?=AROOT?>login.php" class="text-primary">Login</a>
			</div>
		</form>
	</div>
		
	<script src="<?=SROOT?>assets/js/jQuery-2.2.4.min.js"></script>
	<script src="<?=SROOT?>assets/js/bootstrap.min.js"></script>
</body>
</html>