<?php
session_start();

use Classes\Session;
use Classes\Router;
use Classes\Validate;
use Classes\Database;
use Classes\Datetime;

$_page = 'profile';

# Require config file.
require_once __DIR__.'/../config/config.php';

# Require functions and helpers.
require_once __DIR__.'/../functions/functions.php';

# Require autoload.
require_once __DIR__.'/../functions/autoload.php';

# Check if user session is still active.
if(!Session::exists('id')) Router::redirect('login.php');

$validator = new Validate();
$db = Database::getInstance();

# Initialize var array
$post = ['fname'=>'', 'lname'=>'', 'username'=>'', 'email'=>'', 'mobile_number'=>'', 'level'=>'', 'date_added'=>'', 'last_edited_on'=>''];

# Get user info from db.
$selectQuery = $db->selectQuery('_users', ['fname', 'lname', 'username', 'email', 'mobile_number', 'level', 'date_added', 'last_edited_on'], [
	'WHERE' => ['id' => Session::get('id')]
]);
if(!$selectQuery->error()){
	$data = $selectQuery->results();
	$post = $data;
}else{
	$_message = $selectQuery->error_info()[2]." Unable to get user info.";
	$_message = alert_message($_message, 'danger');
}

# If post method is ran, execute code block.
if($_POST){
	if($validator->comparePassword($_POST['password'], $_POST['confirmpassword'])){
		if($validator->checkDuplicates($_POST['username'], '_users', 'username') < 2){
			if($validator->checkDuplicates($_POST['email'], '_users', 'email') < 2){
				if($validator->validateEmail($_POST['email'])){
					$updateQuery = $db->updateQuery('_users', [
						'fname' => sanitize_input($_POST['fname']),
						'lname' => sanitize_input($_POST['lname']),
						'username' => sanitize_input($_POST['username']),
						'email' => sanitize_email($_POST['email']),
						'mobile_number' => sanitize_input($_POST['mobile_number']),
						'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
						'last_edited_on' => $_POST['last_edited_on']], [
							'id' => Session::get('id')
						]);
					if(!$updateQuery->error()){
						$_message = "Your profile update was successful. You may have to re-login to see changes.";
						$_message = alert_message($_message, 'success');
					}else{
						$_message = $updateQuery->error_info()[2]." Failed to update user.";
						$_message = alert_message($_message, 'danger');
					}
				}else{
					$_message = "Invalid email address.";
					$_message = alert_message($_message, 'warning');
				}
			}else{
				$_message = "The email you entered already exists.";
				$_message = alert_message($_message, 'warning');
			}
		}else{
			$_message = "The username you entered already exists.";
			$_message = alert_message($_message, 'warning');
		}
	}else{
		$_message = "Passwords do not match.";
		$_message = alert_message($_message, 'info');
	}
	# Retrieve all user typed input, except password.
	$post = $_POST;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>My profile &#8208; <?=SITE_NAME?> Admin</title>
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
	<?php include_once __DIR__.'/includes/nav.php'; ?>
	<?php if(!empty($_message)) echo $_message; ?>

	<div class="col-md-8 col-md-offset-2 well">

		<h2 class="text-center">My profile(<?=Session::get('username')?>)</h2>
		<h4 class="text-center help-block">All inputs marked * are required</h4>
		<form role="form" action="" method="post" enctype="multipart/form-data">
			<div class="form-group row">
				<div class="col-xs-6">
					<label for="first name">*First name</label>
					<input type="text" name="fname" required placeholder="John" class="form-control" value="<?=$post['fname']?>" minlength="3" maxlength="150" pattern="[A-Za-z ]{3,150}" title="Must contain letters or spaces only">
				</div>
				<div class="col-xs-6">
					<label for="last name">*Last name</label>
					<input type="text" name="lname" required placeholder="Lukes" class="form-control" value="<?=$post['lname']?>" minlength="3" maxlength="150" pattern="[A-Za-z ]{3,150}" title="Must contain letters or spaces only">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-5">
					<label for="username">*Username</label>
					<input type="text" name="username" required placeholder="JohnLukes20" class="form-control" value="<?=$post['username']?>" minlength="3" maxlength="150" pattern="[A-Za-z0-9._-@ ]{3,150}" title="Must contain letters, numbers, spaces or characters(._-@) only">
				</div>
				<div class="col-md-7">
					<label for="email">*Email</label>
					<input type="email" name="email" required placeholder="example@email.com" class="form-control" value="<?=$post['email']?>" minlength="3" maxlength="150" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[a-z]{3,150}">
					<p class="help-block">Enter a valid email address</p>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-9">
					<label for="mobile number">*Mobile number</label>
					<input type="text" name="mobile_number" required placeholder="+234876543210" class="form-control" value="<?=$post['mobile_number']?>" minlength="10" maxlength="20" pattern="\+?[0-9]{10,20}" title="Must contain numbers with or without a + sign at the beginning">
					<p class="help-block">Enter a valid mobile number</p>
				</div>
				<div class="col-md-3">
					<label for="level">Level</label>
					<input type="text" name="level" placeholder="level" class="form-control" value="<?=$post['level']?>" readonly>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-6">
					<label for="password">*Password</label>
					<input type="password" name="password" required placeholder="Password" class="form-control" value="" minlength="6">
					<p class="help-block">You may always want to keep your password updated! - Enter new or old password</p>
				</div>
				<div class="col-md-6">
					<label for="confirm password">*Confirm password</label>
					<input type="password" name="confirmpassword" required placeholder="Confirm password" class="form-control" value="" minlength="6">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-6">
					<label for="date added">Date added</label>
					<input type="text" name="date_added" placeholder="Date added" class="form-control" value="<?=$post['date_added']?>" readonly>
				</div>
				<div class="col-xs-6">
					<label for="date added">Last edited on</label>
					<input type="text" placeholder="Last edited on" class="form-control" value="<?=$post['last_edited_on']?>" readonly>
				</div>
			</div>
			<input type="hidden" name="last_edited_on" value="<?=Datetime::getDateTime()?>">

			<div class="form-group">
				<input type="submit" value="Update" class="btn btn-default">
				<a href="<?=AROOT?>delete_account.php" class="btn btn-danger pull-right">Delete account</a>
			</div>
		</form>
	</div>

	<script src="<?=SROOT?>assets/js/jQuery-2.2.4.min.js"></script>
	<script src="<?=SROOT?>assets/js/bootstrap.min.js"></script>
</body>
</html>