(function( $ ) {
	'use strict';

	var singlePropertySaveProperty = function () {

		return {
			init:function(){
				$(document).on('click','.property_favorite',function(){
					var data 		= $(this).serializeArray();
					var $this 		= $(this);
					var xoutButton 	= $(this).closest('div').find('.xout');
					data.push({name: 'action', value: 'saveproperty_action'});
					data.push({name: 'security', value: MDAjax.security});
					data.push({name: 'property-id', value: $(this).data('property-id')});
					data.push({name: 'property-feed', value: $(this).data('property-feed')});

					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						if( data.status ){
							$this.toggleClass('property_favorite property_favorite_remove');
							$this.toggleClass('btn-default btn-primary');
							$this.find('.fa').toggleClass('fa-heart-o fa-heart');

							if( xoutButton.hasClass('property_xout_remove' ) ){
								xoutButton.toggleClass('property_xout_remove property_xout');
								xoutButton.toggleClass('btn-primary btn-default');
								xoutButton.find('.fa').toggleClass('fa-times-circle fa-times-circle-o');
							}
							alert(data.msg);
						}else{
							alert(data.msg);
						}
					});

					return false;
				});
			}
		};
	}();

	var singlePropertyXOutProperty = function () {
		return {
			init:function(){
				$(document).on('click','.property_xout',function(){
					var data 			= $(this).serializeArray();
					var $this 			= $(this);
					var favoriteButton 	= $(this).closest('div').find('.favorite');
					data.push({name: 'action', value: 'xoutproperty_action'});
					data.push({name: 'security', value: MDAjax.security});
					data.push({name: 'property-id', value: $(this).data('property-id')});
					data.push({name: 'property-feed', value: $(this).data('property-feed')});

					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						if( data.status ){
							$this.toggleClass('property_xout property_xout_remove');
							$this.toggleClass('btn-default btn-primary');
							$this.find('.fa').toggleClass('fa-times-circle-o fa-times-circle');

							if( favoriteButton.hasClass('property_favorite_remove' ) ){
								favoriteButton.toggleClass('property_favorite_remove property_favorite');
								favoriteButton.toggleClass('btn-primary btn-default');
								favoriteButton.find('.fa').toggleClass('fa-heart fa-heart-o');
							}
							alert(data.msg);
						}else{
							alert(data.msg);
						}
					});

					return false;
				});
			}
		};
	}();

	var singlePropertyRemoveProperty = function () {
		return {
			init:function(){
				$(document).on('click','.property_favorite_remove',function(){
					var data 	= $(this).serializeArray();
					var $this 	= $(this);
					var xoutButton 	= $(this).closest('div').find('.xout');
					data.push({name: 'action', value: 'remove_property_action'});
					data.push({name: 'security', value: MDAjax.security});
					data.push({name: 'property-id', value: $(this).data('property-id')});

					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						if( data.status ){

							if( xoutButton.hasClass('property_xout_remove' ) ){
								xoutButton.toggleClass('property_xout_remove property_xout');
								xoutButton.toggleClass('btn-primary btn-default');
								xoutButton.find('.fa').toggleClass('fa-times-circle fa-times-circle-o');
							}

							$this.toggleClass('property_favorite_remove property_favorite');
							$this.toggleClass('btn-primary btn-default');
							$this.find('.fa').toggleClass('fa-heart fa-heart-o');
							alert(data.msg);
						}else{
							alert(data.msg);
						}
					});

					return false;
				});
			}
		};
	}();

	var singlePropertyRemoveXOutProperty = function () {
		return {
			init:function(){
				$(document).on('click','.property_xout_remove',function(){
					var data 	= $(this).serializeArray();
					var $this 	= $(this);
					var favoriteButton 	= $(this).closest('div').find('.favorite');
					data.push({name: 'action', value: 'remove_xout_property_action'});
					data.push({name: 'security', value: MDAjax.security});
					data.push({name: 'property-id', value: $(this).data('property-id')});

					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						if( data.status ){
							if( favoriteButton.hasClass('property_favorite_remove' ) ){
								favoriteButton.toggleClass('property_favorite_remove property_favorite');
								favoriteButton.toggleClass('btn-primary btn-default');
								favoriteButton.find('.fa').toggleClass('fa-heart fa-heart-o');
							}
							$this.toggleClass('property_xout_remove property_xout');
							$this.toggleClass('btn-primary btn-default');
							$this.find('.fa').toggleClass('fa-times-circle fa-times-circle-o');
							alert(data.msg);
						}else{
							alert(data.msg);
						}
					});

					return false;
				});
			}
		};
	}();

	var SendToFriend = function () {
		return {
			init:function(){
				$('.sendtofriend').text("Send").attr("disabled", false);
				$('.closemodal').attr("disabled", false);
				$('.frm_send_link_mail').on('submit',function(){
					var data = $(this).serializeArray();

					data.push({name: 'action', value: 'sendtofriend_action'});
					data.push({name: 'security', value: MDAjax.security});

					$('.sendtofriend-alert').removeClass('alert-success alert-danger');

					$('.sendtofriend').text("Processing..").attr("disabled", true);
					$('.closemodal').attr("disabled", true);
					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						if( data.status ){
							$('.sendtofriend-alert').removeClass('hide alert-danger').addClass('alert-success').html(data.msg);
							setTimeout(function(){
								$('.send-to-friend-modal').modal('hide');
								location.reload(true);
							},2000);
						}else{
							$('.sendtofriend-alert').removeClass('hide alert-success').addClass('alert-danger').html(data.msg);
						}
						$('.sendtofriend').text("Send").attr("disabled", false);
						$('.closemodal').attr("disabled", false);
					});

					return false;
				});
			}
		};
	}();

	$(window).load(function(){
		$('.register-open').on('click',function(e){
			var id_register_modal = $('#registerModal');
			id_register_modal.modal('show');

			$('#registerModal .content-text').empty();

			var current_action = $(this).data('current-action');
			if (typeof current_action !== 'undefined') {
				// the variable is defined
				$('#registerModal .current_action').val(current_action);
				$('#registerModal .content-text').html(jQuery('.content-' + current_action).html());
			}

			var data_post = $(this).data('post');
			if (typeof data_post !== 'undefined') {
				// the variable is defined
				$('#registerModal .data_post').val(data_post);
			}
			e.preventDefault();
		});

		singlePropertySaveProperty.init();
		singlePropertyRemoveProperty.init();
		singlePropertyXOutProperty.init();
		singlePropertyRemoveXOutProperty.init();
	});

})( jQuery );

