<!-- 
[init]   
[20170714] | 로그인페이지 이동로직 생성
             검색,KBoard글씨없애기                        | eley
---------------------------------------------------
[after]
[20170717] | 사용자워드프레스 프로필 이미지 주석처리 -> 첨부이미지로 변경 | eley
-->
<div id="kboard-ocean-rating-list">
	<div class="kboard-header">
		<?php if($board->use_category == 'yes'):?>
		<div class="kboard-category">
			<?php if($board->initCategory1()):?>
				<ul class="kboard-category-list">
					<li<?php if(!$_GET['category1']):?> class="kboard-category-selected"<?php endif?>><a href="<?php echo $url->set('category1', '')->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->tostring()?>"><?php echo __('All', 'kboard')?></a></li>
					<?php while($board->hasNextCategory()):?>
					<li<?php if($_GET['category1'] == $board->currentCategory()):?> class="kboard-category-selected"<?php endif?>><a href="<?php echo $url->set('category1', $board->currentCategory())->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toString()?>"><?php echo $board->currentCategory()?></a></li>
					<?php endwhile?>
				</ul>
			<?php endif?>
			
			<?php if($board->initCategory2()):?>
				<ul class="kboard-category-list">
					<li<?php if(!$_GET['category2']):?> class="kboard-category-selected"<?php endif?>><a href="<?php echo $url->set('category2', '')->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->tostring()?>"><?php echo __('All', 'kboard')?></a></li>
					<?php while($board->hasNextCategory()):?>
					<li<?php if($_GET['category2'] == $board->currentCategory()):?> class="kboard-category-selected"<?php endif?>><a href="<?php echo $url->set('category2', $board->currentCategory())->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toString()?>"><?php echo $board->currentCategory()?></a></li>
					<?php endwhile?>
				</ul>
			<?php endif?>
		</div>
		<?php endif?>
	</div>
	
	<!-- 리스트 시작 -->
	<ul class="kboard-list">
	<?php while($content = $list->hasNext()):?>
		<li class="kboard-list-item">
			<!-- 워프레스 프로필사진 삭제 20170717-->
			<!--<div class="kboard-wrap-left"><?php //echo get_avatar($content->member_uid, 70, '', $content->member_display)?></div>-->
			<!-- 첨부이미지로 대체 20170717 -->
				<div class="kboard-wrap-left">
				<?php foreach($content->attach as $key=>$attach): $extension = strtolower(pathinfo($attach[0], PATHINFO_EXTENSION));?>
					<?php if(in_array($extension, array('gif','jpg','jpeg','png'))):?>
						<p class="thumbnail-area"><a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>"><img src="<?php echo site_url($attach[0])?>" alt="<?php echo $attach[1]?>"></a></p>
					<?php else: $download[$key] = $attach; endif?>
				<?php endforeach?>
				</div>
			<div class="kboard-wrap-center">
				<div class="kboard-item-title cut_strings"><a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>"><?php echo $content->title?> <span class="kboard-rating value-<?php echo $content->option->rating?>" title="<?php echo $content->option->rating?>"></span></a></div>
				<div class="kbaord-item-rating"><span class="kboard-rating value-<?php echo $content->option->rating?>" title="<?php echo $content->option->rating?>"></span></div>
				<div class="kboard-item-content cut_strings"><a href="<?php echo $url->set('uid', $content->uid)->set('mod', 'document')->toString()?>"><?php echo strip_tags($content->content)?></a></div>
				<div class="kboard-item-info">
					<span><?php echo $content->member_display?></span> |
					<?php echo date("Y.m.d", strtotime($content->date))?>
				</div>
			</div>
			<div class="kboard-wrap-right">
				<div class="kboard-right kboard-item-like"><div class="kboard-item-padding">추천 : <span class="kboard-count-bold"><?php echo $content->like?></span></div></div>
				<div class="kboard-right kboard-item-comment"><div class="kboard-item-padding">답변 : <span class="kboard-count-bold"><?php $comment = $content->getCommentsCount('',''); echo $comment?$comment:'0';?></span></div></div>
				<div class="kboard-right kboard-item-view"><div class="kboard-item-padding">조회 : <span class="kboard-count-bold"><?php echo $content->view?></span></div></div>
			</div>
		</li>
	<?php endwhile?>
	</ul>
	<!-- 리스트 끝 -->
	
	<!-- 페이징 시작 -->
	<div class="kboard-pagination">
		<ul class="kboard-pagination-pages">
			<?php echo kboard_pagination($list->page, $list->total, $list->rpp)?>
		</ul>
	</div>
	<!-- 페이징 끝 -->
	
	<!-- 검색폼 주석처리 -->
	<!--
	<form id="kboard-search-form" method="get" action="<?php echo $url->set('mod', 'list')->toString()?>">
		<?php echo $url->set('pageid', '1')->set('target', '')->set('keyword', '')->set('mod', 'list')->toInput()?>
		<div class="kboard-search">
			<select name="target">
				<option value=""><?php echo __('All', 'kboard')?></option>
				<option value="title"<?php if($_GET['target'] == 'title'):?> selected="selected"<?php endif?>><?php echo __('Title', 'kboard')?></option>
				<option value="content"<?php if($_GET['target'] == 'content'):?> selected="selected"<?php endif?>><?php echo __('Content', 'kboard')?></option>
				<option value="member_display"<?php if($_GET['target'] == 'member_display'):?> selected="selected"<?php endif?>><?php echo __('Author', 'kboard')?></option>
			</select>
			<input type="text" name="keyword" value="<?php echo $_GET['keyword']?>">
			<button type="submit" class="kboard-ocean-rating-button-small"><?php echo __('Search', 'kboard')?></button>
		</div>
	</form>
	-->
	
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
	
	<!-- 버튼 시작 -->
	<!--
	<div class="kboard-control">
		<a href="<?php echo $url->set('mod', 'editor')->toString()?>" class="kboard-ocean-rating-button-small"><?php echo __('New', 'kboard')?></a>
	</div>
	-->
	<!-- 버튼 끝 -->
	<!-- 위 코드 변경 -->
	<div class="kboard-control">
		<a href="javascript:kboard_logchk();" class="kboard-ocean-rating-button-small"><?php echo __('New', 'kboard')?></a>
	</div>
	<?php endif?>
	<!-- 글씨숨김 -->
	<!--
	<div class="kboard-ocean-rating-poweredby">
		<a href="http://www.cosmosfarm.com/products/kboard" onclick="window.open(this.href);return false;" title="<?php echo __('KBoard is the best community software available for WordPress', 'kboard')?>">Powered by KBoard</a>
	</div>
	-->
</div>

<script type="text/javascript" src="<?php echo $skin_path?>/script.js"></script>