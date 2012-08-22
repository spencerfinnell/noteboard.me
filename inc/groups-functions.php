<?php
/**
 * Group functions.
 *
 * These functions are generally attached to a hook or filter
 * and called automatically.
 *
 * @package Noteboard
 * @subpackage Groups
 * @since Noteboard 1.0
 */
 
/**
 * Groups Taxonomy
 *
 * @since Noteboard 1.0
 *
 * @return void
 */
function noteboard_groups() {
	$labels = array(
		'name' => __( 'Groups', 'noteboard' ),
		'singular_name' => __( 'Group', 'noteboard' ),
		'search_items' =>  __( 'Search Groups', 'noteboard' ),
		'popular_items' => __( 'Popular Groups', 'noteboard' ),
		'all_items' => __( 'All Groups', 'noteboard' ),
		'edit_item' => __( 'Edit Group', 'noteboard' ), 
		'update_item' => __( 'Update Group', 'noteboard' ),
		'add_new_item' => __( 'Add New Group', 'noteboard' ),
		'new_item_name' => __( 'New Group', 'noteboard' ),
		'separate_items_with_commas' => __( 'Separate groups with commas', 'noteboard' ),
		'add_or_remove_items' => __( 'Add or remove groups', 'noteboard' ),
		'choose_from_most_used' => __( 'Choose from the most used groups', 'noteboard' ),
		'menu_name' => __( 'Groups', 'noteboard' ),
	); 

	$args = array(
		'hierarchical' => false,
		'labels' => $labels,
		'show_ui' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
		'rewrite' => array( 'slug' => 'group' ),
	);

	register_taxonomy( 'group', 'note', $args );
}
add_action( 'init', 'noteboard_groups' );

/**
 * Add Group
 *
 * Process and add a group.
 *
 * @since Noteboard 1.0
 *
 * @return void
 */
function noteboard_group_add() {
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) )
		return;

	if ( empty( $_POST['action'] ) || ( 'noteboard-new-group' !== $_POST['action'] ) )
		return;
	
	if ( ! is_user_logged_in() )
		auth_redirect();	

	check_admin_referer( 'noteboard-new-group' );
	
	$user              = wp_get_current_user();
	
	$group_description = esc_attr( $_POST[ 'group-name' ] );
	$group_name        = sprintf( '%s-%s', noteboard_user_group_prefix(), sanitize_title_with_dashes( $group_description ) );
	
	wp_insert_term( $group_name, 'group', array(
		'description' => $group_description,
		'slug'        => $group_name
	) );
	
	wp_redirect( home_url() );
	
	exit();
}
add_action( 'template_redirect', 'noteboard_group_add' );

/**
 * Edit Group Filter
 *
 * Filter the request to properly set the edit variable. This allows
 * for `get_query_var()` to properly be used in the `template_direct` hook.
 *
 * @since Noteboard 1.0
 *
 * @param array $vars Array of current request variables
 * @return array $vars Array of modified request variables
 */
function noteboard_group_edit_filter_request( $vars ) {
	if( isset( $vars[ 'edit' ] ) )
		$vars[ 'edit' ] = true;
		
	return $vars;
}
add_filter( 'request', 'noteboard_group_edit_filter_request' );

/**
 * Edit Group Template
 *
 * Load the proper template when editing a group. For some reason, endpoints
 * and taxonomies don't mix, so reset the 404 flag to false, 
 * and status header to a 200 request.
 *
 * @since Noteboard 1.0
 *
 * @return void
 */
function noteboard_group_edit_endpoint(){
	global $wp_query;
	
	if ( ! get_query_var( 'edit' ) )
		return;
		
	$wp_query->is_404 = false;
	status_header( 200 ); 
	
	include( get_template_directory() . '/pages/page-group-edit.php' );
	exit;
}
add_action( 'template_redirect', 'noteboard_group_edit_endpoint', 20 );

/**
 * Edit Group
 *
 * Process and edit a group.
 *
 * @since Noteboard 1.0
 *
 * @return void
 */
function noteboard_group_edit() {
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) )
		return;

	if ( empty( $_POST['action'] ) || ( 'noteboard-edit-group' !== $_POST['action'] ) )
		return;
	
	if ( ! is_user_logged_in() )
		auth_redirect();	

	check_admin_referer( 'noteboard-edit-group' );
	
	$user              = wp_get_current_user();
	
	$group_description = esc_attr( $_POST[ 'group-name' ] );
	$group_name        = sprintf( '%s-%s', noteboard_user_group_prefix(), sanitize_title_with_dashes( $group_description ) );
	
	wp_insert_term( $group_name, 'group', array(
		'description' => $group_description,
		'slug'        => $group_name
	) );
	
	wp_redirect( home_url() );
	
	exit();
}
add_action( 'template_redirect', 'noteboard_group_edit' );

/**
 * Delete Group Filter
 *
 * Filter the request to properly set the `delete` variable. This allows
 * for `get_query_var()` to properly be used in the `template_direct` hook.
 *
 * @since Noteboard 1.0
 *
 * @param array $vars Array of current request variables
 * @return array $vars Array of modified request variables
 */
function noteboard_group_delete_filter_request( $vars ) {
	global $wp_query;
	
	if( isset( $vars[ 'delete' ] ) )
		$vars[ 'delete' ] = true;
		
	return $vars;
}
add_filter( 'request', 'noteboard_group_delete_filter_request' );

/**
 * Delete Group
 *
 * Checks for the proper endpoint, and if so, deletes
 * the group (term) and all of the notes (objects).
 *
 * @since Noteboard 1.0
 *
 * @return void
 */
function noteboard_group_delete_endpoint(){
	global $wp_query;
	
	if ( ! get_query_var( 'delete' ) )
		return;
		
	$wp_query->is_404 = false;
	status_header( 200 ); 
		
	$slug  = $wp_query->query[ 'attachment' ];
	$group = get_term_by( 'slug', $slug, 'group' );
	$notes = get_objects_in_term( $group->term_id, 'group' );
	
	foreach ( $notes as $note_id ) {
		wp_delete_post( $note_id );
	}
	
	wp_delete_term( $group->term_id, 'group' );
	
	wp_redirect( home_url() );
	exit();
}
add_action( 'template_redirect', 'noteboard_group_delete_endpoint', 20 );