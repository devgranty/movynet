<?php

use Classes\Session;

$link_1 = $link_2 = $link_3 = $link_4 = $link_5 = $link_6 = '';

if(isset($_page)){
	switch ($_page) {
		case 'index':
			$link_1 = 'class="active"';
			break;

		case 'add_post':
			$link_2 = 'class="active"';
			break;

		case 'register':
			$link_3 = 'class="active"';
			break;

		case 'posts_table':
			$link_4 = 'class="active"';
			break;

		case 'users_table':
			$link_5 = 'class="active"';
			break;

		case 'profile':
			$link_6 = 'class="active"';
			break;
	}
}
?>

<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation-menu">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a href="<?=AROOT?>" class="navbar-brand"><?=SITE_NAME?> Admin</a>
	</div>

	<div class="collapse navbar-collapse" id="navigation-menu">
		<ul class="nav navbar-nav">
			<li <?=$link_1?>><a href="<?=AROOT?>">Dashboard</a></li>

			<li <?=$link_2?>><a href="<?=AROOT?>add_post.php">Add post</a></li>

			<li <?=$link_3?>><a href="<?=AROOT?>register.php">Register user</a></li>

			<li class="dropdown">
				<a href="#" class="dropdown-toogle" data-toggle="dropdown" role="button" aria-expanded="false">Tables <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li <?=$link_4?>><a href="<?=AROOT?>posts_table.php">Posts table</a></li>
					<li <?=$link_5?>><a href="<?=AROOT?>users_table.php">Users table</a></li>
				</ul>
			</li>

			<li <?=$link_6?>><a href="<?=AROOT?>profile.php">My profile(<?=Session::get('username')?>)</a></li>

			<li><a href="<?=AROOT?>logout.php">Logout</a></li>

			<form role="search" action="<?=AROOT?>search.php" method="get" enctype="multipart/form-data" class="navbar-form navbar-left">
				<div class="form-group">
					<input type="search" name="query" required placeholder="Search for a post" class="form-control" autocomplete="off">
				</div>
				<button type="submit" class="btn btn-primary">Search</button>
			</form>
		</ul>
	</div>
</nav>
