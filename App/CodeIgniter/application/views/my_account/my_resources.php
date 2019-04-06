<div id="my-resources-view" class="content">
	<h1>My Resources</h1>
	<button id="create-resrc-btn"><?php echo anchor('resources/create-resource', 'Create resource'); ?></button>
	
	<?php if ($user_resources->num_rows() > 0) : ?>
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
			<?php foreach ($user_resources->result() as $row) : ?>
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
				
				$created = substr(date($row->created), 0, 16);
				?>
				<tr>
					<td class="usr-resrc-title"><?php echo anchor('resources/open/'.$row->slug, $title); ?></td>
					<td class="usr-resrc-description"><?php echo $description; ?></td>
					<td class="usr-resrc-body"><?php echo $body; ?></td>
					<td class="usr-resrc-created"><?php echo $created; ?></td>
					<td class="usr-resrc-edit">
						<?php
						echo anchor('resources/edit-resource/1/'.$row->id.'/'.$this->session->user_id, 'Edit');
						?>
					</td>
					<td class="usr-resrc-delete">
						<?php
						echo anchor(
							'resources/delete-resource/'
							.$row->id
							.'/'
							.$this->session->user_id, 'Delete', 'class="delete-btn"'
						);
						?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
	<div><p>You have not created any resources yet. Click on "Create resource" above to create a new resource.</p></div>
	<?php endif; ?>
</div>