<?php
$this->Form->templates([
    'inputContainer' => '<div class="form-group">{{content}}</div>',
    'inputContainerError' => '<div class="form-group  {{type}}{{required}} has-error">{{content}}{{error}}</div>',
    'label' => '<label class="form-label" {{attrs}}>{{text}}{{label}}</label>',
    'error' => '<div class="validation-error">{{content}}</div>',
    'errorList' => '<ul>{{content}}</ul>',
    'errorItem' => '<li>{{text}}</li>'
]);
?>

<div id="sign-in-view" class="form-view">
        <?= $this->Form->create(null, ['id' => 'form-sign-in', 'class' => 'form']) ?>
		    <?= $this->Form->input('username', ['id' => 'form-username']) ?>
            <?= $this->Form->input('password', ['id' => 'form-password']) ?>
			<input type="submit" name="submit" value="Sign in">
			<?= $this->Html->link('Sign up', '/users/add', ['id' => 'sign-up-btn']) ?>
            <?= $this->Html->link('Cancel', '/home', ['id' => 'cancel-btn']) ?>
        <?= $this->Form->end() ?>
</div>
