<?php while($content = $list->hasNextReply()):?>
<tr class="kboard-list-reply">
	<!-- No -->
	<td class="kboard-list-uid"></td>
	
	<!-- Title -->
	<td class="kboard-list-title">
		<div class="reply-view">
			<!-- att & thumbnail -->
				<?php foreach($content->attach as $key=>$attach): $extension = strtolower(pathinfo($attach[0], PATHINFO_EXTENSION));?>
					<?php if(in_array($extension, array('gif','jpg','jpeg','png'))):?>
						<p class="thumbnail-area"><img src="<?php echo site_url($attach[0])?>" alt="<?php echo $attach[1]?>"></p>
					<?php else: $download[$key] = $attach; endif?>
				<?php endforeach?>
				
				<!-- content -->
				<?php echo strip_tags($content->content)?>
				
				<!-- ADMIN SET -->
				<?php if($board->isAdmin()):?>
				<br>
				<input type="button" value="관리" class="kboard-ask-one-button-gray" style="width:100%;" onclick="<?php if($board->isWriter() && !$content->notice):?>location.href='<?php echo $url->set('uid', $content->uid)->set('mod', 'editor')->toString()?>'<?php endif?>">
				<?php endif ?>
		</div>
		
		<!-- mobile contents view-->
		<div class="kboard-mobile-contents">
			<span class="contents-item"><?php echo $content->member_display?></span>
			<span class="contents-separator">|</span>
			<span class="contents-item"><?php echo date("Y-m-d", strtotime($content->date))?></span>
		</div>
	</td>
	
	<!-- mobile status view-->
	<td class="kboard-list-status"></td>
	<td class="kboard-list-user"><?php echo $content->member_display?></td>
	<td class="kboard-list-date"><?php echo date("Y-m-d", strtotime($content->date))?></td>
</tr>
<?php $boardBuilder->builderReply($content->uid, $depth+1)?>
<?php endwhile?>