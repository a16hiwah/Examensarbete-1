<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resource $resource
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
<div id="edit-resrc-view" class="form-view">
    <?= $this->Form->create($resource, ['id' => 'form-edit-resource', 'class' => 'form']) ?>
    <?= $this->Form->input('title', ['id' => 'form-title']) ?>
    <?= $this->Form->input('description', ['id' => 'form-description']) ?>
    <div class="form-group">
        <?= $this->Form->label('form-body', 'Body') ?>
        <?= $this->Form->textarea(
            'body',
            [
                'id' => 'form-body',
                'cols' => '40',
                'rows' => '10'
            ]
        ) ?>
    </div>
    <input type="submit" name="submit" value="Edit resource">
    <?= $this->Html->link('Cancel', '/my-account/my-resources', ['id' => 'cancel-btn']) ?>
    <?= $this->Form->end() ?>
</div>