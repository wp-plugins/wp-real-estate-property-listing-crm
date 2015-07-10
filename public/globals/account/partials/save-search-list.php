<h3>You have (<?php echo count($search_data); ?>) Save Search</h3>
<div class="saved-search">
	<?php if( $has_saved_search ){//if $search_data ?>
		<ul class="list-group list-saved-search">
			<?php foreach($search_data as $key => $val){//foreach $search_data ?>
					<li class="list-group-item" style="text-align:left;background:#eeeeee;">
						<div class="content-saved-search">
							<p>
								<?php if( isset($val['http_referrer']) ){// if http_referrer ?>
										<a href="<?php echo $val['http_referrer'];?>" target="_blank">
											<?php echo $val['save_search_name'];?>
										</a>
								<?php }else{ ?>
										<?php echo $val['save_search_name'];?>
								<?php }// if http_referrer ?>
								- <a href="trash?id=<?php echo $val['md5_save_search_name'];?>&_nonce=<?php echo wp_create_nonce('trash-saved-search-'. $val['md5_save_search_name'] . $user_account->ID);?>" class="btn btn-default btn-xs" role="button">delete</a>
								<?php if( isset($val['subscribed_property_alert']) && $val['subscribed_property_alert'] == 1 ){// if subscribed_property_alert ?>
									- <a href="unsubscribe?id=<?php echo $val['md5_save_search_name'];?>&_nonce=<?php echo wp_create_nonce('unsubscribe-saved-search-'. $val['md5_save_search_name'] . $user_account->ID);?>" class="btn btn-default btn-xs" role="button">Un-Subscribe to property alert</a>
								<?php }elseif(isset($val['subscribed_property_alert']) && $val['subscribed_property_alert'] == 0){ ?>
									- <a href="subscribe?id=<?php echo $val['md5_save_search_name'];?>&_nonce=<?php echo wp_create_nonce('subscribe-saved-search-'. $val['md5_save_search_name'] . $user_account->ID);?>" class="btn btn-default btn-xs" role="button">Subscribe to property alert</a>
								<?php }// if subscribed_property_alert ?>
							</p>
						</div>
					</li>
			<?php }//loop $search_data ?>
		</ul>
	<?php }//if $search_data ?>
</div>
