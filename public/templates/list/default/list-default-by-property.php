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
<?php
	$template_part = \MD_Template::get_instance()->load_template('list/default/list-default.php');
	if( $template_part ){
		require $template_part;
	}
?>
