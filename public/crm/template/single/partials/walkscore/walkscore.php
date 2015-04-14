<script type='text/javascript'>
jQuery(document).ready(function($){
	//jQuery("#walkscore_map").html('<img src="'+MDAjax.ajax_loader_circle+'">');
	jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		if( jQuery(e.target).attr('href') == '#walkscore' ){
			var ws_wsid = '<?php echo WALKSCORE_API;?>';
			var ws_lat= mainLat;
			var ws_lon=mainLng;
			var ws_width = '100%';
			var ws_height = '900px';
			var ws_layout = 'vertical';
			var ws_commute = 't';
			var ws_industry_type = 'travel';
			var ws_transit_score = 't';
			var ws_iframe_css_final = "border: 0";
			var url = 'http://www.walkscore.com/serve-walkscore-tile.php?wsid='+ws_wsid+'0&lat='+ws_lat+'&lng='+ws_lon+'&o='+ws_layout+'&ts='+ws_transit_score+'&c='+ws_commute+'&industry='+ws_industry_type+'&h=900&fh=18&w=700';
			jQuery("#walkscore_map").html('<iframe src="'+url+'" marginwidth="0" marginheight="0" vspace="0" hspace="0" allowtransparency="true" frameborder="0" scrolling="no" width="' + ws_width + '" height="' + ws_height + '" style="' + ws_iframe_css_final + '"></iframe>');
		}
	});
});
</script>
<div id='walkscore_map'>
</div>
