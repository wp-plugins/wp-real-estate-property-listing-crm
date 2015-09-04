(function( $ ) {
	'use strict';
	/**
	 * array of markers
	 * */
	var arr_markers = new Array();
	var ajax_properties_html;
	var arr_info_windows = new Array();
	var click_marker = false;
	var clicked_marker_data;
	var get_properties_limit = 100;
	var is_moved = false;
	/**
	 * use for google map
	 * */
	var gmap_marker;
	var map;
	var gmap_bounds;
	var gmap_bounds_ne;
	var gmap_bounds_sw;
	var infowindow;
	var gmap_max_zoom;
	//global function
	function set_markers(_marker){
		arr_markers.push(_marker);
	};

	function empty_markers(){
		arr_markers = new Array();
	};

	function get_markers(){
		return arr_markers;
	}

	function close_all_infowindows() {
	  for (var i=0; i < arr_info_windows.length; i++) {
		 arr_info_windows[i].close();
	  }
	}

	function set_marker_data_globally(global_marker){
		clicked_marker_data = global_marker;
	}

	var set_gmap_bounds = function(){
		gmap_bounds = map.getBounds();
		gmap_bounds_ne = gmap_bounds.getNorthEast(); // LatLng of the north-east corner
		gmap_bounds_sw = gmap_bounds.getSouthWest(); // LatLng of the south-west corder
	};

	function ajax_msg(action, html_text){
		html_text = html_text || "";
		var msg = $('#sidebar-properties .msg');
		switch(action){
			case 'show':
				msg.show();
			break;
			case 'hide':
				msg.hide();
			break;
			default:
				msg.hide();
			break;
		}
		msg.html(html_text);
	};

	function has_no_map_boundary_support(){
		if( MDAjax.has_map_boundaries_support == 0){
			return false;
		}
		return true;
	}

	var no_map_boundary_support = function(){
		function _auto_center_marker(map){
			var latlngbounds = new google.maps.LatLngBounds();
			$.each(arr_markers, function (index, marker) {
				latlngbounds.extend(marker.position);
			});
			//  Fit these bounds to the map
			map.fitBounds(latlngbounds);
		}
		function _show_property_box(){
			$('#sidebar-properties a.trigger').click(function(e){
				if (infowindow) infowindow.close();
				var property_id = $(this).data('property-id');
				var found_marker;
				for(var i = 0; i < markers.length; i++){ // looping through Markers Collection
					$('.property-id-'+markers[i].property_id).css('background','');
					if( markers[i].property_id == property_id ){
						found_marker = markers[i].getZIndex();
					}
				}
				var markerPosition = markers[found_marker].getPosition();
				map.setCenter(markerPosition);
				map.setZoom(20);
				google.maps.event.trigger(markers[found_marker], 'click');
			});
		}
		function _sidebar_display_current_visible_marker(map){
			var current_marker = new Array();
			for (var i = 0; i < $('.property-list').length; i++ ){
				$('.property-list').eq(i).hide();
			}
			var bounds = map.getBounds();
			for(var i = 0; i < arr_markers.length; i++){ // looping through Markers Collection
				if( bounds.contains(arr_markers[i].getPosition()) ){
					current_marker.push(arr_markers[i].property_id);
					$('.' + arr_markers[i].property_id + '-sidebar').show();
				}
			}
			var total_properties = current_marker.length;
			//$('.total_property').html('Total Properties : ' + total_properties);
			var property_id = current_marker[0];
			map_sidebar.show_property_overview(property_id);
		}
		return {
			init:function(map){
				if(has_no_map_boundary_support()){
					_sidebar_display_current_visible_marker(map);
				}
			},
			center:function(map){
				if(has_no_map_boundary_support()){
					_auto_center_marker(map);
				}
			},
			show_sidebar_base_marker:function(){
				_sidebar_display_current_visible_marker(map);
			},
		};
	}();

	var map_sidebar = function(){
		function _hide_all_sidebar(){
			$('.property-list').hide();
		}

		function _show_all_sidebar(){
			$('.property-list').show();
		}

		function load_markers(){
		}

		function sidebar_properties(action, html_data){
			html_data = html_data || "";
			var properties_html = $('#sidebar-properties .ajax-load-properties');
			properties_html.html('<p>Loading..</p>');
			switch(action){
				case 'show':
					properties_html.show();
				break;
				case 'hide':
					properties_html.hide();
				break;
				default:
					properties_html.show();
				break;
			}
			properties_html.html(html_data);
		}

		return{
			populate:function(action, data){
				sidebar_properties(action, data);
			},
			click:function(){
				$('.property-list').click(function(e){
					var property_id = $(this).data('property-id');
					var found_marker;

					if (infowindow) close_all_infowindows();
					for(var i = 0; i < arr_markers.length; i++){ // looping through Markers Collection
						if( arr_markers[i].property_id == property_id ){
							found_marker = arr_markers[i].getZIndex();
						}
					}
					set_marker_data_globally(arr_markers[found_marker]);
					google.maps.event.trigger(arr_markers[found_marker], 'click');
					map_sidebar.show_property_overview(property_id);
				});
			},
			show_property_overview:function(property_id){
				var sidebar_panel =  $('#panel-single-property .panel-body');
				sidebar_panel.html('<p>Fetching property details, please wait...</p>');
				var data = {
					'action': 'get_single_property_action',
					'click_marker': click_marker,
					'marker': property_id,
					'security': MDAjax.security
				};
				jQuery.ajax({
				  url: MDAjax.ajaxurl,
				  method: "POST",
				  data: data,
				  dataType: "html",
				  success:function(msg){
					  sidebar_panel.html(msg);
				  }
				});
			},
			load_markers:function(){
				set_gmap_bounds();
				var property_id = 0;
				if( typeof clicked_marker_data !== undefined && clicked_marker_data ){
					property_id = clicked_marker_data.property_id;
				}
				var sidebar_properties = $('#sidebar-properties');
				var data = {
					'action': 'properties_data_action',
					'cityid': urlParams.cityid,
					'communityid': urlParams.communityid,
					'min_listprice': urlParams.min_listprice,
					'max_listprice': urlParams.max_listprice,
					'property_type': urlParams.property_type,
					'transaction': urlParams.transaction,
					'property_status': urlParams.property_status,
					'bathrooms': urlParams.bathrooms,
					'bedrooms': urlParams.bedrooms,
					'ne_lat': gmap_bounds_ne.lat(),
					'ne_lng': gmap_bounds_ne.lng(),
					'sw_lat': gmap_bounds_sw.lat(),
					'sw_lng': gmap_bounds_sw.lng(),
					'limit': get_properties_limit,
					'click_marker': click_marker,
					'marker': property_id,
					'security': MDAjax.security
				};
				ajax_msg('show', 'Please wait while getting data..');
				ajax_properties_html = jQuery.post(MDAjax.ajaxurl, data,'html');
				map_sidebar.populate('hide','');
				ajax_properties_html.success(function(response, callback){
					//set markers array to empty
					empty_markers();
					//populate sidebars
					map_sidebar.populate('show',response);
					//set gmap markers
					gmap.marker(map, property_data);
					//$('.total_property').html('Total Properties : ' + total_properties);
					ajax_msg('hide','');
					//click event
					map_sidebar.click();
					//open first marker
					if(has_no_map_boundary_support()){
						no_map_boundary_support.init(map);
					}else{
						map_sidebar.open_first_marker();
					}
				});
			},
			open_first_marker:function(){
				var property_id = arr_markers[0].property_id;
				if( clicked_marker_data ){
					property_id = clicked_marker_data.property_id;
				}
				map_sidebar.show_property_overview(property_id);
			},
		};
	}();

	var gmap_events = function(){
		return{
			idle:function(){
				google.maps.event.addListener(map, 'idle', function() {
					gmap_events.max_zoom_out(map, gmap_max_zoom);
					if( !click_marker ){
						map_sidebar.load_markers();
					}
					is_moved = true;
				});
			},
			marker_click:function(infowindow, marker, infowindow_content){
				google.maps.event.addListener(marker, 'click', function(event) {
					click_marker = true;
					if (infowindow) {
						close_all_infowindows();
					}
					infowindow.open(map, marker);
					set_marker_data_globally(marker);
					map_sidebar.show_property_overview(marker.property_id);
					google.maps.event.addListener(infowindow,'closeclick',function(){
						click_marker = false;
					});
				});
			},
			max_zoom_out:function(map, zoom){
				// Limit the zoom level
				if (map.getZoom() < (zoom - 1)) map.setZoom(zoom);
			},
			drag:function(){
				google.maps.event.addListener(map,'drag',function(){
				});
			}
		};
	}();

	var gmap = function(){
		var md_property;
		return{
			init:function(arr_options,arr_config){
				var map_selector = arr_config.selector;
				var myLatLng = {lat: arr_options.center.lat, lng: arr_options.center.lng};
				gmap_max_zoom = arr_options.zoom;
				map = new google.maps.Map(document.getElementById('map-canvas'), {
					zoom:arr_options.zoom,
					center:myLatLng
				});
				gmap_events.idle();
			},
			marker:function(map, property_data){
				var arr_markers = new Array();
				for (var i = 0; i < property_data.length; i++) {
					md_property = property_data[i];
					var content_body = {name:md_property.name, url:md_property.url};
					var latlng = new google.maps.LatLng(md_property.lat, md_property.lng);
					var marker = new google.maps.Marker({
						position: latlng,
						map: map,
						title: md_property.name,
						zIndex: i,
						id: i,
						property_id:md_property.id,
						lat:md_property.lat,
						lng:md_property.lng,
						//price:md_property.price,
					});
					set_markers(marker);
					gmap.infowindow(map, marker, content_body);
				}
			},
			infowindow:function(map, gmap_marker, content_body){
				var infowindow_content = '<div>'+
					'<a href="'+content_body.url+'" target="_blank">'+content_body.name+'</a>'+
				'</div>';
				infowindow = new google.maps.InfoWindow({
				  content: infowindow_content
				});
				arr_info_windows.push(infowindow);
				gmap_events.marker_click(infowindow, gmap_marker, infowindow_content);
			}
		};
	}();

	$(window).load(function(){
		if( typeof is_search !== 'undefined' ){
			google.maps.event.addDomListener(window, 'load', gmap.init(gmap_option,gmap_config));
		}
	});

})( jQuery );

