<!-- 
[init]   
[20170726] | RENEWAL - Kboard review-custom create     | eley
--------------------------------------------------------------
[after]
-->
<!-- yeonok: kboard review 시작 -->
<section class="event-board review">
	<!-- Text -->
	<h3 class="kboard-section-hd">리뷰</h3>
	<!-- Board start -->
	<div class="kboard-selvi">
	
		<!-- Category header -->
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
		</div><!--/.kboard-header-->
		
		<!-- Review List -->
		<div class="kboard-list">
			<table>
			
				<!-- Head Menu -->
				<thead>
					<tr>
						<td class="kboard-list-uid">No.</td>
						<td class="kboard-list-title">제목</td>
						<td class="kboard-list-user">작성자</td>
						<td class="kboard-list-date">등록일</td>
					</tr>
				</thead>
				
				
				<!-- Item List start -->
				<tbody>
				<?php while($content = $list->hasNext()):?>
					<tr class="">
						<!-- No -->
						<td class="kboard-list-uid"><?php echo $list->index()?></td>
						
						<!-- title -->
						<td class="kboard-list-title">
							<a href="#">
								<!-- title -->
								<?php echo $content->title?>
								
								<!-- content view -->
								<div class="content-view">
									<!-- att & thumbnail -->
									<?php foreach($content->attach as $key=>$attach): $extension = strtolower(pathinfo($attach[0], PATHINFO_EXTENSION));?>
										<?php if(in_array($extension, array('gif','jpg','jpeg','png'))):?>
											<p class="thumbnail-area"><img src="<?php echo site_url($attach[0])?>" alt="<?php echo $attach[1]?>"></p>
										<?php else: $download[$key] = $attach; endif?>
									<?php endforeach?>
									
									<!-- content -->
									<?php echo nl2br($content->content)?>
									
									<!-- ADMIN SET -->
									<?php if($board->isAdmin()):?>
										<input type="button" value="삭제" class="kboard-ask-one-button-gray" style="width:100%; background-color:darkgray" onclick="location.href='<?php echo $url->set('uid', $content->uid)->set('mod', 'remove')->toString()?>'">
									<?php endif ?>
								</div>
								
								<div class="kboard-mobile-contents">
									<!-- +작성자 글자끝 *표시 -->
									<span class="contents-item">
										<?php
										$m_display = mb_substr($content->member_display, '0', -1) . "*";
										echo $m_display;
										?>
									</span>
									<span class="contents-separator">|</span>
									<span class="contents-item"><?php echo date("Y-m-d", strtotime($content->date))?></span>
								</div>
							</a>
						</td>
						
						<!-- user -->
						<!-- +작성자 글자끝 *표시 -->
						<td class="kboard-list-user">
							<?php
							echo $m_display;
							?>
						</td>
						
						<!-- date -->
						<td class="kboard-list-date"><?php echo date("Y-m-d", strtotime($content->date))?></td>
					</tr>
				<?php endwhile?>
				</tbody>
			</table>
		</div>
		<!-- Item List end -->
		
		<!-- Pageing -->
		<div class="kboard-pagination">
			<ul class="kboard-pagination-pages">
				<?php echo kboard_pagination($list->page, $list->total, $list->rpp)?>
			</ul>
		</div>
					
		<!-- Login controller start -->
		<?php if($board->isWriter()):?>

		<!-- Login check -->
		<?php 
			//현재 유저 정보를 가져옴
			global $current_user;
			wp_get_current_user();
			$user_id = $current_user->ID;
			
			//로그인 유저가 아닐때 빈값줌
			if(is_null($user_id)){
				$user_id = "";
			}	
		?>
		
		<!-- function : login check & link login page -->
		<script>
			
			/* Login Check */
			function kboard_logchk() {
				var user = <?php echo $user_id?>;
				if(!user){
					//유저가 아닐때 로그인으로 이동
					if(confirm("로그인이 필요한 서비스입니다.\n로그인하시겠습니까?")){
						//iframe사용으로 인한 부모창으로url이동
						parent.change_parent_url("http://selvi.co.kr/login/");
						}
						
				//유저일때 글쓰기로 이동
				} else {
					location.href = "<?php echo $url->set('mod', 'editor')->toString()?>";
				}
			}
		</script>

		<!-- Button write -->
		<div class="kboard-control">
			<a href="javascript:kboard_logchk();" class="kboard-selvi-button-small"><?php echo __('New', 'kboard')?></a>
		</div>
		
		<?php endif?>
		<!-- Login controller end -->
		
	</div><!-- .kboard-selvi -->
</section><!-- /.event-review -->
<!-- yeonok: kboard review 끝 -->

<script type="text/javascript" src="<?php echo $skin_path?>/script.js"></script>