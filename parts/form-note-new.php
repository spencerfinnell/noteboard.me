<form action="" method="post">
	<p>
		<label for="note-title">
			<span class="hidden-text"><?php _e( 'Note Title:', 'noteboard' ); ?></span>
			<input type="text" name="note-title" id="note-title" placeholder="Note Title..." class="note-title" />
		</label>
	</p>
	<p>
		<label for="note-content">
			<span class="hidden-text"><?php _e( 'Note Content:', 'noteboard' ); ?></span> <br />
			<textarea name="note-content" id="note-content" rows="28" cols="40" value=""></textarea>
		</label>
	</p>
	<p>
		<input type="submit" name="submit" value="<?php _e( 'Add Note', 'noteboard' ); ?>" />
		<input type="hidden" name="action" value="noteboard-new-note" />
		<input type="hidden" name="group" value="<?php echo absint( get_query_var( 'group' ) ); ?>" />
		<?php wp_nonce_field( 'noteboard-new-note' ); ?>
	</p>
</form>