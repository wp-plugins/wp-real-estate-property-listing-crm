<link rel="stylesheet" href="<?php echo plugins_url(PLUGIN_FOLDER_NAME . '/admin/css/jquery-ui.css'); ?>" />
<style>
.ui-autocomplete-loading {
background: white url("<?php echo plugins_url('masterdigm/admin/css/images/ajax-loader.gif');?>") right center no-repeat;
}
.ui-autocomplete {
max-height: 150px;
overflow-y: auto;
/* prevent horizontal scrollbar */
overflow-x: hidden;
}
/* IE 6 doesn't support max-height
* we use height instead, but this forces the menu to always be this tall
*/
*
html .ui-autocomplete {
height: 300px;
}
#location{
	width:80%;
}
.remove-item{
	font-size:10px;
}
.col-left{
	float: left;
    width: 50%;
}
</style>
<form>
	<div class="ui-widget">
	  <label for="tags">Type Location: </label>
	  <input id="location" name="location" value="">
	  <div id="log" style="height: 150px;overflow-y: auto;overflow-x: hidden;width: 100%; overflow: auto;" class="ui-widget-content"></div>
	</div>
	<div class="row">
		<div class="col-left col-md-6 col-xs-12">
			<p>List by how many Bathrooms in property <input name="bath" value="0"></p>
			<p>List by how many Bedrooms in property <input name="bed" value="0"></p>
			<p>List by minimum listprice in property (number format only, example: 123456) <input name="min_price" value="0"></p>
			<p>List by maximum listprice in property (number format only, example: 123456) <input name="max_price" value="0"></p>
			<p>Status <select id="search_status" name="search_status"></select></p>
			<p>Type <select id="search_type" name="search_type"></select></p>
		</div>
		<div class="col-md-6 col-xs-12">
			<p>
				Transaction
				<select name="transaction" id="transaction">
					<option value="For Sale">For Sale</option>
					<option value="For Rent">For Rent</option>
					<option value="Foreclosure">Foreclosure</option>
				</select>
			</p>
			<p>How many property to display <input name="limit" value="11"></p>
			<p>Show Infinite Scroll? this will show the scrolling ajax instead of tix "how many display" <input type="checkbox" name="infinite" id="infinite"></p>
			<p>Choose template to display <select id="template" name="template"></select></p>
			<p>Set property per columns ( should be divided by 12 ) <input name="col" value="4"></p>
		</div>
	</div>
	<p></p>
	<button name="Insert Shortcode" id="insert-shortcode">Insert Shortcode</button>
</form>
<script>
	var args 					= top.tinymce.activeEditor.windowManager.getParams();
	var $ 						= args.jquery;
	var editor 					= args.editor;
	var autocomplete_location 	= args.autocomplete_location;
	var template 				= args.template;
	var search_status 			= args.search_status;
	var search_type 			= args.search_type;
	var context 				= document.getElementsByTagName("body")[0];
	var loc_data				= [];

	$(template).each(function(k,v){
		$('#template',context).append('<option value="'+v.value+'">'+v.text+'</option>');
	});
	$(search_status).each(function(k,v){
		$('#search_status',context).append('<option value="'+v.value+'">'+v.text+'</option>');
	});
	$(search_type).each(function(k,v){
		$('#search_type',context).append('<option value="'+v.value+'">'+v.text+'</option>');
	});

	function log_location( sel_loc ) {
		$('#location',context).val('');
		loc_data.push({value:sel_loc.item.id,type:sel_loc.item.type});

		var data_select = sel_loc.item.value;

		$( "#log", context ).prepend( '<div class="loc-item-'+sel_loc.item.id+'" >'+data_select+' - <a href="#" class="remove-item" onClick="remove_item('+sel_loc.item.id+');" data-id="'+sel_loc.item.id+'">Remove</a></div>' );
		$( "#log", context ).scrollTop( 0 );
	}

	function remove_item(id){
		loc_data = $.grep(loc_data,function(e){
			return e.value != id;
		});
		$('.loc-item-' + id, context).remove();
	}

	$( "#location", context ).autocomplete({
	   minLength: 3,
	   source: autocomplete_location,
	   select:function(event, ui){
		   log_location(ui);
		   $('#location',context).val('');
	   }
	});

	$('#insert-shortcode', context).on('click',function(e){
		var shortcode = '';
		var loc_input = $( 'input[name^="loc_"]', context );

		var city_id 	 = '';
		var community_id = '';

		var city_shortcode 		= ' cityid="0" ';
		var community_shortcode = ' communityid="0" ';

		var infinite_check = 'false';
		if( $('#infinite',context).is(":checked") ){
			infinite_check = 'true';
		}
		var bathromms 		= ' bathrooms="' + $('input[name="bath"]',context).val() + '" ';
		var bedrooms 		= ' bedrooms="' + $('input[name="bed"]',context).val() + '" ';
		var min_listprice 	= ' min_listprice="' + $('input[name="min_price"]',context).val() + '" ';
		var max_listprice 	= ' max_listprice="' + $('input[name="max_price"]',context).val() + '" ';
		var property_status = ' property_status="' + $('#search_status',context).val() + '" ';
		var property_type	= ' property_type="' + $('#search_type',context).val() + '" ';
		var transaction 	= ' transaction="' + $('#transaction',context).val() + '" ';
		var limit 			= ' limit="' + $('input[name="limit"]',context).val() + '" ';
		var infinite 		= ' infinite="' + infinite_check + '" ';
		var template_path 	= ' template="' + $('#template',context).val() + '" ';
		var col_grid 		= ' col="' + $('input[name="col"]',context).val() + '" ';

		$(loc_data).each(function(k, v) {
			if( v.type == 'city' ){
				city_id += v.value +',';
			}
			if( v.type == 'community' ){
				community_id += v.value +',';
			}
		});

		city_shortcode 		= ' cityid="'+city_id.replace(/,+$/,'')+'" ';
		community_shortcode = ' communityid="'+community_id.replace(/,+$/,'')+'" ';
		shortcode = '[crm_list_properties'
						+ city_shortcode
						+ community_shortcode
						+ bathromms
						+ bedrooms
						+ min_listprice
						+ max_listprice
						+ property_status
						+ property_type
						+ transaction
						+ limit
						+ template_path
						+ col_grid
						+ infinite
					+ ']';
		editor.selection.setContent(shortcode);
		editor.windowManager.close();
		e.preventDefault();
	});
</script>
