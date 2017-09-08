<?php
	get_header();
	$options = get_proton_options();
	if(have_posts()) : while(have_posts()) : the_post();
	if(get_field("proton_post_type") == '2') :

		// Layout
		$portfolio_item_layout = $options['portfolio_item_layout'];
		$proton_project_single_style = get_field("proton_project_single_style");
		$proton_project_single_style_content = "col-md-5 col-sm-12 col-xs-12";
		$proton_project_single_style_gallery = "col-md-6 col-md-offset-1 project-photos col-sm-12 col-xs-12";
		$proton_project_single_style_row = "row";

		if(!$proton_project_single_style){
			$proton_project_single_style = 1;
		}

		if($proton_project_single_style == '1'){
			$proton_project_single_style = $options['portfolio_item_layout'];
			$portfolio_item_layout = $proton_project_single_style;
		}
		else {
			$portfolio_item_layout = $proton_project_single_style - 1;
		}

		switch($portfolio_item_layout){
			case '2':
				$proton_project_single_style_content = "col-md-5 col-sm-12 pull-right";
				$proton_project_single_style_gallery = "col-md-7 project-photos col-sm-12";
			break;
			case '3':
				$proton_project_single_style_content = "col-md-12";
				$proton_project_single_style_gallery = "col-md-12 project-photos";
			break;
			case '4':
				$proton_project_single_style_content = "col-md-12 order-content";
				$proton_project_single_style_gallery = "col-md-12 project-photos order-gallery";
				$proton_project_single_style_row = "row order-single";
		}

		// Columns
		$portfolio_item_gallery_columns = $options['portfolio_item_gallery_columns'];
		$proton_project_gallery_columns = get_field("proton_project_gallery_columns");
		$proton_project_gallery_cols = "selector col-md-12";

		if(!$proton_project_gallery_columns){
			$proton_project_gallery_columns = 1;
		}

		if($proton_project_gallery_columns == '1'){
			$proton_project_gallery_columns = $options['portfolio_item_gallery_columns'];
			$portfolio_item_gallery_columns = $proton_project_gallery_columns;
		}
		else {
			$portfolio_item_gallery_columns = $proton_project_gallery_columns - 1;
		}

		switch($portfolio_item_gallery_columns){
			case '2':
				$proton_project_gallery_cols = "selector col-md-6 col-sm-6 col-xs-12";
				break;
			case '3':
				$proton_project_gallery_cols = "selector col-md-4 col-sm-6 col-xs-12";
				break;
		}

		// Hide category
		$portfolio_item_categories = $options['portfolio_item_categories'];

	?>
		<div class="project-single">
			<div class="<?php echo esc_attr($proton_project_single_style_row); ?>">
				<div class="<?php echo esc_attr($proton_project_single_style_content); ?>">
					<div class="single-info">
						<div class="project-description">
							<h3><?php the_title(); ?></h3>
							<?php if($portfolio_item_categories) :  ?>
								<span><?php the_category(' '); ?></span>
							<?php endif; ?>
							<?php the_content(); ?>
						</div>
					</div>
				</div>
				<div class="<?php echo esc_attr($proton_project_single_style_gallery); ?>">
					<?php
						// Embed Videos
						$proton_project_single_embed_video = get_field("proton_project_single_embed_video");
                        $portfolio_item_embed_position = $options['portfolio_item_embed_position'];
						if($proton_project_single_embed_video && $portfolio_item_embed_position == '1'){
							echo $proton_project_single_embed_video;
						}

						// Fancybox
						$portfolio_item_gallery = $options['portfolio_item_gallery'];
						$proton_portfolio_item_gallery = get_field("proton_portfolio_item_gallery");
						if($portfolio_item_gallery == true || $proton_portfolio_item_gallery){
							$project_single_gallery = "row portfolio-masonry project-single-gallery";
						}
						else {
							$project_single_gallery = "row portfolio-masonry";
						}
					?>
					<div class="<?php echo esc_attr($project_single_gallery); ?>">
						<?php if(have_rows("proton_project_single_gallery")) : while(have_rows("proton_project_single_gallery")) : the_row(); ?>
							<div class="<?php echo esc_attr($proton_project_gallery_cols); ?>">
								<?php
									$proton_project_single_gallery_img = get_sub_field("proton_project_single_gallery_img");
                                    $proton_project_single_gallery_description = get_sub_field("proton_project_single_gallery_description");
									if($portfolio_item_gallery || $proton_portfolio_item_gallery){
										$project_single_image_url = $proton_project_single_gallery_img['url'];
									}
									else {
										$project_single_gallery = "row portfolio-masonry";
										$project_single_image_url = "#";
									}
								?>
								<a title="<?php echo $proton_project_single_gallery_description; ?>" href="<?php echo esc_attr($project_single_image_url); ?>">
									<img src="<?php echo esc_url($proton_project_single_gallery_img['url']); ?>" alt="">
                                    <?php
                                        if($proton_project_single_gallery_description){
                                            echo "<h5>" . $proton_project_single_gallery_description . "</h5>";
                                        }
                                    ?>
								</a>
							</div>
						<?php endwhile; endif; ?>
					</div>
                    <?php
                        // Embed Video on bottom
                        if($proton_project_single_embed_video && $portfolio_item_embed_position == '2'){
                            echo $proton_project_single_embed_video;
                        }
                    ?>
				</div>
			</div>
			<?php if($options['portfolio_item_navigation']) : ?>
				<div class="single-navigation">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6 prev">
							<?php previous_post_link('%link',"<i class='fa fa-angle-left'></i><span>". esc_attr__("Previous Project", "proton") ."</span>", true); ?>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 next">
							<?php next_post_link('%link',"<span>". esc_attr__("Next Project", "proton") ."</span><i class='fa fa-angle-right'></i>", true); ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	<?php else : ?>
		<?php
			$proton_page_title = get_field("proton_page_title");
			if($proton_page_title) :
		?>
			<div class="page-title">
				<div class="row">
					<div class="col-md-12">
						<h1><?php echo $proton_page_title; ?></h1>
					</div>
				</div>
			</div>
		<?php
			endif;

			// Blog Single Layout Options
			$blog_single_layout = $options['blog_single_layout'];
			$blog_single_sidebar = $options['blog_single_sidebar'];
			$blog_single_layout_post = "col-md-9 col-sm-9 col-xs-12 blog-content";
			$blog_single_layout_sidebar = "col-md-3 col-sm-3 col-xs-12 sidebar";

			if($blog_single_layout == '2'){
				$blog_single_layout_post = "col-md-12 blog-content";
				$blog_single_layout_sidebar = "display-none";
			}

			switch($blog_single_sidebar){
				case '1':
					$blog_single_layout_post .= " pull-right";
					break;
				case '3':
					$blog_single_layout_sidebar .= " display-none";
					$blog_single_layout_post .= " col-lg-12";
					break;
			}

			// Blog Single Thumbnail & Author & Category & Post Date Options & Pagination
			$blog_single_thumbnail = $options['blog_single_thumbnail'];
			$blog_single_author_info = $options['blog_single_author_info'];
			$blog_single_categories = $options['blog_single_categories'];
			$blog_single_post_date = $options['blog_single_post_date'];
			$blog_single_next_previous = $options['blog_single_next_previous'];
		?>
		<div class="blog blog-single">
			<div class="row">
				<div class="<?php echo esc_attr($blog_single_layout_post) ?>">
					<div class="blog-post">
						<div class="blog-img">
							<?php
								if(has_post_thumbnail() && $blog_single_thumbnail){
									the_post_thumbnail();
								}
							?>
						</div>
						<div class="blog-info">
							<h2><?php the_title(); ?></h2>
							<ul class="post-info">
								<?php if($blog_single_author_info) : ?>
									<li><?php echo esc_attr__("by", "proton") ?> <?php the_author_posts_link(); ?></li>
								<?php
									endif;
									if($blog_single_categories) :
								?>
								<li><?php echo esc_attr__("in", "proton") ?> <?php the_category(' '); ?></li>
								<?php
									endif;
									if($blog_single_post_date) :
								?>
								<li><?php echo esc_attr__("posted", "proton") ?> <span><?php the_time('F j, Y'); ?></span></li>
								<?php endif; ?>
							</ul>
							<?php the_content(); ?>
							<?php if($blog_single_next_previous) : ?>
								<div class="single-navigation">
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-6 prev">
											<?php previous_post_link('%link',"<i class='fa fa-angle-left'></i><span>". esc_attr__("Previous Post", "proton") ."</span>", true); ?>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-6 next">
											<?php next_post_link('%link',"<span>". esc_attr__("Next Post", "proton") ."</span><i class='fa fa-angle-right'></i>", true); ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<?php comments_template(); ?>
				</div>
				<div class="<?php echo esc_attr($blog_single_layout_sidebar); ?>">
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php
	endwhile; endif;
	get_footer();
?>
