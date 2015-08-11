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
</style>
<div id="masterdigm-map-container">
	<div class="container-fluid">
		<div class="" style="margin:0 10px;">
			<?php if(isset($map_fullscreen)){ ?>
					<?php echo do_shortcode('[md_sc_search_property_form template="searchform/search-form-minimal.php" ]'); ?>
			<?php } ?>
		</div>
		<div class="btn-group"><?php \Save_Search::get_instance()->display_button($atts); ?></div>
		<div class="btn-group">
			<?php if(!isset($map_fullscreen) || !$map_fullscreen){ ?>
				<a href="<?php echo md_search_uri_query('view=map&fullscreen=y');?>" class="btn btn-primary modalfullscreen" data-url="<?php echo md_search_uri_query('view=map&fullscreen=y');?>">
					<span class="glyphicon glyphicon-fullscreen" aria-hidden="true" ></span> Show Map Full Screen
				</a>
			<?php }else{ ?>
				<a href="<?php echo md_search_uri_query('view=map&fullscreen=n');?>" class="btn btn-primary modalfullscreen" data-url="<?php echo md_search_uri_query('view=map&fullscreen=y');?>">
					<span class="glyphicon glyphicon-fullscreen" aria-hidden="true" ></span> Show normal map screen
				</a>
			<?php } ?>
		</div>
	</div>
	<div id="map-container" class="row">
		<div class="col-lg-3 col-md-3 col-xs-12 no-padding">
			<div class="container-siderbar-map col-height">
				<div class="sidemap-properties" id="sidebar-properties">
					<div class="msg"></div>
					<?php $col = 12; ?>
					<?php foreach(have_properties() as $property ){ //loop start have_properties() ?>
						<?php set_loop($property); ?>
						<div class="<?php echo md_property_id();?>-sidebar property-list" data-property-id="<?php echo md_property_id();?>" id="<?php echo md_property_id();?>">
							<div class="center" style="float: none;margin-left:auto;margin-right:auto;text-align:center;"><a href="javascript:void(0)" class="btn btn-default btn-xs trigger" data-property-id="<?php echo md_property_id();?>">Show This on Map</a></div>
							<?php
								$list_part = \MD_Template::get_instance()->load_template('list/default/part-list.php');
								require $list_part;
							?>
						</div>
					<?php }//loop end have_properties() ?>
					<?php md_pagination('',2,get_ret_properties()->total); ?>
				</div>
			</div>
		</div>
		<div class="col-lg-9 col-md-9 col-xs-12 no-padding">
			<div class="container-fluid col-height">
				<div id="map-canvas" class="map-canvas"></div>
			</div>
		</div>
	</div>
</div>
