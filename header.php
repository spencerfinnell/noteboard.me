<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Noteboard
 * @since Noteboard 1.0
 */
 
global $noteboard;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />

	<title><?php wp_title( '&mdash;', true, 'right' ); ?></title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	
	<header id="masthead" class="site-header" role="banner">
		<hgroup>
			<h1 class="site-title"><a href="<?php echo home_url(); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home">Note<span>Board</span></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</hgroup>
		<nav id="access">
			<div id="primary-menu">
				<ul>
					<li><a href="<?php echo home_url(); ?>"><?php _e( 'Dashboard', 'noteboard' ); ?></a></li>
					<li><a href="<?php echo esc_url( get_permalink( $noteboard->get( 'noteboard-groups-new' ) ) ); ?>"><?php _e( 'Add Group', 'noteboard' ); ?></a></li>
					<li><a href="<?php echo esc_url( get_permalink( $noteboard->get( 'noteboard-groups' ) ) ); ?>"><?php _e( 'Groups', 'noteboard' ); ?></a>
					<?php if ( is_user_logged_in() ) : ?>
					<li class="subtle"><a href="<?php echo wp_logout_url(); ?>"><?php _e( 'Sign Out', 'noteboard' ); ?></a></li>
					<?php endif; ?>
				</ul>
			</div>
		</nav>
	</header><!-- #masthead -->
	