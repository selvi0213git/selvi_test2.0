<?php
if(!function_exists('kboard_ocean_rating_like')){
	add_action('wp_ajax_kboard_ocean_rating_like', 'kboard_ocean_rating_like');
	add_action('wp_ajax_nopriv_kboard_ocean_rating_like', 'kboard_ocean_rating_like');
	function kboard_ocean_rating_like(){
		global $wpdb;
		if(isset($_POST['document_uid']) && intval($_POST['document_uid'])){
			if(!@in_array($_POST['document_uid'], $_SESSION['kboard_ocean_rating_like'])){
				$_SESSION['kboard_ocean_rating_like'][] = $_POST['document_uid'];
				$content = new KBContent();
				$content->initWithUID($_POST['document_uid']);
				$content->like+=1;
				if($content->uid) $wpdb->query("UPDATE `{$wpdb->prefix}kboard_board_content` SET `like`='{$content->like}' WHERE `uid`='$content->uid'");
				echo $content->like;
				exit;
			}
			echo '';
			exit;
		}
		exit;
	}
}
?>