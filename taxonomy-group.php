<?php
/**
 * 
 *
 * @package Noteboard
 * @since Noteboard 1.0
 */
 
$group = get_queried_object();

get_header(); ?>
				
	<div id="notes">
		<div id="notes-by-group">
			<div class="group all">
				<h2 class="group-title">
					<?php echo esc_attr( $group->description ); ?>
					<a href="<?php echo get_term_link( $group, 'group' ); ?>edit" class="group-action edit"><?php _e( 'Edit', 'noteboard' ); ?></a>
				</h2>
				<ul class="group-of-notes">
					<li class="note add-new"><a href="<?php noteboard_note_add_link( $group ); ?>">+</a></li>
					
					<?php
						$notes = noteboard_get_notes( $group, array( 'posts_per_page' => -1 ) );
						
						while( $notes->have_posts() ) : $notes->the_post();
							noteboard_get_template( 'note.php' );
						endwhile; 
					?>
				</ul>
			</div>
		</div><!-- #notes-by-group -->
	</div><!-- #notes -->
			
<?php get_footer(); ?>