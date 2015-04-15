<div class="sort-container <?php echo $class_sort_container;?>" style="margin-bottom:10px;">
	<!-- Sort -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle <?php echo $class_button;?>" data-toggle="dropdown" aria-expanded="false">
		Sort <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu" role="menu" <?php echo $class_dropdown_ul;?>>
		<li><a href="<?php echo '?'.$_SERVER['QUERY_STRING'] . '&orderby=price&order_direction=DESC#search-result-container';?>" class="price-high">Price (Highest)</a></li>
		<li><a href="<?php echo '?'.$_SERVER['QUERY_STRING'] . '&orderby=price&order_direction=ASC#search-result-container';?>" class="price-low">Price (Lowest)</a></li>
		<li><a href="<?php echo '?'.$_SERVER['QUERY_STRING'] . '&orderby=posted_at&order_direction=DESC#search-result-container';?>" class="price-low">Days on Site (Newest)</a></li>
		<li><a href="<?php echo '?'.$_SERVER['QUERY_STRING'] . '&orderby=posted_at&order_direction=ASC#search-result-container';?>" class="price-low">Days on Site (Oldest)</a></li>
	  </ul>
	</div>
</div>
