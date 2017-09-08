<?php
	/* Template Name: Portfolio */
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
	<?php
		endif;
		if(have_posts()) : while(have_posts()) : the_post();
	?>
	<div class="portfolio">
		<?php
			// The content of Page
			the_content();

			// Filters
			$proton_enable_filters = get_field("proton_portfolio_filters");
			$proton_filters = get_field("proton_portfolio_filter_tags");

			if($proton_enable_filters && $proton_filters) :
		?>
		<div class="filters">
			<span><?php echo esc_attr__("Filters:", "proton"); ?></span>
			<ul id="filters">
				<li class="active" data-filter="*"><?php echo esc_attr__("All", "proton"); ?></li>
				<?php foreach($proton_filters as $filter) : ?>
					<li data-filter=".<?php echo esc_attr($filter->slug); ?>"><?php echo esc_attr($filter->name); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
			endif;

			// Portfolio Style
			$proton_portfolio_style = get_field("proton_portfolio_style");
			if(!$proton_portfolio_style){
				$proton_portfolio_style = 1;
			}

			if($proton_portfolio_style == '1'){
				$proton_portfolio_style = $options['portfolio_style'];
				$portfolio_style = $proton_portfolio_style;
			}
			else {
				$portfolio_style = $proton_portfolio_style - 1;
			}

			// Portfolio Hover
			$proton_hover_style = get_field("proton_hover_style");
			if(!$proton_hover_style){
				$proton_hover_style = 1;
			}

			if($proton_hover_style == '1'){
				$proton_hover_style = $options['portfolio_hover'];
				$portfolio_hover = $proton_hover_style;
			}
			else {
				$portfolio_hover = $proton_hover_style - 1;
			}

			// Columns
			$proton_portfolio_layout_item = "col-md-4 col-sm-6 col-xs-12 selector";
			$proton_portfolio_columns = get_field("proton_portfolio_columns");
			$portfolio_columns = $options['portfolio_columns'];
			$proton_portfolio_masonry = get_field("proton_portfolio_masonry");

			if($proton_portfolio_columns == '1'){
				switch($portfolio_columns){
					case 'two':
						$proton_portfolio_layout_item = "col-md-6 col-sm-6 col-xs-12 selector";
					break;
					case 'four':
						$proton_portfolio_layout_item = "col-md-3 col-sm-6 col-xs-12 selector";
					break;
				}
			}
			else {
				switch($proton_portfolio_columns){
					case '2':
						$proton_portfolio_layout_item = "col-md-6 col-sm-6 col-xs-12 selector";
					break;
					case '4':
						$proton_portfolio_layout_item = "col-md-3 col-sm-6 col-xs-12 selector";
					break;
				}
			}

			// Text Position
			$proton_text_position_holder = "";
			$proton_text_position = get_field("proton_text_position");
			$portfolio_meta_position = $options['portfolio_meta_position'];

			if($proton_text_position != '1'){
				switch ($proton_text_position) {
					case '3':
					$proton_text_position_holder = "top-left-hover";
				break;
					case '4':
					$proton_text_position_holder = "top-right-hover";
				break;
					case '5':
					$proton_text_position_holder = "bottom-left-hover";
				break;
					case '6':
					$proton_text_position_holder = "bottom-right-hover";
				break;
				}
			}
			else {
				switch($portfolio_meta_position){
					case 'top-left':
					$proton_text_position_holder = "top-left-hover";
				break;
					case 'top-right':
					$proton_text_position_holder = "top-right-hover";
				break;
					case 'bottom-left':
					$proton_text_position_holder = "bottom-left-hover";
				break;
					case 'bottom-right':
					$proton_text_position_holder = "bottom-right-hover";
				break;
				}
			}

			// Hover Effect
			$proton_portfolio_hover_effect = get_field("proton_portfolio_hover_effect");
			$portfolio_hover_effect = $options['portfolio_hover_effect'];

			// Portfolio Masonry
			$proton_portfolio_masonry_row = "row portfolio-masonry";
			if($portfolio_style == '1' || $portfolio_style == '2'){
				if($portfolio_hover == '3' || $portfolio_hover == '6'){
					$proton_portfolio_masonry_row .= " active-gallery";
				}
			}
			if($portfolio_style == '3' || $portfolio_style == '4'){
				$proton_portfolio_masonry_row .= " meta-tags-holder";
			}
			if($portfolio_style == '2' || $portfolio_style == '4' || $portfolio_style == '6'){
				$proton_portfolio_masonry_row .= " no-space";
			}
			if($portfolio_hover_effect || $proton_portfolio_hover_effect == true){
				$proton_portfolio_masonry_row .= " hover-effect";
			}
			if($proton_text_position_holder){
				$proton_portfolio_masonry_row .= " $proton_text_position_holder";
			}
			if($portfolio_hover == '4' || $portfolio_hover == '5' || $portfolio_hover == '6'){
				$proton_portfolio_masonry_row .= " border-hover";
			}
		?>
		<div class="<?php echo esc_attr($proton_portfolio_masonry_row); ?>">
			<?php
				// Portfolio Category
				$proton_portfolio_category = get_field("proton_portfolio_category");

				// Portfolio Post Per Page
				$proton_portfolio_posts_per_page = get_field("proton_portfolio_posts_per_page");

				if($proton_portfolio_posts_per_page){
					$proton_portfolio_ppp = $proton_portfolio_posts_per_page;
				}
				else {
					$proton_portfolio_ppp = 9;
				}

				// Paged
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
					"post_type" => "post",
					"posts_per_page" => $proton_portfolio_ppp,
		         	'paged' => $paged,
					'cat' => $proton_portfolio_category
				);

	    		$query = new WP_Query($args);

				if($query->have_posts()) : while($query->have_posts()) : $query->the_post();

            	$proton_post_tags = get_the_tags();

				$proton_portfolio_layout_col = $proton_portfolio_layout_item;

				if($proton_post_tags){
					foreach($proton_post_tags as $tag) {
						$proton_portfolio_layout_col .= " $tag->slug";
					}
				}
			?>
			<div class="<?php echo esc_attr($proton_portfolio_layout_col); ?>">
				<div class="item-holder">
					<div class="item">
						<?php
							$proton_post_type = get_field("proton_post_type");
							$proton_post_url = get_permalink();
							if($proton_post_type == '3'){
								$proton_post_url = excerpt(50);
							}
							else {
								if($portfolio_style == '1' || $portfolio_style == '2'){
									if($portfolio_hover == '3' || $portfolio_hover == '6'){
										$proton_post_url = get_the_post_thumbnail_url();
									}
								}
							}
						?>
						<a class="full-overlay-link" href="<?php echo esc_attr($proton_post_url); ?>"></a>
						<?php if($portfolio_style == '1' || $portfolio_style == '2') :  ?>
							<div class="overlay-background"></div>
							<div class="overlay">
								<div class="inner-overlay">
									<?php if($portfolio_hover == '1' || $portfolio_hover == '2' || $portfolio_hover == '4' || $portfolio_hover == '5') : ?>
										<h3><a title="<?php the_title(); ?>" href="<?php echo esc_attr($proton_post_url) ?>"><?php the_title(); ?></a></h3>
									<?php endif; ?>
									<?php if($portfolio_hover == '2' || $portfolio_hover == '5') : ?>
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
									<?php endif; ?>
									<?php if($portfolio_hover == '3' || $portfolio_hover == '6') : ?>
										<h3 class="gallery-plus">+</h3>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
					<?php
						if(has_post_thumbnail()){
							the_post_thumbnail();
						}
						else {
							$proton_count = count(get_the_category());
							if($proton_count >= 10){
								echo '<img src="' . get_template_directory_uri() . '/assets/images/default-tall.png" />';
							}
							else {
								echo '<img src="' . get_template_directory_uri() . '/assets/images/default.png" />';
							}
						}
					?>
				</div>
				<?php if($portfolio_style == '3' || $portfolio_style == '4') :  ?>
					<div class="meta-tags-outside">
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
				<?php endif; ?>
			</div>
			<?php endwhile; endif; wp_reset_postdata(); ?>
		</div>
		<?php
			$proton_portfolio_button = get_field("proton_portfolio_button");
			$proton_portfolio_button_link = get_field("proton_portfolio_button_link");
		?>
		<?php if($proton_portfolio_button || $proton_portfolio_button_link) : ?>
			<div class="row">
				<div class="show-more-holder">
					<a class="button-show-more" href="<?php echo esc_attr($proton_portfolio_button_link); ?>">
						<?php
							if($proton_portfolio_button){
								echo $proton_portfolio_button;
							}
							else {
								echo esc_attr__("Show More", "proton");
							}
						?>
					</a>
				</div>
			</div>
		<?php endif; ?>
		<div class="row">
			<div class="col-md-12">
				<?php proton_pagination($query->max_num_pages, "page-pagination", 999); ?>
			</div>
		</div>
	</div>
	<?php endwhile; endif; ?>
	<?php if($options['portfolio_masonry']) : ?>
		<?php if($options['portfolio_masonry'] != true) : ?>
			<script type="text/javascript">
				jQuery(window).load(function($){
					jQuery('.portfolio-masonry').isotope({
						layoutMode: 'fitRows',
					});
				});
			</script>
		<?php endif; ?>
	<?php else : ?>
		<?php if($proton_portfolio_masonry != true) : ?>
			<script type="text/javascript">
				jQuery(window).load(function($){
					jQuery('.portfolio-masonry').isotope({
						layoutMode: 'fitRows',
					});
				});
			</script>
		<?php endif; ?>
	<?php endif; ?>
<?php get_footer(); ?>
