<div id="resources-view" class="content">
	<h1>Resources</h1>
	<div>
		<p>On this page you can find all resoures on this website. Filter by
			letter or perform a search to find what your looking for.</p>
	</div>
	<div id="filter-search-container">
		<div id="filter-section">
			<?php echo anchor('resources/view/0-9', '0-9'); ?>
			<?php $letters = range('A', 'Z'); ?>
			<?php foreach ($letters as $letter) : ?>
				<?php echo anchor('resources/view/'.strtolower($letter), $letter); ?>
			<?php endforeach; ?>
		</div>
		<div id="search-section">
			<?php echo form_open('search/find_resources', 'id=form-search'); ?>
			<?php echo form_input('search-box', ''); ?>
			<?php echo form_submit('submit', 'Search'); ?>
			<?php echo form_close(); ?>
		</div>
	</div>

	<?php if ($resources->num_rows() > 0) : ?>
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
			<?php foreach ($resources->result() as $row) : ?>
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
					<td class="resrc-title"><?php echo anchor('resources/open/'.$row->slug, $title); ?></td>
					<td class="resrc-description"><?php echo $description; ?></td>
					<td class="resrc-body"><?php echo $body; ?></td>
					<td class="resrc-created"><?php echo $created; ?></td>
					<td class="resrc-num-of-comments"><?php echo $row->num_of_comments; ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
	<div>
		<p class="resrc-msg">There are no resources here yet. Why not
			<?php echo anchor('register', 'sign up'); ?> and be the first to
			create one?</p>
	</div>
	<?php endif; ?>
</div>