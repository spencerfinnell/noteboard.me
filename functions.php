<?php
/**
 * Noteboard functions and definitions
 *
 * @package Noteboard
 * @since Noteboard 1.0
 */
 
$files = apply_filters( 'noteboard_setup_include', array(
	'options/nhp-options.php',
	'general-functions.php',
	'general-template.php',
	'groups-functions.php',
	'groups-template.php',
	'notes-functions.php',
	'notes-template.php',
	'users.php'
) );

foreach ( $files as $file ) {
	require_once( sprintf( '%1$s/inc/%2$s', get_template_directory(), $file ) );
} 
 
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Noteboard 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'noteboard_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Noteboard 1.0
 */
function noteboard_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Noteboard, use a find and replace
	 * to change 'noteboard' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'noteboard', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'noteboard' ),
	) );
	
	remove_action( 'wp_footer', array( 'WpeCommon', 'wpe_emit_powered_by_html' ) );
}
endif; // noteboard_setup
add_action( 'after_setup_theme', 'noteboard_setup' );