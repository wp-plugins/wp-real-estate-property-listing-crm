<div class="row">
	<div class="col-md-6">
		<ul class="list-unstyled left-details">
			<li class="tab-light">Property ID : <?php echo md_get_mls();?></li>
			<li class="tab-dark">Status : <?php echo get_single_property_data()->display_status();?></li>
			<li class="tab-light">Location : <?php echo get_single_property_data()->displayAddress();?></li>
			<li class="tab-dark">Bedroom : <?php echo get_single_property_data()->displayBed();?></li>
			<li class="tab-light">Living Sq. Ft: <?php echo get_single_property_data()->get_sqft_heated();?></li>
		</ul>
	</div>
	<div class="col-md-6">
		<ul class="list-unstyled right-details">
			<li class="tab-light">Lot Area: <?php echo get_single_property_data()->get_lot_area() . ' ' . get_single_property_data()->displayAreaMeasurement('lot')->area_type;?></li>
			<li class="tab-dark">Price : <?php echo get_single_property_data()->displayPrice();?></li>
			<li class="tab-light">Bathroom : <?php echo get_single_property_data()->displayBathrooms();?></li>
			<li class="tab-dark">Year Built : <?php echo get_single_property_data()->displayYearBuilt();?></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="single-property-desc md-container">
			<h2><span>Details on <?php echo md_property_address('short');?></span></h2>
			<p><?php echo wp_strip_all_tags(get_single_property_data()->displayDescription());?></p>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span>Location Information </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-light">County :  <?php echo get_single_property_data()->get_county_name();?> </li>
			<li class="tab-dark">HOA :  <?php echo get_single_property_data()->hoa();?> </li>
			<li class="tab-light">Subdivision :  <?php echo get_single_property_data()->community();?> </li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span>Interior Features </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-light">Interior Features :  <?php echo get_single_property_data()->display_interior_features();?> </li>
			<li class="tab-dark">Fireplace :  <?php echo get_single_property_data()->display_fireplace_yn() == 0 ? 'No':'Yes';?> </li>
			<li class="tab-light">Heating and Fuel :  <?php echo get_single_property_data()->display_heating_fuel();?> </li>
			<li class="tab-dark">Flooring :  <?php echo get_single_property_data()->display_floor_covering();?> </li>
			<li class="tab-light">Full Baths :  <?php echo get_single_property_data()->display_bath_full();?> </li>
			<li class="tab-dark">Air Conditioning :  <?php echo get_single_property_data()->display_air_conditioning();?> </li>
			<li class="tab-light">Heat / Air Conditioning :  <?php echo get_single_property_data()->display_heat_air_conditioning();?> </li>
			<li class="tab-dark">Appliances Included :  <?php echo get_single_property_data()->display_appliances_included();?> </li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span>Exterior Features </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-light">Construction :  <?php echo get_single_property_data()->display_exterior_construction();?> </li>
			<li class="tab-dark">Foundation :  <?php echo get_single_property_data()->display_foundation();?> </li>
			<li class="tab-light">Garage Features :  <?php echo get_single_property_data()->display_garage_features();?> </li>
			<li class="tab-dark">Garage / Carport :  <?php echo get_single_property_data()->display_garage_carport();?> </li>
			<li class="tab-light">Lot Size Sq Ft :  <?php echo get_single_property_data()->display_lot_size_sqft();?> </li>
			<li class="tab-dark">Exterior Features :  <?php echo get_single_property_data()->display_exterior_features();?> </li>
			<li class="tab-light">Roof :  <?php echo get_single_property_data()->display_roof();?> </li>
			<li class="tab-dark">Utilities :  <?php echo get_single_property_data()->display_utilities();?> </li>
			<li class="tab-light">Lot Size Acres :  <?php echo get_single_property_data()->display_lot_size_acres();?> </li>
			<li class="tab-dark">Water Frontage :  <?php echo get_single_property_data()->display_water_frontage_yn() == 0 ? 'No':'Yes';?> </li>
			<li class="tab-light">Pool :  <?php echo get_single_property_data()->display_pool();?> </li>
			<li class="tab-dark">Pool Type :  <?php echo get_single_property_data()->display_pool_type();?> </li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span>Additional Information </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-dark">Year Built :  <?php echo get_single_property_data()->displayYearBuilt();?> </li>
			<li class="tab-light">Property SubType :  <?php echo get_single_property_data()->display_property_type();?> </li>
			<li class="tab-dark">Taxes :  <?php echo get_single_property_data()->display_taxes();?> </li>
			<li class="tab-light">Tax Year :  <?php echo get_single_property_data()->display_tax_year();?> </li>
			<li class="tab-dark">Listing Office :  <?php echo get_single_property_data()->display_listing_office();?> </li>
		</ul>
	</div>
</div>
