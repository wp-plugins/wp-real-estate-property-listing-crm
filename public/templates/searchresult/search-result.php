<?php
/*
Template Name: Search Result - Default Template
*/
?>
<?php show_search_result_tools($atts, $show_sort); ?>
<div id="view-display">
	<div class="view-display-before">
		<?php
			if( has_filter("view_display_content_{$view}_before") ){
				apply_filters("view_display_content_{$view}_before", $atts);
			}
		?>
	</div>
	<div class="view-display-content">
		<?php
			\Search_Result_View::get_instance()->init($atts);
		?>
	</div>
	<div class="view-display-before-after">
		<?php
			if( has_filter("view_display_content_{$view}_after") ){
				apply_filters("view_display_content_{$view}_after", $atts);
			}
		?>
	</div>
</div>
