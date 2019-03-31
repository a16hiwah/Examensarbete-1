<div id="new-user-view">
	<?php

	$attributes = array(
		'id' => 'form-new-user',
		'class' => 'form'
	);

	echo form_open('user/new_user', $attributes);

	?>

	<div class="form-group">
		<span class="form-label">Username</span>
		<?php echo form_input($username, set_value('username')); ?>
		<?php echo form_error('username'); ?>
	</div>

	<div class="form-group">
		<span class="form-label">Password</span>
		<?php echo form_password($password, set_value('password')); ?>
		<?php echo form_error('password'); ?>
	</div>

	<div class="form-group">
		<span class="form-label">Confirm password</span>
		<?php echo form_password($passconf, set_value('passconf')); ?>
		<?php echo form_error('passconf'); ?>
	</div>

	<?php echo form_submit('submit', 'Create account'); ?>
	<?php echo anchor('user/', 'Cancel'); ?>
	<?php echo form_close(); ?>
</div>