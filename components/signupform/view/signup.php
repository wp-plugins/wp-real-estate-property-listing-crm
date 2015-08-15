<!-- Modal -->
<?php //if( have_properties() ){ ?>
<div class="modal fade register-modal" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="register-modal-revealLabel">No Account Yet? Sign Up Now!</h4>
	  </div>

      <div class="modal-body">
		<?php require \Signup_Form::get_instance()->get_template_form(); ?>
      </div>

      <div class="modal-footer">
		<button type="button" class="btn btn-primary closemodal" data-dismiss="modal">Close</button>
      </div>

    </div>
   </div>
</div>
<?php //} ?>
