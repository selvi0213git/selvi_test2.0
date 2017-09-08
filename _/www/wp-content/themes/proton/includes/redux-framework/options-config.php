<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "proton_redux";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Proton', 'proton' ),
        'page_title'           => __( 'Proton Options', 'proton' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,
        // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => false,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => false,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = '';
    } else {
         $args['intro_text'] = '';
    }

    // Add content after the form.
    $args['footer_text'] = '';

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

     /* EXT LOADER */
   if(!function_exists('redux_register_custom_extension_loader')) :
   function redux_register_custom_extension_loader($ReduxFramework) {
       $path = dirname( __FILE__ ) . '/extensions/';
       $folders = scandir( $path, 1 );
       foreach($folders as $folder) {
           if ($folder === '.' or $folder === '..' or !is_dir($path . $folder) ) {
               continue;
           }
           $extension_class = 'ReduxFramework_Extension_' . $folder;
           if( !class_exists( $extension_class ) ) {
               // In case you wanted override your override, hah.
               $class_file = $path . $folder . '/extension_' . $folder . '.php';
               $class_file = apply_filters( 'redux/extension/'.$ReduxFramework->args['opt_name'].'/'.$folder, $class_file );
               if( $class_file ) {
                   require_once( $class_file );
                   $extension = new $extension_class( $ReduxFramework );
               }
           }
       }
   }
   // Modify {$redux_opt_name} to match your opt_name
   add_action("redux/extensions/".$opt_name ."/before", 'redux_register_custom_extension_loader', 0);
   endif;

    /*
     *
     * ---> START SECTIONS
     *
     */

    /*
        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for

     */

    // General Settings
        Redux::setSection( $opt_name, array(
            'title'            => __( 'General', 'proton' ),
            'id'               => 'general_settings',
            'desc'             => __( 'Welcome to Proton Theme Options.', 'proton' ),
            'customizer_width' => '400px',
            'icon'             => 'el el-home',
            'fields'           => array(
                array(
                    'id' => 'proton_style',
                    'type' => 'button_set',
                    'title' => __('Proton Style', 'proton'),
                    'subtitle' => __('Change the main style of Proton, choose between classic and modern.', 'proton'),
                    'options' => array(
                        'classic' => __('Classic', 'proton'),
                        'modern' => __('Modern', 'proton'),
                    ),
                    'default' => 'classic'
                ),
                array(
                    'id' => 'proton_skin',
                    'type' => 'button_set',
                    'title' => __('Proton Skin', 'proton'),
                    'subtitle' => __('Change the skin of Proton, default is light.', 'proton'),
                    'options' => array(
                        'light' => __('Light','proton'),
                        'dark' => __('Dark','proton'),
                    ),
                    'default' => 'light'
                ),
                array(
                    'id' => 'proton_disable_responsivity',
                    'type' => 'switch',
                    'title' => __('Responsivity', 'proton'),
                    'subtitle' => __('Switch on or off the responsivity, if you disable the responsive your website will remain the same on small devices.', 'proton'),
                    'on' => __('Enable','proton'),
                    'off' => __('Disable','proton'),
                    'default' => true
                ),
                array(
                    'id' => 'proton_activate_borders',
                    'type' => 'switch',
                    'title' => __('Activate Borders', 'proton'),
                    'subtitle' => __('Switch on or off the borders in your website, borders will appear in all edges of website.', 'proton'),
                ),
                array(
                    'id' => 'proton_borders_size',
                    'type' => 'text',
                    'title' => __('Borders Size', 'proton'),
                    'subtitle' => __('Change the borders size, default is 12px. Write only the number without \'px\'.', 'proton'),
                    'required' => array( 'proton_activate_borders', '=', true ),
                ),
                array(
                    'id' => 'proton_transition',
                    'type' => 'switch',
                    'title' => __('Transition Effect', 'proton'),
                    'subtitle' => __('Switch on or off the transition effect, all elements will hover or fadeIn smoothly.', 'proton'),
                    'default' => true,
                ),
                array(
                    'id' => 'proton_transition_duration',
                    'type' => 'text',
                    'title' => __('Transition Duration', 'proton'),
                    'subtitle' => __('Change the transition duration, default is 0.2 seconds. Write only the number.', 'proton'),
                    'required' => array( 'proton_transition', '=', true ),
                ),
                array(
                    'id' => 'proton_smooth_scroll',
                    'type' => 'switch',
                    'title' => __('Smooth Scroll', 'proton'),
                    'subtitle' => __('Switch on or off the smooth scroll effect, the website will scroll smothly.', 'proton'),
                    'default' => false,
                ),
                array(
                    'id' => 'proton_favicon',
                    'type' => 'media',
                    'title' => __('Favicon Upload', 'proton'),
                    'subtitle' => __('Upload your favicon, 16x16 preferred size in PNG format.', 'proton')
                ),
                array(
                    'id'=>'proton_custom_css',
                    'type' => 'ace_editor',
                    'title' => __('Custom CSS Code', 'proton'),
                    'subtitle' => __('Enter your Custom CSS.', 'proton'),
                    'mode' => 'css',
                    'theme' => 'monokai',
                ),
                array(
                    'id' => 'proton_custom_js',
                    'type' => 'ace_editor',
                    'title' => __('Custom JS Code', 'proton'),
                    'subtitle' => __('Enter your Custom Javascript.', 'proton'),
                    'mode' => 'javascript',
                    'theme' => 'monokai',
                ),
                array(
                    'id' => 'proton_google_analytics',
                    'type' => 'ace_editor',
                    'title' => __('Google Analytics', 'proton'),
                    'subtitle' => __('Enter your google analytics.', 'proton'),
                    'mode' => 'text',
                    'theme' => 'chrome',
                )
            )
        ));

    // Header Settings
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Header', 'proton' ),
        'id'               => 'header_settings',
        'desc'             => __( 'All Header Options are listed on this section.', 'proton' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-lines',
        'fields'           => array(
            array(
                'id' => 'proton_menu_type',
                'type' => 'image_select',
                'title' => __('Menu Type', 'proton'),
                'subtitle' => __('Select the menu style, classic is the standard one with logo in left and menu in right. Minimal and Overlay menu will open when hamburger bar is clicked.', 'proton'),
                'options' => array(
                    'classic' => array(
                        'title' => 'Classic',
                        'img' => get_template_directory_uri() . "" . '/includes/options/header_style/header-classic.png'
                    ),
                    'minimal' => array(
                        'title' => 'Minimal',
                        'img' => get_template_directory_uri() . "" . '/includes/options/header_style/header-minimal.png'
                    ),
                    'overlay' => array(
                        'title' => 'Overlay',
                        'img' => get_template_directory_uri() . "" . '/includes/options/header_style/header-overlay.png'
                    ),
                ),
                'default' => 'classic'
            ),
            array(
                'id' => 'proton_sticky_header',
                'type' => 'switch',
                'title' => __('Sticky Menu', 'proton'),
                'subtitle' => __('Enable or Disable the sticky menu, even if you scroll the header will stay fixed.', 'proton'),
                'default' => false,
            ),
            array(
                'id' => 'proton_logo',
                'type' => 'media',
                'title' => __('Logo', 'proton'),
                'subtitle' => __('Upload a .png or .jpg image that will be your logo.', 'proton')
            ),
            array(
                'id' => 'proton_white_logo',
                'type' => 'media',
                'title' => __('White Logo', 'proton'),
                'subtitle' => __('Upload a .png or .jpg image that will be your white logo, which will be displayed on overlay menu.', 'proton'),
                'required' => array( 'proton_menu_type', '=', 'overlay' ),
            ),
            array(
                'id' => 'proton_logo_width',
                'type' => 'text',
                'title' => __('Logo Width', 'proton'),
                'subtitle' => __('Enter the number to change the logo image width, enter only the number without {px}.', 'proton')
            ),
            array(
                'id' => 'proton_logo_height',
                'type' => 'text',
                'title' => __('Logo Height', 'proton'),
                'subtitle' => __('Enter the number to change the logo image height, enter only the number without {px}.', 'proton')
            ),
            array(
                'id' => 'proton_logo_text',
                'type' => 'text',
                'title' => __('Logo Text', 'proton'),
                'subtitle' => __('Enter the text that will appear as logo.', 'proton')
            ),
            array(
                'id' => 'proton_mini_cart',
                'type' => 'switch',
                'title' => __('Mini Cart', 'proton'),
                'subtitle' => __('Show or hide the mini cart on menu.', 'proton'),
                'default' => true,
                'on' => __('Show', 'proton'),
                'off' => __('Hide', 'proton')
            ),
        )
    ));

    // Footer Settings
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Footer', 'proton' ),
        'id'               => 'footer_settings',
        'desc'             => __( 'All Footer Options are listed on this section.', 'proton' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-th-list',
        'fields'           => array(
            array(
                'id' => 'proton_footer_parallax',
                'type' => 'switch',
                'title' => __('Footer Parallax', 'proton'),
                'subtitle' => __('Switch on if you want to make footer parallax.', 'proton'),
            ),
            array(
                'id' => 'proton_footer_widgets',
                'type' => 'switch',
                'title' => __('Footer Widgets', 'proton'),
                'subtitle' => __('Switch on if you want to show widgets on footer.', 'proton'),
            ),
            array(
                'id' => 'proton_footer_widgets_columns',
                'type' => 'image_select',
                'title' => __('Columns', 'proton'),
                'subtitle' => __('Select the columns of Widgets.', 'proton'),
                'required' => array( 'proton_footer_widgets', '=', true ),
                'options' => array(
                    'two' => array(
                        'title' => __('2 Columns', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_columns/2-col.png'
                    ),
                    'three' => array(
                        'title' => __('3 Columns', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_columns/3-col.png'
                    ),
                    'four' => array(
                        'title' => __('4 Columns', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_columns/4-col.png'
                    ),
                ),
                'default' => 'three'
            ),
            array(
                'id' => 'proton_footer_alignment',
                'type' => 'radio',
                'title' => __('Alignment', 'proton'),
                'subtitle' => __('Select the alignment of content.', 'proton'),
                'options' => array(
                    'left' => __('Left','proton'),
                    'center' => __('Center','proton'),
                    'right' => __('Right','proton'),
                ),
                'default' => 'left'
            ),
            array(
                'id' => 'proton_footer_copyright',
                'type' => 'editor',
                'args' => array(
                    'media_buttons' => false,
                ),
                'title' => __('Footer Copyright', 'proton'),
                'subtitle' => __('Enter the text that will appear in footer as copyright.', 'proton'),
            ),
            array(
                'id' => 'proton_footer_social_icons',
                'type' => 'switch',
                'title' => __('Social Icons', 'proton'),
                'subtitle' => __('Switch on if you want to show the social icons in footer.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_facebook_show',
                'type' => 'checkbox',
                'title' => __('Show Facebook Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_twitter_show',
                'type' => 'checkbox',
                'title' => __('Show Twitter Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_googleplus_show',
                'type' => 'checkbox',
                'title' => __('Show Google Plus Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_vimeo_show',
                'type' => 'checkbox',
                'title' => __('Show Vimeo Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_dribbble_show',
                'type' => 'checkbox',
                'title' => __('Show Dribbble Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_pinterest_show',
                'type' => 'checkbox',
                'title' => __('Show Pinterest Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_youtube_show',
                'type' => 'checkbox',
                'title' => __('Show Youtube Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_tumblr_show',
                'type' => 'checkbox',
                'title' => __('Show Tumblr Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_linkedin_show',
                'type' => 'checkbox',
                'title' => __('Show Linkedin Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_behance_show',
                'type' => 'checkbox',
                'title' => __('Show Behance Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_500px_show',
                'type' => 'checkbox',
                'title' => __('Show 500px Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_flickr_show',
                'type' => 'checkbox',
                'title' => __('Show Flickr Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_spotify_show',
                'type' => 'checkbox',
                'title' => __('Show Spotify Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_instagram_show',
                'type' => 'checkbox',
                'title' => __('Show Instagram Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_github_show',
                'type' => 'checkbox',
                'title' => __('Show GitHub Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_stackexchange_show',
                'type' => 'checkbox',
                'title' => __('Show StackExchange Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_soundcloud_show',
                'type' => 'checkbox',
                'title' => __('Show SoundCloud Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_vk_show',
                'type' => 'checkbox',
                'title' => __('Show VK Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
            array(
                'id' => 'proton_social_media_vine_show',
                'type' => 'checkbox',
                'title' => __('Show Vine Icon', 'proton'),
                'required' => array( 'proton_footer_social_icons', '=', true ),
            ),
        )
    ));

    // Style Settings
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Style', 'proton' ),
        'id'               => 'style_settings',
        'desc'             => __( 'All Style Options are listed on this section.', 'proton' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-brush',
        'fields'           => array(
            array(
                'id' => 'proton_body_color',
                'type' => 'color',
                'title' => __('Body Color', 'proton'),
                'subtitle' => __('Change the body color.', 'proton'),
            ),
            array(
                'id' => 'proton_main_color',
                'type' => 'color',
                'title' => __('Main Color', 'proton'),
                'subtitle' => __('Change all main elements color. ', 'proton'),
            ),
            array(
                'id' => 'proton_borders_color',
                'type' => 'color',
                'title' => __('Borders Color', 'proton'),
                'subtitle' => __('Change the borders color.', 'proton'),
            ),
            array(
                'id' => 'proton_header_color',
                'type' => 'color',
                'title' => __('Header Menu Color', 'proton'),
                'subtitle' => __('Change the header menu color.', 'proton'),
            ),
            array(
                'id' => 'proton_dropdown_color',
                'type' => 'color',
                'title' => __('Header Dropdown Color', 'proton'),
                'subtitle' => __('Change the header dropdown color.', 'proton'),
            ),
            array(
                'id' => 'proton_footer_color',
                'type' => 'color',
                'title' => __('Footer Color', 'proton'),
                'subtitle' => __('Change the footer color.', 'proton'),
            ),
        )
    ));

    // Portfolio and Single Settings
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Portfolio', 'proton' ),
        'id'               => 'portfolio_settings',
        'desc'             => __( 'All Portfolio Options are listed on this section.', 'proton' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-th',
        'fields'           => array(
            array(
                'id' => 'portfolio_style',
                'type' => 'image_select',
                'title' => __('Style', 'proton'),
                'subtitle' => __('Select the style layout of Portfolio.', 'proton'),
                'options' => array(
                    '1' => array(
                        'title' => __('Hover', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_style/hover.png'
                    ),
                    '2' => array(
                        'title' => __('Hover & NoSpace', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_style/hoverNospace.png'
                    ),
                    '3' => array(
                        'title' => __('Meta', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_style/meta.png'
                    ),
                    '4' => array(
                        'title' => __('Meta & NoSpace', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_style/metaNospace.png'
                    ),
                    '5' => array(
                        'title' => __('No Meta', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_style/noOverlay.png'
                    ),
                    '6' => array(
                        'title' => __('No Meta & NoSpace', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_style/noOverlayNospace.png'
                    ),

                ),
                'default' => '1',
            ),
            array(
                'id' => 'portfolio_hover',
                'type' => 'image_select',
                'title' => __('Hover Style', 'proton'),
                'subtitle' => __('Select the hover style of Portfolio, make sure to select first or second Portfolio style to make hover visible.', 'proton'),
                'options' => array(
                    '2' => array(
                        'title' => __('Meta Tags', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/hoverstyles/title+category.png'
                    ),
                    '1' => array(
                        'title' => __('Title', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/hoverstyles/title.png'
                    ),
                    '3' => array(
                        'title' => __('Gallery', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/hoverstyles/gallery.png'
                    ),
                    '5' => array(
                        'title' => __('Meta Tags & Boxed', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/hoverstyles/title+categoryBoxed.png'
                    ),
                    '4' => array(
                        'title' => __('Title & Boxed', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/hoverstyles/titleBoxed.png'
                    ),
                    '6' => array(
                        'title' => __('Gallery & Boxed', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/hoverstyles/galleryBoxed.png'
                    ),
                ),
                'default' => '2'
            ),
            array(
                'id' => 'portfolio_columns',
                'type' => 'image_select',
                'title' => __('Columns', 'proton'),
                'subtitle' => __('Select the columns of Portfolio.', 'proton'),
                'options' => array(
                    'two' => array(
                        'title' => __('2 Columns', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_columns/2-col.png'
                    ),
                    'three' => array(
                        'title' => __('3 Columns', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_columns/3-col.png'
                    ),
                    'four' => array(
                        'title' => __('4 Columns', 'proton'),
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_columns/4-col.png'
                    ),
                ),
                'default' => 'three'
            ),
            array(
                'id' => 'portfolio_meta_position',
                'type' => 'select',
                'title' => __('Text Position', 'proton'),
                'subtitle' => __('Please select text position, default is center.', 'proton'),
                'options' => array(
                    'center' => __('Center', 'proton'),
                    'top-left' => __('Top Left', 'proton'),
                    'top-right' => __('Top Right', 'proton'),
                    'bottom-left' => __('Bottom Left', 'proton'),
                    'bottom-right' => __('Bottom Right', 'proton'),
                ),
                'default' => 'center',
            ),
            array(
                'id' => 'portfolio_hover_effect',
                'type' => 'switch',
                'title' => __('Hover effect', 'proton'),
                'subtitle' => __('Switch on if you want to enable portfolio hover effect.', 'proton'),
            ),
            array(
                'id' => 'portfolio_masonry',
                'type' => 'switch',
                'title' => __('Masonry', 'proton'),
                'subtitle' => __('Switch on the Masonry style, the projects will be displayed in opposite of fixed rows.', 'proton')
            ),
            array(
                'id' => 'proton_portfolio_categories_link',
                'type' => 'switch',
                'title' => __('Portfolio Categories', 'proton'),
                'subtitle' => __('Hide links from categories in portfolio.', 'proton')
            ),
        )
    ));
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Portfolio Item', 'proton' ),
        'id'               => 'portfolio_item_settings',
        'desc'             => __( 'All Portfolio Item Options are listed on this section.', 'proton' ),
        'customizer_width' => '400px',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id' => 'portfolio_item_layout',
                'type' => 'image_select',
                'title' => __('Portfolio Item layout', 'proton'),
                'subtitle' => __('Select the style layout of Portfolio Item.', 'proton'),
                'options' => array(
                    '1' => array(
                        'title' => 'Single v1',
                        'img' => get_template_directory_uri() . "" . '/includes/options/single/single-v1.png'
                    ),
                    '2' => array(
                        'title' => 'Single v2',
                        'img' => get_template_directory_uri() . "" . '/includes/options/single/single-v2.png'
                    ),
                    '3' => array(
                        'title' => 'Single v3',
                        'img' => get_template_directory_uri() . "" . '/includes/options/single/single-v3.png'
                    ),
                    '4' => array(
                        'title' => 'Single v4',
                        'img' => get_template_directory_uri() . "" . '/includes/options/single/single-v4.png'
                    ),
                ),
                'default' => '1'
            ),
            array(
                'id' => 'portfolio_item_gallery_columns',
                'type' => 'image_select',
                'title' => __('Portfolio Item Gallery Columns', 'proton'),
                'subtitle' => __('Select the columns of Gallery.', 'proton'),
                'options' => array(
                    '1' => array(
                        'title' => 'Full Width',
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_columns/fullwidth.png'
                    ),
                    '2' => array(
                        'title' => '2 Columns',
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_columns/2-col.png'
                    ),
                    '3' => array(
                        'title' => '3 Columns',
                        'img' => get_template_directory_uri() . "" . '/includes/options/portfolio_columns/3-col.png'
                    ),
                ),
                'default' => '1'
            ),
            array(
                'id' => 'portfolio_item_navigation',
                'type' => 'switch',
                'title' => __('Portfolio Item Navigation', 'proton'),
                'subtitle' => __('Hide or show the navigation on portfolio single.', 'proton'),
                'on' => __("Show","proton"),
                'off' => __("Hide","proton"),
                'default' => true
            ),
            array(
                'id' => 'portfolio_item_categories',
                'type' => 'switch',
                'title' => __('Portfolio Item Categories', 'proton'),
                'subtitle' => __('Hide or show the categories on portfolio single.', 'proton'),
                'on' => __("Show","proton"),
                'off' => __("Hide","proton"),
                'default' => true
            ),
            array(
                'id' => 'portfolio_item_gallery',
                'type' => 'switch',
                'title' => __('Portfolio Item Gallery', 'proton'),
                'subtitle' => __('Switch on the Gallery, the projects will be displayed in fancybox slider.', 'proton')
            ),
            array(
                'id' => 'portfolio_item_embed_position',
                'type' => 'select',
                'title' => __('Embed Video Position', 'proton'),
                'subtitle' => __('Switch on the Gallery, the projects will be displayed in fancybox slider.', 'proton'),
                'options' => array(
                    '1' => __('Top', 'proton'),
                    '2' => __('Bottom', 'proton'),
                ),
                'default' => '1'
            ),
        )
    ));

    // Blog and Single Settings
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Blog', 'proton' ),
        'id'               => 'blog_settings',
        'desc'             => __( 'All Blog Options are listed on this section.', 'proton' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-list-alt',
        'fields'           => array(
            array(
                'id' => 'blog_layout',
                'type' => 'image_select',
                'title' => __('Blog Layout', 'proton'),
                'subtitle' => __('Select the style layout of Blog.', 'proton'),
                'options' => array(
                    '1' => array(
                        'title' => 'Classic',
                        'img' => get_template_directory_uri() . "" . '/includes/options/blog/classic.png'
                    ),
                    '2' => array(
                        'title' => 'Full Width',
                        'img' => get_template_directory_uri() . "" . '/includes/options/blog/fullwidth.png'
                    ),
                    '3' => array(
                        'title' => 'Grid',
                        'img' => get_template_directory_uri() . "" . '/includes/options/blog/grid.png'
                    ),
                    '4' => array(
                        'title' => 'Minimal',
                        'img' => get_template_directory_uri() . "" . '/includes/options/blog/minimal.png'
                    ),
                    '5' => array(
                        'title' => 'Creative',
                        'img' => get_template_directory_uri() . "" . '/includes/options/blog/creative.png'
                    ),
                ),
                'default' => '1'
            ),
            array(
                'id' => 'blog_sidebar',
                'type' => 'select',
                'title' => __('Sidebar', 'proton'),
                'subtitle' => __('Change the position of sidebar, sidebar is placed in Classic and Minimal.', 'proton'),
                'options' => array(
                    '1' => __('Left', 'proton'),
                    '2' => __('Right', 'proton'),
                ),
                'default' => '2',
            ),
            array(
                'id' => 'blog_pagination_position',
                'type' => 'select',
                'title' => __('Pagination Position', 'proton'),
                'subtitle' => __('Change the position of pagination.', 'proton'),
                'options' => array(
                    '1' => __('Left', 'proton'),
                    '2' => __('Center', 'proton'),
                    '3' => __('Right', 'proton'),
                ),
                'default' => '1',
            ),
            array(
                'id' => 'blog_author_info',
                'type' => 'checkbox',
                'title' => __('Show Author Info', 'proton'),
                'default' => '1',
            ),
            array(
                'id' => 'blog_categories',
                'type' => 'checkbox',
                'title' => __('Show Categories', 'proton'),
                'default' => '1',
            ),
            array(
                'id' => 'blog_post_date',
                'type' => 'checkbox',
                'title' => __('Show Post Date', 'proton'),
                'default' => '1',
            ),
        )
    ));
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Blog Single', 'proton' ),
        'id'               => 'blog_single',
        'desc'             => __( 'All Blog Single Options are listed on this section.', 'proton' ),
        'customizer_width' => '400px',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id' => 'blog_single_layout',
                'type' => 'image_select',
                'title' => __('Blog Single Layout', 'proton'),
                'subtitle' => __('Select the style layout of Blog Single.', 'proton'),
                'options' => array(
                    '1' => array(
                        'title' => 'Classic',
                        'img' => get_template_directory_uri() . "" . '/includes/options/blog/classic.png'
                    ),
                    '2' => array(
                        'title' => 'Full Width',
                        'img' => get_template_directory_uri() . "" . '/includes/options/blog/fullwidth.png'
                    ),
                ),
                'default' => '1'
            ),
            array(
                'id' => 'blog_single_sidebar',
                'type' => 'select',
                'title' => __('Sidebar', 'proton'),
                'subtitle' => __('Change the position of sidebar or hide it.', 'proton'),
                'options' => array(
                    '1' => __('Left', 'proton'),
                    '2' => __('Right', 'proton'),
                    '3' => __('Hide', 'proton'),
                ),
                'default' => '2',
            ),
            array(
                'id' => 'blog_single_thumbnail',
                'type' => 'checkbox',
                'title' => __('Show Thumbnail', 'proton'),
                'default' => '1',
            ),
            array(
                'id' => 'blog_single_author_info',
                'type' => 'checkbox',
                'title' => __('Show Author Info', 'proton'),
                'default' => '1',
            ),
            array(
                'id' => 'blog_single_categories',
                'type' => 'checkbox',
                'title' => __('Show Categories', 'proton'),
                'default' => '1',
            ),
            array(
                'id' => 'blog_single_post_date',
                'type' => 'checkbox',
                'title' => __('Show Post Date', 'proton'),
                'default' => '1',
            ),
            array(
                'id' => 'blog_single_next_previous',
                'type' => 'checkbox',
                'title' => __('Show Next-Previous Post Links', 'proton'),
            ),
        )
    ));

    // Shop Settings
    if(class_exists('WooCommerce')){
        Redux::setSection( $opt_name, array(
            'title'            => __( 'Shop', 'proton' ),
            'id'               => 'shop_settings',
            'desc'             => __( 'All Shop Options are listed on this section.', 'proton' ),
            'customizer_width' => '400px',
            'icon'             => 'el el-shopping-cart',
            'fields'           => array(
                array(
                    'id' => 'shop_columns',
                    'type' => 'image_select',
                    'title' => __('Columns', 'proton'),
                    'subtitle' => __('Select the columns of Shop Page.', 'proton'),
                    'options' => array(
                        '1' => array(
                            'title' => __('Classic', 'proton'),
                            'img' => get_template_directory_uri() . "" . '/includes/options/shop/classic.png'
                        ),
                        '2' => array(
                            'title' => __('Full Width', 'proton'),
                            'img' => get_template_directory_uri() . "" . '/includes/options/shop/fullwidth.png'
                        ),
                    ),
                    'default' => '1'
                ),
                array(
                    'id' => 'shop_page_title',
                    'title' => __('Page Title', 'proton'),
                    'subtitle' => __('Write the page title in Shop.', 'proton'),
                    'type' => 'editor',
                ),
            )
        ));
    }

    // Typography
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Typography', 'proton' ),
        'id'               => 'typography_settings',
        'desc'             => __( 'All Typography Options are listed on this section.', 'proton' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-font',
    ));
    // Typography > Header & Page Header
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Header & Page Header', 'proton' ),
        'id'               => 'typography_settings_header',
        'desc'             => __( 'All Typography Options are listed on this section.', 'proton' ),
        'customizer_width' => '400px',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id' => 'proton_header_font',
                'type' => 'typography',
                'title' => __('Header Font', 'proton'),
                'subtitle' => __('Change the Header font properties.', 'proton'),
                'text-transform' => true,
                'subsets' => false,
                'text-align' => false,
            ),
            array(
                'id' => 'proton_dropdown_font',
                'type' => 'typography',
                'title' => __('Header Dropdown Font', 'proton'),
                'subtitle' => __('Change the Header Dropdown font properties.', 'proton'),
                'text-transform' => true,
                'subsets' => false,
                'text-align' => false,
            ),
            array(
                'id' => 'proton_page_header_font',
                'type' => 'typography',
                'title' => __('Page Header Title Font', 'proton'),
                'subtitle' => __('Change the Page Header font properties.', 'proton'),
                'text-transform' => true,
                'subsets' => false,
                'text-align' => false,
            ),
        )
    ));
    // Typography > Basic HTML Elements
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Basic HTML Elements', 'proton' ),
        'id'               => 'typography_settings_basic',
        'customizer_width' => '400px',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id' => 'proton_body_font',
                'type' => 'typography',
                'title' => __('Body Font', 'proton'),
                'subtitle' => __('Change the Body font properties.', 'proton'),
                'text-transform' => true,
                'subsets' => false,
                'text-align' => false,
            ),
            array(
                'id' => 'proton_heading_one_font',
                'type' => 'typography',
                'title' => __('Heading One', 'proton'),
                'subtitle' => __('Change the H1 font properties.', 'proton'),
                'text-transform' => true,
                'subsets' => false,
                'text-align' => false,
            ),
            array(
                'id' => 'proton_heading_two_font',
                'type' => 'typography',
                'title' => __('Heading Two', 'proton'),
                'subtitle' => __('Change the H2 font properties.', 'proton'),
                'text-transform' => true,
                'subsets' => false,
                'text-align' => false,
            ),
            array(
                'id' => 'proton_heading_three_font',
                'type' => 'typography',
                'title' => __('Heading Three', 'proton'),
                'subtitle' => __('Change the H3 font properties.', 'proton'),
                'text-transform' => true,
                'subsets' => false,
                'text-align' => false,
            ),
            array(
                'id' => 'proton_heading_four_font',
                'type' => 'typography',
                'title' => __('Heading Four', 'proton'),
                'subtitle' => __('Change the H4 font properties.', 'proton'),
                'text-transform' => true,
                'subsets' => false,
                'text-align' => false,
            ),
            array(
                'id' => 'proton_heading_five_font',
                'type' => 'typography',
                'title' => __('Heading Five', 'proton'),
                'subtitle' => __('Change the H5 font properties.', 'proton'),
                'text-transform' => true,
                'subsets' => false,
                'text-align' => false,
            ),
            array(
                'id' => 'proton_heading_six_font',
                'type' => 'typography',
                'title' => __('Heading Six', 'proton'),
                'subtitle' => __('Change the H6 font properties.', 'proton'),
                'text-transform' => true,
                'subsets' => false,
                'text-align' => false,
            ),
        )
    ));


    // Social Media
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Social Media', 'proton' ),
        'id'               => 'social-media',
        'desc'             => __( 'Enter in your social media locations here and then activate which ones you would like to display. <br><b> Remember to include the "http://" in all URLs!</b>', 'proton' ),
        'icon'             => 'el el-share',
        'fields'           => array(
            array(
                'id' => 'proton_social_media_facebook',
                'type' => 'text',
                'title' => __('Facebook URL', 'proton'),
                'subtitle' => __('Please enter your Facebook URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_twitter',
                'type' => 'text',
                'title' => __('Twitter URL', 'proton'),
                'subtitle' => __('Please enter your Twitter URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_googleplus',
                'type' => 'text',
                'title' => __('Google Plus URL', 'proton'),
                'subtitle' => __('Please enter your Google Plus URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_vimeo',
                'type' => 'text',
                'title' => __('Vimeo URL', 'proton'),
                'subtitle' => __('Please enter your Vimeo URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_dribbble',
                'type' => 'text',
                'title' => __('Dribbble URL', 'proton'),
                'subtitle' => __('Please enter your Dribbble URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_pinterest',
                'type' => 'text',
                'title' => __('Pinterest URL', 'proton'),
                'subtitle' => __('Please enter your Pinterest URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_youtube',
                'type' => 'text',
                'title' => __('Youtube URL', 'proton'),
                'subtitle' => __('Please enter your Youtube URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_tumblr',
                'type' => 'text',
                'title' => __('Tumblr URL', 'proton'),
                'subtitle' => __('Please enter your Tumblr URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_linkedin',
                'type' => 'text',
                'title' => __('Linkedin URL', 'proton'),
                'subtitle' => __('Please enter your Linkedin URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_behance',
                'type' => 'text',
                'title' => __('Behance URL', 'proton'),
                'subtitle' => __('Please enter your Behance URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_500px',
                'type' => 'text',
                'title' => __('500px URL', 'proton'),
                'subtitle' => __('Please enter your 500px URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_flickr',
                'type' => 'text',
                'title' => __('Flickr URL', 'proton'),
                'subtitle' => __('Please enter your Flickr URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_spotify',
                'type' => 'text',
                'title' => __('Spotify URL', 'proton'),
                'subtitle' => __('Please enter your Spotify URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_instagram',
                'type' => 'text',
                'title' => __('Instagram URL', 'proton'),
                'subtitle' => __('Please enter your Instagram URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_github',
                'type' => 'text',
                'title' => __('GitHub URL', 'proton'),
                'subtitle' => __('Please enter your GitHub URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_stackexchange',
                'type' => 'text',
                'title' => __('StackExchange URL', 'proton'),
                'subtitle' => __('Please enter your StackExchange URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_soundcloud',
                'type' => 'text',
                'title' => __('SoundCloud URL', 'proton'),
                'subtitle' => __('Please enter your SoundCloud URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_vk',
                'type' => 'text',
                'title' => __('VK URL', 'proton'),
                'subtitle' => __('Please enter your VK URL.', 'proton'),
            ),
            array(
                'id' => 'proton_social_media_vine',
                'type' => 'text',
                'title' => __('Vine URL', 'proton'),
                'subtitle' => __('Please enter your Vine URL.', 'proton'),
            ),
        )
    ));


    // if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
    //     $section = array(
    //         'icon'   => 'el el-list-alt',
    //         'title'  => __( 'Documentation', 'proton' ),
    //         'fields' => array(
    //             array(
    //                 'id'       => '17',
    //                 'type'     => 'raw',
    //                 'markdown' => true,
    //                 'content_path' => dirname( __FILE__ ) . '/../README.md', // FULL PATH, not relative please
    //                 //'content' => 'Raw content here',
    //             ),
    //         ),
    //     );
    //     Redux::setSection( $opt_name, $section );
    // }

    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'proton' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'proton' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }
