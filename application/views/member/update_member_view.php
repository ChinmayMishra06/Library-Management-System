<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>

		<div class="card">
			<div class="card-header">
			
			</div>
			<div class="card-body">
				
			</div>
		</div>
<div class="container">
	<div class="row">
		<div class="offset-sm-2 col-sm-8 mt-2 well pb-2" id="mem_updation_form">
			<?php if(isset($updated_member_data) && count($updated_member_data) > 0): ?>
				<?php if($this->session->flashdata('member_update_message')): ?>
					<div class="alert alert-<?php if($this->session->flashdata('member_update_status')): echo $this->session->flashdata('member_update_status'); ?> alert-dismissible"><?= $this->session->flashdata("member_update_message"); endif; ?>
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
				<?php endif; ?>
				<?= form_open_multipart("member/update_member_check", ["id"=>"member_updation_form"]); ?>
					<input type="hidden" name="member_id" id="member_id" clss="form-control" value="<?= $updated_member_data[0]['MEMID']; ?>">
					<h1 class="text-center">Member Updation</h1><hr>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="member_name">Name</label>
								<input type="text" name="member_name" id="member_name" class="form-control" value="<?= ucwords(strtolower($updated_member_data[0]['MEMBERNAME'])); ?>">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="member_contact">Contact</label>
								<input type="text" name="member_contact" id="member_contact" class="form-control" value="<?= $updated_member_data[0]['CONTACT']; ?>">
							</div>						
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="member_email">Email</label>
								<input type="text" name="member_email" id="member_email" class="form-control" value="<?= strtolower($updated_member_data[0]['EMAIL']); ?>">
							</div>						
						</div>
						<div class="col">
							<div class="form-group">	
								<label for="member_zip">Zip</label>
								<input type="text" name="member_zip" id="member_zip" class="form-control" value="<?= ucwords(strtolower($updated_member_data[0]['ZIP'])); ?>">
							</div>						
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="member_city">City</label>
								<input type="text" name="member_city" id="member_city" class="form-control" value="<?= ucwords(strtolower($updated_member_data[0]['CITY'])); ?>">
							</div>						
						</div>
						<div class="col">
							<div class="form-group">	
								<label for="member_state">State</label>
								<input type="text" name="member_state" id="member_state" class="form-control" value="<?= ucwords(strtolower($updated_member_data[0]['STATE'])); ?>">
							</div>						
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">	
								<label for="member_gender">Gender</label>
								<select name="member_gender" id="member_gender" class="form-control">
									<option value="">Gender</option>
									<?php if($updated_member_data[0]['GENDER'] === "MALE"): ?>
										<option value="male" selected="selected">Male</option>
										<option value="female">Female</option>
										<option value="other">Other</option>
									<?php elseif($updated_member_data[0]['GENDER'] === "FEMALE"): ?>
										<option value="male">Male</option>
										<option value="female" selected="selected">Female</option>
										<option value="other">Other</option>
									<?php else: ?>
										<option value="male">Male</option>
										<option value="female">Female</option>
										<option value="other" selected="selected">Other</option>
									<?php endif; ?>
								</select>
							</div>
						</div>
						<div class="col">
							<div class="form-group">	
								<label for="member_dob">Date of Birth</label>
								<input type="date" name="member_dob" id="member_dob" class="form-control" value="<?= date($updated_member_data[0]['DOB']); ?>">
							</div>						
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">	
								<label for="member_doj">Date of Joining</label>
								<input type="date" name="member_doj" id="member_doj" class="form-control" value="<?= date($updated_member_data[0]['DOJ']); ?>">
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
								<input type="submit" name="update_member_button" id="update_member_button" class="btn btn-outline-secondary float-right" value="Update">
							</div>
						</div>
					</div>
				<?= form_close(); ?>				
			<?php else: ?>
				<div class="text-center text-danger  font-weight-bold">No data found.</div>
			<?php endif; ?>
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
		if(document.getElementById("member_image").value !== ""){
			result = allow_file_type({element_id : "member_image", extension : ["jpeg", "jpg", "png", "gif", "bmp"]});
			if(result === true){
				return result;
			}
			return result;		
		}
		return true;
	}

	// This will validate member signature field for non empty and only for jpeg, jpg, png, gif, and bmp files.
	function member_signature(){
		if(document.getElementById("member_signature").value !== ""){
			result = allow_file_type({element_id : "member_signature", extension : ["jpeg", "jpg", "png", "gif", "bmp"]});
			if(result === true){
				return result;
			}
			return result;		
		}
		return true;
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
	document.getElementById("member_updation_form").addEventListener('submit', function(e){
		e.preventDefault();

		// This variable is used to store the valiate_form function result.
		var form_submit_result;
		
		// If form_submit_result will be true, then member_updation_form will be submitted, else not.			
		form_submit_result = validate_form([
			member_name, member_contact, member_email, member_zip,
			member_city, member_state, member_gender, member_dob,
			member_doj, member_image, member_signature
		]);
		if(form_submit_result === true){
			document.getElementById("member_updation_form").submit();
		}
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>