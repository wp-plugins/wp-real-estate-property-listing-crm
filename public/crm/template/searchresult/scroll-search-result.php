<?php if( have_properties() ){ ?>
	<?php foreach(have_properties() as $property ){ ?>
		  <div class="col-xs-12 col-md-<?php echo $col;?> property-item property-id-<?php echo $property->get_id();?>">
			<div class="thumbnail masterdigm-property-box">
				<a href="<?php echo $property->displayUrl();?>" class="propertyphoto">
					<img class="img-responsive" src="<?php echo $property->get_img() ? $property->get_img():PLUGIN_ASSET_URL . 'house.png'; ?>" style="<?php $property->get_img() ? '':'width:170px;height:180px;'; ?>" alt="Property List Image">
				</a>
				<span class="label label-primary primary-background wp-site-color-theme label-property"><?php echo $property->displayTransaction();?></span>
				<div class="caption">
					<h3 class="property-name">
						<a href="<?php echo $property->displayUrl();?>" class="<?php //echo get_model_register_class();?>">
							<?php echo $property->displayAddress();?>
						</a>
					</h3>
					<div class="property-amenities">
						<span><strong><?php echo $property->displayFloorArea();?>&nbsp;</strong><?php echo $property->displayAreaUnit('account');?></span>
						<span><strong><?php echo $property->get_beds();?>&nbsp;</strong>Bed</span>
						<span><strong><?php echo $property->get_bathrooms();?>&nbsp;</strong>Bath</span>
						<span><strong><?php echo $property->get_garage();?>&nbsp;</strong>Garage</span>
					</div>
					<h2 class="price center-block wp-site-color-theme"><?php echo $property->displayPrice();?></h2>
				</div>
				<div class="panel-footer">
					<?php
						$args_button_action = array(
							'favorite'	=> array(
								'feed' => 'crm',
								'property_id' => $property->get_id(),
							),
							'xout'	=> array(
								'feed' => 'crm',
								'property_id' => $property->get_id(),
							),
							'share'	=> array(
								'property_id' => $property->get_id(),
								'feed' => 'crm',
								'url' => $property->displayUrl(),
								'address' => $property->displayAddress() ? $property->displayAddress():$property->get_tagline()
							),
						);
						\Action_Buttons::get_instance()->display($args_button_action);
					?>
				</div>
			</div>
		  </div>
		<?php } ?>
<?php }else{//end if $properties ?>
		<div class="col-md-12 items">
			<input type="hidden" value="0" id="nomoredata">
		</div>
<?php }//end if $properties ?>
