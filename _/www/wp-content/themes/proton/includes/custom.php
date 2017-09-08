<?php
    function proton_custom_css() {
    	global $options;
    	$proton_mini_cart = $options['proton_mini_cart'];
    	$proton_transition = $options['proton_transition'];
    	$proton_transition_duration = $options['proton_transition_duration'];
    	$proton_sticky_header = $options['proton_sticky_header'];
    	$proton_borders_activate = $options['proton_activate_borders'];
    	$proton_custom_css = $options['proton_custom_css'];
    	$proton_custom_js = $options['proton_custom_js'];
    	$proton_logo_width = $options['proton_logo_width'];
    	$proton_logo_height = $options['proton_logo_height'];
    	$proton_body_color = $options['proton_body_color'];
        $proton_main_color = $options['proton_main_color'];
    	$proton_borders_color = $options['proton_borders_color'];
    	$proton_header_color = $options['proton_header_color'];
    	$proton_dropdown_color = $options['proton_dropdown_color'];
    	$proton_style = $options['proton_style'];
        $proton_skin = $options['proton_skin'];
    	$proton_footer_color = $options['proton_footer_color'];
    	$proton_borders_size = $options['proton_borders_size'];


        echo "<style>";

        // Mini cart
    	if(!class_exists('WooCommerce')){
    		echo ".wrapper header nav ul {margin-right: 0 !important;}";
    	}

    	if(!$proton_mini_cart){
    		echo "header #minicart {display: none !important;} .wrapper header nav ul {margin-right: 0 !important;}";
    	}

    	// Transition effect and duration
    	if($proton_transition == true){
    		if($proton_transition_duration){
    			echo "
                        .show-more-holder .button-show-more,
                        .wrapper header,
                        .wrapper header nav ul li a,
                        .wrapper .portfolio .filters ul li,
                        .wrapper header .logo,
                        .wrapper header nav ul li ul,
                        .wrapper header .hamburger .hamburger-inner,
                        .wrapper header .hamburger .hamburger-inner:after,
                        .wrapper header .hamburger .hamburger-inner:before,
                        .wrapper header nav ul li a:after,
                        .wrapper .portfolio .filters ul li:after,
                        .slicknav_menu .slicknav_icon-bar,
                        .slicknav_menu .slicknav_icon-bar:before,
                        .slicknav_menu .slicknav_icon-bar:after,
                        .wrapper .portfolio .item-holder .item .overlay-background,
                        .wrapper .blog-grid .blog-post .blog-post-holder .blog-info,
                        .blog .sidebar .widget ul li a,
                        .blog .sidebar .widget .tagcloud a,
                        .contact .contact-form input[type=submit],
                        .wrapper .blog-single .comment-form input[type=submit],
                        .wrapper .blog .blog-content .blog-post .blog-info .button,
                        footer .footer-widgets .widget_text a,
                        footer .footer-widgets .widget ul li a,
                        footer .footer-widgets .widget_rotatingtweets_widget .rtw_meta a,
                        footer .footer-copyright ul li a {
    						-webkit-transition: ". $proton_transition ."s all;
    						-o-transition: ". $proton_transition ."s all;
    						transition: ". $proton_transition ."s all;
    					}
    			";
    		}
    	}
    	else if($proton_transition == false) {
    		echo "
                    .show-more-holder .button-show-more,
                    .wrapper header,
                    .wrapper header nav ul li a,
                    .wrapper .portfolio .filters ul li,
                    .wrapper header .logo,
                    .wrapper header nav ul li ul,
                    .wrapper header .hamburger .hamburger-inner,
                    .wrapper header .hamburger .hamburger-inner:after,
                    .wrapper header .hamburger .hamburger-inner:before,
                    .wrapper header nav ul li a:after,
                    .wrapper .portfolio .filters ul li:after,
                    .slicknav_menu .slicknav_icon-bar,
                    .slicknav_menu .slicknav_icon-bar:before,
                    .slicknav_menu .slicknav_icon-bar:after,
                    .wrapper .portfolio .item-holder .item .overlay-background,
                    .wrapper .blog-grid .blog-post .blog-post-holder .blog-info,
                    .blog .sidebar .widget ul li a,
                    .blog .sidebar .widget .tagcloud a,
                    .contact .contact-form input[type=submit],
                    .wrapper .blog-single .comment-form input[type=submit],
                    .wrapper .blog .blog-content .blog-post .blog-info .button,
                    footer .footer-widgets .widget_text a,
                    footer .footer-widgets .widget ul li a,
                    footer .footer-widgets .widget_rotatingtweets_widget .rtw_meta a,
                    footer .footer-copyright ul li a {
    					-webkit-transition: 0s all;
    					-o-transition: 0s all;
    					transition: 0s all;
    				}
    		";
    	}

    	// Borders Activate - Margins
    	if($proton_borders_activate == true){
    		echo ".fixed-footer { padding-bottom: 24px;}";
    	}
    	if($proton_borders_activate == true && $proton_style == 'modern'){
    		echo ".fixed-footer { padding-bottom: 0;}";
    	}
    	if($proton_borders_size){
    		echo "
    			.proton-borders .border-top, .proton-borders .border-right, .proton-borders .border-bottom, .proton-borders .border-left {padding: " . $proton_borders_size . "px}
    			.proton-borders {margin: " . $proton_borders_size*2 . "px}
    			.wrapper header.fixed {margin-top: " . $proton_borders_size*2 . "px}
                .fixed-footer { padding-bottom: ". $proton_borders_size*2 . "px }
                .mfp-gallery .mfp-container .mfp-arrow-left {left: ". ($proton_borders_size+40) ."px !important}
                .mfp-gallery .mfp-container .mfp-arrow-right {right: ". ($proton_borders_size+40) ."px !important}
    		";
    	}

    	// Logo width and height
    	if($proton_logo_width){
    		echo ".wrapper header .logo img { width: ".$proton_logo_width ."px; }";
    	}
    	if($proton_logo_height){
    		echo ".wrapper header .logo img { height: ".$proton_logo_height ."px; }";
    	}

    	// Style Options
    	if($proton_body_color){
    		echo "body, .wrapper header, footer, .loader { background-color: ". $proton_body_color ." !important;}";
    	}
        if($proton_main_color && $proton_skin == 'light'){
            echo "
                .wrapper .portfolio .filters ul li:hover,
                .wrapper .project-single .single-navigation a:hover i,
                .wrapper .project-single .single-navigation a:hover span,
                .blog .sidebar .widget ul li a:hover,
                .blog .sidebar .widget .tagcloud a:hover,
                .wrapper .blog .blog-content .blog-post .blog-info .post-info li a,
                .wrapper .blog .blog-content .blog-post .blog-info .post-info li span,
                footer .footer-widgets .widget ul li a:hover,
                footer .footer-widgets .widget_text a,
                footer .footer-widgets .widget_rotatingtweets_widget .rtw_meta a,
                footer .footer-copyright ul li a:hover,
                footer .footer-copyright a {
                    color: ". $proton_main_color ." !important;
                }

                ::selection,
                .wrapper header nav ul li a:after,
                .wrapper .portfolio .filters ul li:after,
                .contact .contact-form input[type=submit]:hover,
                .wrapper .blog-single .comment-form input[type=submit]:hover,
                .wrapper .blog .blog-content .blog-post .blog-info .button:hover,
                .wrapper .portfolio .item-holder .item .overlay-background {
                    background-color: ". $proton_main_color ." !important;
                }

                .wrapper .blog-single blockquote,
                .show-more-holder .button-show-more:hover{
                    border-color: ". $proton_main_color ." !important;
                }
            ";
        }
        if($proton_main_color && $proton_skin == 'dark'){
            echo "
                footer .footer-widgets .widget_text a,
                footer .footer-widgets .widget_rotatingtweets_widget .rtw_meta a,
                footer .footer-copyright ul li a:hover,
                .show-more-holder .button-show-more:hover,
                footer .footer-widgets .widget ul li a:hover,
                .blog .sidebar .widget ul li a:hover,
                .blog .sidebar .widget .tagcloud a,
                .wrapper .project-single .single-info .project-description span,
                .wrapper .project-single .single-navigation a:hover i,
                .wrapper .project-single .single-navigation a:hover span,
                .wrapper .contact .social-icons ul li a:hover,
                .wrapper .shop .product .summary .product_meta span a,
                .wrapper .portfolio .filters ul li.active,
                .wrapper .portfolio .filters ul li:hover,
                .wrapper .blog .blog-content .blog-post .blog-info .post-info li span,
                footer .footer-copyright a {
                    color: ". $proton_main_color ." !important;
                }

                .wrapper .portfolio .item-holder .item .overlay,
                .wrapper .blog .blog-content .blog-post .blog-info .button,
                .page-pagination li.active, .page-pagination li:hover,
                .contact .contact-form input[type=submit],
                .wrapper .blog-single .comment-form input[type=submit],
                .wrapper .shop div.product .product_type_simple,
                .wrapper .shop .widget_shopping_cart .widget_shopping_cart_content .buttons a,
                .wrapper .shop .widget_price_filter form .price_slider_wrapper .price_slider_amount .button,
                .wrapper .shop .product .summary .cart .button,
                .wrapper header nav ul li a:after, .wrapper .portfolio .filters ul li:after,
                .sidebar .widget_search input#searchsubmit,
                .wrapper .shop .product .woocommerce-tabs #reviews #review_form_wrapper input,
                .contact .contact-form input[type=submit]:hover,
                .wrapper .blog .blog-content .blog-post .blog-info .button:hover,
                .wrapper .blog-single .comment-form input[type=submit]:hover,
                .wrapper .portfolio .filters ul li:after,
                .wrapper .portfolio .item-holder .item .overlay-background,
                .wrapper header nav ul li a:after {
                    background-color: ". $proton_main_color ." !important;
                }

                .show-more-holder .button-show-more:hover,
                .wrapper .blog-single blockquote {
                    border-color: ". $proton_main_color ." !important;
                }
            ";
        }
    	if($proton_borders_color){
    		echo ".proton-borders .border-top, .proton-borders .border-right, .proton-borders .border-bottom, .proton-borders .border-left { background-color: ". $proton_borders_color ." !important;}";
    	}
    	if($proton_header_color){
    		echo ".wrapper header nav ul li > a { color: ". $proton_header_color ." !important;}";
    	}
    	if($proton_dropdown_color){
    		echo ".wrapper header nav ul li ul li a { color: ". $proton_dropdown_color ." !important;}";
    	}

    	// Custom CSS
    	if($proton_custom_css){	echo "". $proton_custom_css  ."";}

    	// Footer Background color
    	if($proton_footer_color){
    		echo "footer {background-color:". $proton_footer_color . " !important}";
    	}
        echo "</style>";

        // Custom JS
        if($proton_custom_js){
            echo "<script>". $proton_custom_js  ."</script>";
        }
    }

    add_action('wp_head', 'proton_custom_css');
?>
