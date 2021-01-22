<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
?>		
<div class="row">
	<div class="col-sm-4 form-center">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">Login Panel</h4>
			</div>
			<div class="card-body">
				<?php if($this->session->flashdata('login_message')): ?>
					<div class="alert alert-<?php if($this->session->flashdata("login_status")): echo $this->session->flashdata("login_status"); endif; ?> alert-dismissible"><?= $this->session->flashdata("login_message"); ?>
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
				<?php endif; ?>

				<?php if($this->session->flashdata('logout_message')): ?>
					<div id="logout_message" class="alert alert-success alert-dismissible"><?= $this->session->flashdata("logout_message"); ?>
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
				<?php endif; ?>				
				<?= form_open('librarian/login_check', ["id"=>"login_form", "name"=>"login_form"]); ?>
					<div class="form-group">
						<label for="login_email">Username</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text"><i class="fa fa-envelope"></i></div>
							</div>
							<input type="text" name="librarian_email" id="librarian_email" class="form-control" value="chinmaymishra.falna@gmail.com">
						</div>
					</div>
					<div class="form-group">
						<label for="login_password">Password</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text"><i class="fa fa-key"></i></div>
							</div>
							<input type="password" name="librarian_password" id="librarian_password" class="form-control" value="password">
							<!-- <div class="input-group-append">
								<div class="input-group-text"><i class="fa fa-eye"></i></div>
							</div> -->
						</div>						
					</div>
					<div class="form-group">
						<a href="<?= base_url('index.php/librarian/forgot_password'); ?>">Forgot Password?</a>
						<input type="submit" name="librarian_login_button" id="librarian_login_button" class="btn btn-outline-secondary float-right" value="Login">
					</div>
				<?= form_close(); ?>				
			</div>
		</div>
	</div>
</div>
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
	<script>
		"use strict";

		// This will will center the form center on window loading.
		window.addEventListener("load", function(e){
			center_form();
		});
		
		// This will will center the form center on resizing window.
		window.addEventListener("resize", function(){
			center_form();
		});

		// This variable is used to store the result of validation function.
		var result;		
		
		// This will validate librarian email field for non empty and only email value.
		function librarian_email(){ 
			result = required({element_id : "librarian_email"});
			if(result === true){
				result = valid_email({element_id : "librarian_email"});
				if(result === true){
					return result;
				}
				return result;
			}
			return result;
		}

		// This will validate librarian password field for non empty.
		function librarian_password(){
			return required({element_id : "librarian_password"});
		}

		// This will attach element with event handler for validating the fields.
		document.getElementById("librarian_email").addEventListener('blur', librarian_email);
		document.getElementById("librarian_password").addEventListener('blur', librarian_password);
		document.getElementById("login_form").addEventListener('submit', function(e){
			e.preventDefault();
	
			// This variable is used to store the valiate_form function result.
			var form_submit_result;
			
			// This variable is used to store the login_form function result.
			form_submit_result = validate_form([librarian_email, librarian_password])
			if(form_submit_result === true){
				document.getElementById("login_form").submit();
			}
		});
	</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>