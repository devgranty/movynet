<?php
use Classes\Database;
use Classes\Validate;

# Require config file.
require_once __DIR__.'/config/config.php';

# Require functions and helpers.
require_once __DIR__.'/functions/functions.php';

# Require autoload.
require_once __DIR__.'/functions/autoload.php';

$db = Database::getInstance();
$validator = new Validate();

if(!empty($_GET['q'])){
	if(isset($_GET['page']) && $validator->validateInt($_GET['page'])){
		$page = sanitize_int($_GET['page']);
	}else{
		$page = 1;
	}
	$type = '';
	$pageLimit = 18;
	$startLimit = ($page-1)*$pageLimit;

	$query = sanitize_input($_GET['q']);

	if(!empty($_GET['type'])){
		$type = sanitize_input($_GET['type']);
		switch($type){
			case 'genre':
				$countQuery = $db->query("SELECT id FROM _posts WHERE genres LIKE '%$query%'", []);
				$totalResults = $countQuery->row_count();
				$selectQuery = $db->query("SELECT id, poster_path, release_date, title, post_type FROM _posts WHERE genres LIKE '%$query%' ORDER BY id DESC LIMIT $startLimit, $pageLimit", []);
				break;
				
			default:
				$countQuery = $db->query("SELECT id FROM _posts WHERE title LIKE '%$query%' OR original_title LIKE '%$query%' OR overview LIKE '%$query%' OR genres LIKE '%$query%' OR release_date LIKE '%$query%'", []);
				$totalResults = $countQuery->row_count();
				$selectQuery = $db->query("SELECT id, poster_path, release_date, title, post_type FROM _posts WHERE title LIKE '%$query%' OR original_title LIKE '%$query%' OR overview LIKE '%$query%' OR genres LIKE '%$query%' OR release_date LIKE '%$query%' ORDER BY id DESC LIMIT $startLimit, $pageLimit", []);
				break;
		}
	}else{
		$countQuery = $db->query("SELECT id FROM _posts WHERE title LIKE '%$query%' OR original_title LIKE '%$query%' OR overview LIKE '%$query%' OR genres LIKE '%$query%' OR release_date LIKE '%$query%'", []);
		$totalResults = $countQuery->row_count();
		$selectQuery = $db->query("SELECT id, poster_path, release_date, title, post_type FROM _posts WHERE title LIKE '%$query%' OR original_title LIKE '%$query%' OR overview LIKE '%$query%' OR genres LIKE '%$query%' OR release_date LIKE '%$query%' ORDER BY id DESC LIMIT $startLimit, $pageLimit", []);
	}
	
	$last = ceil($totalResults/$pageLimit);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once __DIR__.'/includes/google_analytics.php'; ?>
	<?php include_once __DIR__.'/includes/google_adsense.php'; ?>
	<title>Search &#8208; <?=SITE_NAME?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex">
    <meta name="theme-color" content="#dd0404">
	<link rel="icon" href="<?=SROOT?>favicon.png" sizes="32x32" type="image/png">
	<link rel="apple-touch-icon" href="<?=SROOT?>assets/icons/icon-72x72.png" type="image/png">
	<link rel="apple-touch-icon" href="<?=SROOT?>assets/icons/icon-144x144.png" sizes="144x144" type="image/png">
	<link rel="apple-touch-icon" href="<?=SROOT?>assets/icons/icon-152x152.png" sizes="152x152" type="image/png">
	<link rel="dns-prefetch" href="//fonts.googleapis.com">
	<link rel="dns-prefetch" href="//image.tmdb.org">
	<link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
	<link rel="dns-prefetch" href="//www.youtube.com">
	<link rel="dns-prefetch" href="//s7.addthis.com">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
	<link rel="stylesheet" type="text/css" href="<?=SROOT?>assets/css/style.css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?=SROOT?>assets/css/media.style.css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="manifest" href="<?=SROOT?>manifest.json">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="#dd0404">
	<meta name="apple-mobile-web-app-title" content="<?=SITE_NAME?>">
	<meta name="apple-touch-icon" content="<?=SROOT?>assets/icons/icon-152x152.png">
	<meta name="msapplication-TileImage" content="<?=SROOT?>assets/icons/icon-144x144.png">
	<meta name="msapplication-TileColor" content="#dd0404">
	<style type="text/css">
		.search-bar-drawer{display:block;}
		.search-help-container{padding:0 10px; list-style-type:none; max-width:670px; margin:auto;}
		.search-help-container > li:first-child{font-weight:500; font-size:20px; color:#dd0404; margin-bottom:20px;}
		.search-help-container > li:nth-child(2){font-weight:600;}
		.search-help-tips{margin:10px 0 0 40px;}
		.search-help-tips > li{margin-bottom:4px;}
	</style>
</head>
<body>
	<div class="main-container">
		<?php include_once __DIR__.'/includes/nav.php'; ?>
		
		<?php if(!empty($_GET['q'])): ?>
		<div class="drawer">
			<div class="drawer-content"><?=$totalResults?> result(s) found</div>
		</div>
		
		<?php if($totalResults > 0): ?>
		<div class="content-container">
			<section>
				<div class="grid-content-container">
				<?php while($data = $selectQuery->results()): ?>
					<?php $poster_path = TMDB_IMG_BASE_URL.PS.$data['poster_path']; ?>
					<?php if(!empty($data['release_date'])): ?>
						<?php $release_year = date('Y', strtotime($data['release_date'])); ?>
					<?php else: ?>
						<?php $release_year = emptyHandler($data['release_date']); ?>
					<?php endif; ?>
					<div class="grid-material-card">
						<a href="<?=SROOT?>view.php?vwid=<?=$data['id']?>&type=<?=$data['post_type']?>&from=search" class="grid-mc-link">
							<div class="material-card-img" style="background-image:url(<?=$poster_path?>)"></div>
							<div class="material-card-detail">
								<ul class="material-card-detail-ul">
									<li title="<?=$data['title']?>"><?=$data['title']?></li>
									<li><?=$release_year?></li>
								</ul>
							</div>
						</a>
					</div>
				<?php endwhile; ?>
				</div>
				<div class="clearfloat"></div>
			</section>
		</div>
		<?=paginate('search.php', $page, $last, ['q'=>$query, 'type'=>$type])?>

		<?php else: ?>
		<div class="content-container">
			<section>
				<ul class="search-help-container">
					<li>Oops!. Seems we couldn't find any results matching your search query.</li>
					<li>Try:</li>
					<ol class="search-help-tips">
						<li>Reducing your search query.</li>
						<li>Checking your spelling for typographical errors.</li>
						<li>Using a different keyword or using a more common term.</li>
					</ol>
				</ul>
			</section>
		</div>
		<?php endif; ?>

		<?php endif; ?>
	</div>

	<?php include_once __DIR__.'/includes/footer.php'; ?>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript" src="<?=SROOT?>assets/js/script.js"></script>
</body>
</html>