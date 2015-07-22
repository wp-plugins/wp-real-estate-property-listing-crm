<div id="my-account" class="user-id-">
	<div class="row">
		<div class="col-md-2 col-xs-12">
			<ul class="nav nav-pills nav-stacked">
				<li role="presentation" class="<?php //echo ($active == 'profile') ? 'active':'';?>">
					<a href="#">Profile</a>
				</li>
				<li role="presentation" class="<?php //echo ($active == 'favorites') ? 'active':'';?>">
					<a href="#">Favorites</a>
				</li>
			</ul>
		</div>
		<div class="col-md-10 col-xs-12">
			<?php
				if( has_filter('dashboard_profile') ){
					//apply_filters('dashboard_profile', $profile_args);
				}
			?>
		</div>
	</div>
</div>
