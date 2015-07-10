(function( $ ) {
	'use strict';

	var PropertyAlert = function () {

		function show_registration_modal(){
		}

		return {
			init:function(){
				var button = jQuery('.save-search');
				button.on('click',function(){
					var data = [];
					data.push({name: 'action', value: 'property_alert_action'});
					data.push({name: 'security', value: MDAjax.security});
					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						if( data.is_loggedin == 0 ){
							RegisterForm.init();
						}
					});
				});
			}
		};
	}();

	$(window).load(function(){
		//PropertyAlert.init();
	});

})( jQuery );

