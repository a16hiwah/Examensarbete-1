<div id="show-user-view" class="content">
	<?php if($user_info->num_rows() < 1) : ?>
		<span>The user "<?php echo $username_search; ?>" does not exist.</span>
	<?php else : ?>
		<h1 id="show_user_header"><?php echo $username_search; ?></h1>
		<?php foreach ($user_info->result() as $row) : ?>
			<img id="profile-img" src="<?php echo $row->img_src ?>" alt="Profile image">
			<div id="profile-biography-lbl">Biography:</div>
			
			<?php if ($row->biography !== NULL) : ?>
				<div id="profile-biography"><?php echo $row->biography; ?></div>
			<?php else: ?>
				<div id="profile-biography-null"><?php echo 'This user has not added a biograpy yet.' ?></div>
			<?php endif; ?>
			
			<div id="profile-member-since">Member since: <?php echo substr($row->created, 0, 10); ?></div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>