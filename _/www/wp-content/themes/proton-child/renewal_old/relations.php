<?php 
/**
* [init]     
* [20170718] | 관련내역 리스트 최초생성                 | eley 
* ---------------------------------------------------
* [after]
*/
class relation_list {
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
		add_shortcode( 'relationlist', array($this, 'shortcode') );
		
		//액션등록 admin-post.php 참조
		add_action( 'admin_post_relationlist-post', array($this, 'post_request') );
		add_action( 'admin_post_nopriv_relationlist-post', array($this, 'post_request') );
	}
	
	//숏코드 실행
	function shortcode(){
		ob_start();
		?>
		<div id="event-list-outer">
			<!-- 리스트 실행 -->
			<?php $this->the_list(); ?>
		</div>
		<?php
		return ob_get_clean();
	}
	
	//fucntion : list loading
	function the_list(){
		global $user_id;
		//현재 유저 정보를 가져옴
		global $current_user;
		wp_get_current_user();
		$user_id = $current_user->ID;
		
		//포스트정보 가져옴
		$post_id = get_the_ID();
		
		//변수에 정보담음
		$relation_rows = $this->get_relation_rows($user_id, $post_id);
		
		//스크립트 변수설정을 위한 변수
		$i = 0;
		?>
		
		<!-- Title -->
		<!--<h3>Title</h3>-->
		
		<div class="event-list other-event-carousel">
		<?php foreach($relation_rows as $relation_row){ ?>
			
			<!-- value setting -->
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
			
			if(isset($relation_row)){
				//변수설정
				$post_id         = $relation_row->post_id;
				$event_end       = $relation_row->event_end;
				$event_prize     = $relation_row->event_prize;
				$event_all_prize = $relation_row->event_all_prize;
				$event_enter     = $relation_row->event_enter;
				$event_type      = $relation_row->event_type;

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
			?>
			

			<?php
				//썸네일 사진 가져옴
				$thumbnail_url = wp_get_attachment_url( get_post_thumbnail_id($post_id));
				
				//스크립트 변수설정을 위한 변수++
				$i++;
			?>
			<?php if($thumbnail_url != ''){ ?>
			<!--썸네일 있을때-->
				<img src='<?php echo $thumbnail_url?>'/>
			<?php } else { 
			//썸네일 없을때
					echo '<img src="' . get_template_directory_uri() . '/assets/images/default.png" />';
				  } ?>
			
		<?php } ?>
		</div><!-- /.event-list other-event-carousel -->
		
	<?php
	}

	//관련리스트 가져오는 함수
	function get_relation_rows($user_id, $post_id){
		global $wpdb , $user_id;
		$relation_rows = null;
		$relation_rows = $wpdb->get_results(
											"SELECT 
												$this->table2.*, 
												$this->table3.post_title 
											FROM 
												$this->table2, 
												$this->table3 
											WHERE 
												$this->table2.event_id not in (
													SELECT 
														$this->table2.event_id 
													FROM 
														$this->table, 
														$this->table2 
													WHERE 
														$this->table.user_id = $user_id
														AND $this->table2.event_id = $this->table.event_id
												) 
												AND $this->table2.post_id <> $post_id
												AND $this->table2.post_id = $this->table3.ID 
												AND sysdate() < $this->table2.event_end"
										);
		return $relation_rows;
	}
}?>