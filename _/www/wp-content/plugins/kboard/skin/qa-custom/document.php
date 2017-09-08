<div id="kboard-document">
	<?php if($board->isAdmin()):?>
		<h1 class="pop-header" style="text-align:center;">관리</h1>
		
		<?php if($content->category2 == '답변완료') : ?>
		<div id="kboard-ask-one-document">
			<input type="button" value="답글쓰기" class="btn-univ btn-reply" style="width:100%; margin-bottom:30px;" onclick="<?php if($board->isWriter() && !$content->notice):?>location.href='<?php echo $url->set('parent_uid', $content->uid)->set('mod', 'editor')->toString()?>'<?php endif?>">
		</div>
		<?php endif ?>
		
		<div id="kboard-ask-one-document">
			<input type="button" value="목록으로" class="btn-univ gray btn-list" style="width:100%; margin-bottom:30px;" onclick="location.href='<?php echo $url->set('mod', 'list')->toString()?>'">
		</div>
		
		<div id="kboard-ask-one-document">
			<input type="button" value="수정으로" class="btn-univ gray btn-edit" style="width:100%; margin-bottom:30px;" onclick="<?php if($board->isWriter() && !$content->notice):?>location.href='<?php echo $url->set('uid', $content->uid)->set('mod', 'editor')->toString()?>'<?php endif?>">
		</div>
	<?php else : ?>
		<?php echo "<script>window.location.href='{$url->set('mod', 'list')->toString()}';</script>";?>
	<?php endif?>
</div>