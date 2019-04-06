<div id="sign-in-view" class="form-view">
	<?php

	$form_attr = array(
		'id' => 'form-sign-in',
		'class' => 'form'
	);
	
	$username_attr = array(
		'name' => 'form-username',
		'id' => 'form-username',
		'value' => set_value('form-username', ''),
		'maxlength' => '64'
	);

	$password_attr = array(
		'name' => 'form-password',
		'id' => 'form-password',
		'value' => set_value('form-password', ''),
		'maxlength' => '255'
	);

	echo form_open('sign_in', $form_attr);

	?>

	<div class="form-group">
		<span class="form-label">Username</span>
		<?php echo form_input($username_attr, set_value('form-username')); ?>
	</div>

	<div class="form-group">
		<span class="form-label">Password</span>
		<?php echo form_password($password_attr, set_value('form-password')); ?>
	</div>
	
	<?php if (isset($auth_fail) OR validation_errors()) : ?>
	<span class="validation-error">*Username or Password is incorrect, please try again.</span>
	<?php endif; ?>

	<?php echo form_submit('submit', 'Sign in'); ?>
	<?php echo anchor('register', 'Sign up'); ?>
	<?php echo anchor('home', 'Cancel', 'id="cancel-btn"'); ?>
	<?php echo form_close(); ?>
</div>