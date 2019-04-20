<div id="opened-resource-view" class="content">
	<div class="resource">
		<?php foreach ($query as $row): ?>
			<h1><?= $row->title ?></h1>
			
			<div id="opened-resrc-creator">
				<div>Created by <?= $this->Html->link($row->user->username, '/users/view/'.$row->user->username) ?></div>
				<img id="profile-img" src="<?= $row->user->profile_image->img_src ?>" alt="Profile image">
				<?php $created = substr($row->created->i18nFormat('yyyy-MM-dd HH:mm:ss'), 0, 10); ?>
				<div id="profile-member-since">Member since: <?= $created ?></div>
			</div>
			
			<div>
				<div id="opened-resrc-description">Description</div>
				<p><?= $row->description ?></p>
			</div>

			<div>
				<div id="opened-resrc-body">Content</div>
				<p><?= nl2br($row->body) ?></p>
			</div>
			
			<?php $resource_id = $row->id; ?>
		<?php endforeach; ?>
	</div>
	<div class="comment-section">
		<h3 id="comment-section-header">Comment section</h3>
		
		<!-- Only signed in users can create comments -->
		<?php if($this->request->getSession()->read('Auth.User.id')): ?>
			<?= $this->Form->create(
				null,
				['url' => ['controller' => 'Comments', 'action' => 'add']],
				['id' => 'form-create-comment']
			) ?>

			<div class="form-group">
				<span id="create-comment-lbl" class="form-label">Create comment</span>
				<?= $this->Form->textarea('body', ['id' => 'form-comment', 'cols' => '40', 'rows' => '10']) ?>
				<?= $this->Form->input('resource_id', ['type' => 'hidden', 'value' => $resource_id]) ?>
			</div>

			<input type="submit" name="submit" value="Create comment">

			<?= $this->Form->end(); ?>
		<?php endif; ?>

		<?php foreach ($row->comments as $comment): ?>
			<?php $created = substr(date($comment->created->i18nFormat('yyyy-MM-dd HH:mm:ss')), 0, 16); ?>
			<div class="comment">
				<div class="comment-by">By: <?= $comment->user->username ?></div>
				<div class="comment-created">Created: <?= substr($created, 0, 16) ?></div>
				<p class="comment-body"><?= nl2br($comment->body) ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</div>
