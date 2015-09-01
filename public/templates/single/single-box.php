<div class="row">
	<?php if( have_properties() ){ ?>
		<?php foreach(have_properties() as $property){ ?>
				<?php if( !is_null($property->properties->id) ) { ?>
						<?php $photo = $property->properties->getPhotoUrl($property->photos); ?>
						<div class="col-xs-12 col-md-<?php echo bootstrap_grid_col(count($property_data));?> property-item property-id-<?php echo $property->properties->getID();?> crm">
							<div class="thumbnail masterdigm-property-box">
							<a href="<?php echo $property->properties->displayUrl();?>" class="">
								<img class="img-responsive" src="<?php echo $photo[0] ? $photo[0]:PLUGIN_ASSET_URL . 'house.png'; ?>" style="<?php $photo[0] ? '':'width:170px;height:180px;'; ?>" alt="Property List Image">
							</a>
							<span class="label label-primary primary-background wp-site-color-theme label-property"><?php echo $property->properties->displayTransaction();?></span>
							<div class="caption">
								<h3 class="property-name">
									<a href="<?php echo $property->properties->displayUrl();?>" class="<?php //echo get_model_register_class();?>">
										<?php echo $property->properties->displayAddress();?>
									</a>
								</h3>
								<div class="property-amenities">
									<span><strong><?php echo $property->properties->displayFloorArea();?>&nbsp;</strong><?php echo $property->properties->displayAreaUnit('account');?></span>
									<span><strong><?php echo $property->properties->displayBathroom();?>&nbsp;</strong><?php echo _label('baths');?></span>
									<span><strong><?php echo $property->properties->displayBed();?>&nbsp;</strong><?php echo _label('beds');?></span>
									<span><strong><?php echo $property->properties->displayGarage();?>&nbsp;</strong><?php echo _label('garage');?></span>
								</div>
								<h2 class="price center-block wp-site-color-theme"><?php echo $property->properties->displayPrice();?></h2>
							</div>
							<div class="panel-footer">
								<?php
									$args_button_action = array(
										'favorite'	=> array(
											'show' => 1,
											'feed' => 'crm',
											'property->properties_id' => $property->properties->getID(),
										),
										'xout'	=> array(
											'show' => 1,
											'feed' => 'crm',
											'property->properties_id' => $property->properties->getID(),
										),
										'print' => array(
											'show' => 1,
											'url' => get_option('siteurl') . '/printpdf/'.$property->properties->getID(),
										),
										'share'	=> array(
											'show' => 1,
											'property->properties_id' => $property->properties->getID(),
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
