<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
?>		
<div class="row">
	<div class="col-sm-4 form-center" id="forgot_password_panel">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">Forgot Password</h4>
			</div>
			<div class="card-body">
				<?php if($this->session->flashdata('forgot_password_message')): ?>
					<div class="alert alert-danger alert-dismissible"><?= $this->session->flashdata("forgot_password_message"); ?>
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
				<?php endif; ?>			
				<?= form_open('librarian/forgot_password_check', ["id"=>"forgot_password_form", "name"=>"forgot_password_form"]); ?>
					<div class="form-group">
						<label for="forgot_email">Email</label>
						<input type="text" name="forgot_email" id="forgot_email" class="form-control" value="<?php echo set_value('forgot_email'); ?>">
					</div>
					<div class="form-group">
						<a href="<?= base_url('index.php/librarian/login_view'); ?>">Login?</a>
						<input type="submit" name="forgot_password_button" id="forgot_password_button" class="btn btn-outline-secondary float-right" value="Forgot">
					</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
<script>
	"use strict";

	var result;

	// This will will center the form center on window loading.
	window.addEventListener("load", function(e){
		center_form();
	});
	
	// This will will center the form center on resizing window.
	window.addEventListener("resize", function(){
		center_form();
	});

	// This will validate librarian email field for non empty and only email value.
	function forgot_email(){ 
		result = required({element_id : "forgot_email"});
		if(result === true){
			result = valid_email({element_id : "forgot_email"});
			if(result === true){
				return result;
			}
			return result;
		}
		return result;
	}

	// This will attach element with event handler for validating the fields.
	document.getElementById("forgot_email").addEventListener('blur', forgot_email);
	document.getElementById("forgot_password_form").addEventListener('submit', function(e){
		e.preventDefault();
		
		// This variable is used to store the valiate_form function result.
		var form_submit_result;
		
		// This variable is used to store the forgot_password_form function result.
		form_submit_result = validate_form([forgot_email])
		if(form_submit_result === true){
			document.getElementById("forgot_password_form").submit();
		}
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>