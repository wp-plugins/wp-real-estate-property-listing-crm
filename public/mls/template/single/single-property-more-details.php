<div class="row">
	<div class="col-md-6">
		<ul class="list-unstyled left-details">
			<li>Status : <?php echo get_single_property_data()->displayPropertyStatus();?></li>
			<li>Transaction Type : <?php echo get_single_property_data()->displayTransaction();?></li>
			<li>Type : <?php echo get_single_property_data()->displayPropertyType();?></li>
			<li>Location : <?php echo get_single_property_data()->displayAddress();?></li>
			<li>Lot Area: <?php echo get_single_property_data()->displayAreaMeasurement('lot')->measure . ' ' . get_single_property_data()->displayAreaMeasurement('lot')->area_type;?></li>
		</ul>
	</div>
	<div class="col-md-6">
		<ul class="list-unstyled right-details">
			<li>Property ID : <?php echo get_single_property_data()->get_property_id();?></li>
			<li>Price : <?php echo get_single_property_data()->displayPrice();?></li>
			<li>Bedroom : <?php echo get_single_property_data()->displayBed();?></li>
			<li>Bathroom : <?php echo get_single_property_data()->displayBathrooms();?></li>
			<li>Floor Area : <?php echo get_single_property_data()->displayAreaMeasurement('floor')->measure. ' ' . get_single_property_data()->displayAreaMeasurement('lot')->area_type;?></li>
			<li>Year Built : <?php echo get_single_property_data()->displayYearBuilt();?></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<ul class="list-group">
		  <li class="list-group-item">Air Conditioning : <?php echo get_single_property_data()->display_air_conditioning();?></li>
		  <li class="list-group-item">Appliances Included : <?php echo get_single_property_data()->display_appliances_included();?></li>
		  <li class="list-group-item">Architectural Style : <?php echo get_single_property_data()->display_architectural_style();?></li>
		  <li class="list-group-item">Association Fee Includes : <?php echo get_single_property_data()->display_association_fee_includes();?></li>
		  <li class="list-group-item">Baths Full : <?php echo get_single_property_data()->display_bath_full();?></li>
		  <li class="list-group-item">Baths Half : <?php echo get_single_property_data()->display_bath_half();?></li>
		  <li class="list-group-item">Beds Total : <?php echo get_single_property_data()->display_bed_total();?></li>
		  <li class="list-group-item">Close Date : <?php echo get_single_property_data()->display_close_date();?></li>
		  <li class="list-group-item">Community Features : <?php echo get_single_property_data()->display_community_features();?></li>
		  <li class="list-group-item">County Or Parish : <?php echo get_single_property_data()->display_county_or_parish();?></li>
		  <li class="list-group-item">Current Price : <?php echo get_single_property_data()->display_current_price();?></li>
		  <li class="list-group-item">Elementary School : <?php echo get_single_property_data()->display_elem_school();?></li>
		  <li class="list-group-item">Exterior Construction : <?php echo get_single_property_data()->display_exterior_construction();?></li>
		  <li class="list-group-item">Exterior Features : <?php echo get_single_property_data()->display_exterior_features();?></li>
		  <li class="list-group-item">Fences : <?php echo get_single_property_data()->display_fences();?></li>
		  <li class="list-group-item">Fireplace YN : <?php echo get_single_property_data()->display_fireplace_yn();?></li>
		  <li class="list-group-item">Floor Covering : <?php echo get_single_property_data()->display_floor_covering();?></li>
		  <li class="list-group-item">Foundation : <?php echo get_single_property_data()->display_foundation();?></li>
		  <li class="list-group-item">Garage Carport : <?php echo get_single_property_data()->display_garage_carport();?></li>
		  <li class="list-group-item">Garage Features : <?php echo get_single_property_data()->display_garage_features();?></li>
		  <li class="list-group-item">Heating and Fuel : <?php echo get_single_property_data()->display_heating_fuel();?></li>
		  <li class="list-group-item">High School : <?php echo get_single_property_data()->display_high_school();?></li>
		  <li class="list-group-item">Housing For Older Persons : <?php echo get_single_property_data()->display_housing_for_older_person();?></li>
		  <li class="list-group-item">Interior Features : <?php echo get_single_property_data()->display_interior_features();?></li>
		  <li class="list-group-item">Interior Layout : <?php echo get_single_property_data()->display_interior_layout();?></li>
		  <li class="list-group-item">Kitchen Features : <?php echo get_single_property_data()->display_kitchen_features();?></li>
		  <li class="list-group-item">Legal Subdivision Name : <?php echo get_single_property_data()->display_legal_subdivision_name();?></li>
		  <li class="list-group-item">List Office Name : <?php echo get_single_property_data()->display_list_office_name();?></li>
		  <li class="list-group-item">List Price : <?php echo get_single_property_data()->displayPrice();?></li>
		  <li class="list-group-item">Lot Size Acres : <?php echo get_single_property_data()->display_lot_size_acres();?></li>
		  <li class="list-group-item">Lot Size Sq Ft : <?php echo get_single_property_data()->display_lot_size_sqft();?></li>
		  <li class="list-group-item">Maintenance Includes : <?php echo get_single_property_data()->display_maintenance_includes();?></li>
		  <li class="list-group-item">Middle or Junior School : <?php echo get_single_property_data()->display_middleor_junior_school();?></li>
		  <li class="list-group-item">MLS Number : <?php echo get_single_property_data()->display_mls_number();?></li>
		  <li class="list-group-item">Pool : <?php echo get_single_property_data()->display_pool();?></li>
		  <li class="list-group-item">Pool Type : <?php echo get_single_property_data()->display_pool_type();?></li>
		  <li class="list-group-item">Postal Code : <?php echo get_single_property_data()->display_postal_code();?></li>
		  <li class="list-group-item">Property Type : <?php echo get_single_property_data()->display_property_type();?></li>
		  <li class="list-group-item">Roof : <?php echo get_single_property_data()->display_roof();?></li>
		  <li class="list-group-item">Sq Ft Heated : <?php echo get_single_property_data()->display_sqft_heated();?></li>
		  <li class="list-group-item">Sq Ft Total : <?php echo get_single_property_data()->display_sqft_total();?></li>
		  <li class="list-group-item">State Or Province : <?php echo get_single_property_data()->display_state_or_province();?></li>
		  <li class="list-group-item">Status : <?php echo get_single_property_data()->display_status();?></li>
		  <li class="list-group-item">Street City : <?php echo get_single_property_data()->display_street_city();?></li>
		  <li class="list-group-item">Tax Year : <?php echo get_single_property_data()->display_tax_year();?></li>
		  <li class="list-group-item">Taxes : <?php echo get_single_property_data()->display_taxes();?></li>
		  <li class="list-group-item">Utilities : <?php echo get_single_property_data()->display_utilities();?></li>
		  <li class="list-group-item">Virtual Tour Link : <?php echo get_single_property_data()->display_virtual_tour_link();?></li>
		  <li class="list-group-item">Water Frontage : <?php echo get_single_property_data()->display_water_frontage();?></li>
		  <li class="list-group-item">Water Frontage YN : <?php echo get_single_property_data()->display_water_frontage_yn();?></li>
		  <li class="list-group-item">Year Built : <?php echo get_single_property_data()->displayYearBuilt();?></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="single-property-desc md-container">
			<p><?php echo wp_strip_all_tags(get_single_property_data()->display_public_remarks_new());?></p>
		</div>
	</div>
</div>
