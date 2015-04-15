<?php if( is_user_logged_in() ){ ?>
	<?php if( \XOut_Property::get_instance()->check_property($property_id) ){ ?>
		<a class="btn btn-primary property_xout_remove xout btn-xs <?php echo $class;?>" href="javascript:void(null)" data-property-id="<?php echo $property_id;?>" data-property-feed="<?php echo $feed;?>" role="button">
			<i class="fa fa-times-circle fa-lg"></i> <?php echo $label;?>
		</a>
	<?php }else{ ?>
		<a class="btn btn-default property_xout xout btn-xs <?php echo $class;?>" href="javascript:void(null)" data-property-id="<?php echo $property_id;?>" data-property-feed="<?php echo $feed;?>" role="button">
			<i class="fa fa-times-circle-o fa-lg"></i> <?php echo $label;?>
		</a>
	<?php } ?>
<?php }else{ ?>
		<a class="btn btn-default register-open btn-xs <?php echo $class;?>" href="javascript:void(null)" data-property-id="<?php echo $property_id;?>" data-property-feed="<?php echo $feed;?>" role="button">
			<i class="fa fa-times-circle fa-lg"></i> <?php echo $label;?>
		</a>
<?php } ?>
