<div class="row">
	<div class="col-md-6">
		<ul class="list-unstyled left-details">
			<li>Status : <?php echo get_single_property_data()->displayPropertyStatus();?></li>
			<li>Transaction Type : <?php echo get_single_property_data()->displayTransaction();?></li>
			<li>Type : <?php echo get_single_property_data()->displayPropertyType();?></li>
			<li>Location : <?php echo get_single_property_data()->address;?></li>
			<li>Community : <?php echo get_single_property_data()->community;?></li>
			<li>Lot Area: <?php echo get_single_property_data()->displayAreaMeasurement('lot')->measure . ' ' . get_single_property_data()->displayAreaMeasurement('lot')->area_type;?></li>
		</ul>
	</div>
	<div class="col-md-6">
		<ul class="list-unstyled right-details">
			<li>Property ID : <?php echo get_single_property_data()->id;?></li>
			<li>Price : <?php echo get_single_property_data()->displayPrice();?></li>
			<li>Bedroom : <?php echo get_single_property_data()->beds;?></li>
			<li>Bathroom : <?php echo get_single_property_data()->baths;?></li>
			<li>
				<?php do_action( 'single_before_floor_area' ); ?>
				Floor Area : <?php echo get_single_property_data()->displayAreaMeasurement('floor')->measure. ' ' . get_single_property_data()->displayAreaMeasurement('lot')->area_type;?>
			</li>
			<li>Year Built : <?php echo get_single_property_data()->year_built;?></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="single-property-desc md-container">
			<p><?php echo wp_strip_all_tags(get_single_property_data()->displayDescription());?></p>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="single-property-related md-container">
			<h3>Nearby Properties</h3>
			<?php md_display_nearby_property($atts); ?>
		</div>
	</div>
</div>
