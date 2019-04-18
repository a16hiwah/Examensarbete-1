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
<div id="create-edit-resrc-view" class="form-view">
	<?php
	$attr = array(
		'id' => 'form-create-resource',
		'class' => 'form'
	);

    echo $this->Form->create($resource, $attr);
    echo $this->Form->input('title', ['id' => 'form-title']);
    echo $this->Form->input('description', ['id' => 'form-description']);
    ?>
    <div class="form-group">
        <?= $this->Form->label('form-body', 'Body'); ?>
        <?= $this->Form->textarea(
            'body',
            [
                'id' => 'form-body',
                'cols' => '40',
                'rows' => '10'
            ]
        ); ?>
    </div>
    <?= $this->Form->input('num_of_comments', ['type' => 'hidden', 'value' => '0']); ?>
    <input type="submit" name="submit" value="Create resource">
    <?= $this->Html->link('Cancel', '/my-account/my-resources', ['id' => 'cancel-btn']); ?>
    <?= $this->Form->end(); ?>
</div>
