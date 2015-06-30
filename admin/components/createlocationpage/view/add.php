<div class="wrap">
	<div class="content-help">
	</div>
	<h2>
		Create Page by Location.
	</h2>
	<p style="font-size:15px;"><?php echo $notice;?></p>
	<div id="create_page">
		<div class="content-help">
			<h3>Last Activity : </h3>
			<ul style="height: 150px;overflow-x: hidden;overflow-y: scroll;">
				<?php if( isset($log->total) && $log->total > 0 ){ ?>
						<?php if(isset($log->data) ){ ?>
							<?php foreach($log->data as $key => $val ){ ?>
									<li>
										<p>Date : <?php echo $val->date;?>,
										Total Page created : <?php echo $val->total;?></p>
									</li>
							<?php } ?>
						<?php } ?>
				<?php }else{ ?>
						<li>No last activity, create page now.</li>
				<?php } ?>
			</ul>
		</div>
		<h2>
			<select name="post_status" id="post_status">
				<?php foreach($status as $key => $val ){ ?>
						<option value="<?php echo $key;?>"><?php echo $val;?></option>
				<?php } ?>
			</select>
			<a href="#" class="add-new-h2 click-create-page-location"><?php echo $button;?></a>
		</h2>
		<input type="hidden" name="option_name" id="option_name" value="<?php echo $option_name;?>">
		<input type="hidden" name="default_feed" id="default_feed" value="<?php echo DEFAULT_FEED;?>">
		<div class="indicator"></div>
	</div>
</div>
