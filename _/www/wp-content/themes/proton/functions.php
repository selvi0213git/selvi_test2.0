<?php
// Define global theme variables
$options = get_proton_options();

// Language Setup
add_action('after_setup_theme', 'proton_language_setup');
function proton_language_setup(){
	load_theme_textdomain('proton', get_template_directory() . '/language');
}

// Set max content width
if(!isset($content_width)){
	$content_width = 1170;
}

// Proton Setup
add_action( 'after_setup_theme', 'proton_setup' );
function proton_setup() {
	// Add theme support
	add_theme_support("menus");
	add_theme_support("post-thumbnails");
	add_theme_support("automatic-feed-links");
	add_theme_support("title-tag");
	add_theme_support("woocommerce");
	add_theme_support( 'wc-product-gallery-lightbox' );

	// Include custom files
	require_once( get_template_directory() . '/includes/tgm.php');
	include_once( get_template_directory() . '/includes/custom-fields.php');
	include( get_template_directory() . "/includes/custom.php");
	include( get_template_directory() . "/includes/custom-fonts.php");
	define( 'ACF_LITE', true );

	// Add stylesheets and scripts
	add_action("wp_enqueue_scripts", "proton_add_external_css");
	add_action("wp_enqueue_scripts", "proton_add_external_js");

	// Register Menus
	register_nav_menus(
		array(
			"main-menu" => "Main Menu",
		)
	);

	// Active class in header
	add_filter('nav_menu_css_class' , 'proton_nav_class' , 10 , 2);
	function proton_nav_class($classes, $item){
		if( in_array('current-menu-item', $classes) ){
			$classes[] = 'active ';
		}
		return $classes;
	}

	// Initial the Redux Framework to Proton
	if(!class_exists('ReduxFramework') && file_exists(get_template_directory(). '/includes/redux-framework/ReduxCore/framework.php')){
	    require_once( get_template_directory() . '/includes/redux-framework/ReduxCore/framework.php');
	}
	if(!isset($redux_demo) && file_exists(get_template_directory() . '/includes/redux-framework/options-config.php')){
	    require_once(get_template_directory().'/includes/redux-framework/options-config.php');
	}

	// TGMPA
	add_action( 'tgmpa_register', 'proton_theme_plugins' );
	function proton_theme_plugins() {
		$plugins = array(
	        array(
	            'name'      => esc_attr__('Contact Form 7','proton'),
	            'slug'      => 'contact-form-7',
	            'required'  => false,
	        ),
			array(
				'name'      => esc_attr__('Woocommerce','proton'),
				'slug'      => 'woocommerce',
				'required'  => false,
	        ),
			array(
	        	'name'      => esc_attr__( 'Advanced Custom Fields', 'proton'),
	            'slug'      => 'advanced-custom-fields',
	            'required'  => true,
	        ),
			array(
	        	'name'      => esc_attr__( 'ACF Repeater', 'proton'),
	            'slug'      => 'acf-repeater',
				'source'    => get_template_directory() . '/includes/acf-repeater.zip',
	            'required'  => true,
	        ),
			array(
	        	'name'      => esc_attr__( 'ACF Flexible Content', 'proton'),
	            'slug'      => 'acf-flexible-content',
				'source'    => get_template_directory() . '/includes/acf-flexible-content.zip',
	            'required'  => true,
	        ),
			array(
				'name'      => esc_attr__('Advanced Custom Fields Font Awesome','proton'),
				'slug'      => 'advanced-custom-fields-font-awesome',
				'required'  => false,
			),
			array(
				'name'      => esc_attr__('Tweets Widgets','proton'),
				'slug'      => 'rotatingtweets',
				'required'  => false,
			),
	    );
		$config = array(
			'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);
	    tgmpa( $plugins, $config );
	}
}

// Register Fonts
function proton_fonts_url() {
	global $options;
	$font_url = '';
	if ( 'off' !== _x( 'on', 'Google font: on or off', 'proton' ) ) {
		if($options['proton_style'] == 'modern'){
			$font_url = add_query_arg( 'family', urlencode( 'Hind:300,400,500,600|Poppins:300,400,500,600' ), "//fonts.googleapis.com/css" );
		}
		else {
			$font_url = add_query_arg( 'family', urlencode( 'Roboto:300,400,400i,500,700' ), "//fonts.googleapis.com/css" );
		}
	}
	return $font_url;
}

function proton_add_external_css() {
	global $options;
	// Register
	wp_register_style("wp-style", get_stylesheet_uri());
	wp_register_style("bootstrap", get_template_directory_uri()."/assets/css/bootstrap.css", false, "1.3.1.1");
	wp_register_style("font-awesome", get_template_directory_uri()."/assets/css/font-awesome.css", false, "1.3.1.1");
	wp_register_style("magnific-popup", get_template_directory_uri()."/assets/css/magnific-popup.css", false, "1.3.1.1");
	wp_register_style("magnific-popup", get_template_directory_uri()."/assets/css/magnific-popup.css", false, "1.3.1.1");
	wp_register_style("woocommerce", get_template_directory_uri()."/assets/css/woocommerce.css", false, "1.3.1.1");
	wp_register_style("main", get_template_directory_uri()."/assets/css/style.css", false, "1.3.1.1");
	wp_register_style("modern", get_template_directory_uri()."/assets/css/modern.css", false, "1.3.1.1");
	wp_register_style("dark-skin", get_template_directory_uri()."/assets/css/dark-skin.css", false, "1.3.1.1");
	// Enqueue
	wp_enqueue_style("wp-style");
	wp_enqueue_style("bootstrap");
	wp_enqueue_style("font-awesome");
	wp_enqueue_style("magnific-popup");
	if(class_exists('WooCommerce')) {
		wp_enqueue_style("woocommerce");
	}
	wp_enqueue_style("main");
	if($options['proton_style'] == 'modern'){
		wp_enqueue_style("modern");
	}
	if($options['proton_skin'] == 'dark'){
		wp_enqueue_style("dark-skin");
	}
	wp_enqueue_style( 'proton-fonts', proton_fonts_url(), array(), '1.3.1.1' );
}


function proton_add_external_js() {
	$options = get_proton_options();
	if(!is_admin()) {
		// Register
		wp_register_script("bootstrap", get_template_directory_uri()."/assets/js/bootstrap.js", array("jquery"), "1.3.1.1", TRUE);
		wp_register_script("isotope", get_template_directory_uri()."/assets/js/isotope.pkgd.min.js", array("jquery"), "1.3.1.1", TRUE);
		wp_register_script("owl.carousel", get_template_directory_uri()."/assets/js/owl.carousel.min.js", array("jquery"), "1.3.1.1", TRUE);
		wp_register_script("magnific-popup", get_template_directory_uri()."/assets/js/jquery.magnific-popup.min.js", array("jquery"), "1.3.1.1", TRUE);
		wp_register_script("maps", "https://maps.googleapis.com/maps/api/js?key=AIzaSyAuaE4p3L0-Q6TXUDc4Xf9ttyCSK6779e4", array("jquery"), "1.3.1.1", TRUE);
		wp_register_script("maps-init", get_template_directory_uri()."/assets/js/maps-init.js", array("jquery", "maps"), "1.3.1.1", TRUE);
		wp_register_script("maps-init-modern", get_template_directory_uri()."/assets/js/maps-init-modern.js", array("jquery", "maps"), "1.3.1.1", TRUE);
		wp_register_script("page-smooth-scroll", get_template_directory_uri()."/assets/js/page-smooth-scroll.js", array("jquery", "maps"), "1.3.1.1", TRUE);
		wp_register_script("main", get_template_directory_uri()."/assets/js/main.js", array("jquery"), "1.3.1.1", TRUE);

		$map_data = array(
			'map_latitude' => get_field("proton_contact_map_latitude", get_the_ID()),
			'map_longtitude' => get_field("proton_contact_map_longtitude", get_the_ID())
		);
		wp_localize_script( 'maps-init', 'map_data', $map_data );

		$map_modern_data = array(
			'map_latitude' => get_field("proton_contact_map_latitude", get_the_ID()),
			'map_longtitude' => get_field("proton_contact_map_longtitude", get_the_ID())
		);
		wp_localize_script( 'maps-init-modern', 'map_data', $map_modern_data );

		// Enqueue
		wp_enqueue_script("bootstrap");
		wp_enqueue_script("isotope");
		wp_enqueue_script("website-smooth-scroll");
		wp_enqueue_script("owl.carousel");
		wp_enqueue_script("magnific-popup");
		if(is_page_template("template-contact.php")) {
			if($options['proton_style'] == 'modern'){
				wp_enqueue_script("maps-init-modern");
			}
			else {
				wp_enqueue_script("maps-init");
			}
			wp_enqueue_script("maps");
		}
		if($options['proton_smooth_scroll']){
			wp_enqueue_script("page-smooth-scroll");
		}
		wp_enqueue_script("main");
		if (is_singular()) wp_enqueue_script( "comment-reply" );
	}

}

// Favicon
if (!function_exists('wp_site_icon') || !has_site_icon()){
	function proton_favicon() {
		global $options;
		$proton_favicon = $options['proton_favicon'];
		if($proton_favicon) {
			$proton_favicon_url = $proton_favicon['url'];
			echo "<link rel='shortcut icon' href='$proton_favicon_url' />";
		}
	}
	add_action('wp_head', 'proton_favicon');
}

// Sidebar
add_action( 'widgets_init', 'proton_widgets_init' );
function proton_widgets_init() {
	global $options;
    register_sidebar(
    	array(
				'name' => esc_attr__("Main Sidebar","proton"),
				'id' => 'sidebar-1',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widgettitle">',
				'after_title'   => '</h2>',
    	)
	);
	register_sidebar( array(
		'name' => esc_html__( 'Contact Sidebar', 'proton'),
		'id' => 'sidebar-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	));
	if(class_exists('WooCommerce')){
		register_sidebar(
			array(
				'name' => esc_attr__("Shop Sidebar","proton"),
				'id' => 'sidebar-3',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widgettitle">',
				'after_title'   => '</h2>',
			)
		);
	}
	if($options['proton_footer_widgets'] == true) :
		register_sidebar( array(
	        'name' => esc_html__( 'Footer Sidebar 1', 'proton'),
	        'id' => 'footer-sidebar-1',
	        'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
	    ));
		register_sidebar( array(
	        'name' => esc_html__( 'Footer Sidebar 2', 'proton'),
	        'id' => 'footer-sidebar-2',
	        'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
	    ));
		if($options['proton_footer_widgets_columns'] == 'three' || $options['proton_footer_widgets_columns'] == 'four') :
			register_sidebar( array(
		        'name' => esc_html__( 'Footer Sidebar 3', 'proton'),
		        'id' => 'footer-sidebar-3',
		        'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
		    ));
		endif; if($options['proton_footer_widgets_columns'] == 'four') :
			register_sidebar( array(
		        'name' => esc_html__( 'Footer Sidebar 4', 'proton'),
		        'id' => 'footer-sidebar-4',
		        'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3>',
				'after_title'   => '</h3>',
		    ));
		endif;
	endif;
}

// Pagination
function proton_pagination($pages = '', $class = '', $range = 4) {
	 $showitems = ($range * 2)+1;
	 global $paged;
	 if(empty($paged)) $paged = 1;
	 if($pages == '')
	 {
		 global $wp_query;
		 $pages = $wp_query->max_num_pages;
		 if(!$pages)
		 {
		 $pages = 1;
		 }
	 }
	 if($class == '') {
	 	$pagination_class = 'pagination';
	 } else {
	 	$pagination_class = $class;
	 }
	 if(1 != $pages)
	 {
		 echo "<ul class=\"" . esc_attr($pagination_class)  . "\">";
		 for ($i=1; $i <= $pages; $i++)
		 {
			 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
			 {
			 echo ($paged == $i)? "<li class=\"active\"><a>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a></li>";
			 }
		 }
		 echo "</ul>\n";
	 }
}

// Get Options from Redux
function get_proton_options() {
	$options = get_option('proton_redux');
	if(!empty($options)) {
		return $options;
	}
}

// ACF if not activated
if(!function_exists('get_field') && ! is_admin()){
	function get_field($field_id, $post_id = null){
		return null;
	}
}

if(!function_exists('get_sub_field') && ! is_admin()){
	function get_sub_field($field_id, $post_id = null){
		return null;
	}
}

// Ajax Mini Cart
function woocommerce_header_add_to_cart_fragment($fragments) {
    ob_start();
    ?>
        <span class="number bold">
            <?php echo sprintf('%d', WC()->cart->cart_contents_count); ?>
        </span>
    <?php
    $fragments['#minicart .number'] = ob_get_clean();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');


// Change Excerpt length
function excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if(count($excerpt) >= $limit) {
	array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	}
	else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
	return $excerpt;
}

// Remove redux menu under the tools
add_action( 'admin_menu', 'proton_remove_redux_menu',12 );
function proton_remove_redux_menu() {
	remove_submenu_page('tools.php','redux-about');
}
