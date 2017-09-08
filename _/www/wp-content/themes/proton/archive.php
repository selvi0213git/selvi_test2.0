<?php get_header(); ?>
	<div class="page-title">
		<div class="row">
			<div class="col-md-9 col-xs-12">
				<h1><?php echo esc_attr__("All posts in this category.","proton") ?></h1>
			</div>
		</div>
	</div>
	<div class="portfolio">
		<div class="row portfolio-masonry">
			<?php
				$args = array_merge( $wp_query->query_vars, array(
					'post_type' => 'post'
				));
				$query = new WP_Query($args);

				if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
			?>
			<div class="col-md-4 col-sm-6 col-xs-12 selector">
				<div class="item-holder">
					<div class="item">
						<div class="overlay-background"></div>
						<div class="overlay">
							<div class="inner-overlay">
								<?php
									$proton_post_type = get_field("proton_post_type");
									if($proton_post_type == '3'){
										$proton_post_url = excerpt(50);
									}
									else {
										if($portfolio_gallery || $proton_portfolio_gallery){
											$proton_post_url = get_the_post_thumbnail_url();
										}
										else {
											$proton_post_url = get_permalink();
										}
									}
								?>
								<h3><a title="<?php the_title(); ?>" href="<?php echo esc_attr($proton_post_url) ?>"><?php the_title(); ?></a></h3>
								<span>
									<?php
										$proton_portfolio_categories_link = $options['proton_portfolio_categories_link'];
										if($proton_portfolio_categories_link){
											foreach((get_the_category()) as $category) { echo $category->cat_name . ' '; }
										}
										else {
											the_category(' ');
										}
									?>
								</span>
							</div>
						</div>
					</div>
					<?php
					if(has_post_thumbnail()){
						the_post_thumbnail();
					}
					else {
						echo '<img src="' . get_template_directory_uri() . '/assets/images/default.png" />';
					}
					?>
				</div>
			</div>
			<?php endwhile; endif; wp_reset_postdata(); ?>
		</div>
	</div>
<?php get_footer(); ?>
