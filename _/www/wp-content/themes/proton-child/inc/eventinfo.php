<?php 
/**
* [init]     
* [20170607] | 이벤트 정보등록 CRUD php파일 생성           | eley 
* ------------------------------------------------------
* [after]
* [20170609] | 시작시간,종료시간 테이블컬럼추가에 따른 로직 변경     | eley
* [20170612] | 코드정리 및 CRUD 테스트 완료               | eley
* [20170623] | 코드정리 및 이벤트참여 기능CRUD추가            | eley
* [20170627] | 코드정리 및 facebook share관련 함수로 따로정의 | eley
* [20170629] | 배달정보 팝업->페이지이동                   | eley
* [20170707] | 경고창 confrim창으로 변경                 | eley
* [20170710] | 기존 비로그인 top으로이동 -> 로그인팝업         | eley
* [20170712] | 이벤트타입 DB추가로 인한 로직추가              | eley
* [20170714] | facebook응모시 페이스북 자동로그인           | eley
*
* [RENEWAL]----------------------------------------------------------
* [20170724] | RENEWAL                            | eley 
* [20170731] | POPUP RENEWAL                      | eley 
* [20170906] | 1개일때 확률로직 추가                      | eley 
*
* [20170911] | 응모채널 추가 대응                        | eley 
* [20170914] | 응모채널 추가에 따른 응모기능 추가              | eley 
* [20170915] | 채널별 응답확인                               | eley 
*/

class event_info {
	function __construct(){
		//편의를 위해 wordpress 테이블이름을 변수로 만들어줌
		global $wpdb;
		//이벤트정보 테이블 - 관리자
		$this->table = $wpdb->prefix . 'event_info';
		//이벤트 응모 테이블 - 회원
		$this->table2 = $wpdb->prefix . 'event_enter';
		
		//숏코드 등록
		add_shortcode( 'eventinfo', array($this, 'shortcode') );
		
		//액션등록 admin-post.php 참조
		add_action( 'admin_post_eventinfo-post', array($this, 'post_request') );
		add_action( 'admin_post_nopriv_eventinfo-post', array($this, 'post_request') );
		
		//ajax action
		add_action( 'wp_ajax_eventinfo-post', array($this, 'post_request') );
		add_action( 'wp_ajax_nopriv_eventinfo-post', array($this, 'post_request') );
		
	}

	//숏코드 실행
	function shortcode(){
		ob_start();
		?>
		<div id="eventinfo">
			<!-- 폼 실행 -->
			<?php $this->the_form();?>
		</div>
		<?php
		return ob_get_clean();
	}
	
	//관리자 , 사용자 폼 생성함수
	function the_form(){
		//유저정보
		//현재 유저 정보를 가져옴
		global $current_user;
		wp_get_current_user();
		
		$user_id = $current_user->ID;
		$user_roll = ($user_id != 0) ? $current_user->user_status : 0;
		$user_url_ck = ($user_id != 0) ? $current_user->user_url : '';
		//20170911 유저 접속 체크
		$user_by    = ($user_id != 0) ? $current_user->user_login : '';
		$user_nicename    = ($user_id != 0) ? $current_user->user_nicename : '';
		
		$user_connect_ck = '';
		//페이스북
		if(substr($user_by,0,8) == 'facebook' || substr($user_url_ck,11,8) == 'facebook') {
			$user_connect_ck = 'facebook';
		}
		//네이버
		if(substr($user_by,0,5) == 'naver' || substr($user_nicename,-9) == 'naver-com') {
			$user_connect_ck = 'naver';
		}
		//카카오
		if(substr($user_by,0,5) == 'kakao' || substr($user_nicename,0,5) == 'naver-com') {
			$user_connect_ck = 'kakao';
		}
		//카카오메일
		if(substr($user_by,-12) == '@hanmail.net' || substr($user_nicename,-11) == 'hanmail-net') {
			$user_connect_ck = 'kakao';
		}

		//변수에 저장
		$event_id 		 = isset($_GET['eventinfo-event_id']) ? $_GET['eventinfo-event_id'] : '';
		$post_id         = isset($_GET['eventinfo-post_id']) ? $_GET['eventinfo-post_id'] : get_the_ID();
		
		$event_all_prize = '';
		$event_prize     = '';
		
		//$event_time      = '';  20170609
		$event_start     = '';
		$event_end       = '';
		
		$event_sdate     = '';
		$event_edate     = '';
		$event_stime     = '';
		$event_etime     = '';
		
		$event_enter     = '';
		$status          = 0;
		$enter_id        = '';
		
		//20170712
		$event_type      = 0;
		
		//버튼설정
		$submit_label = '등록';
		
		//업데이트체크-request
		$update = false;
		//응모체크-request 및 중복체크
		$enter  = false;
		
		//텍스트설정
		$event_ck_tx   = "이벤트 종료";
		$event_type_tx = "배송";
		$event_type_class = "event-flag shipping";
		
		//응모가능 설정
		$event_ck = false;
		
		//20170915 모바일/PC체크
		$mobile_ck = '';
		
		//테이블에 저장된 post id값 있을때
		if($row = $this->get_row($post_id)) {
			//관리자 버튼설정
			$update = true;
			$submit_label = '수정';
			
			$event_id 		 = $row->event_id;
			$post_id         = $row->post_id;
			
			$event_all_prize = $row->event_all_prize;
			$event_prize     = $row->event_prize;
			
			//콤마구분 초기화
			$event_prize_comma     = $event_prize;
			$event_all_prize_comma = $event_all_prize;

			$event_start     = $row->event_start;
			$event_end       = $row->event_end;
			
			$event_sdate     = substr($event_start, 0, 10);
			$event_edate     = substr($event_end, 0, 10);
			$event_stime     = substr($event_start, 11, 18);
			$event_etime     = substr($event_end, 11, 18);
			
			$event_enter     = $row->event_enter;
			
			//20170712
			$event_type     = $row->event_type;
		
			//사용자 설정
			
			//Server Event Timecheck
			//기준시간 한국으로 설정
			date_default_timezone_set('Asia/Seoul');
			
			$curnt_t     = date("Y-m-d H:i:s");
			$event_end_t = date("Y-m-d H:i:s", strtotime($event_end));

			//남은경품이 0이거나 남은시간이 없을때 응모버튼비활성화
			if( (strtotime($event_end_t) <= strtotime($curnt_t)) || $event_prize == "0" || $event_prize == ""){
				$event_ck = true;
			}
			
			//경품 자릿수체크 클래스변경
			if( strlen($event_prize) > 3 || strlen($event_all_prize) > 3 ){
				//3자리마다 콤마
				$event_prize_comma     = number_format($event_prize);
				$event_all_prize_comma = number_format($event_all_prize);
			}
		}
		
		if($enter_row = $this->get_enter_row($user_id, $event_id)) {
			//응모내역 있음
			if(isset($enter_row)){		
				$enter = true;
				$enter_id = $enter_row->enter_id;
			}
		}
		
		//이벤트타입 텍스트 설정
		if($event_type == 1){
			$event_type_tx ="매장";
			$event_type_class = "event-flag shop";
		}else{
			$event_type_tx ="배송";
			$event_type_class = "event-flag shipping";
		}
		
		//20170915 모바일/PC체크
		/* 모바일 장치용 코드 */
		if ( wp_is_mobile() ) {
			$mobile_ck = 'mobile';
		}else{
			$mobile_ck = 'pc';
		}
		
		?>
	    
		<!--폼 구성-->
		<form id="eventinfo-form" action="<?=admin_url('admin-post.php')?>" method="post">
			<?php wp_nonce_field('eventinfo', 'eventinfo_nonce'); ?>
			<input type="hidden" id="action" name="action" value="eventinfo-post">
			<input type="hidden" id="event_id" name="event_id" value="<?php echo $event_id;?>" />
			<input type="hidden" id="post_id" name="post_id" value="<?php echo $post_id;?>" />
			<input type="hidden" id="event_start" name="event_start" value="<?php echo $event_start;?>" />
			<input type="hidden" id="event_end" name="event_end" value="<?php echo $event_end;?>" />
			
			<!-- 로그인한회원 + 관리자일때 -->
			<?php if($user_id != 0 && $user_roll == 1) {?>
			
			<!-- 관리자폼실행 -->
			<section class="event-detail-header">
			<?php if( $event_ck  || $event_id == ""){ ?>
				<!-- 이벤트 종료 -->
			<?php }else { ?>
			<div class="event-flag-group">
				<p class="<?php echo $event_type_class ?>"><?php echo $event_type_tx?></p>
				<p class="event-flag ing">진행</p>
			</div><!-- /.event-flag-group -->
			<?php } ?>
			<div class="title">
				<p class="cat">
					<?php foreach((get_the_category()) as $category){
							echo $category->name . ' ' ;
					} ?>
				</p>
				<p class="tit"><?php echo get_the_title($post_id) ?></p>
			</div>
			</section>
			
			<table width="100%" cellspacing="0%">
			<!--20170712-->
			<tr>
				<td colspan="5">
					<p style="text-align:center;"><font size="3"><b>이벤트 타입 선택</b></font></p>
				</td>
			</tr>
			<tr>
				<td colspan="5">
					<select id="event_type" name="event_type" style="width: 100%;" align="center">
						<option value=0 <?php if($event_type == 0):?>selected<?php endif?>>배송</option>
						<option value=1 <?php if($event_type == 1):?>selected<?php endif?>>매장</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td>
					<p style="text-align:center;"><font size="3"><b>남은경품</b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b>전체경품</b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b>시작일시</b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b>종료일시</b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b>응모인원</b></font></p>
				</td>
			</tr>
			<tr>
				<td>
					<p style="text-align:center;"><font size="3"><b><input type="text" id="event_prize" name="event_prize" class="numbersOnly" value="<?php echo $event_prize;?>" style="width:100%; text-align:center; height:52px;" placeholder="0"/></b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b><input type="text" id="event_all_prize" name="event_all_prize" class="numbersOnly" value="<?php echo $event_all_prize;?>" style="width:100%; text-align:center; height:52px" placeholder="0"/></b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b><input type="text" id="event_sdate" value="<?php echo $event_sdate;?>" style="width:100%; text-align:center;" placeholder="0000-00-00" readonly />
					<input type="time" id="event_stime" value="<?php echo $event_stime;?>" style="width:100%; text-align:center;" placeholder="00:00:00"/>
					</b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b><input type="text" id="event_edate" value="<?php echo $event_edate;?>" style="width:100%; text-align:center;" placeholder="0000-00-00" readonly>
					<input type="time" id="event_etime" value="<?php echo $event_etime;?>" style="width:100%; text-align:center;" placeholder="00:00:00"/>
					</b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b><input type="text" id="event_enter" name="event_enter" class="numbersOnly" value="<?php echo $event_enter;?>" style="width:100%; text-align:center; height:52px" placeholder="0"/></b></font></p>
				</td>
			</tr>
			<tr>
				<td colspan="5">
					<p style="text-align:center;"><b><input type="button" id="submit_button" value="<?=$submit_label?>" style="width:100%; text-align:center;" /></b></p>
					<?php if( $update ){ ?>
					<b><input type="reset" value="취소" style="width:100%; text-align:center;" /></b>
					<?php } ?>
				</td>
			</tr>
		</table>
			
		<?php }else {?>
		
		<!-- 커스텀폼실행 -->
		
		<input type="hidden" id="event_prize" name="event_prize" class="numbersOnly" value="<?php echo $event_prize;?>"/>
		<input type="hidden" id="event_enter" name="event_enter" class="numbersOnly" value="<?php echo $event_enter;?>" />
		<input type="hidden" id="event_all_prize" name="event_all_prize" class="numbersOnly" value="<?php echo $event_all_prize;?>"/>
		<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id;?>"/>
		<input type="hidden" id="status" name="status" value="<?php echo $status;?>"/>
	
	<!-- detail renewal start -------------------------------------------------------------------------->
	
		<!-- event info part -->
		<section class="event-detail-header">
			<?php if( $event_ck  || $event_id == ""){ ?>
				<!-- 이벤트 종료 -->
			<?php }else { ?>
			<div class="event-flag-group">
				<p class="<?php echo $event_type_class ?>"><?php echo $event_type_tx?></p>
				<p class="event-flag ing">진행</p>
			</div><!-- /.event-flag-group -->
			<?php } ?>
			<div class="title">
				<p class="cat">
					<?php foreach((get_the_category()) as $category){
							echo $category->name . ' ' ;
					} ?>
				</p>
				<p class="tit"><?php echo get_the_title($post_id) ?></p>
			</div>
			
			<?php if($event_id != "") {?>
					
			<ul class="info-list">
				<dl class="gift-remain">
					<dt>남은경품</dt>
					<dd><span class="value"><?php echo $event_prize_comma;?></span></dd>
				</dl>
				<dl class="gift-total">
					<dt>전체경품</dt>
					<dd><span class="value"><?php echo $event_all_prize_comma;?></span></dd>
				</dl>
				<dl class="apply">
					<dt>응모인원</dt>
					<dd><span class="value"><?php echo $event_enter;?></span></dd>
				</dl>
				<dl class="time">
					<dt>남은시간</dt>
					<dd><span class="value"><text id="event_countdown"></text></span></dd>
				</dl>
			</ul><!-- /.info-list -->
		</section><!-- /.event-detail-header -->
		
		<!-- facebook enter part -->
		<section class="event-apply">
			<?php if( $event_ck ){ ?>
				<input type="button" id="enter_button" value="이벤트종료" class="btn-apply-facebook" disabled />
			<?php }else { ?>
					<!-- 20170911 로직변경 -->
					<input type="button" id="enter_button_fb" <?php if( $enter && $user_connect_ck == 'facebook') { ?> value="FaceBook 응모완료" <?php } else { ?> value="FaceBook 응모하기" <?php } ?> class="btn-apply-facebook" <?php if( $enter && $user_connect_ck == 'facebook') { ?> disabled <?php }?>/>
					
					<!-- 20170915 채널추가 -->
					<input type="button" id="enter_button_ks" <?php if( $enter && $user_connect_ck == 'kakao') { ?> value="카카오스토리 응모완료" <?php } else { ?> value="카카오스토리 응모하기" <?php } ?> class="btn-selvi yellow" <?php if( $enter && $user_connect_ck == 'kakao') { ?> disabled <?php }?>/>

					<!-- 20170915 band, kakao 보류 
					<input type="button" id="enter_button_na" <?php //if( $enter && $user_connect_ck == 'naver') { ?> value="네이버 응모완료" <?php  //} else { ?> value="네이버 응모하기" <?php //} ?> class="btn-selvi green" <?php //if( $enter && $user_connect_ck == 'naver') { ?> disabled <?php //}?>/>
					<input type="button" id="enter_button_ka" <?php //if( $enter && $user_connect_ck == 'kakao') { ?> value="Kakao 응모완료" <?php //} else { ?> value="Kakao 응모하기" <?php //} ?> class="btn-selvi yellow" <?php //if( $enter && $user_connect_ck == 'kakao') { ?> disabled <?php //}?>/>
					<input type="button" id="enter_button_nb" <?php// if( $enter && $user_connect_ck == 'naver') { ?> value="BAND 응모완료" <?php //} else { ?> value="BAND 응모하기"<?php //} ?> class="btn-selvi green" <?php //if( $enter && $user_connect_ck == 'naver') { ?> disabled <?php //}?>/>\
					-->
			<?php }?>
		</section>			
		
		<!-- detail renewal end -------------------------------------------------------------------------->
							
		<?php } ?><!--end if 커스텀 ck -->
		
		<?php } ?><!--end else 커스텀 -->
		</form>
		
		<script>
		//관리자시작
		
			//로딩시 함수
			jQuery(document).ready(function () {
				$.getScript('//connect.facebook.net/ko_KR/sdk.js', function(){
				FB.init({
					appId: '229048730920671',
					autoLogAppEvents : true,
					status           : true,
					xfbml            : true,
					version          : 'v2.10'
					});
				})
			});
	
			//숫자체크 숫자가 아닐경우 자동으로 backspace
			jQuery('.numbersOnly').keyup(function () { 
				this.value = this.value.replace(/[^0-9\.]/g,'');
			});
			
			//날짜입력 jQuery
			jQuery(function() {
				$( "#event_sdate, #event_edate" ).datepicker({
				changeMonth: true ,
				changeYear: true ,
				showMonthAfterYear: true ,
				dateFormat: "yy-mm-dd",
				dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],
				monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월" ],
				monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월" ],
				});
				
				//시작일시 종료일시 체크로직
				//$('#event_sdate').datepicker("option", "minDate", 0); 최소오늘
				$('#event_sdate').datepicker("option", "maxDate", $("#event_edate").val());
				$('#event_sdate').datepicker("option", "onClose", function ( selectedDate ) {
					$("#event_edate").datepicker( "option", "minDate", selectedDate );
				});
		
				$('#event_edate').datepicker("option", "minDate", $("#event_sdate").val());
				$('#event_edate').datepicker("option", "onClose", function ( selectedDate ) {
					$("#event_sdate").datepicker( "option", "maxDate", selectedDate );
				});
			
			});
			
			//등록버튼 클릭시
			jQuery("#submit_button").click(function () {
				//validation
				var event_all_prize = document.getElementById("event_all_prize").value;
				var event_prize     = document.getElementById("event_prize").value;
				var event_sdate     = document.getElementById("event_sdate").value;
				var event_stime     = document.getElementById("event_stime").value;
				var event_edate     = document.getElementById("event_edate").value;
				var event_etime     = document.getElementById("event_etime").value;
				var event_enter     = document.getElementById("event_enter").value;
				
				if(event_all_prize==''){
					alert("전체경품을 입력하세요");
					return;
				}
				if(event_prize==''){
					alert("남은경품을 입력하세요");
					return;
				}
				if(parseInt(event_all_prize)<parseInt(event_prize)){
					alert("남은경품이 전체경품보다 많을수 없습니다.");
					return;
				}
				if(event_sdate==''){
					alert("시작날짜를 입력하세요");
					return;
				}
				if(event_stime==''){
					alert("시작시간을 입력하세요");
					return;
				}
				if(event_edate==''){
					alert("종료일짜를 입력하세요");
					return;
				}
				if(event_etime==''){
					alert("종료시간을 입력하세요");
					return;
				}
				if(event_enter==''){
					alert("응모인원을 입력하세요");
					return;
				}
				
				//날짜 hidden값에 저장
				event_start = event_sdate +" "+ event_stime;
				event_end   = event_edate +" "+ event_etime;
				
				document.getElementById("event_start").value = event_start;
				document.getElementById("event_end").value   = event_end;
				
				$('#eventinfo-form').submit();

			});
		
		//사용자시작
			
			//time설정
			var event_end = document.getElementById("event_end").value;
			
			var user_id = <?php echo $user_id ?>;
			var user_roll = <?php echo $user_roll ?>;
			
			//일반 사용자일때
			if(user_roll != 1) {
				//종료시간 셋팅안되있을때 validation
				if(event_end == "0000-00-00 00:00:00" || event_end == "") {
					//document.getElementById('event_countdown').innerHTML = '대기중';
				}else {
					CountDownTimer(event_end,'event_countdown');
				}
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
						document.getElementById(id).innerHTML = '종료';
						//<p style="text-align:center;"><b><input type="button" id="enter_button" value="응모종료" style="width:100%; text-align:center; background-color:darkgray;" disabled /></b></p>
						
						//20170911 로직변경
						document.getElementById("enter_button_fb").disabled = true;
						document.getElementById("enter_button_fb").style = "width:100%; text-align:center; background-color:darkgray;";
						
						/* 20170915 채널추가 */
						document.getElementById("enter_button_ks").disabled = true;
						document.getElementById("enter_button_ks").style = "width:100%; text-align:center; background-color:darkgray;";
						
						/* 20170915 보류
						document.getElementById("enter_button_na").disabled = true;
						document.getElementById("enter_button_na").style = "width:100%; text-align:center; background-color:darkgray;";
						document.getElementById("enter_button_nb").disabled = true;
						document.getElementById("enter_button_nb").style = "width:100%; text-align:center; background-color:darkgray;";
						document.getElementById("enter_button_ka").disabled = true;
						document.getElementById("enter_button_ka").style = "width:100%; text-align:center; background-color:darkgray;";
						*/
						
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
			
			//20170911 로직변경
			//당첨로직
			function set_probability() {
				//확률계산을 위한 변수
				var event_prize = "<?php echo $event_prize;?>";
				var event_end   = "<?php echo $event_end;?>";
				var event_enter = "<?php echo $event_enter;?>";
				var status = "<?php echo $status; ?>";
					
				//응모인원+1 //status
				event_enter = parseInt(event_enter)+1;
				document.getElementById("event_enter").value = event_enter;
				document.getElementById("status").value = status;
				
				//당첨자 선정 랜덤함수
				//확률 = 경품 % 시간 * 100
				event_end = event_end.replace(/-/g, '/');//IE에서는 지원안함 NAN표시 -> .replace("-","/")
				var end = new Date(event_end);
				var _second = 1000;
				var _minute = _second * 60;
				var _hour   = _minute * 60;
				var _day    = _hour * 24;
				
				function showRemaining() {
					var now = new Date();
					var distance = end - now;
					
					if (distance > 0) {
						clearInterval(timer);
						var days = distance / _day;
						var min = days*24*60;
					}
					return min;
				}
				timer = setInterval(showRemaining, 1000);
				
				//남은시간 분으로 환산한 값
				var remain_min = showRemaining();
				
				//20170906 1개이하 확률로직 추가
				if(event_prize == 1){
					//남은일수 확률 재측정 범위설정
					if(remain_min < 4320) {
						//범위설정 랜덤
						if(Math.random()<((event_prize/remain_min)*100)){
							//당첨시
							//남은경품 -1 //event_prize-1; //status = 1
							document.getElementById("event_prize").value = event_prize;

							event_prize = parseInt(event_prize)-1;
							document.getElementById("event_prize").value = event_prize;
							
							status = 1;
							document.getElementById("status").value = status;
							
							// POPUP RENEWAL -------------------------------------------------------------------------------------->
							
							/* SUBMIT */
							jQuery("#eventinfo-form").submit();
							
							/* ENTER TRUE */
							openApplyRoulette(2);
							
						}else {
							//미당첨시
							//status = 0
							status = 0;
							document.getElementById("status").value = status;
							
							// POPUP RENEWAL -------------------------------------------------------------------------------------->
							
							/* SUBMIT */
							jQuery("#eventinfo-form").submit();
							
							/* ENTER FALSE*/
							openApplyRoulette(1);
						}
						
					//범위 X
					}else {
						//미당첨시
						//status = 0
						status = 0;
						document.getElementById("status").value = status;
						
						// POPUP RENEWAL -------------------------------------------------------------------------------------->
						
						/* SUBMIT */
						jQuery("#eventinfo-form").submit();
						
						/* ENTER FALSE*/
						openApplyRoulette(1);
					}
				
				//일반
				}else {
					if(Math.random()<((event_prize/remain_min)*100)){
						//당첨시
						//남은 경품 -1 //event_prize-1; //status = 1
						document.getElementById("event_prize").value = event_prize;

						event_prize = parseInt(event_prize)-1;
						document.getElementById("event_prize").value = event_prize;
						
						status = 1;
						document.getElementById("status").value = status;
						
						// POPUP RENEWAL -------------------------------------------------------------------------------------->
						
						/* SUBMIT */
						jQuery("#eventinfo-form").submit();
						
						/* ENTER TRUE */
						openApplyRoulette(2);
						
					}else{
						//미당첨시
						//status = 0
						status = 0;
						document.getElementById("status").value = status;
						
						// POPUP RENEWAL -------------------------------------------------------------------------------------->
						
						/* SUBMIT */
						jQuery("#eventinfo-form").submit();
						
						/* ENTER FALSE*/
						openApplyRoulette(1);
					}
				}
			}
			
			//페이스북 공유로직
			function fb_share_pop(){
				//공유에 필요한 변수 세팅
				<?php
				$title = get_the_title();
				$title = strip_tags($title);
				$title = str_replace("\"", " ", $title);
				$title = str_replace("&#039;", "", $title);	
				
				$siteTitle = get_bloginfo('name');
				$siteTitle = strip_tags($siteTitle);
				$siteTitle = str_replace("\"", " ", $siteTitle);
				$siteTitle = str_replace("&#039;", "", $siteTitle);
				
				$link = get_permalink();
				?>
		
				//event.preventDefault();
				//$.ajaxSetup({ cache: true });
				//$.getScript('//connect.facebook.net/ko_KR/sdk.js', function(){
				//FB.init({
				//	appId: '229048730920671',
				//	autoLogAppEvents : true,
				//	status           : true,
				//	xfbml            : true,
				//	version          : 'v2.9'
				//});
				FB.ui({
					method: 'share',
					mobile_iframe: true,
					title: '<?php echo $title?> - <?php echo $siteTitle?>',
					description: 'SELVITEST-매일매일 행운을 더하다!',
					href: '<?php echo $link?>',
					display: 'popup',
				  },
				  function(response) {
					//응답시 공유체크
					if (response && !response.error_code) {
						//20170911 로직변경
						//확률세팅 및 룰렛게임시작
						set_probability();
					//공유하지 않았을때
					} else {
						alert('이벤트 응모가 취소되었습니다.\n응모가 제대로 되지않을 경우 다른 브라우저로 접속해주세요.');
					}
				});
			  //});
			}
			
			//20170911 네이버 공유로직
			/* 20170918 보류
			function na_share_pop(){
				//팝업가운데 세팅
				var screenW = screen.availWidth;  // 스크린 가로사이즈
				var screenH = screen.availHeight; // 스크린 세로사이즈
				var popW = 400; // 띄울창의 가로사이즈
				var popH = 500; // 띄울창의 세로사이즈
				var posL=( screenW-popW ) / 2;   // 띄울창의 가로 포지션 
				var posT=( screenH-popH ) / 2;   // 띄울창의 세로 포지션 
				
				//20170915 모바일/PC체크
				//var mobile_ck = '<?php echo $mobile_ck?>';
				
				var share_na_pop = window.open('http://share.naver.com/web/shareView.nhn?url=<?php echo $link?>&title=<?php echo $title?>-<?php echo $siteTitle?>', '네이버로 공유하기', 'width='+ popW +',height='+ popH +',top='+ posT +',left='+ posL +',resizable=no,scrollbars=no');
				
				//팝업트릭
				var popupTick = setInterval(function() {
					if(share_na_pop.closed) {
						clearInterval(popupTick);
						
						//룰렛게임시작 20170914
						set_probability();
					}
				}, 500);

				return false;
			}
			*/
			
			//20170911 카카오 공유로직
			/* 20170915 보류
			function ka_share_pop(){
				
				//공유 이미지 설정
				<?php 
				$thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id($post_id),'full');
				?>
				
				Kakao.init('06371afb514d3fdd8362d5134491d19b');
				
				Kakao.Link.sendTalkLink({
					//container: '#kakao-link-btn',
					label: '행운을 탐하다!\nwww.selvi.co.kr',
					image: {
					src: '<?php echo $thumbnail_url?>',
					width: '300',
					height: '300'
					},
					webButton: {
					text: '<?php echo $title?>',
					url: '<?php echo $link?>'
					}
				});
				
				//룰렛게임시작 20170914
				set_probability();
			}
			*/
			
			//20170915 채널추가
			//카카오 스토리 공유로직
			function ks_share_pop(){
				
				//팝업가운데 세팅
				var screenW = screen.availWidth;  // 스크린 가로사이즈
				var screenH = screen.availHeight; // 스크린 세로사이즈
				var popW = 400; // 띄울창의 가로사이즈
				var popH = 500; // 띄울창의 세로사이즈
				var posL=( screenW-popW ) / 2;   // 띄울창의 가로 포지션 
				var posT=( screenH-popH ) / 2;   // 띄울창의 세로 포지션 
				
				var share_ks_pop = window.open('https://story.kakao.com/share?url=<?php echo $link?>', '카카오스토리 공유하기', 'width='+ popW +',height='+ popH +',top='+ posT +',left='+ posL +',resizable=no,scrollbars=no');

				//팝업트릭
				var popupTick = setInterval(function() {
					if(share_ks_pop.closed) {
						clearInterval(popupTick);
						
						//룰렛게임시작 20170914
						set_probability();
					}
				}, 500);

				return false;
			}
			
			//네이버 밴드 공유로직
			/* 20170915 보류
			function nb_share_pop(){
				
				//팝업가운데 세팅
				var screenW = screen.availWidth;  // 스크린 가로사이즈
				var screenH = screen.availHeight; // 스크린 세로사이즈
				var popW = 400; // 띄울창의 가로사이즈
				var popH = 500; // 띄울창의 세로사이즈
				var posL=( screenW-popW ) / 2;   // 띄울창의 가로 포지션 
				var posT=( screenH-popH ) / 2;   // 띄울창의 세로 포지션 
				
				var share_nb_pop = window.open('http://www.band.us/plugin/share?body=<?php echo $title?>&route=<?php echo $link?>', '밴드 공유하기', 'width='+ popW +',height='+ popH +',top='+ posT +',left='+ posL +',resizable=no,scrollbars=no');

				//팝업트릭
				var popupTick = setInterval(function() {
					if(share_nb_pop.closed) {
						clearInterval(popupTick);
						
						//룰렛게임시작 20170914
						set_probability();
					}
				}, 500);

				return false;
			}
			*/
			
			//20170911 로직변경
			//facebook 응모버튼 클릭시
			jQuery("#enter_button_fb").click(function (e) {
				//Broswer Check
				var agent = navigator.userAgent.toLowerCase();

				//Samsung Browser
				/* 20170824 지원됨
				if (agent.indexOf("samsungbrowser") != -1) {
					alert("지원되지 않는 브라우저 입니다. \n크롬에서 접속해주세요.");
					return;
				}
				*/
				
				var user_id  = <?php echo $user_id?>;
				  
					if(!user_id){
						/*
						//유저가 아닐때 로그인으로 이동
						//if(confirm("로그인이 필요한 서비스입니다.\n로그인하시겠습니까?")){
							//location.href = "http://selvitest.cafe24.com/selvi_login/";
							
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
							
							//로그인팝업호출 20170710
							//PUM.open(1241);
						//}
						*/
						
						//페이스북 자동로그인 20170714
						location.href = 'http://selvitest.cafe24.com/?action=cosmosfarm_members_social_login&channel=facebook&redirect_to=<?php echo get_permalink()?>';
						
						/*로그인 페이지로 이동 20170914 CLOSE*/
						//location.href = "http://selvitest.cafe24.com/login/";

					//유저일때
					} else {
						var event_id = document.getElementById("event_id").value;//<?php echo $event_id?>;
						//이벤트 아이디가 존재할때
						if(event_id !=""){
							
							//20170911 로직변경
							//로그인 유저 확인
							var user_connect_ck = "<?php echo $user_connect_ck ?>";
								
							//페이스북유저일때
							if(user_connect_ck=="facebook"){
								
								/* NOTICE MESSAGE POPUP*/
								e.stopPropagation();
								openApplyConfirm('facebook');
								
							//페이스북 유저 아닐때
							}else if(user_connect_ck!="facebook"){
								//alert("페이스북으로 로그인해 주세요.");
								//페이스북 자동로그인 20170714
								location.href = 'http://selvitest.cafe24.com/?action=cosmosfarm_members_social_login&channel=facebook&redirect_to=<?php echo get_permalink()?>';
							}
						}
					}
			});
			
			/* naver 보류
			//naver 응모버튼 클릭시
			jQuery("#enter_button_na").click(function (e) {
				//Broswer Check
				var agent = navigator.userAgent.toLowerCase();

				//Samsung Browser
				/* 20170824 지원됨
				if (agent.indexOf("samsungbrowser") != -1) {
					alert("지원되지 않는 브라우저 입니다. \n크롬에서 접속해주세요.");
					return;
				}
				*/
				
			/*	var user_id  = <?php echo $user_id?>;
				  
					if(!user_id){
						//네이버 자동로그인 20170914
						location.href = 'http://selvitest.cafe24.com/?action=cosmosfarm_members_social_login&channel=naver&redirect_to=<?php echo get_permalink()?>';
						
						/*로그인 페이지로 이동*/
						//location.href = "http://selvitest.cafe24.com/login/";

					//유저일때
			/*		} else {
						var event_id = document.getElementById("event_id").value;//<?php echo $event_id?>;
						//이벤트 아이디가 존재할때
						if(event_id !=""){
							
							//20170911 로직변경
							//로그인 유저 확인
							var user_connect_ck = "<?php echo $user_connect_ck ?>";
								
							//네이버유저일때
							if(user_connect_ck=="naver"){
								
								/* NOTICE MESSAGE POPUP*/
			/*					e.stopPropagation();
								openApplyConfirm('naver');
								
							//네이버 유저 아닐때
							}else if(user_connect_ck!="naver"){
								//alert("네이버로 로그인해 주세요.");
								//네이버 자동로그인 20170914
								location.href = 'http://selvitest.cafe24.com/?action=cosmosfarm_members_social_login&channel=naver&redirect_to=<?php echo get_permalink()?>';
							}
						}
					}
			});
		*/	
		
		/* kakao 보류 
		//kakao 응모버튼 클릭시
			jQuery("#enter_button_ka").click(function (e) {
				//Broswer Check
				var agent = navigator.userAgent.toLowerCase();

				//Samsung Browser
				/* 20170824 지원됨
				if (agent.indexOf("samsungbrowser") != -1) {
					alert("지원되지 않는 브라우저 입니다. \n크롬에서 접속해주세요.");
					return;
				}
				*/
				
		/*		var user_id  = <?php echo $user_id?>;
				  
					if(!user_id){
						//카카오 자동로그인 20170914
						location.href = 'http://selvitest.cafe24.com/?action=cosmosfarm_members_social_login&channel=kakao&redirect_to=<?php echo get_permalink()?>';
						
						/*로그인 페이지로 이동*/
						//location.href = "http://selvitest.cafe24.com/login/";

					//유저일때
		/*			} else {
						var event_id = document.getElementById("event_id").value;//<?php echo $event_id?>;
						//이벤트 아이디가 존재할때
						if(event_id !=""){
							
							//20170911 로직변경
							//로그인 유저 확인
							var user_connect_ck = "<?php echo $user_connect_ck ?>";
								
							//카카오유저일때
							if(user_connect_ck=="kakao"){
								
								/* NOTICE MESSAGE POPUP*/
		/*						e.stopPropagation();
								openApplyConfirm('kakao');
								
							//카카오 유저 아닐때
							}else if(user_connect_ck!="kakao"){
								//alert("카카오로 로그인해 주세요.");
								//카카오 자동로그인 20170914
								location.href = 'http://selvitest.cafe24.com/?action=cosmosfarm_members_social_login&channel=kakao&redirect_to=<?php echo get_permalink()?>';
							}
						}
					}
			});
		*/
		
		// 20170915 응모채널 추가
		//kakao story 응모버튼 클릭시
			jQuery("#enter_button_ks").click(function (e) {
				//Broswer Check
				var agent = navigator.userAgent.toLowerCase();

				//Samsung Browser
				/* 20170824 지원됨
				if (agent.indexOf("samsungbrowser") != -1) {
					alert("지원되지 않는 브라우저 입니다. \n크롬에서 접속해주세요.");
					return;
				}
				*/
				
				var user_id  = <?php echo $user_id?>;
				  
					if(!user_id){
						//카카오 자동로그인 20170914
						location.href = 'http://selvitest.cafe24.com/?action=cosmosfarm_members_social_login&channel=kakao&redirect_to=<?php echo get_permalink()?>';
						
						/*로그인 페이지로 이동*/
						//location.href = "http://selvitest.cafe24.com/login/";

					//유저일때
					} else {
						var event_id = document.getElementById("event_id").value;//<?php echo $event_id?>;
						//이벤트 아이디가 존재할때
						if(event_id !=""){
							
							//20170911 로직변경
							//로그인 유저 확인
							var user_connect_ck = "<?php echo $user_connect_ck ?>";
								
							//카카오유저일때
							if(user_connect_ck=="kakao"){
								
								/* NOTICE MESSAGE POPUP*/
								e.stopPropagation();
								openApplyConfirm('kakao_story');
								
							//카카오 유저 아닐때
							}else if(user_connect_ck!="kakao"){
								//alert("카카오로 로그인해 주세요.");
								//카카오 자동로그인 20170914
								location.href = 'http://selvitest.cafe24.com/?action=cosmosfarm_members_social_login&channel=kakao&redirect_to=<?php echo get_permalink()?>';
							}
						}
					}
			});
			
	
		/* 20170915 band로그인 중간에 필 - 보류 
		//naver band 응모버튼 클릭시
			jQuery("#enter_button_nb").click(function (e) {
				//Broswer Check
				var agent = navigator.userAgent.toLowerCase();

				//Samsung Browser
				/* 20170824 지원됨
				if (agent.indexOf("samsungbrowser") != -1) {
					alert("지원되지 않는 브라우저 입니다. \n크롬에서 접속해주세요.");
					return;
				}
				*/
				
		/*		var user_id  = <?php echo $user_id?>;
				  
					if(!user_id){
						//네이버 자동로그인 20170914
						location.href = 'http://selvitest.cafe24.com/?action=cosmosfarm_members_social_login&channel=naver&redirect_to=<?php echo get_permalink()?>';
						
						/*로그인 페이지로 이동*/
						//location.href = "http://selvitest.cafe24.com/login/";

					//유저일때
		/*			} else {
						var event_id = document.getElementById("event_id").value;//<?php echo $event_id?>;
						//이벤트 아이디가 존재할때
						if(event_id !=""){
							
							//20170911 로직변경
							//로그인 유저 확인
							var user_connect_ck = "<?php echo $user_connect_ck ?>";
								
							//네이버유저일때
							if(user_connect_ck=="naver"){
								
								/* NOTICE MESSAGE POPUP*/
		/*						e.stopPropagation();
								openApplyConfirm('naver');
								
							//네이버 유저 아닐때
							}else if(user_connect_ck!="naver"){
								//alert("네이버로 로그인해 주세요.");
								//네이버 자동로그인 20170914
								location.href = 'http://selvitest.cafe24.com/?action=cosmosfarm_members_social_login&channel=naver&redirect_to=<?php echo get_permalink()?>';
							}
						}
					}
			});
			
		*/

		// POPUP RENEWAL -------------------------------------------------------------------------------------->
		
		<!-- ENTER POPUP LOGIC START -------------------------------------------------------------------------->
		<!-- AJAX SUBMIT -->
		jQuery("#eventinfo-form").submit(function(e) {
			var formObj = $(this);
			var formURL = formObj.attr("action");
			var formData = new FormData(this);
			jQuery.ajax({
				url: formURL,
				type: 'POST',
				data:  formData,
				mimeType:"multipart/form-data",
				contentType: false,
				cache: false,
				processData:false,
				success: function(data, textStatus, jqXHR)
				{
					//form data저장 성공일때
				},
				 error: function(jqXHR, textStatus, errorThrown)
				{
					//form data저장 실패일때
				}         
			});
			e.preventDefault(); //Prevent Default action.
			//e.unbind();
		});
		
		<!-- ENTER WIN -->
		function enter_win(){
			location.href='delivery?event_id=<?php echo $event_id;?>';
		}
		
		<!-- ENTER LOSE -->
		function enter_lose(){
			window.location.href="http://selvitest.cafe24.com/"; 
		}
		<!-- ENTER POPUP LOGIC END --------------------------------------------------------------------------->
		
		</script>

		<?php
	}
	
	//실질 데이터 요청 함수
	//admin-post.php->action->eventinfo-post->post_request
	function post_request(){
		global $current_user, $wpdb;

	if( ! isset($_REQUEST['eventinfo_nonce'])
			|| ! wp_verify_nonce($_REQUEST['eventinfo_nonce'], 'eventinfo') )//nonce유효한지
			return;
			
		$event_id        = absint($_REQUEST['event_id'])>0 ? $_REQUEST['event_id'] : null;
		$post_id 		 = trim($_REQUEST['post_id']);
		$user_id 		 = trim($_REQUEST['user_id']);
		$status 		 = trim($_REQUEST['status']);
		$event_all_prize = trim($_REQUEST['event_all_prize']);
		$event_prize     = trim($_REQUEST['event_prize']);
		$event_start     = trim($_REQUEST['event_start']);
		$event_end       = trim($_REQUEST['event_end']);

		$event_enter     = trim($_REQUEST['event_enter']);
		$event_all_prize = apply_filters('pre_event_event_all_prize', $event_all_prize);
		$event_prize     = apply_filters('pre_event_event_prize', $event_prize);
		$event_start     = apply_filters('pre_event_event_start', $event_start);
		$event_end       = apply_filters('pre_event_event_end', $event_end);
		$event_enter     = apply_filters('pre_event_event_enter', $event_enter);
		
		//20170712
		$event_type      = trim($_REQUEST['event_type']);
		
		//업데이트 체크
		$update = false;
		if( $row = $this->get_row($post_id) ){
			//업데이트일경우
			$update = true;
		}
		
		//응모체크
		$enter = false;
		if( $enter_row = $this->get_enter_row($user_id, $event_id) ){
			//응모 중복인경우
			$enter = true;
		}
		
		$data['event_all_prize']   = $event_all_prize;
		$data['event_prize'] = $event_prize;
		$data['event_start'] = $event_start;
		$data['event_end']   = $event_end;
		$data['event_enter'] = $event_enter;
		$data['updt_date']   = current_time('mysql');
		//20170712
		$data['event_type']  = $event_type;
	
		//이벤트정보업데이트 and 응모중복일때 -> 이벤트정보만 업데이트
		if( $update==true && $enter==true){
			$wpdb->update($this->table, $data, compact('event_id'));
		
		//이벤트정보업데이트 and 새로운응모 -> 이벤트정보업데이트 and 응모정보등록 - 사용자
		}else if( $update==true && $enter==false && $current_user->user_status == 0 ){
			$data2['enter_id']    = $enter_id;
			$data2['event_id']    = $event_id;
			$data2['user_id']     = $user_id;
			$data2['status']      = $status;
			$data2['rgst_date']   = current_time('mysql');
			$data2['updt_date']   = current_time('mysql');

			$wpdb->update($this->table, $data, compact('event_id'));
			$wpdb->insert($this->table2, $data2);

		//이벤트정보업데이트 and 새로운응모 -> 이벤트정보업데이트 and 응모정보등록 - 관리자
		}else if( $update==true && $enter==false && $current_user->user_status == 1 ){
			$data2['enter_id']    = $enter_id;
			$data2['event_id']    = $event_id;
			$data2['user_id']     = $user_id;
			$data2['status']      = $status;
			$data2['rgst_date']   = current_time('mysql');
			$data2['updt_date']   = current_time('mysql');

			$wpdb->update($this->table, $data, compact('event_id'));
			
		//어느경우도 아닌경우 -> 이벤트정보 등록
		}else{
			$data['event_id']    = $event_id;
			$data['post_id']     = $post_id;
			$data['event_all_prize']   = $event_all_prize;
			$data['event_prize'] = $event_prize;
			$data['event_start'] = $event_start;
			$data['event_end']   = $event_end;
			$data['event_enter'] = $event_enter;
			$data['rgst_date']   = current_time('mysql');
			$data['updt_date']   = current_time('mysql');
			//20170712
			$data['event_type']  = $event_type;
			
			$wpdb->insert($this->table, $data);
		}
		
		$goback = wp_get_referer();
		$goback = remove_query_arg('eventinfo-event_id', $goback);
		wp_redirect( $goback );
		exit;
	}

	//정보 가져오는 함수
	function get_row($post_id){
		global $wpdb , $user_ID;
		
		$row = null;
		$post_id = absint($post_id);
		if( $post_id > 0 ){
			$sql = $wpdb->prepare("SELECT * FROM $this->table WHERE post_id=%d", $post_id);
			$row = $wpdb->get_row( $sql );
		}
		return $row;
	}
	
	//응모내역 정보 가져오는 함수
	function get_enter_row($user_id, $event_id){
		global $wpdb , $user_ID;
		
		$enter_row = null;
		$user_id = absint($user_id);
		if( $user_id > 0 ){
			$sql = $wpdb->prepare("SELECT * FROM $this->table2 WHERE user_id=%d AND event_id=%d", $user_id , $event_id);
			$enter_row = $wpdb->get_row( $sql );
		}
		return $enter_row;
	}
}