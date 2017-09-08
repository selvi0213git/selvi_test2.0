<ul id="kboard-ocean-rating-latest">
	<?php while($content = $list->hasNext()):?>
		<li class="kboard-ocean-rating-latest-item cut_strings">
			<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toStringWithPath($board_url)?>"><span class="kboard-rating value-<?php echo $content->option->rating?>" title="<?php echo $content->option->rating?>"></span> <?php echo $content->title?></a>
		</li>
	<?php endwhile?>
</ul>