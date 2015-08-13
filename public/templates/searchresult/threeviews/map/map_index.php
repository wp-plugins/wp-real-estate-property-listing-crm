<style>
#masterdigm-map-container{
width:98%;
margin:5px;
padding:5px;
}
.col-height{
height:700px;
}
.container-fluid {
position:relative;
padding:0px !important;
top:0  !important;
}
#map-canvas {
width:100%;
height:100%;
position:absolute;
}
.container-siderbar-map{
width:100%;
overflow-y:auto;
overflow-x:hidden;
}
.no-padding{
padding:0px !important;
}
.sidemap-properties{
padding:10px;
}
.container-siderbar-map{
	position:absolute;
	z-index:1;
	background:#777;
}
.btn-toggle-sidebar{
	padding: 10px;
	z-index: 1;
	position: absolute;
	top: 0;
	right:100%;
}
.show_tools{
	width: 25%;
}
.hide_tools{
	width: 0px;
	padding:0;
}
</style>
<div id="masterdigm-map-container">
	<div class="container-fluid">
		<div class="" style="margin:0 10px;">
			<?php if(is_fullscreen() == 'y'){ ?>
					<?php echo do_shortcode('[md_sc_search_property_form template="searchform/search-form-minimal.php" ]'); ?>
					<?php
					$show_sort = true;
					show_search_result_tools($atts, $show_sort);
					?>
			<?php } ?>
		</div>
	</div>
	<div id="map-container" class="row">
		<div class="col-md-3 col-xs-6 col-sm-6 no-padding col-sidebar pull-right">
			<button class="btn btn-primary btn-toggle-sidebar pull-right">Toggle Sidebar</button>
			<div class="container-siderbar-map col-height">
				<div class="sidemap-properties" id="sidebar-properties">
					<div class="msg"></div>
					<?php $col = 12; ?>
					<?php foreach(have_properties() as $property ){ //loop start have_properties() ?>
						<?php set_loop($property); ?>
						<div class="<?php echo md_property_id();?>-sidebar property-list" data-property-id="<?php echo md_property_id();?>" id="<?php echo md_property_id();?>">
							<!--<div class="center" style="float: none;margin-left:auto;margin-right:auto;text-align:center;"><a href="javascript:void(0)" class="btn btn-default btn-xs trigger" data-property-id="<?php //echo md_property_id();?>">Show This on Map</a></div>-->
							<?php
								$list_part = \MD_Template::get_instance()->load_template('list/default/part-photo-list.php');
								require $list_part;
							?>
						</div>
					<?php }//loop end have_properties() ?>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-xs-12 no-padding">
			<div class="container-fluid col-height">
				<div id="map-canvas" class="map-canvas"></div>
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function(){
		jQuery('.btn-toggle-sidebar').click(function(){
			jQuery('.col-sidebar').toggleClass('hide_tools');
		});
	});
</script>
