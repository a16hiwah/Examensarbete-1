<div id="create-user-view" class="form-view">
	<?php

	$attributes = array(
		'id' => 'form-create-user',
		'class' => 'form'
	);

	echo form_open('register/create_user', $attributes);

	?>

	<div class="form-group">
		<span class="form-label">Username</span>
		<?php echo form_input($form_username, set_value('form-username')); ?>
		<?php echo form_error('form-username'); ?>
	</div>

	<div class="form-group">
		<span class="form-label">Password</span>
		<?php echo form_password($form_password, set_value('form-password')); ?>
		<?php echo form_error('form-password'); ?>
	</div>

	<div class="form-group">
		<span class="form-label">Confirm password</span>
		<?php echo form_password($form_passconf, set_value('form-passconf')); ?>
		<?php echo form_error('form-passconf'); ?>
	</div>

	<?php echo form_submit('submit', 'Create account'); ?>
	<?php echo anchor('sign-in', 'Cancel', 'id="cancel-btn"'); ?>
	<?php echo form_close(); ?>
</div>