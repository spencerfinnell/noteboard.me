<?php
/**
 * Single Note
 *
 * @package Noteboard
 * @since Noteboard 1.0
 */
 
$group = wp_get_object_terms( $post->ID, 'group' );
$group = current( $group );

get_header(); ?>
	
		<div id="notes">
			<div id="note" class="section">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php noteboard_note_title(); ?>
					
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
					
					<p class="edit-note">
						<a href="<?php noteboard_note_action_url( 'edit' ); ?>" class="button-submit"><?php _e( 'Edit Note', 'noteboard' ); ?></a>
						<a href="<?php noteboard_note_action_url( 'delete' ); ?>" class="button-submit cancel"><?php _e( 'Delete Note', 'noteboard' ); ?></a>
					</p>
				<?php endwhile; ?>
			</div>
			<?php noteboard_get_template( 'notes-by-group.php', array( 'first' => $group->term_id ) ) ?>
		</div>
		
<?php get_footer(); ?>