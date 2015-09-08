<form name="md_api" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="action" value="update_api">
	<?php
		if( get_option('md_finish_install') ){
			$log = \Create_Location_Page::get_instance()->get_option_log();

			if( !$log && count($log) == 0 ){
				echo '<h2>Create page by location now, <a href='.admin_url('admin.php?page=md-api-create-page-location').'>Click this link</a></h2>';
			}
		}
	?>
	<div class="wrap">
		<table class="form-table">
			<tbody>
				<?php if( !$setting && get_option('md_not_finish_install') ){ ?>
				<tr>
					<th scope="row"><label for="property_data_feed"><span style="font-weight:bold;color:red;">Choose property status</span></label></th>
					<td>
						<select name="setting[search_criteria][status]">
							<?php foreach($property_status as $key => $val){ ?>
									<option value="<?php echo $key;?>"><?php echo $val;?></option>
							<?php } ?>
						</select>
						<p style="font-style:italic;color:red;">choose property status to finish installation</p>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<th scope="row"><label for="property_data_feed">Property Data Feed</label></th>
					<td>
						<select name="property_data_feed">
							<option value="0">Select Data Feed</option>
							<option value="crm" <?php echo (get_option( 'property_data_feed' ) == 'crm') ? 'selected':''; ?>>CRM</option>
							<option value="mls" <?php echo (get_option( 'property_data_feed' ) == 'mls') ? 'selected':''; ?>>MLS</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="api_key"><?php _e("API KEY: " ); ?></label></th>
					<td><input type="text" name="api_key" value="<?php echo get_option( 'api_key' );?>" style="width:100%;"></td>
				</tr>
				<tr>
					<th scope="row"><label for="api_token"><?php _e("API TOKEN: " ); ?></label></th>
					<td><input type="text" name="api_token" value="<?php echo get_option( 'api_token' );?>" style="width:100%;"></td>
				</tr>
				<tr>
					<th scope="row"><label for="broker_id"><?php _e("Broker ID: " ); ?></label></th>
					<td><input type="text" name="broker_id" value="<?php echo get_option( 'broker_id' );?>" style="width:100%;"></td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php _e('Update', 'update_api' ) ?>" />
		</p>

	</div>
</form>
