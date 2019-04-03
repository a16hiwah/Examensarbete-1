<div id="create-resource-view" class="form-view">
	<?php

	$attributes = array(
		'id' => 'form-create-resource',
		'class' => 'form'
	);

	echo form_open('resources/create_resource', $attributes);

	?>

	<div class="form-group">
		<span class="form-label">Title</span>
		<?php echo form_input($form_title, set_value('form-title')); ?>
		<?php echo form_error('form-title'); ?>
	</div>

	<div class="form-group">
		<span class="form-label">Description</span>
		<?php echo form_input($form_description, set_value('form-description')); ?>
		<?php echo form_error('form-description'); ?>
	</div>

	<div class="form-group">
		<span class="form-label">Body</span>
		<?php echo form_textarea($form_body, set_value('form-body')); ?>
		<?php echo form_error('form-body'); ?>
	</div>

	<?php echo form_submit('submit', 'Create resource'); ?>
	<?php echo anchor('my-account/my-resources', 'Cancel'); ?>
	<?php echo form_close(); ?>
</div>