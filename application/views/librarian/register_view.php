<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="offset-sm-2 col-sm-8">
		<div class="card">
			<div class="card-header p-0">			
				<h4 class="text-center text-white">New Librarian</h4>
			</div>
			<div class="card-body">				
				<?php if($this->session->flashdata("register_message")): ?>
					<div class="alert alert-<?php if($this->session->flashdata('register_status')): echo $this->session->flashdata('register_status'); ?> alert-dismissible"><?= $this->session->flashdata("register_message"); endif; ?>
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
				<?php endif; ?>
				<?= form_open_multipart("librarian/register_check", ["id"=>"librarian_registration_form", "name"=>"librarian_registration_form"]); ?>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="librarian_name">Name</label>
								<input type="text" name="librarian_name" id="librarian_name" class="form-control" value="<?php echo set_value('librarian_name'); ?>">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="librarian_contact">Contact</label>
								<input type="text" name="librarian_contact" id="librarian_contact" class="form-control" value="<?php echo set_value('librarian_contact'); ?>">
							</div>						
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="librarian_email">Email</label>
								<input type="text" name="librarian_email" id="librarian_email" class="form-control" value="<?php echo set_value('librarian_email'); ?>">
							</div>						
						</div>
						<div class="col">
							<div class="form-group">	
								<label for="librarian_zip">Zip</label>
								<input type="text" name="librarian_zip" id="librarian_zip" class="form-control" value="<?php echo set_value('librarian_zip'); ?>">
							</div>						
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="librarian_city">City</label>
								<input type="text" name="librarian_city" id="librarian_city" class="form-control" value="<?php echo set_value('librarian_city'); ?>">
							</div>						
						</div>
						<div class="col">
							<div class="form-group">	
								<label for="librarian_state">State</label>
								<input type="text" name="librarian_state" id="librarian_state" class="form-control" value="<?php echo set_value('librarian_state'); ?>">
							</div>						
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">	
								<label for="librarian_gender">Gender</label>
								<select name="librarian_gender" id="librarian_gender" class="form-control">
									<option value="">Gender</option>
									<option value="male">Male</option>
									<option value="female">Female</option>
									<option value="other">Other</option>
								</select>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="librarian_role">Role</label>
								<select name="librarian_role" id="librarian_role" class="form-control">
									<option value="">Role</option>
									<option value="admin">Admin</option>
									<option value="librarian">Librarian</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">	
								<label for="librarian_dob">Date of Birth</label>
								<input type="date" name="librarian_dob" id="librarian_dob" class="form-control">
							</div>						
						</div>
						<div class="col">
							<div class="form-group">	
								<label for="librarian_doj">Date of Joining</label>
								<input type="date" name="librarian_doj" id="librarian_doj" class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">	
								<label for="librarian_image">Profile Image</label>
								<input type="file" name="librarian_image" id="librarian_image" class="form-control">
							</div>						
						</div>						
						<div class="col">						
							<div class="form-group">	
								<label for="librarian_signature">Signature</label>
								<input type="file" name="librarian_signature" id="librarian_signature" class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="offset-sm-6 col">
							<div class="form-group">
								<input type="submit" name="librarian_register_button" id="librarian_register_button" class="btn btn-outline-secondary float-right" value="Register">
							</div>
						</div>
					</div>		
				</form>				
			</div>
		</div>
	</div>
</div>
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
<script>
	"use strict";
	
	// This variable is used to store the result of validaton function
	var result;
	
	// This will validate librarian name field for non empty and only character value.
	function librarian_name(){
		result = required({element_id : "librarian_name"});
		if(result === true){
			result = allow_only_character({element_id : "librarian_name"});
			if(result === true){				
				return result;
			}
			return result;
		}
		return result;
	}		

	// This will validate librarian contact field for non empty, minimum and maximum length.
	function librarian_contact(){
		result = required({element_id : "librarian_contact"});
		if(result === true){
			result = allow_only_digit({element_id : "librarian_contact"});
			if(result === true){
				result = min_length({element_id : "librarian_contact", min_length : 10});
				if(result === true){
					result = max_length({element_id : "librarian_contact", max_length : 11});
					if(result === true){
						return result;
					}
					return result;
				}
				return result;
			}
			return result;
		}
		return result;
	}		
	
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

	// This will validate librarian zip field for non empty and only zip code value.
	function librarian_zip(){			
		result = required({element_id : "librarian_zip"});
		if(result === true){
			result = zip_code({element_id : "librarian_zip"});
			if(result === true){				
				return result;
			}
			return result;
		}
		return result;
	}

	// This will validate librarian city field for non empty and only character value.
	function librarian_city(){ 
		result = required({element_id : "librarian_city"});
		if(result === true){
			result = allow_only_character({element_id : "librarian_city"});
			if(result === true){				
				return result;
			}
			return result;
		}
		return result;
	}

	// This will validate librarian state field for non empty and only character value.
	function librarian_state(){
		result = required({element_id : "librarian_state"});
		if(result === true){
			result = allow_only_character({element_id : "librarian_state"});
			if(result === true){				
				return result;
			}
			return result;
		}
		return result;
	}

	// This will validate librarian gender field for non empty.
	function librarian_gender(){ 
		return required({element_id : "librarian_gender"});			
	}

	// This will validate librarian role field for non empty.
	function librarian_role(){ 
		return required({element_id : "librarian_role"});
	}

	// This will validate librarian dob field for non empty.
	function librarian_dob(){
		return required({element_id : "librarian_dob"});
	}

	// This will validate librarian doj field for non empty.
	function librarian_doj(){ 
		return required({element_id : "librarian_doj"});			
	}

	// This will validate librarian image field for non empty and only for jpeg, jpg, png, gif, and bmp files.
	function librarian_image(){ 
		result = required({element_id : "librarian_image"});
		if(result === true){
			result = allow_file_type({element_id : "librarian_image", extension : ["jpeg", "jpg", "png", "gif", "bmp"]});
			if(result === true){
				return result;
			}
			return result;		
		}
		return result;
	}

	// This will validate librarian signature field for non empty and only for jpeg, jpg, png, gif, and bmp files.
	function librarian_signature(){
		result = required({element_id : "librarian_signature"});
		if(result === true){
			result = allow_file_type({element_id : "librarian_signature", extension : ["jpeg", "jpg", "png", "gif", "bmp"]});
			if(result === true){
				return result;
			}
			return result;		
		}
		return result;
	}

	// This will attach element with event handler for validating the fields.
	document.getElementById("librarian_name").addEventListener('blur', librarian_name);
	document.getElementById("librarian_contact").addEventListener('blur', librarian_contact);
	document.getElementById("librarian_email").addEventListener('blur', librarian_email);
	document.getElementById("librarian_zip").addEventListener('blur', librarian_zip);
	document.getElementById("librarian_city").addEventListener('blur', librarian_city);
	document.getElementById("librarian_state").addEventListener('blur', librarian_state);
	document.getElementById("librarian_gender").addEventListener('blur', librarian_gender);
	document.getElementById("librarian_role").addEventListener('blur', librarian_role);
	document.getElementById("librarian_dob").addEventListener('blur', librarian_dob);
	document.getElementById("librarian_doj").addEventListener('blur', librarian_doj);
	document.getElementById("librarian_image").addEventListener('blur', librarian_image);
	document.getElementById("librarian_signature").addEventListener('blur', librarian_signature);
	document.getElementById("librarian_registration_form").addEventListener('submit', function(e){
		e.preventDefault();
		
		// This variable is used to store the validate_form function result.
		var form_submit_result;
		
		// If form_submit_result will be true, then librarian_registration_form will be submitted, else not.			
		form_submit_result = validate_form([
			librarian_name, librarian_contact, librarian_email, librarian_zip,
			librarian_city, librarian_state, librarian_gender, librarian_role,
			librarian_dob, librarian_doj, librarian_image, librarian_signature
		]);
		if(form_submit_result === true){
			document.getElementById("librarian_registration_form").submit();
		}
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>