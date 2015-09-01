<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div id="carousel-property-details" class="carousel slide">
		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
			<?php if(count(get_md_property_img()) > 0 ){ ?>
				<?php $i = 0; ?>
				<?php foreach( get_md_property_img() as $photo ){ ?>
					<div class="item <?php echo ($i==0) ? 'active':'';?>">
						<img src="<?php echo $photo;?>" >
					</div>
					<?php $i++; ?>
				<?php } ?>
			<?php } ?>
		  </div>
		  <!-- Controls -->
		  <a class="left carousel-control" href="#carousel-property-details" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#carousel-property-details" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		  </a>
		  <div class="property-details-info">
			<div class="caption">
				<span class="price">
					<?php
						if( md_property_raw_price() == 0 ){
							echo md_property_html_price();
						}else{
							echo md_property_format_price();
						}
					?>
				</span><br>
				<span class="url-title">
					<a href="<?php echo md_property_url();?>" class="<?php //echo get_model_register_class();?>" target="<?php echo open_property_in();?>">
						<?php echo md_property_address('tiny');?>
					</a>
				</span><br>
				<span class="basic-info">
					<?php if(!has_filter('list_display_area_'.md_get_source())){ ?>
						<span>
							<strong>
								<?php echo apply_filters('property_area_'.md_get_source(), get_property_area());?>
								&nbsp;
							</strong>
							<?php do_action( 'list_before_area' ); ?>
							<?php echo apply_filters('property_area_unit_'.md_get_source(), get_property_area_unit());?>
						</span> |
					<?php } ?>
					<?php if(!has_filter('list_display_bed_'.md_get_source())){ ?>
						<span><strong><?php echo md_property_beds();?></strong>&nbsp;<?php echo _label('beds');?></span> |
					<?php } ?>
					<?php if(!has_filter('list_display_baths_'.md_get_source())){ ?>
						<span><strong><?php echo md_property_bathrooms();?></strong>&nbsp;<?php echo _label('baths');?></span> |
					<?php } ?>
				</span>
			</div>
		  </div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6">
		<div class="property-details-desc">
			<?php echo trim(strtolower(strip_tags( \helpers\Text::limit_words(md_get_description(),20) )));  ?>
			<a class="more-info" href="<?php echo md_property_url();?>">More</a>
			<div class="property-details-action-buttons">
				<?php
					$args_button_action = array(
						'favorite'	=> array(
							'show'	=> 1,
							'feed' 	=> md_get_source(),
							'property_id' => md_property_id(),
							'bootstrap_btn_class' => 'primary',
						),
						'xout'	=> array(
							'show'	=> 1,
							'feed' => md_get_source(),
							'property_id' => md_property_id(),
							'bootstrap_btn_class' => 'primary',
						),
						'print' => array(
							'show' => 1,
							'url' => get_option('siteurl') . '/printpdf/'.md_property_id(),
							'bootstrap_btn_class' => 'primary',
						),
						'share'	=> array(
							'show'=>0,
						),
					);
					\Action_Buttons::get_instance()->display($args_button_action);
				?>
			</div>
		</div>
	</div>
</div>
