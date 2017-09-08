<!-- 
[init]   
[20170726] | RENEWAL - Kboard review-custom create     | eley
--------------------------------------------------------------
[after]
[20170801] | RENEWAL - Kboard review-custom view       | eley
-->

<section class="event-board review">
	<!-- Form start -->
	<form method="post" action="<?php echo $url->getContentEditorExecute()?>" enctype="multipart/form-data" onsubmit="return kboard_editor_execute(this);">
		<?php wp_nonce_field('kboard-editor-execute', 'kboard-editor-execute-nonce');?>
		<input type="hidden" name="action" value="kboard_editor_execute">
		<input type="hidden" name="mod" value="editor">
		<input type="hidden" name="uid" value="<?php echo $content->uid?>">
		<input type="hidden" name="board_id" value="<?php echo $content->board_id?>">
		<input type="hidden" name="parent_uid" value="<?php echo $content->parent_uid?>">
		<input type="hidden" name="member_uid" value="<?php echo $content->member_uid?>">
		<input type="hidden" name="member_display" value="<?php echo $content->member_display?>">
		<input type="hidden" name="date" value="<?php echo $content->date?>">

		<!-- Editor UI Script -->
		<script type="text/javascript" src="<?php echo $skin_path?>/script.js"></script>
		
		<!-- View start -->
		<div class="kboard-selvi">
			<h3 class="kboard-section-hd">리뷰 작성하기</h3>
			<div class="kboard-selvi-write">
				<div class="content">
					<div class="form-list">
					
						<!-- Title -->
						<dl>
							<dt>제목</dt>
							<dd>
								<input type="text" class="input-text col-12" name="title" value="<?php echo $content->title?>">
							</dd>
						</dl>
						
						<!-- Cateogry Logic -->
						<?php if($board->use_category):?>
							<!-- Cateogry1 Logic -->
							<?php if($board->initCategory1()):?>
							<div class="kboard-attr-row">
								<label class="attr-name"><?php echo __('Category', 'kboard')?>1</label>
								<div class="attr-value">
									<select name="category1">
										<?php while($board->hasNextCategory()):?>
										<option value="<?php echo $board->currentCategory()?>"<?php if($content->category1 == $board->currentCategory()):?> selected="selected" <?php endif?>><?php echo $board->currentCategory()?></option>
										<?php endwhile?>
									</select>
								</div>
							</div>
							<?php endif?>
							<!-- Cateogry2 Logic -->
							<?php if($board->initCategory2()):?>
							<div class="kboard-attr-row">
								<label class="attr-name"><?php echo __('Category', 'kboard')?>2</label>
								<div class="attr-value">
									<select name="category2">
										<?php while($board->hasNextCategory()):?>
										<option value="<?php echo $board->currentCategory()?>"<?php if($content->category2 == $board->currentCategory()):?> selected="selected" <?php endif?>><?php echo $board->currentCategory()?></option>
										<?php endwhile?>
									</select>
								</div>
							</div>
							<?php endif?>
						<?php endif?>
						
						<!-- Scriet Check & Lobot Check -->
						<!-- Admin -->
						<?php if($board->isAdmin()):?>
						<!-- Non members -->
						<?php elseif(!is_user_logged_in()):?>
						<div class="kboard-attr-row">
							<label class="attr-name"><?php echo __('Author', 'kboard')?></label>
							<div class="attr-value"><input type="text" name="member_display" value="<?php echo $content->member_display?>"></div>
						</div>
						<div class="kboard-attr-row">
							<label class="attr-name"><?php echo __('Password', 'kboard')?></label>
							<div class="attr-value"><input type="password" name="password" value="<?php echo $content->password?>"></div>
						</div>
						<div class="kboard-attr-row">
							<label class="attr-name"><img src="<?php echo kboard_captcha()?>" alt=""></label>
							<div class="attr-value"><input type="text" name="captcha" value=""></div>
						</div>
						<?php endif?>
	
						<!-- Contents -->
						<dl class="field-msg">
							<dt>내용</dt>
							<dd>
								<!-- Editor -->
								<?php if($board->use_editor):?>
									<?php wp_editor($content->content, 'kboard_content'); ?>
								<?php else:?>
									<textarea class="textarea col-12" name="kboard_content" id="kboard_content"><?php echo $content->content?></textarea>
								<?php endif?>
							</dd>
						</dl>
						
						<!-- File -->
						<dl>
							<dt>첨부파일</dt>
							<dd>
								<!-- File Logic Setting -->
								<?php $attach_index = '1'; if(!$content->attach) $content->attach=array(); foreach($content->attach as $key => $attach):?>
								<div class="filebox">
									<input class="input-file-name input-text" type="text" disabled>
									<label for="attach">파일첨부</label>
									<?php if($content->attach->{$key}[0]):?><?php echo $content->attach->{$key}[1]?> - <a href="<?php echo $url->getDeleteURLWithAttach($content->uid, $key);?>" onclick="return confirm('<?php echo __('Are you sure you want to delete?', 'kboard')?>');"><?php echo __('Delete file', 'kboard')?></a><?php endif?>
									<input class="hidden-input-file" type="file" id="attach" name="kboard_attach_<?php echo $key?>">
								</div><!-- /.filebox -->
								
								<?php $attach_index = intval(str_replace('file', '', $key)); $attach_index++; endforeach; ?>
								<div class="filebox">
									<input class="input-file-name input-text" type="text" disabled>
									<label for="attach">파일첨부</label>
									<?php if(isset($content->attach->{'file'.$attach_index}[0])):?><?php echo $content->attach->{'file'.$attach_index}[1]?> - <a href="<?php echo $url->getDeleteURLWithAttach($content->uid, 'file'.$attach_index);?>" onclick="return confirm('<?php echo __('Are you sure you want to delete?', 'kboard')?>');"><?php echo __('Delete file', 'kboard')?></a><?php endif?>
									<input class="hidden-input-file" type="file" id="attach" name="kboard_attach_file<?php echo $attach_index?>" onchange="add_input_file()">
								</div><!-- /.filebox -->
								
								<script>ui.filebox();</script>
							</dd>
						</dl>

					</div><!-- /.form-list --> 
				</div><!-- /.content -->
					
				<!-- Button -->
				<div class="controls">
					<!-- Save -->
					<?php if($board->isWriter()):?>
					<input type="submit" value="등록" class="kboard-selvi-button-small btn-confirm">
					<?php endif?>
					
					<!-- Cancel or Back -->
					<!-- Editor Mode-->
					<?php if($content->uid):?>
					<input type="button" value="취소" class="kboard-selvi-button-small gray btn-cancel" onclick="location.href='<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>'">
					<input type="button" value="목록으로" class="kboard-selvi-button-small gray btn-cancel" onclick="location.href='<?php echo $url->toString()?>'">

					<!-- Editor Mode-->
					<?php else:?>
					<input type="button" value="취소" class="kboard-selvi-button-small gray btn-cancel" onclick="location.href='<?php echo $url->toString()?>'">
					<?php endif?>
				</div><!-- /.controls -->
			</div><!-- /.kboard-selvi-write -->
		</div><!-- /.kboard-selvi -->
		
	</form>
</section><!-- /.event-board -->

<!-- Map -->
<map id="kboard-rating-map" name="kboard-rating-map">
	<area shape="rect" coords="0,0,7,13" href="#" onclick="return false;" onmouseover="kboard_rating_value(1);">
	<area shape="rect" coords="7,0,14,13" href="#" onclick="return false;" onmouseover="kboard_rating_value(2);">
	<area shape="rect" coords="14,0,21,13" href="#" onclick="return false;" onmouseover="kboard_rating_value(3);">
	<area shape="rect" coords="21,0,28,13" href="#" onclick="return false;" onmouseover="kboard_rating_value(4);">
	<area shape="rect" coords="28,0,35,13" href="#" onclick="return false;" onmouseover="kboard_rating_value(5);">
	<area shape="rect" coords="35,0,42,13" href="#" onclick="return false;" onmouseover="kboard_rating_value(6);">
	<area shape="rect" coords="42,0,49,13" href="#" onclick="return false;" onmouseover="kboard_rating_value(7);">
	<area shape="rect" coords="49,0,56,13" href="#" onclick="return false;" onmouseover="kboard_rating_value(8);">
	<area shape="rect" coords="56,0,63,13" href="#" onclick="return false;" onmouseover="kboard_rating_value(9);">
	<area shape="rect" coords="63,0,69,13" href="#" onclick="return false;" onmouseover="kboard_rating_value(10);">
</map>

<!-- Kboard script -->
<script type="text/javascript">
var kboard_attach_index = <?php echo $attach_index+1?>;
var kboard_localize = {
	please_enter_a_title:'<?php echo __('Please enter a title.', 'kboard')?>',
	please_enter_a_author:'<?php echo __('Please enter a author.', 'kboard')?>',
	please_enter_a_password:'<?php echo __('Please enter a password.', 'kboard')?>',
	please_enter_the_CAPTCHA_code:'<?php echo __('Please enter the CAPTCHA code.', 'kboard')?>',
	attachment:'<?php echo __('Attachment', 'kboard')?>'
}
</script>