(function( $ ) {
	'use strict';

	var SendInquiryForm = function () {
		return {
			init:function(){
				$('.inquiry_form')[0].reset();
				$('.inquireform').text("Send").attr("disabled", false);
				$('.inquiry_form').on('submit',function(){
					var data = jQuery(this).serializeArray();

					data.push({name: 'action', value: 'inquireform_action'});
					data.push({name: 'security', value: MDAjax.security});

					$('.inquireform').text("Sending Inquiry...").attr("disabled", true);
					$('.ajax-msg').html("");

					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						$('.ajax-msg').html( data.msg );
						if( data.status ){
							//console.log('success');
						}else{
							//console.log('fail');
						}
						$('.inquireform').text("Send").attr("disabled", false);
					});

					return false;
				});
			}
		};
	}();

	$(window).load(function(){
		if ( $('.inquiry_form').length ) {
			SendInquiryForm.init();
		}
	});

})( jQuery );

