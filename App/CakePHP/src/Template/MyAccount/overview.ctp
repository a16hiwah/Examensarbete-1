<div id="overview-view" class="content">
	<h1>My account</h1>
	<div id="welcome-user">Welcome <?= $username ?></div>
	<p id="overview-msg">Some of the things you can do in the "My account" section are creating
		new resources and updating your profile. Use the menu above to
		navigate between the different sections.</p>

	<div id="overview-usr-info">
		<img id="profile-img" src="<?= $profile_img ?>" alt="Profile image">
		<div id="profile-biography-lbl">Biography:</div>
		
		<?php if ($biography !== NULL) : ?>
			<div id="profile-biography"><?= $biography ?></div>
		<?php else: ?>
			<div id="profile-biography-null">You have not added a biograpy yet.</div>
		<?php endif; ?>
		
		<div id="profile-member-since">Member since: <?= $created ?></div>
		<?= $this->Html->link('Edit', '/users/edit/'.$uid, ['id' => 'edit-usr-btn']) ?>
	</div>
</div>