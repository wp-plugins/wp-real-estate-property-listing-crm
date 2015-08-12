<div class="row">
	<div class="col-md-6">
		<ul class="list-unstyled left-details">
			<li class="tab-light">Status : <?php echo get_single_property_data()->displayPropertyStatus();?></li>
			<li class="tab-dark">Transaction Type : <?php echo get_single_property_data()->displayTransaction();?></li>
			<li class="tab-light">Type : <?php echo get_single_property_data()->displayPropertyType();?></li>
			<li class="tab-dark">Location : <?php echo get_single_property_data()->address;?></li>
			<li class="tab-light">Community : <?php echo get_single_property_data()->community;?></li>
			<li class="tab-dark"><?php do_action( 'single_before_lot_area' ); ?>Lot Area: <?php echo get_single_property_data()->displayAreaMeasurement('lot')->measure . ' ' . get_single_property_data()->displayAreaMeasurement('lot')->area_type;?></li>
		</ul>
	</div>
	<div class="col-md-6">
		<ul class="list-unstyled right-details">
			<li class="tab-light"><?php echo _label('property-code');?> : <?php echo md_get_mls();?></li>
			<li class="tab-dark">Price : <?php echo get_single_property_data()->displayPrice();?></li>
			<li class="tab-light">Bedroom : <?php echo get_single_property_data()->beds;?></li>
			<li class="tab-dark">Bathroom : <?php echo get_single_property_data()->baths;?></li>
			<li  class="tab-light">
				<?php do_action( 'single_before_floor_area' ); ?>
				Floor Area : <?php echo get_single_property_data()->displayAreaMeasurement('floor')->measure. ' ' . get_single_property_data()->displayAreaMeasurement('lot')->area_type;?>
			</li>
			<li class="tab-dark">Year Built : <?php echo get_single_property_data()->year_built;?></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="single-property-desc md-container">
			<div class="details-txt">
                <h2><span>Details on <?php echo get_single_property_data()->displayAddress('short');?></span></h2>
				<div class="description">
					<?php echo get_single_property_data()->displayDescription();?>
				</div>
			</div>
		</div>
	</div>
</div>
