<?php
session_start();

use Classes\Router;
use Classes\Database;
use Classes\Session;

$_page = 'delete_account';

# Require config file.
require_once __DIR__.'/../config/config.php';

# Require functions and helpers.
require_once __DIR__.'/../functions/functions.php';

# Require autoload.
require_once __DIR__.'/../functions/autoload.php';

# Check if user session is still active.
if(!Session::exists('id')) Router::redirect('login.php');

$db = Database::getInstance();

if(isset($_GET['user_redirect_from_delete_user'])){
	$_message = "You were redirected from the delete user page because you cannot delete your account using the 'delete user' page. To go back to the 'users table' page <a href='".AROOT."users_table.php' class='alert-link'>click here</a>";
	$_message = alert_message($_message, 'info');
}

# If get method is ran, execute code block.
if(isset($_GET['confirm'])){
	if($_GET['confirm'] == 'true'){
		if(Session::get('level') != 'Super Admin'){
			$deleteQuery = $db->deleteQuery('_users', ['id' => Session::get('id')]);
			if(!$deleteQuery->error()){
				Router::redirect('logout.php');
			}else{
				$_message = $deleteQuery->error_info()[2]." Unable to delete your account. That's an error.";
				$_message = alert_message($_message, 'danger');
			}
		}else{
			$_message = "Unable to delete this account. Level: Super Admin.";
			$_message = alert_message($_message, 'warning');
		}
	}else{
		Router::redirect('profile.php');
	}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Delete account &#8208; <?=SITE_NAME?> Admin</title>
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

	<h1 class="text-center">We are sorry to see you go!</h1>

	<div class="panel panel-danger col-md-6 col-md-offset-3">
		<div class="panel-heading text-center">Are you sure you want to delete your account?</div>
		<div class="panel-body">
			<a href="<?=AROOT?>delete_account.php?confirm=true" class="btn btn-danger">Yes, please delete</a>
			<a href="<?=AROOT?>delete_account.php?confirm=false" class="btn btn-default">Cancel</a>
		</div>
		<div class="panel-footer">Notice: Deleting your account prevents you from accessing <?=SITE_NAME?> Admin panel. Confirming this will completely delete your account and you will be automatically logged out.</div>
	</div>

	<script src="<?=SROOT?>assets/js/jQuery-2.2.4.min.js"></script>
	<script src="<?=SROOT?>assets/js/bootstrap.min.js"></script>
</body>
</html>