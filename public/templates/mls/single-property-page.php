<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/*
Template Name: Single - Default Property page
*/
?>
<div class="single-property-container <?php echo get_single_property_id();?> crm-single-property">
	<div role="tabpanel">

	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#property-details" aria-controls="property-details" role="tab" data-toggle="tab"><?php echo _tab_key_label('property-details');?></a></li>
		<li role="presentation"><a href="#map-directions" aria-controls="map-directions" role="tab" data-toggle="tab"><?php echo _tab_key_label('map-and-directions');?></a></li>
		<li role="presentation"><a href="#school" aria-controls="school" role="tab" data-toggle="tab"><?php echo _tab_key_label('school-and-information');?></a></li>
		<li role="presentation"><a href="#walkscore" aria-controls="walkscore" role="tab" data-toggle="tab"><?php echo _tab_key_label('walk-score');?></a></li>
		<li role="presentation"><a href="#photos" aria-controls="photos" role="tab" data-toggle="tab"><?php echo _tab_key_label('single-photos');?></a></li>
		<?php if( get_single_property_data()->displayParams('videos') ){ ?>
			<li role="presentation"><a href="#video" role="tab" data-toggle="tab"><?php echo _tab_key_label('video');?></a></li>
		<?php } ?>
	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="property-details">
			<ul class="list-inline">
				<li class="price">
					<span>Price</span>
					<p><?php echo get_single_property_data()->displayPrice();?></p>
				</li>
				<li class="baths">
					<span>Baths</span>
					<p><?php echo get_single_property_data()->displayBathroom();?></p>
				</li>
				<li class="beds">
					<span>Beds</span>
					<p><?php echo get_single_property_data()->displayBed();?></p>
				</li>
				<li class="area-measurement">
					<span><?php echo get_single_property_data()->displayAreaMeasurement('lot')->area_type;?></span>
					<p><?php echo get_single_property_data()->displayAreaMeasurement('lot')->measure;?></p>
				</li>
				<li class="yr-built">
					<span>Year Built</span>
					<p><?php echo get_single_property_data()->displayYearBuilt();?></p>
				</li>
				<li class="mls">
					<span>MLS#</span>
					<p><?php echo get_single_property_data()->displayMLS();?></p>
				</li>
			</ul>

			<div class="row">
				<div class="col-md-9 col-sm-12">
					<div class="single-property-carousel">
						<?php require $template_carousel;?>
					</div>
					<div class="row">
						<div class="col-md-6">
							<ul class="list-unstyled left-details">
								<li>Status : <?php echo get_single_property_data()->displayPropertyStatus();?></li>
								<li>Transaction Type : <?php echo get_single_property_data()->displayTransaction();?></li>
								<li>Type : <?php echo get_single_property_data()->displayPropertyType();?></li>
								<li>Location : <?php echo get_single_property_data()->address;?></li>
								<li>Community : <?php echo get_single_property_data()->community;?></li>
								<li>Lot Area : <?php echo get_single_property_data()->lot_area . ' ' . get_single_property_data()->lot_area_unit;?></li>
							</ul>
						</div>
						<div class="col-md-6">
							<ul class="list-unstyled right-details">
								<li>Property ID : <?php echo get_single_property_data()->id;?></li>
								<li>Price : <?php echo get_single_property_data()->displayPrice();?></li>
								<li>Bedroom : <?php echo get_single_property_data()->beds;?></li>
								<li>Bathroom : <?php echo get_single_property_data()->baths;?></li>
								<li>Floor Area : <?php echo get_single_property_data()->floor_area. ' ' . get_single_property_data()->floor_area_unit;?></li>
								<li>Year Built : <?php echo get_single_property_data()->year_built;?></li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="single-property-desc">
								<p><?php echo get_single_property_data()->displayDescription();?></p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="single-property-related">
								<h3>Nearby Properties</h3>
								<?php //md_display_nearby_property($atts); ?>
								<?php //display_single_related_properties($att_nearby_prop_col);?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-12">
					<div class="right-sidebar">
						<p>Right Side Bar</p>
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="map-directions">
			<div class="single-property-map">
				<?php require 'partials/map/map.php'; ?>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="school">
			<div class="single-property-school">
				<p>school</p>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="walkscore">
			<div class="single-property-walkscore">
				<p>walkscore</p>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="photos">
			<div class="single-property-photos">
				<p>photos</p>
			</div>
		</div>
		<?php if( get_single_property_data()->displayParams('videos') ){ ?>
		  <div role="tabpanel" class="tab-pane" id="video">
			<?php //include('single-property-video.php'); ?>
		  </div>
		<?php } ?>
	  </div>

	</div>
</div>
