<?php
session_start();

use Classes\Session;
use Classes\Router;
use Classes\Database;
use Classes\Validate;

$_page = 'delete_post';

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

# Initialize vars
$m_id = 'nomovie';
$data = ['title'=>'Invalid movie'];

# If get method is ran, execute code block.
if(!empty($_GET['m_id']) && $validator->validateInt($_GET['m_id'])){
	$m_id = sanitize_int($_GET['m_id']);
	$selectQuery = $db->selectQuery('_posts', ['title'], [
		'WHERE' => ['id' => $m_id]
	]);
	if($selectQuery->row_count() > 0){
		$data = $selectQuery->results();
		if(isset($_GET['confirm'])){
			if($_GET['confirm'] == 'true'){
				$deleteQuery = $db->deleteQuery('_posts', ['id' => $m_id]);
				if(!$deleteQuery->error()){
					Router::redirect('posts_table.php?movie_delete_true');
				}else{
					$_message = $deleteQuery->error_info()[2]." Unable to delete this movie. That's an error.";
					$_message = alert_message($_message, 'danger');
				}
			}else{
				Router::redirect('posts_table.php');
			}
		}
	}else{
		$_message = "This movie does not exist.";
		$_message = alert_message($_message, 'warning');
		if(isset($_GET['confirm'])) Router::redirect('posts_table.php');
	}
}else{
	$_message = "Invalid movie id.";
	$_message = alert_message($_message, 'warning');
	if(isset($_GET['confirm'])) Router::redirect('posts_table.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Delete post &#8208; <?=SITE_NAME?> Admin</title>
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

	<div class="panel panel-danger col-md-6 col-md-offset-3">
		<div class="panel-heading text-center">Are you sure you want to delete this movie, "<?=$data['title']?>"?</div>
		<div class="panel-body">
			<a href="<?=AROOT?>delete_post.php?m_id=<?=$m_id?>&confirm=true" class="btn btn-danger">Yes, please delete</a>
			<a href="<?=AROOT?>delete_post.php?m_id=<?=$m_id?>&confirm=false" class="btn btn-default">Cancel</a>
		</div>
		<div class="panel-footer">Notice: Confirming this will completely delete this movie from <?=SITE_NAME?> database.</div>
	</div>

	<script src="<?=SROOT?>assets/js/jQuery-2.2.4.min.js"></script>
	<script src="<?=SROOT?>assets/js/bootstrap.min.js"></script>
</body>
</html>