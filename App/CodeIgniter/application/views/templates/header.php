<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/styles.css">
	<title><?php echo $title; ?></title>
</head>
<body>
	<nav id="header-nav">
		<?php
		$active_page = $this->router->class;
		$pages = array('Home', 'Resources', 'Collections', 'My account');
		
		foreach ($pages as $page)
		{
			if($active_page === str_replace(' ', '_', strtolower($page)))
			{
				echo '<span id="active-page">'.$page.'</span>';
			}
			else
			{
				$href = site_url().'/'.url_title($page, 'dash', TRUE);
				$html = '<a href="'.$href.'">'.$page.'</a>';
				echo $html;
			}
		}
		?>
	</nav>
	<?php if ($center_content) : ?>
	<div id="content-center">
	<?php else: ?>
	<div id="content">
	<?php endif;
