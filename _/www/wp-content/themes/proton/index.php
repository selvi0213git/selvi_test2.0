<?php get_header(); ?>
	<div class="blog">
		<div class="row">
			<div class="col-md-9 col-sm-9 col-xs-12 blog-content">
                <?php
                    if(get_query_var('paged')){
                        $paged = get_query_var('paged');
                    }
                    elseif(get_query_var('page')){
                        $paged = get_query_var('page');
                    }
                    else {
                        $paged = 1;
                    }

                    $args = array(
                        'post_type' => 'post',
                        'paged' => $paged,
                    );

                    $query = new WP_Query($args);

                    if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
                 ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class("blog-post"); ?>>
						<div class="blog-post-holder">
							<div class="blog-img">
								<a href="<?php the_permalink(); ?>">
									<?php
										if(has_post_thumbnail()){
											the_post_thumbnail();
										}
									?>
								</a>
							</div>
							<div class="blog-info">
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<ul class="post-info">
									<li><?php echo esc_attr__("by", "proton"); ?> <?php echo esc_attr(get_the_author()); ?></li>
									<li><?php echo esc_attr__("in", "proton"); ?> <?php the_category(' '); ?></li>
									<li><?php echo esc_attr__("posted", "proton"); ?> <span><?php the_time('F j, Y'); ?></span></li>
								</ul>
								<p><?php echo esc_attr(excerpt(38)); ?></p>
								<a href="<?php the_permalink(); ?>" class="button"><?php echo esc_attr__("Read More", "proton") ?></a>
							</div>
						</div>
					</div>
				<?php endwhile; endif; wp_reset_postdata(); ?>
                <?php proton_pagination($query->max_num_pages, "page-pagination"); ?>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-12 sidebar">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
<?php get_footer(); ?>
