<?php
	global $post;
?>

<form action="" method="post">
	<p>
		<label for="note-title">
			<span class="hidden-text"><?php _e( 'Note Title:', 'noteboard' ); ?></span>
			<input type="text" name="note-title" id="note-title" value="<?php the_title() ?>" class="note-title" />
		</label>
	</p>
	<p>
		<label for="note-content">
			<span class="hidden-text"><?php _e( 'Note Content:', 'noteboard' ); ?></span> <br />
			<textarea name="note-content" id="note-content" rows="28" cols="40" value=""><?php echo esc_textarea( get_the_content() ); ?></textarea>
		</label>
	</p>
	<p>
		<input type="submit" name="submit" value="<?php _e( 'Save Note', 'noteboard' ); ?>" />
		<a href="<?php noteboard_note_action_url( 'delete' ); ?>" class="button-submit cancel"><?php _e( 'Delete Note', 'noteboard' ); ?></a>
		
		<input type="hidden" name="action" value="noteboard-edit-note" />
		<input type="hidden" name="note-id" value="<?php echo absint( $post->ID ); ?>" />
		<?php wp_nonce_field( 'noteboard-edit-note' ); ?>
	</p>
</form>