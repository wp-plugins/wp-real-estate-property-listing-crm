(function( $ ) {
	'use strict';

	var gmap = function(){
		var arr_options = {};
		var arr_config = {};
		var map;
		var marker;
		var markers 	= new Array();
		var myLatLng 	= new Array();
		var infowindow;
		var markerCluster;
		var content_body;
		var md_property;

		function _remove_red_bg(){
			$('.property-item').css('background','');
		}

		function _scroll_property_to(marker){
			var sidebar_property_id = marker.property_id;
			var target = $("." + sidebar_property_id + '-sidebar');
			var container = $('.container-siderbar-map');
			var sidebar_list = $('.sidemap-properties');
			var check_top = Math.floor((Math.max(0, (container.scrollTop() + target.position().top))));

			_remove_red_bg();

			if( check_top == 0 ){
				container.scrollTop(0);
			}else{
				container.scrollTop(container.scrollTop() + (target.position().top + (container.height()/2)) );
				$('.property-id-'+sidebar_property_id).css('background','red');
			}
		}

		function _show_property_box(){
			$(document).on('click','.trigger',function(){
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

		function _auto_center_marker(map){
			var latlngbounds = new google.maps.LatLngBounds();
			$.each(markers, function (index, marker) {
				latlngbounds.extend(marker.position);
			});
			//  Fit these bounds to the map
			map.fitBounds(latlngbounds);
		}

		function _get_markers() {
		  return markers;
		}


		var msg_sidebar_notification 	= $('.msg');
		var element_property_list 		= $('.property-list');

		function _get_current_visible_markers(){
			google.maps.event.addListener(map, 'dragend', function() {
				$('.container-siderbar-map').scrollTop(0);
				_remove_red_bg();
			});
			google.maps.event.addListener(map, 'bounds_changed', function() {
				for (var i = 0; i < $('.property-list').length; i++ ){
					$('.property-list').eq(i).hide();
				}
				var bounds = map.getBounds();
				for(var i = 0; i < markers.length; i++){ // looping through Markers Collection
					if( bounds.contains(markers[i].getPosition()) ){
						$('.' + markers[i].property_id + '-sidebar').show();
					}
				}
			});
			google.maps.event.addListener(markerCluster, "clusterclick", function (c) {
			  for (var i = 0; i < $('.property-list').length; i++ ){
				$('.property-list').eq(i).hide();
			  }

			  msg_sidebar_notification.html('<p>Fetching property list...</p>');
			  var m = c.getMarkers();
			  var p = [];
			  for (var i = 0; i < m.length; i++ ){
				p.push(m[i].getPosition());
				$('.' + m[i].property_id + '-sidebar').show();
				$('.property-id-'+m[i].property_id).css('background','');
			  }
			  msg_sidebar_notification.html('');
			});
		}

		return{
			init:function(){
				var map_selector = arr_config.selector;
				map = new google.maps.Map(document.getElementById('map-canvas'), arr_options);
				gmap.marker(map);
				markerCluster = new MarkerClusterer(map, markers);
				_auto_center_marker(map);
				_get_current_visible_markers();
				_show_property_box();
			},
			options:function($options){
				arr_options = $options;
			},
			config:function($config){
				arr_config = $config;
			},
			marker:function(map){
				for (var i = 0; i < property_data.length; i++) {
					md_property = property_data[i];
					content_body = {name:md_property.name, url:md_property.url};
					myLatLng = new google.maps.LatLng(md_property.lat, md_property.lng);
					marker = new google.maps.Marker({
						position: myLatLng,
						map: map,
						title: md_property.name,
						zIndex: i,
						id: i,
						property_id:md_property.id,
						lat:md_property.lat,
						lng:md_property.lng,
						//price:md_property.price,
					});
					markers.push(marker);
					gmap.infowindow(map, marker, content_body);
				}
			},
			infowindow:function(map, marker, content_body){
				var infowindow_content = '<div>'+
					'<div class="tab-infowindow">'+
						'<ul class="nav nav-tabs" role="tablist">'+
							'<li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">Details</a></li>'+
							//'<li role="presentation"><a href="#walkscore" aria-controls="walkscore" role="tab" data-toggle="tab">Walkscore</a></li>'+
						'</ul>'+
						'<div class="tab-content">'+
							'<div role="tabpanel" class="tab-pane active" id="details">'+
								'<div style="margin:20px 0;">'+
									'<p></p>'+
									'<a href="'+content_body.url+'">'+content_body.name+'</a>'+
								'</div>'+
							'</div>'+
							/*'<div role="tabpanel" class="tab-pane" id="walkscore">'+
								'<p>Walkscore</p>'+
							'</div>'+*/
						'</div>'+
					'</div>'+
				'</div>';
				google.maps.event.addListener(marker, 'click', function() {
					_scroll_property_to(marker);
					if (infowindow) infowindow.close();
					infowindow = new google.maps.InfoWindow({
					  content: infowindow_content
					});
					infowindow.open(map, marker);
				});
			}
		};
	}();

	$(window).load(function(){
		if( typeof is_search !== 'undefined' ){
			gmap.options(gmap_option);
			gmap.config(gmap_config);
			google.maps.event.addDomListener(window, 'load', gmap.init());
		}
	});

})( jQuery );

