<ul class="nav nav-pills nav-stacked">
	<li role="presentation" class="<?php echo ($action == 'profile') ? 'active':'';?>">
		<a href="<?php echo \Account_Profile::get_instance()->url();?>">Profile</a>
	</li>
	<li role="presentation" class="<?php echo ($action == 'favorites') ? 'active':'';?>">
		<a href="<?php echo \Favorites_Property::get_instance()->url();?>">Favorites</a>
	</li>
	<li role="presentation" class="<?php echo ($action == 'xout') ? 'active':'';?>">
		<a href="<?php echo \Xout_Property::get_instance()->url();?>">X-Out</a>
	</li>
	<li role="presentation" class="<?php echo ($action == 'savesearch') ? 'active':'';?>">
		<a href="<?php echo \Dashboard_Save_Search::get_instance()->url();?>">Save Search</a>
	</li>
</ul>
