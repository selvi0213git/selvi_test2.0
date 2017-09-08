<?php
	/* Template Name: About */
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
	<div class="about">
		<div class="about-img">
			<?php
	            if(has_post_thumbnail()){
	                the_post_thumbnail();
	            }
	        ?>
		</div>
		<div class="about-content">
			<div class="about-info">
				<?php if(get_field("proton_about_title")) : ?>
					<h3><?php echo esc_attr(get_field("proton_about_title")); ?></h3>
				<?php endif; ?>
				<?php the_content(); ?>
			</div>
			<?php if(have_rows("proton_about_clients")) : ?>
			<div class="about-clients">
				<h3><?php the_field("proton_about_clients_title") ?></h3>
				<div id="owl-example">
					<?php while(have_rows("proton_about_clients")) : the_row(); ?>
						<?php if(get_sub_field("proton_about_clients_url")) : ?>
							<a href="<?php esc_attr(the_sub_field("proton_about_clients_url")); ?>">
						<?php endif; ?>
							<img src="<?php echo esc_attr(the_sub_field("proton_about_clients_img")) ?>" alt="">
						<?php if(get_sub_field("proton_about_clients_url")) : ?>
							</a>
						<?php endif; ?>
					<?php endwhile; ?>
				</div>
			</div>
			<?php endif;  ?>
		</div>
	</div>
	<?php endwhile; endif; ?>
<?php get_footer(); ?>

<?php
	$proton_about_client_columns = get_field("proton_about_client_columns");

	if($proton_about_client_columns){
		$proton_about_client_cols = $proton_about_client_columns;
	}
	else {
		$proton_about_client_cols = 6;
	}
?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		jQuery("#owl-example").owlCarousel({
			items : <?php echo esc_attr($proton_about_client_cols);  ?>,
			autoPlay : true
		});
	});
</script>
