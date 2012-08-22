<form id="edit-group" action="" method="post">
	<p>
		<label for="group-name">
			<?php _e( 'Group Name', 'noteboard' ); ?> <br />
			<input type="text" name="group-name" id="group-name" value="<?php esc_attr_e( $group->description ); ?>" />
		</label>
	</p>
	<p>
		<label for="group-name">
			<?php printf( __( 'I want to <a href="%s" class="delete cancel">delete this group</a>.', 'noteboard' ), noteboard_group_delete_url( $group ) ); ?></a>
		</label>
	</p>
	<p class="form-submit">
		<input type="submit" name="submit" value="<?php _e( 'Update Group', 'noteboard' ); ?>" />
		<a href="<?php echo get_term_link( $group, 'group' ); ?>" class="cancel"><?php _e( 'Cancel', 'noteboard' ); ?></a>
		<input type="hidden" name="action" value="noteboard-edit-group" />
		<?php wp_nonce_field( 'noteboard-edit-group' ); ?>
	</p>
</form>