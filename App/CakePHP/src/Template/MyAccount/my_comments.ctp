<div id="my-comments-view" class="content">
	<h1>My Comments</h1>
	<?php if ($query !== null): ?>
		<table id="tbl-user-comments">
			<thead>
				<tr>
					<th>Resource</th>
					<th>Comment</th>
					<th>Created</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($query as $row): ?>
				<?php
				// Maximum string length visible in table
				$str_max_len = 80;

				$title =
					(strlen($row->resource->title) < $str_max_len) // if
					? $row->resource->title // condition met
					: substr($row->resource->title, 0, $str_max_len-3).'...'; // else

				$body =
				(strlen($row->body) < $str_max_len) // if
				? $row->body // condition met
				: substr($row->body, 0, $str_max_len-3).'...'; // else
				
				$created = substr(date($row->created->i18nFormat('yyyy-MM-dd HH:mm:ss')), 0, 16);
				?>
				<tr>
					<td class="usr-cmt-title"><?= $this->Html->link($title, '/resources/open/'.$row->resource->slug) ?></td>
					<td class="usr-cmt-body"><?= $body ?></td>
					<td class="usr-cmt-created"><?= $created ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
	<p class="comment-msg">You have not created any comments yet.</p>
	<?php endif; ?>
</div>
