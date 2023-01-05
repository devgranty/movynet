<?php
use Classes\Database;
use Classes\Validate;
use Classes\Datetime;
use Classes\Router;

# Require config file.
require_once __DIR__.'/config/config.php';

# Require functions and helpers.
require_once __DIR__.'/functions/functions.php';

# Require autoload.
require_once __DIR__.'/functions/autoload.php';

$db = Database::getInstance();
$validator = new Validate();

if(!empty($_GET['vwid']) && $validator->validateInt($_GET['vwid'])){
	$vwid = sanitize_int($_GET['vwid']);
	$selectQuery = $db->selectQuery('_posts', ['*'], ['WHERE'=>['id' => $vwid]]);
	$data = $selectQuery->results();

	# Process all data
	$backdrop_path = TMDB_IMG_BASE_URL.BS.$data['backdrop_path'];
	$poster_path = TMDB_IMG_BASE_URL.PS2.$data['poster_path'];
	# Fetch title
	$title = $data['title'];
	# Process release year and release date
	if(!empty($data['release_date'])){
		$release_year = date('Y', strtotime($data['release_date']));
		$release_date = date('Y M j', strtotime($data['release_date']));
	}else{
		$release_year = emptyHandler($data['release_date']);
		$release_date = emptyHandler($data['release_date']);
	}
	# Process date added
	$date_added = Datetime::timeTranslate($data['date_added']);
	# Process video
	$video = explode(' * ', $data['videos'])[0];
	# Fetch overview
	$overview = $data['overview'];
	# Process status
	$status = emptyHandler($data['status']);
	# Process genres
	if(!empty($data['genres'])){
		$genre = '';
		$genres = explode(' * ', $data['genres']);
		foreach($genres as $key => $value){
			$genre .= "<a href='".SROOT."search.php?q=$value&type=genre'>$value</a>, ";
		}
		$genre = rtrim($genre, ', ');
	}else{
		$genre = emptyHandler($data['genres']);
	}
	# Process homepage
	if(!empty($data['homepage'])){
		$homepage = "<a href='$data[homepage]' rel='external' target='_blank'>$data[homepage] <i class='fa fa-external-link'></i></a>";
	}else{
		$homepage = emptyHandler($data['homepage']);
	}
	# Process imdb id
	if(!empty($data['imdb_id'])){
		$imdb = "<a href='https://www.imdb.com/title/$data[imdb_id]' rel='external' target='_blank'>https://www.imdb.com/title/$data[imdb_id] <i class='fa fa-external-link'></i></a>";
	}else{
		$imdb = emptyHandler($data['imdb_id']);
	}
	# Process production companies
	$production_companies = emptyHandler($data['production_companies']);
	# Process runtime
	if(!empty($data['runtime'])){
		$seconds = $data['runtime'] * 60;
		$runtime = gmdate('H\h i\m', $seconds);
	}else{
		$runtime = emptyHandler($data['runtime']);
	}
	# Process vote average
	$vote_average = emptyHandler($data['vote_average']);
	# Process vote count
	$vote_count = emptyHandler($data['vote_count']);
	# Process adult
	if($data['adult'] == 1){
		$adult = 'True';
	}else{
		$adult = 'False';
	}
	# Process original title
	$original_title = emptyHandler($data['original_title']);
	# Process original language
	if(!empty($data['original_language'])){
		$original_language = languageDecode($data['original_language']);
	}else{
		$original_language = emptyHandler($data['original_language']);
	}
	# Process budget
	if(!empty($data['budget'])){
		$budget = '$'.number_format($data['budget']);
	}else{
		$budget = emptyHandler($data['budget']);
	}
	# Process revenue
	if(!empty($data['revenue'])){
		$revenue = '$'.number_format($data['revenue']);
	}else{
		$revenue = emptyHandler($data['revenue']);
	}
	# Fetch publisher's name
	$posted_by = $data['posted_by'];
	
	# Fetch related posts
	# Handle genres as an array
	if(!empty($data['genres'])){
		$addToRelatedQuery = 'WHERE ';
		$relatedGenres = explode(' * ', $data['genres']);
		foreach($relatedGenres as $key => $value){
			$addToRelatedQuery .= "genres LIKE '%$value%' OR ";
		}
		$addToRelatedQuery = rtrim($addToRelatedQuery, ' OR ');
	}else{
		$addToRelatedQuery = '';
	}
	$relatedQuery = $db->query("SELECT id, poster_path, release_date, title, post_type FROM _posts {$addToRelatedQuery} ORDER BY RAND() LIMIT 15", []);
}else{
	Router::redirect('404.php');
}
if(empty($title)){
	Router::redirect('404.php');
}

if($_POST){
	$mail_to = 'contact@movynet.com';

	$mail = "Post ID: ".$_POST['post_vwid']."\r\n";
	$mail .= "Post title: ".$_POST['post_title']."\r\n";
	$mail .= "From: ".$_POST['email']."\r\n";
	$mail .= "Type: ".$_POST['contact_type']."\r\n";
	$mail .= $_POST['issue_description'];

	$from = $_POST['email']."\r\n";
	if(send_mail($mail_to, $_POST['issue'], $mail, $from, false)){
		$_message = "Report sent successfully.";
		$_message = alert_feedback($_message);
	}else{
		$_message = "Unable to send report, something went wrong.";
		$_message = alert_feedback($_message);
	}
}
?>


<!DOCTYPE html>
<html lang="en" prefix="website: http://ogp.me/ns/website#">
<head>
	<?php include_once __DIR__.'/includes/google_analytics.php'; ?>
	<?php include_once __DIR__.'/includes/google_adsense.php'; ?>
	<?php if(!empty($title)): ?>
	<title><?=$title?> &#8208; <?=SITE_NAME?></title>
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
	<meta name="description" content="<?=$overview?>">
	<meta name="author" content="Grant Adiele">
    <link rel="canonical" href="<?=SITE_URL.SROOT?>view.php?vwid=<?=$vwid?>&type=<?=$data['post_type']?>&utm_source=external">
	<meta property="og:title" content="<?=$title?> &#8208; <?=SITE_NAME?>">
	<meta property="og:type" content="website">
	<meta property="og:image" content="<?=$backdrop_path?>">
	<meta property="og:image:type" content="image/jpeg">
	<meta property="og:image:alt" content="<?=$overview?>">
	<meta property="og:image:width" content="780">
	<meta property="og:image:height" content="439">
	<meta property="og:url" content="<?=SITE_URL.SROOT?>view.php?vwid=<?=$vwid?>&type=<?=$data['post_type']?>&utm_source=external">
	<meta property="og:description" content="<?=$overview?>">
	<meta property="og:locale" content="en_US">
	<meta property="og:site_name" content="<?=SITE_NAME?>">
	<meta name="twitter:card" content="summary">
	<meta name="twitter:creator" content="@adielegrant">
	<meta name="twitter:title" content="<?=$title?> &#8208; <?=SITE_NAME?>">
	<meta name="twitter:description" content="<?=$overview?>">
	<meta name="twitter:image" content="<?=$backdrop_path?>">
	<script type="application/ld+json">
		{
			"@context": "http://schema.org/",
			"@type": "WebSite",
			"image": [
            	"<?=$poster_path?>"
            ],
			"url": "<?=SITE_URL.SROOT?>view.php?vwid=<?=$vwid?>&type=<?=$data['post_type']?>&utm_source=external",
			"name": "<?=$title?> &#8208; <?=SITE_NAME?>",
			"author":{
				"@type": "person",
				"name": "Grant Adiele"
			}
			"description": "<?=$overview?>",
			"publisher": "<?=$posted_by?>"
		}
	</script>
	<?php endif; ?>
</head>
<body>
	<div class="main-container">
		<?php include_once __DIR__.'/includes/nav.php'; ?>
		<?php if(!empty($_message)) echo $_message; ?>

		<?php if(!empty($title)): ?>
		<div class="content-container">
			<section>
				<div class="backdrop-image-container" style="background-image:url(<?=$backdrop_path?>)"></div>
			</section>

			<section class="section-class">
				<div class="poster-title-container">
					<div class="movie-poster" style="background-image:url(<?=$poster_path?>)"></div>
					<h1 class="movie-title"><?=$title?> <span>(<?=$release_year?>)</span></h1>
					<div class="post-info-container">
						<span><i class="fa fa-clock-o"></i> <?=$date_added?></span>
						<span>&bull; <i class="fa fa-comment-o"></i> <span class="disqus-comment-count" data-disqus-identifier="<?=$vwid?>"></span></span>
					</div>
				</div>
			</section>
			
			<?php if(!empty($video)): ?>
				<section class="section-class">
					<div class="section-header">Teaser/trailer</div>
					<div class="video-container">
						<iframe src="https://www.youtube.com/embed/<?=$video?>" width="853" height="480" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gryroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
				</section>
			<?php endif; ?>

			<?php if(!empty($overview)): ?>
				<section class="section-class">
					<div class="movie-overview-container">
						<div class="overview-header">Overview</div>
						<div class="movie-overview"><?=$overview?></div>
					</div>
				</section>
			<?php endif; ?>

			<section class="section-class">
				<div class="section-header">Movie details</div>
				<ul class="movie-details-container">
					<li><i class="fa fa-check-square"></i> Status <div><?=$status?></div></li>
					<li><i class="fa fa-hashtag"></i> Genres <div><?=$genre?></div></li>
					<li><i class="fa fa-calendar"></i> Release date <div><?=$release_date?></div></li>
					<li><i class="fa fa-globe"></i> Homepage <div><?=$homepage?></div></li>
					<li><i class="fa fa-imdb"></i> IMDB <div><?=$imdb?></div></li>
					<li><i class="fa fa-industry"></i> Production companies <div><?=$production_companies?></div></li>
					<li><i class="fa fa-hourglass-end"></i> Runtime <div><?=$runtime?></div></li>
					<li><i class="fa fa-asterisk"></i> Vote average <div><?=$vote_average?></div></li>
					<li><i class="fa fa-user"></i> Vote count <div><?=$vote_count?></div></li>
				</ul>
			</section>

			<?php if($relatedQuery->row_count() > 0): ?>
			<section class="section-class">
				<div class="section-header">More movies</div>
				<div class="grid-content-container">
				<?php while($column = $relatedQuery->results()): ?>
					<?php $poster_path = TMDB_IMG_BASE_URL.PS.$column['poster_path']; ?>
					<?php if(!empty($column['release_date'])): ?>
						<?php $release_year = date('Y', strtotime($column['release_date'])); ?>
					<?php else: ?>
						<?php $release_year = emptyHandler($column['release_date']); ?>
					<?php endif; ?>
					<?php if($column['id'] == $vwid): ?>
						<?php continue; ?>
					<?php endif; ?>
					<div class="grid-material-card">
						<a href="<?=SROOT?>view.php?vwid=<?=$column['id']?>&type=<?=$column['post_type']?>&from=view" class="grid-mc-link">
							<div class="material-card-img" style="background-image:url(<?=$poster_path?>)"></div>
							<div class="material-card-detail">
								<ul class="material-card-detail-ul">
									<li title="<?=$column['title']?>"><?=$column['title']?></li>
									<li><?=$release_year?></li>
								</ul>
							</div>
						</a>
					</div>
				<?php endwhile; ?>
				</div>
				<div class="clearfloat"></div>
			</section>
			<?php endif; ?>

			<section class="section-class">
				<div class="section-header">More information</div>
				<ul class="movie-details-container">
					<li><i class="fa fa-asterisk"></i> Adult <div><?=$adult?></div></li>
					<li><i class="fa fa-asterisk"></i> Original title <div><?=$original_title?></div></li>
					<li><i class="fa fa-language"></i> Original language <div><?=$original_language?></div></li>
					<li><i class="fa fa-usd"></i> Budget <div><?=$budget?></div></li>
					<li><i class="fa fa-money"></i> Revenue <div><?=$revenue?></div></li>
				</ul>
			</section>

			<section class="section-class">
				<div class="section-header">Movie download links</div>
				<ul class="movie-details-container">
					<?php if(!empty($data['download_links'])): ?>
						<?php $download_links = explode(' * ', $data['download_links']); ?>
						<?php $download_links_info = explode(' * ', $data['download_links_info']); ?>
						<?php foreach($download_links as $key => $value): ?>
							<?php if(isset($download_links_info[$key])): ?>
								<?php $download_link_info = '['.$download_links_info[$key].']'; ?>
							<?php endif; ?>
							<li><div><a href="<?=$value?>" rel="external" target="_blank"><?=$value?> <?=$download_link_info?> <i class="fa fa-external-link"></i></a></div></li>
						<?php endforeach; ?>
						<button id="reportBtn" class="clickBtnStyle report-link-btn"><i class="fa fa-flag"></i> Report link</button>
						<div class="clearfloat"></div>
					<?php else: ?>
						<li>HD download links are currently not available for this movie, do check back later.</li>
					<?php endif; ?>
				</ul>
				<div id="reportFormContainer" class="formContainer modalContainer" style="display:none;">
					<form action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
						<span role="button" class="modalCloseBtn" id="closeReportModal" title="Close"><i class="fa fa-times"></i></span>
						<h2>Report link</h2>

						<ul class="notice">
							<li>Inputs marked <span style="color:#dd0404;">*</span> are required</li>
							<li>Why do we require this information? <a href="<?=SROOT?>docs/privacy.php">Learn why</a></li>
						</ul>

						<label for="email address"><span>*</span>Email address</label>
						<input type="email" name="email" maxlength="50" required placeholder="Your email address">

						<label for="issue"><span>*</span>Issue</label>
						<select name="issue" required>
							<option>Links are not working</option>
							<option>I am finding it difficult to download from any link</option>
							<option>The file is not available</option>
							<option>Other</option>
						</select>

						<label for="describe your issue">Describe your issue</label>
						<textarea name="issue_description" maxlength="250" rows="5" placeholder="Describe your issue"></textarea>

						<input type="hidden" name="post_vwid" value="<?=$vwid?>">
						<input type="hidden" name="post_title" value="<?=$title?>">
						<input type="hidden" name="contact_type" value="Report">
						<button>Submit</button>
					</form>
				</div>
			</section>

			<section class="section-class pad-lr-10px-section-class margin-t-20px-section-class">
				<div id="disqus_thread"></div>
				<script>
					var disqus_config = function () {
						this.page.url = "<?=SITE_URL.SROOT?>view.php?vwid=<?=$vwid?>&type=<?=$data['post_type']?>";
						this.page.identifier = "<?=$vwid?>";
					};
					(function() {
						var d = document, s = d.createElement('script');
						s.src = 'https://movynet.disqus.com/embed.js';
						s.setAttribute('data-timestamp', +new Date());
						(d.head || d.body).appendChild(s);
					})();
				</script>
				<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
			</section>
			
		</div>

		<?php endif; ?>
	</div>

	<?php include_once __DIR__.'/includes/footer.php'; ?>
	<script id="dsq-count-scr" src="//movynet.disqus.com/count.js" async></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript" src="<?=SROOT?>assets/js/script.js"></script>
	<!-- Go to www.addthis.com/dashboard to customize your tools -->
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5c649ac27a7b560a" async></script>
</body>
</html>