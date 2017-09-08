<?php 
/**
* [init]     
* [20170718] | 관련내역 리스트 최초생성                 | eley 
* [after]
* [RENEWAL]----------------------------------------------------------
* [20170728] | RENEWAL                            | eley 
* [20170907] | 카테고리 오류수정                         | eley 
*/

class relation_list {
	function __construct(){
		//편의를 위해 wordpress 테이블이름을 변수로 만들어줌
		global $wpdb;
		
		//이벤트 응모 테이블
		$this->table = $wpdb->prefix . 'event_enter';
		//이벤트 정보 테이블
		$this->table2 = $wpdb->prefix . 'event_info';
		//포스트 정보 테이블
		$this->table3 = $wpdb->prefix . 'posts';
		
		//숏코드 등록
		add_shortcode( 'relationlist', array($this, 'shortcode') );
		
		//액션등록 admin-post.php 참조
		add_action( 'admin_post_relationlist-post', array($this, 'post_request') );
		add_action( 'admin_post_nopriv_relationlist-post', array($this, 'post_request') );
	}
	
	//숏코드 실행
	function shortcode(){
		ob_start();
		?>	
		<div id="event-list-outer">
			<!-- list loading -->
			<?php $this->the_list(); ?>
		</div>
		<?php
		return ob_get_clean();
	}
	
	//fucntion : list loading
	function the_list(){
		global $user_id;
		//현재 유저 정보를 가져옴
		global $current_user;
		wp_get_current_user();
		$user_id = $current_user->ID;
		
		//포스트정보 가져옴
		$post_id = get_the_ID();
		
		//변수에 정보담음
		$relation_rows = $this->get_relation_rows($user_id, $post_id);
		
		//스크립트 변수설정을 위한 변수
		$i = 0;
		
		//카테고리 정보 가져오기
		$options = get_proton_options();
		?>
		
		<!-- Title -->
		<!--<h3>Title</h3>-->
		
		<!-- List -->
		<div class="event-list other-event-carousel">
		<?php foreach($relation_rows as $relation_row){ ?>
			
			<!-- Value setting -->
			<?php 
			//변수초기화 및 세팅
			//응모가능한지 체크 불가능=false / 가능=true
			$event_ck = false;
			
			$post_id     = get_the_ID();
			$event_end   = '';
			$event_all_prize = '';
			$event_prize     = '';
			$event_enter     = '';
			$event_type      = 0;
			$event_url       = '';
			
			$event_ck_tx = "마감";
			$event_type_tx = "배송";
			
			if(isset($relation_row)){
				//변수설정
				$post_id         = $relation_row->post_id;
				$event_end       = $relation_row->event_end;
				$event_prize     = $relation_row->event_prize;
				$event_all_prize = $relation_row->event_all_prize;
				$event_enter     = $relation_row->event_enter;
				$event_type      = $relation_row->event_type;
				$event_url       = $relation_row->guid;

				$event_edate     = substr($event_end, 0, 10);
				$event_etime     = substr($event_end, 11, 18);
				
				//Server Event Timecheck
				//기준시간 한국으로 설정
				date_default_timezone_set('Asia/Seoul');
				
				$curnt_t     = date("Y-m-d H:i:s");
				$event_end_t = date("Y-m-d H:i:s", strtotime($event_end));
				
				//남은경품이 0이거나 남은시간이 없을때 응모버튼비활성화
				if((strtotime($event_end_t) <= strtotime($curnt_t)) || $event_prize == "0" || $event_prize == ""){
					$event_ck = false;
				}else{
					$event_ck = true;
				}
			}
			
			//이벤트 진행/마감 텍스트 설정
			if($event_ck == true){
				$event_ck_tx ="진행";
			}else{
				$event_ck_tx ="마감";
			}
			
			//이벤트타입 텍스트 설정
			if($event_type == 1){
				$event_type_tx ="매장";
			}else{
				$event_type_tx ="배송";
			}
			?>
			
			<!-- Timer setting -->
			<script>
			//time설정
			var event_end = '<?php echo date("Y-m-d H:i:s", strtotime($event_end))?>';
			
			if(event_end != '') {
				//타이머 함수 호출
				CountDownTimer(event_end,'event_countdown_<?php echo $i ?>');
			}
			
			//남은날짜 count
			function CountDownTimer(end_time, id) {
				end_time = end_time.replace(/-/g, '/');//IE에서는 지원안함 NAN표시 -> .replace("-","/")
				var end = new Date(end_time); 
				var _second = 1000;
				var _minute = _second * 60;
				var _hour = _minute * 60;
				var _day = _hour * 24;
				var timer;

				function showRemaining() {
					var now = new Date();
					var distance = end - now;
			
					if (distance <= 0) {
						clearInterval(timer);
						return;
					}
					
					var days = Math.floor(distance / _day);
					var hours = Math.floor((distance % _day) / _hour);
					var minutes = Math.floor((distance % _hour) / _minute);
					var seconds = Math.floor((distance % _minute) / _second);

					document.getElementById(id).innerHTML  = days + '일 ';
					document.getElementById(id).innerHTML += hours + '시 ';
					document.getElementById(id).innerHTML += minutes + '분 ';
					document.getElementById(id).innerHTML += seconds + '초';	
				}

				timer = setInterval(showRemaining, 1000);
			}
			</script>
	  
			<!-- View contents -->
			<!-- event item -->		
			<div class="event-list-item">			
				<div class="event-item">
					<a href="<?php echo $event_url ?>" class="inner">
					
						<div class="info">
						<!-- 타이머 설정 위한 event_end -->
						<input type="hidden" id="event_end" name="event_end" value="<?php echo $event_end;?>"/>
						
							<!-- information bar 1 -->
							<ul class="row1">
								<li class="flags">
									<div class="event-flag-group flex">
										<p class="event-flag shipping col-6"><?php echo $event_type_tx ?></p>
										<p class="event-flag ing col-6"><?php echo $event_ck_tx ?></p>
									</div><!-- /.event-flag-group -->
								</li>
								<li class="time"><text id="event_countdown_<?php echo $i ?>"/></li>
							</ul>
							
							<!-- information bar 2 -->
							<ul class="row2">
								<li class="col-6">
									<dl>
										<dt>경품</dt>
										<dd><span class="value"><?php echo $event_prize?> / <?php echo $event_all_prize?></span><span class="unit">개</span></dd>
									</dl>
								</li><!-- /.col -->
								<li class="col-6">
									<dl>
										<dt>응모</dt>
										<dd><span class="value"><?php echo $event_enter?></span><span class="unit">명</span></dd>
									</dl>
								</li><!-- /.col -->
							</ul>
						</div><!-- /.info -->
						
						<!-- thumbnail part -->
						<div class="entry-img">
							<?php
							//썸네일 사진 가져옴
							$thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id($post_id));
				
							 if($thumbnail_url != ''){ ?>
							<!--썸네일 있을때-->
								<img src='<?php echo $thumbnail_url?>'/>
							<?php } else { 
							//썸네일 없을때
									echo '<img src="' . get_template_directory_uri() . '/assets/images/default.png" />';
								} 
								
							//+ 응모확인 딱지 추가
							//<!-- yeonok: add status flag 20170824 -->
							echo 
								'<span class="text-flag">
									<i class="icon facebook xs"></i>
									<span class="tit">응모가능</span>
								</span>';
							
							//스크립트 변수설정을 위한 변수++
							$i++;
							?>
								
						</div><!-- /.thumbnail -->
						<div class="title">
							<p class="cat">
								<?php
								/* 20170907 카테고리 오류 수정
									$proton_portfolio_categories_link = $options['proton_portfolio_categories_link'];
									if($proton_portfolio_categories_link){
										foreach((get_the_category()) as $category) { echo $category->cat_name . ' '; }
									}
									else {
										the_category(' ');
									}
								*/	
									$category = get_the_category($post_id); 
									echo $category[0]->name;
									
								?>
							</p>
							<p class="tit"><?php echo get_the_title($post_id) ?></p>
						</div>
						
					</a><!-- /.inner -->
				</div><!-- /.event-item -->
			</div><!-- /.event-list-item -->
			
		<?php } ?>
		</div><!-- /.event-list other-event-carousel -->
	
		<!-- Slider js setting -->
		<script>
		jQuery(function() {
			/* Other Events Carousel */
			var flickityOptions = {
			  cellAlign: 'left',
				contain: true,
				groupCells: true,
				pageDots: false
			};
			jQuery(".other-event-carousel").flickity(flickityOptions);

		  });//$function
	  </script>
	
	<?php
	}
	//관련리스트 가져오는 함수
	function get_relation_rows($user_id, $post_id){
		global $wpdb , $user_id;
		$relation_rows = null;
		
		$user_ck = '';
		
		//전제 - 진행중인 이벤트 목록
		//유저  : 참여한 목록 포함x
		//비유저 : 모든목록 
		if($user_id == 0){
		  $user_ck = '1=1';
		} else {
			$user_ck = 'wp_event_info.event_id not in (
														SELECT 
															wp_event_info.event_id 
														FROM 
															wp_event_enter, 
															wp_event_info 
														WHERE 
															wp_event_enter.user_id = '.$user_id.' 
															AND wp_event_info.event_id = wp_event_enter.event_id
													) ';
		}
		
		$relation_rows = $wpdb->get_results(
											"SELECT 
												$this->table2.*, 
												$this->table3.post_title,
												$this->table3.guid
											FROM
												$this->table2, 
												$this->table3 
											WHERE 
												$user_ck
												AND $this->table3.post_status <> 'trash'
												AND $this->table3.post_type = 'post'
												AND $this->table2.post_id = $this->table3.ID
												AND sysdate() < $this->table2.event_end
												AND $this->table2.post_id <> $post_id"
										);
		return $relation_rows;
	}
}?>