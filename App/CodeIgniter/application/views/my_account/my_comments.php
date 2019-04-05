<div id="my-comments-view" class="main-content">
	<h1>My Comments</h1>
	<?php if ($user_comments->num_rows() > 0) : ?>
		<table id="tbl-user-comments">
			<thead>
				<tr>
					<th>Resource</th>
					<th>Comment</th>
					<th>Created</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($user_comments->result() as $row) : ?>
				<?php
				// Maximum string length visible in table
				$str_max_len = 80;

				$title =
					(strlen($row->title) < $str_max_len) // if
					? $row->title // condition met
					: substr($row->title, 0, $str_max_len-3).'...'; // else

				$body =
				(strlen($row->body) < $str_max_len) // if
				? $row->body // condition met
				: substr($row->body, 0, $str_max_len-3).'...'; // else
				
				$created = substr(date($row->created), 0, 16);
				?>
				<tr>
					<td class="usr-cmt-title"><?php echo anchor('resources/open/'.$row->slug, $title); ?></td>
					<td class="usr-cmt-body"><?php echo $body; ?></td>
					<td class="usr-cmt-created"><?php echo $created; ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
	<div><p>You have not created any comments yet.</p></div>
	<?php endif; ?>
</div>