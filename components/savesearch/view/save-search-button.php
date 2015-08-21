<button
	class="btn <?php echo $btn_class;?> wp-site-color-theme <?php echo $class;?>"
	data-post="<?php echo $query_data;?>"
	data-save-search="<?php echo $save_search_name;?>"
	data-current-action="save_search_action"
	type="button"
>
	<span class="glyphicon <?php echo $btn_icon;?>" aria-hidden="true"></span>
	<span class="btn-text"><?php echo $btn_name;?></span>
	<?php if( !is_user_logged_in() ) { ?>
		<span class="hidden content-save_search_action" style="display:hidden !important;"><?php echo $content;?></span>
	<?php } ?>
	<span class="label label-info label-ajax"></span>
</button>

