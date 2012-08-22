<?php
/**
 * Edit a Group
 *
 * @package Noteboard
 * @since Noteboard 1.0
 */

global $wp_query;

$slug  = $wp_query->query[ 'attachment' ];
$group = get_term_by( 'slug', $slug, 'group' );

get_header(); ?>
	
		<div id="modal-overlay">
			<div id="modal">
				<div id="modal-content">
					<div id="modal-inner">
						<h3><?php _e( 'Edit Group', 'noteboard' ); ?></h3>
						<p class="subtitle"><?php _e( 'Update or delete this group&#39;s information.', 'noteboard' ); ?></p>
						
						<?php 
							noteboard_get_template( 'form-group-edit.php', array(
								'group' => $group
							) ); 
						?>
					</div>
				</div>
			</div>
		</div>
		
<?php get_footer(); ?>