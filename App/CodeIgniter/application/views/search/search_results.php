<div id="search-results-view">
	<span><?php echo anchor($_SERVER['HTTP_REFERER'], '<-- Go back'); ?></span>
	<h1>Search results</h1>
	<?php if ($search_results->num_rows() > 0) : ?>
	<table id="tbl-search-results" class="table">
			<thead>
				<tr>
					<th>Title</th>
					<th>Description</th>
					<th>Created</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($search_results->result() as $row) : ?>
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

				$created = substr(date($row->created), 0, 16);
				?>
				<tr>
					<td class="usr-resrc-title"><?php echo anchor('resources/open/'.$row->slug, $title); ?></td>
					<td class="usr-resrc-description"><?php echo $description; ?></td>
					<td class="usr-resrc-created"><?php echo $created; ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>