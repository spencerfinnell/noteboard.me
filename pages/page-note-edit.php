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
					<?php noteboard_get_template( 'form-note-edit.php' ); ?>
				<?php endwhile; ?>
			</div>
			<?php noteboard_get_template( 'notes-by-group.php', array( 'first' => $group->term_id ) ) ?>
		</div>
		
<?php get_footer(); ?>