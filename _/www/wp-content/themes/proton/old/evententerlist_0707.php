<?php 
/**
* [init]     
* [20170703] | 이벤트 응모내역 리스트 CRUD php파일 생성     | eley 
* ---------------------------------------------------
* [after]
* [20170704] | 이벤트 정보 가져오는 함수선언 및 데이터 뿌려줌    | eley 
*/
class event_enterlist {
	function __construct(){
		//편의를 위해 wordpress 테이블이름을 변수로 만들어줌
		global $wpdb;
		
		//이벤트 응모 테이블
		$this->table = $wpdb->prefix . 'event_enter';
		//이벤트 정보 테이블
		$this->table2 = $wpdb->prefix . 'event_info';
		//포스트 정보 테이블
		$this->table3 = $wpdb->prefix . 'posts';
		
		//숏코드 등록
		add_shortcode( 'evententerlist', array($this, 'shortcode') );
		
		//액션등록 admin-post.php 참조
		add_action( 'admin_post_evententerlist-post', array($this, 'post_request') );
		add_action( 'admin_post_nopriv_evententerlist-post', array($this, 'post_request') );
	}

	//숏코드 실행
	function shortcode(){
		ob_start();
		?>
		<div id="eventdelivery">
			<!-- 리스트 실행 -->
			<?php $this->the_list(); ?>
		</div>
		<?php
		return ob_get_clean();
	}
	
	//리스트 함수
	function the_list(){
		global $user_id;
		//현재 유저 정보를 가져옴
		global $current_user;
		wp_get_current_user();
		$user_id = $current_user->ID;
		
		//변수 초기화
		
		//페이지 관련 변수
		$view_page  = isset($_REQUEST['pageid']) ? $_REQUEST['pageid'] : 1;
		$total_page = 1;//$total_page = $enter_row->ENTER_COUNT;
		$limit_page = 5;
		
		//키워드 관련 변수
		$keyword = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
		
		//정렬 관련 변수
		$sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : '';
		
		//전달받은 응모아이디
		$s_enter_id = isset($_REQUEST['enter_id']) ? $_REQUEST['enter_id'] : '';
		
		$enter_row = $this->get_enter_row($user_id);
		$enter_rows = $this->get_enter_rows($user_id, $view_page, $limit_page, $keyword, $sort);
		
		//if( empty($enter_row) )
			//echo "<div align='center';><h3 style='color:#ffcb2f'>응모 내역이 존재하지 않습니다.</h3></div></script>";
			//return;
		
		?>
		<div id="evententer-list">
		<style type="text/css">
		.tg-enterlist  {border-collapse:collapse;border-spacing:0;}
		.tg-enterlist td{, sans-serif;font-size:14px;padding:7px 3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
		.tg-enterlist th{, sans-serif;font-size:14px;font-weight:normal;padding:7px 3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
		.tg-enterlist .tg-enterlist-hv75{font-align:center;background-color:#ffffff;color:#9b9b9b;text-align:center}
		.tg-enterlist .tg-enterlist-ahts{background-color:#ffffff;color:#9b9b9b;text-align:center}
		.tg-enterlist .tg-enterlist-frya{background-color:#ffffff;color:#9b9b9b}
		.tg-enterlist .tg-enterlist-0ql5{background-color:#ffffff;color:#9b9b9b;text-align:center;}
		.tg-enterlist .tg-enterlist-6z7r{font-weight:bold;font-size:14px;, Helvetica, sans-serif !important;;background-color:#c0c0c0;color:#9b9b9b;text-align:center;}
		
		.btn-enterlist {
			height: 26px;
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
		
		.btn-enterlist:hover {
			color: #ffffff;
			background: #4ba1fc;
			background-image: -webkit-linear-gradient(top, #4ba1fc, #4ba1fc);
			background-image: -moz-linear-gradient(top, #4ba1fc, #4ba1fc);
			background-image: -ms-linear-gradient(top, #4ba1fc, #4ba1fc);
			background-image: -o-linear-gradient(top, #4ba1fc, #4ba1fc);
			background-image: linear-gradient(to bottom, #4ba1fc, #4ba1fc);
			text-decoration: none;
		}
		.kboard-pagination { float: left; padding: 3px 0; width: 100%; }
		.kboard-pagination .kboard-pagination-pages { float: left; margin: 0; padding: 0; width: 100%; list-style: none; text-align: center; border: 0; }
		.kboard-pagination .kboard-pagination-pages li { display: inline-block; *display: inline; zoom: 1; margin: 0; padding: 0 1px; background: none; border: 0; list-style: none; }
		.kboard-pagination .kboard-pagination-pages li a { display: block; margin: 0; padding: 0 11px; height: 28px; line-height: 28px; font-size: 13px; color: #999999; text-decoration: none; border: 0; background-color: #f9f9f9; box-shadow: none; transition-duration: 0.3s; }
		.kboard-pagination .kboard-pagination-pages li:hover a,
		.kboard-pagination .kboard-pagination-pages li.active a { border: 0; color: white; background-color: #2990ff; }
		.kboard-pagination .kboard-pagination-pages li:before { display: none; }
		.kboard-pagination .kboard-pagination-pages li:after { display: none; }
		.kboard_style{ display: inline; margin: 0; padding: 0; width: auto; height: 26px; line-height: 26px; font-size: 14px; color:#9b9b9b; border-radius: 0; border: 1px solid #9b9b9b; background: white; vertical-align: middle; box-shadow: none; box-sizing: content-box; text-indent: 0; text-align: center;}
		.search_enterlist_div { float: left; padding: 3px 0; width: 100%; }
		.sort_enterlist_div {div style="float:right; width:30%; height:500px; background:#f00;"}
		</style>
		
		<table class="tg-enterlist" style="undefined;table-layout: fixed; width: 100%" frame="void">
		<input type="hidden" value="<?php echo $s_enter_id?>" id="test_hidden" name="test_hidden"/>
		
		<colgroup>
			<col style="width: 40px">
			<col style="width: 100%">
			<col style="width: 90px">
			<col style="width: 45px">
			<col style="width: 90px">
		</colgroup>
		
		  <tr>
			<th class="tg-enterlist-hv75" colspan="5">
			<!-- 검색창 -->
			<div class="search_enterlist_div">
				<input type="text" class="kboard_style" id="search_enterlist" name="search_enterlist" value="<?php echo $keyword?>" placeholder="이벤트명 검색"/>
				<input type="button" class="btn-enterlist" id="search_enterlist_btn" name="search_enterlist_btn" value="검색" style="width:50px; text-align:center; background-color:#2990ff; color: #ffffff;">
			</div>
			<!-- 정렬창 -->
			<div class="sort_enterlist_div" style="float:right">
				<select class="kboard_style" name="enterlist_sort" id="enterlist_sort" style="float:right;">
					<option value="date"<?php if($sort == 'date'):?>selected<?php endif?>>날짜순</option>
					<option value="status"<?php if($sort == 'status'):?>selected<?php endif?>>당첨순</option>
				</select>
			<div>
			</th>
		  </tr>
		  <tr>
			<td class="tg-enterlist-6z7r"><font style="color: #ffffff">번호</font></td>
			<td class="tg-enterlist-6z7r"><font style="color: #ffffff">이벤트명</font></td>
			<td class="tg-enterlist-6z7r"><font style="color: #ffffff">참여날짜</font></td>
			<td class="tg-enterlist-6z7r"><font style="color: #ffffff">당첨여부</font></td>
			<td class="tg-enterlist-6z7r"><font style="color: #ffffff">배송지 관리</font></td>
		  </tr>
			<?php foreach($enter_rows as $enter_row){ ?>
				<?php
				//변수초기화
				$enter_id = '';
				$event_id = '';
				$enter_user_id = '';
				$status = '';
				$rgst_date = '';
				$post_title = '';
				
				$status_text = '';
				$enter_date = '';
				
				//foreach문 값있을때
				if(isset($enter_row)){
				//변수설정
				$enter_id = isset($enter_row->enter_id) ? $enter_row->enter_id : '';
				$event_id = isset($enter_row->event_id) ? $enter_row->event_id : '';
				$enter_user_id  = isset($enter_row->user_id) ? $enter_row->user_id : '';
				$status    = isset($enter_row->status) ? $enter_row->status : '';
				$rgst_date = isset($enter_row->rgst_date) ? $enter_row->rgst_date : '';
				$post_title = isset($enter_row->post_title) ? $enter_row->post_title : '';
				
				//$post_row = $this->get_post_row($event_id);
						
				//if(isset($post_row)){
				//	$post_title = isset($post_row->post_title) ? $post_row->post_title : '';
				//}
				
				//당첨/비당첨 세팅
				if($status==1){
					$status_text = '당첨';
				}else if($status==0){
					$status_text = '꽝';
				}else{
					$status_text = '';
				}
					
				//참여날짜 세팅
				$enter_date = date("Y-m-d", strtotime( $rgst_date ) );
				?>
				
				 <tr>
					<td class="tg-enterlist-0ql5"><?php echo $enter_row->ROWNUM?></td>
					<td class="tg-enterlist-frya"><?php echo $post_title?></td>
					<td class="tg-enterlist-ahts"><?php echo $enter_date?></td>
					<td class="tg-enterlist-0ql5"><?php echo $status_text?></td>
					<td class="tg-enterlist-0ql5"><input type="button" class="btn-enterlist" id="from_delivery_btn" name="from_delivery_btn" value="확인 및 수정" 
						onclick="location.href='<?php echo add_query_arg('enter_id', $enter_row->enter_id)?>'" style="width:100%; text-align:center; background-color:#2990ff; color: #ffffff;"></td>
						<!--"location.href='<?php //echo add_query_arg('enter_id', $enter_row->enter_id)?>'"-->
						<!--javascript:open_delivery(<?php //echo $enter_row->enter_id?>)-->
						<!--PUM.open(1219)-->
				 </tr>
				 
				 <!--배달정보-->
				 <?php if($enter_row->enter_id == $s_enter_id){?>
				 <tr id="eventdelivery_row" name="eventdelivery_row">
					<td class="tg-enterlist-hv75" colspan="5">
						<?php echo do_shortcode('[eventdelivery]');?>
					</td>
				 </tr>
				 <?php } ?>
				 
				<?php } ?>
			<?php } ?>
			
				<tr>
					<th class="tg-enterlist-hv75" colspan="5">
					<!-- 페이징 시작 -->
					<div class="kboard-pagination">
						<ul class="kboard-pagination-pages">
							<?php 
								$total_page = isset($enter_row) ? $enter_row->ENTER_COUNT : 1;
								echo kboard_pagination($view_page, $total_page , $limit_page);
							?>
						</ul>
					</div>
					<!-- 페이징 끝 -->
					</th>
				</tr>
		</table>
		</div>
		
		<script>
		//검색창에서 엔터키누를때
		jQuery("#search_enterlist").keyup(function(e){
			if(e.keyCode == 13){
				search_keyword();
			}
		});

		//검색버튼 눌렀을때
		jQuery("#search_enterlist_btn").click(function (){search_keyword();});
		
		//정렬값 바뀌었을때
		jQuery("#enterlist_sort").change(function(){
			var sort = document.getElementById("enterlist_sort").value;
			var keyword = document.getElementById("search_enterlist").value;
			location.href="?pageid=1&sort="+sort+"&keyword="+keyword;
		});
		
		//배달정보 버튼 클릭했을때
		//jQuery("#from_delivery_btn").click(function(){
		//	var enter_id = "";
		//});
		
		//키워드 검색 함수
		function search_keyword(){
			var sort = document.getElementById("enterlist_sort").value;
			var keyword = document.getElementById("search_enterlist").value;
			location.href="?pageid=1&sort="+sort+"&keyword="+keyword;
		}
		
		//배송정보 오픈 함수
		function open_delivery(enter_id){
			alert(enter_id);
			location.href="?pageid=1&sort="+sort+"&keyword="+keyword+"enter_id="+enter_id;
			/*
			if(document.getElementById("hiddenlogin").style.display==""){
				document.getElementById("hiddenlogin").style.display="none";
			}else{
				document.getElementById("hiddenlogin").style.display="";  
			}
			*/
		}
		</script>
		<?php
	}
	
	//응모내역 정보리스트 가져오는 함수
	function get_enter_rows($user_id, $view_page, $limit_page, $keyword, $sort){
		global $wpdb , $user_id;
		$total = null;
		$enter_rows = null;
		$user_id = absint($user_id);
		
		//페이징
		$view_page = ($view_page-1)*$limit_page;
		
		//검색키워드
		if($keyword != ''){
			$keyword = "selvitest.$this->table3.post_title LIKE '%$keyword%'";
		}else{
			$keyword ='1=1';
		}
		
		//정렬
		if($sort != ''){
			if($sort == 'status'){
				$sort = "selvitest.$this->table.status DESC";
			}
			else if($sort == 'date'){
				$sort = "selvitest.$this->table.rgst_date DESC";
			}
		}else{
			$sort = "selvitest.$this->table.rgst_date DESC";
		}

		if( $user_id > 0 ){
			/** %d때문에 like가 적용안됨
			$sql = $wpdb->prepare("SELECT @ROWNUM := @ROWNUM + 1 AS ROWNUM
										  , $this->table.* 
									      ,(SELECT COUNT(*) 
										    FROM $this->table 
											WHERE user_id = $user_id)AS ENTER_COUNT
									FROM $this->table,(SELECT @ROWNUM := 0) R, $this->table2, $this->table3 
									WHERE user_id=%d 
									AND $this->table.event_id = $this->table2.event_id
									AND $this->table2.post_id = $this->table3.ID
									AND $this->table3.post_title LIKE $keyword
									ORDER BY rgst_date DESC LIMIT $view_page, $limit_page", $user_id);
			$enter_rows = $wpdb->get_results( $sql );
			*/
			
			$enter_rows = $wpdb->get_results("SELECT @ROWNUM := @ROWNUM + 1 AS ROWNUM ,A.* 
												FROM 
													(SELECT $this->table.* 
															,(SELECT COUNT(*) 
																FROM $this->table
																	 , $this->table2 
																	 , $this->table3
															   WHERE user_id=$user_id
																 AND $this->table.event_id = $this->table2.event_id
																 AND $keyword
																 AND $this->table2.post_id = $this->table3.ID
																 )AS ENTER_COUNT
															, $this->table3.post_title
													  FROM $this->table
														   , $this->table2 
														   , $this->table3
													 WHERE user_id=$user_id
													   AND $this->table.event_id = $this->table2.event_id
													   AND $keyword
													   AND $this->table2.post_id = $this->table3.ID
											         ORDER BY $sort
												     LIMIT $view_page, $limit_page
													) A
												,(select @ROWNUM := $view_page)R"
											);
		}
		return $enter_rows;
	}
	/*
		public function init(){
		global $wpdb;
		$this->total = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}kboard_board_content` WHERE 1");
		$this->resource = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}kboard_board_content` WHERE 1 ORDER BY `date` DESC LIMIT ".($this->page-1)*$this->rpp.",$this->rpp");
		$this->index = $this->total;
		return $this;
		}
		public function initWithKeyword($keyword=''){
		global $wpdb;
		if($keyword){
			$keyword = esc_sql($keyword);
			$where = "`board_name` LIKE '%$keyword%'";
		}
		else{
			$where = '1';
		}
		$this->total = $wpdb->get_var("SELECT COUNT(*) FROM `{$wpdb->prefix}kboard_board_setting` WHERE $where");
		$this->resource = $wpdb->get_results("SELECT * FROM `{$wpdb->prefix}kboard_board_setting` WHERE $where ORDER BY `uid` DESC LIMIT ".($this->page-1)*$this->rpp.",$this->rpp");
		return $this;
		}
	
	public function getSorting(){
		if(self::$kboard_list_sort){
			return self::$kboard_list_sort;
		}

		self::$kboard_list_sort = isset($_COOKIE["kboard_list_sort_{$this->board_id}"])?$_COOKIE["kboard_list_sort_{$this->board_id}"]:$this->getDefaultSorting();
		self::$kboard_list_sort = isset($_SESSION["kboard_list_sort_{$this->board_id}"])?$_SESSION["kboard_list_sort_{$this->board_id}"]:self::$kboard_list_sort;
		self::$kboard_list_sort = isset($_GET['kboard_list_sort'])?$_GET['kboard_list_sort']:self::$kboard_list_sort;

		if(!in_array(self::$kboard_list_sort, array('newest', 'best', 'viewed', 'updated'))){
			self::$kboard_list_sort = $this->getDefaultSorting();
		}

		$_SESSION["kboard_list_sort_{$this->board_id}"] = self::$kboard_list_sort;

		return self::$kboard_list_sort;
	}

	public function setSorting($sort){
		if($sort == 'newest'){
			// 최신순서
			self::$kboard_list_sort = $sort;
		}
		else if($sort == 'best'){
			// 추천순서
			self::$kboard_list_sort = $sort;
		}
		else if($sort == 'viewed'){
			// 조회순서
			self::$kboard_list_sort = $sort;
		}
		else if($sort == 'updated'){
			// 업데이트순서
			self::$kboard_list_sort = $sort;
		}
	}
	
		public function getDefaultSorting(){
		return apply_filters('kboard_list_default_sorting', 'newest', $this->board_id, $this);
	}
	*/
	
	//응모내역 정보 가져오는 함수
	function get_enter_row($user_id){
		global $wpdb , $user_ID;
		
		$enter_row = null;
		$user_id = absint($user_id);
		if( $user_id > 0 ){
			$sql = $wpdb->prepare("SELECT * FROM $this->table WHERE user_id=%d", $user_id);
			$enter_row = $wpdb->get_row( $sql );
		}
		return $enter_row;
	}
	
	//이벤트중인 포스트 가져오는 함수
	/*
	function get_post_row($event_id){
		global $wpdb , $user_ID;
		
		$post_row = null;
		$event_row = null;
		
		$event_id = absint($event_id);
		if( $event_id > 0 ){
			$sql = $wpdb->prepare("SELECT * FROM $this->table2 WHERE event_id=%d", $event_id);
			$event_row = $wpdb->get_row( $sql );
		}
		
		if(isset($event_row)){
			$post_id = $event_row->post_id;
			
			if( $post_id > 0 ){
				$sql = $wpdb->prepare("SELECT * FROM $this->table3 WHERE ID=%d", $post_id);
				$post_row = $wpdb->get_row( $sql );
				
				return $post_row;
			}
		}
	}
	*/
}?>