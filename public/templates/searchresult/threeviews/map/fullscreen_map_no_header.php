<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php echo isset($_GET['location']) ? $_GET['location']:'Full Screen'; ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
	<style>
		html, body, #map-canvas{
			height:100%;
			margin: 0;
			padding: 0;
			min-width:100% !important
		}
		#tools{
		    z-index: 1;
			float: right;
			height: 100%;
			position: absolute;
			right: 0px;
			background-color: #808080;
			top: 0;
		}
		.show_tools{
			width: 25%;
		}
		.hide_tools{
			width: 0px;
			padding:0;
		}
		.btn-toggle-sidebar{
			float: right;
			padding: 10px;
			z-index: 1;
			position: absolute;
			top: 50%;
			right:100%;
		}
		.container-siderbar-map{
			margin: 10px 0px;
			width:100%;
			overflow-y:auto;
			overflow-x:hidden;
			height:90%;
		}
		.no-padding{
			padding:0px !important;
		}
		.sidemap-properties{
			padding:10px;
		}
		#sidebar-properties .property-item .thumbnail a > img {
			height:100px;
			min-height: 0;
			width:70%;
		}
		#header-nav{
			height:20%;
			position:relative;
			background:yellow;
		}
	</style>
</head>
<body class="fullscreen-map">
	<div id="header-nav"></div>
	<div id="tools" class="container-fluid hide_tools">
		<button class="btn btn-primary btn-toggle-sidebar">Toggle Sidebar</button>
		<div class="container-siderbar-map col-height">
			<div class="sidemap-properties" id="sidebar-properties">
				<div class="msg"></div>
				<?php $col = 12; ?>
				<?php foreach(have_properties() as $property ){ //loop start have_properties() ?>
					<?php set_loop($property); ?>
					<div class="<?php echo md_property_id();?>-sidebar property-list" data-property-id="<?php echo md_property_id();?>" id="<?php echo md_property_id();?>">
						<div class="center" style="display:none;float: none;margin-left:auto;margin-right:auto;text-align:center;"><a href="javascript:void(0)" class="btn btn-default btn-xs trigger" data-property-id="<?php echo md_property_id();?>">Show This on Map</a></div>
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
	<div id="map-canvas" class="map-canvas"></div>
</body>
<footer>
	<?php wp_footer(); ?>
	<script>
		jQuery(document).ready(function(){
			jQuery('.btn-toggle-sidebar').click(function(){
				jQuery('#tools').toggleClass('show_tools hide_tools');
			});
		});
	</script>
</footer>
