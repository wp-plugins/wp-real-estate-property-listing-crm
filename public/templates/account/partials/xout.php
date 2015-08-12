<div class="xout" style="height:10px;">
	<div class="row">
		<?php foreach($get_xout_property as $property ){ ?>
			<?php \MD\Property::get_instance()->set_properties($property,$property['source']); ?>
			<?php set_loop($property['properties']); ?>
			  <div class="col-xs-12 col-md-<?php echo $col;?> property-item property-id-<?php echo md_property_id();?> <?php echo md_get_source();?>">
				<div class="thumbnail masterdigm-property-box">
					<a href="<?php echo md_property_url();?>" class="propertyphoto">
						<img class="img-responsive" src="<?php echo md_property_img(md_property_id()); ?>" style="<?php !md_property_has_img() ? 'width:170px;height:180px;':''; ?>" alt="Property List Image">
					</a>
					<span class="label label-primary primary-background wp-site-color-theme label-property"><?php echo md_property_transaction();?></span>
					<div class="caption">
						<h3 class="property-name">
							<a href="<?php echo md_property_url();?>" class="<?php //echo get_model_register_class();?>">
								<?php echo md_property_title();?>
							</a>
						</h3>
						<div class="property-amenities">
							<?php if(!has_filter('list_display_area')){ ?>
								<span><strong><?php echo md_property_area();?>&nbsp;</strong><?php echo md_property_area_unit();?></span>
							<?php } ?>
							<?php if(!has_filter('list_display_bed')){ ?>
								<span><strong><?php echo md_property_beds();?>&nbsp;</strong><?php echo _label('beds');?></span>
							<?php } ?>
							<?php if(!has_filter('list_display_baths')){ ?>
								<span><strong><?php echo md_property_bathrooms();?>&nbsp;</strong><?php echo _label('baths');?></span>
							<?php } ?>
							<?php if(!has_filter('list_display_garage')){ ?>
								<span><strong><?php echo md_property_garage();?>&nbsp;</strong><?php echo _label('garage');?></span>
							<?php } ?>
						</div>
						<h2 class="price center-block wp-site-color-theme"><?php echo md_property_price();?></h2>
					</div>
					<div class="panel-footer">
						<?php
							$args_button_action = array(
								'favorite'	=> array(
									'show' => 0,
									'feed' => md_get_source(),
									'property_id' => md_property_id(),
								),
								'xout'	=> array(
									'show' => 0,
									'feed' => md_get_source(),
									'property_id' => md_property_id(),
								),
								'print' => array(
									'show' => 1,
									'url' => get_option('siteurl') . '/printpdf/'.md_property_id(),
								),
								'share'	=> array(
									'property_id' => md_property_id(),
									'feed' => md_get_source(),
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
	</div>
</div>
