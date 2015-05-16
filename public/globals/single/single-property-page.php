<?php
/*
Template Name: Single - Details of property
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php if( get_single_data() && is_property_viewable(md_get_property_status()) ){ ?>
<?php if( function_exists('crm_masterdigm_breadcrumb' ) ){ /*crm_masterdigm_breadcrumb();*/ } ?>
<?php next_prev(); ?>
<div class="single-property-container <?php echo md_property_id();?> crm-single-property" id="<?php echo 'property-id-'.md_property_id();?>">
	<div role="tabpanel">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs <?php do_action('single_nav_tab');?> <?php do_action('single_nav_tab_'.get_single_property_source());?>" role="tablist">
		<li role="presentation" class="active"><a href="#property-details" aria-controls="property-details" role="tab" data-toggle="tab"><?php echo _label('property-details');?></a></li>
		<li role="presentation"><a href="#map-directions" aria-controls="map-directions" role="tab" data-toggle="tab"><?php echo _label('map-and-directions');?></a></li>
		<li role="presentation"><a href="#walkscore" aria-controls="walkscore" role="tab" data-toggle="tab"><?php echo _label('walk-score');?></a></li>
		<li role="presentation"><a href="#photos" aria-controls="photos" role="tab" data-toggle="tab"><?php echo _label('single-photos');?></a></li>
		<?php //if( get_single_property_data()->displayParams('videos') ){ ?>
			<!--<li role="presentation"><a href="#video" role="tab" data-toggle="tab"><?php //echo _label('video');?></a></li>-->
		<?php //} ?>
	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content <?php do_action('tab_content');?> <?php do_action('tab_content_'.get_single_property_source());?>">
		<div role="tabpanel" class="tab-pane active" id="property-details">
			<ul class="list-inline single-property-quick-info <?php do_action('quick_info');?> <?php do_action('quick_info_'.get_single_property_source());?>">
				<li class="price">
					<span><?php echo _label('price');?></span>
					<p><?php echo md_property_price();?></p>
				</li>
				<?php if(!has_filter('list_display_baths')){ ?>
					<li class="baths">
						<span><?php echo _label('baths');?></span>
						<p><?php echo md_property_bathrooms();?></p>
					</li>
				<?php } ?>
				<?php if(!has_filter('list_display_bed')){ ?>
					<li class="beds">
						<span><?php echo _label('beds');?></span>
						<p><?php echo md_property_beds();?></p>
					</li>
				<?php } ?>
				<?php if(!has_filter('list_display_area')){ ?>
					<li class="area-measurement">
						<span>
							<?php do_action( 'single_before_area_measurement' ); ?>
							<?php echo ucwords(get_single_property_data()->displayAreaMeasurement('floor')->area_type);?>
						</span>
						<p><?php echo md_property_area();?></p>
					</li>
				<?php } ?>
				<li class="yr-built">
					<span><?php echo _label('year-built');?></span>
					<p><?php echo md_property_yr_built();?></p>
				</li>
				<?php if(!has_filter('list_display_mls')){ ?>
				<li class="mls">
					<span><?php echo _label('mls');?></span>
					<p><?php echo md_get_mls();?></p>
				</li>
				<?php } ?>
			</ul>

			<div class="row">
				<div class="col-md-9 col-sm-12">
					<div class="single-property-carousel md-container">
						<?php
							if( has_filter('template_carousel_'.get_single_property_source()) ){
								apply_filters('template_carousel_'.get_single_property_source(), $atts);
							}else{
								//display default - crm
								md_global_carousel_template($atts);
							}
						?>
					</div>
					<?php
						do_action('before_more_details_'.get_single_property_source());
						do_action('template_more_details_'.get_single_property_source(), $atts);
						do_action('after_more_details_'.get_single_property_source());
					?>
				</div>
				<div class="col-md-3 col-sm-12">
					<div class="right-sidebar">
						<?php
							if( has_action('before_right_sidebar_content') ){
								do_action( 'before_right_sidebar_content' );
							}
						?>

						<div class="panel panel-default">
						  <div class="panel-body">
						   <?php \Action_Buttons::get_instance()->display($args_button_action); ?>
						  </div>
						</div>

						<?php
							\md_sc_single_properties::get_instance()->display_inquire_form($att_inquire_msg);
						?>

						<?php \MD_Property_Content::get_instance()->displayTagContent(get_single_property_data()); ?>

						<?php
							if( has_action('after_right_sidebar_content') ){
								do_action( 'after_right_sidebar_content' );
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="map-directions">
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
		</div>
		<div role="tabpanel" class="tab-pane" id="walkscore">
			<div class="single-property-walkscore">
				<?php
					if( has_filter('template_walkscore_'.get_single_property_source()) ){
						apply_filters('template_walkscore_'.get_single_property_source(), $atts);
					}else{
						display_walkscore_single($atts);
					}
				?>
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
		<?php //if( get_single_property_data()->displayParams('videos') ){ ?>
		  <!--<div role="tabpanel" class="tab-pane" id="video">-->
				<!--<div class="single-property-videos md-container">-->
					<?php
					/*if( has_filter('template_videos_'.get_single_property_source()) ){
						apply_filters('template_videos_'.get_single_property_source(), $atts);
					}else{
						require GLOBAL_TEMPLATE . 'partials/single-property-video.php';
					}*/
					?>
				<!--</div>-->
		  <!--</div>-->
		<?php //} ?>
	  </div>

	</div>
</div>
<script type="text/javascript">
	var mainLat = '<?php echo md_get_lat();?>';
	var mainLng = '<?php echo md_get_lon();?>';
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
