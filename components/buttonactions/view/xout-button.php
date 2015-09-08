<?php if( is_user_logged_in() ){ ?>
	<?php if( \Xout_Button::get_instance()->check_property($property_id) ){ ?>
		<a
			class="butonactions btn btn-primary property_xout_remove xout btn-xs <?php echo $class;?>"
			href="javascript:void(null)"
			data-property-id="<?php echo $property_id;?>"
			data-property-feed="<?php echo $feed;?>"
			data-toggle="tooltip"
			data-placement="top"
			title="Un-Xout property"
			role="button"
		>
			<i class="fa fa-times-circle"></i> <?php echo $label;?>
		</a>
	<?php }else{ ?>
		<a
			class="butonactions btn btn-default property_xout xout btn-xs <?php echo $class;?>"
			href="javascript:void(null)"
			data-property-id="<?php echo $property_id;?>"
			data-property-feed="<?php echo $feed;?>"
			data-toggle="tooltip"
			data-placement="top"
			title="Xout property"
			role="button"
		>
			<i class="fa fa-times-circle-o"></i> <?php echo $label;?>
		</a>
	<?php } ?>
<?php }else{ ?>
		<a
			class="butonactions btn btn-default register-open btn-xs <?php echo $class;?>"
			href="javascript:void(null)"
			data-post="<?php echo "property-id={$property_id}&property-feed={$feed}"; ?>"
			data-current-action="<?php echo $action;?>"
			data-toggle="tooltip"
			data-placement="top"
			title="Register or login to Xout property"
			role="button"
		>
			<i class="fa fa-times-circle"></i> <?php echo $label;?>
		</a>
		<?php if( !is_user_logged_in() ) { ?>
			<div class="content-<?php echo $action;?> hidden" style="display:hiden !important;"><?php echo $content;?></div>
		<?php } ?>
<?php } ?>
