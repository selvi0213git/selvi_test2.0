<?php if(!defined('ABSPATH')) exit;?>
<?php
global $post;
$core = new Cosmosfarm_Comments_Core();
if(comments_open($post->ID)):
?>
<div id="comments" <?php comment_class('comments-area', null, $post->ID, true)?>>
	<!-- 코스모스팜 소셜댓글 시작 -->
	<div id="cosmosfarm-comments" data-plugin-id="<?php echo get_option('cosmosfarm_comments_plugin_id', '')?>" data-href="<?php echo get_permalink($post->ID)?>" data-width="100%" data-row="<?php echo get_option('cosmosfarm_comments_plugin_row', '10')?>" data-access-token="<?php echo $core->get_access_token()?>"><a href="http://www.cosmosfarm.com/plugin/comments">코스모스팜 소셜댓글</a></div>
	<!-- 코스모스팜 소셜댓글 종료 -->
</div>
<?php endif?>