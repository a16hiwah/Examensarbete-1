<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div id="show-user-view" class="content">
	<?php if($query === null) : ?>
		<span>The user "<?= $username_search ?>" does not exist.</span>
	<?php else : ?>
		<h1 id="show_user_header"><?= $username_search ?></h1>
		<?php foreach ($query as $row) : ?>
			<img id="profile-img" src="<?= $row->profile_image->img_src ?>" alt="Profile image">
			<div id="profile-biography-lbl">Biography:</div>
			
			<?php if ($row->biography !== NULL) : ?>
				<div id="profile-biography"><?= $row->biography ?></div>
			<?php else: ?>
				<div id="profile-biography-null">This user has not added a biograpy yet.</div>
			<?php endif; ?>
			
			<?php $created = substr($row->created->i18nFormat('yyyy-MM-dd HH:mm:ss'), 0, 10); ?>
			<div id="profile-member-since">Member since: <?= $created ?></div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
