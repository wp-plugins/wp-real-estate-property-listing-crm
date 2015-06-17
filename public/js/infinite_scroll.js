(function($) {
	$.fn.scrollPagination = function(options) {

		var settings = {
			ajax_url		: '', // the url of ajax
			ajax_action 	: '',	//
			ajax_data 		: '',
			ajax_data_wp	: '',
			ajax_dataType 	: 'html',
			nop     		: 10, // The number of posts per scroll to be loaded
			paged  			: 2, // current page show is 1, so we need the next page which is 2
			error   		: 'No More Posts!', // When the user reaches the end this is the message that is
												// displayed. You can change this if you want.
			delay   		: 500, // When you scroll down the posts will load after a delayed amount of time.
									// This is mainly for usability concerns. You can alter this as you see fit
			scroll  		: true // The main bit, if set to false posts will not load as the user scrolls.
									// but will still load if the user clicks.
		}

		// Extend the options so they work with the plugin
		if(options) {
			$.extend(settings, options);
		}

		// For each so that we keep chainability.
		return this.each(function() {

			// Some variables
			$this = $(this);
			$settings = settings;
			var $masonry_container = MDAjax.masonry_container;
			var _current_page = 2;
			var _next_page;
			var paged;
			var busy = false; // Checks if the scroll action is happening
							  // so we don't run it multiple times
			var loader_html 			= jQuery('.ajax-indicator');
			var loader_img 				= jQuery('#loading-ajax-property-container .ajax-loader');
			var loader_html_container 	= jQuery('#loading-ajax-property-container');
			// Custom messages based on settings
			if($settings.scroll == true) $initmessage = 'Scroll for more or click here';
			else $initmessage = 'Click for more';
			// Append custom messages and extra UI
			var nomoredata = 1;

			function printPdf(){
				$('.print-pdf-action').on('click',function(e){
					var url = $(this).attr('href');
					var newwindow = window.open(url,'print pdf','height=700,width=900');
					if (window.focus) {newwindow.focus()}
					return false;
					e.preventDefault();
				});
			}
			function get_absolute_path() {
				var loc = window.location;
				var link;
				var pathName = loc.pathname.split('page');
				return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName[0].length))
			}
			function get_current_page(){
				var vars = [], hash;
				var link = '';
				var hashes = window.location.pathname.split('/');

				for(var i = 0; i < hashes.length; i++)
				{
					if( hashes[i] == 'page' ){
						vars['page'] = hashes[i+1];
					}
				}
				if (typeof(vars.page) != 'undefined') {
					return (parseInt(vars.page)+1);
				}else{
					return 2;
				}
			}
			function get_paged_link()
			{
				return get_absolute_path() + 'page/' + get_current_page() + '/' + window.location.search;
			}

			function getData() {
				var _ajax_data = [
					{name : 'security', value: MDAjax.security},
					{name : 'action', value : $settings.ajax_action},
					{name : 'number', value : $settings.nop},
					{name : 'paged', value : get_current_page()},
					{name : 'url', value : get_paged_link()},
				];
				if( $settings.ajax_data.length > 0 ){
					$.merge(_ajax_data,$settings.ajax_data);
				}
				if( $settings.ajax_data_wp.length > 0 ){
					$.merge(_ajax_data,$settings.ajax_data_wp);
				}
				var _ajax_result_selector;
				jQuery( _ajax_data ).each(function( k, v ) {
				  if( _ajax_data[k].name == 'infinite_result' ){
					  _ajax_result_selector = '.' + _ajax_data[k].value;
				  }
				  if( _ajax_data[k].name == 'next_url_page' ){
					  _next_page = _ajax_data[k].value;
				  }
				});
				var _ajax_container_result = jQuery(_ajax_result_selector);

				// Post data to ajax.php
				var $container = $('.' + MDAjax.masonry_container);

				// initialize
				if( MDAjax.masonry == 1 ){
					$container.imagesLoaded(function(){
						$container.masonry({
							itemSelector: '.property-item'
						});
					});
				}

				$.post(
					$settings.ajax_url,
					_ajax_data,
					function(data) {
						// If there is no data returned, there are no more posts to be shown. Show error
						nomoredata = jQuery(data).find('#nomoredata').val();
						if(data == "" || nomoredata == 0) {
							loader_html.hide();
						}
						else {
							var class_page = '.page-' + get_current_page();
							history.replaceState(null, null, get_paged_link());
							var $moreBlocks = $( data );
							var $data 		= $moreBlocks.filter(".property-item");
							if( MDAjax.masonry == 1 ){
								$data.hide();
								$container.append( $data );
								$data.imagesLoaded(function(){
									$data.show();
									$container.masonry( 'appended', $data );
								});
							}else{
								_ajax_container_result.append($moreBlocks);
							}
							var replace_pagination = $( data ).find('.pagination');
							jQuery('.pagination').html(replace_pagination);
							//console.log(data);
							busy = false;
							printPdf();
						}
					},
					$settings.ajax_dataType
				)
			}
			// If scrolling is enabled
			if($settings.scroll == true) {
				// .. and the user is scrolling
				$(window).scroll(function() {
					// Check the user is at the bottom of the element
					if($(window).scrollTop() + $(window).height() > $this.height() && !busy) {
						//console.log($(window).scrollTop() + '+' + $(window).height() + '>' + $this.height());
						loader_html.show();
						// Now we are working, so busy is true
						busy = true;
						// Tell the user we're loading posts
						// Run the function to fetch the data inside a delay
						// This is useful if you have content in a footer you
						// want the user to see.
						if(nomoredata != 0 ){
							setTimeout(function() {
								getData();
							}, $settings.delay);
							loader_html.show();
						}else{
							loader_html.hide();
						}
					}
				});
			}

			// Also content can be loaded by clicking the loading bar/
			loader_html_container.click(function() {

				if(busy == false) {
					busy = true;
					getData();
				}

			});

		});
	}
})(jQuery);
