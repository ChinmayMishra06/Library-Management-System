<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>		
<div class="row">
	<div class="offset-sm-2 col-sm-8">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">New Member</h4>
			</div>
			<div class="card-body">
				<?php if($this->session->flashdata('member_register_message')): ?>
					<div class="alert alert-<?php if($this->session->flashdata('member_register_status')): echo $this->session->flashdata('member_register_status'); ?> alert-dismissible"><?= $this->session->flashdata("member_register_message"); endif; ?>
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
				<?php endif; ?>
				<?= form_open_multipart("member/register_check", ["id"=>"member_registration_form", "name"=>"member_registration_form"]); ?>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="member_name">Name</label>
								<input type="text" name="member_name" id="member_name" class="form-control" value="<?php echo set_value('member_name'); ?>">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="member_contact">Contact</label>
								<input type="text" name="member_contact" id="member_contact" class="form-control" value="<?php echo set_value('member_contact'); ?>">
							</div>						
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="member_email">Email</label>
								<input type="text" name="member_email" id="member_email" class="form-control" value="<?php echo set_value('member_email'); ?>">
							</div>						
						</div>
						<div class="col">
							<div class="form-group">	
								<label for="member_zip">Zip</label>
								<input type="text" name="member_zip" id="member_zip" class="form-control" value="<?php echo set_value('member_zip'); ?>">
							</div>						
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="member_city">City</label>
								<input type="text" name="member_city" id="member_city" class="form-control" value="<?php echo set_value('member_city'); ?>">
							</div>						
						</div>
						<div class="col">
							<div class="form-group">	
								<label for="member_state">State</label>
								<input type="text" name="member_state" id="member_state" class="form-control" value="<?php echo set_value('member_state'); ?>">
							</div>						
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">	
								<label for="member_gender">Gender</label>
								<select name="member_gender" id="member_gender" class="form-control">
									<option value="">Gender</option>
									<option value="male">Male</option>
									<option value="female">Female</option>
									<option value="other">Other</option>
								</select>
							</div>
						</div>
						<div class="col">
							<div class="form-group">	
								<label for="member_dob">Date of Birth</label>
								<input type="date" name="member_dob" id="member_dob" class="form-control">
							</div>						
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">	
								<label for="member_doj">Date of Joining</label>
								<input type="date" name="member_doj" id="member_doj" class="form-control">
							</div>
						</div>
						<div class="col">
							<div class="form-group">	
								<label for="member_image">Profile Image</label>
								<input type="file" name="member_image" id="member_image" class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">	
								<label for="member_signature">Signature</label>
								<input type="file" name="member_signature" id="member_signature" class="form-control">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<input type="submit" name="member_register_button" id="member_register_button" class="btn btn-outline-secondary float-right" value="Register">
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
		
		// This will validate member name field for non empty and only character value.
		function member_name(){
			result = required({element_id : "member_name"});
			if(result === true){
				result = allow_only_character({element_id : "member_name"});
				if(result === true){				
					return result;
				}
				return result;
			}
			return result;
		}

		// This will validate member contact field for non empty, minimum and maximum length.
		function member_contact(){
			result = required({element_id : "member_contact"});
			if(result === true){
				result = allow_only_digit({element_id : "member_contact"});
				if(result === true){
					result = min_length({element_id : "member_contact", min_length : 10});
					if(result === true){
						result = max_length({element_id : "member_contact", max_length : 11});
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
		
		// This will validate member email field for non empty and only email value.
		function member_email(){ 
			result = required({element_id : "member_email"});
			if(result === true){
				result = valid_email({element_id : "member_email"});
				if(result === true){				
					return result;
				}
				return result;
			}
			return result;
		}

		// This will validate member zip field for non empty and only zip code value.
		function member_zip(){			
			result = required({element_id : "member_zip"});
			if(result === true){
				result = zip_code({element_id : "member_zip"});
				if(result === true){				
					return result;
				}
				return result;
			}
			return result;
		}

		// This will validate member city field for non empty and only character value.
		function member_city(){ 
			result = required({element_id : "member_city"});
			if(result === true){
				result = allow_only_character({element_id : "member_city"});
				if(result === true){				
					return result;
				}
				return result;
			}
			return result;
		}

		// This will validate member state field for non empty and only character value.
		function member_state(){
			result = required({element_id : "member_state"});
			if(result === true){
				result = allow_only_character({element_id : "member_state"});
				if(result === true){				
					return result;
				}
				return result;
			}
			return result;
		}

		// This will validate member gender field for non empty.
		function member_gender(){ 
			return required({element_id : "member_gender"});			
		}

		// This will validate member dob field for non empty.
		function member_dob(){
			return required({element_id : "member_dob"});			
		}

		// This will validate member doj field for non empty.
		function member_doj(){ 
			return required({element_id : "member_doj"});			
		}

		// This will validate member image field for non empty and only for jpeg, jpg, png, gif, and bmp files.
		function member_image(){ 
			result = required({element_id : "member_image"});
			if(result === true){
				result = allow_file_type({element_id : "member_image", extension : ["jpeg", "jpg", "png", "gif", "bmp"]});
				if(result === true){
					return result;
				}
				return result;		
			}
			return result;
		}

		// This will validate member signature field for non empty and only for jpeg, jpg, png, gif, and bmp files.
		function member_signature(){ 
			result = required({element_id : "member_signature"});
			if(result === true){
				result = allow_file_type({element_id : "member_signature", extension : ["jpeg", "jpg", "png", "gif", "bmp"]});
				if(result === true){
					return result;
				}
				return result;		
			}
			return result;
		}

		// This will attach element with event handler for validating the fields.
		document.getElementById("member_name").addEventListener('blur', member_name);
		document.getElementById("member_contact").addEventListener('blur', member_contact);
		document.getElementById("member_email").addEventListener('blur', member_email);
		document.getElementById("member_zip").addEventListener('blur', member_zip);
		document.getElementById("member_city").addEventListener('blur', member_city);
		document.getElementById("member_state").addEventListener('blur', member_state);
		document.getElementById("member_gender").addEventListener('blur', member_gender);
		document.getElementById("member_dob").addEventListener('blur', member_dob);
		document.getElementById("member_doj").addEventListener('blur', member_doj);
		document.getElementById("member_image").addEventListener('blur', member_image);
		document.getElementById("member_signature").addEventListener('blur', member_signature);
		document.getElementById("member_registration_form").addEventListener('submit', function(e){
			e.preventDefault();
			
			// This variable is used to store the validate_form function result.
			var form_submit_result;
			
			// If form_submit_result will be true, then member_registration_form will be submitted, else not.			
			form_submit_result = validate_form([
				member_name, member_contact, member_email, member_zip,
				member_city, member_state, member_gender, member_dob,
				member_doj, member_image, member_signature
			]);
			if(form_submit_result === true){
				document.getElementById("member_registration_form").submit();
			}
		});
	</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>