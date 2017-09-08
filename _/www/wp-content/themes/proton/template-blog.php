<?php
	/* Template Name: Blog */
	get_header();
	$options = get_proton_options();

		// Page Title
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
	<?php endif; ?>
	<div class="blog">
		<?php
			// Blog Creative Opacity
			$proton_blog_creative_opacity = get_field("proton_blog_creative_opacity");
			if($proton_blog_creative_opacity){
				echo "<style>.wrapper .blog-grid .blog-post .blog-info {background-color: rgba(211, 211, 211, ". $proton_blog_creative_opacity .")}</style>";
			}

			// Blog Layout
			$proton_blog_layout = get_field("proton_blog_layout");
			$blog_layout = $options['blog_layout'];
			$blog_pagination_position = $options['blog_pagination_position'];
			$proton_blog_bool = false;
			$proton_blog_info = "blog-info";
			$proton_blog_img = "blog-img";
			$proton_blog_post_category = "";
			$proton_blog_content = "col-md-9 col-sm-9 col-xs-12 blog-content";
			$proton_blog_post = "blog-post";
			$proton_blog_sidebar = "col-md-3 col-sm-3 col-xs-12 sidebar";

			// Blog Layout
			if(!$proton_blog_layout){
				$proton_blog_layout = 1;
			}

			if($proton_blog_layout == '1'){
				$proton_blog_layout = $options['blog_layout'];
				$blog_layout = $proton_blog_layout;
			}
			else {
				$blog_layout = $proton_blog_layout - 1;
			}

			switch($blog_layout){
				case '2':
					$proton_blog_content = "col-md-12 blog-content";
					$proton_blog_sidebar = "display-none";
				break;
				case '3':
					$proton_blog_content = "blog-content portfolio-masonry";
					$proton_blog_post .= " col-md-6 col-sm-6 col-xs-12 selector";
					$proton_blog_sidebar = "display-none";
				break;
				case '4':
					$proton_blog_content .= " minimal-blog";
					$proton_blog_post .= " row";
					$proton_blog_img .= " col-md-5 col-sm-12";
					$proton_blog_info .= " col-md-7 col-sm-12";
				break;
				case '5':
					$proton_blog_content = "blog-grid blog-content portfolio-masonry creative-blog";
					$proton_blog_post .= " col-md-4 col-sm-6 col-xs-12 selector";
					$proton_blog_post_category = "display-none";
					$proton_blog_bool = true;
					$proton_blog_sidebar = "display-none";
				break;
			}

			// Sidebar Position
			$blog_sidebar = $options['blog_sidebar'];
			$proton_blog_position_sidebar = get_field("proton_blog_sidebar");

			if(!$proton_blog_position_sidebar){
				$proton_blog_position_sidebar = 1;
			}

			if($proton_blog_position_sidebar == '1'){
				$proton_blog_position_sidebar = $options['blog_sidebar'];
				$blog_sidebar = $proton_blog_position_sidebar;
			}
			else {
				$blog_sidebar = $proton_blog_position_sidebar - 1;
			}

			if($blog_sidebar == '1' && !strpos($proton_blog_sidebar, 'display-none')){
				$proton_blog_content .= " pull-right";
			}

			// Pagination Position
			$blog_pagination_position = $options['blog_pagination_position'];
			$blog_pagination_position_holder = "align-left";
			$proton_blog_pagination_position = get_field("proton_blog_pagination_position");

			if(!$proton_blog_pagination_position){
				$proton_blog_pagination_position = 1;
			}

			if($proton_blog_pagination_position == '1'){
				$proton_blog_pagination_position = $options['blog_pagination_position'];
				$blog_pagination_position = $proton_blog_pagination_position;
			}
			else {
				$blog_pagination_position = $proton_blog_pagination_position - 1;
			}

			switch($blog_pagination_position){
				case '2':
					$blog_pagination_position_holder = " align-center";
				break;
				case '3':
					$blog_pagination_position_holder = " align-right";
				break;
			}

			// Show Author/Categories/Post Date
			$proton_blog_author_info = get_field("proton_blog_author_info");
			$blog_author_info = $options["blog_author_info"];
			$proton_blog_show_categories = get_field("proton_blog_show_categories");
			$blog_show_categories = $options["blog_categories"];
			$proton_blog_show_post_date = get_field("proton_blog_show_post_date");
			$blog_show_post_date = $options["blog_post_date"];

		?>
		<div class="row">
			<div class="<?php echo esc_attr($proton_blog_content); ?>">
				<?php
					if(get_query_var('paged')) {
                        $paged = get_query_var('paged');
                    }
                    elseif(get_query_var('page')) {
                        $paged = get_query_var('page');
                    }
                    else {
                        $paged = 1;
                    }

                    $proton_blog_category = get_field("proton_blog_category");
                    $proton_blog_postperpage = get_field("proton_blog_ppp");

					// Blog Post Per Page
                    if($proton_blog_postperpage){
                    	$proton_blog_ppp = $proton_blog_postperpage;
                    }
                    else {
                    	$proton_blog_ppp = "5";
                    }

                    if(!empty($proton_blog_category)) :

                    $args = array(
						"post_type" => "post",
						"cat" => $proton_blog_category,
						"posts_per_page" => $proton_blog_ppp,
                    	'paged' => $paged
					);

               		$query = new WP_Query($args);

					if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
				?>
					<div id="post-<?php the_ID(); ?>" <?php post_class($proton_blog_post); ?>>
						<div class="blog-post-holder">
							<a class="permalink-creative" href="<?php the_permalink(); ?>"></a>
							<div class="<?php echo esc_attr($proton_blog_img); ?>">
								<a href="<?php the_permalink(); ?>">
									<?php
										if(has_post_thumbnail()){
											the_post_thumbnail();
										}
									?>
								</a>
							</div>
							<div class="<?php echo esc_attr($proton_blog_info); ?>">
								<h2>
									<?php if($proton_blog_bool) : ?>
										<?php the_title(); ?>
									<?php else : ?>
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									<?php endif; ?>
								</h2>
								<ul class="post-info">
									<?php if($proton_blog_author_info == true || $blog_author_info ) : ?>
										<li><?php echo esc_attr__("by", "proton"); ?>
											<?php
												if($proton_blog_bool == true){
													echo esc_attr(get_the_author());
												}
												else {
													the_author_posts_link();
												}
											?>
										</li>
									<?php
										endif;
										if($proton_blog_show_categories == true || $blog_show_categories ) :
									?>
									<li><?php echo esc_attr__("in", "proton"); ?>
										<?php
											if($proton_blog_bool == true){
												foreach((get_the_category()) as $category) { echo $category->cat_name . ' '; }
											}
											else {
												the_category(' ');
											}
										?>
									</li>
									<?php
										endif;
										if($proton_blog_show_post_date == true || $blog_show_post_date ) :
									?>
									<li class="<?php echo esc_attr($proton_blog_post_category); ?>"><?php echo esc_attr__("posted", "proton"); ?> <span><?php the_time('F j, Y'); ?></span></li>
									<?php endif; ?>
								</ul>
								<p>
									<?php
										if($proton_blog_bool == false){
											echo esc_attr(excerpt(33));
										}
									?>
								</p>
								<?php if($proton_blog_bool) : ?>
									<div class="button"><?php echo esc_attr__("Read More", "proton") ?></div>
								<?php else : ?>
									<a href="<?php the_permalink(); ?>" class="button"><?php echo esc_attr__("Read More", "proton") ?></a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endwhile; endif; wp_reset_postdata(); endif; ?>
			</div>
			<div class="<?php echo esc_attr($proton_blog_sidebar); ?>">
				<?php get_sidebar(); ?>
			</div>
		</div>
		<div class="<?php echo esc_attr($blog_pagination_position_holder); ?>">
			<?php proton_pagination($query->max_num_pages, "page-pagination", 999); ?>
		</div>
	</div>
<?php get_footer(); ?>
