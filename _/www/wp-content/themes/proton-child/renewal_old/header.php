<!DOCTYPE html>
<!--
[init] 
[20170524] | 구글 애널리틱스 추적코드추가                      | eley    
---------------------------------------------------------------
[after]
[20170529] | 페이지 상단 로그인 체크                        | eley 
[20170609] | jQuery DatePicker 추가                  | eley
[20170602] | 로그인 클릭했을때 자바스크립트 함수 추가              | eley 
[20170602] | 기존 url타입 로그아웃 로그인 코드변경               | eley
[20170629] | 기존 로그아웃 마이페이지 url추가                  | eley
[20170710] | 기존 div open - >로그인클릭시 로그인 페이지로 이동변경 | eley
[20170717] | 부모창url이동 script함수 추가                 | eley
[20170718] | 관리자 일때 마이페이지 -> 설정페이지               | eley
-->
<html <?php language_attributes(); ?>>
	<head>
		<!-- 구글 애널리틱스 추적코드추가 20170524 eley-->
		<script>
  		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
 		 })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		 ga('create', 'UA-99634637-1', 'auto');
		 ga('send', 'pageview');
		</script>
		<!-- jQuery DatePicker 추가 20170609 eley-->
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" media="all" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
		
		<!-- 부모창 url이동시 저장(iframe에서 사용) 20170717 eley-->
		<script>
		function change_parent_url (url){ 
			document.location = url; 
        }	
		</script>
		
		<!-- Document Settings -->
		<meta charset="<?php bloginfo('charset'); ?>">
		<?php
			global $options;

			// Disable Responsivity
			$proton_disable_responsivity = $options['proton_disable_responsivity'];
			if($proton_disable_responsivity == true){
				echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
			}

			// Add google analytics to the website
			if($options['proton_google_analytics']){
				echo $options['proton_google_analytics'];
			}

            wp_head();
		?>
	</head>
	<?php
		$proton_borders_class = "";
		$proton_borders_activate = $options['proton_activate_borders'];
		if($proton_borders_activate == true){
			$proton_borders_class = "proton-borders";
		}
	?>
	<body <?php body_class($proton_borders_class); ?>>
		<div class="loader"></div>
		<div class="wrapper">
			<?php
				$proton_header_layout = $options['proton_menu_type'];
				$proton_sticky_header = $options['proton_sticky_header'];

				if($proton_sticky_header){
					$proton_header_class = "fixed";
				}
				else {
					$proton_header_class = "";
				}

				switch($proton_header_layout) {
					case 'minimal':
						$proton_header_layout_column = "second-header cart-hidden";
						$proton_header_layout_footer = "display-none";
						$proton_header_layout_hamburger = "hamburger";
						$proton_header_layout_nav = "menu-hidden";
					break;
					case 'overlay':
						$proton_header_layout_column = "third-header";
						$proton_header_layout_footer = "";
						$proton_header_layout_hamburger = "hamburger";
						$proton_header_layout_nav = "";
					break;
					default:
						$proton_header_layout_column = "header";
						$proton_header_layout_footer = "display-none";
						$proton_header_layout_hamburger = "hamburger display-none";
						$proton_header_layout_nav = "";
					break;
				}
			?>
			<header class="<?php echo esc_attr($proton_header_class); ?>">
			
			<script>
			//로그인버튼 보이기 안보이기
			/*20170710*/
			/*
			function login_view(){
				if(document.getElementById("hiddenlogin").style.display==""){
					document.getElementById("hiddenlogin").style.display="none";
				}else{
					document.getElementById("hiddenlogin").style.display="";  
				}
			}
			*/
			</script>
			
			<?php 
				//현재 유저 정보를 가져옴
				global $current_user;
				wp_get_current_user();
				$user_id = $current_user->ID;
				//Notice문제때문에 선언
				$redirect_to = ''; 

				//로그인 하지않은 사람
				if ($user_id == 0) {
					//echo '<div align=right class=container style="color: #999999;"><a href="center_pop("http://selvitest.cafe24.com/selvi_login/","login","100","100")"> 로그인 </a> | <a href="http://selvitest.cafe24.com/login/"> Login </a></div>';
					//20170710
					//echo '<div align=right class=container style="color: #999999;"><a href="javascript:login_view();"> LOGIN </a></div>';
					//echo '<div align=right class=header-holder><div id="hiddenlogin" class="social-icons" style="display:none; align=right">' . cosmosfarm_members_social_buttons(array('redirect_to'=>$redirect_to)) . '</div></div>';
					echo '<div align=right class=container style="color: #999999;"><a href="http://selvitest.cafe24.com/login/"> LOGIN </a></div>';
				//로그인한 사람
				} else {
					//echo '<div align=right class=container style="color: #999999;"> 안녕하세요 ' . $current_user->user_login . ' 님 | <a href="http://selvitest.cafe24.com/logout/"> Logout </a></div>';
					//echo '<div align=right class=container style="color: #999999;"> 안녕하세요 ' . $current_user->display_name . ' 님 | <a href="http://selvitest.cafe24.com/logout/"> LOGOUT </a></div>';
					//20170629
					echo '<div align=right class=container style="color: #999999;"> 안녕하세요 ' . $current_user->display_name . ' 님 </div>'; 
					//관리자 일때 설정페이지로 보여줌 20170718 eley
					if ($current_user->user_status == 1){
						echo '<div align=right class=container style="color: #999999;"><a href="http://selvitest.cafe24.com/admin_home/"> 설정/관리 </a> | <a href="http://selvitest.cafe24.com/logout/"> LOGOUT </a></div>'; 
					}else{
						echo '<div align=right class=container style="color: #999999;"><a href="http://selvitest.cafe24.com/mypage/"> MYPAGE </a> | <a href="http://selvitest.cafe24.com/logout/"> LOGOUT </a></div>'; 
					}
				}
			?>
				<div class="container">
					<div class="default-header <?php echo esc_attr($proton_header_layout_column); ?>">
						<div class="logo">
							<a href="<?php echo esc_url(home_url('/')); ?>">
								<?php
                                    $proton_logo = $options['proton_logo'];
                                    $proton_white_logo = $options['proton_white_logo'];
                                    $proton_logo_txt = $options['proton_logo_text'];

                                    if(!empty($proton_white_logo['url'])){
                                        echo '<img class="logo-white" src='. $proton_white_logo['url'] . '>';
                                    }

                                    if(!empty($proton_logo['url'])){
                                        echo '<img class="normal-logo" src='. $proton_logo['url'] . '>';
                                    }
                                    else if($proton_logo_txt){
                                        echo esc_attr($proton_logo_txt);
                                    }
                                    else {
                                        echo esc_attr(bloginfo('name'));
                                    }
								?>
							</a>
						</div>
						<div class="header-holder">
							<div class="mobile-menu">
								<span class="line"></span>
							</div>
							<div class="<?php echo esc_attr($proton_header_layout_hamburger); ?>">
								<a href="#">
									<div class="hamburger-inner"></div>
								</a>
							</div>
							<?php if(class_exists('WooCommerce')) : ?>
								<div id="cartcontents">
									<a id="minicart" class="cart icon red relative">
										<span class="icon-ecommerce-bag">
											<?php if($options['proton_skin'] == 'dark') : ?>
												<img class="white-bag" src="<?php echo get_template_directory_uri() . "/assets/images/shopping-bag-white.png" ?>" alt="">
											<?php else : ?>
												<img class="white-bag" src="<?php echo get_template_directory_uri() . "/assets/images/shopping-bag-white.png" ?>" alt="">	
												<img class="normal-bag" src="<?php echo get_template_directory_uri() . "/assets/images/shopping-bag.png" ?>" alt="">
											<?php endif; ?>
										</span>
										<span class="number bold">
											<?php echo sprintf('%d', WC()->cart->cart_contents_count); ?>
										</span>
									</a>
									<div class="widget_shopping_cart_content">
										<?php woocommerce_mini_cart(); ?>
									</div>
								</div>
							<?php endif; ?>
							<div class="menu-holder">
								<nav class="<?php echo esc_attr($proton_header_layout_nav); ?>">
									<?php
										$args = array(
											'theme_location' => 'main-menu',
											'container' => false,
											'menu_id' => 'menu'
										);

										if(has_nav_menu('main-menu')) {
											wp_nav_menu($args);
										}
										else {
											echo "<ul id='menu'><li><a class='no-menu-assigned' href='wp-admin/nav-menus.php'>" . esc_attr__("No menu assigned!","proton") ."</a></li></ul>";
										}
									?>
									<footer class="<?php echo esc_attr($proton_header_layout_footer); ?>">
										<div class="container">
											<div class="footer-copyright">
												<?php
													$proton_footer_alignment = $options['proton_footer_alignment'];
													switch($proton_footer_alignment){
														case 'left':
														default:
															$proton_footer_alignment_copyright = "col-md-6";
															$proton_footer_alignment_icons = "col-md-6 align-right";
														break;
														case 'right':
															$proton_footer_alignment_copyright = "col-md-6 pull-right align-right";
															$proton_footer_alignment_icons = "col-md-6 align-left";
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
								</nav>
							</div>
						</div>
					</div>
				</div>
			</header>
			<?php
				$proton_borders_class = $options['proton_activate_borders'];
				if($proton_borders_class == true) :
			?>
				<div class="borders-holder">
					<div class="border-top"></div>
					<div class="border-right"></div>
					<div class="border-bottom"></div>
					<div class="border-left"></div>
				</div>
			<?php endif; ?>
			<div class="container">
