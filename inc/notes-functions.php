<?php
/**
 * Notes
 *
 * Handle notes
 *
 * @package  	Noteboard
 * @category	Notes
 * @author   	Spencer Finnell
 */

/**
 * Notes Post Type
 *
 * @since Noteboard 1.0
 *
 * @return void
 */
function noteboard_notes() {
	 $labels = array(
		'name' => __( 'Notes', 'noteboard' ),
		'singular_name' =>  __( 'Note', 'noteboard' ),
		'add_new' => __( 'Add New', 'noteboard' ),
		'add_new_item' => __( 'Add New Note', 'noteboard' ),
		'edit_item' => __( 'Edit Note', 'noteboard' ),
		'new_item' => __( 'New Note', 'noteboard' ),
		'all_items' => __( 'All Notes', 'noteboard' ),
		'view_item' => __( 'View Note', 'noteboard' ),
		'search_items' => __( 'Search Notes', 'noteboard' ),
		'not_found' =>  __( 'No notes found', 'noteboard' ),
		'not_found_in_trash' => __( 'No notes found in the trash', 'noteboard' ), 
		'menu_name' => __( 'Notes', 'noteboard' )
	);
	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'editor', 'author' )
	); 
	
	register_post_type( 'note', $args );
}
add_action( 'init', 'noteboard_notes' );

function noteboard_note_force_title( $title, $id ) {
	global $post;
	
	if ( $post->post_type != 'note' )
		return $title;
		
	if ( '' == $title )
		return __( 'Untitled', 'noteboard' );
		
	return $title;
}

function noteboard_note_add() {
	// Bail if not a POST action
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) )
		return;

	// Bail if action is not noteboard-new-note
	if ( empty( $_POST[ 'action' ] ) || ( 'noteboard-new-note' !== $_POST[ 'action' ] ) )
		return;
	
	// Make sure they are logged in
	if ( ! is_user_logged_in() )
		auth_redirect();	

	// Nonce check
	check_admin_referer( 'noteboard-new-note' );
	
	if ( empty( $_POST[ 'group' ] ) )
		return;
	
	$user  = wp_get_current_user();
	$group = absint( $_POST[ 'group' ] );
	$term  = get_term( $group, 'group' );
	
	if ( ! $term )
		return;
	
	if ( strpos( $term->name, $user->user_login ) != 0 )
		return;
		
	$note_title   = wp_strip_all_tags( $_POST[ 'note-title' ] );
	$note_content = $_POST[ 'note-content' ];
	
	wp_insert_post( array(
		'post_type'    => 'note',
		'post_title'   => $note_title,
		'post_content' => $note_content,
		'post_status'  => 'publish',
		'tax_input'    => array(
			'group' => array( $term->name )
		) 
	) );
	
	wp_redirect( get_term_link( $term, 'group' ) );
	
	exit();
}
add_action( 'template_redirect', 'noteboard_note_add' );

function noteboard_note_edit_endpoint(){
	global $wp_query;

	if ( ! isset( $wp_query->query[ 'edit' ] ) )
		return;
	
	if ( ! is_singular( 'note' ) )
		return;
	
	include( get_template_directory() . '/pages/page-note-edit.php' );
	exit;
}
add_action( 'template_redirect', 'noteboard_note_edit_endpoint' );

function noteboard_note_edit() {
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) )
		return;

	if ( empty( $_POST[ 'action' ] ) || ( 'noteboard-edit-note' !== $_POST[ 'action' ] ) )
		return;
	
	if ( ! is_user_logged_in() )
		auth_redirect();	
	
	wp_verify_nonce( 'noteboard-edit-note' );
	
	$id           = absint( $_POST[ 'note-id' ] );
	$note_title   = wp_strip_all_tags( $_POST[ 'note-title' ] );
	$note_content = $_POST[ 'note-content' ];
	
	if ( ! current_user_can( 'edit_post', $id ) )
		return;
	
	wp_update_post( array(
		'ID'           => $id,
		'post_title'   => $note_title,
		'post_content' => $note_content,
	) );
	
	wp_redirect( get_permalink( $id ) );
	
	exit();
}
add_action( 'template_redirect', 'noteboard_note_edit', 9  );

function noteboard_note_delete_endpoint(){
	global $wp_query;

	if ( ! isset( $wp_query->query[ 'delete' ] ) )
		return;
	
	if ( ! is_singular( 'note' ) )
		return;
}
add_action( 'template_redirect', 'noteboard_note_delete_endpoint' );