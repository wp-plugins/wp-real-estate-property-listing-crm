<?php if( have_properties() ){ ?>
	<?php foreach(have_properties() as $property ){ ?>
		<?php set_loop($property); ?>
		  <div class="col-xs-12 col-md-<?php echo $col;?> property-item property-id-<?php echo md_property_id();?> <?php echo md_get_source();?>">
			<div class="thumbnail masterdigm-property-box">
				<a href="<?php echo md_property_url();?>" class="propertyphoto">
					<img class="img-responsive" src="<?php echo md_property_img(); ?>" style="<?php !md_property_has_img() ? 'width:170px;height:180px;':''; ?>" alt="Property List Image">
				</a>
				<span class="label label-primary primary-background wp-site-color-theme label-property"><?php echo md_property_transaction();?></span>
				<div class="caption">
					<h3 class="property-name">
						<a href="<?php echo md_property_url();?>" class="<?php //echo get_model_register_class();?>">
							<?php echo md_property_title();?>
						</a>
					</h3>
					<div class="property-amenities">
						<span><strong><?php echo md_property_area();?>&nbsp;</strong><?php echo md_property_area_unit();?></span>
						<span><strong><?php echo md_property_beds();?>&nbsp;</strong>Bed</span>
						<span><strong><?php echo md_property_bathrooms();?>&nbsp;</strong>Bath</span>
						<span><strong><?php echo md_property_garage();?>&nbsp;</strong>Garage</span>
					</div>
					<h2 class="price center-block wp-site-color-theme"><?php echo md_property_price();?></h2>
				</div>
				<div class="panel-footer">
					<?php
						$args_button_action = array(
							'favorite'	=> array(
								'feed' => 'crm',
								'property_id' => md_property_id(),
							),
							'xout'	=> array(
								'feed' => 'crm',
								'property_id' => md_property_id(),
							),
							'share'	=> array(
								'property_id' => md_property_id(),
								'feed' => 'crm',
								'url' => md_property_url(),
								'address' => md_property_title()
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
