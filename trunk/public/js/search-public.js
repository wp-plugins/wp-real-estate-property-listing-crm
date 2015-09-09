(function( $ ) {
	'use strict';

	function get_geo_code(address){
		var searchAddress = address;
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode(
			{address: searchAddress},
			function(result,status) {
				console.log(status);
				if (status == google.maps.GeocoderStatus.OK ){
					var lat = result[0].geometry.location.lat();
					var lng = result[0].geometry.location.lng();

					jQuery('#lat_front').val(lat);
					jQuery('#lon_front').val(lng);
				}
			}
		);
	}

	/**
	module for search property change max and min price, depends on transaction
	**/
	var searchPropertyTransactionChange = function () {

		// use to get the url transaction parameter
		var urlParam = function(sParam) {
			var sPageURL = window.location.search.substring(1);
			var sURLVariables = sPageURL.split('&');

			for (var i = 0; i < sURLVariables.length; i++)
			{
				var sParameterName = sURLVariables[i].split('=');
				if (sParameterName[0] == sParam)
				{
					return sParameterName[1];
				}
			}
		}

		function updateMaxMinPrice( transaction ){
			// max price
			var selectMaxListPriceContainer = jQuery('#max_listprice');
			var selectMaxListPriceRent = jQuery('#max_listprice_rent');
			var selectMaxListPriceSale = jQuery('#max_listprice_sale');

			// min price
			var selectMinListPriceContainer = jQuery('#min_listprice');
			var selectMinListPriceRent = jQuery('#min_listprice_rent');
			var selectMinListPriceSale = jQuery('#min_listprice_sale');

			switch( transaction ){
				case 'for rent':
					selectMaxListPriceContainer.html( selectMaxListPriceRent.html() )
					selectMinListPriceContainer.html( selectMinListPriceRent.html() )
				break;
				case 'for sale':
					selectMaxListPriceContainer.html( selectMaxListPriceSale.html() )
					selectMinListPriceContainer.html( selectMinListPriceSale.html() )
				break;
				default:
				break;
			}
		}

		return {

			//main function
			init: function () {
				var transactionDropDown = jQuery('#transaction');
				var transaction = urlParam('transaction') ? urlParam('transaction').toLowerCase() : '';

				updateMaxMinPrice(transaction);

				jQuery('body').on('change', '#transaction', function(){
					var transaction = transactionDropDown.val();
					updateMaxMinPrice(transaction.toLowerCase());
				});
			}

		};

	}();



	/**
	 * Get the lat and long of the location before submitting
	 * */
	var geocodeServiceSearch = function () {
		return {
			init: function(address){
				var searchAddress = address;
				var geocoder = new google.maps.Geocoder();

				geocoder.geocode(
					{address: searchAddress},
					function(result,status) {
						if (status == google.maps.GeocoderStatus.OK ){
							var lat = result[0].geometry.location.lat();
							var lng = result[0].geometry.location.lng();

							jQuery('#lat_front').val(lat);
							jQuery('#lon_front').val(lng);
						}
					}
				);
			}
		};

	}();

	var search_properties = function(){
		return {
			init:function(){
				var buttonpressed;
				jQuery('.search-form-btn').click(function(e) {
					  buttonpressed = jQuery(this).attr('value');
				})
				jQuery("#advanced_search").on('submit',function(e){
					$('#msg').html('');
					e.preventDefault();
					var form = this;
					var address = jQuery("#location").val();
					jQuery('#transaction').val('For Sale');
					if( typeof buttonpressed !== 'undefined' ){
						if( buttonpressed == 'For Sale' ){
							jQuery('#transaction').val('For Sale');
						}else if( buttonpressed == 'For Rent' ){
							jQuery('#transaction').val('For Rent');
						}
					}
					var lat = jQuery('#lat_front');
					var lng = jQuery('#lon_front');
					var coordinates;
					if(
						lat.val() == ''
						&& lat.val().length == 0
						&& lng.val() == ''
						&& lng.val().length == 0
					){
						get_geo_code(address);
					}
					$('#msg').html('Please wait while we get current location coordinates..');
					setTimeout(function(){
						form.submit();
					}, 2000);
				});
			}
		};
	}();

	var jquery_ui_autocomplete = function(){
		return {
			init:function(source){
				$( "#location", context ).autocomplete({
					minLength: 3,
					source: function( request, response ) {
						var matches = $.map( autocomplete_location, function(value, label) {
							if ( value.value.toUpperCase().indexOf(request.term.toUpperCase()) === 0 ) {
								return value;
							}
						});
						response(matches);
					},
					select:function(event, ui){
						//log_location(ui);
						//$('#location',context).val('');
					}
				});
			},
		};
	}();

	var LocationTypeAhead = function () {

		return {
			init:function($source){
					var map = {};
					var substringMatcher = function(strs) {

						var objects = [];

						jQuery.each(strs, function(i, object) {
							map[object.keyword] = object;
							objects.push(object.keyword);
						});

						//strs = objects;
						return function findMatches(q, cb) {
							var matches, substrRegex, other_matches;
							console.log(q);
							// an array that will be populated with substring matches
							matches = [];
							other_matches = [];
							jQuery.each(objects, function(i, str) {
								if ( str.toUpperCase().indexOf(q.toUpperCase()) === 0 ) {
									matches.push({ value: str });
								}
							});
							cb(matches);
						};
					};

					var data_source = $source;

					jQuery('.typeahead').typeahead(
						{
							hint: true,
							highlight: true,
							limit:10,
							minLength: 3
						},
						{
							source: substringMatcher(data_source)
						}
					);
					jQuery('.typeahead').bind('typeahead:selected', function(obj, datum, name) {
							var address = datum.value;
							var location_id = map[datum.value].id;
							var location_type = map[datum.value].type;
							//console.log(location_type);

							jQuery('#locationname').val('');
							jQuery('#communityid').val('');
							jQuery('#cityid').val('');
							jQuery('#subdivisionid').val('');

							if( location_type == 'community' ){
								jQuery('#communityid').val(location_id);
							} else if( location_type == 'city' ){
								jQuery('#cityid').val(location_id);
							} else if( location_type == 'county' ){
								jQuery('#countyid').val(location_id);
							} else if( location_type == 'subdivision' ){
								jQuery('#subdivisionid').val(location_id);
							}

							jQuery('#locationname').val(map[datum.value].locationname);

							$('.search-form-btn').prop('disabled',true);
							if( address != '' ){
								get_geo_code(address);
							}
							$('.search-form-btn').prop('disabled',false);
							return false;
					});
			}
		};
	}();

	var ScrollInfiniteSearchResult = function(){
		return {
			init:function(selector, total_data, wp_var){
				jQuery(selector).scrollPagination({
					ajax_url 	: MDAjax.ajaxurl,
					ajax_action : 'pagination_scroll_action',
					ajax_data	: [
						{name: 'total_data', value: total_data}
					],
					ajax_data_wp : wp_var
				});
			}
		};
	}();

	$(window).load(function(){
		searchPropertyTransactionChange.init();
		search_properties.init();
		if(typeof location_autocomplete !== 'undefined' ){
			LocationTypeAhead.init(location_autocomplete);
		}
		if(typeof infinite_scroll !== 'undefined' && infinite_scroll == '1' ){
			ScrollInfiniteSearchResult.init(infinite_selector,search_property_result,wp_var);
		}
	});
})( jQuery );
