<?php
/**
 * General functions.
 *
 * These functions are generally attached to a hook or filter
 * and called automatically.
 *
 * @package Noteboard
 * @since Noteboard 1.0
 */

/**
 * Endpoints
 *
 * Register endpoints for editing and deleting notes
 * and groups. This allows /edit and /delete to be added to
 * URLS to create boss permastucts.
 *
 * @since Noteboard 1.0
 *
 * @return void
 */  
function noteboard_add_endpoints() {
	add_rewrite_endpoint( 'edit', EP_ALL );
	add_rewrite_endpoint( 'delete', EP_ALL );
}
add_action( 'init', 'noteboard_add_endpoints' );
 
/**
 * Query Vars
 *
 * Properly register query var so they can be called via the
 * WP_Query class, and used correctly and safely.
 *
 * @since Noteboard 1.0
 *
 * @param array $vars Existing query variables
 * @return arrat $vars Updated list of query variables
 */  
function noteboard_add_query_vars( $vars ) {
	$vars[] = 'group';
	
	return $vars;
}
add_filter( 'query_vars', 'noteboard_add_query_vars' );
 
/**
 * Rewrites
 *
 * Custom rewrite rules for adding groups, etc.
 *
 * @since Noteboard 1.0
 *
 * @return void
 */   
function noteboard_add_rewrites() {
	add_rewrite_rule( 'notes/add/group/([^/]+)/?$', 'index.php?pagename=notes/add&group=$matches[1]','top');
}
add_action( 'init', 'noteboard_add_rewrites' );

/**
 * Auth Redirect
 *
 * Everything requires you to be logged in, so check everything.
 *
 * As soon as we know where we are, check to see what's up. If you are
 * not logged in, use the default `auth_redirect()` to redirect to the login page.
 *
 * @since Noteboard 1.0
 *
 * @return void
 */ 
function noteboard_require_login() {
	global $noteboard;
	
	if ( ! ( is_page( $noteboard->get( 'noteboard-login' ) ) || $noteboard->get( 'noteboard-register' ) ) && ! is_user_logged_in() )
		auth_redirect();
		
	if ( is_home() && ! is_user_logged_in() )
		auth_redirect();
}
add_action( 'wp', 'noteboard_require_login' );

/**
 * Set the Login URL
 *
 * Filter the default login URL away from wp-login.php
 * Allows the use of core functions such as auth_redirect()
 * to use the templated login form.
 *
 * @since Noteboard 1.0
 *
 * @param string $url The original (default) login URL
 * @param string The new login URL
 */ 
function noteboard_login_url( $url ) {
	global $noteboard;
	
	return get_permalink( $noteboard->get( 'noteboard-login' ) );
}
add_filter( 'login_url', 'noteboard_login_url' );

/**
 * Template loader
 *
 * Borrowed from WooCommerce, this allows a template to be loaded
 * and variables passed to it instead of setting globals.
 *
 * @see https://github.com/woothemes/woocommerce/blob/master/woocommerce-core-functions.php#L249
 *
 * @since Noteboard 1.0
 *
 * @param string $template_name The name of the template (including extension)
 * @param array $args An array of variables to pass to the template
 * @return mixed
 */ 
function noteboard_get_template( $template_name, $args = array(), $template_path = 'parts', $once = false ) {
	if ( $args && is_array( $args ) ) 
		extract( $args );

	$located = locate_template( array( trailingslashit( $template_path ) . $template_name ) );

	if ( ! $once )
		require( $located );
	else
		require_once( $located );
		
	return;
}

/**
 * Returns the <title> tag based on what is being viewed.
 *
 * @since Noteboard 1.0
 *
 * @param string $title The current page title
 * @param string $sep The separatating character
 * @return string $title The newly filtered title
 */
function noteboard_wp_title( $title, $sep ) {
	global $paged, $page, $wp_query, $post;

	$title .= get_bloginfo( 'name' );

	$site_description = get_bloginfo( 'description', 'display' );
	
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	
	/** edit a group */
	if ( get_query_var( 'edit' ) && ! is_singular( 'note' ) ) {
		$slug  = $wp_query->query[ 'attachment' ];
		$group = get_term_by( 'slug', $slug, 'group' );
		
		$title = sprintf( __( 'Edit Group &lsaquo; %s %s %s', 'noteboard' ), $group->description, $sep, $title );
	/** edit a note */
	} elseif ( get_query_var( 'edit' ) && is_singular( 'note' ) )
		$title = sprintf( __( 'Edit Note &lsaquo; %s', 'noteboard' ), $title );
	
	/** viewing a group */
	if ( is_tax( 'group' ) && ! is_singular( 'note' ) ) {
		$group = get_queried_object();
	/** viewing a note */
	} else if ( is_singular( 'note' ) ) {
		if ( $post->post_title == '' )
			$post->post_title = __( 'Untitled', 'noteboard' );
			
		$group = wp_get_object_terms( $post->ID, 'group' );
		$group = current( $group );
		
		$title = sprintf( '%s &lsaquo; %s %s %s', $group->description, $post->post_title, $sep, get_bloginfo( 'name' ) );
	}
	
	return $title;
}
add_filter( 'wp_title', 'noteboard_wp_title', 10, 2 );

/**
 * Scripts and Styles
 *
 * Depending on where we are, and what we are doing, load
 * certains scripts and styles. 
 *
 * @since Noteboard 1.0
 *
 * @return void
 */
function noteboard_scripts() {
	global $post;

	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Patua+One|Podkova|Raleway:100' );
	
	if ( is_singular( 'note' ) )
		wp_enqueue_style( 'prettify', get_template_directory_uri() . '/css/libs/prettify.css' );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'kinetic', get_template_directory_uri() . '/js/jquery.kinetic.js' );
	wp_enqueue_script( 'noteboard', get_template_directory_uri() . '/js/noteboard.js' );
	
	if ( is_singular( 'note' ) ) {
		wp_enqueue_script( 'prettify', get_template_directory_uri() . '/js/prettify/prettify.js', array( 'noteboard' ) );
		wp_enqueue_script( 'tabby', get_template_directory_uri() . '/js/tabby.js', array( 'noteboard' ) );
	}
}	
add_action( 'wp_enqueue_scripts', 'noteboard_scripts' );

/**
 * Head Scripts
 *
 * Instead of outputting this in the application's javascript, only
 * initiliaze certain things if we need them (and when their script is loaded).
 *
 * @since Noteboard 1.0
 *
 * @return void
 */
function noteboard_head_scripts() {
	if ( ! wp_script_is( 'prettify' ) || ! wp_script_is( 'tabby' ) )
		return;

	if ( is_singular( 'note' ) ) {
?>
	<script>
		jQuery(document).ready(function($) {
			prettyPrint();
			$( 'textarea' ).tabby();
		});
	</script>
<?php
	}
}
add_action( 'wp_head', 'noteboard_head_scripts' );