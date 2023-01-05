<?php
session_start();

use Classes\Session;
use Classes\Router;
use Classes\Database;

$_page = 'index';

# Require config file.
require_once __DIR__.'/../config/config.php';

# Require functions and helpers.
require_once __DIR__.'/../functions/functions.php';

# Require autoload.
require_once __DIR__.'/../functions/autoload.php';

# Check if user session is still active.
if(!Session::exists('id')) Router::redirect('login.php');

$db = Database::getInstance();

# Get post information
$selectPosts = $db->selectQuery('_posts', ['id'], []);
$numberOfPosts = $selectPosts->row_count();

$selectMaxPostId = $db->query("SELECT MAX(id) AS maxPostID FROM _posts", []);
$maxPostId = $selectMaxPostId->results()['maxPostID'];
$selectLastAddedPost = $db->selectQuery('_posts', ['title'], ['WHERE' => ['id'=>$maxPostId]]);
$lastAddedPost = $selectLastAddedPost->results();

$selectMaxVoted = $db->query("SELECT MAX(vote_average) AS maxVoteAvg FROM _posts", []);
$maxVoted = $selectMaxVoted->results()['maxVoteAvg'];
$selectTopVoted = $db->selectQuery('_posts', ['title'], ['WHERE' => ['vote_average'=>$maxVoted]]);
$topVoted = $selectTopVoted->results();

# Get user information
$selectUsers = $db->selectQuery('_users', ['id'], []);
$numberOfUsers = $selectUsers->row_count();

$selectSuperAdmins = $db->selectQuery('_users', ['id'], ['WHERE' => ['level'=>'Super Admin']]);
$numberOfSuperAdmins = $selectSuperAdmins->row_count();

$selectAdmins = $db->selectQuery('_users', ['id'], ['WHERE' => ['level'=>'Admin']]);
$numberOfAdmins = $selectAdmins->row_count();

$selectEditors = $db->selectQuery('_users', ['id'], ['WHERE' => ['level'=>'Editor']]);
$numberOfEditors = $selectEditors->row_count();

$selectMaxUserId = $db->query("SELECT MAX(id) AS maxUserID FROM _users", []);
$maxUserId = $selectMaxUserId->results()['maxUserID'];
$selectLastAddedUser = $db->selectQuery('_users', ['fname', 'lname'], ['WHERE' => ['id'=>$maxUserId]]);
$lastAddedUser = $selectLastAddedUser->results();
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Dashboard &#8208; <?=SITE_NAME?> Admin</title>
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
		.handle-overflow{max-width:40%; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
	</style>
</head>
<body>
	<?php include_once __DIR__.'/includes/nav.php'; ?>

	<div class="col-md-6 col-md-offset-3 well">
		<h2 class="text-center">Dashboard overview</h2>
	</div>

	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-primary col-md-10 col-md-offset-1">
			<div class="panel-heading">Posts Information</div>
			<div class="panel-body">
				<ul class="list-group">
					<li class="list-group-item">All posts <span class="badge handle-overflow"><?=$numberOfPosts?></span></li>
					<li class="list-group-item">Last added post <span class="badge handle-overflow"><?=$lastAddedPost['title']?></span></li>
					<li class="list-group-item">Top voted <span class="badge handle-overflow"><?=$topVoted['title']?></span></li>
				</ul>	
			</div>
		</div>

		<div class="panel panel-primary col-md-10 col-md-offset-1">
			<div class="panel-heading">Users Information</div>
			<div class="panel-body">
				<ul class="list-group">
					<li class="list-group-item">All users <span class="badge handle-overflow"><?=$numberOfUsers?></span></li>
					<li class="list-group-item">Number of Super Admins <span class="badge handle-overflow"><?=$numberOfSuperAdmins?></span></li>
					<li class="list-group-item">Number of Admins <span class="badge handle-overflow"><?=$numberOfAdmins?></span></li>
					<li class="list-group-item">Number of Editors <span class="badge handle-overflow"><?=$numberOfEditors?></span></li>
					<li class="list-group-item">Last added user <span class="badge handle-overflow"><?=$lastAddedUser['fname'].' '.$lastAddedUser['lname']?></span></li>
				</ul>	
			</div>
		</div>
	</div>

	<script src="<?=SROOT?>assets/js/jQuery-2.2.4.min.js"></script>
	<script src="<?=SROOT?>assets/js/bootstrap.min.js"></script>
</body>
</html>