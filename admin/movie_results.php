<?php
session_start();

use Classes\Session;
use Classes\Router;
use Classes\Validate;

$_page = 'movie_results';

# Require config file.
require_once __DIR__.'/../config/config.php';

# Require functions and helpers.
require_once __DIR__.'/../functions/functions.php';

# Require autoload.
require_once __DIR__.'/../functions/autoload.php';

# Check if user session is still active.
if(!Session::exists('id')) Router::redirect('login.php');

$validator = new Validate();

if(!empty($_GET['q'])){
	$query = urlencode($_GET['q']);
	if(!isset($_GET['page'])){
		$page = 1;
	}else{
		if($validator->validateInt($_GET['page'])){
			$page = sanitize_int($_GET['page']);
		}else{
			$_message = "Invalid argument passed as page number, defaulting to 1";
			$_message = alert_message($_message, 'warning');
			$page = 1;
		}
	}
	$apiQueryMovieTitle = "https://api.themoviedb.org/3/search/movie?api_key=".TMDB_API_KEY."&query=$query&include_adult=true&page=$page";
	$getMovieTitleResults = searchByMovieTitle($apiQueryMovieTitle);
	if(!isset($getMovieTitleResults['id'])){
		$getMovieTitleResults = ['total_results' => '"Connection error" 0', 'id' => [], 'title' => 0, 'release_date' => 0, 'total_pages' => 0, 'current_page' => 0];
	}
}else{
	Router::redirect('add_post.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Movie results &#8208; <?=SITE_NAME?> Admin</title>
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
		<h2 class="text-center"><?=$getMovieTitleResults['total_results']?> result(s) found for <?=urldecode($query)?></h2>
		<h4 class="text-center">Page: <?=$getMovieTitleResults['current_page']?></h4>
	</div>

	<div class="col-md-4 col-md-offset-4">
		<ul class="list-group">
			<?php $movie_id = $getMovieTitleResults['id']; ?>
			<?php foreach($movie_id as $key => $value): ?>
				<?php $movie_title = $getMovieTitleResults['title'][$key]; ?>
				<?php $release_date = $getMovieTitleResults['release_date'][$key]; ?>
				<li class="list-group-item text-center"><a href="<?=AROOT?>movie_details.php?qid=<?=$value?>" class="text-primary"><?=$movie_title." [".$release_date."]"?></a></li>
			<?php endforeach; ?>
		</ul>

		<ul class="pagination">
			<?php $addClass = ""; ?>
			<?php for($i = 1; $i <= $getMovieTitleResults['total_pages']; $i++): ?>

				<?php if($getMovieTitleResults['current_page'] == $i): ?>
					<?php $addClass = 'class="active"'; ?>
					<li <?=$addClass?>><a href="<?=AROOT?>movie_results.php?q=<?=$query?>&page=<?=$i?>"><?=$i?></a></li>
					<?php continue; ?>
				<?php endif; ?>

					<li><a href="<?=AROOT?>movie_results.php?q=<?=$query?>&page=<?=$i?>"><?=$i?></a></li>
			<?php endfor; ?>
		</ul>
	</div>

	<script src="<?=SROOT?>assets/js/jQuery-2.2.4.min.js"></script>
	<script src="<?=SROOT?>assets/js/bootstrap.min.js"></script>
	<script src="<?=SROOT?>assets/js/pagination.min.js"></script>
</body>
</html>