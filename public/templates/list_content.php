<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}?>
<?php if( $content ){ ?>
<div class="right-sidebar-agent right-sidebar-panel">
	<div class="panel panel-default">
	  <div class="panel-heading">
		<h3 class="panel-title"><?php echo $title;?></h3>
	  </div>
	  <div class="panel-body">
			<div class="action ">
				<?php if( count($post_content) > 0 ){ ?>
						<?php foreach($post_content as $key => $val ){ ?>
							<?php $ID = $val->ID; ?>
							<div class="media">
							  <?php if( $options_content[$ID]['display_featured_img'] == 'on' ){ ?>
								  <div class="media-left">
									<a href="<?php echo get_permalink($ID);?>">
									  <?php echo get_the_post_thumbnail( $ID, 'thumbnail', array('class'=>'media-object alignleft') ); ?>
									</a>
								  </div>
							  <?php } ?>
							  <div class="media-body">
								<a href="<?php echo get_permalink($ID);?>">
									<h4 class="media-heading">
										<?php echo get_the_title( $ID ); ?>
									</h4>
								</a>
								<?php if( $options_content[$ID]['display_content_list'] == 'title_excerpt' ){ ?>
									<p><?php echo \helpers\Text::limit_words(wp_trim_excerpt($val->post_content),15);?></p>
								<?php } ?>
							  </div>
							</div>
						<?php } ?>
				<?php } ?>
				<?php if( count($post_cat_content) > 0 ){ ?>
					<?php foreach($post_cat_content as $key => $val ){ ?>
								<?php $ID = $val->ID; ?>
								<?php
									$cat_id = 0;
									$cat 	= get_the_category($ID);
									foreach($cat as $val_cat){
										if( array_key_exists($val_cat->term_id,$options_category) ){
											$cat_id = $val_cat->term_id;
										}
									}
								?>
								<div class="media">
								  <?php if( $options_category[$cat_id]['display_category_featured_img'] == 'on' ){ ?>
									  <div class="media-left">
										<a href="<?php echo get_permalink($ID);?>">
										  <?php echo get_the_post_thumbnail( $ID, 'thumbnail', array('class'=>'media-object alignleft') ); ?>
										</a>
									  </div>
								  <?php } ?>
								  <div class="media-body">
									<a href="<?php echo get_permalink($ID);?>">
										<h4 class="media-heading">
											<?php echo get_the_title( $ID ); ?>
										</h4>
									</a>
									<?php if( $options_category[$cat_id]['display_category_list'] = 'title_excerpt' ){ ?>
										<p><?php echo \helpers\Text::limit_words(wp_trim_excerpt($val->post_content),15);?></p>
									<?php } ?>
								  </div>
								</div>
							<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>
