<?php if( $count > 0 ){ ?>
<a href="unsubscribe-all?_nonce=<?php echo wp_create_nonce('un-subscribe-all-' . $user_id);?>" class="btn btn-lg <?php echo $class;?>" role="button">
	Un-Subscribe to <span class="badge"><?php echo $count;?></span> Property Alert
</a>
<?php } ?>

