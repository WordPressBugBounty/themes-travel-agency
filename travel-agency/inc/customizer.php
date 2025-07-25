<?php
/**
 * Travel Agency Theme Customizer
 *
 * @package Travel_Agency
 */

$travel_agency_sections = array( 'info', 'demo', 'header', 'social', 'home', 'general', 'footer', 'elementor' );

foreach( $travel_agency_sections as $section ){
    require get_template_directory() . '/inc/customizer/' . $section . '.php';
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function travel_agency_customize_preview_js() {
	wp_enqueue_style( 'travel-agency-customizer', get_template_directory_uri() . '/inc/css/customizer.css', array(), TRAVEL_AGENCY_THEME_VERSION );
    wp_enqueue_script( 'travel_agency_customizer', get_theme_file_uri( '/inc/js/customizer.js' ), array( 'customize-preview', 'customize-selective-refresh' ), TRAVEL_AGENCY_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'travel_agency_customize_preview_js' );

function travel_agency_customizer_scripts() {
    wp_enqueue_style( 'travel-agency-customize',get_template_directory_uri().'/inc/css/customize.css', TRAVEL_AGENCY_THEME_VERSION, 'screen' );
    wp_enqueue_script( 'travel_agency_customize', get_template_directory_uri() . '/inc/js/customize.js', array( 'jquery' ), TRAVEL_AGENCY_THEME_VERSION, true );

    $array = array(
        'home' => get_home_url(),
		'ajax_url'   => admin_url( 'admin-ajax.php' ),
    	'flushit'    => __( 'Successfully Flushed!','travel-agency' ),
    	'nonce'      => wp_create_nonce('ajax-nonce')
    );
    wp_localize_script( 'travel_agency_customize', 'tadata', $array );

	wp_localize_script( 'travel-agency-repeater', 'tap_customize',
		array(
			'nonce' => wp_create_nonce( 'tap_customize_nonce' )
		)
	);
}
add_action( 'customize_controls_enqueue_scripts', 'travel_agency_customizer_scripts' );

/**
 * Sanitize callback for checkbox
*/
function travel_agency_sanitize_checkbox( $checked ){
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Sanitize callback for select
*/
function travel_agency_sanitize_select( $input, $setting ){
    // Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/*
 * Notifications in customizer
 */
require get_template_directory() . '/inc/customizer-plugin-recommend/customizer-notice/class-customizer-notice.php';

require get_template_directory() . '/inc/customizer-plugin-recommend/plugin-install/class-plugin-install-helper.php';

require get_template_directory() . '/inc/customizer-plugin-recommend/section-notice/class-section-notice.php';

if( ! function_exists( 'travel_agency_customizer_notice_init' ) ) {
	function travel_agency_customizer_notice_init() {
		$travel_agency_config_customizer = array(
			'recommended_plugins' => array( 
				'travel-agency-companion' => array(
					'recommended' => true,
					'description' => sprintf( esc_html__( 'If you want to take full advantage of the features this theme has to offer, please install and activate %s plugin.', 'travel-agency' ), '<strong>Travel Agency Companion</strong>' ),
				),
			),
			'recommended_plugins_title' => esc_html__( 'Recommended Plugin', 'travel-agency' ),
			'install_button_label'      => esc_html__( 'Install and Activate', 'travel-agency' ),
			'activate_button_label'     => esc_html__( 'Activate', 'travel-agency' ),
			'deactivate_button_label'   => esc_html__( 'Deactivate', 'travel-agency' ),
		);
		Travel_Agency_Customizer_Notice::init( apply_filters( 'travel_agency_customizer_notice_array', $travel_agency_config_customizer ) );
	}
}
add_action( 'init', 'travel_agency_customizer_notice_init' );

Travel_Agency_Customizer_Section::get_instance();


/**
 * Travel Agency Custom Control
 * 
 * @package Travel_Agency
*/

if( ! function_exists( 'travel_agency_register_custom_controls' ) ) :
/**
 * Register Custom Controls
*/
function travel_agency_register_custom_controls( $wp_customize ){    
	// Load our custom control.
	require_once get_template_directory() . '/inc/custom-controls/note/class-note-control.php';
	require_once get_template_directory() . '/inc/custom-controls/radioimg/class-radio-image-control.php';
			
	// Register the control type.
	$wp_customize->register_control_type( 'Travel_Agency_Radio_Image_Control' );
}
endif;
add_action( 'customize_register', 'travel_agency_register_custom_controls', 8 );


/**
 * Sanitize radio button
 */
function travel_agency_sanitize_radio( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}