<?php
use Classes\Database;

# Require config file.
require_once __DIR__.'/config/config.php';

# Require functions and helpers.
require_once __DIR__.'/functions/functions.php';

# Require autoload.
require_once __DIR__.'/functions/autoload.php';

$db = Database::getInstance();

# initialize vars
$sorts_1 = $sorts_2 = $sorts_3 = $sorts_4 = '';

$selectQuery = $db->selectQuery('_posts', ['id', 'poster_path', 'release_date', 'title', 'post_type'], ['ORDER'=>['id', 'DESC'], 'LIMIT'=>[27]]);

if(!empty($_GET['sort'])){
	$sort = sanitize_input($_GET['sort']);
}else{
	$sort = 'r_d';
}
switch($sort){
	case 'r_d':
		$sortBy = 'release_date * DESC';
		$sortName = 'release date(desc)';
		$sorts_1 = 'class="active"';
		break;

	case 'tt_asc':
		$sortBy = 'title * ASC';
		$sortName = 'title(asc)';
		$sorts_2 = 'class="active"';
		break;

	case 'tt_desc':
		$sortBy = 'title * DESC';
		$sortName = 'title(desc)';
		$sorts_3 = 'class="active"';
		break;

	case 'd_a':
		$sortBy = 'date_added * ASC';
		$sortName = 'date added(asc)';
		$sorts_4 = 'class="active"';
		break;

	default:
		$sortBy = 'release_date * DESC';
		$sortName = 'release date(desc)';
		$sorts_1 = 'class="active"';
		break;
}
?>


<!DOCTYPE html>
<html lang="en" prefix="website: http://ogp.me/ns/website#">
<head>
	<?php include_once __DIR__.'/includes/google_analytics.php'; ?>
	<?php include_once __DIR__.'/includes/google_adsense.php'; ?>
	<title>Home &#8208; <?=SITE_NAME?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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

	<meta name="robots" content="index">
	<meta name="description" content="Easily find, review and download movies you love from a wide range of genres for free.">
	<meta name="author" content="Grant Adiele">
    <link rel="canonical" href="<?=SITE_URL.SROOT?>">
	<meta property="og:title" content="Home &#8208; <?=SITE_NAME?>">
	<meta property="og:type" content="website">
	<meta property="og:image" content="<?=SITE_URL.SROOT?>assets/icons/icon-256x256.png">
	<meta property="og:image:type" content="image/png">
	<meta property="og:image:width" content="256">
	<meta property="og:image:height" content="256">
	<meta property="og:url" content="<?=SITE_URL.SROOT?>">
	<meta property="og:description" content="Easily find, review and download movies you love from a wide range of genres for free.">
	<meta property="og:locale" content="en_US">
	<meta property="og:site_name" content="<?=SITE_NAME?>">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:creator" content="@adielegrant">
	<meta name="twitter:title" content="Home &#8208; <?=SITE_NAME?>">
	<meta name="twitter:description" content="Easily find, review and download movies you love from a wide range of genres for free.">
	<meta name="twitter:image" content="<?=SITE_URL.SROOT?>assets/icons/icon-256x256.png">
	<script type="application/ld+json">
		{
			"@context": "http://schema.org/",
			"@type": "WebSite",
			"url": "<?=SITE_URL.SROOT?>",
			"name": "Home &#8208; <?=SITE_NAME?>",
			"author":{
				"@type": "person",
				"name": "Grant Adiele"
			}
			"description": "Easily find, review and download movies you love from a wide range of genres for free.",
			"potentialAction": {
				"@type": "SearchAction",
				"target": "<?=SITE_URL.SROOT?>/search.php?q={search_query}",
				"query-input": "required name=search_query"
			}
		}
	</script>
	<style type="text/css">
		.genre-tray{max-width:1024px; margin:0 auto; padding-left:5px;}
		.genre-tray a{color:#dd0404; border:1px solid #dd0404;}
	</style>
</head>
<body>
	<?php include_once __DIR__.'/includes/facebook_page_plugin_sdk.php'; ?>
	<div class="main-container">
		<?php include_once __DIR__.'/includes/nav.php'; ?>
		<h1 class="overflow-flex-content-container genre-tray">
			<a href="<?=SROOT?>search.php?q=action&type=genre">Action</a>
			<a href="<?=SROOT?>search.php?q=adventure&type=genre">Adventure</a>
			<a href="<?=SROOT?>search.php?q=animation&type=genre">Animation</a>
			<a href="<?=SROOT?>search.php?q=comedy&type=genre">Comedy</a>
			<a href="<?=SROOT?>search.php?q=crime&type=genre">Crime</a>
			<a href="<?=SROOT?>search.php?q=documentary&type=genre">Documentary</a>
			<a href="<?=SROOT?>search.php?q=drama&type=genre">Drama</a>
			<a href="<?=SROOT?>search.php?q=family&type=genre">Family</a>
			<a href="<?=SROOT?>search.php?q=fantasy&type=genre">Fantasy</a>
			<a href="<?=SROOT?>search.php?q=horror&type=genre">Horror</a>
			<a href="<?=SROOT?>search.php?q=music&type=genre">Music</a>
			<a href="<?=SROOT?>search.php?q=mystery&type=genre">Mystery</a>
			<a href="<?=SROOT?>search.php?q=romance&type=genre">Romance</a>
			<a href="<?=SROOT?>search.php?q=science+fiction&type=genre">Sci-fi</a>
			<a href="<?=SROOT?>search.php?q=thriller&type=genre">Thriller</a>
			<a href="<?=SROOT?>search.php?q=tv+movie&type=genre">TV movie</a>
			<a href="<?=SROOT?>search.php?q=war&type=genre">War</a>
		</h1>

		<div class="content-container">
			<section>
				<h2 class="content-category">Recently added</h2>
				<div class="grid-content-container">
				<?php while($data = $selectQuery->results()): ?>
					<?php $poster_path = TMDB_IMG_BASE_URL.PS.$data['poster_path']; ?>
					<?php if(!empty($data['release_date'])): ?>
						<?php $release_year = date('Y', strtotime($data['release_date'])); ?>
					<?php else: ?>
						<?php $release_year = emptyHandler($data['release_date']); ?>
					<?php endif; ?>
					<div class="grid-material-card">
						<a href="<?=SROOT?>view.php?vwid=<?=$data['id']?>&type=<?=$data['post_type']?>&from=home" class="grid-mc-link">
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

			<section>
				<h2 class="content-category" style="margin-top:20px;">
					Movies <span class="content-category-detail">Sorted by <?=$sortName?></span>
					<div class="clearfloat"></div>
					<div class="overflow-flex-content-container">
						<a href="<?=SROOT?>?sort=r_d" <?=$sorts_1?>>Release date(desc)</a>
						<a href="<?=SROOT?>?sort=tt_asc" <?=$sorts_2?>>Title(asc)</a>
						<a href="<?=SROOT?>?sort=tt_desc" <?=$sorts_3?>>Title(desc)</a>
						<a href="<?=SROOT?>?sort=d_a" <?=$sorts_4?>>Date added(asc)</a>
					</div>
				</h2>
				<div class="grid-content-container page-content"></div>
				<div class="clearfloat"></div>
			</section>
		</div>

		<button role="button" class="site-load-more-button" id="loadMoreBtn">Load more</button>
	</div>

	<?php include_once __DIR__.'/includes/facebook_page_plugin.php'; ?>

	<?php include_once __DIR__.'/includes/footer.php'; ?>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript" src="<?=SROOT?>assets/js/script.js"></script>
	<script type="text/javascript">
	    var pageNum = 1;
	    var pagePath = '<?=SROOT?>includes/fetch_index.php';
	    var sortBy = '<?=$sortBy?>';
	    loadPageContent(pageNum, pagePath, sortBy);
	    $('#loadMoreBtn').click(function(e){
	        pageNum++;
	        loadPageContent(pageNum, pagePath, sortBy);
	    });
    </script>
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c649ac27a7b560a" async></script>
</body>
</html>