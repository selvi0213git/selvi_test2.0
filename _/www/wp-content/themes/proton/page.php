<?php get_header(); ?>
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
	<div class="blog blog-single">
		<div class="row">
			<?php
				$proton_page_layout = get_field("proton_page_layout");
				$page_content = "col-md-12 col-sm-12 col-xs-12 blog-content";
				$page_sidebar = "display-none";

				if($proton_page_layout == '2'){
					$page_content = "col-md-9 col-sm-9 col-xs-12 blog-content";
					$page_sidebar = "col-md-3 col-sm-3 col-xs-12 sidebar";
				}
			?>
			<div class="<?php echo esc_attr($page_content); ?>">
				<div class="blog-post">
					<div class="blog-info">
						<h2><?php the_title(); ?></h2>
						<?php
							the_content();
							wp_link_pages( $args );
							previous_posts_link();
							posts_nav_link();
						?>
					</div>
				</div>
				<?php comments_template(); ?>
			</div>
			<div class="<?php echo esc_attr($page_sidebar); ?>">
				<?php
					if(is_active_sidebar('sidebar-1')){
						dynamic_sidebar('sidebar-1');
					}
				?>
			</div>
		</div>
	</div>
	<?php endwhile; endif; ?>
<?php get_footer(); ?>
