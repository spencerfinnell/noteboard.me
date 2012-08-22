<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Noteboard
 * @since Noteboard 1.0
 */

get_header(); ?>

	<div id="notes">
		<div id="notes-by-group">
			<div class="group">
				<h2 class="group-title">Page Not Found</h2>
				<ul class="group-of-notes">
					<li class="note">
						<h3 class="title"><?php _e( 'Uh oh.', 'noteboard' ); ?></h3>
						<p><?php _e( 'I have no idea what you&#39;re trying to do, but stop. Just stop it.', 'noteboard' ); ?></p>
						<p><strong><a href="<?php echo home_url(); ?>"><?php _e( 'Go home.', 'noteboard' ); ?></a></strong></p>
						<a href="<?php echo home_url(); ?>" class="click-through"></a>
					</li>
				</ul>
			</div>
		</div>
	</div><!-- #notes -->

<?php get_footer(); ?>