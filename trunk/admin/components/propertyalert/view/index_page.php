<div class="content-help">
	<p></p>
</div>
<h2>
	Property Alert Settings
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
		<h3>Add Message for successfully un-subscribe </h3>
		<?php wp_editor( $success_editor['content'], $success_editor['editor_id'], $success_editor['settings'] ); ?>
	</div>
	<hr/>
	<div>
		<h3>Add Message for fail un-subscribe </h3>
		<?php wp_editor( $fail_editor['content'], $fail_editor['editor_id'], $fail_editor['settings'] ); ?>
	</div>
	<p><button type="submit" name="add">Update</button></p>
</form>
