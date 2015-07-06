<div class="favorite-dashboard">
	<?php
		if( has_filter("content_favorite") ){
			apply_filters("content_favorite",$args);
		}
	?>
</div>
<div class="xout-dashboard">
	<?php
		if( has_filter("content_xout") ){
			apply_filters("content_xout", $args);
		}
	?>
</div>
