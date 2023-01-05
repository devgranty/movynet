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

if(!empty($_GET['euid']) && !empty($_GET['expid']) && $validator->validateInt($_GET['euid']) && $validator->validateInt($_GET['expid'])){
	$user_id = sanitize_int(resolveUserId($_GET['euid']));
	$expiryId = sanitize_int($_GET['expid']);
	$selectQuery = $db->selectQuery('_users', ['reset_password_expiry'], [
		'WHERE' => ['id' => $user_id, 'reset_password_expiry' => $expiryId]
	]);
	$data = $selectQuery->results();
	if($data['reset_password_expiry'] > strtotime('now')){
		if($selectQuery->row_count() > 0){
			if($_POST){
				if($validator->comparePassword($_POST['password'], $_POST['confirmpassword'])){
					$updateQuery = $db->updateQuery('_users', [
						'password' => password_hash($_POST['password'], PASSWORD_DEFAULT), 
						'reset_password_expiry' => ''], ['id' => $user_id]);
					if(!$updateQuery->error()){
						$_message = "Your password has been updated successfully.";
						$_message = alert_message($_message, 'success');
					}else{
						$_message = $updateQuery->error_info()[2]." Failed to update password.";
						$_message = alert_message($_message, 'warning');
					}
				}else{
					$_message = "Passwords do not match.";
					$_message = alert_message($_message, 'warning');
				}
			}
		}else{
			Router::redirect('login.php');
		}
	}else{
		Router::redirect('login.php');	
	}
}else{
	Router::redirect('login.php');
}

# If user session still exists, then redirect to index.
if(Session::exists('id')) Router::redirect('index.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Reset password &#8208; <?=SITE_NAME?> Admin</title>
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

		<h2 class="text-center">Enter new password.</h2>

		<form role="form" action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="password">New password</label>
				<input type="password" name="password" required placeholder="New password"class="form-control" minlength="6">
			</div>

			<div class="form-group">
				<label for="confirm password">Confirm new password</label>
				<input type="password" name="confirmpassword" required placeholder="Confirm new password" class="form-control" minlength="6">
			</div>

			<div class="form-group">
				<input type="submit" value="Update" class="btn btn-primary">
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