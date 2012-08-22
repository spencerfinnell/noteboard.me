<?php
	global $noteboard;
	
	if ( ! isset( $first ) )
		$first = get_query_var( 'group' );
	
	if ( false !== ( $groups = noteboard_get_groups( array( 'first' => $first ) ) ) ) :
?>
<div id="notes-by-group">
	<?php foreach ( $groups as $group ) : ?>
		<div class="group">
			<h2 class="group-title">
				<a href="<?php echo get_term_link( $group, 'group' ); ?>"><?php echo esc_attr( wp_trim_words( $group->description, 3, '...' ) ); ?></a>
				<?php if ( $group->count > 5 ) : ?>
					<a href="<?php echo get_term_link( $group, 'group' ); ?>" class="group-action view-all"><?php _e( 'View All', 'noteboard' ); ?></a>
				<?php endif; ?>
			</h2>
			<ul class="group-of-notes">
				<li class="note add-new"><a href="<?php noteboard_note_add_link( $group ); ?>">+</a></li>
				
				<?php
					$notes = noteboard_get_notes( $group );
					
					while( $notes->have_posts() ) : $notes->the_post();
						noteboard_get_template( 'note.php' );
					endwhile; 
				?>
			</ul>
		</div>
	<?php endforeach; ?>
</div><!-- #notes-by-group -->
<?php endif; ?>