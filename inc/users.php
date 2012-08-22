<?php

function noteboard_user_group_prefix( $user_id = null ) {
	$user = wp_get_current_user();
	
	$prefix = sprintf( '%s-%d', $user->user_login, $user->ID );
	
	return $prefix;
}