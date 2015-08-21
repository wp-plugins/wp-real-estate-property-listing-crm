<div class="row">
	<div class="col-md-6">
		<ul class="list-unstyled left-details">
			<li class="tab-light"><strong>Status :</strong> <?php echo get_single_property_data()->displayPropertyStatus();?></li>
			<li class="tab-dark"><strong>Transaction Type :</strong> <?php echo get_single_property_data()->displayTransaction();?></li>
			<li class="tab-light"><strong>Type :</strong> <?php echo get_single_property_data()->displayPropertyType();?></li>
			<li class="tab-dark"><strong>Location :</strong> <?php echo get_single_property_data()->city;?></li>
			<li class="tab-light"><strong>Community :</strong> <?php echo get_single_property_data()->community;?></li>
			<li class="tab-dark"><strong><?php do_action( 'single_before_lot_area' ); ?>Lot Area :</strong> <?php echo get_single_property_data()->displayAreaMeasurement('lot')->measure . ' ' . get_single_property_data()->displayAreaMeasurement('lot')->area_type;?></li>
		</ul>
	</div>
	<div class="col-md-6">
		<ul class="list-unstyled right-details">
			<li class="tab-light"><strong><?php echo _label('property-code');?> :</strong> <?php echo md_get_mls();?></li>
			<li class="tab-dark"><strong>Price :</strong> <?php echo get_single_property_data()->displayPrice();?></li>
			<li class="tab-light"><strong>Bedroom :</strong> <?php echo get_single_property_data()->beds;?></li>
			<li class="tab-dark"><strong>Bathroom :</strong> <?php echo get_single_property_data()->baths;?></li>
			<li  class="tab-light">
				<?php do_action( 'single_before_floor_area' ); ?>
				<strong>Floor Area : </strong><?php echo get_single_property_data()->displayAreaMeasurement('floor')->measure. ' ' . get_single_property_data()->displayAreaMeasurement('lot')->area_type;?>
			</li>
			<li class="tab-dark"><strong>Year Built :</strong> <?php echo get_single_property_data()->year_built;?></li>
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
