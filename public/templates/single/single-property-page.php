<?php
/*
Template Name: Single - Details of property
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php if( get_single_data() && is_property_viewable(md_get_property_status()) ){ ?>
<?php if( function_exists('crm_masterdigm_breadcrumb' ) ){ crm_masterdigm_breadcrumb(); } ?>
<div class="single-property-container <?php echo md_property_id();?> crm-single-property <?php echo 'property-id-'.md_property_id();?>" id="md-proppage">
	<div role="tabpanel">
	  <!-- Nav tabs -->
	  <div class="row">
		  <div id="md-proppage-tab" class="col-md-8">
			  <ul class="nav nav-tabs <?php do_action('single_nav_tab');?> <?php do_action('single_nav_tab_'.get_single_property_source());?>" role="tablist">
				<li role="presentation" class="active"><a href="#property-details" aria-controls="property-details" role="tab" data-toggle="tab"><?php echo _label('property-details');?></a></li>
				<li role="presentation"><a href="#map-directions" aria-controls="map-directions" role="tab" data-toggle="tab"><?php echo _label('map-and-directions');?></a></li>
				<li role="presentation"><a href="#walkscore" aria-controls="walkscore" role="tab" data-toggle="tab"><?php echo _label('walk-score');?></a></li>
				<li role="presentation"><a href="#photos" aria-controls="photos" role="tab" data-toggle="tab"><?php echo _label('single-photos');?></a></li>
				<?php if( md_get_video() ){ ?>
					<li role="presentation"><a href="#video" role="tab" data-toggle="tab"><?php echo _label('video');?></a></li>
				<?php } ?>
			  </ul>
		  </div>
		  <div id="md-proppage-pagi" class="col-md-4">
			<?php next_prev(); ?>
		  </div>
	  </div>
	  <!-- Tab panes -->
	  <div class="tab-content <?php do_action('tab_content');?> <?php do_action('tab_content_'.get_single_property_source());?>">
		<div role="tabpanel" class="tab-pane active" id="property-details">
			<ul class="list-inline single-property-quick-info <?php do_action('quick_info');?> <?php do_action('quick_info_'.get_single_property_source());?>">
				<li class="price">
					<?php echo md_property_html_price();?>
				</li>
				<?php if(!has_filter('list_display_bed')){ ?>
					<?php if( md_property_beds() > 0 || md_property_beds() != '' ){ ?>
					<li class="beds">
						<?php echo md_property_beds();?>
						<span><?php echo _label('beds');?></span>
					</li>
					<?php } ?>
				<?php } ?>
				<?php if(!has_filter('list_display_baths')){ ?>
					<?php if( md_property_bathrooms() > 0 || md_property_bathrooms() != '' ){ ?>
						<li class="baths">
							<?php echo md_property_bathrooms();?>
							<span><?php echo _label('baths');?></span>
						</li>
					<?php } ?>
				<?php } ?>

				<?php if(!has_filter('list_display_area')){ ?>
					<li class="area-measurement">
						<?php
							if( has_action('single_area_measurement_'.md_get_source()) ){
								do_action('single_area_measurement_'.md_get_source());
							}else{
								echo get_single_property_data()->displayAreaMeasurement('')->measure;
							}
						?>
						<span>
							<?php do_action( 'single_before_area_measurement' ); ?>
							<?php
								if( has_action('single_area_measurement_unit_'.md_get_source()) ){
									do_action('single_area_measurement_unit_'.md_get_source());
								}else{
									$unit = get_single_property_data()->displayAreaMeasurement('')->area_type;
									echo ($unit!='') ? ucwords($unit):'&nbsp;';
								}
							?>
						</span>
					</li>
				<?php } ?>
				<li class="yr-built">
					<?php
						if( has_filter('year_built_'.md_get_source()) ){
							apply_filters('year_built_'.md_get_source(), md_property_yr_built());
						}else{
							echo md_property_yr_built();
							?><span><?php echo _label('year-built');?></span><?php
						}
					?>
				</li>
				<?php if(!has_filter('list_display_mls')){ ?>
				<li class="mls">
					<?php echo md_get_mls();?>
					<span><?php echo _label('mls');?></span>
				</li>
				<?php } ?>
			</ul>

			<div class="row" id="md-proppage-left">
				<div class="col-md-9 col-sm-12">
					<div class="left-content">
						<?php  display_property_details_left_content($atts); ?>
					</div>
					<div class="mini-map">
                    	<h2><span>Map on <?php echo md_property_address('short');?></span></h2>
                       <div class="quick_map_view" style="height:450px;"></div>
                    </div>
				</div>
				<div class="col-md-3 col-sm-12">
					<div class="right-sidebar" id="md-proppage-right">
						<?php
							$additional_atts = array(
								'args_button_action' => $args_button_action,
								'att_inquire_msg' => $att_inquire_msg
							);
							display_property_details_right_content($atts, $additional_atts);
						?>
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="map-directions">
			<div class="col-md-9 col-sm-12" id="md-proppage-left">
				<div class="single-property-map md-container">
					<?php do_action( 'before_map_load' ); ?>
					<?php
						if( has_filter('template_map_'.get_single_property_source()) ){
							apply_filters('template_map_'.get_single_property_source(), $atts);
						}else{
							display_map_single($atts);
						}
					?>
					<?php do_action( 'after_map_load' ); ?>
				</div>
				<?php  display_property_details_left_content($atts); ?>
			</div>
			<div class="col-md-3 col-sm-12">
				<div class="right-sidebar" id="md-proppage-right">
						<?php
							$additional_atts = array(
								'args_button_action' => $args_button_action,
								'att_inquire_msg' => $att_inquire_msg
							);
							display_property_details_right_content($atts, $additional_atts);
						?>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="walkscore">
			<div class="col-md-9 col-sm-12" id="md-proppage-left">
				<div class="single-property-walkscore">
					<?php
						if( has_filter('template_walkscore_'.get_single_property_source()) ){
							apply_filters('template_walkscore_'.get_single_property_source(), $atts);
						}else{
							display_walkscore_single($atts);
						}
					?>
				</div>
				<?php  display_property_details_left_content($atts); ?>
			</div>
			<div class="col-md-3 col-sm-12">
				<div class="right-sidebar" id="md-proppage-right">
					<?php display_property_details_right_content($atts, $additional_atts); ?>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="photos">
			<div class="single-property-photos md-container">
				<?php
					if( has_filter('template_photos_'.get_single_property_source()) ){
						apply_filters('template_photos_'.get_single_property_source(), $atts);
					}else{
						display_photos_single($atts);
					}
				?>
			</div>
		</div>
		<?php if( md_get_video() ){ ?>
		  <div role="tabpanel" class="tab-pane" id="video">
				<div class="col-md-9 col-sm-12">
					<div class="single-property-videos md-container">
						<?php
						if( has_filter('template_videos_'.get_single_property_source()) ){
							apply_filters('template_videos_'.get_single_property_source(), $atts);
						}else{
							md_display_video();
						}
						?>
					</div>
					<div class="left-content">
						<?php  display_property_details_left_content($atts); ?>
					</div>
				</div>
				<div class="col-md-3 col-sm-12">
					<div class="right-sidebar" id="md-proppage-right">
						<?php
							$additional_atts = array(
								'args_button_action' => $args_button_action,
								'att_inquire_msg' => $att_inquire_msg
							);
							display_property_details_right_content($atts, $additional_atts);
						?>
					</div>
				</div>
		  </div>
		<?php } ?>
	  </div>

	</div>
</div>
<script type="text/javascript">
	var mainLat = '<?php echo get_single_property_data()->getLattitude();?>';
	var mainLng = '<?php echo get_single_property_data()->getLongitude();?>';
	var mainAddress = '<?php echo remove_nonaplha(get_single_property_data()->displayAddress('long'));?>';
</script>
<?php
	}else{
		if( has_action('no_property_content') ){
			do_action( 'no_property_content' );
		}else{
			echo '<h2>This property is currently not active</h2>';
		}
	}
?>
