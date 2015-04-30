<div id="my-account" class="user-id-<?php echo $current_user->ID;?>">
	<?php
		if( !is_user_logged_in() ){ // is_user_logged_in
			require  $template_signup;
		}else{
	?>
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div role="tabpanel">
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
					<li role="presentation"><a href="#favorites" aria-controls="favorites" role="tab" data-toggle="tab">Favorites (<?php echo $num_favorites;?>)</a></li>
					<li role="presentation"><a href="#xout" aria-controls="xout" role="tab" data-toggle="tab">X-Out (<?php echo $num_xout;?>)</a></li>
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="profile">
						<div style="height:10px;"></div>
						<?php require $template_profile; ?>
						<?php require $template_password; ?>
					</div>
					<div role="tabpanel" class="tab-pane" id="favorites">
						<!-- Single button -->
						<div class="btn-group">
						  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							Action <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" role="menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
						  </ul>
						</div>
						<?php require $template_favorites;?>
					</div>
					<div role="tabpanel" class="tab-pane" id="xout">
						<!-- Single button -->
						<div class="btn-group">
						  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							Action <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" role="menu">
							<li><a href="#">Action</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
						  </ul>
						</div>
						<?php require $template_xout;?>
					</div>
				  </div>

				</div>
			</div>
		</div>
	<?php
		} //is_user_logged_in
	?>
</div>
