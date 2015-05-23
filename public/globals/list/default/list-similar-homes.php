<?php
/*
Template Name: List - Box Style
*/
?>
<?php
if( have_properties() ){ //if have_properties() start
?>
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
				<div class="prop-contain">
					<div class="row">
						<div class="col-md-4">
							<a href="<?php echo md_property_url();?>" class="propertyphoto">
								<img class="img-responsive" src="<?php echo md_property_img(md_property_id()); ?>" style="<?php !md_property_has_img() ? 'width:170px;height:180px;':''; ?>" alt="Property List Image">
							</a>
							<p class="price"><?php echo md_property_price();?></p>
						</div>
						<div class="col-md-8">
							<h3>
								<a href="<?php echo md_property_url();?>" class="<?php //echo get_model_register_class();?>">
									<?php echo md_property_title();?>
								</a>
							</h3>
							<?php if(!has_filter('list_display_area_'.md_get_source())){ ?>
								<p><?php echo md_property_area();?>&nbsp;<?php do_action( 'list_before_area' ); ?><?php echo md_property_area_unit();?></p>
							<?php } ?>
							<?php if(!has_filter('list_display_bed_'.md_get_source())){ ?>
								<p><?php echo md_property_beds();?>&nbsp;<?php echo _label('beds');?></p>
							<?php } ?>
							<?php if(!has_filter('list_display_baths_'.md_get_source())){ ?>
								<p><?php echo md_property_bathrooms();?>&nbsp;<?php echo _label('baths');?></p>
							<?php } ?>
							<?php if(!has_filter('list_display_garage_'.md_get_source())){ ?>
								<p><?php echo md_property_garage();?>&nbsp;<?php echo _label('garage');?></p>
							<?php } ?>
							<div class="smbut">
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
				</div>
			  <?php } // do not display same id ?>

		<?php }//loop end have_properties() ?>
	</div>
</div>
<a href="<?php echo $more_similar_homes_link; ?>">More Similar Homes</a>
<?php }else{ ?>
	<?php
		if(has_action('list_no_property_found')){
			do_action('list_no_property_found');
		}else{
	?>

	<?php } ?>
<?php }//if have_properties() end ?>
