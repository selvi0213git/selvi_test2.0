	<!-- 페이스북 SDK 로그인 20170530 eley -->
		<script>
		//초기로딩   
		window.fbAsyncInit = function() {
			//페이스북 SDK초기화
			FB.init({appId: "1232110286912413", status: true, cookie: true ,xfbml: true, version: 'v2.9'});
			//페이스북 상태확인
			checkLoginState();	
		};  

		//페이스북 로그인 관련 SDK 로딩
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/ko_KR/sdk.js#xfbml=1&version=v2.9&appId=1232110286912413";
			fjs.parentNode.insertBefore(js, fjs);
			
		}(document, 'script', 'facebook-jssdk'));

		//페이스북 로그인 상태 확인관련 함수
		function checkLoginState() {
			FB.getLoginStatus(function(response) {
			    statusChangeCallback(response);
			});
		}

		//페이스북 상태 콜백 함수
		function statusChangeCallback(response) {
			console.log('statusChangeCallback');
			console.log(response);
			
			//연결 되었을때
			if (response.status === 'connected') {
				facebooklogin();
			//연결되지 않았을때
			} else {
				alert("안됨");
			}
		}

		//로그인 연결되었을때
		function facebooklogin() {  
			FB.login(function(response) {
				var fname;
				var fid;
				var faccessToken = response.authResponse.accessToken;
				//페이스북 api호출
				FB.api('/me', function(user) {
					fname = user.name;
					fid    = user.id;
					alert(fname+"아이디"+fid+"토큰"+faccessToken+"짠");
					
					
					jQuery.ajax({
						type : 'POST',
						url  : 'http://selvitest.cafe24.com/wp-content/themes/proton/inc/fbloginprocess.php',
						//'<?php echo admin_url('fbloginprocess.php')?>',
						data : {
							'fid' : 'fid',
							'fname' : 'fname',
							'faccessToken' : 'faccessToken'
						},
						dataType : "json",
						cach : false,
						success : function(data) {
							alert("좋앗어");
						},
						error : function(data) {
							alert("실패");
							return false;
						}
					});
					
				/**
				jQuery.post("http://selvitest.cafe24.com/wp-content/themes/proton/inc/fbloginprocess.php", { "fid": fid, "fname": fname, "faccessToken":faccessToken},  
				  function (responsephp) {  
					if(responsephp=="N"){
						alert("안됫어...");
					}else{
					  alert("됫어...");          
					}
				  });
				*/
				});
			}, {scope: 'public_profile,email'});
		}

		//로그아웃
		function facebooklogout() {
			FB.logout(function(response) {
			   // Person is now logged out
			});
		}
		
		</script>
		
		<!--페이스북 버튼-->
		<div class="fb-login-button" data-max-rows="1" data-size="medium" data-button-type="login_with" data-show-faces="false" data-auto-logout-link="true" data-use-continue-as="true" onlogin="checkLoginState();"></div>
		<!--<fb:login-button data-size="medium" data-button-type="login_with" data-show-faces="false" data-use-continue-as="true" scope="public_profile,email" onlogin="checkLoginState();">로그인</fb:login-button>
		<input type="button" onclick="facebooklogout()" value="로그아웃" />-->
		