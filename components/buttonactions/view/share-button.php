<!-- Single button -->
<div class="btn-group butonactions ">
  <a role="button" class="btn btn-default dropdown-toggle btn-xs <?php echo $class;?>" data-toggle="dropdown" aria-expanded="false">
    <?php echo $label;?> <span class="caret"></span>
  </a>
  <ul class="dropdown-menu" role="menu">
    <li><a class="send-to-friend" href="javascript:void(null)" data-property-id="<?php echo $property_id;?>" data-property-url="<?php echo $url;?>" data-property-address="<?php echo $address;?>">Email to friend</a></li>
    <li><a class="share-popup" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url;?>" rel="nofollow" target="_blank">Facebook</a></li>
    <li><a class="share-popup" href="http://twitter.com/intent/tweet?text=Check out this property! <?php echo $url;?>&media=<?php echo isset($media) ? $media:'';?>&description=<?php echo urldecode($address);?>" rel="nofollow" target="_blank">Twitter</a></li>
    <li><a class="share-popup" href="http://pinterest.com/pin/create/button/?url=<?php echo $url;?>&media=<?php echo isset($media) ? $media:'';?>&description=<?php echo urldecode($address);?>" rel="nofollow" target="_blank">Pinterest</a></li>
    <li><a class="share-popup" href="https://plus.google.com/share?url=<?php echo $url;?>" rel="nofollow" target="_blank">Google+</a></li>
  </ul>
</div>
