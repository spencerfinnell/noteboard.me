<form id="add-group" action="" method="post">
	<p>
		<label for="group-name">
			<?php _e( 'Group Name', 'noteboard' ); ?> <br />
			<input type="text" name="group-name" id="group-name" value="" />
		</label>
	</p>
	<p class="form-submit">
		<input type="submit" name="submit" value="<?php _e( 'Create Group', 'noteboard' ); ?>" />
		<a href="<?php echo home_url(); ?>" class="cancel"><?php _e( 'Cancel', 'noteboard' ); ?></a>
		<input type="hidden" name="action" value="noteboard-new-group" />
		<?php wp_nonce_field( 'noteboard-new-group' ); ?>
	</p>
</form>