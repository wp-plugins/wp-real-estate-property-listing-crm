(function( $ ) {
	'use strict';

	var update_profile = function(){
		return {
			init:function(){
				$('.profile-form').on('submit',function(e){
					var data 	   = jQuery(this).serializeArray();
					var html_alert = $('.profile-alert');
					var form_btn   = $('.update-profile-btn');

					data.push({name: 'action', value: 'update_profile'});
					data.push({name: 'security', value: MDAjax.security});

					form_btn.attr("disabled", true);

					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						html_alert.html( data.msg );
						if( data.status ){
							//console.log('success');
							html_alert.removeClass('hide alert-danger').addClass('alert-success').html(data.msg).fadeOut('slow');
						}else{
							html_alert.removeClass('hide alert-success').addClass('alert-danger').html(data.msg);
						}
						form_btn.attr("disabled", false);
					});
					e.preventDefault();
				});
			},
		};
	}();

	var set_password = function(){
		return {
			init:function(){
				$('.password-form').on('submit',function(e){
					var data 		= jQuery(this).serializeArray();
					var html_alert 	= $('.password-alert');
					var form_btn 	= $('.set-password');

					data.push({name: 'action', value: 'update_password'});
					data.push({name: 'security', value: MDAjax.security});

					form_btn.attr("disabled", true);
					html_alert.attr('style','');

					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						html_alert.html( data.msg );
						if( data.status ){
							html_alert.removeClass('hide alert-danger').addClass('alert-success').html(data.msg).fadeOut('slow');
						}else{
							html_alert.removeClass('hide alert-success').addClass('alert-danger').html(data.msg);
						}
						form_btn.attr("disabled", false);
					});
					e.preventDefault();
				});
			},
		};
	}();

	$(window).load(function(){
		update_profile.init();
		set_password.init();
	});

})( jQuery );
