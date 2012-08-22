<?php
/**
 * Template Name: Register
 *
 * @package Noteboard
 * @since Noteboard 1.0
 */

get_header(); ?>
	
		<div id="modal-overlay">
			<div id="modal">
				<div id="modal-content">
					<div id="modal-inner">
						<?php while ( have_posts() ) : the_post(); ?>
						<h3><?php the_title(); ?></h3>
						<?php the_content(); ?>
						<?php endwhile; ?>
						
						<form action="<?php echo add_query_arg( array( 'action' => 'register' ), site_url( 'wp-login.php' ) ); ?>" method="post" id="registration-form">
							<p>
								<label for="user_login"><?php _e( 'Username', 'noteboard' ); ?></label>
								<input type="text" name="user_login" id="user_login" />
							</p>
							
							<p>
								<label for="user_email"><?php _e( 'Email Address', 'noteboard' ); ?></label>
								<input type="text" name="user_email" id="user_email" value="" />
							</p>
							
							<p class="form-submit">
								<input type="submit" name="submit" value="<?php _e( 'Sign up for Noteboard', 'noteboard' ); ?>" />
								<span class="submit-note"><?php _e( 'A password will be emailed to you.', 'noteboard' ); ?></span>
								<a href="<?php echo home_url(); ?>" class="cancel"><?php _e( 'Cancel', 'noteboard' ); ?></a>
							</p>
						</form>
					</div>
				</div>
			</div>
		</div>
		
<?php get_footer(); ?>