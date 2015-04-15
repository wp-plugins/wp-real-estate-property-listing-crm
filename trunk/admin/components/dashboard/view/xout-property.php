<p><a href="#" class="admin_send_email" title="Send this property to a friend via Email">Email</a></p>
<table class="wp-list-table widefat fixed pages">
  <tbody>
	<?php if( $property['result'] ) { ?>
			<?php foreach( $property as $key_property => $list_property) { ?>
					<?php $objClassProperty->setSource($list_property); ?>
					<tr>
					  <td>
						<div class="property-favorite-container">
							<div class="left-content">
								<div class="single-property-photos single-property-slider">
									<div class="galleria mls-galleria">
										<?php if( count($objClassProperty->getPhotos()) > 0 ){ ?>
											<?php foreach( $objClassProperty->getPhotos() as $photo ){ ?>
												<a href="<?php echo $photo;?>">
													<img
														src="<?php echo $photo;?>",
														data-big="<?php echo $photo;?>"
														data-title=""
														data-description=""
													>
												</a>
											<?php } ?>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="right-content">
								<p>
									<a href="<?php echo $objClassProperty->getObject()->displayUrl()?>">
										<?php echo $objClassProperty->getObject()->displayAddress();?>
									</a>
								</p>
								<div class="details">
									<ul>
										<li>Price: <?php echo $objClassProperty->getPrice();?></li>
										<li>Beds: <?php echo $objClassProperty->getBed();?></li>
										<li>Baths: <?php echo $objClassProperty->getBathroom();?></li>
										<li>Sq.Ft: <?php echo $objClassProperty->getSqFt();?></li>
										<li>Year Built: <?php echo $objClassProperty->getYearBuilt();?></li>
									</ul>
								</div>
								<div class="action-buttons">
									<span>
										<a class="property_xout_remove" data-property-feed="<?php echo $objClassProperty->getFeed();?>" data-property-id="<?php echo $objClassProperty->getID();?>" href="javascript:void(null)">
											Remove
										</a>
									</span>
								</div>
							</div>
						</div>
						<hr>
					  </td>
					</tr>
			<?php } ?>
	<?php }else{ ?>
		<div class="galleria mls-galleria"></div>
	<?php } ?>
  </tbody>
</table>
