<?php
/**
[init] 
[20170724] | RENEWAL                               | eley    
---------------------------------------------------------------
[after]
*/
	/* Template Name: Portfolio */
	get_header();
	$options = get_proton_options();

		// Page Title
		$proton_page_title = get_field("proton_page_title");
		if($proton_page_title) :
	?>
		<div class="page-title">
			<div class="row">
				<div class="col-md-12">
					<h1><?php echo $proton_page_title; ?></h1>
				</div>
			</div>
		</div>
	<?php
		endif;
		if(have_posts()) : while(have_posts()) : the_post();
	?>

	<!-- portfolio start -->
	<div class="portfolio">
		<?php
			//스크립트 변수설정을 위한 전역변수설정
			$i= 0;
			
			// The content of Page
			the_content();

			// Filters
			$proton_enable_filters = get_field("proton_portfolio_filters");
			$proton_filters = get_field("proton_portfolio_filter_tags");

			if($proton_enable_filters && $proton_filters) :
		?>
		
		<div class="filters">
			<span><?php echo esc_attr__("Filters:", "proton"); ?></span>
			<ul id="filters">
				<li class="active" data-filter="*"><?php echo esc_attr__("All", "proton"); ?></li>
				<?php foreach($proton_filters as $filter) : ?>
					<li data-filter=".<?php echo esc_attr($filter->slug); ?>"><?php echo esc_attr($filter->name); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		
		<?php
			endif;

			// Portfolio Style
			$proton_portfolio_style = get_field("proton_portfolio_style");
			if(!$proton_portfolio_style){
				$proton_portfolio_style = 1;
			}

			if($proton_portfolio_style == '1'){
				$proton_portfolio_style = $options['portfolio_style'];
				$portfolio_style = $proton_portfolio_style;
			}
			else {
				$portfolio_style = $proton_portfolio_style - 1;
			}

			// Portfolio Hover
			$proton_hover_style = get_field("proton_hover_style");
			if(!$proton_hover_style){
				$proton_hover_style = 1;
			}

			if($proton_hover_style == '1'){
				$proton_hover_style = $options['portfolio_hover'];
				$portfolio_hover = $proton_hover_style;
			}
			else {
				$portfolio_hover = $proton_hover_style - 1;
			}

			// Columns
			$proton_portfolio_layout_item = "col-md-4 col-sm-6 col-xs-12 selector";
			$proton_portfolio_columns = get_field("proton_portfolio_columns");
			$portfolio_columns = $options['portfolio_columns'];
			$proton_portfolio_masonry = get_field("proton_portfolio_masonry");

			if($proton_portfolio_columns == '1'){
				switch($portfolio_columns){
					case 'two':
						$proton_portfolio_layout_item = "col-md-6 col-sm-6 col-xs-12 selector";
					break;
					case 'four':
						$proton_portfolio_layout_item = "col-md-3 col-sm-6 col-xs-12 selector";
					break;
				}
			}
			else {
				switch($proton_portfolio_columns){
					case '2':
						$proton_portfolio_layout_item = "col-md-6 col-sm-6 col-xs-12 selector";
					break;
					case '4':
						$proton_portfolio_layout_item = "col-md-3 col-sm-6 col-xs-12 selector";
					break;
				}
			}

			// Text Position
			$proton_text_position_holder = "";
			$proton_text_position = get_field("proton_text_position");
			$portfolio_meta_position = $options['portfolio_meta_position'];

			if($proton_text_position != '1'){
				switch ($proton_text_position) {
					case '3':
					$proton_text_position_holder = "top-left-hover";
				break;
					case '4':
					$proton_text_position_holder = "top-right-hover";
				break;
					case '5':
					$proton_text_position_holder = "bottom-left-hover";
				break;
					case '6':
					$proton_text_position_holder = "bottom-right-hover";
				break;
				}
			}
			else {
				switch($portfolio_meta_position){
					case 'top-left':
					$proton_text_position_holder = "top-left-hover";
				break;
					case 'top-right':
					$proton_text_position_holder = "top-right-hover";
				break;
					case 'bottom-left':
					$proton_text_position_holder = "bottom-left-hover";
				break;
					case 'bottom-right':
					$proton_text_position_holder = "bottom-right-hover";
				break;
				}
			}

			// Hover Effect
			$proton_portfolio_hover_effect = get_field("proton_portfolio_hover_effect");
			$portfolio_hover_effect = $options['portfolio_hover_effect'];

			// Portfolio Masonry
			$proton_portfolio_masonry_row = "row portfolio-masonry";
			if($portfolio_style == '1' || $portfolio_style == '2'){
				if($portfolio_hover == '3' || $portfolio_hover == '6'){
					$proton_portfolio_masonry_row .= " active-gallery";
				}
			}
			if($portfolio_style == '3' || $portfolio_style == '4'){
				$proton_portfolio_masonry_row .= " meta-tags-holder";
			}
			if($portfolio_style == '2' || $portfolio_style == '4' || $portfolio_style == '6'){
				$proton_portfolio_masonry_row .= " no-space";
			}
			if($portfolio_hover_effect || $proton_portfolio_hover_effect == true){
				$proton_portfolio_masonry_row .= " hover-effect";
			}
			if($proton_text_position_holder){
				$proton_portfolio_masonry_row .= " $proton_text_position_holder";
			}
			if($portfolio_hover == '4' || $portfolio_hover == '5' || $portfolio_hover == '6'){
				$proton_portfolio_masonry_row .= " border-hover";
			}
		?>
		
		<!-- portfolio road start-->
		<div class="<?php echo esc_attr($proton_portfolio_masonry_row); ?>">
			<?php
				// Portfolio Category
				$proton_portfolio_category = get_field("proton_portfolio_category");

				// Portfolio Post Per Page
				$proton_portfolio_posts_per_page = get_field("proton_portfolio_posts_per_page");

				if($proton_portfolio_posts_per_page){
					$proton_portfolio_ppp = $proton_portfolio_posts_per_page;
				}
				else {
					$proton_portfolio_ppp = 9;
				}

				// Paged
				if(get_query_var('paged')){
					$paged = get_query_var('paged');
				}
				elseif(get_query_var('page')){
					$paged = get_query_var('page');
				}
				else {
					$paged = 1;
				}

				$args = array(
					"post_type" => "post",
					"posts_per_page" => $proton_portfolio_ppp,
		         	'paged' => $paged,
					'cat' => $proton_portfolio_category
				);

	    		$query = new WP_Query($args);

				if($query->have_posts()) : while($query->have_posts()) : $query->the_post();

            	$proton_post_tags = get_the_tags();

				$proton_portfolio_layout_col = $proton_portfolio_layout_item;

				if($proton_post_tags){
					foreach($proton_post_tags as $tag) {
						$proton_portfolio_layout_col .= " $tag->slug";
					}
				}
			?>
			<div class="<?php echo esc_attr($proton_portfolio_layout_col); ?>">
				<div class="item-holder">
				
		<!-- portfolio renwal start -------------------------------------------------------------------------->		
					
					<!-- yeonok: 이벤트 아이템 재정의 '.event-item' -->
					<div class="event-item">
					
						<!-- post logic -->
						<?php
							$proton_post_type = get_field("proton_post_type");
							$proton_post_url = get_permalink();
							if($proton_post_type == '3'){
								$proton_post_url = excerpt(50);
							}
							else {
								if($portfolio_style == '1' || $portfolio_style == '2'){
									if($portfolio_hover == '3' || $portfolio_hover == '6'){
										$proton_post_url = get_the_post_thumbnail_url();
									}
								}
							}
						?>
						
						<!-- information bar logic -->
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
							
							$event_ck_tx = "이벤트 종료";
							$event_type_tx = "배송";
							$event_prize_class = "row2";
							
							if($row = get_row($post_id)) {
		
								//변수설정
								$post_id         = $row->post_id;
								$event_end       = $row->event_end;
								$event_prize     = $row->event_prize;
								$event_all_prize = $row->event_all_prize;
								$event_enter     = $row->event_enter;
								$event_type      = $row->event_type;
		
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
							
							//이벤트 진행/이벤트 종료 텍스트 설정
							if($event_ck == true){
								$event_ck_tx ="진행";
							}else{
								$event_ck_tx ="이벤트 종료";
							}
							
							//이벤트타입 텍스트 설정
							if($event_type == 1){
								$event_type_tx ="매장";
							}else{
								$event_type_tx ="배송";
							}
							
							//경품 자릿수체크 클래스변경
							if( strlen($event_prize) > 3 || strlen($event_all_prize) > 3 ){
								
								$event_prize_class = "row2 break-line";
								
								//3자리마다 콤마
								$event_prize     = number_format($event_prize);
								$event_all_prize = number_format($event_all_prize);
							}
							
							//현재 유저 정보를 가져옴
							global $current_user;
							wp_get_current_user();

							//+유저 응모정보 가져옴
							$user_id = $current_user->ID;

							//+응모가능
							$result_enter = true;
							$user_result_row = get_user_result($post_id, $user_id);
							
							//+응모 불가능
							if($user_result_row){
								$result_enter = false;
							}
						?>
						
						<!-- timer setting-->
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
						
						<!-- information bar view start -->
						<a href="<?php echo esc_attr($proton_post_url); ?>" class="inner">
							
							<!-- info part -->
							<div class="info">
								<!-- 타이머 설정 위한 event_end -->
								<input type="hidden" id="event_end" name="event_end" value="<?php echo $event_end;?>"/>
								
								<!-- information bar 1 -->
								<ul class="row1">
									<li class="flags">
										<?php if($event_ck==true){?>
										<div class="event-flag-group flex">
											<p class="event-flag shipping col-6"><?php echo $event_type_tx ?></p>
											<p class="event-flag ing col-6"><?php echo $event_ck_tx ?></p>
										</div><!-- /.event-flag-group -->
										<?php } else { ?>
											<li class="closed"><?php echo $event_ck_tx ?></li>
										<?php } ?>
									</li>
									<li class="time"><text id="event_countdown_<?php echo $i ?>"/></li>
								</ul>
								
								<!-- information bar 2 -->
								<ul class="<?php echo $event_prize_class ?>">
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
								if(has_post_thumbnail()){
									the_post_thumbnail();
								}
								else {
									$proton_count = count(get_the_category());
									if($proton_count >= 10){
										echo '<img class="attachment-post-thumbnail size-post-thumbnail wp-post-image" src="' . get_template_directory_uri() . '/assets/images/default-tall.png" />';
									}
									else {
										echo '<img class="attachment-post-thumbnail size-post-thumbnail wp-post-image" src="' . get_template_directory_uri() . '/assets/images/default.png" />';
									}
								}
								
								//+ 응모확인 딱지 추가
								//<!-- yeonok: add status flag 20170824 -->
								if( $row->event_id != '' && $event_ck == true){ //+이벤트등록 안되있거나 or 종료된이벤트 아닐때
									if( $result_enter == true){ //응모가능
										echo 
											'<span class="text-flag">
												<i class="icon facebook xs"></i>
												<span class="tit">응모가능</span>
											</span>';
									}else if( $result_enter == false){ //응모불가능
										echo 
											'<span class="text-flag disabled">
												<i class="icon facebook xs"></i>
												<span class="tit">응모완료</span>
											</span>';
									}
								}
								
								//스크립트 변수설정을 위한 변수++
								$i++;
							?>
							</div><!-- /.thumbnail -->
							
							<!-- title part -->
							<div class="title">
								<p class="cat">
									<?php
										$proton_portfolio_categories_link = $options['proton_portfolio_categories_link'];
										if($proton_portfolio_categories_link){
											foreach((get_the_category()) as $category) { echo $category->cat_name . ' '; }
										}
										else {
											the_category(' ');
										}
									?>
								</p>
								<p class="tit"><?php the_title()?></p>
							</div><!-- /.title -->
							
						</a><!-- /.inner -->
						<!-- information bar view end -->
						
		<!-- portfolio renwal end -------------------------------------------------------------------------->					
					
					</div><!-- /.event-item -->
					
				</div><!-- /.item-holder -->
			</div><!-- /.col-md-3 col-sm-6 col-xs-12 selector -->
			<?php endwhile; endif; wp_reset_postdata(); ?>
		</div>
		<!-- portfolio road end-->
		
		<?php
			$proton_portfolio_button = get_field("proton_portfolio_button");
			$proton_portfolio_button_link = get_field("proton_portfolio_button_link");
		?>
		
		<?php if($proton_portfolio_button || $proton_portfolio_button_link) : ?>
			<div class="row">
				<div class="show-more-holder">
					<a class="button-show-more" href="<?php echo esc_attr($proton_portfolio_button_link); ?>">
						<?php
							if($proton_portfolio_button){
								echo $proton_portfolio_button;
							}
							else {
								echo esc_attr__("Show More", "proton");
							}
						?>
					</a>
				</div>
			</div>
		<?php endif; ?>
		
		<div class="row">
			<div class="col-md-12">
				<?php proton_pagination($query->max_num_pages, "page-pagination", 999); ?>
			</div>
		</div>
	</div>
	
	<?php endwhile; endif; ?>
	
	<?php if($options['portfolio_masonry']) : ?>
	
		<?php if($options['portfolio_masonry'] != true) : ?>
			<script type="text/javascript">
				jQuery(window).load(function($){
					jQuery('.portfolio-masonry').isotope({
						layoutMode: 'fitRows',
					});
				});
			</script>
		<?php endif; ?>
		
	<?php else : ?>
	
		<?php if($proton_portfolio_masonry != true) : ?>
			<script type="text/javascript">
				jQuery(window).load(function($){
					jQuery('.portfolio-masonry').isotope({
						layoutMode: 'fitRows',
					});
				});
			</script>
		<?php endif; ?>
	<?php endif; ?>
	
<?php get_footer(); ?>


<?php
/* function : event info load */
function get_row($post_id){
	global $wpdb;
	
	$row = null;
	$post_id = absint($post_id);
	if( $post_id > 0 ){
		$sql = $wpdb->prepare("SELECT * FROM wp_event_info WHERE post_id=%d", $post_id);
		$row = $wpdb->get_row( $sql );
	}
	return $row;
}

/* +function : user result load */
function get_user_result($post_id, $user_id){
	global $wpdb;
	
	$user_result_row = null;
	$post_id = absint($post_id);
	$user_id = absint($user_id);
	
	if( $post_id > 0 && $user_id > 0 ){
		$user_result_row =
			$wpdb->get_results("SELECT * FROM wp_event_enter, wp_event_info
								WHERE wp_event_enter.event_id = wp_event_info.event_id
								AND wp_event_info.post_id = $post_id
								AND wp_event_enter.user_id = $user_id");
	}
	return $user_result_row;
}
?>
