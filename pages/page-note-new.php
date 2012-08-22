<?php
/**
 * Template Name: Note - New
 *
 * @package Noteboard
 * @since Noteboard 1.0
 */

get_header(); ?>
	
		<div id="notes">
			<div id="note" class="section">
				<?php noteboard_get_template( 'form-note-new.php' ); ?>
			</div>
			<?php noteboard_get_template( 'notes-by-group.php' ) ?>
		</div>
		
<?php get_footer(); ?>