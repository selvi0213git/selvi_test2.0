<?php 
/**
* [init]     
* [20170629] | 마이페이지 정보 CRUD php파일 생성           | eley 
* ---------------------------------------------------
* [after]
* [20170703] | 마이페이지 view및 로직 생성                | eley 
*
* [RENEWAL]----------------------------------------------------------
* [20170804] | RENEWAL                            | eley 
*/

class my_info {
	function __construct(){
		//편의를 위해 wordpress 테이블이름을 변수로 만들어줌
		global $wpdb;
		//사용자 정보 테이블
		$this->table = $wpdb->prefix . 'users';
		
		//숏코드 등록
		add_shortcode( 'myinfo', array($this, 'shortcode') );
		
		//액션등록 admin-post.php 참조
		add_action( 'admin_post_myinfo-post', array($this, 'post_request') );
		add_action( 'admin_post_nopriv_myinfo-post', array($this, 'post_request') );
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
		//초기 필요한 변수세팅
		
		//현재 유저 정보를 가져옴
		global $current_user;
		wp_get_current_user();
		$user_id = $current_user->ID;
		$user_url_ck = ($user_id != 0) ? $current_user->user_url : '';
		
		//todo : 비로그인 유저 보여줄 화면 필요함
		
		//초기값 init
		$user_pic   = 'http://selvitest.cafe24.com/wp-content/uploads/2017/07/selvi_login.gif';
		$user_nic   = ($user_id != 0) ? $current_user->display_name : '';
		$user_name  = ($user_id != 0) ? $current_user->user_realname : '';
		$user_phone = ($user_id != 0) ? $current_user->user_phone : '';
		$user_addr1 = ($user_id != 0) ? $current_user->user_addr1 : '';
		$user_addr2 = ($user_id != 0) ? $current_user->user_addr2 : '';
		$user_zip   = ($user_id != 0) ? $current_user->user_zip : '';
		$user_by    = ($user_id != 0) ? $current_user->user_login : '';
		
		//이미지 세팅
		if($user_url_ck != ""){
			$facebook_ck = substr($user_url_ck,11,8);
			//페이스북유저일때
			if($facebook_ck=="facebook"){
				$user_pic   = 'http://graph.facebook.com/'.substr($user_url_ck,24, 30) .'/picture?type=large';
			}
		}
		?>
		<!--폼 구성-->
		<form id="myinfo-form" action="<?=admin_url('admin-post.php')?>" method="post">
			<?php wp_nonce_field('myinfo', 'myinfo_nonce'); ?>
			<input type="hidden" id="action" name="action" value="myinfo-post">
			<input type="hidden" id="user_zip" name="user_zip" value="<?php echo $user_zip;?>" />
			<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id;?>" />
			
			<!-- View -->
			<div class="form-frame">
				<!-- user info-->
				<div class="user-profile">
					<!-- profile image -->
					<div class="user-img">
						<image class="flex-img" src="<?php echo $user_pic;?>">
					</div>
					
					<!-- login information -->
					<p class="login-info">Login by. <?php echo $user_by;?></p>
				</div><!-- /.user-profile -->

				<!-- profile information -->
				<div class="form-list">
					<dl>
						<dt>닉네임</dt>
						<dd>
							<input type="text" class="input-text col-6" id="user_nic" name="user_nic" value="<?php echo $user_nic;?>"  placeholder="닉네임"/>
						</dd>
					</dl>
					<dl>
						<dt>이름(실명)</dt>
						<dd>
							<input type="text" class="input-text col-6" id="user_name" name="user_name" value="<?php echo $user_name;?>"  placeholder="이름(실명)"/>
						</dd>
					</dl>
					<dl class="">
						<dt>휴대폰('-'포함)</dt>
						<dd>
							<input type="text" class="input-text col-6" id="user_phone" name="user_phone" value="<?php echo $user_phone;?>"  placeholder="휴대전화"/>
						</dd>
					</dl>
					<dl class="field-addr">
						<dt>주소</dt>
						<dd>
							<!-- DAUM MAP API -->
							<div id="my_wrap" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0; position: absolute;">
								<img src="//t1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="my_foldDaumPostcode()" alt="접기 버튼">
							</div>
							<input type="text" class="input-text col-9" onclick="my_sample3_execDaumPostcode()" id="user_addr1" name="user_addr1" class="d_form large" value="<?php echo $user_addr1;?>" placeholder="주소" readonly />
							<input type="text" class="input-text col-9" id="user_addr2" name="user_addr2" value="<?php echo $user_addr2;?>" placeholder="상세주소"/>
						</dd>
					</dl>
				</div><!-- /.form-list -->

				<!-- Submit -->
				<div class="field-control">
					<input type="button" value="기본정보 저장" class="btn-univ" id="myinfo_submit">
				</div>
				
			</div><!-- /.form-frame -->
		
		</form>
		
		<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
		<script>
		<!-- 다음주소 api 시작-->
			// 우편번호 찾기 찾기 화면을 넣을 element
			var my_element_wrap = document.getElementById('my_wrap');

			function my_foldDaumPostcode() {
				// iframe을 넣은 element를 안보이게 한다.
				my_element_wrap.style.display = 'none';
			}

			function my_sample3_execDaumPostcode() {
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
						document.getElementById('user_zip').value = data.zonecode; //5자리 새우편번호 사용
						document.getElementById('user_addr1').value = fullAddr;

						// iframe을 넣은 element를 안보이게 한다.
						// (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
						my_element_wrap.style.display = 'none';

						// 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
						document.body.scrollTop = currentScroll;
					},
					// 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
					onresize : function(size) {
						my_element_wrap.style.height = size.height+'px';
					},
					width : '100%',
					height : '100%'
				}).embed(my_element_wrap);

				// iframe을 넣은 element를 보이게 한다.
				my_element_wrap.style.display = 'block';
			}
		<!-- 다음주소 api 끝-->
		
		//전화번호 체크함수
			function tel_check(str){
				var regTel = /^(01[016789]{1}|070|02|0[3-9]{1}[0-9]{1})-[0-9]{3,4}-[0-9]{4}$/;
				if(!regTel.test(str)) {
					return false;
				}
				return true;
			}
			
		//submit
		//저장버튼 클릭시
			jQuery("#myinfo_submit").click(function () {
				//validation
				//input box
				var user_nic      = document.getElementById("user_nic").value;
				var user_name     = document.getElementById("user_name").value;
				var user_phone    = document.getElementById("user_phone").value;
				var user_addr1    = document.getElementById("user_addr1").value;
				var user_addr2    = document.getElementById("user_addr2").value;
				
				if(user_nic==''){
					alert("닉네임을 입력해주세요");
					return;
				}
				if(user_name==''){
					alert("이름(실명)을 입력해주세요");
					return;
				}
				if(user_phone==''){
					alert("번호를('-'포함) 입력해주세요");
					return;
				}
				if(tel_check(user_phone)==false){
					alert("번호형식이 잘못되었습니다.\n올바른 번호를 입력해주세요");
					return;
				}
				if(user_addr1==''){
					alert("주소를 입력해주세요");
					return;
				}
				if(user_addr2==''){
					alert("상세주소를 입력해주세요");
					return;
				}
				
				//submit
				$('#myinfo-form').submit();
				
			});
		</script>

		<?php
	}
	
	//실질 데이터 요청 함수
	//admin-post.php->action->myinfo-post->post_request
	function post_request(){
		global $wpdb;

	if( ! isset($_REQUEST['myinfo_nonce'])
			|| ! wp_verify_nonce($_REQUEST['myinfo_nonce'], 'myinfo') )//nonce유효한지
			return;

		$ID           = absint($_REQUEST['user_id'])>0 ? $_REQUEST['user_id'] : '';
		$user_nic     = trim($_REQUEST['user_nic']);
		$user_name    = trim($_REQUEST['user_name']);
		$user_phone   = trim($_REQUEST['user_phone']);
		$user_addr1   = trim($_REQUEST['user_addr1']);
		$user_addr2   = trim($_REQUEST['user_addr2']);
		$user_zip     = trim($_REQUEST['user_zip']);
		
		$data['ID']             = $ID;
		$data['display_name']   = $user_nic;
		$data['user_realname']  = $user_name;
		$data['user_phone']     = $user_phone;
		$data['user_zip']       = $user_zip;
		$data['user_addr1']     = $user_addr1;
		$data['user_addr2']     = $user_addr2;
			
		$wpdb->update($this->table, $data, compact('ID'));

		$goback = wp_get_referer();
		$goback = remove_query_arg('myinfo-ID', $goback);
		
		print "<script language=javascript> alert('저장되었습니다.'); location.replace('".$goback."'); </script>";
		//wp_redirect( $goback );
		exit;
		
	}

}?>