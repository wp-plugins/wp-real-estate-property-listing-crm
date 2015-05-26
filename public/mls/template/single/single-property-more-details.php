<div class="row">
	<div class="col-md-6">
		<ul class="list-unstyled left-details">
			<li class="tab-light">Status : <?php echo get_single_property_data()->displayPropertyStatus();?></li>
			<li class="tab-dark">Transaction Type : <?php echo get_single_property_data()->displayTransaction();?></li>
			<li class="tab-light">Type : <?php echo get_single_property_data()->displayPropertyType();?></li>
			<li class="tab-dark">Location : <?php echo get_single_property_data()->displayAddress();?></li>
			<li class="tab-light">Lot Area: <?php echo get_single_property_data()->get_lot_area() . ' ' . get_single_property_data()->displayAreaMeasurement('lot')->area_type;?></li>
		</ul>
	</div>
	<div class="col-md-6">
		<ul class="list-unstyled right-details">
			<li class="tab-light">Property ID : <?php echo get_single_property_data()->get_property_id();?></li>
			<li class="tab-dark">Price : <?php echo get_single_property_data()->displayPrice();?></li>
			<li class="tab-light">Bedroom : <?php echo get_single_property_data()->displayBed();?></li>
			<li class="tab-dark">Bathroom : <?php echo get_single_property_data()->displayBathrooms();?></li>
			<li class="tab-light">Floor Area : <?php echo get_single_property_data()->get_floor_area(). ' ' . get_single_property_data()->displayAreaMeasurement('lot')->area_type;?></li>
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
		<ul class="list-unstyled left-details">
		  <li class="tab-light"><span class="list">Air Conditioning : </span><span class="cont"><?php echo get_single_property_data()->display_air_conditioning();?></span></li>
		  <li class="tab-dark"><span class="list">Appliances Included : </span><span class="cont"><?php echo get_single_property_data()->display_appliances_included();?></span></li>
		  <li class="tab-light"><span class="list">Architectural Style : </span><span class="cont"><?php echo get_single_property_data()->display_architectural_style();?></span></li>
		  <li class="tab-dark"><span class="list">Association Fee Includes : </span><span class="cont"><?php echo get_single_property_data()->display_association_fee_includes();?></span></li>
		  <li class="tab-light"><span class="list">Baths Full : </span><span class="cont"><?php echo get_single_property_data()->display_bath_full();?></span></li>
		  <li class="tab-dark"><span class="list">Baths Half : </span><span class="cont"><?php echo get_single_property_data()->display_bath_half();?></span></li>
		  <li class="tab-light"><span class="list">Beds Total : </span><span class="cont"><?php echo get_single_property_data()->display_bed_total();?></span></li>
		  <li class="tab-dark"><span class="list">Community Features : </span><span class="cont"><?php echo get_single_property_data()->display_community_features();?></span></li>
		  <li class="tab-light"><span class="list">County Or Parish : </span><span class="cont"><?php echo get_single_property_data()->display_county_or_parish();?></span></li>
		  <li class="tab-dark"><span class="list">Elementary School : </span><span class="cont"><?php echo get_single_property_data()->display_elem_school();?></span></li>
		  <li class="tab-light"><span class="list">Exterior Construction : </span><span class="cont"><?php echo get_single_property_data()->display_exterior_construction();?></span></li>
		  <li class="tab-dark"><span class="list">Exterior Features : </span><span class="cont"><?php echo get_single_property_data()->display_exterior_features();?></span></li>
		  <li class="tab-light"><span class="list">Fences : </span><span class="cont"><?php echo get_single_property_data()->display_fences();?></span></li>
		  <li class="tab-dark"><span class="list">Fireplace YN : </span><span class="cont"><?php echo get_single_property_data()->display_fireplace_yn() == 0 ? 'No':'Yes';?></span></li>
		  <li class="tab-light"><span class="list">Floor Covering : </span><span class="cont"><?php echo get_single_property_data()->display_floor_covering();?></span></li>
		  <li class="tab-dark"><span class="list">Foundation : </span><span class="cont"><?php echo get_single_property_data()->display_foundation();?></span></li>
		  <li class="tab-light"><span class="list">Garage Carport : </span><span class="cont"><?php echo get_single_property_data()->display_garage_carport();?></span></li>
		  <li class="tab-dark"><span class="list">Garage Features : </span><span class="cont"><?php echo get_single_property_data()->display_garage_features();?></span></li>
		  <li class="tab-light"><span class="list">Heating and Fuel : </span><span class="cont"><?php echo get_single_property_data()->display_heating_fuel();?></span></li>
		  <li class="tab-dark"><span class="list">High School : </span><span class="cont"><?php echo get_single_property_data()->display_high_school();?></span></li>
		  <li class="tab-light"><span class="list">Housing For Older Persons : </span><span class="cont"><?php echo get_single_property_data()->display_housing_for_older_person();?></span></li>
		  <li class="tab-dark"><span class="list">Interior Features : </span><span class="cont"><?php echo get_single_property_data()->display_interior_features();?></span></li>
		  <li class="tab-light"><span class="list">Interior Layout : </span><span class="cont"><?php echo get_single_property_data()->display_interior_layout();?></span></li>
		  <li class="tab-dark"><span class="list">Kitchen Features : </span><span class="cont"><?php echo get_single_property_data()->display_kitchen_features();?></span></li>
		  <li class="tab-light"><span class="list">Legal Subdivision Name : </span><span class="cont"><?php echo get_single_property_data()->display_legal_subdivision_name();?></span></li>
		  <li class="tab-dark"><span class="list">List Office Name : </span><span class="cont"><?php echo get_single_property_data()->display_list_office_name();?></span></li>
		  <li class="tab-light"><span class="list">List Price : </span><span class="cont"><?php echo get_single_property_data()->displayPrice();?></span></li>
		  <li class="tab-dark"><span class="list">Lot Size Acres : </span><span class="cont"><?php echo get_single_property_data()->display_lot_size_acres();?></span></li>
		  <li class="tab-light"><span class="list">Lot Size Sq Ft : </span><span class="cont"><?php echo get_single_property_data()->display_lot_size_sqft();?></span></li>
		  <li class="tab-dark"><span class="list">Maintenance Includes : </span><span class="cont"><?php echo get_single_property_data()->display_maintenance_includes();?></span></li>
		  <li class="tab-light"><span class="list">Middle or Junior School : </span><span class="cont"><?php echo get_single_property_data()->display_middleor_junior_school();?></span></li>
		  <li class="tab-dark"><span class="list">MLS Number : </span><span class="cont"><?php echo get_single_property_data()->display_mls_number();?></span></li>
		  <li class="tab-light"><span class="list">Pool : </span><span class="cont"><?php echo get_single_property_data()->display_pool();?></span></li>
		  <li class="tab-dark"><span class="list">Pool Type : </span><span class="cont"><?php echo get_single_property_data()->display_pool_type();?></span></li>
		  <li class="tab-light"><span class="list">Postal Code : </span><span class="cont"><?php echo get_single_property_data()->display_postal_code();?></span></li>
		  <li class="tab-dark"><span class="list">Property Type : </span><span class="cont"><?php echo get_single_property_data()->display_property_type();?></span></li>
		  <li class="tab-light"><span class="list">Roof : </span><span class="cont"><?php echo get_single_property_data()->display_roof();?></span></li>
		  <li class="tab-dark"><span class="list">Sq Ft Heated : </span><span class="cont"><?php echo get_single_property_data()->display_sqft_heated();?></span></li>
		  <li class="tab-light"><span class="list">Sq Ft Total : </span><span class="cont"><?php echo get_single_property_data()->display_sqft_total();?></span></li>
		  <li class="tab-dark"><span class="list">State Or Province : </span><span class="cont"><?php echo get_single_property_data()->display_state_or_province();?></span></li>
		  <li class="tab-light"><span class="list">Status : </span><span class="cont"> <?php echo get_single_property_data()->display_status();?></span></li>
		  <li class="tab-dark"><span class="list">Street City : </span><span class="cont"><?php echo get_single_property_data()->display_street_city();?></span></li>
		  <li class="tab-light"><span class="list">Tax Year : </span><span class="cont"><?php echo get_single_property_data()->display_tax_year();?></span></li>
		  <li class="tab-dark"><span class="list">Taxes : </span><span class="cont"><?php echo get_single_property_data()->display_taxes();?></span></li>
		  <li class="tab-light"><span class="list">Utilities : </span><span class="cont"><?php echo get_single_property_data()->display_utilities();?></span></li>
		  <li class="tab-dark"><a href="<?php echo get_single_property_data()->display_virtual_tour_link();?>" target="_blank">Click for Virtual Tour Link </a></span></li>
		  <li class="tab-light"><span class="list">Water Frontage : </span><span class="cont"><?php echo get_single_property_data()->display_water_frontage();?></span></li>
		  <li class="tab-dark"><span class="list">Water Frontage YN : </span><span class="cont"><?php echo get_single_property_data()->display_water_frontage_yn() == 0 ? 'No':'Yes';?></span></li>
		  <li class="tab-light"><span class="list">Year Built : </span><span class="cont"><?php echo get_single_property_data()->displayYearBuilt();?></span></li>
		</ul>
	</div>
</div>

