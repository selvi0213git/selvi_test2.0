<!-- 
[init]   
[20170605] | 글쓰기버튼 클릭시 로그인/비로그인 체크로직  | eley   
[20170605] | 비로그인 유저일때 로그인 페이지로 이동시키기 | eley 
---------------------------------------------------
[after]
[20170606] | 기존 로그인페이지이동->페이지상단으로 이동  | eley
[20170714] | 로그인페이지이동으로변경
             검색,KBoard글씨없애기             | eley
-->
<div id="kboard-default-list">
	
	<!-- 게시판 정보 시작 -->
	<div class="kboard-list-header">
		<?php if(!$board->isPrivate()):?>
			<div class="kboard-total-count">
				<?php echo __('Total', 'kboard')?> <?php echo number_format($board->getListTotal())?>
			</div>
		<?php endif?>
		
		<div class="kboard-sort">
			<form id="kboard-sort-form-<?php echo $board->id?>" method="get" action="<?php echo $url->toString()?>">
				<?php echo $url->set('pageid', '1')->set('category1', '')->set('category2', '')->set('target', '')->set('keyword', '')->set('mod', 'list')->set('kboard_list_sort_remember', $board->id)->toInput()?>
				
				<select name="kboard_list_sort" onchange="jQuery('#kboard-sort-form-<?php echo $board->id?>').submit();">
					<option value="newest"<?php if($list->getSorting() == 'newest'):?> selected<?php endif?>><?php echo __('Newest', 'kboard')?></option>
					<option value="best"<?php if($list->getSorting() == 'best'):?> selected<?php endif?>><?php echo __('Best', 'kboard')?></option>
					<option value="viewed"<?php if($list->getSorting() == 'viewed'):?> selected<?php endif?>><?php echo __('Viewed', 'kboard')?></option>
					<option value="updated"<?php if($list->getSorting() == 'updated'):?> selected<?php endif?>><?php echo __('Updated', 'kboard')?></option>
				</select>
			</form>
		</div>
	</div>
	<!-- 게시판 정보 끝 -->
	
	<?php if($board->use_category == 'yes'):?>
	<!-- 카테고리 시작 -->
	<div class="kboard-category category-mobile">
		<form id="kboard-category-form-<?php echo $board->id?>" method="get" action="<?php echo $url->toString()?>">
			<?php echo $url->set('pageid', '1')->set('category1', '')->set('category2', '')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput()?>
			
			<?php if($board->initCategory1()):?>
				<select name="category1" onchange="jQuery('#kboard-category-form-<?php echo $board->id?>').submit();">
					<option value=""><?php echo __('All', 'kboard')?></option>
					<?php while($board->hasNextCategory()):?>
					<option value="<?php echo $board->currentCategory()?>"<?php if(kboard_category1() == $board->currentCategory()):?> selected<?php endif?>><?php echo $board->currentCategory()?></option>
					<?php endwhile?>
				</select>
			<?php endif?>
			
			<?php if($board->initCategory2()):?>
				<select name="category2" onchange="jQuery('#kboard-category-form-<?php echo $board->id?>').submit();">
					<option value=""><?php echo __('All', 'kboard')?></option>
					<?php while($board->hasNextCategory()):?>
					<option value="<?php echo $board->currentCategory()?>"<?php if(kboard_category2() == $board->currentCategory()):?> selected<?php endif?>><?php echo $board->currentCategory()?></option>
					<?php endwhile?>
				</select>
			<?php endif?>
		</form>
	</div>
	
	<div class="kboard-category category-pc">
		<?php if($board->initCategory1()):?>
			<ul class="kboard-category-list">
				<li<?php if(!kboard_category1()):?> class="kboard-category-selected"<?php endif?>><a href="<?php echo $url->set('category1', '')->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->tostring()?>"><?php echo __('All', 'kboard')?></a></li>
				<?php while($board->hasNextCategory()):?>
				<li<?php if(kboard_category1() == $board->currentCategory()):?> class="kboard-category-selected"<?php endif?>>
					<a href="<?php echo $url->set('category1', $board->currentCategory())->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toString()?>"><?php echo $board->currentCategory()?></a>
				</li>
				<?php endwhile?>
			</ul>
		<?php endif?>
		
		<?php if($board->initCategory2()):?>
			<ul class="kboard-category-list">
				<li<?php if(!kboard_category2()):?> class="kboard-category-selected"<?php endif?>><a href="<?php echo $url->set('category2', '')->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->tostring()?>"><?php echo __('All', 'kboard')?></a></li>
				<?php while($board->hasNextCategory()):?>
				<li<?php if(kboard_category2() == $board->currentCategory()):?> class="kboard-category-selected"<?php endif?>>
					<a href="<?php echo $url->set('category2', $board->currentCategory())->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toString()?>"><?php echo $board->currentCategory()?></a>
				</li>
				<?php endwhile?>
			</ul>
		<?php endif?>
	</div>
	<!-- 카테고리 끝 -->
	<?php endif?>
	
	<!-- 리스트 시작 -->
	<div class="kboard-list">
		<table>
			<thead>
				<tr>
					<td class="kboard-list-uid"><?php echo __('Number', 'kboard')?></td>
					<td class="kboard-list-title"><?php echo __('Title', 'kboard')?></td>
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
					<td class="kboard-list-title">
						<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>">
							<div class="kboard-default-cut-strings">
								<?php if($content->isNew()):?><span class="kboard-default-new-notify">New</span><?php endif?>
								<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon-lock.png" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
								<?php echo $content->title?>
								<span class="kboard-comments-count"><?php echo $content->getCommentsCount()?></span>
							</div>
						</a>
						<div class="kboard-mobile-contents">
							<span class="contents-item"><?php echo apply_filters('kboard_user_display', $content->member_display, $content->member_uid, $content->member_display, 'kboard', $boardBuilder)?></span>
							<span class="contents-separator">|</span>
							<span class="contents-item"><?php echo $content->getDate()?></span>
							<span class="contents-separator">|</span>
							<span class="contents-item"><?php echo __('Votes', 'kboard')?> <?php echo $content->vote?></span>
							<span class="contents-separator">|</span>
							<span class="contents-item"><?php echo __('Views', 'kboard')?> <?php echo $content->view?></span>
						</div>
					</td>
					<td class="kboard-list-user"><?php echo apply_filters('kboard_user_display', $content->member_display, $content->member_uid, $content->member_display, 'kboard', $boardBuilder)?></td>
					<td class="kboard-list-date"><?php echo $content->getDate()?></td>
					<td class="kboard-list-vote"><?php echo $content->vote?></td>
					<td class="kboard-list-view"><?php echo $content->view?></td>
				</tr>
				<?php endwhile?>
				<?php while($content = $list->hasNext()):?>
				<tr class="<?php if($content->uid == kboard_uid()):?>kboard-list-selected<?php endif?>">
					<td class="kboard-list-uid"><?php echo $list->index()?></td>
					<td class="kboard-list-title">
						<a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>">
							<div class="kboard-default-cut-strings">
								<?php if($content->isNew()):?><span class="kboard-default-new-notify">New</span><?php endif?>
								<?php if($content->secret):?><img src="<?php echo $skin_path?>/images/icon-lock.png" alt="<?php echo __('Secret', 'kboard')?>"><?php endif?>
								<?php echo $content->title?>
								<span class="kboard-comments-count"><?php echo $content->getCommentsCount()?></span>
							</div>
						</a>
						<div class="kboard-mobile-contents">
							<span class="contents-item"><?php echo apply_filters('kboard_user_display', $content->member_display, $content->member_uid, $content->member_display, 'kboard', $boardBuilder)?></span>
							<span class="contents-separator">|</span>
							<span class="contents-item"><?php echo $content->getDate()?></span>
							<span class="contents-separator">|</span>
							<span class="contents-item"><?php echo __('Votes', 'kboard')?> <?php echo $content->vote?></span>
							<span class="contents-separator">|</span>
							<span class="contents-item"><?php echo __('Views', 'kboard')?> <?php echo $content->view?></span>
						</div>
					</td>
					<td class="kboard-list-user"><?php echo apply_filters('kboard_user_display', $content->member_display, $content->member_uid, $content->member_display, 'kboard', $boardBuilder)?></td>
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
	<!-- 검색폼 주석처리 20170714-->
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
			<button type="submit" class="kboard-default-button-small"><?php echo __('Search', 'kboard')?></button>
		</form>
	</div>
	-->
	<!-- 검색폼 끝 -->
	
	<?php if($board->isWriter()):?>
	
	<!-- 로그인/비로그인 체크 20170605-->
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
	
	<!-- 20170605 20170606 로그인 이동시키기 함수-->
	<script>
		function kboard_logchk() {
			var user = <?php echo $user_id?>;
			if(!user){
				//유저가 아닐때 로그인으로 이동
				if(confirm("로그인이 필요한 서비스입니다.\n로그인하시겠습니까?")){
					//iframe사용으로 인한 부모창으로url이동
					parent.change_parent_url("http://selvi.co.kr/login/");
					//location.href = "http://selvi.co.kr/login/";
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
	
	<!-- 버튼 시작 -->
	<!--
	<div class="kboard-control">
		<a href="<?php echo $url->set('mod', 'editor')->toString()?>" class="kboard-default-button-small"><?php echo __('New', 'kboard')?></a>
	</div>
	-->
	<!-- 위 코드 변경 -->
	<div class="kboard-control">
		<a href="javascript:kboard_logchk();" class="kboard-default-button-small"><?php echo __('New', 'kboard')?></a>
	</div>
	
	<!-- 버튼 끝 -->
	<?php endif?>
	
	<!-- 글씨숨김 20170714-->
	<!--
	<div class="kboard-default-poweredby">
		<a href="http://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href);return false;" title="<?php //echo __('KBoard is the best community software available for WordPress', 'kboard')?>">Powered by KBoard</a>
	</div>
	-->
</div>