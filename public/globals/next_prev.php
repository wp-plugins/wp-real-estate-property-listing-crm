<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<nav>
  <ul class="pager">
	<?php if($next_prev_data['show_prev_url']){ ?>
		<li class=""><a href="<?php echo $next_prev_data['prev_url'];?>"><span aria-hidden="true">&larr;</span> <?php echo _label('prev');?></a></li>
    <?php } ?>
    <?php if($next_prev_data['show_next_url']){ ?>
		<li class=""><a href="<?php echo $next_prev_data['next_url'];?>"><?php echo _label('next');?> <span aria-hidden="true">&rarr;</span></a></li>
    <?php } ?>
  </ul>
</nav>
