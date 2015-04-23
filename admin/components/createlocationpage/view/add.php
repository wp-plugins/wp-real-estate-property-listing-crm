<div class="wrap">
	<div class="content-help">
		<h2>
			<span style="color:red;font-weight:bold;">Notice: Please check if you execute this already, if you did,
			check that you wont duplicate pages. See below the last time when you create page by locations</span>
		</h2>
	</div>
	<h2>
		Create Page by Location
	</h2>
	<div id="create_page">
		<div class="content-help">
			<h3>Last Activity : </h3>
			<ul>
				<?php if( isset($log->total) && $log->total > 0 ){ ?>
						<?php foreach($log->data as $key => $val ){ ?>
								<li>
									<p>Date : <?php echo $val->date;?>,
									Total Page created : <?php echo $val->total;?></p>
								</li>
						<?php } ?>
				<?php }else{ ?>
						<li>No last activity, create page now.</li>
				<?php } ?>
			</ul>
		</div>
		<h2><a href="#" class="add-new-h2 click-create-page-location">Click to Create Page by Location</a></h2>
		<div class="indicator"></div>
	</div>
</div>
