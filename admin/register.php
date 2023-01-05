<?php
session_start();

use Classes\Session;
use Classes\Router;
use Classes\Validate;
use Classes\Database;
use Classes\Datetime;

$_page = 'register';

# Require config file.
require_once __DIR__.'/../config/config.php';

# Require functions and helpers.
require_once __DIR__.'/../functions/functions.php';

# Require autoload.
require_once __DIR__.'/../functions/autoload.php';

# Check if user session is still active.
if(!Session::exists('id')) Router::redirect('login.php');

# Check user level
if(Session::get('level') == 'Editor') Router::redirect('403.php');

$validator = new Validate();
$db = Database::getInstance();

# Initialize var array
$post = ['fname'=>'', 'lname'=>'', 'username'=>'', 'email'=>'', 'mobile_number'=>'', 'password'=>'', 'confrimpassword'=>'', 'last_edited_on'=>''];

# If post method is ran, execute code block.
if($_POST){
	if($validator->comparePassword($_POST['password'], $_POST['confrimpassword'])){
		if($validator->checkDuplicates($_POST['username'], '_users', 'username') == 0){
			if($validator->checkDuplicates($_POST['email'], '_users', 'email') == 0){
				if($validator->validateEmail($_POST['email'])){
					$insertQuery = $db->insertQuery('_users', [
						'fname' => sanitize_input($_POST['fname']),
						'lname' => sanitize_input($_POST['lname']),
						'username' => sanitize_input($_POST['username']),
						'email' => sanitize_email($_POST['email']),
						'mobile_number' => sanitize_input($_POST['mobile_number']),
						'level' => sanitize_input($_POST['level']),
						'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
						'date_added' => $_POST['date_added'],
						'last_edited_on' => 'Never'
					]);
					if(!$insertQuery->error()){
						$_message = "User registeration was successful.";
						$_message = alert_message($_message, 'success');
					}else{
						$_message = $insertQuery->error_info()[2]." Failed to register user.";
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
	# Retrieve all user typed input.
	$post = $_POST;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register user &#8208; <?=SITE_NAME?> Admin</title>
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

		<h2 class="text-center">Register user</h2>
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
					<input type="tel" name="mobile_number" required placeholder="+234876543210" class="form-control" value="<?=$post['mobile_number']?>" minlength="10" maxlength="20" pattern="\+?[0-9]{10,20}" title="Must contain numbers with or without a + sign at the beginning">
					<p class="help-block">Enter a valid mobile number</p>
				</div>
				<div class="col-md-3">
					<label for="level">*Level</label>
					<select name="level" required class="form-control">
						<option value="Super Admin">Super Admin</option>
						<option value="Admin">Admin</option>
						<option value="Editor" selected>Editor</option>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-6">
					<label for="password">*Password</label>
					<input type="password" name="password" required placeholder="Password" class="form-control" value="<?=$post['password']?>" minlength="6">
				</div>
				<div class="col-md-6">
					<label for="confirm password">*Confirm password</label>
					<input type="password" name="confrimpassword" required placeholder="Confirm password" class="form-control" value="<?=$post['confrimpassword']?>" minlength="6">
				</div>
			</div>

			<input type="hidden" name="date_added" value="<?=Datetime::getDateTime()?>">
			
			<div class="form-group">
				<input type="submit" value="Register" class="btn btn-default">
			</div>
		</form>
	</div>

	<script src="<?=SROOT?>assets/js/jQuery-2.2.4.min.js"></script>
	<script src="<?=SROOT?>assets/js/bootstrap.min.js"></script>
</body>
</html>