<?php
session_start();

use Classes\Session;
use Classes\Router;
use Classes\Database;
use Classes\Validate;

$_page = 'posts_table';

# Require config file.
require_once __DIR__.'/../config/config.php';

# Require functions and helpers.
require_once __DIR__.'/../functions/functions.php';

# Require autoload.
require_once __DIR__.'/../functions/autoload.php';

# Check if user session is still active.
if(!Session::exists('id')) Router::redirect('login.php');

$db = Database::getInstance();
$validator = new Validate();

if(isset($_GET['movie_delete_true'])){
	$_message = "Movie deletion was successful.";
	$_message = alert_message($_message, 'success');
}

if(isset($_GET['page']) && $validator->validateInt($_GET['page'])){
	$page = sanitize_int($_GET['page']);
}else{
	$page = 1;
}
$pageLimit = 50;
$startLimit = ($page-1)*$pageLimit;

$countQuery = $db->selectQuery('_posts', ['id'], []);
$totalResults = $countQuery->row_count();
$selectQuery = $db->selectQuery('_posts', ['id', 'movie_id', 'genres', 'imdb_id', 'release_date', 'status', 'title', 'vote_average', 'videos', 'date_added', 'posted_by'], [
	'ORDER' => ['id', 'DESC'], 'LIMIT' => [$startLimit, $pageLimit]
]);

$last = ceil($totalResults/$pageLimit);
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Posts table &#8208; <?=SITE_NAME?> Admin</title>
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
		.site-paginate{list-style-type:none; margin:0 auto 50px auto; padding:0; text-align:center;}
		.site-paginate > li{display:inline-block; border:1px solid #888; border-radius:4px; background-color:#fff; color:#777; margin-right:5px;}
		.site-paginate > li.active{background-color:#dd0f0f; color:#fff;}
		.site-paginate > li.disabled{pointer-events:none; color:#aaa; border:1px solid #aaa;}
		.site-paginate > li > a{display:inline-block; padding:10px; text-decoration:none; color:inherit;}
	</style>
</head>
<body>
	<?php include_once __DIR__.'/includes/nav.php'; ?>
	<?php if(!empty($_message)) echo $_message; ?>

	<div class="table-responsive col-md-12">

		<h2 class="text-center">Posts table</h2>

		<table class="table table-bordered">
			<thead>
				<tr>
					<td>#</td> <td>Movie ID</td> <td>Genres</td> <td>IMDB ID</td> <td>Release date</td> <td>Status</td> <td>Title</td> <td>Vote average</td> <td>Edit</td> <td>Action</td> <td>Youtube videos</td> <td>Date added</td> <td>Posted by</td>
				</tr>
			</thead>
			<tbody>
				<?php while($data = $selectQuery->results()): ?>
					<tr>
						<td><?=$data['id']?></td>
						<td><?=$data['movie_id']?></td>
						<td><?=$data['genres']?></td>
						<td><?=$data['imdb_id']?></td>
						<td><?=$data['release_date']?></td>
						<td><?=$data['status']?></td>
						<td><?=$data['title']?></td>
						<td><?=$data['vote_average']?></td>
						<td><a href="<?=AROOT?>edit_post.php?m_id=<?=$data['id']?>" class="btn btn-primary">Edit</a></td>
						<td><a href="<?=AROOT?>delete_post.php?m_id=<?=$data['id']?>" class="btn btn-danger">Delete</a></td>
						<td><?=$data['videos']?></td>
						<td><?=$data['date_added']?></td>
						<td><?=$data['posted_by']?></td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>

		<?=paginate('posts_table.php', $page, $last, [])?>
	</div>

	<script src="<?=SROOT?>assets/js/jQuery-2.2.4.min.js"></script>
	<script src="<?=SROOT?>assets/js/bootstrap.min.js"></script>
</body>
</html>