<!-- Single button -->
<div class="btn-group butonactions ">
  <a role="button" class="btn btn-default dropdown-toggle btn-xs <?php echo $class;?>" data-toggle="dropdown" aria-expanded="false">
    <?php echo $label;?> <span class="caret"></span>
  </a>
  <ul class="dropdown-menu" role="menu">
    <li><a class="send-to-friend" href="javascript:void(null)" data-property-id="<?php echo $property_id;?>" data-property-url="<?php echo $url;?>" data-property-address="<?php echo $address;?>">Email to friend</a></li>
  </ul>
</div>
