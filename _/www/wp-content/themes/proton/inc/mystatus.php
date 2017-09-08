<?php 
/*
Author: Taehan Lee
Author URI: http://biscuitpress.kr/503
License: GPLv2 or later
*/
 
class MY_Status {
	function __construct(){
		global $wpdb;
		$this->table = $wpdb->prefix . 'z_mystatus';
		add_shortcode( 'mystatus', array($this, 'shortcode') );
		add_action( 'admin_post_mystatus-post', array($this, 'post_request') );
		add_action( 'admin_post_mystatus-delete', array($this, 'delete_request') );
		add_action( 'admin_post_nopriv_mystatus-post', array($this, 'post_request') );
	}

	function shortcode(){
		ob_start();
		?>
		<div id="mystatus">
			<?php $this->the_form(); ?>
			<?php $this->the_list(); ?>
		</div>
		<?php
		return ob_get_clean();
	}
	
	function the_form(){
		// if( ! is_user_logged_in() )
		//	return;
		
		$ID = isset($_GET['mystatus-ID']) ? $_GET['mystatus-ID'] : '';
		$content = '';
		$submit_label = '올리기';
		$update = false;
		if( $row = $this->get_row( $ID ) ){
			extract($row);
			$update = true;
			$submit_label = '수정';
		}
		?>
		
		<form id="mystatus-form" action="<?=admin_url('admin-post.php')?>" method="post">
			<?php wp_nonce_field('mystatus', 'mystatus_nonce'); ?>
			<input type="hidden" name="action" value="mystatus-post">
			<input type="hidden" name="ID" value="<?php echo $ID;?>">
			<p>
				<textarea name="content" rows="5"><?php echo esc_textarea($content); ?></textarea>

				<input name="post_id" value="<?php echo $post_id = the_ID() ?>" />
			</p>
			<p>
				<input type="submit" value="<?=$submit_label?>">
				<?php if( $update ){ ?>
				<a href="<?php echo remove_query_arg('mystatus-ID')?>" class="cancel">취소</a>
				<?php } ?>
			</p>
		</form>
		
		<?php
	}
	
	function the_list(){
		global $user_ID;
		
		$rows = $this->get_rows();
		if( empty($rows) )
			return;
		?>
		<div id="mystatus-list">
			<?php foreach($rows as $row){ ?>
			<div class="item">
				<div class="content">
					<?php echo apply_filters('comment_text', $row->content); ?>
				</div>
				<div class="meta">
					<span class="date"><?php echo human_time_diff( strtotime($row->post_date), current_time('timestamp') ); ?>전</span>
					<?php if( $row->user_id == $user_ID ){ ?>
					<span class="sep">|</span>
					<a href="<?php echo add_query_arg('mystatus-ID', $row->ID)?>" class="edit">수정</a>
					<span class="sep">|</span>
					<a href="<?php echo admin_url('admin-post.php?action=mystatus-delete&ID='.$row->ID.'&mystatus_nonce='.wp_create_nonce('mystatus'))?>" class="delete">삭제</a>
					<?php  } ?>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php
	}
	
	function post_request(){
		global $wpdb, $user_ID;
		echo wp_verify_nonce($_REQUEST['mystatus_nonce'], 'mystatus');
		echo $_REQUEST['mystatus_nonce'];
		if( //! is_user_logged_in()|| 
			! isset($_REQUEST['mystatus_nonce'])
			|| ! wp_verify_nonce($_REQUEST['mystatus_nonce'], 'mystatus') )
			return;
		echo wp_verify_nonce($_REQUEST['mystatus_nonce'], 'mystatus');
		$ID = absint($_REQUEST['ID'])>0 ? $_REQUEST['ID'] : null;
		
		$content = trim($_REQUEST['content']);
		$content = apply_filters('pre_comment_content', $content);
		
		if( empty($content) ){
			wp_die( '내용을 입력하세요.' );
		}
		
		$update = false;
		if( $row = $this->get_row( $ID ) )
			$update = true;
		
		$data = array('content' => $content);
		
		if( $update ){
			$wpdb->update($this->table, $data, compact('ID'));
			
		}else{
			$data['user_id'] = $user_ID;
			$data['post_date'] = current_time('mysql');
			$wpdb->insert($this->table, $data);
		}
		
		$goback = wp_get_referer();
		$goback = remove_query_arg('mystatus-ID', $goback);
		wp_redirect( $goback );
		exit;
	}
	
	function delete_request(){
		global $wpdb, $user_ID;
		
		if(// ! is_user_logged_in()|| 
			 ! isset($_REQUEST['mystatus_nonce'])
			|| ! wp_verify_nonce($_REQUEST['mystatus_nonce'], 'mystatus') )
			return;
		
		$ID = absint($_REQUEST['ID'])>0 ? $_REQUEST['ID'] : null;
		
		if( $row = $this->get_row( $ID ) )
			$wpdb->query( $wpdb->prepare("DELETE FROM $this->table WHERE ID=%d", $ID) );
		
		$goback = wp_get_referer();
		$goback = remove_query_arg('mystatus-ID', $goback);
		wp_redirect( $goback );
		exit;
	}
	
	function get_rows($limit=10){
		global $wpdb;
		
		$sql = $wpdb->prepare("SELECT * FROM $this->table ORDER BY post_date DESC LIMIT %d", $limit);
		$rows = $wpdb->get_results( $sql );
		return $rows;
	}
	
	function get_row($ID){
		global $wpdb, $user_ID;
		
		$row = null;
		$ID = absint($ID);
		if( $ID > 0 && $user_ID > 0 ){
			$sql = $wpdb->prepare("SELECT * FROM $this->table WHERE user_id=%d AND ID=%d", $user_ID, $ID);
			$row = $wpdb->get_row( $sql, ARRAY_A );
		}
		return $row;
	}
	
}
