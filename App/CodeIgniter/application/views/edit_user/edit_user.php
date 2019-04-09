<div id="edit-user-view" class="form-view">
	<?php
	$attributes = array(
		'id' => 'form-edit-user',
		'class' => 'form'
	);

	echo form_open('edit_user/edit_profile/'.$this->session->user_id, $attributes);
	?>

	<div class="form-group">
		<span id="profile-img-lbl" class="form-label">Image</span>
		<div id="profile-img-selection">
			<?php
			foreach ($profile_images as $row)
			{
				$attributes = array(
					'name' => 'form-image',
					'id' => 'profile-img-'.$row->id,
					'class' => 'profile-img-radio',
					'value' => $row->id,

					// User's currently selected image should be checked
					'checked' => ($row->id === $usr_info->image) ? TRUE : FALSE
				);

				echo '<label>';
				echo form_radio($attributes);
				echo '<img class="img-radio-select" src="'.$row->img_src.'" alt="'.$row->img_name.'">';
				echo '</label>';
			}
			?>
		</div>
	</div>

	<div class="form-group">
		<span class="form-label">Biography</span>
		<?php echo form_textarea($form_biography, set_value('form-biography')); ?>
	</div>

	<?php echo form_submit('submit', 'Edit profile'); ?>
	<?php echo anchor('my-account', 'Cancel', 'id="cancel-btn"'); ?>
	<?php echo form_close(); ?>
</div>