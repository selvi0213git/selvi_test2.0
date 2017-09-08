<?php 
/**
* [init]     
* [20170629] | 마이페이지 정보 CRUD php파일 생성           | eley 
* ---------------------------------------------------
* [after]
* [20170703] | 마이페이지 view및 로직 생성                | eley 
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
			
			<style type="text/css">
			.tg-myinfo  {border-collapse:collapse;border-spacing:10;border:none;}
			.tg-myinfo  td{font-family:Arial, sans-serif;font-size:14px;padding:7px 3px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
			.tg-myinfo  td{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:7px 3px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
			.tg-myinfo .tg-myinfo-0wuw{font-weight:bold;background-color:#ffffff;color:#9b9b9b}
			.tg-myinfo .tg-myinfo-ahts{background-color:#ffffff;color:#9b9b9b;text-align:center}
			.tg-myinfo .tg-myinfo-pr3q{background-color:#ffffff;color:#9b9b9b}
			.tg-myinfo .tg-myinfo-cwl8{font-weight:bold;background-color:#ffffff;color:#9b9b9b;}
			.tg-myinfo .tg-myinfo-2i35{font-weight:bold;background-color:#ffffff;color:#9b9b9b}
			.tg-myinfo .tg-myinfo-0ql5{background-color:#ffffff;color:#9b9b9b;text-align:center}
			.tg-myinfo .tg-myinfo-jplj{background-color:#ffffff;color:#9b9b9b}
			.tg-myinfo .tg-myinfo-0hak{background-color:#ffffff;color:#9b9b9b;text-align:center}
			.tg-myinfo .tg-myinfo-0y0a{font-weight:bold;background-color:#ffffff;color:#9b9b9b;text-align:center;}
			
			input[type=text] { -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; border-width:thin; border-style:solid;}
			
			textarea { -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; }
			
			.btn-myinfo {
				background: #2990ff;
				background-image: -webkit-linear-gradient(top, #2990ff, #2990ff);
				background-image: -moz-linear-gradient(top, #2990ff, #2990ff);
				background-image: -ms-linear-gradient(top, #2990ff, #2990ff);
				background-image: -o-linear-gradient(top, #2990ff, #2990ff);
				background-image: linear-gradient(to bottom, #2990ff, #2990ff);
				-webkit-border-radius: 0;
				-moz-border-radius: 0;
				border-radius: 0px;
				font-weight:bold;
				font-family: Arial;
				color: #ffffff;
				font-size: 12px;
				padding: 3px 6px 3px 6px;
				text-decoration: none;
				border-width:thin; 
				border-style:solid;
			}
			
			.btn-myinfo:hover {
				color: #ffffff;
				background: #4ba1fc;
				background-image: -webkit-linear-gradient(top, #4ba1fc, #4ba1fc);
				background-image: -moz-linear-gradient(top, #4ba1fc, #4ba1fc);
				background-image: -ms-linear-gradient(top, #4ba1fc, #4ba1fc);
				background-image: -o-linear-gradient(top, #4ba1fc, #4ba1fc);
				background-image: linear-gradient(to bottom, #4ba1fc, #4ba1fc);
				text-decoration: none;
			}

			</style>

			<table class="tg-myinfo" style="undefined;table-layout: fixed; width: 100%">
			
			<colgroup>
				<col style="width: 10px">
				<col style="width: 10px">
				<col style="width: 10px">
			</colgroup>
			
			  <tr>
				<td class="tg-myinfo-0y0a" colspan="3"><image style="border: 1px solid #9b9b9b;border-radius: 7px;-moz-border-radius: 7px;-khtml-border-radius: 7px;-webkit-border-radius: 7px;" src="<?php echo $user_pic;?>"></td>
			  </tr>
			   <tr>
				<td class="tg-myinfo-jplj" colspan="3" style="text-align:center">Login by. <?php echo $user_by;?></td>
			  </tr>
			  <tr>
				<td class="tg-myinfo-cwl8">닉네임</td>
				<td class="tg-myinfo-jplj" colspan="2"><input type="text" id="user_nic" name="user_nic" value="<?php echo $user_nic;?>" style="width:100%;" placeholder="닉네임"/></td>
			  </tr>
			  <tr>
				<td class="tg-myinfo-cwl8">이름(실명)</td>
				<td class="tg-myinfo-pr3q" colspan="2"><input type="text" id="user_name" name="user_name" value="<?php echo $user_name;?>" style="width:100%;" placeholder="이름(실명)"/></td>
			  </tr>
			  <tr>
				<td class="tg-myinfo-cwl8">휴대전화</td>
				<td class="tg-myinfo-jplj" colspan="2"><input type="text" id="user_phone" name="user_phone" value="<?php echo $user_phone;?>" style="width:100%;" placeholder="휴대전화"/></td>
			  </tr>
			  <tr>
				<td class="tg-myinfo-cwl8">주소</td>
				<td class="tg-myinfo-pr3q">
					<div id="wrap" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0; position: absolute;">
						<img src="//t1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
					</div>
					<input type="text" onclick="sample3_execDaumPostcode()" id="user_addr1" name="user_addr1" class="d_form large" value="<?php echo $user_addr1;?>" style="width:100%;" placeholder="주소" readonly />
				</td>
				<td class="tg-myinfo-pr3q"><input type="text" id="user_addr2" name="user_addr2" value="<?php echo $user_addr2;?>" style="width:100%;" placeholder="상세주소"/></td>
			  </tr>
			  <tr>
				<td class="tg-myinfo-0y0a" colspan="3"><input type="button" class="btn-myinfo" id="myinfo_submit" value="프로필 저장" style="width:100%; text-align:center; background-color:#2990ff; color: #ffffff;"></td>
			  </tr>
			</table>
		
		</form>
		
		<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
		<script>
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
						document.getElementById('user_zip').value = data.zonecode; //5자리 새우편번호 사용
						document.getElementById('user_addr1').value = fullAddr;

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
		wp_redirect( $goback );
		exit;
		
	}

}?>