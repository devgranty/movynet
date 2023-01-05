<?php

use Classes\Database;

# Require config file.
require_once __DIR__.'/../config/config.php';

# Require autoload.
require_once __DIR__.'/../functions/autoload.php';

# Require functions and helpers.
require_once __DIR__.'/../functions/functions.php';

$db = Database::getInstance();

if(isset($_POST['page']) && isset($_POST['sortType'])):
$perPage = 18;
$numpage = sanitize_int($_POST['page']);
$limit = (($numpage - 1) * $perPage);
$sortBy = $_POST['sortType'];
$sortArray = explode(' * ', $sortBy);
$selectQuery = $db->selectQuery('_posts', ['id', 'poster_path', 'release_date', 'title', 'post_type'], ['ORDER'=>[$sortArray[0], $sortArray[1]], 'LIMIT'=>[$limit, $perPage]]);
?>

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
<?php endif; ?>
