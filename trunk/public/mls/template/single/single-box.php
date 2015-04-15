<div class="row">
	<?php if( count($property_data) > 0 ){ ?>
		<?php foreach($property_data as $property){ ?>
				<?php if( !is_null($property->properties->id) ) { ?>
						<?php $photo = $property->properties->getPhotoUrl($property->photos); ?>
						<div class="col-xs-12 col-md-<?php echo bootstrap_grid_col(count($property_data));?>">
							<div class="thumbnail masterdigm-property->properties-box">
							<a href="<?php echo $property->properties->displayUrl();?>" class="property->propertiesphoto">
								<img class="img-responsive" src="<?php echo $photo[0] ? $photo[0]:PLUGIN_ASSET_URL . 'house.png'; ?>" style="<?php $photo[0] ? '':'width:170px;height:180px;'; ?>" alt="Property List Image">
							</a>
							<span class="label label-primary wp-site-color-theme label-property->properties"><?php echo $property->properties->displayTransaction();?></span>
							<div class="caption">
								<h3 class="property->properties-name">
									<a href="<?php echo $property->properties->displayUrl();?>" class="<?php //echo get_model_register_class();?>">
										<?php echo $property->properties->displayAddress();?>
									</a>
								</h3>
								<div class="property->properties-amenities">
									<span><strong><?php echo $property->properties->displayFloorArea();?>&nbsp;</strong><?php echo $property->properties->displayAreaUnit('account');?></span>
									<span><strong><?php echo $property->properties->get_bathrooms();?>&nbsp;</strong>Bed</span>
									<span><strong><?php echo $property->properties->get_beds();?>&nbsp;</strong>Bath</span>
									<span><strong><?php echo $property->properties->get_garage();?>&nbsp;</strong>Garage</span>
								</div>
								<h2 class="price center-block wp-site-color-theme"><?php echo $property->properties->displayPrice();?></h2>
							</div>
							<div class="panel-footer">
								<?php
									$args_button_action = array(
										'favorite'	=> array(
											'feed' => 'crm',
											'property->properties_id' => $property->properties->get_id(),
										),
										'xout'	=> array(
											'feed' => 'crm',
											'property->properties_id' => $property->properties->get_id(),
										),
										'share'	=> array(
											'property->properties_id' => $property->properties->get_id(),
											'feed' => 'crm',
											'url' => $property->properties->displayUrl(),
											'address' => $property->properties->displayAddress() ? $property->properties->displayAddress():$property->properties->get_tagline()
										),
									);
									\Action_Buttons::get_instance()->display($args_button_action);
								?>
							</div>
						</div>
						</div>
				<?php } ?>
		<?php } ?>
	<?php } ?>
</div>
