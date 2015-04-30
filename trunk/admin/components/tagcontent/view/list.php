<div class="wrap">
	<div class="content-help">
		<p></p>
	</div>
	<h2>
		Tag Content
		<a
			class="add-new-h2"
			href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&action=add">
			Add New Tag Content
		</a>
	</h2>
	<div class="list-tag-content">
		<?php if( count($listTagContent) > 0 ){ ?>
				<table class="wp-list-table widefat fixed pages">
					<thead>
						<tr>
							<th>
								<span>Property Address / Location</span>
							</th>
							<th>
								<span>Property / Location ( Name / ID )</span>
							</th>
							<th>
								<span>Action</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($listTagContent as $key=>$val){ ?>
								<?php $array_property = unserialize( $val->option_value ); ?>
								<?php $nonce = wp_create_nonce( $array_property['property_id'] ); ?>
								<tr>
									<td>
										<?php echo $array_property['address'];?>
									</td>
									<td>
										<?php echo $array_property['property_id'];?>
									</td>
									<td>
										<a href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&action=edit&id=<?php echo $array_property['property_id'];?>">Edit</a> |
										<a href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&action=delete&id=<?php echo $array_property['property_id'];?>&_wpnounce=<?php echo $nonce;?>">Delete</a>
									</td>
								</tr>
						<?php } ?>
					</tbody>
				</table>
		<?php } ?>
	</div>
</div>
