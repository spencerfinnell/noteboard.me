<?php
/**
 *
 */
if( ! class_exists( 'NHP_Options' ) ) {
	require_once( dirname( __FILE__ ) . '/options/options.php' );
}

/**
 *
 */
function setup_framework_options(){
	$args = array(
		'dev_mode'           => false,
		'show_import_export' => false,
		'opt_name'           => 'noteboard',
		'menu_title'         => __( 'Theme Options', 'noteboard' ),
		'page_title'         => __('Noteboard Theme Options', 'noteboard' ),
		'page_type'          => 'submenu',
		'page_slug'          => 'noteboard_theme_options'
	);
	
	$sections = array(
		array(
			'icon'  => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_107_text_resize.png',
			'title' => __( 'General Settings', 'noteboard' ),
			'desc'  => __( 'General settings are so cool, yeah!', 'noteboard' ),
			'fields' => array(
				array(
					'id'       => 'noteboard-groups',
					'type'     => 'pages_select',
					'title'    => __( 'Groups Page', 'noteboard' ), 
					'sub_desc' => '',
					'desc'     => '',
					'std'      => ''
				),
				array(
					'id'       => 'noteboard-groups-new',
					'type'     => 'pages_select',
					'title'    => __( 'New Group Page', 'noteboard' ), 
					'sub_desc' => '',
					'desc'     => '',
					'std'      => ''
				),
				array(
					'id'       => 'noteboard-notes-new',
					'type'     => 'pages_select',
					'title'    => __( 'New Note Page', 'noteboard' ), 
					'sub_desc' => '',
					'desc'     => '',
					'std'      => ''
				),
				array(
					'id'       => 'noteboard-login',
					'type'     => 'pages_select',
					'title'    => __( 'Login Page', 'noteboard' ), 
					'sub_desc' => '',
					'desc'     => '',
					'std'      => ''
				),
				array(
					'id'       => 'noteboard-register',
					'type'     => 'pages_select',
					'title'    => __( 'Register Page', 'noteboard' ), 
					'sub_desc' => '',
					'desc'     => '',
					'std'      => ''
				),
			)
		)
	);
				
	$tabs = array();
			
	global $noteboard;
	
	$noteboard = new NHP_Options( $sections, $args, $tabs );
}
add_action( 'init', 'setup_framework_options', 0 );