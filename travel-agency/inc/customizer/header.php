<?php
/**
 * Header Settings
 *
 * @package Travel_Agency
 */

function travel_agency_customize_register_header( $wp_customize ) {
	
    $wp_customize->add_panel( 'header_setting', array(
        'title'      => __( 'Logo & Header Settings', 'travel-agency' ),
        'priority'   => 20,
        'capability' => 'edit_theme_options',
    ) );
    
    $wp_customize->get_section( 'title_tagline' )->panel = 'header_setting';
    
    $wp_customize->add_section( 'header_misc_setting', array(
        'title'    => __( 'Misc Settings', 'travel-agency' ),
        'priority' => 35,
        'panel'    => 'header_setting',
    ) );
    
    /** Enable/Disable Search Form */
    $wp_customize->add_setting(
        'ed_search',
        array(
            'default'           => true,
            'sanitize_callback' => 'travel_agency_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
		'ed_search',
		array(
			'section'	  => 'header_misc_setting',
			'label'		  => __( 'Search Form', 'travel-agency' ),
			'description' => __( 'Enable to show search form in header.', 'travel-agency' ),
            'type'        => 'checkbox'
		)		
	);
    
    /** Phone Number  */
    $wp_customize->add_setting(
        'phone',
        array(
            'default'           => __( '(888) 123-45678', 'travel-agency' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'phone',
        array(
            'label'       => __( 'Phone Number', 'travel-agency' ),
            'description' => __( 'Add phone no. in header.', 'travel-agency' ),
            'section'     => 'header_misc_setting',
            'type'        => 'text',
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'phone', array(
        'selector'        => '.site-header .header-b .phone',
        'render_callback' => 'travel_agency_get_header_phone',
    ) );
    
    /** Phone Label  */
    $wp_customize->add_setting(
        'phone_label',
        array(
            'default'           => __( 'Call us, we are open 24/7', 'travel-agency' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'phone_label',
        array(
            'label'       => __( 'Phone Label', 'travel-agency' ),
            'description' => __( 'Add phone label in header.', 'travel-agency' ),
            'section'     => 'header_misc_setting',
            'type'        => 'text',
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'phone_label', array(
        'selector' => '.site-header .header-b .phone-label',
        'render_callback' => 'travel_agency_get_phone_label',
    ) );

    $wp_customize->add_setting(
        'ed_open_whatsapp',
        array(
            'default'           => false,
            'sanitize_callback' => 'travel_agency_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'ed_open_whatsapp',
        array(
            'section'  => 'header_misc_setting',
            'label'    => __( 'Link to WhatsApp', 'travel-agency' ),
            'type'     => 'checkbox'
        )
    );

    /** Default WhatsApp Message */
    $wp_customize->add_setting(
        'whatsapp_msg_lbl',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    
    $wp_customize->add_control(
        'whatsapp_msg_lbl',
        array(
            'section'  => 'header_misc_setting',
            'label'    => __( 'Default WhatsApp Message', 'travel-agency' ),
            'type'     => 'text',
        )		
	);

    $wp_customize->add_section( 
        'header_layout_setting',
            array(
            'title'    => __( 'Layout Settings', 'travel-agency' ),
            'priority' => 30,
            'panel'    => 'header_setting',
        ) 
    );
    
    /** Note */
    $wp_customize->add_setting(
        'layout_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );

    $wp_customize->add_control(
        new Travel_Agency_Note_Control( 
            $wp_customize,
            'layout_text',
            array(
                'section'     => 'header_layout_setting',
                'description' => sprintf( __( '%1$sThis feature is available in Pro version.%2$s %3$sUpgrade to Pro%4$s ', 'travel-agency' ),'<div class="featured-pro"><span>', '</span>', '<a href="https://rarathemes.com/wordpress-themes/travel-agency-pro/?utm_source=travel_agency&utm_medium=customizer&utm_campaign=upgrade_to_pro" target="_blank">', '</a></div>' ),
            )
        )
    );


    $wp_customize->add_setting( 
        'layout_image_settings', 
        array(
            'default'           => 'one',
            'sanitize_callback' => 'travel_agency_sanitize_radio',
        ) 
    );

    $wp_customize->add_control(
        new Travel_Agency_Radio_Image_Control(
            $wp_customize,
            'layout_image_settings',
            array(
                'section'     => 'header_layout_setting',
                'feat_class' => 'upg-to-pro',
                'choices'     => array(
                    'one'       => get_template_directory_uri() . '/images/pro/header-layout.png',
                ),
            )
        )
    );
    
}
add_action( 'customize_register', 'travel_agency_customize_register_header' );