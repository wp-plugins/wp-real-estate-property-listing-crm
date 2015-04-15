<div class="child-location">
	<div class="row">
		<?php if( $atts['show_child'] ){ ?>
			<div class="col-md-12 property-item">
				<?php if( $child_details['child_label'] != '' ){ ?>
				<h4>Search by <?php echo $child_details['child_label']; ?></h4>
				<?php } ?>
				<?php if(count($child_details['data']) > 0) { ?>
						<ul class="child_list list-unstyled">
							<?php foreach($child_details['data'] as $key=>$val){ ?>
									<li><a href="<?php echo $val['url'];?>"><?php echo $val['name'];?></a></li>
							<?php } ?>
						</ul>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</div>
<div>
<?php require $list_template; ?>
</div>
