<div id="opened-resource-view" class="content">
	<div class="resource">
		<?php foreach ($resource->result() as $row) : ?>
		<h1><?php echo $row->title; ?></h1>
		<div>
			<div id="opened-resrc-description">Description</div>
			<p><?php echo $row->description; ?></p>
		</div>
		<div>
			<div id="opened-resrc-body">Content</div>
			<p><?php echo nl2br($row->body); ?></p>
		</div>
		<?php $resource_id = $row->id; ?>
		<?php endforeach; ?>
	</div>
	<div class="comment-section">
		<h3 id="comment-section-header">Comment section</h3>
		<!-- Only signed in users can create comments -->
		<?php if($show_create_comment) : ?>
			<?php echo form_open(uri_string(), 'id=form-create-comment'); ?>
			<div class="form-group">
				<span id="create-comment-lbl" class="form-label">Create comment</span>
				<?php echo form_textarea($form_comment, set_value('form-comment')); ?>
				<?php echo form_error('form-comment'); ?>
			</div>
			<?php echo form_hidden('form-resource-id', $resource_id); ?>
			<?php echo form_submit('submit', 'Create comment'); ?>
			<?php echo form_close(); ?>
		<?php endif; ?>

		<?php foreach ($comments->result() as $row) : ?>
			<div class="comment">
				<div class="comment-by">By: <?php echo $row->username; ?></div>
				<div class="comment-created">Created: <?php echo substr($row->created, 0, 16); ?></div>
				<p class="comment-body"><?php echo nl2br($row->body); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</div>