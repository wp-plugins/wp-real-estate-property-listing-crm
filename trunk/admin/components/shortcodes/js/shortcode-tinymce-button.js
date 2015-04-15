(function() {
	tinymce.create('tinymce.plugins.MDshortcode', {
          init : function(editor, url) {
					var list_menu = [
						{
							text:'CRM Property',
							menu:[
								crm_list_properties(editor),
								crm_featured_properties(editor),
								crm_single_property(editor),
							]
						},
						{
							text:'MLS Property',
							menu:[
								mls_list_properties(editor),
								mls_single_property(editor),
							]
						},
						{
							text:'Masterdigm Property Utility',
							menu:[
								md_list_properties_by(editor),
								md_search_form(editor),
								md_search_result(editor),
								md_single_property(editor),
							]
						},
					];

					if( has_crm_key == 0 ){
						list_menu[0] = {text:'NO API - CRM',menu:[]};
					}
					if( has_mls_key == 0 ){
						list_menu[1] = {text:'NO API - MLS',menu:[]};
					}
					if( has_crm_key == 0 ){
						list_menu[2] = {text:'NO API - CRM or MLS',menu:[]};
					}
					editor.addButton('mdshortcodes', {
						type: 'menubutton',
						icon: false,
						text: menu_button_label,
						menu: list_menu
					});
          },
          createControl : function(n, cm) {
               return null;
          }
     });
	/* Start the buttons */
    tinymce.PluginManager.add('mdshortcodes', tinymce.plugins.MDshortcode );

})();
