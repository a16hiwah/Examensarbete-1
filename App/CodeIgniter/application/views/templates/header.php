<!DOCTYPE html>
<html lang="sv">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title; ?></title>
</head>
<body>
	<nav id="header-nav">
		<?php
		$active_page = $this->router->class;
		$pages = array
		(
			'home'=>'Hem',
			'resources'=>'Resurser',
			'collections'=>'Samlingar',
			'user'=>'Mina sidor'
		);
		
		foreach ($pages as $page => $page_value)
		{
			if($active_page == $page)
			{
				echo '<span id="active-page">'.$page_value.'</span>';
			}
			else
			{
				$href = site_url().'/'.url_title($page_value, 'dash', TRUE);
				$html = '<a href="'.$href.'">'.$page_value.'</a>';
				echo $html;
			}
		}
		?>
	</nav>