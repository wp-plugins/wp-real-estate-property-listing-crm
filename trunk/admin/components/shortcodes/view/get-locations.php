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
	<h2>List community locations base on City</h2>

	<div class="ui-widget" id="city_location">
	  <label for="tags">Type Location: </label>
	  <input id="location" name="location" value="">
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
	var context 				= document.getElementsByTagName("body")[0];
	var city_id					= [];

	$(template).each(function(k,v){
		$('#template',context).append('<option value="'+v.value+'">'+v.text+'</option>');
	});

	function get_city_id( sel_loc ) {
		city_id.push({value:sel_loc.item.id});
	}

	$( "#location", context ).autocomplete({
	   minLength: 3,
	   source: autocomplete_location,
	   select:function(event, ui){
		   get_city_id(ui);
		   $('#location',context).val('');
	   }
	});

	$('#insert-shortcode', context).on('click',function(e){
		var shortcode = '';
		var loc_input = $( 'input[name^="loc_"]', context );

		city_shortcode 		= ' cityid="'+city_id[0].value+'" ';
		shortcode = '[crm_get_locations'
						+ city_shortcode
					+ ']';
		editor.selection.setContent(shortcode);
		editor.windowManager.close();
		e.preventDefault();
	});
</script>
