(function( $ ) {
	'use strict';
	var sharePop = function(){
		return {
			init:function(){
				$(".share-popup").click(function(e){
					var url = this.href;
					var domain = url.split("/")[2];
					var window_size = "width=585,height=511";
					window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,' + window_size);
					e.preventDefault();
					return false;
				});
			}
		};
	}();
	var printPdf = function(){
		return {
			init:function(){
				$('.print-pdf-action').on('click',function(e){
					var url = $(this).attr('href');
					var newwindow = window.open(url,'print pdf','height=700,width=900');
					if (window.focus) {newwindow.focus()}
					return false;
					e.preventDefault();
				});
			}
		};
	}();
	$(window).load(function(){
		sharePop.init();
		printPdf.init();
		if( MDAjax.masonry == 1 ){
			var $container = $('.' + MDAjax.masonry_container);
			// initialize
			$container.imagesLoaded(function(){
				$container.masonry({
					itemSelector: '.property-item'
				});
			});

			$('.item-container').imagesLoaded(function(){
				$('.item-container').masonry({
					itemSelector: '.property-item'
				});
			});
		}
	});
})( jQuery );

