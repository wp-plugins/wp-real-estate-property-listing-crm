(function( $ ) {
	'use strict';

	var update_profile = function(){
		return {
			init:function(){
				$(document).on('submit','.profile-form',function(e){

					var data 	   = jQuery(this).serializeArray();
					var html_alert = $('.profile-alert');
					var form_btn   = $('.update-profile-btn');
					var html_msg   = $('.profile_msg');

					html_msg.empty();

					data.push({name: 'action', value: 'update_profile'});
					data.push({name: 'security', value: MDAjax.security});

					form_btn.attr("disabled", true);
					html_msg.html('<p>Pls wait, updating profile</p>');

					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						html_alert.html( data.msg );
						if( data.status ){
							html_alert.show();
							html_alert.removeClass('hide alert-danger').addClass('alert-success').html(data.msg).fadeOut(2000);
						}else{
							html_alert.removeClass('hide alert-success').addClass('alert-danger').html(data.msg);
						}
						form_btn.attr("disabled", false);
						html_msg.empty();
					});
					e.preventDefault();
				});
			},
		};
	}();

	var set_password = function(){
		return {
			init:function(){
				$(document).on('submit','.password-form',function(e){
					var data 		= jQuery(this).serializeArray();
					var html_alert 	= $('.password-alert');
					var form_btn 	= $('.set-password');
					var html_msg   	= $('.password_msg');

					data.push({name: 'action', value: 'update_password'});
					data.push({name: 'security', value: MDAjax.security});

					form_btn.attr("disabled", true);
					html_alert.attr('style','');
					html_msg.html('<p>Pls wait, updating password</p>');

					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						html_alert.html( data.msg );
						if( data.status ){
							html_alert.removeClass('hide alert-danger').addClass('alert-success').html(data.msg).fadeOut(2000);
						}else{
							html_alert.removeClass('hide alert-success').addClass('alert-danger').html(data.msg);
						}
						form_btn.attr("disabled", false);
						html_msg.empty();
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
