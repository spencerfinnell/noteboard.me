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
 * 
 *
 * @since Noteboard 1.0
 *
 * @return void
 */
function noteboard_get_notes( $group, $args = array() ) {
	$user = wp_get_current_user();
	
	$defaults = array(
		'posts_per_page' => 5,
		'post_type' => 'note',
		'author' => $user->ID,
		'order'  => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'group',
				'field'    => 'slug',
				'terms'    => $group
			)
		)
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	
	return new WP_Query( $args );
}

function noteboard_note_add_link( $group ) {
	global $noteboard;
	
	$base = get_permalink( $noteboard->get( 'noteboard-notes-new' ) );
	
	$url = noteboard_note_get_action_url( 'group', array(
		'base' => $base,
		'arg'  => $group->term_id
	) );
	
	echo $url;
}

function noteboard_note_title() {
	global $post;
	
	add_filter( 'the_title', 'noteboard_note_force_title', 10, 2 );
?>
	<h1 class="title"><?php the_title(); ?></h1>
<?php
	remove_filter( 'the_title', 'noteboard_note_force_title', 10, 2 );
}

function noteboard_note_action_url( $action, $args = array() ) {
	echo noteboard_note_get_action_url( $action, $args );
}

function noteboard_note_get_action_url( $action, $args = array() ) {
	global $post;
	
	$defaults = array(
		'base' => get_permalink( $post->ID ),
		'arg'  => ''
	);
	
	$args = wp_parse_args( $args, $defaults );
	extract( $args );
	
	if ( get_option( 'permalink_structure' ) )
		return trailingslashit( trailingslashit( $base ) . $action . '/' . $arg );
	else
		return add_query_arg( array( $action => $arg ), $base );
}