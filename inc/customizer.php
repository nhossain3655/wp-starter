<?php
/**
 * starter Theme Customizer
 *
 * @package starter
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */


 /* =============
 Sanitization Added
 ==============*/
 //checkbox sanitize
if ( ! function_exists( 'starter_checkbox_sanitization' ) ) {
    function starter_checkbox_sanitization( $checked ) {
        // Boolean check.
        return ( ( isset( $checked ) && true == $checked ) ? true : false );
    }
}
        //URL sanitize
        if ( ! function_exists( 'starter_url_sanitization' ) ) {
                function starter_url_sanitization( $input ) {
                    if ( strpos( $input, ',' ) !== false) {
                        $input = explode( ',', $input );
                    }
                    if ( is_array( $input ) ) {
                        foreach ($input as $key => $value) {
                            $input[$key] = esc_url_raw( $value );
                        }
                        $input = implode( ',', $input );
                    }
                    else {
                        $input = esc_url_raw( $input );
                    }
                    return $input;
                }
            }

//File sanitize
        if ( ! function_exists( 'starter_file_sanitization' ) ) {
            function starter_file_sanitization( $file, $setting ) {
              
                //allowed file types
                $mimes = array(
                    'jpg|jpeg|jpe' => 'image/jpeg',
                    'gif'          => 'image/gif',
                    'png'          => 'image/png',
                    'webp'          => 'image/webp'
                );
                  
                //check file type from file name
                $file_ext = wp_check_filetype( $file, $mimes );
                  
                //if file has a valid mime type return it, otherwise return default
                return ( $file_ext['ext'] ? $file : $setting->default );
            }
        }
/* END of Sanitizations */


function starter_customize_register( $wp_customize ) {
    /*=========================
    Theme Options Added
    =========================*/
    // Creating Panel
    $wp_customize->add_panel(
        'starter_theme_options', 
        array (
            'title' => __('Theme Options', 'starter'),
            'priority' => 160,
        ));

    // Adding Section in panel
    $wp_customize->add_section(
        'menu_option',
        array(
            'title' => __( 'Navigation Menu Options', 'starter' ),
            //'description' => __( 'This is a section for the nav', 'starter' ),
            'panel' => 'starter_theme_options',
            'priority' => 30,
        )
    );
    // Nav alignment configure
    $wp_customize->add_setting( 
        'main_menu_setting', 
        array(
        'default'   => 'sina-menu-left',
        'type'       => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ) );

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'menu_alignment_setting', array(
        'label' => __( 'Menu Alignment', 'starter' ),
        'section'    => 'menu_option',
        'settings'   => 'main_menu_setting',
        'type'    => 'select',
        'choices' => array(
            'sina-menu-left' => __('Left', 'starter'),
            'sina-menu-center' => __('Center', 'starter'),
            'sina-menu-right' => __('Right', 'starter'),
        )
    ) ) );

    // Nav Fixed to Top Configure
    $wp_customize->add_setting( 
        'fixed_nav_setting', 
        array(
        'default'   => 'no',
        'type'       => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ) );

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'fixed_nav_setting', array(
        'label' => __( 'Enable Fixed Menu', 'starter' ),
        'section'    => 'menu_option',
        'settings'   => 'fixed_nav_setting',
        'type'    => 'select',
        'choices' => array(
            'yes' => __( 'Yes', 'starter' ),
            'no' => __( 'No', 'starter' ),
        )
    ) ) );

    // Right Search Configure
    $wp_customize->add_setting( 
        'right_search_setting', 
        array(
        'default'   => 'no',
        'type'       => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ) );

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'right_search_setting', array(
        'label' => __( 'Show Right Side Search Option', 'starter' ),
        'section'    => 'menu_option',
        'settings'   => 'right_search_setting',
        'type'    => 'select',
        'choices' => array(
            'yes' => __( 'Yes', 'starter' ),
            'no' => __( 'No', 'starter' ),
        )
    ) ) );

    // Right Menu Configure
    $wp_customize->add_setting( 
        'right_menu_setting', 
        array(
        'default'   => 'no',
        'type'       => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ) );

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'right_menu_setting', array(
        'label' => __( 'Show Right Side Menu', 'starter' ),
        'section'    => 'menu_option',
        'settings'   => 'right_menu_setting',
        'type'    => 'select',
        'choices' => array(
            'yes' => __( 'Yes', 'starter' ),
            'no' => __( 'No', 'starter' ),
        )
    ) ) );

    // Show Social Icons Configure
    $wp_customize->add_setting( 
        'social_icon_setting', 
        array(
        'default'   => 'no',
        'type'       => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ) );

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'social_icon_setting', array(
        'label' => __( 'Show Social Icons', 'starter' ),
        'section'    => 'menu_option',
        'settings'   => 'social_icon_setting',
        'type'    => 'select',
        'choices' => array(
            'yes' => __( 'Yes', 'starter' ),
            'no' => __( 'No', 'starter' ),
        )
    ) ) );

    // Social Icon repeater
    $wp_customize->add_setting( 'starter_customizer_repeater', array(
         'sanitize_callback' => 'customizer_repeater_sanitize',
         'default' => json_encode( array(
            /*Repeater's first item*/
            array("icon_value" => "fab fa-facebook-f" ,"link" => "https://facebook.com", "id" => "customizer_repeater_56d7ea7f40f56" ), 
            array("icon_value" => "fab fa-twitter" ,"link" => "https://twitter.com", "id" => "customizer_repeater_56d7ea7f40f57" ), 
            array("icon_value" => "fab fa-linkedin-in" ,"link" => "https://linkedin.com", "id" => "customizer_repeater_56d7ea7f40f58" ), 
            ) )
      ));
    $wp_customize->add_control( new Customizer_Repeater( $wp_customize, 'starter_customizer_repeater', array(
    'label'   => esc_html__('Icons to Show','starter'),
    'section' => 'menu_option',
    'priority' => 160,
    'customizer_repeater_image_control' => false,
    'customizer_repeater_icon_control' => true,
    'customizer_repeater_title_control' => false,
    'customizer_repeater_subtitle_control' => false,
    'customizer_repeater_text_control' => false,
    'customizer_repeater_link_control' => true,
    'customizer_repeater_shortcode_control' => false,
    'customizer_repeater_repeater_control' => false
 ) ) );


    /*=============
    Header background section for different pages
    =============*/
    $wp_customize->add_section(
        'title_bg_section',
        array(
            'title' => __( 'Page Title Customization', 'starter' ),
            'panel'  => 'starter_theme_options',
            'priority' => 30,
        )
    );


    //color selection BLOG page
    $wp_customize->add_setting(
        'blog_title_bg_color',
        array(
            'default'     => '#333',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
            'blog_title_bg_color',
            array(
                'label'      => __( 'Blog page title background color', 'starter' ),
                'section'    => 'title_bg_section',
                'settings'   => 'blog_title_bg_color',
            ) )
    );


    //image selection BLOG page
        $wp_customize->add_setting( 
            'blog_title_bg_image', 
            array(
                'sanitize_callback' => 'starter_file_sanitization'
            )
        );
          
          
        $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 
                'blog_title_bg_image', 
                array(
                    'label'      => __( 'Blog page title background image', 'starter' ),
                    'section'    => 'title_bg_section'                   
                )
            ) 
        );  
    

    //color selection ARCHIVE/CATEGORY/TAG page
    $wp_customize->add_setting(
        'archive_title_bg_color',
        array(
            'default'     => '#333',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
            'archive_title_bg_color',
            array(
                'label'      => __( 'Archive page title background color', 'starter' ),
                'section'    => 'title_bg_section',
                'settings'   => 'archive_title_bg_color',
            ) )
    );


    //image selection ARCHIVE/CATEGORY/TAG page
        $wp_customize->add_setting( 
            'archive_title_bg_image', 
            array(
                'sanitize_callback' => 'starter_file_sanitization'
            )
        );
          
          
        $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 
                'archive_title_bg_image', 
                array(
                    'label'      => __( 'Archive page title background image', 'starter' ),
                    'section'    => 'title_bg_section'                   
                )
            ) 
        );  
    

    //color selection SEARCH page
    $wp_customize->add_setting(
        'search_title_bg_color',
        array(
            'default'     => '#333',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
            'search_title_bg_color',
            array(
                'label'      => __( 'Search page title background color', 'starter' ),
                'section'    => 'title_bg_section',
                'settings'   => 'search_title_bg_color',
            ) )
    );


    //image selection SEARCH page
        $wp_customize->add_setting( 
            'search_title_bg_image', 
            array(
                'sanitize_callback' => 'starter_file_sanitization'
            )
        );
          
          
        $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 
                'search_title_bg_image', 
                array(
                    'label'      => __( 'Search page title background image', 'starter' ),
                    'section'    => 'title_bg_section'                   
                )
            ) 
        );  
    

    //color selection 404 page
    $wp_customize->add_setting(
        'nfound_title_bg_color',
        array(
            'default'     => '#333',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize,
            'nfound_title_bg_color',
            array(
                'label'      => __( '404 page title background color', 'starter' ),
                'section'    => 'title_bg_section',
                'settings'   => 'nfound_title_bg_color',
            ) )
    );


    //image selection 404 page
        $wp_customize->add_setting( 
            'nfound_title_bg_image', 
            array(
                'sanitize_callback' => 'starter_file_sanitization'
            )
        );
          
          
        $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 
                'nfound_title_bg_image', 
                array(
                    'label'      => __( '404 page title background image', 'starter' ),
                    'section'    => 'title_bg_section'                   
                )
            ) 
        );  

    /*============ 
    Adding Section in panel for Other Customization
    ============*/
    $wp_customize->add_section(
        'other_customize',
        array(
            'title' => __( 'Other Customization', 'starter' ),
            //'description' => __( 'This is a section for the nav', 'starter' ),
            'panel' => 'starter_theme_options',
            'priority' => 30,
        )
    );
    // Nav alignment configure
    $wp_customize->add_setting( 
        'smooth_scroll', 
        array(
        'default'   => 'no',
        'type'       => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ) );

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'smooth_scroll', array(
        'label' => __( 'Enable smooth scrolling', 'starter' ),
        'section'    => 'other_customize',
        'settings'   => 'smooth_scroll',
        'type'    => 'select',
        'choices' => array(
            'yes' => __('Yes', 'starter'),
            'no' => __('No', 'starter')
        )
    ) ) ); // Custom theme option ends


	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'starter_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'starter_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'starter_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function starter_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function starter_customize_partial_blogdescription() {
	bloginfo( 'description' );
}



// Starter generate CSS added
add_action( 'wp_head', 'starter_gen_customizer_css');
function starter_gen_customizer_css()
{
    ?>
    <style type="text/css">
        .blog-title { background-color: <?php echo get_theme_mod('blog_title_bg_color', '#333'); ?>; 
        <?php if(!empty(get_theme_mod('blog_title_bg_image'))) :  ?>
            background-image: url(
        <?php echo get_theme_mod('blog_title_bg_image'); ?>); <?php endif;  ?> }

        .archive-title { background-color: <?php echo get_theme_mod('archive_title_bg_color', '#333'); ?>; 
        <?php if(!empty(get_theme_mod('archive_title_bg_image'))) :  ?>
            background-image: url(
        <?php echo get_theme_mod('archive_title_bg_image'); ?>); <?php endif;  ?> }

        .search-title { background-color: <?php echo get_theme_mod('search_title_bg_color', '#333'); ?>; 
        <?php if(!empty(get_theme_mod('search_title_bg_image'))) : ?>
            background-image: url(
        <?php echo get_theme_mod('search_title_bg_image'); ?>); <?php endif;  ?> }

        .nfound-title { background-color: <?php echo get_theme_mod('nfound_title_bg_color', '#333'); ?>; 
        <?php if(!empty(get_theme_mod('nfound_title_bg_image'))) : ?>
            background-image: url(
        <?php echo get_theme_mod('nfound_title_bg_image'); ?>); <?php endif;  ?> }
    </style>
    <?php
}


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function starter_customize_preview_js() {
	wp_enqueue_script( 'starter-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'starter_customize_preview_js' );
