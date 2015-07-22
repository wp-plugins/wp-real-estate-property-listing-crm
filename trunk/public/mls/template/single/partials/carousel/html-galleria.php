<?php
/*
Template Name: Carousel - Single, Galleria Script
*/
?>
<style>
#galleria{height:550px;}
/*#galleria .galleria-image-nav-left, body .galleria-image-nav-right {
    background-image: url("<?php echo PLUGIN_PUBLIC_URL;?>galleria/themes/classic/arrows.png") !important;
}*/
.galleria-stage{height:85% !important;}
</style>
<div class="single-property-photos single-property-slider">
	<div class="galleria crm-galleria" id="galleria">
		<?php if( count(get_single_property_photos()) > 0 ){ ?>
			<?php foreach( get_single_property_photos() as $photo ){ ?>
				<a href="<?php echo $photo->url;?>">
					<img
						src="<?php echo $photo->url;?>",
						data-big="<?php echo $photo->url;?>"
						data-title=""
						data-description=""
					>
				</a>
			<?php } ?>
		<?php } ?>
	</div>
</div>
<script>
jQuery(document).ready(function($){
	// Load the classic theme
	Galleria.loadTheme('<?php echo PLUGIN_PUBLIC_URL . 'galleria/themes/classic/galleria.classic.min.js';?>');
	// Initialize Galleria
	Galleria.configure({
		lightbox: true,
		responsive:true,
		imageCrop: true,
		preload:2,
		dummy: '<?php echo PLUGIN_ASSET_URL . 'house.png';?>',
	});
	Galleria.run('#galleria');
});
</script>
