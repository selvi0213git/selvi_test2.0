<?php

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments">

	<?php if ( have_comments() ) : ?>

	<h3><?php echo esc_attr__("Comments","proton") ?></h3>

	<?php get_template_part("includes/walkers/walker-comments"); ?>

	<?php
		wp_list_comments( array(
			'short_ping' => true,
			'avatar_size'=> 34,
			'max_depth'  => 1,
			'walker'     => new comment_walker
		) );
	?>

	<?php endif; ?>

	<div class="row">
		<div class="col-md-12">
			<?php if (comments_open() ) : ?>
				<h3 style="margin-top: 45px;"><?php esc_attr__("Write a comment","proton"); ?></h3>
			<?php endif; ?>
		</div>
	</div>

	<?php
		$fields =  array(
			'<div class="form row">',
			'author' =>
			'<div class="col-md-4">
				<input type="text" id="author" name="author" placeholder="Name">
			</div>',

			'email' =>
			'<div class="col-md-4">
				<input type="email" id="email" name="email" placeholder="Email">
			</div>',

			'website' =>
			'<div class="col-md-4">
				<input type="text" id="website" name="website" placeholder="Website">
			</div>',
			'</div>'
		);
		$args = array(
				'fields' => apply_filters( 'comment_form_default_fields', $fields ),
				'comment_field' => '<div class="form row" style="margin-top:0;"><div class="col-md-12"><textarea id="comment" name="comment" placeholder="Your comment"></textarea></div></div>',
				'title_reply' => '',
				'title_reply_to' => '',
				'label_submit' => 'Post Comment'
			);
	?>
	<div class="comment-form">
		<?php comment_form($args); ?>
	</div>
</div><!-- #comments -->

<div class="hidden">
	<?php paginate_comments_links(); ?>
</div>
