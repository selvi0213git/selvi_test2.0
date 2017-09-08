<!-- 
[init]   
[20170726] | RENEWAL - Kboard qa-custom create             | eley
-------------------------------------------------------------------
[after]
[20170801] | RENEWAL - Kboard qa-custom view               | eley
[20170802] | RENEWAL - Kboard qa-custom Logic & Admin      | eley
-->
<section class="event-board qna">
	<!-- Form start -->
	<form class="kboard-form" method="post" action="<?php echo $url->getContentEditorExecute()?>" enctype="multipart/form-data" onsubmit="return kboard_editor_execute(this);">
		<?php wp_nonce_field('kboard-editor-execute', 'kboard-editor-execute-nonce')?>
		<input type="hidden" name="action" value="kboard_editor_execute">
		<input type="hidden" name="mod" value="editor">
		<input type="hidden" name="uid" value="<?php echo $content->uid?>">
		<input type="hidden" name="board_id" value="<?php echo $content->board_id?>">
		<input type="hidden" name="parent_uid" value="<?php echo $content->parent_uid?>">
		<input type="hidden" name="member_uid" value="<?php echo $content->member_uid?>">
		<input type="hidden" name="member_display" value="<?php echo $content->member_display?>">
		<input type="hidden" name="date" value="<?php echo $content->date?>">
		<input type="hidden" name="user_id" value="<?php echo get_current_user_id()?>">
		
		<!-- Editor UI Script -->
		<script type="text/javascript" src="<?php echo $skin_path?>/script.js"></script>
		
		<!-- View start -->
		<div class="kboard-selvi">
			<h3 class="kboard-section-hd">질문하기</h3>
			<div class="kboard-selvi-write">
				<div class="content">
					<div class="form-list">
					
						<!-- Title -->
						<dl>
							<dt>제목</dt>
							<dd>
								<input type="text" class="input-text col-12" id="kboard-input-title" name="title" value="<?php echo $content->title?>">
							</dd>
						</dl>
						
						<!-- Cateogry Logic -->
						<?php if($board->use_category):?>
							<!-- Cateogry1 Logic -->
							<?php if($board->initCategory1()):?>
							<div class="kboard-attr-row">
								<label class="attr-name" for="kboard-select-category1"><?php echo __('Category', 'kboard')?></label>
								<div class="attr-value">
									<select id="kboard-select-category1" name="category1">
										<option value=""><?php echo __('Category', 'kboard')?> <?php echo __('Select', 'kboard')?></option>
										<?php while($board->hasNextCategory()):?>
										<option value="<?php echo $board->currentCategory()?>"<?php if($content->category1 == $board->currentCategory()):?> selected<?php endif?>><?php echo $board->currentCategory()?></option>
										<?php endwhile?>
									</select>
								</div>
							</div>
							<?php endif?>
						<?php endif?>
						
						<!-- QA Status Setting -->
						<?php if($board->isAdmin()):?>
						<dl>
							<dt>상태</dt>
							<dd>
								<div class="kboard-attr-row">
									<div class="attr-value">
										<select class="input-text col-12" id="kboard-select-category2" name="category2">
											<option value="">상태없음</option>
											<option value="답변대기"<?php if($content->category2 == '답변대기'):?> selected<?php endif?>>답변대기</option>
											<option value="답변완료"<?php if($content->category2 == '답변완료'):?> selected<?php endif?>>답변완료</option>
										</select>
									</div>
									<div class="description col-12" style="color:red;">※ 상태 '답변완료' 변경 > 등록 > 답글쓰기 > 상태 '상태없음' 유지 > 내용기입 > 등록 </div>
								</div>
							</dd>
						</dl>
						<?php else:?>
						<input type="hidden" name="category2" value="<?php echo $content->category2?$content->category2:'답변대기'?>">
						<?php endif?>
						
						<!-- Scriet Check & Lobot Check -->
						<?php if($board->viewUsernameField()):?>
						<div class="kboard-attr-row">
							<label class="attr-name" for="kboard-input-member-display"><?php echo __('Author', 'kboard')?></label>
							<div class="attr-value"><input type="text" id="kboard-input-member-display" name="member_display" value="<?php echo $content->member_display?>" placeholder="<?php echo __('Author', 'kboard')?>..."></div>
						</div>
						<div class="kboard-attr-row">
							<label class="attr-name" for="kboard-input-password"><?php echo __('Password', 'kboard')?></label>
							<div class="attr-value"><input type="password" id="kboard-input-password" name="password" value="<?php echo $content->password?>" placeholder="<?php echo __('Password', 'kboard')?>..."></div>
						</div>
						<?php else:?>
						<input style="display:none" type="text" name="fake-autofill-fields">
						<input style="display:none" type="password" name="fake-autofill-fields">
						<!-- 비밀글 비밀번호 필드 시작 -->
						<div class="kboard-attr-row secret-password-row"<?php if(!$content->secret):?> style="display:none"<?php endif?>>
							<label class="attr-name" for="kboard-input-password"><?php echo __('Password', 'kboard')?></label>
							<div class="attr-value"><input type="password" id="kboard-input-password" name="password" value="<?php echo $content->password?>" placeholder="<?php echo __('Password', 'kboard')?>..."></div>
						</div>
						<!-- 비밀글 비밀번호 필드 끝 -->
						<?php endif?>
						<!-- CAPTCHA -->
						<?php if($board->useCAPTCHA() && !$content->uid):?>
							<?php if(kboard_use_recaptcha()):?>
								<div class="kboard-attr-row">
									<label class="attr-name"></label>
									<div class="attr-value"><div class="g-recaptcha" data-sitekey="<?php echo kboard_recaptcha_site_key()?>"></div></div>
								</div>
							<?php else:?>
								<div class="kboard-attr-row">
									<label class="attr-name" for="kboard-input-captcha"><img src="<?php echo kboard_captcha()?>" alt=""></label>
									<div class="attr-value"><input type="text" id="kboard-input-captcha" name="captcha" value="" placeholder="<?php echo __('CAPTCHA', 'kboard')?>..."></div>
								</div>
							<?php endif?>
						<?php endif?>
						
						<!-- Contents -->
						<dl class="field-msg">
							<dt>내용</dt>
							<dd>
								<?php if($board->use_editor):?>
									<?php wp_editor($content->content, 'kboard_content', array('media_buttons'=>$board->isAdmin(), 'editor_height'=>400))?>
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
									<input class="hidden-input-file" type="file" id="attach" name="kboard_attach_file<?php echo $attach_index?>">
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
					<!--<input type="button" value="상세" class="btn-univ gray btn-cancel" onclick="location.href='<?php //echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>'">-->
					<input type="button" value="취소" class="kboard-selvi-button-small gray btn-cancel" onclick="location.href='<?php echo $url->set('mod', 'list')->toString()?>'">

					<!-- Editor Mode-->
					<?php else:?>
					<input type="button" value="취소" class="kboard-selvi-button-small gray btn-cancel" onclick="location.href='<?php echo $url->set('mod', 'list')->toString()?>'">
					<?php endif?>
				</div><!-- /.controls -->
				
				<!-- ADMIN SET -->
				<?php if($board->isAdmin()):?>
					<br>
					<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'remove')->toString()?>" onclick="return confirm('<?php echo __('Are you sure you want to delete?', 'kboard')?>');">
						<input type="button" value="삭제" class="btn-univ btn-reply" style="width:100%; background-color:darkgray">
					</a>
				<?php endif?>

			</div><!-- /.kboard-selvi-write -->
		</div><!-- /.kboard-selvi -->
	
	</form>
</section><!-- /.event-board -->

<!-- Kboard script -->
<script>
jQuery(document).ready(function(){
	var auto_secret_check = false;
	var document_uid = <?php echo intval($content->uid)?>;
	if(auto_secret_check && !document_uid){
		jQuery('input[name=secret]').prop('checked', true);
		kboard_toggle_password_field(jQuery('input[name=secret]'));
	}
});
</script>