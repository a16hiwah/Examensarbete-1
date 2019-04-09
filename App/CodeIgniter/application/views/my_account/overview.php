<div id="overview-view" class="content">
	<h1>My account</h1>
	<div id="welcome-user">Welcome <?php echo $this->session->username; ?></div>
	<p id="overview-msg">Some of the things you can do in the "My account" section are creating
		new resources and updating your profile. Use the menu above to
		navigate between the different sections.</p>

	<div id="overview-usr-info">
		<?php foreach ($user_info as $row) : ?>
			<img id="profile-img" src="<?php echo $row->img_src ?>" alt="Profile image">
			<div id="overview-about-me">Biography:</div>
			
			<?php if ($row->biography !== NULL) : ?>
				<div id="overview-biography"><?php echo $row->biography; ?></div>
			<?php else: ?>
				<div id="overview-biography-null"><?php echo 'You have not added a biograpy yet.' ?></div>
			<?php endif; ?>
			
			<div id="overview-member-since">Member since: <?php echo substr($row->created, 0, 10); ?></div>
		<?php endforeach; ?>
		<?php echo anchor('edit-profile', 'Edit', 'id="edit-usr-btn"'); ?>
	</div>
</div>