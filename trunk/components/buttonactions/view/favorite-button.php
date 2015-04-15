<?php if( is_user_logged_in() ){ ?>
	<?php if( \Favorite_Property::get_instance()->check_property($property_id) ){ ?>
		<a class="btn btn-primary favorite property_favorite_remove btn-xs <?php echo $class;?>" href="javascript:void(null)" data-property-id="<?php echo $property_id;?>" data-property-feed="<?php echo $feed;?>" role="button">
			<i class="fa fa-heart fa-lg"></i> <?php echo $label;?>
		</a>
	<?php }else{ ?>
		<a class="btn btn-default favorite property_favorite btn-xs <?php echo $class;?>" href="javascript:void(null)" data-property-id="<?php echo $property_id;?>" data-property-feed="<?php echo $feed;?>" role="button">
			<i class="fa fa-heart-o fa-lg"></i> <?php echo $label;?>
		</a>
	<?php } ?>
<?php }else{ ?>
		<a class="btn btn-default register-open btn-xs <?php echo $class;?>" href="javascript:void(null)" data-property-id="<?php echo $property_id;?>" data-property-feed="<?php echo $feed;?>" role="button">
			<i class="fa fa-heart-o fa-lg"></i> <?php echo $label;?>
		</a>
<?php } ?>
