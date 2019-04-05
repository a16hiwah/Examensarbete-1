<div id="my-resources-view" class="main-content">
	<h1>My Resources</h1>
	<?php echo anchor('resources/create-resource', 'Create resource'); ?>
	
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
					<td class="usr-res-title"><?php echo anchor('resources/open/'.$row->slug, $title); ?></td>
					<td class="usr-res-description"><?php echo $description; ?></td>
					<td class="usr-res-body"><?php echo $body; ?></td>
					<td class="usr-res-created"><?php echo $created; ?></td>
					<td class="usr-res-edit">
						<?php
						echo anchor('resources/edit-resource/'.$row->id, 'Edit');
						?>
					</td>
					<td class="usr-res-delete">
						<?php
						echo anchor('resources/delete-resource/'.$row->id.'/'.$this->session->user_id, 'Delete');
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