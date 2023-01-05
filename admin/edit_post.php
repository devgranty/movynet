<?php
session_start();

use Classes\Session;
use Classes\Router;
use Classes\Validate;
use Classes\Database;
use Classes\Datetime;

$_page = 'edit_post';

# Require config file.
require_once __DIR__.'/../config/config.php';

# Require functions and helpers.
require_once __DIR__.'/../functions/functions.php';

# Require autoload.
require_once __DIR__.'/../functions/autoload.php';

# Check if user session is still active.
if(!Session::exists('id')) Router::redirect('login.php');

$validator = new Validate();
$db = Database::getInstance();

# Initialize var array
$tmdb = ['adult' => '', 'backdrop_path' => '', 'budget' => '', 'genres' => '', 'homepage' => '', 'imdb_id' => '', 'original_language' => '', 'original_title' => '', 'overview' => '', 'poster_path' => '', 'production_companies' => '', 'release_date' => '', 'revenue' => '', 'runtime' => '', 'status' => '', 'title' => '', 'vote_average' => '', 'vote_count' => '', 'videos' => ''];
$post = ['download_link_1'=>'', 'download_link_2'=>'', 'download_link_3'=>'', 'download_link_4'=>'', 'download_link_5'=>'', 'download_link_6'=>'', 'download_link_1_info'=>'', 'download_link_2_info'=>'', 'download_link_3_info'=>'', 'download_link_4_info'=>'', 'download_link_5_info'=>'', 'download_link_6_info'=>''];

if(!empty($_GET['m_id']) && $validator->validateInt($_GET['m_id'])){
	$m_id = sanitize_int($_GET['m_id']);

	# Get post info from db.
	$selectQuery = $db->selectQuery('_posts', ['adult', 'backdrop_path', 'budget', 'genres', 'homepage', 'imdb_id', 'original_language', 'original_title', 'overview', 'poster_path', 'production_companies', 'release_date', 'revenue', 'runtime', 'status', 'title', 'vote_average', 'vote_count', 'videos', 'download_links', 'download_links_info', 'post_type', 'last_edited_on', 'source'], [
		'WHERE' => ['id' => $m_id]
	]);
	if(!$selectQuery->error()){
		$data = $selectQuery->results();
		if(!empty($data)){
			$tmdb = $data;
			# Get download links.
			$download_links = explode(' * ', $data['download_links']);
			foreach($download_links as $key => $value){
				$val = $key+1;
				$post['download_link_'.$val] = $value;
			}
			# Get download links info.
			$download_links_info = explode(' * ', $data['download_links_info']);
			foreach($download_links_info as $key => $value){
				$val = $key+1;
				$post['download_link_'.$val.'_info'] = $value;
			}
		}else{
			Router::redirect('posts_table.php');
		}
	}else{
		$_message = $selectQuery->error_info()[2]." Unable to get post info.";
		$_message = alert_message($_message, 'danger');
	}

	# Update post info
	if($_POST){
		$download_links = $_POST['download_link_1']." * ".$_POST['download_link_2']." * ".$_POST['download_link_3']." * ".$_POST['download_link_4']." * ".$_POST['download_link_5']." * ".$_POST['download_link_6'];
		$all_download_links = rtrim($download_links, ' * ');
		$download_links_info = $_POST['download_link_1_info']." * ".$_POST['download_link_2_info']." * ".$_POST['download_link_3_info']." * ".$_POST['download_link_4_info']." * ".$_POST['download_link_5_info']." * ".$_POST['download_link_6_info'];
		$all_download_links_info = rtrim($download_links_info, ' * ');
		$updateQuery = $db->updateQuery('_posts', [
			'original_title' => sanitize_input($_POST['original_title']),
			'overview' => sanitize_input($_POST['overview']),
			'release_date' => sanitize_input($_POST['release_date']),
			'runtime' => sanitize_input($_POST['runtime']),
			'status' => sanitize_input($_POST['status']),
			'title' => sanitize_input($_POST['title']),
			'download_links' => $all_download_links,
			'download_links_info' => $all_download_links_info,
			'last_edited_on' => $_POST['last_edited_on'],
			'source' => $_POST['source']], [
				'id' => $m_id
			]);
		if(!$updateQuery->error()){
			$_message = "Post successfully updated.";
			$_message = alert_message($_message, 'success');
		}else{
			$_message = $updateQuery->error_info()[2]." Failed to update post.";
			$_message = alert_message($_message, 'danger');
		}
		# Retrieve all download links and links info.
		$post = $_POST;
	}
}else{
	Router::redirect('posts_table.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Edit post &#8208; <?=SITE_NAME?> Admin</title>
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

	<div class="col-md-8 col-md-offset-2 well">

		<h2 class="text-center">Editing "<?=$tmdb['title']?> [<?=$tmdb['release_date']?>]"</h2>
		<h4 class="text-center help-block">All inputs marked * are required</h4>
		<form role="form" action="" method="post" enctype="multipart/form-data">
			<div class="form-group row">
				<div class="col-xs-6 col-md-4">
					<label for="adult">Adult</label>
					<input type="text" name="adult" placeholder="Adult" class="form-control" value="<?=$tmdb['adult']?>" readonly>
				</div>
				<div class="col-xs-6 col-md-4">
					<label for="backdrop path">Backdrop path</label>
					<input type="text" name="backdrop_path" placeholder="Backdrop path" class="form-control" value="<?=$tmdb['backdrop_path']?>" readonly>
				</div>
				<div class="col-md-4">
					<label for="username">Budget</label>
					<input type="text" name="budget" placeholder="Budget" class="form-control" value="<?=$tmdb['budget']?>" readonly>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-6 col-md-4">
					<label for="email">Genres</label>
					<input type="text" name="genres" placeholder="Genres" class="form-control" value="<?=$tmdb['genres']?>" readonly>
				</div>

				<div class="col-xs-6 col-md-4">
					<label for="homepage">Homepage</label>
					<input type="url" name="homepage" placeholder="homepage" class="form-control" value="<?=$tmdb['homepage']?>" readonly>
				</div>

				<div class="col-md-4">
					<label for="imdb id">IMDB ID</label>
					<input type="text" name="imdb_id" placeholder="IMDB ID" class="form-control" value="<?=$tmdb['imdb_id']?>" readonly>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-6 col-md-4">
					<label for="original language">Original language</label>
					<input type="text" name="original_language" placeholder="Original language" class="form-control" value="<?=$tmdb['original_language']?>" readonly>
				</div>
				<div class="col-xs-6 col-md-4">
					<label for="original title">Original title</label>
					<input type="text" name="original_title" placeholder="Original title" class="form-control" value="<?=$tmdb['original_title']?>">
				</div>
				<div class="col-md-4">
					<label for="overview">*Overview</label>
					<textarea name="overview" required placeholder="Overview" class="form-control" rows="3"><?=$tmdb['overview']?></textarea>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-6 col-md-4">
					<label for="poster path">Poster path</label>
					<input type="text" name="poster_path" placeholder="Poster path" class="form-control" value="<?=$tmdb['poster_path']?>" readonly>
				</div>
				<div class="col-xs-6 col-md-4">
					<label for="production companies">Production companies</label>
					<input type="text" name="production_companies" placeholder="Production companies" class="form-control" value="<?=$tmdb['production_companies']?>" readonly>
				</div>
				<div class="col-md-4">
					<label for="release date">*Release date</label>
					<input type="text" name="release_date" required placeholder="Release date" class="form-control" value="<?=$tmdb['release_date']?>" pattern="[0-9\-]{1,}" title="Must contain numbers and character(-) only">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-6 col-md-4">
					<label for="revenue">Revenue</label>
					<input type="text" name="revenue" placeholder="Revenue" class="form-control" value="<?=$tmdb['revenue']?>" readonly>
				</div>
				<div class="col-xs-6 col-md-4">
					<label for="runtime">*Runtime</label>
					<input type="text" name="runtime" required placeholder="Runtime" class="form-control" value="<?=$tmdb['runtime']?>" pattern="[0-9]{1,}" title="Must contain only numbers(in minutes)">
				</div>
				<div class="col-md-4">
					<label for="status">Status</label>
					<input type="text" name="status" placeholder="Status" class="form-control" value="<?=$tmdb['status']?>">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-12">
					<label for="title">*Title</label>
					<input type="text" name="title" required placeholder="Title" class="form-control" value="<?=$tmdb['title']?>">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-6 col-md-4">
					<label for="vote average">Vote average</label>
					<input type="text" name="vote_average" placeholder="Vote average" class="form-control" value="<?=$tmdb['vote_average']?>" readonly>
				</div>
				<div class="col-xs-6 col-md-4">
					<label for="vote count">Vote count</label>
					<input type="text" name="vote_count" placeholder="Vote count" class="form-control" value="<?=$tmdb['vote_count']?>" readonly>
				</div>
				<div class="col-md-4">
					<label for="videos">Videos</label>
					<input type="text" name="videos" placeholder="Videos" class="form-control" value="<?=$tmdb['videos']?>" readonly>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-7">
					<label for="download link 1">Download link 1</label>
					<input type="url" name="download_link_1" placeholder="Download link 1" class="form-control" value="<?=$post['download_link_1']?>" autocomplete="off">
				</div>
				<div class="col-xs-5">
					<label for="download link 1 info">Link 1 info</label>
					<input type="text" name="download_link_1_info" placeholder="Filesize, recommended, etc" class="form-control" value="<?=$post['download_link_1_info']?>" pattern="[A-Za-z0-9,.- ]{0,}" title="Must contain letters, numbers or character(,.-) only" autocomplete="off">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-7">
					<label for="download link 2">Download link 2</label>
					<input type="url" name="download_link_2" placeholder="Download link 2" class="form-control" value="<?=$post['download_link_2']?>" autocomplete="off">
				</div>
				<div class="col-xs-5">
					<label for="download link 2 info">Link 2 info</label>
					<input type="text" name="download_link_2_info" placeholder="Filesize, recommended, etc" class="form-control" value="<?=$post['download_link_2_info']?>" pattern="[A-Za-z0-9,.- ]{0,}" title="Must contain letters, numbers or character(,.-) only" autocomplete="off">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-7">
					<label for="download link 3">Download link 3</label>
					<input type="url" name="download_link_3" placeholder="Download link 3" class="form-control" value="<?=$post['download_link_3']?>" autocomplete="off">
				</div>
				<div class="col-xs-5">
					<label for="download link 3 info">Link 3 info</label>
					<input type="text" name="download_link_3_info" placeholder="Filesize, recommended, etc" class="form-control" value="<?=$post['download_link_3_info']?>" pattern="[A-Za-z0-9,.- ]{0,}" title="Must contain letters, numbers or character(,.-) only" autocomplete="off">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-7">
					<label for="download link 4">Download link 4</label>
					<input type="url" name="download_link_4" placeholder="Download link 4" class="form-control" value="<?=$post['download_link_4']?>" autocomplete="off">
				</div>
				<div class="col-xs-5">
					<label for="download link 4 info">Link 4 info</label>
					<input type="text" name="download_link_4_info" placeholder="Filesize, recommended, etc" class="form-control" value="<?=$post['download_link_4_info']?>" pattern="[A-Za-z0-9,.- ]{0,}" title="Must contain letters, numbers or character(,.-) only" autocomplete="off">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-7">
					<label for="download link 5">Download link 5</label>
					<input type="url" name="download_link_5" placeholder="Download link 5" class="form-control" value="<?=$post['download_link_5']?>" autocomplete="off">
				</div>
				<div class="col-xs-5">
					<label for="download link 5 info">Link 5 info</label>
					<input type="text" name="download_link_5_info" placeholder="Filesize, recommended, etc" class="form-control" value="<?=$post['download_link_5_info']?>" pattern="[A-Za-z0-9,.- ]{0,}" title="Must contain letters, numbers or character(,.-) only" autocomplete="off">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-7">
					<label for="download link 6">Download link 6</label>
					<input type="url" name="download_link_6" placeholder="Download link 6" class="form-control" value="<?=$post['download_link_6']?>" autocomplete="off">
				</div>
				<div class="col-xs-5">
					<label for="download link 6 info">Link 6 info</label>
					<input type="text" name="download_link_6_info" placeholder="Filesize, recommended, etc" class="form-control" value="<?=$post['download_link_6_info']?>" pattern="[A-Za-z0-9,.- ]{0,}" title="Must contain letters, numbers or character(,.-) only" autocomplete="off">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-xs-6 col-md-4">
					<label for="last edited on">Last edited on</label>
					<input type="text" placeholder="Last edited on" class="form-control" value="<?=$data['last_edited_on']?>" readonly>
				</div>
				<div class="col-xs-6 col-md-4">
					<label for="last edited on">Post type</label>
					<input type="text" placeholder="Post type" class="form-control" value="<?=$data['post_type']?>" readonly>
				</div>
				<div class="col-md-4">
					<label for="source">*Source</label>
					<select name="source" required class="form-control">
						<?php $select_1 = ''; ?>
						<?php if(empty($data['source'])): ?>
							<?php $select_1 = 'selected'; ?>
						<?php endif; ?>
						<option value="themoviedb.org">TMDB</option>
						<option <?=$select_1?> value="">None</option>
					</select>
				</div>
			</div>
			<input type="hidden" name="last_edited_on" value="<?=Datetime::getDateTime()?>">
			
			<div class="form-group">
				<input type="submit" value="Update" class="btn btn-primary">
			</div>
		</form>
	</div>

	<script src="<?=SROOT?>assets/js/jQuery-2.2.4.min.js"></script>
	<script src="<?=SROOT?>assets/js/bootstrap.min.js"></script>
</body>
</html>