<?php 
/**
* [init]     
* [20170707] |  마이페이지 php파일 생성           | eley 
* ---------------------------------------------------
* [after]
*/
class mypage {
	function __construct(){
		//숏코드 등록
		add_shortcode( 'mypage', array($this, 'shortcode') );
	}

	//숏코드 실행
	function shortcode(){
		ob_start();
		?>
		<div id="mypage">
			<h2><strong>내 정보 관리</strong></h2>
			<?php echo do_shortcode('[myinfo]');?>
			&nbsp;
			<span id="list"></span>
			<h2><strong>응모내역 &amp; 당첨내역</strong></h2>
			<?php echo do_shortcode('[evententerlist]');?>
		</div>
		<?php
		return ob_get_clean();
	}
	
	
}?>