<div class="row">
	<div class="col-md-6">
		<ul class="list-unstyled left-details">
			<li class="tab-light"><strong>Property ID : </strong><?php echo md_get_mls();?></li>
			<li class="tab-dark"><strong>Status : </strong><?php echo get_single_property_data()->display_status();?></li>
			<li class="tab-light"><strong>Location : </strong><?php echo get_single_property_data()->displayAddress();?></li>
			<li class="tab-dark"><strong>Bedroom : </strong><?php echo get_single_property_data()->displayBed();?></li>
			<li class="tab-light"><strong>Living Sq. Ft: </strong><?php echo get_single_property_data()->get_sqft_heated();?></li>
		</ul>
	</div>
	<div class="col-md-6">
		<ul class="list-unstyled right-details">
			<li class="tab-light"><strong>Lot Area: </strong><?php echo get_single_property_data()->get_lot_area() . ' ' . get_single_property_data()->displayAreaMeasurement('lot')->area_type;?></li>
			<li class="tab-dark"><strong>Price : </strong><?php echo get_single_property_data()->displayPrice();?></li>
			<li class="tab-light"><strong>Bathroom : </strong><?php echo get_single_property_data()->displayBathrooms();?></li>
			<li class="tab-dark"><strong>Year Built : </strong><?php echo get_single_property_data()->displayYearBuilt();?></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="single-property-desc md-container">
			<h2><span>Details on </strong><?php echo md_property_address('short');?></span></h2>
			<p></strong><?php echo wp_strip_all_tags(get_single_property_data()->displayDescription());?></p>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span>Location Information </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-light"><strong>County :  </strong><?php echo get_single_property_data()->get_county_name();?> </li>
			<li class="tab-dark"><strong>HOA :  </strong><?php echo get_single_property_data()->hoa();?> </li>
			<li class="tab-light"><strong>Subdivision :  </strong><?php echo get_single_property_data()->community();?> </li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span>Interior Features </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-light"><strong>Interior Features :  </strong><?php echo get_single_property_data()->display_interior_features();?> </li>
			<li class="tab-dark"><strong>Fireplace :  </strong><?php echo get_single_property_data()->display_fireplace_yn() == 0 ? 'No':'Yes';?> </li>
			<li class="tab-light"><strong>Heating and Fuel :  </strong><?php echo get_single_property_data()->display_heating_fuel();?> </li>
			<li class="tab-dark"><strong>Flooring :  </strong><?php echo get_single_property_data()->display_floor_covering();?> </li>
			<li class="tab-light"><strong>Full Baths :  </strong><?php echo get_single_property_data()->display_bath_full();?> </li>
			<li class="tab-dark"><strong>Air Conditioning :  </strong><?php echo get_single_property_data()->display_air_conditioning();?> </li>
			<li class="tab-light"><strong>Heat / Air Conditioning :  </strong><?php echo get_single_property_data()->display_heat_air_conditioning();?> </li>
			<li class="tab-dark"><strong>Appliances Included :  </strong><?php echo get_single_property_data()->display_appliances_included();?> </li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span>Exterior Features </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-light"><strong>Construction :  </strong><?php echo get_single_property_data()->display_exterior_construction();?> </li>
			<li class="tab-dark"><strong>Foundation :  </strong><?php echo get_single_property_data()->display_foundation();?> </li>
			<li class="tab-light"><strong>Garage Features :  </strong><?php echo get_single_property_data()->display_garage_features();?> </li>
			<li class="tab-dark"><strong>Garage / Carport :  </strong><?php echo get_single_property_data()->display_garage_carport();?> </li>
			<li class="tab-light"><strong>Lot Size Sq Ft :  </strong><?php echo get_single_property_data()->display_lot_size_sqft();?> </li>
			<li class="tab-dark"><strong>Exterior Features :  </strong><?php echo get_single_property_data()->display_exterior_features();?> </li>
			<li class="tab-light"><strong>Roof :  </strong><?php echo get_single_property_data()->display_roof();?> </li>
			<li class="tab-dark"><strong>Utilities :  </strong><?php echo get_single_property_data()->display_utilities();?> </li>
			<li class="tab-light"><strong>Lot Size Acres :  </strong><?php echo get_single_property_data()->display_lot_size_acres();?> </li>
			<li class="tab-dark"><strong>Water Frontage :  </strong><?php echo get_single_property_data()->display_water_frontage_yn() == 0 ? 'No':'Yes';?> </li>
			<li class="tab-light"><strong>Pool :  </strong><?php echo get_single_property_data()->display_pool();?> </li>
			<li class="tab-dark"><strong>Pool Type :  </strong><?php echo get_single_property_data()->display_pool_type();?> </li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span>Additional Information </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-dark"><strong>Year Built :  </strong><?php echo get_single_property_data()->displayYearBuilt();?> </li>
			<li class="tab-light"><strong>Property SubType :  </strong><?php echo get_single_property_data()->display_property_type();?> </li>
			<li class="tab-dark"><strong>Taxes :  </strong><?php echo get_single_property_data()->display_taxes();?> </li>
			<li class="tab-light"><strong>Tax Year :  </strong><?php echo get_single_property_data()->display_tax_year();?> </li>
			<li class="tab-dark"><strong>Listing Office :  </strong><?php echo get_single_property_data()->display_listing_office();?> </li>
		</ul>
	</div>
</div>
