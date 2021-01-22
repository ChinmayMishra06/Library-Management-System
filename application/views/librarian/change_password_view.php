<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
?>	
<div class="row">
	<div class="col-sm-4 form-center" id="change_password_panel">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">Change Password</h4>
			</div>
			<div class="card-body">
				<?= form_open(base_url('index.php/librarian/change_password_check'), ["id"=>"change_password_form", "name"=>"change_password_form"]); ?>
				    <input type="hidden" name="forgot_email" id="forgot_email" value="<?= $forgot_email[0]['EMAIL']; ?>"> 
					<div class="form-group">
						<label for="login_email">New Password</label>
						<input type="password" name="new_password" id="new_password" class="form-control">
					</div>
					<div class="form-group">
						<a href="<?= base_url('index.php/librarian/login_view'); ?>">Login?</a>
						<input type="submit" name="change_password_button" id="change_password_button" class="btn btn-outline-secondary float-right" value="Change">
					</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
<script>
	"use strict";
	
	// This variable is used to store the result of validaton function
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
	function change_password(){ 
		result = required({element_id : "change_password"});
		if(result === true){
			result = allow_special_character({element_id : "change_password"});
			if(result === true){
				return result;
			}
			return result;
		}
		return result;
	}

	// This will attach element with event handler for validating the fields.
	document.getElementById("change_password").addEventListener('blur', change_password);
	document.getElementById("change_password_form").addEventListener('submit', function(e){
		e.preventDefault();

		// This variable is used to store the valiate_form function result.
		var form_submit_result;
		
		// This variable is used to store the change_password_form function result.
		form_submit_result = validate_form([change_password])
		if(form_submit_result === true){
			document.getElementById("change_password_form").submit();
		}
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>