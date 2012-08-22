<?php
/**
 * Group template functions.
 *
 * @package Noteboard
 * @subpackage Groups
 * @since Noteboard 1.0
 */

function noteboard_get_groups( $args = array() ) {
	$defaults = array(
		'name__like' => noteboard_user_group_prefix(),
		'hide_empty' => 0,
		'orderby'    => 'id',
		'order'      => 'DESC'
	);
	
	$args = wp_parse_args( $args, $defaults );

	$groups = get_terms( array( 'group' ), $args );
	
	if ( ! empty( $args[ 'first' ] ) ) {
		foreach ( $groups as $id => $group ) {
			if ( $group->term_id == $args[ 'first' ] ) {
				unset( $groups[ $id ] );
				array_unshift( $groups, $group );
			}
		}
	}
	
	return $groups;
}

function noteboard_group_delete_url( $group ) {
	$base = get_term_link( $group, 'group' );
	
	if ( get_option( 'permalink_structure' ) )
		return trailingslashit( trailingslashit( $base ) . 'delete' );
	else
		return add_query_arg( array( 'delete' => '' ), $base );
}