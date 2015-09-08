<tr class="<?php echo md_property_id();?>-sidebar property-list" data-property-id="<?php echo md_property_id();?>" id="<?php echo md_property_id();?>">
	<td><?php echo md_property_title();?></td>
	<td>
	<?php
		if( md_property_raw_price() == 0 ){
			echo md_property_html_price();
		}else{
			echo md_property_format_price();
		}
	?>
	</td>
	<td>
	<?php if(!has_filter('list_display_bed_'.md_get_source())){ ?>
		<?php echo md_property_beds();?>&nbsp;<?php echo _label('beds');?>
	<?php } ?>
	</td>
	<td>
	<?php if(!has_filter('list_display_bed_'.md_get_source())){ ?>
		<?php echo md_property_bathrooms();?>&nbsp;<?php echo _label('baths');?>
	<?php } ?>
	</td>
	<td>
	<?php if(!has_filter('list_display_area_'.md_get_source())){ ?>
			<?php echo apply_filters('property_area_'.md_get_source(), get_property_area());?>
			&nbsp;
			<?php do_action( 'list_before_area' ); ?>
			<?php echo apply_filters('property_area_unit_'.md_get_source(), get_property_area_unit());?>
	<?php } ?>
	</td>
</tr>
