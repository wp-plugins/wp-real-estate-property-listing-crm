(function( $ ) {
	'use strict';

	var LoginForm = function () {
		return {
			init:function(){
				//$('.login-form')[0].reset();
				$('.modal-login').text("Login").attr("disabled", false);
				$('.login-form').on('submit',function(){
					var data = jQuery(this).serializeArray();

					data.push({name: 'action', value: 'login_action'});
					data.push({name: 'security', value: MDAjax.security});

					$('.register-login-alert').removeClass('alert-success alert-danger');
					$('.register-login-alert').html('');
					$('.modal-login').text("Processing...").attr("disabled", true);
					$('.closemodal').attr("disabled", true);

					jQuery.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						$('.register-login-alert').html( data.msg );
						if( data.status ){
							//console.log('success');
							$('.register-login-alert').removeClass('hide alert-danger').addClass('alert-success').html(data.msg);
							setTimeout(function(){
								$('.register-modal').modal('hide');
								location.reload(true);
							},2000);
						}else{
							//console.log('fail');
							$('.register-login-alert').removeClass('hide alert-success').addClass('alert-danger').html(data.msg);
						}
						$('.modal-login').text("Login").attr("disabled", false);
						$('.closemodal').attr("disabled", false);
					});

					return false;
				});
			}
		};
	}();

	var RegisterForm = function () {

		return {
			init:function(){
				$('.register-form')[0].reset();
				$('.registersend').text("Sign-up").attr("disabled", false);
				$('.register-form').on('submit',function(){
					var data = jQuery(this).serializeArray();

					data.push({name: 'action', value: 'signup_action'});
					data.push({name: 'security', value: MDAjax.security});

					$('.register-login-alert').removeClass('alert-success alert-danger');
					$('.registersend').text("Please wait signing-up...").attr("disabled", true);
					$('.closemodal').attr("disabled", true);

					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						$('.register-login-alert').html( data.msg );
						if( data.status ){
							//console.log('success');
							$('.register-login-alert').removeClass('hide alert-danger').addClass('alert-success').html(data.msg);
							setTimeout(function(){
								$('.register-modal').modal('hide');
								location.reload(true);
							},2000);
						}else{
							$('.register-login-alert').removeClass('hide alert-success').addClass('alert-danger').html(data.msg);
						}
						$('.registersend').text("Sign-up").attr("disabled", false);
						$('.closemodal').attr("disabled", false);
					});

					return false;
				});
			}
		};
	}();

	$(window).load(function(){
		if ( $('.register-form').length ) {
			RegisterForm.init();
		}
		if( $('.login-form').length ){
			LoginForm.init();
		}
	});

})( jQuery );

