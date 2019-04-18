<div id="my-resources-view" class="content">
	<h1>My Resources</h1>
	<button id="create-resrc-btn"><?= $this->Html->link('Create resource', '/resources/create-resource') ?></button>
	
	<?php if ($query !== null) : ?>
		<table id="tbl-user-resources" class="table">
			<thead>
				<tr>
					<th>Title</th>
					<th>Description</th>
					<th>Body</th>
					<th>Created</th>
					<th>Edit</th>
					<th>Delete</th>
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
				
				$edit_btn_href = '/resources/edit-resource/'.$row->id.'/'.$row->user_id;
				
				$delete_btn_href = '/resources/delete/'.$row->id.'/'.$row->user_id;
				$delete_btn_attr = ['class' => 'delete-btn'];
				?>
				<tr>
					<td class="usr-resrc-title"><?= $this->Html->link($title, '/resources/open/'.$row->slug) ?></td>
					<td class="usr-resrc-description"><?= $description ?></td>
					<td class="usr-resrc-body"><?= $body ?></td>
					<td class="usr-resrc-created"><?= $created ?></td>
					<td class="usr-resrc-edit"><?= $this->Html->link('Edit', $edit_btn_href) ?>
					<td class="usr-resrc-delete"><?= $this->Form->postLink('Delete', $delete_btn_href, $delete_btn_attr) ?>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
	<p class="resrc-msg">You have not created any resources yet. Click on
		"Create resource" above to create a new resource.</p>
	<?php endif; ?>
</div>
