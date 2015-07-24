<div class="wrap">
	<div class="content-help">
		<p></p>
	</div>
	<h2>
		Breadcrumb Url
		<a
			class="add-new-h2"
			href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&action=add">
			Add New Filter
		</a>
	</h2>
	<div class="list-url">
		<?php if( count($url) > 0 ){ ?>
				<table class="wp-list-table widefat fixed pages">
					<thead>
						<tr>
							<th>
								<span>Filter Label</span>
							</th>
							<th>
								<span>Attach to page</span>
							</th>
							<th>
								<span>Location filter</span>
							</th>
							<th>
								<span>Action</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($url as $key=>$val){ ?>
								<?php $nonce = wp_create_nonce( $val->page_id ); ?>
								<tr>
									<td>
										<?php echo $val->filter_name;?>
									</td>
									<td>
										<?php $page_details = get_post($val->page_id); ?>
										<?php if($page_details){ ?>
												<a href="<?php echo get_permalink($val->page_id);?>" title="Click to view url"><?php echo $page_details->post_title;?></a>
										<?php } ?>
									</td>
									<td>
										<?php echo $val->filter_location_search;?>
									</td>
									<td>
										<a href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&action=edit&id=<?php echo $val->page_id;?>">Edit</a> |
										<a href="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>&action=delete&id=<?php echo $val->page_id;?>&_wpnounce=<?php echo $nonce;?>">Delete</a>
									</td>
								</tr>
						<?php } ?>
					</tbody>
				</table>
		<?php } ?>
	</div>
</div>
