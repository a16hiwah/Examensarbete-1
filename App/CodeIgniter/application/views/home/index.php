<div class="homepage-view">
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

	<?php if ($latest_resources->num_rows() > 0) : ?>
		<ul class="two-columns">
			<?php foreach ($latest_resources->result() as $row) : ?>
				<?php
				// Maximum string length visible in list
				$str_max_len = 40;

				$title =
					(strlen($row->title) < $str_max_len) // if
					? $row->title // condition met
					: substr($row->title, 0, $str_max_len-3).'...'; // else
				
				$created = substr(date($row->created), 0, 16);
				?>
				<li><?php echo anchor('resources/open/'.$row->slug, $title); ?> - <?php echo $created; ?></li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

</div>