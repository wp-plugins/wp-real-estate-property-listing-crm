<div id="button-view">
	<div class="btn-group" role="group" aria-label="...">
	  <a class="btn btn-default" href="#" role="button">Map</a>
	  <a class="btn btn-default" href="#" role="button">Grid</a>
	  <a class="btn btn-default" href="#" role="button">List</a>
	</div>
</div>
<div id="view-display">
	<div class="view-display-before">
		<?php
			if( has_filter("view_display_content_{$action}_before") ){
				apply_filters("view_display_content_{$action}_before", $action_args);
			}
		?>
	</div>
	<div class="view-display-content">
	<?php
		if( has_filter("view_display_content_{$action}") ){
			apply_filters("view_display_content_{$action}", $action_args);
		}
	?>
	</div>
	<div class="view-display-before-after">
		<?php
			if( has_filter("view_display_content_{$action}_after") ){
				apply_filters("view_display_content_{$action}_after", $action_args);
			}
		?>
	</div>
</div>
