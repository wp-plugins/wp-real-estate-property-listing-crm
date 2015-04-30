<div class="content-help">
	<p></p>
</div>
<h2>
	Provide social api credentials.
</h2>
<form id="post" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" name="post">
	<input type="hidden" name="action" value="update">
	<?php if($obj->getError()){ ?>
		<div class="error">
			<ul>
				<?php foreach($obj->getError() as $val) { ?>
						<li><p class="error"><?php echo $val;?></p></li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
	<div>
		<p>Facebook APP ID</p>
		<input type="text" name="socialapi[facebook][id]" value="<?php echo $obj->getSocialApiByKey('facebook','id');?>" style="width:60%;">
		<p>Facebook APP Secret token</p>
		<input type="text" name="socialapi[facebook][secret]" value="<?php echo $obj->getSocialApiByKey('facebook','secret');?>" style="width:60%;">
	</div>
	<div>
		<p>Google APP ID</p>
		<input type="text" name="socialapi[google][id]" value="<?php echo $obj->getSocialApiByKey('google','id');?>" style="width:60%;">
		<p>Google APP Secret token</p>
		<input type="text" name="socialapi[google][secret]" value="<?php echo $obj->getSocialApiByKey('google','secret');?>" style="width:60%;">
	</div>
	<p><button type="submit" name="add">Update</button></p>
</form>
