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
		<ul class="list-unstyled">
		  <li class="">Air Conditioning : <?php echo get_single_property_data()->display_air_conditioning();?></li>
		  <li class="">Appliances Included : <?php echo get_single_property_data()->display_appliances_included();?></li>
		  <li class="">Architectural Style : <?php echo get_single_property_data()->display_architectural_style();?></li>
		  <li class="">Association Fee Includes : <?php echo get_single_property_data()->display_association_fee_includes();?></li>
		  <li class="">Baths Full : <?php echo get_single_property_data()->display_bath_full();?></li>
		  <li class="">Baths Half : <?php echo get_single_property_data()->display_bath_half();?></li>
		  <li class="">Beds Total : <?php echo get_single_property_data()->display_bed_total();?></li>
		  <li class="">Close Date : <?php echo get_single_property_data()->display_close_date();?></li>
		  <li class="">Community Features : <?php echo get_single_property_data()->display_community_features();?></li>
		  <li class="">County Or Parish : <?php echo get_single_property_data()->display_county_or_parish();?></li>
		  <li class="">Current Price : <?php echo get_single_property_data()->display_current_price();?></li>
		  <li class="">Elementary School : <?php echo get_single_property_data()->display_elem_school();?></li>
		  <li class="">Exterior Construction : <?php echo get_single_property_data()->display_exterior_construction();?></li>
		  <li class="">Exterior Features : <?php echo get_single_property_data()->display_exterior_features();?></li>
		  <li class="">Fences : <?php echo get_single_property_data()->display_fences();?></li>
		  <li class="">Fireplace YN : <?php echo get_single_property_data()->display_fireplace_yn();?></li>
		  <li class="">Floor Covering : <?php echo get_single_property_data()->display_floor_covering();?></li>
		  <li class="">Foundation : <?php echo get_single_property_data()->display_foundation();?></li>
		  <li class="">Garage Carport : <?php echo get_single_property_data()->display_garage_carport();?></li>
		  <li class="">Garage Features : <?php echo get_single_property_data()->display_garage_features();?></li>
		  <li class="">Heating and Fuel : <?php echo get_single_property_data()->display_heating_fuel();?></li>
		  <li class="">High School : <?php echo get_single_property_data()->display_high_school();?></li>
		  <li class="">Housing For Older Persons : <?php echo get_single_property_data()->display_housing_for_older_person();?></li>
		  <li class="">Interior Features : <?php echo get_single_property_data()->display_interior_features();?></li>
		  <li class="">Interior Layout : <?php echo get_single_property_data()->display_interior_layout();?></li>
		  <li class="">Kitchen Features : <?php echo get_single_property_data()->display_kitchen_features();?></li>
		  <li class="">Legal Subdivision Name : <?php echo get_single_property_data()->display_legal_subdivision_name();?></li>
		  <li class="">List Office Name : <?php echo get_single_property_data()->display_list_office_name();?></li>
		  <li class="">List Price : <?php echo get_single_property_data()->displayPrice();?></li>
		  <li class="">Lot Size Acres : <?php echo get_single_property_data()->display_lot_size_acres();?></li>
		  <li class="">Lot Size Sq Ft : <?php echo get_single_property_data()->display_lot_size_sqft();?></li>
		  <li class="">Maintenance Includes : <?php echo get_single_property_data()->display_maintenance_includes();?></li>
		  <li class="">Middle or Junior School : <?php echo get_single_property_data()->display_middleor_junior_school();?></li>
		  <li class="">MLS Number : <?php echo get_single_property_data()->display_mls_number();?></li>
		  <li class="">Pool : <?php echo get_single_property_data()->display_pool();?></li>
		  <li class="">Pool Type : <?php echo get_single_property_data()->display_pool_type();?></li>
		  <li class="">Postal Code : <?php echo get_single_property_data()->display_postal_code();?></li>
		  <li class="">Property Type : <?php echo get_single_property_data()->display_property_type();?></li>
		  <li class="">Roof : <?php echo get_single_property_data()->display_roof();?></li>
		  <li class="">Sq Ft Heated : <?php echo get_single_property_data()->display_sqft_heated();?></li>
		  <li class="">Sq Ft Total : <?php echo get_single_property_data()->display_sqft_total();?></li>
		  <li class="">State Or Province : <?php echo get_single_property_data()->display_state_or_province();?></li>
		  <li class="">Status : <?php echo get_single_property_data()->display_status();?></li>
		  <li class="">Street City : <?php echo get_single_property_data()->display_street_city();?></li>
		  <li class="">Tax Year : <?php echo get_single_property_data()->display_tax_year();?></li>
		  <li class="">Taxes : <?php echo get_single_property_data()->display_taxes();?></li>
		  <li class="">Utilities : <?php echo get_single_property_data()->display_utilities();?></li>
		  <li class="">Virtual Tour Link : <?php echo get_single_property_data()->display_virtual_tour_link();?></li>
		  <li class="">Water Frontage : <?php echo get_single_property_data()->display_water_frontage();?></li>
		  <li class="">Water Frontage YN : <?php echo get_single_property_data()->display_water_frontage_yn();?></li>
		  <li class="">Year Built : <?php echo get_single_property_data()->displayYearBuilt();?></li>
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
<div class="row">
	<div class="col-md-12">
		<div class="single-property-related md-container">
			<h3>Nearby Properties</h3>
			<?php md_display_nearby_property($atts); ?>
		</div>
	</div>
</div>
