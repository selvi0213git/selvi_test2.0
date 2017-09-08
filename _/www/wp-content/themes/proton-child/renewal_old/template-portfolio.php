<?php
/**
* [init]
* [20170523] | 포트폴리오 템플릿 카테고리 숨기기                  | eley
* -----------------------------------------------------------
* [after]
* [20170525] | 파일 최초 수정                             | eley 
* [20170525] | 상세페이지내의 사이드바 안보이게 주석처리              | eley 
* [20170613] | 이벤트정보 숏코드 등록(참조: inc/eventinfo.php) 
*              포스트정보 보이지 않게 설정                      | eley 
* [20170713] | 이벤트 안내바 추가                           | eley
* [20170714] | 카테고리 숨기는 주석 삭제 	                      | eley
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
					<div class="item">
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
						<a class="full-overlay-link" href="<?php echo esc_attr($proton_post_url); ?>"></a>
						<?php if($portfolio_style == '1' || $portfolio_style == '2') :  ?>
							<div class="overlay-background"></div>
							<div class="overlay">
								<div class="inner-overlay">
									<?php if($portfolio_hover == '1' || $portfolio_hover == '2' || $portfolio_hover == '4' || $portfolio_hover == '5') : ?>
										<h3><a title="<?php the_title(); ?>" href="<?php echo esc_attr($proton_post_url) ?>"><?php the_title(); ?></a></h3>
									<?php endif; ?>
									<?php if($portfolio_hover == '2' || $portfolio_hover == '5') : ?>
										<span>
											<?php
												$proton_portfolio_categories_link = $options['proton_portfolio_categories_link'];
												if($proton_portfolio_categories_link){
													foreach((get_the_category()) as $category) { echo $category->cat_name . ' '; }
												}
												else {
													the_category(' ');
												}
											?>
										</span>
									<?php endif; ?>
									<?php if($portfolio_hover == '3' || $portfolio_hover == '6') : ?>
										<h3 class="gallery-plus">+</h3>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<!-- 안내바 추가 20170713-->
					<!-- 안내바 로직 -->
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
						
						$event_ck_tx = "마감";
						$event_type_tx = "배송";
						
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
							
						//test
						//echo "<script>alert('".$event_ck."');</script>";
						//echo $event_ck;
						?>
						
						<!-- 안내바 화면 1 -->
						<style type="text/css">
						.tg-infobar1  {border-collapse:collapse;border-spacing:0;}
						.tg-infobar1 td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
						.tg-infobar1 th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
						.tg-infobar1 .tg-infobar1-kn3m{font-weight:bold;font-size:14px;font-family:Arial, Helvetica, sans-serif !important;;background-color:#0ccfed;color:#ffffff;text-align:center}
						.tg-infobar1 .tg-infobar1-9ehz{font-weight:bold;font-size:14px;font-family:Arial, Helvetica, sans-serif !important;;background-color:#f2c601;color:#ffffff;text-align:center}
						.tg-infobar1 .tg-infobar1-9eht{font-weight:bold;font-size:14px;font-family:Arial, Helvetica, sans-serif !important;;background-color:darkgray;color:#ffffff;text-align:center}
						.tg-infobar1 .tg-infobar1-e4s0{font-weight:bold;font-size:14px;font-family:Arial, Helvetica, sans-serif !important;;background-color:#ff7522;color:#ffffff;text-align:right}
						</style>
						
						<table class="tg-infobar1" style="undefined;table-layout: fixed; width: 100%">
						<input type="hidden" id="event_end" name="event_end" value="<?php echo $event_end;?>"/>
						
						<colgroup>
						<col style="width: 46px">
						<col style="width: 46px">
						</colgroup>
						
						  <tr>
						  <?php if($event_ck==true){?>
							<th class="tg-infobar1-kn3m"><?php echo $event_type_tx ?></th>
							<th class="tg-infobar1-9ehz"><?php echo $event_ck_tx ?></th>
							<th class="tg-infobar1-e4s0"><text id="event_countdown_<?php echo $i ?>"/></th>
							<?php } else { ?>
							<th colspan="3" class="tg-infobar1-9eht">이벤트종료</th>
							<?php } ?>
						  </tr>
						</table>
						
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
						
						<!-- 안내바 화면 2 -->
						<style type="text/css">
						.tg-infobar2  {border-collapse:collapse;border-spacing:0;border:none;}
						.tg-infobar2 td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
						.tg-infobar2 th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
						.tg-infobar2 .tg-infobar2-s8nl{font-family:Arial, Helvetica, sans-serif !important;;background-color:#ffffff;color:#9b9b9b;text-align:center;vertical-align:top}
						.tg-infobar2 .tg-infobar2-jsx6{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;background-color:#ffffff;;color:#ff7522;text-align:right;vertical-align:top}
						.tg-infobar2 .tg-infobar2-dnyv{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;background-color:#ffffff;color:#656565;text-align:center}
						.tg-infobar2 .tg-infobar2-y6oy{font-weight:bold;font-family:Arial, Helvetica, sans-serif !important;;background-color:#ffffff;color:#656565;text-align:center;vertical-align:top}
						</style>
						
						<table class="tg-infobar2" style="undefined;table-layout: fixed; width: 100%">
						
						<colgroup>
						<col style="width: 45px">
						<col style="width: 100%">
						<col style="width: 22px">
						<col style="width: 15px">
						<col style="width: 45px">
						<col style="width: 80%">
						<col style="width: 22px">
						</colgroup>
						
						  <tr>
							<th class="tg-infobar2-dnyv">경품</th>
							<th class="tg-infobar2-jsx6"><?php echo $event_prize?>/<?php echo $event_all_prize?></th>
							<th class="tg-infobar2-y6oy">개</th>
							<th class="tg-infobar2-s8nl">|</th>
							<th class="tg-infobar2-y6oy">응모</th>
							<th class="tg-infobar2-jsx6"><?php echo $event_enter?></th>
							<th class="tg-infobar2-y6oy">명</th>
						  </tr>
						</table>

					<?php
						if(has_post_thumbnail()){
							the_post_thumbnail();
						}
						else {
							$proton_count = count(get_the_category());
							if($proton_count >= 10){
								echo '<img src="' . get_template_directory_uri() . '/assets/images/default-tall.png" />';
							}
							else {
								echo '<img src="' . get_template_directory_uri() . '/assets/images/default.png" />';
							}
						}
						
						//스크립트 변수설정을 위한 변수++
						$i++;
					?>
				</div>
				
				<?php if($portfolio_style == '3' || $portfolio_style == '4') :  ?>
					<div class="meta-tags-outside">
						<span>
							<!--포트폴리오 템플릿 카테고리 숨기기 20170523 eley - 주석삭제 20170714 -->
							<?php
							
								$proton_portfolio_categories_link = $options['proton_portfolio_categories_link'];
								if($proton_portfolio_categories_link){
									foreach((get_the_category()) as $category) { echo $category->cat_name . ' '; }
								}
								else {
									the_category(' ');
								}
							
							?>
						</span>
						<h3><a title="<?php the_title(); ?>" href="<?php echo esc_attr($proton_post_url) ?>"><?php the_title(); ?></a></h3>
					</div>
				<?php endif; ?>
			</div>
			<?php endwhile; endif; wp_reset_postdata(); ?>
		</div>
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
//이벤트정보 불러오는 함수
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
?>
