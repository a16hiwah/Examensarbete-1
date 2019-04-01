<nav id="my-account-nav">
	<?php
	$active_page = $this->router->method;
	$pages = array('Overview', 'My Resources', 'My Collections', 'My Comments');

	foreach ($pages as $page)
	{
		if($active_page === str_replace(' ', '_', strtolower($page)))
		{
			echo '<span id="active-page">'.$page.'</span>';
		}
		else
		{
			$href = site_url().'/my-account/'.url_title($page, 'dash', TRUE);
			$html = '<a href="'.$href.'">'.$page.'</a>';
			echo $html;
		}
	}
	
	?>
</nav>