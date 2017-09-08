<?php
	/* Template Name: Services */
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
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
		<?php if(have_rows("proton_services_posts")) : ?>
			<div class="services">
				<?php
					$i = 0;
					while(have_rows("proton_services_posts")) : the_row();
				?>
					<?php if(get_sub_field("proton_services_posts_url")) : ?>
						<a href="<?php echo esc_attr(get_sub_field("proton_services_posts_url")); ?>">
					<?php endif; ?>
					<div class="service row">
						<div class="<?php echo esc_attr(($i % 2 == 0) ? 'col-md-6 col-sm-6 col-xs-12' : 'col-md-6 col-sm-6 col-xs-12 pull-right'); ?>">
							<img src="<?php echo esc_attr(get_sub_field("proton_services_posts_image")); ?>">
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="service-info-holder">
								<h3><?php echo esc_attr(get_sub_field("proton_services_posts_title")); ?></h3>
								<p><?php echo get_sub_field("proton_services_posts_content"); ?></p>
							</div>
						</div>
					</div>
					<?php if(get_sub_field("proton_services_posts_url")) : ?>
						</a>
					<?php endif; ?>
				<?php $i++; endwhile; ?>
			</div>
		<?php endif; ?>
	<?php endwhile; endif; ?>
<?php get_footer(); ?>
