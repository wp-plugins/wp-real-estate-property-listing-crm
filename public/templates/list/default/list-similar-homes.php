<?php
/*
Template Name: List - Box Style
*/
?>
<?php if( have_properties() ){ //if have_properties() start ?>
<?php
	if( !is_front_page() && $show_sort ){
		\Action_Buttons::display_sort_button(array('class'=>'list-default'));
	}

	$single_property = false;
	$single_property_id = 0;
	$count_properties = 0;
	if( get_single_property_data() ){
		$single_property = true;
		$single_property_id = get_single_property_data()->getID();
	}
?>
<div class="row" id="search-result-container">
	<div class="search-result item-container">
		<?php foreach(have_properties() as $property ){ //loop start have_properties() ?>
				<?php set_loop($property); ?>
				<?php if( $single_property_id != md_property_id() ) { // do not display same id ?>
				  <div class="col-xs-12 col-md-12 property-item property-id-<?php echo md_property_id();?> <?php echo md_get_source();?>">
					<div class="thumbnail masterdigm-property-box">
						<a href="<?php echo md_property_url();?>" class="propertyphoto">
							<img class="img-responsive" src="<?php echo md_property_img(md_property_id()); ?>" style="<?php !md_property_has_img() ? 'width:170px;height:180px;':''; ?>" alt="Property List Image">
						</a>
						<span class="label label-primary primary-background wp-site-color-theme label-property"><?php echo md_property_transaction();?></span>
						<div class="caption">
							<h3 class="property-name">
								<a href="<?php echo md_property_url();?>" class="<?php //echo get_model_register_class();?>">
									<?php echo md_property_title();?>
								</a>
							</h3>
							<div class="property-amenities">
								<?php if(!has_filter('list_display_area_'.md_get_source())){ ?>
									<span>
										<strong>
											<?php echo apply_filters('property_area_'.md_get_source(), get_property_area());?>
											&nbsp;
										</strong>
										<?php do_action( 'list_before_area' ); ?>
										<?php echo apply_filters('property_area_unit_'.md_get_source(), get_property_area_unit());?>
									</span>
								<?php } ?>
								<?php if(!has_filter('list_display_bed_'.md_get_source())){ ?>
									<span><strong><?php echo md_property_beds();?>&nbsp;</strong><?php echo _label('beds');?></span>
								<?php } ?>
								<?php if(!has_filter('list_display_baths_'.md_get_source())){ ?>
									<span><strong><?php echo md_property_bathrooms();?>&nbsp;</strong><?php echo _label('baths');?></span>
								<?php } ?>
								<?php if(!has_filter('list_display_garage_'.md_get_source())){ ?>
									<span><strong><?php echo md_property_garage();?>&nbsp;</strong><?php echo _label('garage');?></span>
								<?php } ?>
							</div>
							<h2 class="price center-block wp-site-color-theme">
								<?php
									if( md_property_raw_price() == 0 ){
										echo md_property_html_price();
									}else{
										echo md_property_format_price();
									}
								?>
							</h2>
						</div>
						<div class="panel-footer">
							<?php
								$args_button_action = array(
									'favorite'	=> array(
										'feed' => md_get_source(),
										'property_id' => md_property_id(),
									),
									'xout'	=> array(
										'feed' => md_get_source(),
										'property_id' => md_property_id(),
									),
									'print' => array(
										'show' => 1,
										'url' => get_option('siteurl') . '/printpdf/'.md_property_id(),
									),
									'share'	=> array(
										'property_id' => md_property_id(),
										'feed' => md_get_source(),
										'url' => md_property_url(),
										'address' => md_property_title()
									),
								);
								\Action_Buttons::get_instance()->display($args_button_action);
							?>
						</div>
					</div>
				  </div>
				  <?php $count_properties++;?>
			  <?php } // do not display same id ?>
		<?php }//loop end have_properties() ?>
	</div>
</div>
<?php if($count_properties >0){ ?>
<a href="<?php echo $more_similar_homes_link; ?>">More Similar Homes</a>
<?php } ?>
<?php }else{ ?>
	<?php
		if(has_action('list_no_property_found')){
			do_action('list_no_property_found');
		}else{
	?>
		<h3>No Properties Found</h3>
	<?php } ?>
<?php }//if have_properties() end ?>
