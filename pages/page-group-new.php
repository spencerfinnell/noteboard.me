<?php
/**
 * Template Name: Group - New
 *
 * @package Noteboard
 * @since Noteboard 1.0
 */

get_header(); ?>
	
		<div id="modal-overlay">
			<div id="modal">
				<div id="modal-content">
					<div id="modal-inner">
						<h3>Create a new Group</h3>
						<p class="subtitle">Groups allow you to easily organize your notes.</p>
						
						<?php noteboard_get_template( 'form-group-new.php' ); ?>
					</div>
				</div>
			</div>
		</div>
		
<?php get_footer(); ?>