<?php if( is_user_logged_in() ){ ?>
	<?php if( \Favorite_Button::get_instance()->check_property($property_id) ){ ?>
		<a class="btn btn-primary favorite property_favorite_remove btn-xs <?php echo $class;?>" href="javascript:void(null)" data-property-id="<?php echo $property_id;?>" data-property-feed="<?php echo $feed;?>" role="button">
			<i class="fa fa-heart"></i> <?php echo $label;?>
		</a>
	<?php }else{ ?>
		<a class="btn btn-default favorite property_favorite btn-xs <?php echo $class;?>" href="javascript:void(null)" data-property-id="<?php echo $property_id;?>" data-property-feed="<?php echo $feed;?>" role="button">
			<i class="fa fa-heart-o"></i> <?php echo $label;?>
		</a>
	<?php } ?>
<?php }else{ ?>
		<a class="btn btn-default register-open btn-xs <?php echo $class;?>" href="javascript:void(null)" data-post="<?php echo "property-id={$property_id}&property-feed={$feed}"; ?>" data-current-action="<?php echo $action;?>" role="button">
			<i class="fa fa-heart-o"></i> <?php echo $label;?>
		</a>
		<div class="content-<?php echo $action;?> hidden" style="display:hiden !important;"><?php echo $content;?></div>
<?php } ?>
