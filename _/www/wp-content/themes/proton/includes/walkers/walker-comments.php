<?php
	class comment_walker extends Walker_Comment {

		var $tree_type = 'comment';
		var $db_fields = array( 'parent' => 'comment_parent', 'id' => 'comment_ID' );

		// constructor – wrapper for the comments list

		function __construct() { ?>

		<div class="col-md-12">

		<?php }

		// start_lvl – wrapper for child comments list

		function start_lvl( &$output, $depth = 0, $args = array() ) {

			$GLOBALS['comment_depth'] = $depth + 2; ?>

			<section class="child-comments comments-list">

		<?php }

		// end_lvl – closing wrapper for child comments list

		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; ?>
			
			</section>
		<?php }
		// start_el – HTML for comment template

		function start_el( &$output, $comment, $depth = 0, $args = Array(), $id = 0 ) {

			$depth++;
			$GLOBALS['comment_depth'] = $depth;
			$GLOBALS['comment'] = $comment;
			$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' ); 

			if ( 'article' == $args['style'] ) {
				$tag = 'article';
				$add_below = 'comment';
			} 
			else {
				$tag = 'article';
				$add_below = 'comment';
			} 
		?>
		<ul class="comments-list">
			<li class="comments comment-line" <?php comment_class("single-comment clearfix col-md-12", empty( $args['has_children'] ) ? '' :'parent') ?> id="comment-<?php comment_ID() ?>" itemscope itemtype="http://schema.org/Comment"> 
				<div class="row">
					<div class="comment col-md-12">
						<div class="pic">
							<?php echo get_avatar( $comment, 65 ); ?>
						</div>
						<div class="comment-content">
							<h4><?php comment_author(); ?></h4>
							<span><?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?></span>
							<p><?php comment_text() ?></p>
						</div>
					</div>
				</div>
			</li>
		<?php }
		// end_el – closing HTML for comment template
		function end_el(&$output, $comment, $depth = 0, $args = array() ) { ?>
		</ul>
		<?php }
		// destructor – closing wrapper for the comments list
		function __destruct() { ?>
 		</div>
		<?php }
	}
?>