<?php
/*
Template Name: List - Box Style
*/

?>
<?php if( have_properties() ){ //if have_properties() start ?>
<?php $index_items = 1; ?>
<?php
	if( !is_front_page() && $show_sort ){
		\Action_Buttons::display_sort_button(array('class'=>'list-default'));
	}

	$single_property = false;
	$single_property_id = 0;
	if( get_single_property_data() ){
		$single_property = true;
		$single_property_id = get_single_property_data()->id;
	}
?>
<div class="row" id="search-result-container">
	<div class="search-result item-container">
		<?php foreach(have_properties() as $property ){ //loop start have_properties() ?>
			<?php set_loop($property); ?>
			<?php if( $single_property_id != md_property_id() ) { // do not display same id ?>
			  <div class="col-xs-12 col-md-<?php echo $col;?> property-item property-id-<?php echo md_property_id();?> <?php echo md_get_source();?>">
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
							<?php if(!has_filter('list_display_area')){ ?>
								<span><strong><?php echo md_property_area();?>&nbsp;</strong><?php do_action( 'list_before_area' ); ?><?php echo md_property_area_unit();?></span>
							<?php } ?>
							<?php if(!has_filter('list_display_bed')){ ?>
								<span><strong><?php echo md_property_beds();?>&nbsp;</strong><?php echo _label('beds');?></span>
							<?php } ?>
							<?php if(!has_filter('list_display_baths')){ ?>
								<span><strong><?php echo md_property_bathrooms();?>&nbsp;</strong><?php echo _label('baths');?></span>
							<?php } ?>
							<?php if(!has_filter('list_display_garage')){ ?>
								<span><strong><?php echo md_property_garage();?>&nbsp;</strong><?php echo _label('garage');?></span>
							<?php } ?>
						</div>
						<h2 class="price center-block wp-site-color-theme"><?php echo md_property_price();?></h2>
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
		  <?php } // do not display same id ?>
		<?php }//loop end have_properties() ?>
	</div>
</div>
<?php if( have_properties() > 0 && $atts['infinite'] ){ ?>
	<div class="ajax-indicator text-center">
	  <img src="<?php echo PLUGIN_ASSET_URL . 'ajax-loader-big-circle.gif';?>" class="" id="loading-indicator" style='' />
	</div>
<?php }else{ ?>
		<input type="hidden" name="nomoredata" id="nomoredata" value="0">
<?php } ?>
<?php
	$options = array(
		'selector'=>'#search-result-container',
		'ajax_display'=>'search-result',
		'col'=>$atts['col'],
	);

	if( !isset($search_data) ){
		$search_data = null;
	}

	\MD_Search_Utility::get_instance()->js_var_search_data($properties, $atts, $search_data, $options);
?>
<?php }else{ ?>
	<?php
		if(has_action('list_no_property_found')){
			do_action('list_no_property_found');
		}else{
	?>
		<h3>No Properties Found</h3>
	<?php } ?>
<?php }//if have_properties() end ?>
