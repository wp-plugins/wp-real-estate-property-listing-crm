<?php
/*
Template Name: Search Result - Default Property page
*/
?>
<?php if( have_properties() ){ ?>
	<?php \Action_Buttons::display_sort_button(); ?>
	<div class="row" id="search-result-container">
		<div class="search-result item-container">
			<?php foreach(have_properties() as $property ){ ?>
			 <?php set_loop($property); ?>
			  <div class="col-xs-12 col-md-<?php echo $col;?> property-item property-id-<?php echo md_property_id();?> <?php echo md_get_source();?>">
				<div class="thumbnail masterdigm-property-box">
					<a href="<?php echo md_property_url();?>" class="propertyphoto">
						<img class="img-responsive" src="<?php echo md_property_img(); ?>" style="<?php !md_property_has_img() ? 'width:170px;height:180px;':''; ?>" alt="Property List Image">
					</a>
					<span class="label label-primary primary-background wp-site-color-theme label-property"><?php echo md_property_transaction();?></span>
					<div class="caption">
						<h3 class="property-name">
							<a href="<?php echo md_property_url();?>" class="<?php //echo get_model_register_class();?>">
								<?php echo md_property_title();?>
							</a>
						</h3>
						<div class="property-amenities">
							<span><strong><?php echo md_property_area();?>&nbsp;</strong><?php echo md_property_area_unit();?></span>
							<span><strong><?php echo md_property_beds();?>&nbsp;</strong>Bed</span>
							<span><strong><?php echo md_property_bathrooms();?>&nbsp;</strong>Bath</span>
							<span><strong><?php echo md_property_garage();?>&nbsp;</strong>Garage</span>
						</div>
						<h2 class="price center-block wp-site-color-theme"><?php echo md_property_price();?></h2>
					</div>
					<div class="panel-footer">
						<?php
							$args_button_action = array(
								'favorite'	=> array(
									'feed' => 'crm',
									'property_id' => md_property_id(),
								),
								'xout'	=> array(
									'feed' => 'crm',
									'property_id' => md_property_id(),
								),
								'print' => array(
									'show' => 1,
									'url' => get_option('siteurl') . '/printpdf/'.md_property_id(),
								),
								'share'	=> array(
									'property_id' => md_property_id(),
									'feed' => 'crm',
									'url' => md_property_url(),
									'address' => md_property_title()
								),
							);
							\Action_Buttons::get_instance()->display($args_button_action);
						?>
					</div>
				</div>
			  </div>
			<?php } ?>
		</div><!-- search-result -->
	</div><!-- row -->
	<?php if( have_properties() ){ ?>
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
			'col'=>$col,
		);
		\MD_Search_Utility::get_instance()->js_var_search_data($properties, $atts, null, $options);
	?>
<?php }else{ ?>
	<h3>No Properties Found</h3>
<?php } ?>
