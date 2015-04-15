<?php
/*
Template Name: Single - Default Property page
*/
?>
<?php if( get_single_data() && is_property_viewable(md_get_property_status()) ){ ?>
<?php if( function_exists('crm_masterdigm_breadcrumb' ) ){ crm_masterdigm_breadcrumb();} ?>
<div class="single-property-container <?php echo md_property_id();?> crm-single-property" id="<?php echo 'property-id-'.md_property_id();?>">
	<div role="tabpanel">

	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#property-details" aria-controls="property-details" role="tab" data-toggle="tab"><?php echo _tab_key_label('property-details');?></a></li>
		<li role="presentation"><a href="#map-directions" aria-controls="map-directions" role="tab" data-toggle="tab"><?php echo _tab_key_label('map-and-directions');?></a></li>
		<li role="presentation"><a href="#walkscore" aria-controls="walkscore" role="tab" data-toggle="tab"><?php echo _tab_key_label('walk-score');?></a></li>
		<li role="presentation"><a href="#photos" aria-controls="photos" role="tab" data-toggle="tab"><?php echo _tab_key_label('single-photos');?></a></li>
		<?php if( get_single_property_data()->displayParams('videos') ){ ?>
			<li role="presentation"><a href="#video" role="tab" data-toggle="tab"><?php echo _tab_key_label('video');?></a></li>
		<?php } ?>
	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="property-details">
			<ul class="list-inline single-property-quick-info">
				<li class="price">
					<span>Price</span>
					<p><?php echo md_property_price();?></p>
				</li>
				<li class="baths">
					<span>Baths</span>
					<p><?php echo md_property_bathrooms();?></p>
				</li>
				<li class="beds">
					<span>Beds</span>
					<p><?php echo md_property_beds();?></p>
				</li>
				<li class="area-measurement">
					<span><?php echo get_single_property_data()->displayAreaMeasurement('lot')->area_type;?></span>
					<p><?php echo get_single_property_data()->displayAreaMeasurement('lot')->measure;?></p>
				</li>
				<li class="yr-built">
					<span>Year Built</span>
					<p><?php echo md_property_yr_built();?></p>
				</li>
				<li class="mls">
					<span>MLS#</span>
					<p><?php echo get_single_property_data()->displayMLS();?></p>
				</li>
			</ul>

			<div class="row">
				<div class="col-md-9 col-sm-12">
					<div class="single-property-carousel md-container">
						<?php require $template_carousel;?>
					</div>
					<?php require $template_path . 'single/single-property-more-details.php'; ?>
				</div>
				<div class="col-md-3 col-sm-12">
					<div class="right-sidebar">
						<div class="panel panel-default">
						  <div class="panel-body">
						   <?php \Action_Buttons::get_instance()->display($args_button_action); ?>
						  </div>
						</div>
						<?php
							\md_sc_single_properties::get_instance()->display_inquire_form($att_inquire_msg);
						?>
						<?php \MD_Property_Content::get_instance()->displayTagContent(get_single_property_data()); ?>
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="map-directions">
			<div class="single-property-map md-container">
				<?php require $template_path . 'single/partials/map/map.php'; ?>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="walkscore">
			<div class="single-property-walkscore">
				<?php require $template_path . 'single/partials/walkscore/walkscore.php'; ?>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="photos">
			<div class="single-property-photos md-container">
				<?php require $template_path . 'single/partials/photos/photos.php'; ?>
			</div>
		</div>
		<?php if( get_single_property_data()->displayParams('videos') ){ ?>
		  <div role="tabpanel" class="tab-pane" id="video">
				<div class="single-property-videos md-container">
					<?php require PLUGIN_PUBLIC_DIR . 'partials/single-property-video.php'; ?>
				</div>
		  </div>
		<?php } ?>
	  </div>

	</div>
</div>
<script type="text/javascript">
	var mainLat = '<?php echo get_single_property_data()->latitude;?>';
	var mainLng = '<?php echo get_single_property_data()->longitude;?>';
</script>
<?php }else{ ?>
	<h2>This property is currently not active</h2>
<?php } ?>
