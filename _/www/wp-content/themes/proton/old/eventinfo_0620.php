<?php 
/**
* [init]     
* [20170607] | 이벤트 정보등록 CRUD php파일 생성       | eley 
* ---------------------------------------------------
* [after]
* [20170609] | 시작시간,종료시간 테이블컬럼추가에 따른 로직 변경 | eley
* [20170612] | 코드정리 및 CRUD 테스트 완료            | eley
*/
class event_info {
	function __construct(){
		//편의를 위해 테이블이름을 변수로 만들어줌
		global $wpdb;
		$this->table = $wpdb->prefix . 'event_info';
		//숏코드 등록
		add_shortcode( 'eventinfo', array($this, 'shortcode') );
		//액션등록 admin-post.php 참조
		add_action( 'admin_post_eventinfo-post', array($this, 'post_request') );
		add_action( 'admin_post_nopriv_eventinfo-post', array($this, 'post_request') );
		//event_enter테이블 변수로 생성 >>table2
		$this->table2 = $wpdb->prefix . 'event_enter';
		
		//액션등록 admin-post.php 참조
		//add_action( 'admin_post_evententer-post', array($this, 'post_req') );
		//add_action( 'admin_post_nopriv_evententer-post', array($this, 'post_req') );
		
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
	
	//관리자폼 함수
	function the_form(){
		//유저정보
		//현재 유저 정보를 가져옴
		global $current_user;
		wp_get_current_user();
		
		$user_id = $current_user->ID;
		$user_roll = ($user_id != 0) ? $current_user->user_status : 0;
		$user_url_ck = ($user_id != 0) ? $current_user->user_url : '';

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
		
		//버튼설정
		$submit_label = '등록';
		$update = false;
		$enter  = false;
		
		//테이블에 저장된 post id값 있을때
		if($row = $this->get_row($post_id)) {
			//관리자 버튼설정
			$update = true;
			$submit_label = '수정';
			
			$event_id 		 = $row->event_id;
			$post_id         = $row->post_id;
			
			$event_all_prize = $row->event_all_prize;
			$event_prize     = $row->event_prize;

			$event_start     = $row->event_start;
			$event_end       = $row->event_end;
			
			$event_sdate     = substr($event_start, 0, 10);
			$event_edate     = substr($event_end, 0, 10);
			$event_stime     = substr($event_start, 11, 18);
			$event_etime     = substr($event_end, 11, 18);
			
			$event_enter     = $row->event_enter;
		
			//사용자 설정
			
			//Server Event Timecheck
			//기준시간 한국으로 설정
			date_default_timezone_set('Asia/Seoul');
			
			$event_ck = false;
			
			$curnt_t     = date("Y-m-d H:i:s");
			$event_end_t = date("Y-m-d H:i:s", strtotime($event_end));

			//남은경품이 0이거나 남은시간이 없을때 응모버튼비활성화
			if( (strtotime($event_end_t) <= strtotime($curnt_t)) || $event_prize == "0" || $event_prize == ""){
				$event_ck = true;
			}
		}
		
		//이벤트 응모내역 확인
		$dup = false;
		
		if($enter_row = $this->get_enter_row($user_id, $event_id)) {
			//응모내역 있음
			if(isset($enter_row)){
				$dup = true;//중복응모안되게 체크
			//응모내역 없음	
			}else{
				$dup = false;
			}
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
			<!--
			<input type="hidden" id="event_prize" name="event_prize" value="<?php //echo $event_prize;?>" />
			<input type="hidden" id="event_enter" name="event_enter" value="<?php //echo $event_enter;?>" />-->
			
			<!-- 로그인한회원 + 관리자일때 -->
			<?php if($user_id != 0 && $user_roll == 1) {?>
			
			<!-- 관리자폼실행 -->
		
			<!-- 보이는 폼변경 세로방식->가로방식 20170613
			<h3><b>
			전체경품 / 남은경품
			<br></br>
			<input type="text" id="event_all_prize" name="event_all_prize" class="numbersOnly" value="<?php// echo $event_all_prize;?>" style="width:95px; text-align:center;" />
			/
			<input type="text" id="event_prize" name="event_prize" class="numbersOnly" value="<?php //echo $event_prize;?>" style="width:95px; text-align:center;" />
			<br></br>
			<!-- 20170609
			시작시간 ~ 종료시간
			<br></br>
			<div id="event_time_div">
			<input id="event_time_1" class="numbersOnly" value="" style="width:52px; text-align:center;" maxlength="2"/>
			:
			<input id="event_time_2" class="numbersOnly" value="" style="width:52px; text-align:center;" maxlength="2"/>
			:
			<input id="event_time_3" class="numbersOnly" value="" style="width:52px; text-align:center;" maxlength="2"/>
			-->
			<!-- 20170613
			시작일시
			<br></br>
			<input type="text" id="event_sdate" value="<?php //echo $event_sdate;?>" style="width:210px; text-align:center;" readonly />
			<br></br>
			<input type="time" id="event_stime" value="<?php //echo $event_stime;?>" style="width:210px; text-align:center;" />
			<br></br>
			종료일시
			<br></br>
			<input type="text" id="event_edate" value="<?php ///echo $event_edate;?>" style="width:210px; text-align:center;" readonly>
			<br></br>
			<input type="time" id="event_etime" value="<?php //echo $event_etime;?>" style="width:210px; text-align:center;" />
			<br></br>
			<div>
			응모인원
			<br></br>
			<input type="text" id="event_enter" name="event_enter" class="numbersOnly" value="<?php //echo $event_enter;?>" style="width:210px; text-align:center;" />
			</b></h3>
			<!--버튼-->
			<!-- 20170613
			<input type="button" id="submit_button" value="<?=$submit_label?>" />
			<?php//if( $update ){ ?>
				<input type="reset" value="취소"/>
			<?php// } ?>
			-->
			
			<table width="100%" cellspacing="0%">
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
					<p style="text-align:center;"><font size="3"><b><input type="text" id="event_prize" name="event_prize" class="numbersOnly" value="<?php echo $event_prize;?>" style="width:100%; text-align:center; height:52px;" /></b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b><input type="text" id="event_all_prize" name="event_all_prize" class="numbersOnly" value="<?php echo $event_all_prize;?>" style="width:100%; text-align:center; height:52px" /></b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b><input type="text" id="event_sdate" value="<?php echo $event_sdate;?>" style="width:100%; text-align:center;" readonly />
					<input type="time" id="event_stime" value="<?php echo $event_stime;?>" style="width:100%; text-align:center;" />
					</b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b><input type="text" id="event_edate" value="<?php echo $event_edate;?>" style="width:100%; text-align:center;" readonly>
					<input type="time" id="event_etime" value="<?php echo $event_etime;?>" style="width:100%; text-align:center;" />
					</b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b><input type="text" id="event_enter" name="event_enter" class="numbersOnly" value="<?php echo $event_enter;?>" style="width:100%; text-align:center; height:52px" /></b></font></p>
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
		
		<?php if($event_id != "") {?>
		<input type="hidden" id="event_prize" name="event_prize" class="numbersOnly" value="<?php echo $event_prize;?>"/>
		<input type="hidden" id="event_enter" name="event_enter" class="numbersOnly" value="<?php echo $event_enter;?>" />
		<table width="100%" cellspacing="0%">
			<tr>
				<td>
					<p style="text-align:center;"><font size="3"><b>남은경품</b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b>전체경품</b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b>남은시간</b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b>응모인원</b></font></p>
				</td>
			</tr>
			<tr>
				<td>
					<p style="text-align:center;"><font size="3"><b><?php echo $event_prize;?></b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b><?php echo $event_all_prize;?></b></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b><text id="event_countdown"/></font></p>
				</td>
				<td>
					<p style="text-align:center;"><font size="3"><b><?php echo $event_enter;?></b></font></p>
				</td>
			</tr>
			<tr>
				<td colspan="5">
					<?php if( $event_ck ){ ?>
						<p style="text-align:center;"><b><input type="button" id="enter_button" value="응모종료" style="width:100%; text-align:center; background-color:darkgray;" disabled /></b></p>
					<!--<p style="text-align:center;"><b><input type="button" value="앵콜 요청하기" style="width:100%; text-align:center;" /></b></p>-->
					<?php }else { ?>
						<!--test-->
						<?php if( $dup ) { ?>
							<p style="text-align:center;"><b><input type="button" id="enter_button" value="응모완료" style="width:100%; text-align:center; background-color:darkgray;" disabled /></b></p>
						<?php } else {?>
						<p style="text-align:center;"><b><input type="button" id="enter_button" value="응모하기" style="width:100%; text-align:center;" /></b></p>
						<?php }?>
					<?php }?>
				</td>
			</tr>
		</table>
		<?php } ?>
		
		<?php } ?>
		</form>
		
		<script>
		//관리자시작
			//로딩시 함수
			jQuery(document).ready(function () {
			});
	
			//숫자체크 숫자가 아닐경우 자동으로 backspace
			jQuery('.numbersOnly').keyup(function () { 
				this.value = this.value.replace(/[^0-9\.]/g,'');
			});
			
			/** 20170609
			//event_time관련
			jQuery("#event_time_div").focusout(function () { 
				
				var event_time;
				var event_time_1;
				var event_time_2;
				var event_time_3;
			
				event_time_1 = document.getElementById("event_time_1").value;
				event_time_2 = document.getElementById("event_time_2").value;
				event_time_3 = document.getElementById("event_time_3").value;
				 
				if(event_time_1.length < 2){
					event_time_1 = "0"+document.getElementById("event_time_1").value;
				}
				if(event_time_2.length < 2){
					event_time_2 = "0"+document.getElementById("event_time_2").value;
				}
				if(event_time_3.length < 2){
					event_time_3 = "0"+document.getElementById("event_time_3").value;
				}
				
				event_time = event_time_1+":"+event_time_2+":"+event_time_3;
				
				document.getElementById("event_time").value = event_time;
			});
			*/
			
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
				if(event_end == "" ) {
					//document.getElementById('event_countdown').innerHTML = '';
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

						document.getElementById("enter_button").disabled = true;
						document.getElementById("enter_button").style = "width:100%; text-align:center; background-color:darkgray;";
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
			
			//응모버튼 클릭시
			jQuery("#enter_button").click(function () { 
				var user_id  = <?php echo $user_id?>;
				
					if(!user_id){
						//유저가 아닐때 로그인으로 이동
						if(confirm("로그인이 필요한 서비스입니다.\n로그인하시겠습니까?")){
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
							}
					//유저일때
					} else {
						var event_id = document.getElementById("event_id").value;//<?php echo $event_id?>;
						//이벤트 아이디가 존재할때
						if(event_id !=""){
							
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
							
							//KoreaSNS플러그인 함수 활용하여 SNS공유함수 부르기 
							//함수사용 : SendSNS('".$snsKey."', '".$title." - ".$siteTitle."', '".$link."', '');
							//$("#enter_button").click(SendSNS('facebook', '<?php echo $title?> - <?php echo $siteTitle?>', '<?php echo $link?>', ''))
							
							//로그인 유저가 페이스북유저인지 확인
							var user_url_ck = "<?php echo $user_url_ck ?>";

							if(user_url_ck != ""){
								var facebook_ck = user_url_ck.substr(11, 8);
								
								//페이스북유저일때
								if(facebook_ck=="facebook"){
									//페이스북 공유로직
									//event.preventDefault();
									//$.ajaxSetup({ cache: true });
									$.getScript('//connect.facebook.net/ko_KR/sdk.js', function(){
									FB.init({
									  appId: '229048730920671',
									  version: 'v2.9'
									})
									FB.ui({
										method: 'share',
										title: '<?php echo $title?> - <?php echo $siteTitle?>',
										description: 'SELVI-매일매일 행운을 더하다!',
										href: '<?php echo $link?>',
									  },
									  function(response) {
										//확률계산을 위한 변수
										var event_prize = "<?php echo $event_prize;?>";
										var event_end   = "<?php echo $event_end;?>";
										var event_enter = "<?php echo $event_enter;?>";
										
										//응답시 공유체크
										if (response && !response.error_code) {
											//응모인원늘리기
											event_enter = parseInt(event_enter)+1;
											document.getElementById("event_enter").value = event_enter;
											
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
											//alert((event_prize/remain_min)*100);
											
											if(Math.random()<((event_prize/remain_min)*100)){
												//당첨시
												//남은경품 -1 
												//event_prize-1;
												document.getElementById("event_prize").value = event_prize;
												
												event_prize = parseInt(event_prize)-1;
												document.getElementById("event_prize").value = event_prize;
												//jQuery('#eventinfo-form').submit();
												alert("당첨!\n오늘의 행운은 당신에게!");
												
												//배송관련 정보 적어주세요
												
												
											}else{
												//jQuery('#eventinfo-form').submit();
												//미당첨시
												alert("미당첨ㅠㅠ\n다음기회에...");
											}
										    //alert('이벤트에 응모 되었습니다.');
											//$('#eventinfo-form').submit();
											PUM.open(1103);
											//$('#eventinfo-form').submit();
										} else {
											alert('이벤트 응모가 취소되었습니다.');
										}
									})
								  })
								  
								//페이스북 유저 아닐때
								}else{
									alert("페이스북으로 로그인해 주세요.");
								}
								
							}
								
							//post함수로 이동
							//document.getElementById("action").value = "evententer-post";
							//document.getElementById("event_enter").value + 1 ;
							//$('#eventinfo-form').submit();
							//javascript:goPost("<?php admin_url('admin-post.php')?>",{'event_id':event_id, 'user_id':user_id, 'action':'evententer-post'},"evententer-post");
						}
					}

			});
					//<form id="eventinfo-form" action="<?=admin_url('admin-post.php')?>" method="post">
			//<?php wp_nonce_field('eventinfo', 'eventinfo_nonce'); ?>
			//<input type="hidden" name="action" value="eventinfo-post">
			/**
			function goPost(path, params, id, method) {
			method = method || "post"; // 전송 방식 기본값을 POST로
			
			//폼생성
			var evententer_form = document.createElement("form");
			
			//data 세팅
			evententer_form.setAttribute("id", id);
			evententer_form.setAttribute("method", method);
			evententer_form.setAttribute("action", path);
		 
			//히든으로 값을 주입시킨다.
			for(var key in params) {
				var hiddenField = document.createElement("input");
				hiddenField.setAttribute("type", "hidden");
				hiddenField.setAttribute("name", key);
				hiddenField.setAttribute("value", params[key]);
		 
				alert(key + params[key]);
				evententer_form.appendChild(hiddenField);
			}
		 
			document.body.appendChild(evententer_form);
			
			//저장 -> request
			evententer_form.submit();
		}
		*/
		</script>

		<?php
	}
	
	//실질 데이터 요청 함수
	//admin-post.php->action->eventinfo-post->post_request
	function post_request(){
		global $wpdb;

	if( ! isset($_REQUEST['eventinfo_nonce'])
			|| ! wp_verify_nonce($_REQUEST['eventinfo_nonce'], 'eventinfo') )//nonce유효한지
			return;

		//echo '<script>alert('.intval($event_all_prize).');</script>';
		$event_id        = absint($_REQUEST['event_id'])>0 ? $_REQUEST['event_id'] : null;
		$post_id 		 = trim($_REQUEST['post_id']);
		$event_all_prize = trim($_REQUEST['event_all_prize']);
		$event_prize     = trim($_REQUEST['event_prize']);
		$event_start     = trim($_REQUEST['event_start']);
		$event_end       = trim($_REQUEST['event_end']);
		//$event_time      = trim($_REQUEST['event_time']);  20170609
		$event_enter     = trim($_REQUEST['event_enter']);
		$event_all_prize = apply_filters('pre_event_event_all_prize', $event_all_prize);
		$event_prize     = apply_filters('pre_event_event_prize', $event_prize);
		$event_start     = apply_filters('pre_event_event_start', $event_start);
		$event_end       = apply_filters('pre_event_event_end', $event_end);
		//$event_time      = apply_filters('pre_event_event_time', $event_time);  20170609
		$event_enter      = apply_filters('pre_event_event_enter', $event_enter);
		
		//server validation 
		/** 20170609
		if( empty($event_time) ){
			wp_die( '시간을 입력하세요.' );
		}
		*/
		
		//업데이트 체크
		$update = false;
		if( $row = $this->get_row($post_id) )
		//업데이트일경우
		$update = true;
		
		$data['event_all_prize']   = $event_all_prize;
		$data['event_prize'] = $event_prize;
		$data['event_start'] = $event_start;
		$data['event_end']   = $event_end;
		$data['event_enter'] = $event_enter;
		$data['updt_date']   = current_time('mysql');
	
		if( $update ){
			$wpdb->update($this->table, $data, compact('event_id'));
		
		//업데이트 아닌경우
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
			
			$wpdb->insert($this->table, $data);
		}
		
		$goback = wp_get_referer();
		$goback = remove_query_arg('eventinfo-event_id', $goback);
		wp_redirect( $goback );
		exit;
	}
	
	//test
	/**
	function post_req(){
		echo '<script>alert("tt");</script>';
		global $wpdb;
	echo $_POST['evententer_nonce'];
	//if( ! isset($_POST['evententer_nonce'])
	//		|| ! wp_verify_nonce($_POST['evententer_nonce'], 'evententer') )
	//		return;

		$event_id        = absint($_POST['event_id'])>0 ? $_POST['event_id'] : '';
		$enter_id 		 = absint($_POST['enter_id'])>0 ? $_POST['enter_id'] : '';
		$user_id         = absint($_POST['user_id'])>0 ? $_POST['user_id'] : '';
		
		//업데이트 체크
		$update = false;
		if( $enter_row = $this->get_enter_row($user_id, $event_id) )
		//업데이트일경우
		$update = true;
		
		$data['enter_id']   = $event_all_prize;
		$data['event_id']   = $event_prize;
		$data['user_id']    = $event_start;
		
		if( $update ){
			//$wpdb->update($this->table2, $data, compact('enter_id'));
			
			$dup = true;
			//return $dup;
		
		//업데이트 아닌경우
		}else{
			$data['enter_id']    = $enter_id;
			$data['event_id']    = $event_id;
			$data['user_id']     = $user_id;
			$data['status']      = '1';
			$data['rgst_date']   = current_time('mysql');
			$data['updt_date']   = current_time('mysql');
			
			//$dup = false;
			//$wpdb->insert($this->table2, $data);
		}
		
		$goback = wp_get_referer();
		$goback = remove_query_arg('evententer-enter_id', $goback);
		wp_redirect( $goback );
		exit;
		
	}
	*/
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


