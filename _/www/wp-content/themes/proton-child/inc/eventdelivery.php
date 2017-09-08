<?php 
/**
* [init]     
* [20170623] | 이벤트 배달정보등록 CRUD php파일 생성     | eley 
* ---------------------------------------------------
* [after]
* [20170707] | 소스정리 및 기능 마무리                 | eley 
*
* [RENEWAL]----------------------------------------------------------
* [20170731] | RENEWAL                        | eley 
*/
class event_delivery {
	function __construct(){
		//편의를 위해 wordpress 테이블이름을 변수로 만들어줌
		global $wpdb;
		
		//이벤트 응모 배달정보 등록 테이블
		$this->table  = $wpdb->prefix . 'event_delivery';
		//이벤트 응모 테이블 - 회원
		$this->table2 = $wpdb->prefix . 'event_enter';
		//사용자 테이블 - 회원
		$this->table3 = $wpdb->prefix . 'users';
		//+이벤트 테이블
		$this->table4 = $wpdb->prefix . 'event_info';
		
		//숏코드 등록
		add_shortcode( 'eventdelivery', array($this, 'shortcode') );
		
		//액션등록 admin-post.php 참조
		add_action( 'admin_post_eventdelivery-post', array($this, 'post_request') );
		add_action( 'admin_post_nopriv_eventdelivery-post', array($this, 'post_request') );
	}

	//숏코드 실행
	function shortcode(){
		ob_start();
		?>
		<div id="eventdelivery">
			<!-- 폼 실행 -->
			<?php $this->the_form();?>
		</div>
		<?php
		return ob_get_clean();
	}
	
	//폼 생성함수
	function the_form(){
		//초기 필요한 변수세팅
		
		//현재 유저 정보를 가져옴
		global $current_user;
		wp_get_current_user();

		//todo : 당첨자와 현재유저 같은사람인지 확인할 필요성 ?
		$user_id = $current_user->ID;
		//초기값 init
		$delivery_id = '';
		$enter_id    = isset($_REQUEST['enter_id']) ? $_REQUEST['enter_id'] : '';
		$delivery_name  = '';
		$delivery_phone = '';
		$delivery_zip   = '';
		$delivery_addr1 = '';
		$delivery_addr2 = '';
		$basic_YN     = 'Y';
		$delivery_etc = '';
		//event_id 전송받음
		$event_id     = isset($_REQUEST['event_id'])? $_REQUEST['event_id'] : '';
		//+post_id
		$post_id = '';
		
		//나쁜접속확인
		$url_ck = false;
		//버튼설정
		$submit_label = '등록';
		
		//업데이트체크-request deliveryDB
		$update = false;
		
		//응모내역에 있는지 확인 + 받는내용 없으면 안보여줌
		if($event_id != '' || $enter_id != ''){
			$enter_row = $this->get_enter_row($user_id, $event_id, $enter_id);
			//응모내역 있음
			if(isset($enter_row)){		
				//변수설정
				$enter_id = $enter_row->enter_id;
				$enter_status = $enter_row->status;
				$enter_user_id = $enter_row->user_id;
				//+event_id
				$event_id = $enter_row->event_id;
				
				if($user_id!=$enter_user_id || $enter_status=='0'){
					$url_ck = false;
				}else{
					$url_ck = true;
				}
				
			}else{
				$url_ck = false;
			}
			
		}
		//url잘못된 접속일때 홈화면으로 이동
	    if($url_ck == false){
			wp_redirect(home_url());
			return;
		}
		//url잘못된 접속일때 메세지 보여줌
		//if($url_ck == false){ 
		//	echo "<div align='center';><h3 style='color:#ffcb2f'>당첨 내역이 없습니다.</h3></div>";
		//	return;
		//}
		
		//등록된 기본정보가 있을때 변수설정
		if($user_row = $this->get_user_row($user_id)){
			if(isset($user_row)){
				$delivery_name  = $user_row->user_realname;
				$delivery_phone = $user_row->user_phone;
				$delivery_zip   = $user_row->user_zip;
				$delivery_addr1 = $user_row->user_addr1;
				$delivery_addr2 = $user_row->user_addr2;
			}
		}
		
		//등록된 배송정보가 있을때 변수설정
		if($delivery_row = $this->get_delivery_row($enter_id)){
			if(isset($delivery_row)){
				$update = true;
				//$submit_label = '수정';
				$delivery_id = $delivery_row->delivery_id;
				$enter_id    = $delivery_row->enter_id;
				$delivery_name  = $delivery_row->delivery_name;
				$delivery_phone = $delivery_row->delivery_phone;
				$delivery_zip   = $delivery_row->delivery_zip;
				$delivery_addr1 = $delivery_row->delivery_addr1;
				$delivery_addr2 = $delivery_row->delivery_addr2;
				$basic_YN     = $delivery_row->basic_YN;
				$delivery_etc = $delivery_row->delivery_etc;
			}
		}
		
		//+post_id
		$event_row = $this->get_event_row($event_id);
		$post_id = $event_row->post_id;
		?>
				
		<!--폼 구성-->
		<form id="eventdelivery-form" action="<?=admin_url('admin-post.php')?>" method="post">
			<?php wp_nonce_field('eventdelivery', 'eventdelivery_nonce'); ?>
			<input type="hidden" id="action" name="action" value="eventdelivery-post">
			<input type="hidden" id="delivery_id" name="delivery_id" value="<?php echo $delivery_id;?>" />
			<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id;?>" />
			<input type="hidden" id="enter_id" name="enter_id" value="<?php echo $enter_id;?>" />
			<input type="hidden" id="delivery_zip" name="delivery_zip" value="<?php echo $delivery_zip;?>" />
			<input type="hidden" id="basic_YN" name="basic_YN" value="<?php echo $basic_YN;?>" />
			<input type="hidden" id="post_id" name="post_id" value="<?php echo $post_id;?>" />
			
			<!-- delivery renewal start -------------------------------------------------------------------------->
			
			<!-- VIEW -->
			<!-- yeonok: 배송지 입력화면 시작 -->
			<article class="page-basic">
				<div class="inner-container">
					
					<div class="page-basic-header">
						<h1 class="page-title">배송지 정보 입력</h1>
						<p class="page-desc">경품 전달을 위한 정보입니다. 정확하게 입력 해 주세요.</p>
					</div><!-- /.page-basic-header -->

					<div class="page-basic-content">

						<section class="write-address">
							<div class="form-frame">
								<p class="check-form check-default">
									<input type="checkbox" id="basic_YN_ck" name="basic_YN_ck" value="<?php echo $basic_YN;?>" checked>
									<label for="basic_YN_ck">기본 정보로 등록</label>
								</p>
								<div class="form-list">
									<dl>
										<dt>이름(실명)</dt>
										<dd>
											<input type="text" class="input-text col-6" id="delivery_name" name="delivery_name" value="<?php echo $delivery_name;?>">
										</dd>
									</dl>
									<dl class="">
										<dt>휴대폰('-'포함)</dt>
										<dd>
											<input type="text" class="input-text col-6" id="delivery_phone" name="delivery_phone" value="<?php echo $delivery_phone;?>">
										</dd>
									</dl>
									<dl class="field-addr">
										<dt>주소</dt>
										<dd>
											<div id="wrap" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0; position: absolute; z-index: 999;">
												<img src="//t1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
											</div>
											<input type="text" class="input-text col-9 d_form large" placeholder="주소" onclick="sample3_execDaumPostcode()" id="delivery_addr1" name="delivery_addr1" value="<?php echo $delivery_addr1;?>" readonly>
											<input type="text" class="input-text col-9" placeholder="상세주소" id="delivery_addr2" name="delivery_addr2" value="<?php echo $delivery_addr2;?>">
										</dd>
									</dl>
									<dl>
										<dt>기타사항</dt>
										<dd>
											<!-- +yeonok: adjust textarea 20170824 -->
											<textarea id="delivery_etc" name="delivery_etc" class="textarea col-12" value="<?php echo $delivery_etc;?>"><?php echo $delivery_etc;?></textarea>
										</dd>
									</dl>
								</div><!-- /.form-list -->
								
								<?php if($update == false) { ?>
								<div class="field-agree">
										<p class="check-form">
											<input type="checkbox" id="agree_individual" checked="checked">
											<label for="agree_individual">
												<a onclick="popupFunc('http://selvitest.cafe24.com/agree_individual.html',400,600,'개인정보동의')">
													개인정보동의
												</a>
											</label>
										</p>
										<p class="check-form">
											<input type="checkbox" id="agree_service" checked="checked">
											<label for="agree_service">
												<a onclick="popupFunc('http://selvitest.cafe24.com/agree_service.html',400,600,'서비스이용약관동의')">
													서비스이용약관동의
												</a>
											</label>
										</p>
								</div>
								<?php } ?>
								
								<div class="field-control">
									<?php if($update == false) : ?>
										<input type="button" name="delviery_submit" id="delviery_submit" value="<?=$submit_label?>" class="btn-univ" style="width:100%; max-width: 228px;">
									<?php else : ?>
										<input type="button" name="delviery_submit" id="delviery_submit" value="저장" class="btn-univ btn-univ-small">
										<input type="reset" value="취소" class="btn-univ btn-univ-small gray">
									<?php endif ?>								
								</div>
								
							</div><!-- /.form-frame -->
						</section><!-- /.write-address -->

					</div><!-- /.page-basic-content -->
				
				</div><!-- /.inner-container -->
			</article><!-- /.page-basic -->
			<!-- yeonok: 배송지 입력화면 끝 -->
		</form>
		
		<!-- script시작 -->
		<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
		<script>
			//로딩시 함수
			jQuery(document).ready(function () {
				//checkbox 값 세팅 - 불러올때
				var basic_YN     = document.getElementById("basic_YN").value;
				
				//불러온 basic_YN값에따라 체크
				if(basic_YN == "Y"){
					$("#basic_YN_ck").prop("checked", true);
				}else if(basic_YN == 'N'){
					$("#basic_YN_ck").prop("checked", false);
				}else{
					$("#basic_YN_ck").prop("checked", true);
					document.getElementById("basic_YN").value = "Y";
				}
			});
			
			//기본정보 체크값에따라 저장여부 변경
			jQuery("#basic_YN_ck").change(function () { 
				if($("#basic_YN_ck").is(":checked") == true){
					document.getElementById("basic_YN").value = "Y";
				}else if($("#basic_YN_ck").is(":checked") == false){
					document.getElementById("basic_YN").value = "N";
				}
			});
			
			//textarea 크기자동조절
			/*
			function resize(obj){
				obj.style.height = "1px";
				obj.style.height = (20+obj.scrollHeight)+"px";
			}
			*/
			
			//전화번호 체크함수
			function tel_check(str){
				var regTel = /^(01[016789]{1}|070|02|0[3-9]{1}[0-9]{1})-[0-9]{3,4}-[0-9]{4}$/;
				if(!regTel.test(str)) {
					return false;
				}
				return true;
			}

			//팝업띄우기
			function popupFunc(url,w,h,name) {
				var screenW = screen.availWidth;  // 스크린 가로사이즈
				var screenH = screen.availHeight; // 스크린 세로사이즈
				var popW = w; // 띄울창의 가로사이즈
				var popH = h; // 띄울창의 세로사이즈
				var posL=( screenW-popW ) / 2;   // 띄울창의 가로 포지션 
				var posT=( screenH-popH ) / 2;   // 띄울창의 세로 포지션 

				window.open(url, name,'width='+ popW +',height='+ popH +',top='+ posT +',left='+ posL +',resizable=no,scrollbars=no');
			}

			<!-- 다음주소 api 시작-->
			// 우편번호 찾기 찾기 화면을 넣을 element
			var element_wrap = document.getElementById('wrap');

			function foldDaumPostcode() {
				// iframe을 넣은 element를 안보이게 한다.
				element_wrap.style.display = 'none';
			}

			function sample3_execDaumPostcode() {
				// 현재 scroll 위치를 저장해놓는다.
				var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
				new daum.Postcode({
					oncomplete: function(data) {
						// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

						// 각 주소의 노출 규칙에 따라 주소를 조합한다.
						// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
						var fullAddr = ''; // 최종 주소 변수
						var extraAddr = ''; // 조합형 주소 변수

						// 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
						if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
							fullAddr = data.roadAddress;

						} else { // 사용자가 지번 주소를 선택했을 경우(J)
							fullAddr = data.jibunAddress;
						}

						// 사용자가 선택한 주소가 도로명 타입일때 조합한다.
						if(data.userSelectedType === 'R'){
							//법정동명이 있을 경우 추가한다.
							if(data.bname !== ''){
								extraAddr += data.bname;
							}
							// 건물명이 있을 경우 추가한다.
							if(data.buildingName !== ''){
								extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
							}
							// 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
							fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
						}

						// 우편번호와 주소 정보를 해당 필드에 넣는다.
						document.getElementById('delivery_zip').value = data.zonecode; //5자리 새우편번호 사용
						document.getElementById('delivery_addr1').value = fullAddr;

						// iframe을 넣은 element를 안보이게 한다.
						// (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
						element_wrap.style.display = 'none';

						// 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
						document.body.scrollTop = currentScroll;
					},
					// 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
					onresize : function(size) {
						element_wrap.style.height = size.height+'px';
					},
					width : '100%',
					height : '100%'
				}).embed(element_wrap);

				// iframe을 넣은 element를 보이게 한다.
				element_wrap.style.display = 'block';
			}
			<!-- 다음주소 api 끝-->
			
			//submit
			//저장버튼 클릭시
			jQuery("#delviery_submit").click(function () {
				//validation
				//input box
				var delivery_name      = document.getElementById("delivery_name").value;
				var delivery_phone     = document.getElementById("delivery_phone").value;
				var delivery_addr1     = document.getElementById("delivery_addr1").value;
				var delivery_addr2     = document.getElementById("delivery_addr2").value;
				
				if(delivery_name==''){
					alert("이름(실명)을 입력해주세요");
					return;
				}
				if(delivery_phone==''){
					alert("번호를('-'포함) 입력해주세요");
					return;
				}
				if(tel_check(delivery_phone)==false){
					alert("번호형식이 잘못되었습니다.\n올바른 번호를 입력해주세요");
					return;
				}
				if(delivery_addr1==''){
					alert("주소를 입력해주세요");
					return;
				}
				if(delivery_addr2==''){
					alert("상세주소를 입력해주세요");
					return;
				}
				
				//checkbox				
				if($("#agree_individual").prop(checked="checked") == false){
					alert("개인정보동의 항목에 동의해주세요");
					return;
				}
				if($("#agree_service").prop(checked="checked") == false){
					alert("서비스이용약관동의 항목에 동의해주세요");
					return;
				}
				
				//submit
				$('#eventdelivery-form').submit();

			});
		</script>

		<?php
	}
	
	//실질 데이터 요청 함수
	//admin-post.php->action->eventdelivery-post->post_request
	function post_request(){
		global $wpdb;

	if( ! isset($_REQUEST['eventdelivery_nonce'])
			|| ! wp_verify_nonce($_REQUEST['eventdelivery_nonce'], 'eventdelivery') )//nonce유효한지
			return;
			
		$ID     = absint($_REQUEST['user_id'])>0 ? $_REQUEST['user_id'] : '';
		$delivery_id = absint($_REQUEST['delivery_id'])>0 ? $_REQUEST['delivery_id'] : '';
		$enter_id    = trim($_REQUEST['enter_id']);
		$delivery_name  = trim($_REQUEST['delivery_name']);
		$delivery_phone = trim($_REQUEST['delivery_phone']);
		$delivery_zip   = trim($_REQUEST['delivery_zip']);
		$delivery_addr1 = trim($_REQUEST['delivery_addr1']);
		$delivery_addr2 = trim($_REQUEST['delivery_addr2']);
		$basic_YN     = trim($_REQUEST['basic_YN']);
		$delivery_etc = trim($_REQUEST['delivery_etc']);
		
		//+저장후 페이지이동을 위한 post_id 추가
		$post_id = absint($_REQUEST['post_id'])>0 ? $_REQUEST['post_id'] : '';
		
		//업데이트 체크
		$update = false;
		if( $row = $this->get_delivery_row($enter_id) ){
			//업데이트일경우
			$update = true;
		}
		
		$data['delivery_id']    = $delivery_id;
		$data['enter_id']       = $enter_id;
		$data['delivery_name']  = $delivery_name;
		$data['delivery_phone'] = $delivery_phone;
		$data['delivery_zip']   = $delivery_zip;
		$data['delivery_addr1'] = $delivery_addr1;
		$data['delivery_addr2'] = $delivery_addr2;
		$data['basic_YN']       = $basic_YN;
		$data['delivery_etc']   = $delivery_etc;
		//$data['rgst_date']      = current_time('mysql');
		$data['updt_date']      = current_time('mysql');
		
		$data2['ID']             = $ID;
		$data2['user_realname']  = $delivery_name;
		$data2['user_phone']     = $delivery_phone;
		$data2['user_zip']       = $delivery_zip;
		$data2['user_addr1']     = $delivery_addr1;
		$data2['user_addr2']     = $delivery_addr2;
			
		//기본정보 저장 체크 and 이미있는정보 => 배달업데이트, 기본정보 업데이트
		if( $update==true && $basic_YN =="Y" ){
			$wpdb->update($this->table, $data, compact('delivery_id'));
			$wpdb->update($this->table3, $data2, compact('ID'));

		//기본정보 저장 x and 이미있는정보 => 배달정보업데이트
		}else if( $update==true && $basic_YN =="N" ){
			$wpdb->update($this->table, $data, compact('delivery_id'));
		}

		$data['delivery_id']    = $delivery_id;
		$data['enter_id']       = $enter_id;
		$data['delivery_name']  = $delivery_name;
		$data['delivery_phone'] = $delivery_phone;
		$data['delivery_zip']   = $delivery_zip;
		$data['delivery_addr1'] = $delivery_addr1;
		$data['delivery_addr2'] = $delivery_addr2;
		$data['basic_YN']       = $basic_YN;
		$data['delivery_etc']   = $delivery_etc;
		$data['rgst_date']      = current_time('mysql');
		$data['updt_date']      = current_time('mysql');
		
		//기본정보 저장 체크 and 없는정보 => 배달정보저장, 기본정보 업데이트
		if( $update==false && $basic_YN =="Y" ){
			$wpdb->insert($this->table, $data);
			$wpdb->update($this->table3, $data2, compact('ID'));
			
		//기본정보 저장 x and 없는정보 =>
		}else if( $update==false && $basic_YN =="N" ){
			$wpdb->insert($this->table, $data);
		}
		
		$goback = wp_get_referer();
		$goback = remove_query_arg('eventdelivery-delivery_id', $goback);
		
		//저장후->이벤트페이지로 이동
		print "<script language=javascript> alert('저장되었습니다.'); location.replace('". get_permalink($post_id) ."'); </script>";
		//wp_redirect("http://selvitest.cafe24.com/mypage?enter_id=".$enter_id."#list" );
		
		exit;
	}
	
	//응모내역 정보 가져오는 함수
	function get_enter_row($user_id, $event_id, $enter_id){
		global $wpdb , $user_ID;
		
		$enter_row = null;
		$user_id = absint($user_id);
		
		if($event_id == ''){
			$event_id = "1=1";
		}else{
			$event_id = "event_id = $event_id";
		}
		
		if($enter_id == ''){
			$enter_id = "1=1";
		}else{
			$enter_id = "enter_id = $enter_id";
		}
		
		if( $user_id > 0 ){
			$sql = $wpdb->prepare("SELECT * FROM $this->table2 WHERE user_id=%d AND $event_id AND $enter_id", $user_id);
			$enter_row = $wpdb->get_row( $sql );
		}
		return $enter_row;
	}
	
	//회원 기본 정보 가져오는 함수
	function get_user_row($user_id){
		global $wpdb , $user_ID;
		
		$user_row = null;
		$user_id = absint($user_id);
		if( $user_id > 0 ){
			$sql = $wpdb->prepare("SELECT * FROM $this->table3 WHERE ID=%d", $user_id);
			$user_row = $wpdb->get_row( $sql );
		}
		return $user_row;
	}
	
	//응모 배달정보 가져오는 함수
	function get_delivery_row($enter_id){
		global $wpdb , $user_ID;
		
		$delivery_row = null;
		$enter_id = absint($enter_id);
		if( $enter_id > 0 ){
			$sql = $wpdb->prepare("SELECT * FROM $this->table WHERE enter_id=%d", $enter_id);
			$delivery_row = $wpdb->get_row( $sql );
		}
		return $delivery_row;
	}
	
	//+이벤트 정보 가져오는 함수
	function get_event_row($event_id){
		global $wpdb;
		
		$event_row = null;
		$event_id = absint($event_id);
		if( $event_id > 0 ){
			$sql = $wpdb->prepare("SELECT * FROM $this->table4 WHERE event_id=%d", $event_id);
			$event_row = $wpdb->get_row( $sql );
		}
		return $event_row;
	}
}?>