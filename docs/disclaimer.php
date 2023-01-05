<?php

# Require config file.
require_once __DIR__.'/../config/config.php';

# Require functions and helpers.
require_once __DIR__.'/../functions/functions.php';

# Require autoload.
require_once __DIR__.'/../functions/autoload.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once __DIR__.'/../includes/google_analytics.php'; ?>
	<title>Disclaimer &#8208; <?=SITE_NAME?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex">
    <meta name="theme-color" content="#dd0404">
	<link rel="icon" href="<?=SROOT?>favicon.png" sizes="32x32" type="image/png">
	<link rel="apple-touch-icon" href="<?=SROOT?>assets/icons/icon-72x72.png" type="image/png">
	<link rel="apple-touch-icon" href="<?=SROOT?>assets/icons/icon-144x144.png" sizes="144x144" type="image/png">
	<link rel="apple-touch-icon" href="<?=SROOT?>assets/icons/icon-152x152.png" sizes="152x152" type="image/png">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
	<link rel="stylesheet" type="text/css" href="<?=SROOT?>assets/css/style.css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?=SROOT?>assets/css/media.style.css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="main-container">
		<?php include_once __DIR__.'/../includes/nav.php'; ?>
		<div class="drawer">
			<h2 class="drawer-content">Disclaimer</h2>
		</div>
		<div class="content-container">
			<section class="document-section">
				<p>THIS DISCLAIMER IS AN AGREEMENT BETWEEN MOVYNET AND YOU AND IT SETS FORTH THE GENERAL GUIDELINES OF YOUR USE OF THIS WEBSITE.</p>
			</section>

			<section class="document-section">
				<h3>Representation</h3>
				<p>Any views or opinions represented on this website belong solely to the Content creators and do not represent that of the people that this website may or may not be associated with in professional or personal capacity, unless explicitly stated. Any views or opinions are not intended to malign any religion, ethnic group, club, organization, company or individual.</p>
			</section>

			<section class="document-section">
				<h3>Content and postings</h3>
				<p>You may print a copy of any part of this website for your personal or non-commercial use.</p>
				<p>You may submit comments for the Content available on the website. You may not impersonate any other person through the website. You may not post content that is defamatory, fraudulent, obscene, threatening, invasive of another person's privacy rights or that is otherwise unlawful. You may not post content that infringes on the intellectual property rights of any other person or entity. You may not post any content that includes any computer virus or other code designed to disrupt, damage or limit the functioning of any computer software or hardware.</p>
			</section>

			<section class="document-section">
				<h3>Indemnification and warranties</h3>
				<p>While we have made every attempt to ensure that the information contained on the website is correct, Movynet is not responsible for any errors or omissions or for the results obtained from the use of this information. All information on the website is provided "as is", with no guarantee of completeness, accuracy, timeliness or of the results obtained from the use of this information, and without warranty of any kind. In no event will this website, be liable to you or anyone else for any decision made or action taken in reliance on the information on the website or for any consequential or similar damages, even if advised of the possibility of such damages. Information on the website is for general information purposes only. Furthermore, information contained on the website and any pages linked to from it are subject to change at any time and without warning.</p>
				<p>We reserve the right to modify this disclaimer at any time, effective upon posting of an updated version of this disclaimer on the website.</p>
			</section>

			<section class="document-section">
				<h3>Acceptance of this disclaimer</h3>
				<p>BY ACCESSING THIS WEBSITE, YOU ACKNOWLEDGE THAT YOU HAVE READ THIS DISCLAIMER AND AGREED TO ALL TERMS STATED.</p>

				<p class="doc-date"><span>*</span> Last Updated: February 19, 2019</p>
			</section>
		</div>
	</div>

	<?php include_once __DIR__.'/../includes/footer.php'; ?>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript" src="<?=SROOT?>assets/js/script.js"></script>
</body>
</html>