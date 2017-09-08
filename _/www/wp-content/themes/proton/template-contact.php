<?php
	/* Template Name: Contact */
	get_header();

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
	<?php
		$proton_contact_form_alignment = get_field("proton_contact_form_alignment");
		$proton_contact_show_map = get_field("proton_contact_show_map");
		switch ($proton_contact_form_alignment) {
			case '2':
				$proton_contact_form_holder = "col-md-8 col-sm-8 col-xs-12 pull-right";
				$proton_contact_form_sidebar = "col-md-4 col-sm-4 col-xs-12 sidebar";
				break;
			default:
				$proton_contact_form_holder = "col-md-9 col-sm-9 col-xs-12";
				$proton_contact_form_sidebar = "col-md-3 col-sm-3 col-xs-12 sidebar";
				break;
		}

		switch ($proton_contact_show_map) {
			case true:
				$proton_contact_container = "contact second-contact";
				break;
			default:
				$proton_contact_container = "contact";
				break;
		}

		if(have_posts()) : while(have_posts()) : the_post();
	?>
		<div class="<?php echo esc_attr($proton_contact_container); ?>">
			<div class="<?php echo esc_attr(($proton_contact_show_map == true) ? 'contact-map' : 'display-none'); ?>">
				<div id="map"></div>
			</div>
			<div class="row">
				<div class="<?php echo esc_attr($proton_contact_form_holder); ?>">
					<div class="contact-form">
						<?php echo do_shortcode('[acf field="proton_contact_form"]'); ?>
					</div>
				</div>
				<div class="<?php echo esc_attr($proton_contact_form_sidebar); ?>">
					<?php the_content(); ?>
					<?php if(have_rows("proton_contact_social_icons")) : ?>
						<div class="social-icons">
							<h4><?php echo esc_attr(get_field("proton_social_media_title")); ?></h4>
							<ul>
								<?php while(have_rows("proton_contact_social_icons")) : the_row(); ?>
									<li>
										<a target="_BLANK" href="<?php echo esc_attr(get_sub_field("proton_contact_social_icons_link")); ?>">
											<i class="fa <?php echo esc_attr(get_sub_field("proton_contact_social_icons_icon")); ?>"></i>
										</a>
									</li>
								<?php endwhile; ?>
							</ul>
						</div>
					<?php endif; ?>
					<?php
						if(is_active_sidebar('sidebar-2')){
							dynamic_sidebar('sidebar-2');
						}
					?>
				</div>
			</div>
		</div>
	<?php endwhile; endif; ?>
<?php get_footer(); ?>
