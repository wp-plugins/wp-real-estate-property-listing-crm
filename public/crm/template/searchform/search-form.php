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
				<input type="text" id="location" name="location" placeholder="Enter Location here" class="form-control typeahead" value="<?php echo $location?$location:'';?>">
			</div>
		</div>
		<div class="row md-container">
			<div class="col-md-4 col-xs-12">
				<select id="min_listprice" name="min_listprice" class="form-control">
					<option value="0">Min Price</option>
					<?php if( count(get_search_form_price_range()) > 0 ){ ?>
							<?php foreach(get_search_form_price_range() as $key=>$val) { ?>
									<option value="<?php echo $val;?>" <?php echo ($min_listprice == $val) ? "selected":""; ?>><?php echo $currency.number_format($val);?></option>
							<?php } ?>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4 col-xs-12">
				<select id="max_listprice" name="max_listprice" class="form-control">
					<option value="0">Max Price</option>
					<?php if( count(get_search_form_price_range()) > 0 ){ ?>
							<?php foreach(get_search_form_price_range() as $key=>$val) { ?>
									<option value="<?php echo $val;?>" <?php echo ($max_listprice == $val) ? "selected":""; ?>><?php echo $currency.number_format($val);?></option>
							<?php } ?>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-4 col-xs-12">
				<select name="property_type" id="property_type" class="form-control">
					<option value="0">Type - All</option>
					<?php foreach($fields_type as $key=>$val){ ?>
							<option value="<?php echo $key;?>" <?php echo ($property_type == $key) ? "selected":""; ?>><?php echo $val;?></option>
					<?php } ?>
				</select>
			</div>
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
		<input type="hidden" name="transaction" value="" id="transaction">
		<input type="hidden" name="lat" value="<?php echo $lat ? $lat:'';?>" id="lat_front">
		<input type="hidden" name="lon" value="<?php echo $lon ? $lon:'';?>" id="lon_front">
		<input type="hidden" name="communityid" value="<?php echo $_REQUEST['communityid'] ? $_REQUEST['communityid']:0;?>" id="communityid">
		<input type="hidden" name="cityid" value="<?php echo $_REQUEST['cityid'] ? $_REQUEST['cityid']:0;?>" id="cityid">
		<button type="submit" class="btn btn-default wp-site-color-theme" value="For Sale">For Sale</button>
		<button type="submit" class="btn btn-default wp-site-color-theme" value="For Rent">For Rent</button>
	</form>
</div>
<script>
	var location_autocomplete = <?php echo \md_sc_search_form::get_instance()->get_autocomplete_location('json'); ?>;
</script>
