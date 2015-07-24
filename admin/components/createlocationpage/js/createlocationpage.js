(function( $ ) {
	'use strict';

	var create_page_location = function(){
		return {
			init:function(){
				var click_button 	= $('.click-create-page-location');
				var html_indicator 	= $('.indicator');

				click_button.on('click',function(e){
					click_button.hide();
					var post_status = $('#post_status').val();
					var option_name = $('#option_name').val();
					var default_feed = $('#default_feed').val();

					var data = [
						{name: 'action', value: 'create_location_page_action_' + default_feed},
						{name: 'security', value: MDAjax.security},
						{name: 'post_status', value: post_status},
						{name: 'option_name', value: option_name}
					];

					html_indicator.html('<h2>Warning! Do not interrupt, Updating / Creating page by location now, please wait...</h2><img src='+MDAjax.ajax_indicator+'>');

					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						html_indicator.html('');
						click_button.show();
						if( data.status ){
							html_indicator.html('<h3>' + data.msg + '</h3>');
						}else{
							html_indicator.html('<h3>' + data.msg + '</h3>');
						}
					});
					return false;
					e.preventDefault();
				});
			},
		};
	}();

	$(window).load(function(){
		create_page_location.init();
	});

})( jQuery );
