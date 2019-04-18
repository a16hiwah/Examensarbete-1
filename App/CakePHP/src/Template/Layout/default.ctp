<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?= $this->Html->css('styles.css') ?>
	<title><?= $title ?></title>
</head>
<body>
	<nav id="header-nav">
		<?php
        $active_page = $this->request->getParam('controller');
		$active_subpage = $this->request->getParam('action');
		
		// [controller => Link text]
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
				// When a resource is opened (action = "open" and not "view"),
				// it should be possible to navigate back to the "Resources"
				// page through the top navigation.
				if ($page !== 'Resources' OR $active_subpage !== 'view')
				{
					$is_anchor = TRUE;
				}
				else
				{
					// Having a "view" action in other controllers than
					// "Resources" should not impact navigation.
					if ($active_subpage === 'view' && $active_page === 'Resources') {
						$is_anchor = FALSE;
					} else {
						$is_anchor = TRUE;
					}
					
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
    <?php if($active_page === "MyAccount") : ?>
        <nav id="subheader-nav">
			<?php
			
			// [action => Link text]
            $pages = array(
                'overview' => 'Overview',
                'myResources' => 'My Resources',
                'myCollections' => 'My Collections',
                'myComments' => 'My Comments'
            );

            foreach ($pages as $action => $page)
            {
                if($active_subpage === $action)
                {
                    echo '<span id="active-subheader-nav">'.$page.'</span>';
                }
                else
                {
                    $href = '/my-account/'.str_replace(' ', '-', strtolower($page));
                    echo $this->Html->link(
                        $page,
                        $href
                    );
                }
            }

            ?>
            <?= $this->Html->link('Sign out', '/users/logout', ['id' => 'sign-out-btn']) ?>
        </nav>
    <?php endif; ?>
	<?= $this->fetch('content') ?>
</body>
</html>