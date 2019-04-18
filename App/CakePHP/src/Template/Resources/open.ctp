<div id="opened-resource-view" class="content">
	<div class="resource">
		<?php foreach ($query as $row) : ?>
			<h1><?= $row->title; ?></h1>
			
			<div id="opened-resrc-creator">
				<div>Created by <?= $this->Html->link($row->user->username, '/users/'.$row->user->username); ?></div>
				<img id="profile-img" src="<?= $row->user->profile_image->img_src ?>" alt="Profile image">
				<?php $created = substr($row->created->i18nFormat('yyyy-MM-dd HH:mm:ss'), 0, 10) ?>
				<div id="profile-member-since">Member since: <?= $created; ?></div>
			</div>
			
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
</div>
