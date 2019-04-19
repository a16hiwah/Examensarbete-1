<div id="search-results-view" class="content">
	<span><?= $this->Html->link('<-- Go back', $_SERVER['HTTP_REFERER']) ?></span>
	<h1>Search results</h1>
	<?php if ($query !== null) : ?>
	<table id="tbl-search-results" class="table">
			<thead>
				<tr>
					<th>Title</th>
					<th>Description</th>
					<th>Created</th>
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

				$created = substr(date($row->created->i18nFormat('yyyy-MM-dd HH:mm:ss')), 0, 16);
				?>
				<tr>
					<td class="usr-resrc-title"><?= $this->Html->link($title, 'resources/open/'.$row->slug) ?></td>
					<td class="usr-resrc-description"><?= $description ?></td>
					<td class="usr-resrc-created"><?= $created ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>