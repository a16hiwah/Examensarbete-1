<div id="homepage-view" class="content">
<h1>Homepage</h1>
	<h4>
		Lorem ipsum, dolor sit amet consectetur adipisicing elit. Modi fugiat
		porro quam ipsa temporibus quidem recusandae. Nam iure nostrum aut
		consectetur! Maiores dicta sint aperiam vero veniam, nihil, similique
		numquam quo repellendus asperiores, eaque magni. Suscipit, placeat
		excepturi. Numquam non corrupti iste dolorum reprehenderit, deserunt
		nobis aliquid, nihil voluptate esse, possimus alias modi nemo recusandae
		quod suscipit sit illum!
	</h4>

	<div id="latest-resources">
		<h2>Latest resources</h2>
		<?php if ($query !== null): ?>
			<ul class="two-columns">
				<?php foreach ($query as $row): ?>
					<?php
					// Maximum string length visible in list
					$str_max_len = 40;

					$title =
						(strlen($row->title) < $str_max_len) // if
						? $row->title // condition met
						: substr($row->title, 0, $str_max_len-3).'...'; // else
					
					$created = substr(date($row->created->i18nFormat('yyyy-MM-dd HH:mm:ss')), 0, 16);
					?>
					<li><?= $this->Html->link($title, '/resources/open/'.$row->slug); ?> - <?= $created ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</div>
