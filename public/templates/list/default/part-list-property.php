<div class="property-list-body bg-primary">
	<div class="media">
	  <div class="media-left" style="width:20%;">
		<a href="<?php echo md_property_url();?>" class="propertyphoto" target="<?php echo open_property_in();?>">
			<img class="lazy" data-original="<?php echo md_property_img(md_property_id()); ?>" style="max-width:115px;height:115px;" alt="Property List Image">
		</a>
	  </div>
	  <div class="media-body">
		<p>
			<?php echo md_property_address('tiny');?>
		</p>
		<span class="">
			<strong>
			Price :
			<?php
				if( md_property_raw_price() == 0 ){
					echo md_property_html_price();
				}else{
					echo md_property_format_price();
				}
			?>
			</strong>
		</span> |
		<?php if(!has_filter('list_display_area_'.md_get_source())){ ?>
			<span>
				<strong>
					<?php echo apply_filters('property_area_'.md_get_source(), get_property_area());?>
					&nbsp;
				</strong>
				<?php do_action( 'list_before_area' ); ?>
				<?php echo apply_filters('property_area_unit_'.md_get_source(), get_property_area_unit());?>
			</span> |
		<?php } ?>
		<?php if(!has_filter('list_display_bed_'.md_get_source())){ ?>
			<span><strong><?php echo md_property_beds();?>&nbsp;</strong><?php echo _label('beds');?></span> |
		<?php } ?>
		<?php if(!has_filter('list_display_baths_'.md_get_source())){ ?>
			<span><strong><?php echo md_property_bathrooms();?>&nbsp;</strong><?php echo _label('baths');?></span> |
		<?php } ?>
		<?php if(!has_filter('list_display_garage_'.md_get_source())){ ?>
			<span><strong><?php echo md_property_garage();?>&nbsp;</strong><?php echo _label('garage');?></span>
		<?php } ?>
	  </div>
	</div>
</div>

