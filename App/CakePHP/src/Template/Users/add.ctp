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

<div id="create-user-view" class="form-view">
        <?= $this->Form->create($user, ['id' => 'form-create-user', 'class' => 'form']) ?>
        <?= $this->Form->input('username', ['id' => 'form-username']); ?>
        <?= $this->Form->input('password', ['id' => 'form-password']); ?>
        <?= $this->Form->input(
            'passconf',
            [
                'id' => 'form-passconf',
                'type' => 'password',
                'label' => 'Confirm password'
            ]
        ); ?>
        <?= $this->Form->input('profile_image_id', ['type' => 'hidden', 'value' => '1']); ?>
        <input type="submit" name="submit" value="Create account">
        <?= $this->Html->link('Cancel', '/users/login', ['id' => 'cancel-btn']) ?>
        <?= $this->Form->end() ?>
</div>
