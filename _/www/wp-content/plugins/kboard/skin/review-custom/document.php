<div id="kboard-ocean-rating-document">
	<div class="kboard-header"></div>
	
	<div class="kboard-document-wrap" itemscope itemtype="http://schema.org/Article">
		<div class="kboard-title" itemprop="name">
			<p><?php echo $content->title?> <span class="kboard-rating value-<?php echo $content->option->rating?>" title="<?php echo $content->option->rating?>"></span></p>
		</div>
		
		<div class="kboard-detail">
			<?php if($content->category1):?>
			<div class="detail-attr detail-category1">
				<div class="detail-name"><?php echo $content->category1?></div>
			</div>
			<?php endif?>
			<?php if($content->category2):?>
			<div class="detail-attr detail-category2">
				<div class="detail-name"><?php echo $content->category2?></div>
			</div>
			<?php endif?>
			<div class="detail-attr detail-writer">
				<div class="detail-name"><?php echo __('Author', 'kboard')?></div>
				<div class="detail-value"><?php echo $content->member_display?></div>
			</div>
			<div class="detail-attr detail-date">
				<div class="detail-name"><?php echo __('Date', 'kboard')?></div>
				<div class="detail-value"><?php echo date("Y-m-d H:i", strtotime($content->date))?></div>
			</div>
			<div class="detail-attr detail-view">
				<div class="detail-name"><?php echo __('Views', 'kboard')?></div>
				<div class="detail-value"><?php echo $content->view?></div>
			</div>
		</div>
		
		<div class="kboard-content" itemprop="description">
			<div class="content-view">
				<?php foreach($content->attach as $key=>$attach): $extension = strtolower(pathinfo($attach[0], PATHINFO_EXTENSION));?>
					<?php if(in_array($extension, array('gif','jpg','jpeg','png'))):?>
						<p class="thumbnail-area"><img src="<?php echo site_url($attach[0])?>" alt="<?php echo $attach[1]?>"></p>
					<?php else: $download[$key] = $attach; endif?>
				<?php endforeach?>
				
				<?php echo $content->content?>
				
				<div class="like-area">
					<a href="#" onclick="return kboard_ocean_rating_like('<?php echo $content->uid?>')"; class="kboard-item-like">
						<div class="kboard-item-padding">추천 : <span class="kboard-count-bold"><?php echo $content->like?></span></div>
					</a>
				</div>
			</div>
		</div>
		
		<?php if(isset($download) && $download): foreach($download as $key=>$value):?>
		<div class="kboard-attach">
			<?php echo __('Attachment', 'kboard')?> : <a href="<?php echo $url->getDownloadURLWithAttach($content->uid, $key)?>"><?php echo $content->attach->{$key}[1]?></a>
		</div>
		<?php endforeach; endif;?>
	</div>
	
	<?php if($board->isComment()):?>
	<div class="kboard-comments-area"><?php echo $board->buildComment($content->uid)?></div>
	<?php endif?>
	
	<div class="kboard-control">
		<div class="left">
			<a href="<?php echo $url->toString()?>" class="kboard-ocean-rating-button-small"><?php echo __('List', 'kboard')?></a>
			<a href="<?php echo $url->getDocumentURLWithUID($content->getPrevUID())?>" class="kboard-ocean-rating-button-small"><?php echo __('Prev', 'kboard')?></a>
			<a href="<?php echo $url->getDocumentURLWithUID($content->getNextUID())?>" class="kboard-ocean-rating-button-small"><?php echo __('Next', 'kboard')?></a>
		</div>
		<?php if($board->isEditor($content->member_uid) || $board->permission_write=='all'):?>
		<div class="right">
			<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'editor')->toString()?>" class="kboard-ocean-rating-button-small"><?php echo __('Edit', 'kboard')?></a>
			<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'remove')->toString()?>" class="kboard-ocean-rating-button-small" onclick="return confirm('<?php echo __('Are you sure you want to delete?', 'kboard')?>');"><?php echo __('Delete', 'kboard')?></a>
		</div>
		<?php endif?>
	</div>
	<!-- 글씨숨김 -->
	<!--
	<div class="kboard-ocean-rating-poweredby">
		<a href="http://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href);return false;" title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard')?>">Powered by KBoard</a>
	</div>
	-->
</div>

<script>
function kboard_ocean_rating_like(document_uid){
	jQuery.post('<?php echo admin_url('/admin-ajax.php')?>', {'action':'kboard_ocean_rating_like', 'document_uid':document_uid}, function(res){
		if(res){
			alert('추천 했습니다.');
			jQuery('.kboard-count-bold').text(res);
		}
		else{
			alert('이미 추천 하셨습니다.');
		}
	});
	return false;
}
</script>