<?php
session_start();

use Classes\Session;
use Classes\Router;

$_page = 'add_post';

# Require config file.
require_once __DIR__.'/../config/config.php';

# Require functions and helpers.
require_once __DIR__.'/../functions/functions.php';

# Require autoload.
require_once __DIR__.'/../functions/autoload.php';

# Check if user session is still active.
if(!Session::exists('id')) Router::redirect('login.php');

if(isset($_GET['invalid_movie_id'])){
	$_message = "You were redirected from the 'movie details' page because the movie ID passed was invalid.";
	$_message = alert_message($_message, 'info');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Add post &#8208; <?=SITE_NAME?> Admin</title>
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

	<div class="col-md-4 col-md-offset-4 well">
		<h2 class="text-center">Add post</h2>

		<form action="<?=AROOT?>movie_results.php" method="get" enctype="multipart/form-data">
			<div class="form-group row">
				<div class="col-xs-9">
					<label for="movie title" class="sr-only">Movie title</label>
					<input type="search" name="q" required placeholder="Enter a movie title e.g Captain America" class="form-control" autocomplete="off">
				</div>
				<div class="col-xs-3">
					<button type="submit" value="Search" class="btn btn-primary">Search</button>
				</div>
			</div>
		</form>

	</div>

	<script src="<?=SROOT?>assets/js/jQuery-2.2.4.min.js"></script>
	<script src="<?=SROOT?>assets/js/bootstrap.min.js"></script>
</body>
</html>