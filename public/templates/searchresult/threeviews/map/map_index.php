<div id="masterdigm-map-container">
	<div class="container-fluid">
		<div class="" style="margin:0 10px;">
			<?php if(is_fullscreen() == 'y'){ ?>
					<?php echo do_shortcode('[md_sc_search_property_form template="searchform/search-form-minimal.php" ]'); ?>
			<?php } ?>
			<?php
				$show_sort = true;
				show_search_result_tools($atts, $show_sort);
			?>
		</div>
	</div>
	<div id="map-container" class="row">
		<div class="col-md-7 no-padding col-sidebar">
			<div class="container-fluid col-height">
				<div id="map-canvas" class="map-canvas"></div>
			</div>
		</div>
		<div class="col-md-5 no-padding col-map">
			<button class="btn btn-primary btn-toggle-sidebar pull-right hidden">Toggle Sidebar</button>
			<div class="container-siderbar-map col-height">
				<div class="sidemap-properties" id="sidebar-properties">
					<div class="msg alert alert-info" role="alert"></div>
					<div class="ajax-load-properties"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	var urlParams = <?php echo json_encode($_REQUEST, JSON_HEX_TAG);?>;
	jQuery(document).ready(function(){
		var col_map 	= jQuery('.col-map');
		var col_sidebar = jQuery('.col-sidebar');
		var toggle_btn 	= jQuery('.btn-toggle-sidebar');
		function toggle_col_map(col_map, col_sidebar){
			alert(col_sidebar.hasClass('hide_tools'));
			if( col_sidebar.hasClass('hide_tools') ){
				col_map.toggleClass('col-lg-12 col-md-12', 'col-lg-8 col-md-8');
			}else{
				col_map.toggleClass('col-lg-8 col-md-8', 'col-lg-12 col-md-12');
			}
		}
		//toggle_col_map(col_map, col_sidebar);
		toggle_btn.click(function(){
			col_sidebar.toggleClass('hide_tools').promise().done(function(){
				if( col_sidebar.hasClass('hide_tools') ){
					col_map.addClass('col-lg-12 col-md-12');
					col_map.removeClass('col-lg-8 col-md-8');
				}else{
					col_map.addClass('col-lg-8 col-md-8');
					col_map.removeClass('col-lg-12 col-md-12');
				}
			});
		});

	});
</script>
