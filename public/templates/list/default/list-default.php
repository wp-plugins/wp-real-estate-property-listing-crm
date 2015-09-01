<?php
/*
Template Name: List - Box Style
*/
?>
<?php if( have_properties() ){ //if have_properties() start ?>
	<?php
		$single_property = false;
		$single_property_id = 0;
		if( get_single_property_data() ){
			$single_property = true;
			$single_property_id = get_single_property_data()->id;
		}
	?>
	<?php $max = ceil( intval( get_ret_properties()->total ) / (isset($atts['limit']) ? $atts['limit']:get_search_limit()));?>
	<?php show_search_result_tools($atts, $show_sort); ?>
	<div class="row" id="search-result-container">
		<div class="search-result<?php echo ( isset($atts['infinite']) && $atts['infinite'] != 1 ) ? '-not-infinite':'';?> item-container">
			<?php if( !is_front_page() && ($max > 1) ){ ?>
				<div class="md-pagination">
					<?php md_pagination('', 2, get_ret_properties()->total); ?>
				</div>
			<?php } ?>
			<?php foreach(have_properties() as $property ){ //loop start have_properties() ?>
					<?php set_loop($property); ?>
					<?php if($single_property_id != md_property_id()) { // do not display same id ?>
						<?php
							$list_part = \MD_Template::get_instance()->load_template('list/default/part-photo-list.php');
							require $list_part;
						?>
					<?php } // do not display same id ?>
			<?php }//loop end have_properties() ?>
		</div>
	</div>
	<?php if( !is_front_page() && ($max > 1) ){ ?>
		<div class="md-pagination">
			<?php md_pagination('', 2, get_ret_properties()->total); ?>
		</div>
		<?php if( count(have_properties()) > 0 && $atts['infinite'] ){ ?>
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
	<?php }//end is_front_page() ?>
<?php }else{ ?>
	<?php
		if(has_action('list_no_property_found')){
			do_action('list_no_property_found');
		}else{
	?>
		<h3>No Properties Found</h3>
	<?php } ?>
<?php }//if have_properties() end ?>
