<!-- 
[init]   
[20170714] | 로그인페이지 이동로직 생성
             검색,KBoard글씨없애기            | eley
---------------------------------------------------
[after]
-->
<div id="kboard-ask-one-list">
	
	<!-- 게시판 정보 시작 -->
	<!-- 상위 글쓰기 버튼 제거-->
	<div class="kboard-list-header">
		<!-- 상위 글쓰기 버튼 제거-->
		<!--
		<div class="kboard-left">
			<?php if($board->isWriter()):?>
				<a href="<?php echo $url->set('mod', 'editor')->toString()?>" class="kboard-ask-one-button-small"><?php echo __('New', 'kboard')?></a>
			<?php endif?>
		</div>
		-->
		
		<div class="kboard-right">
			<?php if($board->use_category == 'yes'):?>
			<div class="kboard-category category-pc">
				<form id="kboard-category-form-<?php echo $board->id?>-pc" method="get" action="<?php echo $url->toString()?>">
					<?php echo $url->set('pageid', '1')->set('category1', '')->set('category2', '')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput()?>
					
					<?php if($board->initCategory1()):?>
						<select name="category1" onchange="jQuery('#kboard-category-form-<?php echo $board->id?>-pc').submit();">
							<option value=""><?php echo __('All', 'kboard')?></option>
							<?php while($board->hasNextCategory()):?>
							<option value="<?php echo $board->currentCategory()?>"<?php if(kboard_category1() == $board->currentCategory()):?> selected<?php endif?>><?php echo $board->currentCategory()?></option>
							<?php endwhile?>
						</select>
					<?php endif?>
					
					<?php if($board->initCategory2()):?>
						<select name="category2" onchange="jQuery('#kboard-category-form-<?php echo $board->id?>-pc').submit();">
							<option value=""><?php echo __('All', 'kboard')?></option>
							<?php while($board->hasNextCategory()):?>
							<option value="<?php echo $board->currentCategory()?>"<?php if(kboard_category2() == $board->currentCategory()):?> selected<?php endif?>><?php echo $board->currentCategory()?></option>
							<?php endwhile?>
						</select>
					<?php endif?>
				</form>
			</div>
			<?php endif?>
			<!--
			<form id="kboard-sort-form-<?php echo $board->id?>" method="get" action="<?php echo $url->toString()?>">
				<?php echo $url->set('pageid', '1')->set('category1', '')->set('category2', '')->set('target', '')->set('keyword', '')->set('mod', 'list')->set('kboard_list_sort_remember', $board->id)->toInput()?>
				
				<select name="kboard_list_sort" onchange="jQuery('#kboard-sort-form-<?php echo $board->id?>').submit();">
					<option value="newest"<?php if($list->getSorting() == 'newest'):?> selected<?php endif?>><?php echo __('Newest', 'kboard')?></option>
					<option value="best"<?php if($list->getSorting() == 'best'):?> selected<?php endif?>><?php echo __('Best', 'kboard')?></option>
					<option value="viewed"<?php if($list->getSorting() == 'viewed'):?> selected<?php endif?>><?php echo __('Viewed', 'kboard')?></option>
					<option value="updated"<?php if($list->getSorting() == 'updated'):?> selected<?php endif?>><?php echo __('Updated', 'kboard')?></option>
				</select>
			</form>
			-->
		</div>
	</div>
	
	<!-- 게시판 정보 끝 -->
	
	<?php if($board->use_category == 'yes'):?>
	<div class="kboard-category category-mobile">
		<form id="kboard-category-form-<?php echo $board->id?>-mobile" method="get" action="<?php echo $url->toString()?>">
			<?php echo $url->set('pageid', '1')->set('category1', '')->set('category2', '')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput()?>
			
			<?php if($board->initCategory1()):?>
				<select name="category1" onchange="jQuery('#kboard-category-form-<?php echo $board->id?>-mobile').submit();">
					<option value=""><?php echo __('All', 'kboard')?></option>
					<?php while($board->hasNextCategory()):?>
					<option value="<?php echo $board->currentCategory()?>"<?php if(kboard_category1() == $board->currentCategory()):?> selected<?php endif?>><?php echo $board->currentCategory()?></option>
					<?php endwhile?>
				</select>
			<?php endif?>
			
			<?php if($board->initCategory2()):?>
				<select name="category2" onchange="jQuery('#kboard-category-form-<?php echo $board->id?>-mobile').submit();">
					<option value=""><?php echo __('All', 'kboard')?></option>
					<?php while($board->hasNextCategory()):?>
					<option value="<?php echo $board->currentCategory()?>"<?php if(kboard_category2() == $board->currentCategory()):?> selected<?php endif?>><?php echo $board->currentCategory()?></option>
					<?php endwhile?>
				</select>
			<?php endif?>
		</form>
	</div>
	<?php endif?>
	
	<!-- 리스트 시작 -->
	<div class="kboard-list">
		<table>
			<thead>
				<tr>
					<td class="kboard-list-uid"><?php echo __('Number', 'kboard')?></td>
					
					<?php if($board->use_category == 'yes' && $board->initCategory1()):?>
						<td class="kboard-list-category"><?php echo __('Category', 'kboard')?></td>
					<?php endif?>
					
					<td class="kboard-list-title"><?php echo __('Title', 'kboard')?></td>
					<td class="kboard-list-status"><?php echo __('Status', 'kboard')?></td>
					<td class="kboard-list-user"><?php echo __('Author', 'kboard')?></td>
					<td class="kboard-list-date"><?php echo __('Date', 'kboard')?></td>
					<td class="kboard-list-vote"><?php echo __('Votes', 'kboard')?></td>
					<td class="kboard-list-view"><?php echo __('Views', 'kboard')?></td>
				</tr>
			</thead>
			<tbody>
				<?php while($content = $list->hasNextNotice()):?>
				<tr class="kboard-list-notice<?php if($content->uid == kboard_uid()):?> kboard-list-selected<?php endif?>">
					<td class="kboard-list-uid"><?php echo __('Notice', 'kboard')?></td>
					
					<?php if($board->use_category == 'yes' && $board->initCategory1()):?>
						<td class="kboard-list-category"><?php echo $content->category1?></td>
					<?php endif?>
					
					<td class="kboard-list-title">
						<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>">
							<div class="kboard-ask-one-cut-strings">
								<?php if($content->isNew()):?><span class="kboard-ask-one-new-notify">New</span><?php endif?>
								<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon-lock.png" class="kboard-icon-lock" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
								
								<?php if($board->use_category == 'yes' && $board->initCategory1()):?>
									<span class="kboard-mobile-category"><?php if($content->category1):?>[<?php echo $content->category1?>]<?php endif?></span>
								<?php endif?>
								
								<?php echo $content->title?>
								<span class="kboard-comments-count"><?php echo $content->getCommentsCount()?></span>
							</div>
							<div class="kboard-mobile-status">
								<?php if($content->category2 == '답변대기'):?><span class="kboard-ask-one-status-wait">답변대기</span><?php endif?>
								<?php if($content->category2 == '답변완료'):?><span class="kboard-ask-one-status-complete">답변완료</span><?php endif?>
							</div>
							<div class="kboard-mobile-contents">
								<span class="contents-item"><?php echo $content->member_display?></span>
								<span class="contents-separator">|</span>
								<span class="contents-item"><?php echo $content->getDate()?></span>
								<!--
								<span class="contents-separator">|</span>
								<span class="contents-item"><?php echo __('Votes', 'kboard')?> <?php echo $content->vote?></span>
								<span class="contents-separator">|</span>
								<span class="contents-item"><?php echo __('Views', 'kboard')?> <?php echo $content->view?></span>
								-->
							</div>
						</a>
					</td>
					<td class="kboard-list-status">
						<?php if($content->category2 == '답변대기'):?><span class="kboard-ask-one-status-wait">답변대기</span><?php endif?>
						<?php if($content->category2 == '답변완료'):?><span class="kboard-ask-one-status-complete">답변완료</span><?php endif?>
					</td>
					<td class="kboard-list-user"><?php echo $content->member_display?></td>
					<td class="kboard-list-date"><?php echo $content->getDate()?></td>
					<td class="kboard-list-vote"><?php echo $content->vote?></td>
					<td class="kboard-list-view"><?php echo $content->view?></td>
				</tr>
				<?php endwhile?>
				<?php while($content = $list->hasNext()):?>
				<tr class="<?php if($content->uid == kboard_uid()):?>kboard-list-selected<?php endif?>">
					<td class="kboard-list-uid"><?php echo $list->index()?></td>
					
					<?php if($board->use_category == 'yes' && $board->initCategory1()):?>
						<td class="kboard-list-category"><?php echo $content->category1?></td>
					<?php endif?>
					
					<td class="kboard-list-title">
						<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>">
							<div class="kboard-ask-one-cut-strings">
								<?php if($content->isNew()):?><span class="kboard-ask-one-new-notify">New</span><?php endif?>
								<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon-lock.png" class="kboard-icon-lock" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
								
								<?php if($board->use_category == 'yes' && $board->initCategory1()):?>
									<span class="kboard-mobile-category"><?php if($content->category1):?>[<?php echo $content->category1?>]<?php endif?></span>
								<?php endif?>
								
								<?php echo $content->title?>
								<span class="kboard-comments-count"><?php echo $content->getCommentsCount()?></span>
							</div>
							<div class="kboard-mobile-status">
								<?php if($content->category2 == '답변대기'):?><span class="kboard-ask-one-status-wait">답변대기</span><?php endif?>
								<?php if($content->category2 == '답변완료'):?><span class="kboard-ask-one-status-complete">답변완료</span><?php endif?>
							</div>
							<div class="kboard-mobile-contents">
								<span class="contents-item"><?php echo $content->member_display?></span>
								<span class="contents-separator">|</span>
								<span class="contents-item"><?php echo $content->getDate()?></span>
								<!--
								<span class="contents-separator">|</span>
								<span class="contents-item"><?php echo __('Votes', 'kboard')?> <?php echo $content->vote?></span>
								<span class="contents-separator">|</span>
								<span class="contents-item"><?php echo __('Views', 'kboard')?> <?php echo $content->view?></span>
								-->
							</div>
						</a>
					</td>
					<td class="kboard-list-status">
						<?php if($content->category2 == '답변대기'):?><span class="kboard-ask-one-status-wait">답변대기</span><?php endif?>
						<?php if($content->category2 == '답변완료'):?><span class="kboard-ask-one-status-complete">답변완료</span><?php endif?>
					</td>
					<td class="kboard-list-user"><?php echo $content->member_display?></td>
					<td class="kboard-list-date"><?php echo $content->getDate()?></td>
					<td class="kboard-list-vote"><?php echo $content->vote?></td>
					<td class="kboard-list-view"><?php echo $content->view?></td>
				</tr>
				<?php $boardBuilder->builderReply($content->uid)?>
				<?php endwhile?>
			</tbody>
		</table>
	</div>
	<!-- 리스트 끝 -->
	
	<!-- 페이징 시작 -->
	<div class="kboard-pagination">
		<ul class="kboard-pagination-pages">
			<?php echo kboard_pagination($list->page, $list->total, $list->rpp)?>
		</ul>
	</div>
	<!-- 페이징 끝 -->
	
	<!-- 검색폼 시작 -->
	<!-- 검색폼 주석처리 -->
	<!--
	<div class="kboard-search">
		<form id="kboard-search-form-<?php echo $board->id?>" method="get" action="<?php echo $url->toString()?>">
			<?php echo $url->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput()?>
			
			<select name="target">
				<option value=""><?php echo __('All', 'kboard')?></option>
				<option value="title"<?php if(kboard_target() == 'title'):?> selected="selected"<?php endif?>><?php echo __('Title', 'kboard')?></option>
				<option value="content"<?php if(kboard_target() == 'content'):?> selected="selected"<?php endif?>><?php echo __('Content', 'kboard')?></option>
				<option value="member_display"<?php if(kboard_target() == 'member_display'):?> selected="selected"<?php endif?>><?php echo __('Author', 'kboard')?></option>
			</select>
			<input type="text" name="keyword" value="<?php echo kboard_keyword()?>">
			<button type="submit" class="kboard-ask-one-button-search" title="<?php echo __('Search', 'kboard')?>"><img src="<?php echo $skin_path?>/images/icon-search.png" alt="<?php echo __('Search', 'kboard')?>"></button>
		</form>
	</div>
	-->
	<!-- 검색폼 끝 -->
	
	<?php if($board->isWriter()):?>
	
	<!-- 로그인/비로그인 체크 20170714-->
	<?php 
		//현재 유저 정보를 가져옴
		global $current_user;
		get_currentuserinfo();
		$user_id = $current_user->ID;
		
		//로그인 유저가 아닐때 빈값줌
		if(is_null($user_id)){
			$user_id = "";
		}	
	?>
	
	<!-- 20170714 로그인 이동시키기 함수-->
	<script>
		function kboard_logchk() {
			var user = <?php echo $user_id?>;
			if(!user){
				//유저가 아닐때 로그인으로 이동
				if(confirm("로그인이 필요한 서비스입니다.\n로그인하시겠습니까?")){
					//iframe사용으로 인한 부모창으로url이동
					parent.change_parent_url("http://selvitest.cafe24.com/login/");
					//location.href = "http://selvitest.cafe24.com/login/";
					//주석처리 20170714
					/*
					//홈페이지 상단으로 이동
					x = document.body.scrollLeft;
					y = document.body.scrollTop; 
					step = 2; 

					while ((x != 0) || (y != 0)) { 
						scroll (x, y); 
						step += (step * step / 300); 
						x -= step; 
						y -= step; 
						if (x < 0) x = 0; 
						if (y < 0) y = 0; 
					} 
					scroll (0, 0); 
					//상단 로그인 버튼 활성화
					document.getElementById("hiddenlogin").style.display="";
					*/
					}
					
			//유저일때 글쓰기로 이동
			} else {
				location.href = "<?php echo $url->set('mod', 'editor')->toString()?>";
			}
		}
	</script>
	
	<!--
	<div class="kboard-control">
		<a href="<?php echo $url->set('mod', 'editor')->toString()?>" class="kboard-ask-one-button-small"><?php echo __('New', 'kboard')?></a>
	</div>
	-->
	<!-- 위 코드 변경 -->
	<div class="kboard-control">
		<a href="javascript:kboard_logchk();" class="kboard-ask-one-button-small"><?php echo __('New', 'kboard')?></a>
	</div>
	<?php endif?>
	<!-- 글씨숨김 -->
	<!--
	<div class="kboard-ask-one-poweredby">
		<a href="http://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href);return false;" title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard')?>">Powered by KBoard</a>
	</div>
	-->
</div>