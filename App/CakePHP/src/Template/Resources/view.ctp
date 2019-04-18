<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Resource $resource
 */
?>
<div id="resources-view" class="content">
	<h1>Resources</h1>
	<div>
		<p>On this page you can find all resoures on this website. Filter by
			letter or perform a search to find what your looking for.</p>
	</div>
	<div id="filter-search-container">
		<div id="filter-section">
			<?= $this->Html->link('0-9', '/resources/view/0-9') ?>
			<?php $letters = range('A', 'Z'); ?>
			<?php foreach ($letters as $letter) : ?>
				<?= $this->Html->link($letter, '/resources/view/'.strtolower($letter)) ?>
			<?php endforeach; ?>
		</div>
	</div>
    <?php if ($query !== null) : ?>
		<table id="tbl-resources">
			<thead>
				<tr>
					<th>Title</th>
					<th>Description</th>
					<th>Body</th>
					<th>Created</th>
					<th>Comments</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($query as $row) : ?>
				<?php
				// Maximum string length visible in table
				$str_max_len = 80;

				$title =
					(strlen($row->title) < $str_max_len) // if
					? $row->title // condition met
					: substr($row->title, 0, $str_max_len-3).'...'; // else

				$description =
					(strlen($row->description) < $str_max_len) // if
					? $row->description // condition met
					: substr($row->description, 0, $str_max_len-3).'...'; // else

				$body =
				(strlen($row->body) < $str_max_len) // if
				? $row->body // condition met
				: substr($row->body, 0, $str_max_len-3).'...'; // else
				
				$created = substr(date($row->created->i18nFormat('yyyy-MM-dd HH:mm:ss')), 0, 16);
				?>
				<tr>
					<td class="resrc-title"><?= $this->Html->link($title, '/resources/open/'.$row->slug) ?></td>
					<td class="resrc-description"><?= $description ?></td>
					<td class="resrc-body"><?= $body ?></td>
					<td class="resrc-created"><?= $created ?></td>
					<td class="resrc-num-of-comments"><?= $row->num_of_comments ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
	<div>
		<p class="resrc-msg">There are no resources here yet. Why not
			<?= $this->Html->link('sign up', '/users/add') ?> and be the first to
			create one?</p>
	</div>
	<?php endif; ?>
</div>
