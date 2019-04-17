<div id="overview-view" class="content">
	<h1>My account</h1>
	<div id="welcome-user">Welcome <?php echo $username; ?></div>
	<p id="overview-msg">Some of the things you can do in the "My account" section are creating
		new resources and updating your profile. Use the menu above to
		navigate between the different sections.</p>

	<div id="overview-usr-info">
		<img id="profile-img" src="<?php echo $profile_img; ?>" alt="Profile image">
		<div id="profile-biography-lbl">Biography:</div>
		
		<?php if ($biography !== NULL) : ?>
			<div id="profile-biography"><?php echo $biography; ?></div>
		<?php else: ?>
			<div id="profile-biography-null"><?php echo 'You have not added a biograpy yet.' ?></div>
		<?php endif; ?>
		
		<div id="profile-member-since">Member since: <?php echo $created; ?></div>
		<?php echo $this->Html->link('Edit', '/users/edit/'.$uid, ['id' => 'edit-usr-btn']); ?>
	</div>
</div>