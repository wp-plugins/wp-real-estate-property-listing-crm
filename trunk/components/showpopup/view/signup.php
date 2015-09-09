<!-- Modal -->
<div class="modal fade register-only-modal" id="registerOnlyModal" tabindex="-1" role="dialog" aria-labelledby="registerOnlyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header">
		<?php if( \Settings_API::get_instance()->showpopup_settings('close') == 0 ){ ?>
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<?php } ?>
		<h4 class="modal-title" id="register-modal-revealLabel">Sign-up now, to continue browsing properties</h4>
	  </div>

      <div class="modal-body">
			<?php require \Signup_Form::get_instance()->get_template_form(); ?>
      </div>

      <div class="modal-footer">

      </div>

    </div>
   </div>
</div>
