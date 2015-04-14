<div id="my-account" class="user-id-<?php echo $current_user->ID;?>">
	<?php
		if( !is_user_logged_in() ){ // is_user_logged_in
			require  $template_signup;
		}else{
	?>
		<div class="row">
			<div class="col-md-4 col-xs-12">
				<ul class="nav nav-pills nav-stacked">
					<li role="presentation" class="<?php echo ($active == 'profile') ? 'active':'';?>">
						<a href="#">Profile</a>
					</li>
					<li role="presentation" class="<?php echo ($active == 'favorites') ? 'active':'';?>">
						<a href="#">Favorites</a>
					</li>
				</ul>
			</div>
			<div class="col-md-8 col-xs-12">

			</div>
		</div>
	<?php
		} //is_user_logged_in
	?>
</div>
