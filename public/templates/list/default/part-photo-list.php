<div class="col-xs-12 col-sm-6 col-md-<?php echo $col;?> property-item property-id-<?php echo md_property_id();?> <?php echo md_get_source();?>">
	<?php
		if( has_filter("view_before_thumbnail_" . md_get_source()) ){
			apply_filters("view_before_thumbnail_" . md_get_source(), md_property_id());
		}
	?>
	<?php
		if( has_filter("view_before_thumbnail") ){
			apply_filters("view_before_thumbnail", md_property_id());
		}
	?>
	<div class="thumbnail masterdigm-property-box">
		<a href="<?php echo md_property_url();?>" class="propertyphoto" target="<?php echo open_property_in();?>">
			<img class="img-responsive" src="<?php echo md_property_img(md_property_id()); ?>" style="<?php !md_property_has_img() ? 'width:170px;height:180px;':''; ?>" alt="Property List Image">
		</a>
		<span class="label label-primary primary-background wp-site-color-theme label-property"><?php echo md_property_transaction();?></span>
		<div class="caption">
			<h3 class="property-name">
				<a href="<?php echo md_property_url();?>" class="<?php //echo get_model_register_class();?>" target="<?php echo open_property_in();?>">
					<?php echo md_property_title();?>
				</a>
			</h3>
			<div class="property-amenities">
				<?php if(!has_filter('list_display_area_'.md_get_source())){ ?>
					<span>
						<strong><?php echo md_property_area();?>&nbsp;</strong>
						<?php do_action( 'list_before_area' ); ?><?php echo md_property_area_unit();?>
					</span>
				<?php } ?>
				<?php if(!has_filter('list_display_bed_'.md_get_source())){ ?>
					<span><strong><?php echo md_property_beds();?>&nbsp;</strong><?php echo _label('beds');?></span>
				<?php } ?>
				<?php if(!has_filter('list_display_baths_'.md_get_source())){ ?>
					<span><strong><?php echo md_property_bathrooms();?>&nbsp;</strong><?php echo _label('baths');?></span>
				<?php } ?>
				<?php if(!has_filter('list_display_garage_'.md_get_source())){ ?>
					<span><strong><?php echo md_property_garage();?>&nbsp;</strong><?php echo _label('garage');?></span>
				<?php } ?>
			</div>
			<h2 class="price center-block wp-site-color-theme">
				<?php
					if( md_property_raw_price() == 0 ){
						echo md_property_html_price();
					}else{
						echo md_property_format_price();
					}
				?>
			</h2>
		</div>
		<div class="panel-footer">
			<?php
				$args_button_action = array(
					'favorite'	=> array(
						'feed' => md_get_source(),
						'property_id' => md_property_id(),
					),
					'xout'	=> array(
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
