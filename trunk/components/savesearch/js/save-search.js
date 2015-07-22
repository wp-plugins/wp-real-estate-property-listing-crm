(function( $ ) {
	'use strict';

	var SaveSearch = function () {

		function show_registration_modal(){
		}

		return {
			init:function(){
				var button = jQuery('.save-search');
				var label_ajax = jQuery('.label-ajax');
				$(document).on('click','.save-search',function(){
					var data = [];
					var data_post = $(this).data('post');
					var data_save_search_name = $(this).data('save-search');
					data.push({name: 'action', value: 'save_search_action'});
					data.push({name: 'security', value: MDAjax.security});
					data.push({name: 'data_post', value: data_post});
					data.push({name: 'data_save_search_name', value: data_save_search_name});

					$(this).find('.btn-text').text('Saved Search');
					$(this).find('.glyphicon').toggleClass('glyphicon-star-empty glyphicon-star');
					$(this).toggleClass('btn-primary btn-success');
					$(this).toggleClass('save-search saved-search');
					label_ajax.html('Saving search...');
					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						label_ajax.html('!Done');
						label_ajax.html('');
						if( data.is_loggedin == 0 ){
							RegisterForm.init();
						}
					});
				});
			}
		};
	}();

	$(window).load(function(){
		SaveSearch.init();
	});

})( jQuery );

