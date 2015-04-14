<div class="row md-container">
	<div class="col-md-12">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#map-view" aria-controls="map-view" role="tab" data-toggle="tab">Map View</a></li>
			<li role="presentation"><a href="#street-view" aria-controls="street-view" role="tab" data-toggle="tab">Street View</a></li>
			<li role="presentation"><a href="#birdseye-view" aria-controls="birdseye-view" role="tab" data-toggle="tab">Birds Eye View</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content md-container">
			<div role="tabpanel" class="tab-pane active" id="map-view">
				<div class="map_view"></div>
				<h3>Distance & Driving Directions</h3>
				<form id="get_directions">
				  <div class="form-group">
					<label for="From">From</label>
					<input type="text" class="form-control" id="from" placeholder="From">
				  </div>
				  <div class="form-group">
					<label for="to">To</label>
					<input type="text" class="form-control" id="from" placeholder="To" value="<?php echo get_single_property_data()->displayAddress();?>" readonly>
				  </div>
				  <button type="submit" class="btn btn-default">Get Directions</button>
				</form>
				<div class="directions"></div>
			</div>
			<div role="tabpanel" class="tab-pane" id="street-view">
				<div class="street_view" id="street_view"></div>
			</div>
			<div role="tabpanel" class="tab-pane" id="birdseye-view">
				<div class="birdseye_view"></div>
			</div>
		</div>

	</div>
</div>
<script type="text/javascript">
	var origin_place = '<?php echo remove_nonaplha(get_single_property_data()->displayAddress());?>';
	var propertyList =[
		{
			latLng:[<?php echo md_get_lat();?>, <?php echo md_get_lon();?>],
			data:'<div style="width: 100%; min-height: 120px;">' +
						'<div style="width: 100%; overflow: hidden;">' +
							'<div class="row">' +
								'<div class="col-md-5 col-sm-12">' +
									'<img src="<?php //echo get_single_property_data()->getPhotoUrl(get_single_property_photos())[0] ? get_single_property_data()->getPhotoUrl(get_single_property_photos())[0] : PLUGIN_ASSET_URL . 'house.png';?>" style="width:150px;">' +
								'</div>'+
								'<div class="col-md-7 col-sm-12">' +
									'<h3 style="margin:0;padding:0;color:#428bca;">' +
										'<?php //echo (get_single_property_data()->displayAddress() != '') ? remove_nonaplha(get_single_property_data()->displayAddress()):remove_nonaplha(get_single_property_data()->tag_line);?>' +
									'</h3>' +
									'<h3 style="margin:0;padding:0;color:#d9534f;">' +
										'<?php //echo get_single_property_data()->displayPrice();?> - <?php //echo get_single_property_data()->displayTransaction();?>' +
									'</h3>' +
									'<div>' +
										'<span><?php //echo get_single_property_data()->displayFloorArea();?> Floor Area</span></br>' +
										'<span><?php //echo get_single_property_data()->beds;?> Bedrooms</span></br>' +
										'<span><?php //echo get_single_property_data()->baths;?> Bathrooms</span></br>' +
										'<span><?php //echo get_single_property_data()->garage;?> Garages</span>' +
									'</div>' +
								'</div>'+
							'</div>'+
						'</div>'+
			'</div>',
			options:{icon: "http://maps.google.com/mapfiles/marker_green.png"}
		}
		<?php //if( count(get_single_related_properties()) > 0 ){	?>
		<?php $i=1;if( $i==0 ){	?>
		,
				<?php foreach(get_single_related_properties() as $list) { ?>
						{
							latLng:[<?php echo $list->latitude;?>, <?php echo $list->longitude;?>],
							data:'<div style="width: 100%; min-height: 120px;">' +
										'<div style="width: 100%; overflow: hidden;">' +
											'<div class="row">' +
												'<div class="col-md-5 col-sm-12">' +
													'<img src="<?php echo $list->photo_url ? $list->displayPrimaryPhotoUrl() : PLUGIN_ASSET_URL . 'house.png';?>" style="width:150px;">' +
												'</div>'+
												'<div class="col-md-7 col-sm-12">' +
													'<h3 style="margin:0;padding:0;color:#428bca;">' +
														'<a style="color:#428bca;" href="<?php echo $list->displayUrl();?>" title="Click to view full listing"><?php echo ($list->displayAddress() != '') ? remove_nonaplha($list->displayAddress()):remove_nonaplha($list->tag_line);?></a>' +
													'</h3>' +
													'<h3 style="margin:0;padding:0;color:#d9534f;">' +
														'<?php echo $list->displayPrice();?> - <?php echo $list->displayTransaction();?>' +
													'</h3>' +
													'<div>' +
														'<span><?php echo $list->displayFloorArea();?> Floor Area</span></br>' +
														'<span><?php echo $list->beds;?> Bedrooms</span></br>' +
														'<span><?php echo $list->baths;?> Bathrooms</span></br>' +
														'<span><?php echo $list->garage;?> Garages</span>' +
													'</div>' +
													'<h3 style="margin:0;padding:0;"><a href="<?php echo $list->displayUrl();?>" title="Click to view full listing" class="btn btn-info btn-sm">View Full Details</a></h3>' +
												'</div>'+
											'</div>'+
										'</div>'+
							'</div>',
						},
				<?php } ?>
		<?php }	?>
	];
</script>

