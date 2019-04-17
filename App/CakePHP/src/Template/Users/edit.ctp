<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->Form->templates([
    'inputContainer' => '<div class="form-group">{{content}}</div>',
    'inputContainerError' => '<div class="form-group  {{type}}{{required}} has-error">{{content}}{{error}}</div>',
    'label' => '<label class="form-label" {{attrs}}>{{text}}{{label}}</label>',
    'error' => '<div class="validation-error">{{content}}</div>',
    'errorList' => '<ul>{{content}}</ul>',
    'errorItem' => '<li>{{text}}</li>'
]);
?>
<div id="edit-user-view" class="form-view">
	<?php
	$attr = array(
		'id' => 'form-edit-user',
		'class' => 'form'
    );

    echo $this->Form->create($user, $attr);
    ?>
	<div class="form-group">
		<span id="profile-img-lbl" class="form-label">Image</span>
		<div id="profile-img-selection">
			<?php
			foreach ($profileImages as $img)
			{
				$attr = array(
					'name' => 'profile_image_id',
					'id' => 'profile-img-'.$img->id,
					'class' => 'profile-img-radio',
					'value' => $img->id,

					// User's currently selected image should be checked
					'checked' => ($img->id === $user->profile_image_id) ? TRUE : FALSE
				);

                echo '<label>';
                if($img->id === $user->profile_image_id) {
                    echo '<input type="radio" id="'.$attr['id']
                    .'" class="'.$attr['class']
                    .'" name="'.$attr['name']
                    .'" value="'.$attr['value']
                    .'" checked="checked" />';
                } else {
                    echo '<input type="radio" id="'.$attr['id']
                    .'" class="'.$attr['class']
                    .'" name="'.$attr['name']
                    .'" value="'.$attr['value']
                    .'" />';
                }
                // echo '<input type="radio" id="'.$attr['id'].'" class="'.$attr['class'].'" name="'.$attr['name'].'" value="'.$attr['value'].'" checked="'.$attr['checked'].'" />';
				echo '<img class="img-radio-select" src="'.$img->img_src.'" alt="'.$img->img_name.'">';
				echo '</label>';
			}
			?>
		</div>
    </div>
    <div class="form-group">
        <?php echo $this->Form->label('biography', 'Biography'); ?>
        <?php echo $this->Form->textarea('biography', ['id' => 'form-biography', 'cols' => '40', 'rows' => '10']); ?>
    </div>
    <input type="submit" name="submit" value="Edit profile">
    <?php echo $this->Html->link('Cancel', '/my-account', ['id' => 'cancel-btn']) ?>
    <?= $this->Form->end() ?>
</div>
