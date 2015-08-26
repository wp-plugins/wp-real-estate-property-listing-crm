(function( $ ) {
	'use strict';
	/*
	_renderItem: function( ul, item ) {

		var re = new RegExp( "(" + this.term + ")", "gi" ),
			cls = this.options.highlightClass,
			template = "<span class='" + cls + "'>$1</span>",
			label = item.label.replace( re, template ),
			$li = $( "<li/>" ).appendTo( ul );

		$( "<a/>" ).attr( "href", "#" )
				   .html( label )
				   .appendTo( $li );

		return $li;

	}
	* http://www.boduch.ca/2013/11/jquery-ui-highlighting-autocomplete-text.html
	*/
	var autocomplete_highlight = function(){
		return {
			init:function(){
				var oldFn = $.ui.autocomplete.prototype._renderItem;
				$.ui.autocomplete.prototype._renderItem = function( ul, item) {
				  var re = new RegExp("^" + this.term, "i") ;
				  var t = item.label.replace(re,"<span style='font-weight:bold;color:Blue;'>" + this.term + "</span>");
				  return $( "<li></li>" )
					  .data( "item.autocomplete", item )
					  .append( "<a>" + t + "</a>" )
					  .appendTo( ul );
				};
			}
		};
	}();
	$(window).load(function(){
		autocomplete_highlight.init();
	});
})( jQuery );
