(function( $ ) {
	'use strict';
	var ajax_update_user = function(){
		return {
			init:function(response, fb_auth, current_action){
				var ajax_data = [];
				var current_data_post = jQuery('#registerModal .data_post').val();
				var finish = 0;

				ajax_data.push({name:'data_post', value:current_data_post});
				ajax_data.push({name:'fb_first_name', value:response.first_name});
				ajax_data.push({name:'fb_last_name', value:response.last_name});
				ajax_data.push({name:'fb_name', value:response.name});
				ajax_data.push({name:'fb_email', value:response.email});
				ajax_data.push({name:'fb_uid', value:response.id});
				ajax_data.push({name:'fb_access_token', value:fb_auth[1].value});
				ajax_data.push({name:'current_action', value:current_action});
				ajax_data.push({name:'action', value: 'fb_login_action'});
				ajax_data.push({name:'security', value: MDAjax.security});

				jQuery.ajax({
					type: "POST",
					url: MDAjax.ajaxurl,
					data: ajax_data,
					dataType: "json"
				}).done(function( data ) {
					jQuery('#status').html(data.msg);
					if( data.status ){
						if( data.callback_action != 0 ){
							var data_callback = {
								action: data.callback_action,
								security: MDAjax.security,
								post_data: data.ret_data
							};
							jQuery.post(
								MDAjax.ajaxurl,
								data_callback,
								function(response){
									if( response.status ){
										ReloadThis.init();
									}
								}
							);
						}else{
							finish = 1;
						}
						finish = 1;
					}
					if( finish == 1 ){
						ReloadThis.init();
					}
				});
			}
		};
	}();

	var ajax_update_user_meta = function(){
		return {
			init:function(response){
				var ajax_data = [];

				var uid = response.authResponse.userID;
				var accessToken = response.authResponse.accessToken;

				ajax_data.push({name:'fb_uid', value:uid});
				ajax_data.push({name:'fb_accessToken', value:accessToken});

				return ajax_data;
			}
		};
	}();

	var statusChangeCallback = function(){
		return {
			init:function(response){
				// The response object is returned with a status field that lets the
				// app know the current login status of the person.
				// Full docs on the response object can be found in the documentation
				// for FB.getLoginStatus().
				if (response.status === 'connected') {
				  // Logged into your app and Facebook.
				  console.log('connected');
				  connected_api.init(response);
				} else if (response.status === 'not_authorized') {
				  // The person is logged into Facebook, but not your app.
				  /*document.getElementById('status').innerHTML = 'Please log ' +
					'into this app.';*/
					console.log('Please log into this app');
				} else {
				  // The person is not logged into Facebook, so we're not sure if
				  // they are logged into this app or not.
				  /*document.getElementById('status').innerHTML = 'Please log ' +
					'into Facebook.';*/
					console.log('Please log into Facebook');
				}
			}
		};
	}();

	var connected_api = function(){
		return {
			init: function(response){
					jQuery('#status').html('');
					var current_action 	= jQuery('#registerModal .current_action').val();
					var fb_auth 		= ajax_update_user_meta.init(response);
					FB.api('/me', function(response) {
						if( current_action != '' ){
							jQuery('#status').html('<p>login to facebook, please wait...</p>');
							ajax_update_user.init(response, fb_auth, current_action);
						}
					});
			}
		};
	}();

	$(window).load(function(){
		window.fbAsyncInit = function() {
			FB.init({
				appId      : '737572189630663',
				cookie     : true,  // enable cookies to allow the server to access
									// the session
				xfbml      : true,  // parse social plugins on this page
				version    : 'v2.2' // use version 2.2
			});

			// Now that we've initialized the JavaScript SDK, we call
			// FB.getLoginStatus().  This function gets the state of the
			// person visiting this page and can return one of three states to
			// the callback you provide.  They can be:
			//
			// 1. Logged into your app ('connected')
			// 2. Logged into Facebook, but not your app ('not_authorized')
			// 3. Not logged into Facebook and can't tell if they are logged into
			//    your app or not.
			//
			// These three cases are handled in the callback function.

			FB.getLoginStatus(function(response) {
				statusChangeCallback.init(response);
			});
		};

		// Load the SDK asynchronously
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		function checkLoginState() {
			FB.getLoginStatus(function(response) {
			  statusChangeCallback.init(response);
			});
		}
	});

})( jQuery );

