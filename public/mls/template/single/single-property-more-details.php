<div class="row">
	<div class="col-md-6">
		<ul class="list-unstyled left-details">
			<li class="tab-light">Property ID : <?php echo get_single_property_data()->get_property_id();?></li>
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
			<p><?php echo wp_strip_all_tags(get_single_property_data()->display_public_remarks_new());?></p>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span>Location Information </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-light"><span class="list">County : </span><span class="cont"><?php echo get_single_property_data()->get_county_name();?></span></li>
			<li class="tab-dark"><span class="list">HOA : </span><span class="cont"><?php echo get_single_property_data()->hoa();?></span></li>
			<li class="tab-light"><span class="list">Subdivision : </span><span class="cont"><?php echo get_single_property_data()->legal_subdivision_name();?></span></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span>Interior Features </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-light"><span class="list">Interior Features : </span><span class="cont"><?php echo get_single_property_data()->display_interior_features();?></span></li>
			<li class="tab-dark"><span class="list">Fireplace : </span><span class="cont"><?php echo get_single_property_data()->display_fireplace_yn() == 0 ? 'No':'Yes';?></span></li>
			<li class="tab-light"><span class="list">Heating and Fuel : </span><span class="cont"><?php echo get_single_property_data()->display_heating_fuel();?></span></li>
			<li class="tab-dark"><span class="list">Flooring : </span><span class="cont"><?php echo get_single_property_data()->display_floor_covering();?></span></li>
			<li class="tab-light"><span class="list">Full Baths : </span><span class="cont"><?php echo get_single_property_data()->display_bath_full();?></span></li>
			<li class="tab-dark"><span class="list">Air Conditioning : </span><span class="cont"><?php echo get_single_property_data()->display_air_conditioning();?></span></li>
			<li class="tab-light"><span class="list">Appliances Included : </span><span class="cont"><?php echo get_single_property_data()->display_appliances_included();?></span></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span>Exterior Features </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-light"><span class="list">Construction : </span><span class="cont"><?php echo get_single_property_data()->display_exterior_construction();?></span></li>
			<li class="tab-dark"><span class="list">Foundation : </span><span class="cont"><?php echo get_single_property_data()->display_foundation();?></span></li>
			<li class="tab-light"><span class="list">Garage Features : </span><span class="cont"><?php echo get_single_property_data()->display_garage_features();?></span></li>
			<li class="tab-dark"><span class="list">Garage / Carport : </span><span class="cont"><?php echo get_single_property_data()->display_garage_carport();?></span></li>
			<li class="tab-light"><span class="list">Lot Size Sq Ft : </span><span class="cont"><?php echo get_single_property_data()->display_lot_size_sqft();?></span></li>
			<li class="tab-dark"><span class="list">Pool : </span><span class="cont"><?php echo get_single_property_data()->display_pool();?></span></li>
			<li class="tab-light"><span class="list">Exterior Features : </span><span class="cont"><?php echo get_single_property_data()->display_exterior_features();?></span></li>
			<li class="tab-dark"><span class="list">Roof : </span><span class="cont"><?php echo get_single_property_data()->display_roof();?></span></li>
			<li class="tab-light"><span class="list">Utilities : </span><span class="cont"><?php echo get_single_property_data()->display_utilities();?></span></li>
			<li class="tab-dark"><span class="list">Lot Size Acres : </span><span class="cont"><?php echo get_single_property_data()->display_lot_size_acres();?></span></li>
			<li class="tab-light"><span class="list">Water Frontage : </span><span class="cont"><?php echo get_single_property_data()->display_water_frontage_yn() == 0 ? 'No':'Yes';?></span></li>
			<li class="tab-dark"><span class="list">Pool Type : </span><span class="cont"><?php echo get_single_property_data()->display_pool_type();?></span></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span>Additional Information </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-dark"><span class="list">Year Built : </span><span class="cont"><?php echo get_single_property_data()->displayYearBuilt();?></span></li>
			<li class="tab-light"><span class="list">Tax Year : </span><span class="cont"><?php echo get_single_property_data()->display_tax_year();?></span></li>
			<li class="tab-dark"><span class="list">Property SubType : </span><span class="cont"><?php echo get_single_property_data()->displayPropertyType();?></span></li>
			<li class="tab-light"><span class="list">Taxes : </span><span class="cont"><?php echo get_single_property_data()->display_taxes();?></span></li>
		</ul>
	</div>
</div>
