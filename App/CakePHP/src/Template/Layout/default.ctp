<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?= $this->Html->css('styles.css') ?>
	<title><?php echo $title; ?></title>
</head>
<body>
	<nav id="header-nav">
		<?php
		$active_page = $this->request->params['controller'];
		$pages = array(
			'Home' => 'Home',
			'Resources' => 'Resources',
			'Collections' => 'Collections',
			'MyAccount' => 'My account'
		);
		
		// Check what the active page is to determine what links should be clickable
		foreach ($pages as $controller => $page)
		{
			$is_anchor = NULL;

			// There should not be a link to the currently active page.
			// "Resources" is a special case that will be evaluated in the else block.
			if ($active_page === $controller && $page !== 'Resources')
			{
				$is_anchor = FALSE;
			}
			else
			{
				$active_subpage = $this->request->params['action'];

				// When a resource is opened (action = "open" and not "view"),
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
				$href = '/'.str_replace(' ', '-', strtolower($page));
				echo $this->Html->link(
					$page,
					$href
				);
			}
			else
			{
				echo '<span id="active-header-nav">'.$page.'</span>';
			}
		}
		?>
	</nav>
<div class="container clearfix">
    <?= $this->fetch('content') ?>
</div>
</body>
</html>