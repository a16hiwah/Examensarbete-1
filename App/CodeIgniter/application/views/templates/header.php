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
		
		// Check what the active page is to determine what links should be clickable
		foreach ($pages as $page)
		{
			$is_anchor = NULL;

			// There should not be a link to the currently active page.
			// "Resources" is a special case that will be evaluated in the else block.
			if ($active_page === str_replace(' ', '_', strtolower($page)) &&
				$page !== 'Resources')
			{
				$is_anchor = FALSE;
			}
			else
			{
				$active_subpage = $this->router->method;

				// When a resource is opened (method = "open" and not "view"),
				// it should be possible to navigate back to the "Resources"
				// page through the top navigation.
				if ($page !== 'Resources' OR $active_subpage !== 'view')
				{
					$is_anchor = TRUE;
				}
				else
				{
					$is_anchor = FALSE;
				}
			}

			if ($is_anchor)
			{
				$href = site_url().'/'.url_title($page, 'dash', TRUE);
				$html = '<a href="'.$href.'">'.$page.'</a>';
				echo $html;
			}
			else
			{
				echo '<span id="active-page">'.$page.'</span>';
			}
		}
		?>
	</nav>
	<?php if ($center_content) : ?>
	<div id="content-center">
	<?php else: ?>
	<div id="content">
	<?php endif;
