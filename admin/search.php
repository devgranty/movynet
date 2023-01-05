<?php
session_start();

use Classes\Session;
use Classes\Router;
use Classes\Database;
use Classes\Validate;

$_page = 'search';

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

if(!empty($_GET['query'])){
	if(isset($_GET['page']) && $validator->validateInt($_GET['page'])){
		$page = sanitize_int($_GET['page']);
	}else{
		$page = 1;
	}
	$pageLimit = 50;
	$startLimit = ($page-1)*$pageLimit;

	$query = sanitize_input($_GET['query']);

	$countQuery = $db->query("SELECT id FROM _posts WHERE title LIKE '%$query%' OR genres LIKE '%$query%'", []);
	$totalResults = $countQuery->row_count();
	$selectQuery = $db->query("SELECT id, release_date, title FROM _posts WHERE title LIKE '%$query%' OR genres LIKE '%$query%' ORDER BY id DESC LIMIT $startLimit, $pageLimit", []);

	$last = ceil($totalResults/$pageLimit);
}else{
	Router::redirect('index.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Search &#8208; <?=SITE_NAME?> Admin</title>
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

	<?php if(!empty($_GET['query'])): ?>

	<div class="col-md-6 col-md-offset-3 well">
		<h2 class="text-center"><?=$totalResults?> result(s) found for <?=$query?></h2>
	</div>

	<div class="col-md-4 col-md-offset-4">
		<ul class="list-group list-container">
			<?php while($data = $selectQuery->results()): ?>
				<li class="list-group-item text-center">
					<?=$data['title']." [".$data['release_date']."]"?>
					<div class="text-center">
						<a href="<?=AROOT?>edit_post.php?m_id=<?=$data['id']?>" class="text-primary">Edit</a>
						<a href="<?=AROOT?>delete_post.php?m_id=<?=$data['id']?>" class="text-danger">Delete</a>
					</div>
				</li>
			<?php endwhile; ?>
		</ul>

		<?=paginate('search.php', $page, $last, ['query'=>$query])?>
	</div>

	<?php endif; ?>

	<script src="<?=SROOT?>assets/js/jQuery-2.2.4.min.js"></script>
	<script src="<?=SROOT?>assets/js/bootstrap.min.js"></script>
</body>
</html>