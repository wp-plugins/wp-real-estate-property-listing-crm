<?php
/*
Template Name: Search Form - Default UI
*/
?>
<div class="search-form-ui md-container search-property">
	<h3 class="search-heading"><i class="fa fa-search"></i><?php echo _label('search-title');?></h3><div class="as-form-wrap">
	<form class="form-inline search_property" method="GET" id="advanced_search" name="search_property" action="<?php echo \Property_URL::get_instance()->get_search_page_default();?>"  role="form">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<input type="text" id="location" name="location" placeholder="Enter Location here" class="form-control typeahead" value="<?php echo $location ? $location:'';?>">
			</div>
		</div>
		<div class="row md-container">
			<div class="col-md-4 col-xs-12">
				<select id="min_listprice" name="min_listprice" class="form-control">
					<option value="0">
						<?php
							if( has_action('min_price_val') ){
								do_action('min_price_val');
							}else{
								echo 'Min Price - Any';
							}
						?>
					</option>
					<?php if( count(get_search_form_price_range()) > 0 ){ ?>
							<?php foreach(get_search_form_price_range() as $key=>$val) { ?>
									<option value="<?php echo $val;?>" <?php echo ($min_listprice == $val) ? "selected":""; ?>><?php echo $currency.number_format($val);?></option>
							<?php } ?>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4 col-xs-12">
				<select id="max_listprice" name="max_listprice" class="form-control">
					<option value="0">
						<?php
							if( has_action('max_price_val') ){
								do_action('max_price_val');
							}else{
								echo 'Max Price - Any';
							}
						?>
					</option>
					<?php if( count(get_search_form_price_range()) > 0 ){ ?>
							<?php foreach(get_search_form_price_range() as $key=>$val) { ?>
									<option value="<?php echo $val;?>" <?php echo ($max_listprice == $val) ? "selected":""; ?>><?php echo $currency.number_format($val);?></option>
							<?php } ?>
					<?php } ?>

					<?php
						if( has_filter('max_price_val_plus') ){
							$max_price_val_plus = '';
							$max_price_val_plus = apply_filters('max_price_val_plus',$max_price_val_plus);
							echo '<option value="'.$max_price_val_plus.'">';
								echo $currency.number_format($max_price_val_plus).'+';
							echo '</option>';
						}else{
							echo '<option value="100000000">';
							echo $currency.'100,000,000+';
							echo '</option>';
						}
					?>

				</select>
			</div>
			<?php if( !has_filter('show_button_property_type_'.DEFAULT_FEED) ){ ?>
			<div class="col-md-4 col-xs-12">
				<select name="property_type" id="property_type" class="form-control">
					<option value="0">Type - All</option>
					<?php foreach($fields_type as $key=>$val){ ?>
							<option value="<?php echo $key;?>" <?php echo ($property_type == $key) ? "selected":""; ?>><?php echo $val;?></option>
					<?php } ?>
				</select>
			</div>
			<?php } ?>
		</div>
		<div class="row md-container">
			<div class="col-md-4 col-xs-12">
				<select id="bedrooms" name="bedrooms" class="form-control">
					<option value="0">Bedroom, Any</option>
					<?php foreach (range(1, 5) as $number){ ?>
						<option value="<?php echo $number;?>" <?php echo ($bedrooms == $number) ? "selected":"";?>><?php echo $number;?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4 col-xs-12">
				<select id="bathrooms" name="bathrooms" class="form-control">
					<option value="0">Bathroom, Any</option>
					<?php foreach (range(1, 5) as $number){ ?>
						<option value="<?php echo $number;?>" <?php echo ($bathrooms == $number) ? "selected":"";?>><?php echo $number;?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div style="height: 10px;"></div>
		<input type="hidden" name="transaction" value="" id="transaction">
		<input type="hidden" name="lat" value="<?php echo $lat ? $lat:'';?>" id="lat_front">
		<input type="hidden" name="lon" value="<?php echo $lon ? $lon:'';?>" id="lon_front">
		<input type="hidden" name="communityid" value="<?php echo $communityid ? $communityid:'';?>" id="communityid">
		<input type="hidden" name="cityid" value="<?php echo $cityid ? $cityid:'';?>" id="cityid">
		<input type="hidden" name="countyid" value="<?php echo $countyid ? $countyid:'';?>" id="countyid">
		<input type="hidden" name="subdivisionid" value="<?php echo $subdivisionid ? $subdivisionid:'';?>" id="subdivisionid">
		<?php if( $show_button_for_sale ){ ?>
		<button type="submit" class="search-form-btn btn btn-default wp-site-color-theme" value="For Sale">
			<?php echo $button_for_sale;?>
		</button>
		<?php } ?>
		<?php if( $show_button_for_rent ){ ?>
		<button type="submit" class="search-form-btn btn btn-default wp-site-color-theme" value="For Rent">
			<?php echo $button_for_rent;?>
		</button>
		<?php } ?>
	</form>
</div>
<script>
	var location_autocomplete = <?php echo \md_sc_search_form::get_instance()->get_autocomplete_location('json'); ?>;
</script>
