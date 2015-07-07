<div class="single-property-carousel md-container">
	<?php
		if( has_filter('template_carousel_'.get_single_property_source()) ){
			apply_filters('template_carousel_'.get_single_property_source(), $atts);
		}else{
			//display default - crm
			md_global_carousel_template($atts);
		}
	?>
</div>
<div class="listing-info">
	<h2><span>Listing Information</span></h2>
	<?php
		do_action('before_more_details_'.get_single_property_source());
		do_action('template_more_details_'.get_single_property_source(), $atts);
		do_action('after_more_details_'.get_single_property_source());
	?>
</div>
