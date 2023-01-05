<div class="site-header">
	<div class="site-logo"><a href="<?=SROOT?>"><img width="92" height="30" src="<?=SROOT?>assets/logos/movynet_logo_184x60.png" alt="<?=SITE_NAME?>"></a></div>
	<div class="search-btn"><button role="button" id="searchBtn"><i class="fa fa-search"></i></button></div>
	<div class="clearfloat"></div>
</div>

<?php if(!isset($query)) $query = ''; ?>
<div class="search-bar-drawer" id="searchBarDrawer">
	<form class="search-bar" action="<?=SROOT?>search.php" method="get" enctype="multipart/form-data">
		<input type="search" name="q" required placeholder="Type to search" value="<?=$query?>" autofocus autocomplete="off">
		<button role="button" type="submit"><i class="fa fa-search"></i></button>
		<div class="clearfloat"></div>
	</form>
</div>
