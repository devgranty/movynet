<?php
session_start();

use Classes\Session;
use Classes\Router;
use Classes\Database;

# Require config file.
require_once __DIR__.'/../config/config.php';

# Require functions and helpers.
require_once __DIR__.'/../functions/functions.php';

# Require autoload.
require_once __DIR__.'/../functions/autoload.php';

$db = Database::getInstance();

# If post method is ran, execute code block.
if($_POST){
	$selectQuery = $db->selectQuery('_users', ['id', 'fname', 'lname', 'username', 'level', 'password'], [
		'WHERE' => ['username' => $_POST['username']]
	]);
	if($selectQuery->row_count() > 0){
		$data = $selectQuery->results();
		$password = $data['password'];
		if(password_verify($_POST['password'], $password)){
			Session::set('id', $data['id']);
			Session::set('name', $data['fname'].' '.$data['lname']);
			Session::set('username', $data['username']);
			Session::set('level', $data['level']);
			Router::redirect(AROOT);
		}else{
			$_message = "Incorrect username or password.";
			$_message = alert_message($_message, 'warning');
		}
	}else{
		$_message = "Incorrect username or password.";
		$_message = alert_message($_message, 'warning');
	}
}

# If user session still exists, then redirect to index.
if(Session::exists('id')) Router::redirect(AROOT);
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login &#8208; <?=SITE_NAME?> Admin</title>
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

	<h1 class="text-center">Welcome <?=SITE_NAME?> Admin</h1>
	
	<div class="col-md-4 col-md-offset-4 well">

		<h2 class="text-center">Login</h2>

		<form role="form" action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" name="username" required placeholder="Enter username" class="form-control" minlength="3" maxlength="150" pattern="[A-Za-z0-9._-@ ]{3,150}">
			</div>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" name="password" required placeholder="Enter password" class="form-control" minlength="6">
			</div>
			
			<div class="form-group">
				<input type="submit" value="Login" class="btn btn-primary">
				<a href="<?=SROOT?>" class="btn btn-default pull-right">Go home</a>
			</div>

			<div class="text-right">
				<a href="<?=AROOT?>forgot_password.php" class="text-primary">Forgot Password?</a>
			</div>
		</form>
	</div>
		
	<script src="<?=SROOT?>assets/js/jQuery-2.2.4.min.js"></script>
	<script src="<?=SROOT?>assets/js/bootstrap.min.js"></script>
</body>
</html>