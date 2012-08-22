<?php
/**
 * Template Name: Login
 *
 * @package Noteboard
 * @since Noteboard 1.0
 */

global $noteboard; 
 
get_header(); ?>
	
		<div id="modal-overlay">
			<div id="modal">
				<div id="modal-content">
					<div id="modal-inner">
						<h3>Sign In to Noteboard</h3>
						<p>Please Sign In to use Noteboard. <a href="<?php echo esc_url( get_permalink( $noteboard->get( 'noteboard-register' ) ) ); ?>">Register an account.</a></p>
						
						<?php
							wp_login_form( array(
								'label_log_in'   => __( 'Sign in', 'noteboard' ),
								'value_remember' => true,
								'redirect'       => home_url()
							) );
						?>
					</div>
				</div>
			</div>
		</div>
		
<?php get_footer(); ?>