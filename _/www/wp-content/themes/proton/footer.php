			</div>
		</div>
		<?php global $options; ?>
		<?php
			$proton_footer_parallax = $options['proton_footer_parallax'];
		?>
		<footer class="<?php echo esc_attr($proton_footer_parallax) ? "fixed-footer" : ""; ?>">
			<div class="container">
				<?php if($options['proton_footer_widgets']) : ?>
					<div class="footer-widgets">
						<div class="row">
							<?php
								switch($options['proton_footer_widgets_columns']){
									case 'two':
										$proton_footer_widgets_columns_holder = "col-md-6 col-sm-6 col-xs-12";
										break;
									case 'three':
									default:
										$proton_footer_widgets_columns_holder = "col-md-4 col-sm-4 col-xs-12";
										break;
									case 'four':
										$proton_footer_widgets_columns_holder = "col-md-3 col-sm-3 col-xs-12";
										break;
								}
								if($options['proton_footer_widgets_columns'] == '2'){
									$proton_footer_widgets_columns_holder = "col-md-6 col-sm-6 col-xs-12";
								}
								else if($options['proton_footer_widgets_columns'] == '3'){
									$proton_footer_widgets_columns_holder = "col-md-4 col-sm-6 col-xs-12";
								}
								else if($options['proton_footer_widgets_columns'] == '4'){
									$proton_footer_widgets_columns_holder = "col-md-3 col-sm-6 col-xs-12";
								}
							?>
							<div class="<?php echo esc_attr($proton_footer_widgets_columns_holder);  ?>">
								<?php
									if(is_active_sidebar('footer-sidebar-1')){
										dynamic_sidebar('footer-sidebar-1');
									}
								?>
							</div>
							<div class="<?php echo esc_attr($proton_footer_widgets_columns_holder);  ?>">
								<?php
									if(is_active_sidebar('footer-sidebar-2')){
										dynamic_sidebar('footer-sidebar-2');
									}
								?>
							</div>
							<?php if($options['proton_footer_widgets_columns'] == 'three' || $options['proton_footer_widgets_columns'] == 'four') : ?>
								<div class="<?php echo esc_attr($proton_footer_widgets_columns_holder);  ?>">
									<?php
										if(is_active_sidebar('footer-sidebar-3')){
											dynamic_sidebar('footer-sidebar-3');
										}
									?>
								</div>
							<?php endif; if($options['proton_footer_widgets_columns'] == 'four') : ?>
								<div class="<?php echo esc_attr($proton_footer_widgets_columns_holder);  ?>">
									<?php
										if(is_active_sidebar('footer-sidebar-4')){
											dynamic_sidebar('footer-sidebar-4');
										}
									?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
				<div class="footer-copyright">
					<?php
						$proton_footer_alignment = $options['proton_footer_alignment'];
						switch($proton_footer_alignment){
							case 'left':
							default:
								$proton_footer_alignment_copyright = "col-md-6 col-sm-6 col-xs-12";
								$proton_footer_alignment_icons = "col-md-6 col-sm-6 col-xs-12 align-right";
							break;
							case 'right':
								$proton_footer_alignment_copyright = "col-md-6 col-sm-6 col-xs-12 pull-right align-right";
								$proton_footer_alignment_icons = "col-md-6 col-sm-6 col-xs-12 align-left";
							break;
							case 'center':
								$proton_footer_alignment_copyright = "col-md-12 align-center";
								$proton_footer_alignment_icons = "col-md-12 align-center";
							break;
						}
					?>
					<div class="row">
						<div class="<?php echo esc_attr($proton_footer_alignment_copyright); ?>">
							<?php $proton_footer_content = $options['proton_footer_copyright']; ?>
							<p><?php echo $proton_footer_content; ?></p>
						</div>
						<div class="<?php echo esc_attr($proton_footer_alignment_icons); ?>">
							<ul>
	                            <?php if($options['proton_social_media_facebook_show'] && !empty($options['proton_social_media_facebook'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_facebook']); ?>"><i class="fa fa-facebook"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_twitter_show'] && !empty($options['proton_social_media_twitter'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_twitter']); ?>"><i class="fa fa-twitter"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_googleplus_show'] && !empty($options['proton_social_media_googleplus'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_googleplus']); ?>"><i class="fa fa-google-plus"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_vimeo_show'] && !empty($options['proton_social_media_vimeo'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_vimeo']); ?>"><i class="fa fa-vimeo"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_dribbble_show'] && !empty($options['proton_social_media_dribbble'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_dribbble']); ?>"><i class="fa fa-dribbble"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_pinterest_show'] && !empty($options['proton_social_media_pinterest'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_pinterest']); ?>"><i class="fa fa-pinterest"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_youtube_show'] && !empty($options['proton_social_media_youtube'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_youtube']); ?>"><i class="fa fa-youtube"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_tumblr_show'] && !empty($options['proton_social_media_tumblr'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_tumblr']); ?>"><i class="fa fa-tumblr"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_linkedin_show'] && !empty($options['proton_social_media_linkedin'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_linkedin']); ?>"><i class="fa fa-linkedin"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_behance_show'] && !empty($options['proton_social_media_behance'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_behance']); ?>"><i class="fa fa-behance"></i></a></li>
	                            <?php endif; ?>
								<?php if($options['proton_social_media_500px_show'] && !empty($options['proton_social_media_500px'])) : ?>
									<li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_500px']); ?>"><i class="fa fa-500px"></i></a></li>
								<?php endif; ?>
	                            <?php if($options['proton_social_media_flickr_show'] && !empty($options['proton_social_media_flickr'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_flickr']); ?>"><i class="fa fa-flickr"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_spotify_show'] && !empty($options['proton_social_media_spotify'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_spotify']); ?>"><i class="fa fa-spotify"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_instagram_show'] && !empty($options['proton_social_media_instagram'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_instagram']); ?>"><i class="fa fa-instagram"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_github_show'] && !empty($options['proton_social_media_github'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_github']); ?>"><i class="fa fa-github"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_stackexchange_show'] && !empty($options['proton_social_media_stackexchange'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_stackexchange']); ?>"><i class="fa fa-stack-exchange"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_soundcloud_show'] && !empty($options['proton_social_media_soundcloud'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_soundcloud']); ?>"><i class="fa fa-soundcloud"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_vk_show'] && !empty($options['proton_social_media_vk'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_vk']); ?>"><i class="fa fa-vk"></i></a></li>
	                            <?php endif; ?>
	                            <?php if($options['proton_social_media_vine_show'] && !empty($options['proton_social_media_vine'])) : ?>
	                                <li><a target="_BLANK" href="<?php echo esc_attr($options['proton_social_media_vine']); ?>"><i class="fa fa-vine"></i></a></li>
	                            <?php endif; ?>
	                        </ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<?php wp_footer(); ?>
	</body>
</html>
