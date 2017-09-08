<?php 
/**
* [init]     
* [20170718] | 관리자 컨트롤 페이지 생성               | eley 
* ---------------------------------------------------
* [after]
*/
class admin_control {
	function __construct(){
		//숏코드 등록
		add_shortcode( 'admincontrol', array($this, 'shortcode') );
	}

	//숏코드 실행
	function shortcode(){
		ob_start();
		?>
		<div id="admincontrol">
			<!-- 폼 실행 -->
			<?php $this->admin_form();?>
		</div>
		<?php
		return ob_get_clean();
	}
	
	//관리자 폼 생성함수
	function admin_form(){
		?>
		<!-- 관리자 서브메뉴(고정) -->
		<div id=admin_submenu >
		<script>
			function click_sub(admin_menu){
				var admin_menu = admin_menu;

				if(admin_menu == 'info'){
					window.location.href= "/admin_info";
				}else if(admin_menu == 'event'){
					window.location.href= "http://selvitest.cafe24.com/";
				}else if(admin_menu == 'ad'){
					window.location.href= "http://selvitest.cafe24.com/wp-admin/admin.php?page=metaslider";
				}else if(admin_menu == 'list'){
					window.location.href= "/admin_list";
				}else if(admin_menu == 'statistics'){
					window.location.href= "/admin_statistics";
				}else{
					alert("준비중입니다!");
				}
			}
		</script>
		
		<style type="text/css">
		.tg  {border-collapse:collapse;border-spacing:0;border:none;}
		.tg td{font-family:Arial, sans-serif;font-size:20px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
		.tg th{font-family:Arial, sans-serif;font-size:20px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
		.tg .tg-vdcs{font-weight:bold;font-size:20px;font-family:Arial, Helvetica, sans-serif !important;;background-color:#f2c701;color:#ffffff;text-align:center}
		.tg .tg-9dar{font-weight:bold;font-size:20px;font-family:Arial, Helvetica, sans-serif !important;;background-color:#33b5cb;color:#ffffff;text-align:center}
		.tg .tg-vfmm{font-weight:bold;font-size:20px;font-family:Arial, Helvetica, sans-serif !important;;background-color:#f26917;color:#ffffff;text-align:center}
		.tg .tg-xu6e{font-weight:bold;font-size:20px;font-family:Arial, Helvetica, sans-serif !important;;background-color:#883bfd;color:#ffffff;text-align:center;}
		.tg .tg-ad{font-weight:bold;font-size:20px;font-family:Arial, Helvetica, sans-serif !important;;background-color:#00d856;color:#ffffff;text-align:center;}
		
		.tg .tg-vdcs:hover { background-color: lightgray; }
		.tg .tg-9dar:hover { background-color: lightgray; }
		.tg .tg-vfmm:hover { background-color: lightgray; }
		.tg .tg-xu6e:hover { background-color: lightgray; }
		.tg .tg-ad:hover { background-color: lightgray; }
		</style>
		<center>
		<table class="tg" style="undefined;table-layout: fixed; height : 45%; width: 100%;">
		  <tr>
			<th class="tg-9dar" onclick="javascript:click_sub('info')"  >관리자<br>정보관리</th>
			<th class="tg-ad" onclick="javascript:click_sub('ad')" >메인배너<br>관리</th>
			<th class="tg-vdcs" onclick="javascript:click_sub('event')" >이벤트<br>관리</th>
			<th class="tg-vfmm" onclick="javascript:click_sub('list')" >리스트<br>관리</th>
			<th class="tg-xu6e" onclick="javascript:click_sub('statistics')" >통계<br>관리</th>
		  </tr>
		</table>
		</center>
		</div>
		<?php
	}
}?>