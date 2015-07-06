<div id="my-account" class="user-id-">
	<div class="row">
		<div class="col-md-2 col-xs-12">
			<?php \Account_Dashboard::get_instance()->navigation($action_args); ?>
		</div>
		<div class="col-md-10 col-xs-12">
			<div class="content-dashboard-before">
				<?php
					if( has_filter("dashboard_content_{$action}_before") ){
						apply_filters("dashboard_content_{$action}_before", $action_args);
					}
				?>
			</div>
			<div>
			<?php
				if( has_filter("dashboard_content_{$action}") ){
					apply_filters("dashboard_content_{$action}", $action_args);
				}
			?>
			</div>
			<div class="content-dashboard-after">
				<?php
					if( has_filter("dashboard_content_{$action}_after") ){
						apply_filters("dashboard_content_{$action}_after", $action_args);
					}
				?>
			</div>
		</div>
	</div>
</div>
