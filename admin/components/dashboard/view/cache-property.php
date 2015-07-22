<form name="md_api" method="post" action="<?php echo admin_url('admin.php?page=md-api-plugin-settings&noheaders=true'); ?>">
	<input type="hidden" name="action" value="delete_all_cache">
	<input type="hidden" name="option_key" value="cache">
	<p class="submit">
	<input type="submit" name="Submit" class="button-primary" value="<?php _e('Delete All Cache' ) ?>" />
	</p>
</form>
