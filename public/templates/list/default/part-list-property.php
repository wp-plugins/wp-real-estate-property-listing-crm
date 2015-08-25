<div class="thumbnail">
    <a href="<?php echo md_property_url();?>" class="propertyphoto">
		<img class="img-responsive" src="<?php echo md_property_img(md_property_id()); ?>" style="<?php !md_property_has_img() ? 'width:170px;height:180px;':''; ?>" alt="Property List Image">
	</a>
	<div class="caption" style="position:absolute;left:0;bottom:0;">
		<a href="<?php echo md_property_url();?>" class="<?php //echo get_model_register_class();?>">
			<?php echo md_property_title();?>
		</a>
		<ul class="list-unstyled">
			<?php if(!has_filter('list_display_area_'.md_get_source())){ ?>
				 <li><span>
					<strong><?php echo md_property_area();?>&nbsp;</strong>
					<?php do_action( 'list_before_area' ); ?><?php echo md_property_area_unit();?>
				</span> </li>
			<?php } ?>
			<?php if(!has_filter('list_display_bed_'.md_get_source())){ ?>
				<li><span><strong><?php echo md_property_beds();?>&nbsp;</strong><?php echo _label('beds');?></span> </li>
			<?php } ?>
			<?php if(!has_filter('list_display_baths_'.md_get_source())){ ?>
				 <li><span><strong><?php echo md_property_bathrooms();?>&nbsp;</strong><?php echo _label('baths');?></span>  </li>
			<?php } ?>
			<?php if(!has_filter('list_display_garage_'.md_get_source())){ ?>
				<li><span><strong><?php echo md_property_garage();?>&nbsp;</strong><?php echo _label('garage');?></span></li>
			<?php } ?>
		</ul>
		<h3>
			<?php
				if( md_property_raw_price() == 0 ){
					echo md_property_html_price();
				}else{
					echo md_property_format_price();
				}
			?>
		</h3>
	</div>
</div>

