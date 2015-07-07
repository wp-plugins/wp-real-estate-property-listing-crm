(function( $ ) {
	'use strict';

	var MapView = function(){
		return {
			init:function(map_selector, lat, lng, latlngData){
				$(map_selector).css("height", "700px").gmap3({
					map:{
						options:{
							center:[lat,lng],
							zoom: 14,
							mapTypeId: google.maps.MapTypeId.ROADMAP,
							mapTypeControl: true,
							mapTypeControlOptions: {
								style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
							},
							navigationControl: true,
							scrollwheel: true,
							streetViewControl: true
						}
					},
					marker:{
						values:latlngData,
						 cluster:{
							events: {
							  click:function(cluster, event, data) {
								var map = $(this).gmap3("get");
								map.setCenter(cluster.main.getPosition());
								map.setZoom(map.getZoom() + 1);
							  }
							},
						  radius:100,
						  // This style will be used for clusters with more than 0 markers
						  0: {
							content: "<div class='cluster cluster-1'>CLUSTER_COUNT</div>",
							width: 53,
							height: 52
						  },
						  // This style will be used for clusters with more than 20 markers
						  20: {
							content: "<div class='cluster cluster-2'>CLUSTER_COUNT</div>",
							width: 56,
							height: 55
						  },
						  // This style will be used for clusters with more than 50 markers
						  50: {
							content: "<div class='cluster cluster-3'>CLUSTER_COUNT</div>",
							width: 66,
							height: 65
						  }
						},
						options:{
							draggable: false
						},
						events:{
							mouseover: function(marker, event, context){
								var map = $(this).gmap3("get"),
								infowindow = $(this).gmap3({get:{name:"infowindow"}});
								if (infowindow){
									infowindow.open(map, marker);
									infowindow.setContent(context.data);
								} else {
									$(this).gmap3({
										infowindow:{
											anchor:marker,
											options:{content: context.data}
										}
									});
								}
							},// mouseover
							mouseout: function(){
								//var infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
								//if (infowindow){
								//infowindow.close();
								//}
							}, // mouseout
							click: function(marker, event, context){
								var map = $(this).gmap3("get"),
								infowindow = $(this).gmap3({get:{name:"infowindow"}});
								if (infowindow){
									infowindow.open(map, marker);
									infowindow.setContent(context.data);
								} else {
									$(this).gmap3({
										infowindow:{
											anchor:marker,
											options:{content: context.data}
										}
									});
								}
							},// click
						}
					}
				});
			}
		};
	}();

	var DirectionsMapView = function(){
		return {
			init:function(map_selector, lat, lng, latlngData, from, to){
				$(map_selector).css("height", "700px").gmap3({
					map:{
						options:{
							center:[lat,lng],
							zoom: 9,
							mapTypeId: google.maps.MapTypeId.ROADMAP,
							mapTypeControl: true,
							mapTypeControlOptions: {
								style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
							},
							navigationControl: true,
							scrollwheel: true,
							streetViewControl: true
						}
					},
					getroute:{
						options:{
							origin:to,
							destination:from,
							travelMode: google.maps.DirectionsTravelMode.DRIVING
						},
						callback: function(results){
						  if (!results) return;
						  $(this).gmap3({
							map:{
							  options:{
								zoom: 13,
								center: [lat, lng]
							  }
							},
							directionsrenderer:{
							  container: $('.directions'),
							  options:{
								directions:results
							  }
							}
						  });
						}
					},
					marker:{
						values:latlngData,
						options:{
							draggable: false
						},
						events:{
							mouseover: function(marker, event, context){
								var map = $(this).gmap3("get"),
								infowindow = $(this).gmap3({get:{name:"infowindow"}});
								if (infowindow){
									infowindow.open(map, marker);
									infowindow.setContent(context.data);
								} else {
									$(this).gmap3({
										infowindow:{
											anchor:marker,
											options:{content: context.data}
										}
									});
								}
							},// mouseover
							mouseout: function(){
								//var infowindow = jQuery(this).gmap3({get:{name:"infowindow"}});
								//if (infowindow){
								//infowindow.close();
								//}
							}, // mouseout
							click: function(marker, event, context){
								var map = $(this).gmap3("get"),
								infowindow = $(this).gmap3({get:{name:"infowindow"}});
								if (infowindow){
									infowindow.open(map, marker);
									infowindow.setContent(context.data);
								} else {
									$(this).gmap3({
										infowindow:{
											anchor:marker,
											options:{content: context.data}
										}
									});
								}
							},// click
						}
					}
				});
			}
		};
	}();

	var StreetView = function(){
		return {
			init:function(selector, lat, lng, latlngData){
				var lat_lng = new google.maps.LatLng(lat,lng);
				$(selector).css("height", "400px").gmap3({
				  marker:{
					values:[
						{latLng:[lat,lng]}
					],
				  },
				  map:{
					options:{
					  zoom: 14,
					  mapTypeId: google.maps.MapTypeId.ROADMAP,
					  streetViewControl: true,
					  center: lat_lng
					}
				  },
				  streetviewpanorama:{
					options:{
					  container: $(document.createElement("div")).addClass("googlemap").insertAfter($(selector)),
					  opts:{
						position: lat_lng,
						pov: {
						  heading: 34,
						  pitch: 10,
						  zoom: 1
						}
					  }
					}
				  }
				});
			}
		};
	}();

	var BirdsView = function(){
		return {
			init: function(selector, lat, lng, latlngData){
				$(selector).css("height", "400px").gmap3({
				  marker:{
					values:[
						{latLng:[lat,lng]}
					],
				  },
				  map:{
					options:{
					  center:[lat, lng],
					  zoom: 18,
					  mapTypeId: google.maps.MapTypeId.SATELLITE,
					  mapTypeControl: true,
					  mapTypeControlOptions: {
						  style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
					  },
					  navigationControl: true,
					  scrollwheel: true,
					  streetViewControl: true
					}
				  }
				});
			}
		}
	}();

	// Place your public-facing JavaScript here
	var showMap = function(){
		return {
			init:function(selector, lat, lng, latlngData){
				$(document).on('shown.bs.tab','a[data-toggle="tab"]', function (e) {
				//$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var currentTab = $(e.target).text(); // get current tab
					var LastTab = $(e.relatedTarget).text(); // get last tab
					var currentHref = $(e.target).attr('href'); // get last tab

					if(
						currentHref == '#map-directions' ||
						currentHref == '#map-view'
					){
						MapView.init(selector, lat, lng, latlngData);
					}

					if( currentHref == '#street-view' ){
						StreetView.init('.street_view', lat, lng, latlngData);
					}

					if( currentHref == '#birdseye-view' ){
						BirdsView.init('.birdseye_view', lat, lng, latlngData);
					}

				});
			}
		};
	}();

	var ShowTabPhotos = function(){
		return {
			init:function(){
				$(document).on('shown.bs.tab','a[data-toggle="tab"]', function (e) {
				//$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
					var currentTab = $(e.target).text(); // get current tab
					var LastTab = $(e.relatedTarget).text(); // get last tab
					var currentHref = $(e.target).attr('href'); // get last tab
					if(
						currentHref == '#photos'
					){
						var $photo_container = $('#photos-single-container');
						// initialize
						$photo_container.imagesLoaded(function(){
							$photo_container.masonry({
								itemSelector: 'li.photos-item-single'
							});
						});
					}
				});
			}
		};
	}();

	var QuickMapShow = function(){
		return {
			init:function(sel, lat,lon, str_data){
				$(sel).gmap3({
				  map:{
					options:{
					  center:[lat,lon],
					  zoom: 15
					}
				  },
				  marker:{
					values:[
					  {latLng:[lat,lon], data:str_data, options:{icon: "http://maps.google.com/mapfiles/marker_green.png"}},
					],
					options:{
					  draggable: false
					},
					events:{
					  mouseover: function(marker, event, context){
						var map = $(this).gmap3("get"),
						  infowindow = $(this).gmap3({get:{name:"infowindow"}});
						if (infowindow){
						  infowindow.open(map, marker);
						  infowindow.setContent(context.data);
						} else {
						  $(this).gmap3({
							infowindow:{
							  anchor:marker,
							  options:{content: context.data}
							}
						  });
						}
					  },
					  mouseout: function(){
						var infowindow = $(this).gmap3({get:{name:"infowindow"}});
						if (infowindow){
						  infowindow.close();
						}
					  }
					}
				  }
				});
			}
		};
	}();

	$(window).load(function(){
		if(typeof mainLat !== 'undefined' && typeof mainLng !== 'undefined'){
			showMap.init('.map_view', mainLat, mainLng, propertyList);
			$('#get_directions').on('submit',function(e){
				var from = $('#from').val();
				var to = origin_place;
				DirectionsMapView.init('.map_view', mainLat, mainLng, propertyList, from, to);
				return false; // prevent default click action from happening!
				e.preventDefault();
			});
			QuickMapShow.init(".quick_map_view",mainLat,mainLng,mainAddress);
		}
		ShowTabPhotos.init();
	});
})( jQuery );

