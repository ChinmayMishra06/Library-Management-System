<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="offset-sm-4 col-sm-4" id="subscriber_registration_card">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">New Subscriber</h4>
			</div>
			<div class="card-body">
				<?php if($this->session->flashdata('subscriber_register_message')): ?>
					<div class="alert alert-<?php if($this->session->flashdata('subscriber_register_status')): echo $this->session->flashdata('subscriber_register_status'); ?> alert-dismissible"><?= $this->session->flashdata("subscriber_register_message"); endif; ?>
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
				<?php endif; ?>
				<?= form_open('subscriber/register_check', ["id"=>"subscriber_registration_form"]); ?>
					<input type="hidden" name="member_contact" id="member_contact" value="">
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="member_name">Member Name</label>
								<input type="text" list="member_name_datalist" name="member_name" id="member_name" class="form-control">
								<datalist id="member_name_datalist"></datalist>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="plan_name">Plan Name</label>
								<input type="text" list="plan_name_datalist" name="plan_name" id="plan_name" class="form-control">
								<datalist id="plan_name_datalist"></datalist>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="pay_mode">Pay Mode</label>
								<select type="text" name="pay_mode" id="pay_mode" class="form-control">
									<option value="">Pay Mode</option>								
									<option value="online">Online</option>
									<option value="offline">Offline</option>
								</select>
								<?php if(validation_errors()): echo form_error('pay_mode'); endif; ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<input type="submit" name="subscriber_register_button" id="subscriber_register_button" class="btn btn-outline-secondary float-right" value="Register">
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
	
	// This variable is used to store the validation result
	var result;

	// This code will separate the member name and contact details with each other.
	document.getElementById('member_name').addEventListener('change', function(e){
		e.preventDefault();
		document.getElementById('member_contact').value = document.getElementById('member_name').value.split(',')[1].trim();
		document.getElementById('member_name').value = document.getElementById('member_name').value.split(',')[0].trim();
	});			
	
	// This will make an ajax request to get member name according to keyup event of subscriber registration form's member name column.
	document.getElementById('member_name').addEventListener('keyup', function(e){
		e.preventDefault();

		// This variable is used to store the member name, filled on the subscriber registration form's member name column.
		let member_name = document.getElementById('member_name').value;

		// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '<?php echo base_url("index.php/member/member_name"); ?>', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send("member_name=" + member_name);
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4){
				if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
					if(xhr.responseText){

						// newResponse variable is used to store the ajax success result.
						var newResponse = JSON.parse(xhr.responseText);

						// This code will set the member name list to empty string. 
						document.getElementById('member_name_datalist').innerHTML = "";
						if(newResponse.not_found === undefined){
							for(let i=0; i<newResponse.length; i++){
								var new_option = document.createElement('option');
								new_option.value = newResponse[i]['MEMBERNAME'] + ', ' + newResponse[i]['CONTACT'] ;
								document.getElementById('member_name_datalist').appendChild(new_option);
							}
						}
						else{
							// This code will set the status message for 5 seconds to denote the user what type of error occurred.
							// After completion of 5 seconds, status message automatically gets hide.
							let status_message = document.getElementById('status_message');
							status_message.style.display = "block";
							status_message.style.opacity = 1;
							status_message.textContent = newResponse.not_found;
							let status_message_id = setInterval(() => {
								if(status_message.style.opacity > 0){
									status_message.style.opacity -= 0.1;
								}
								else{
									status_message.style.display = "none";
									clearInterval(status_message_id);
								}
							}, 500);
						}						
					}
				}
				else{
					console.log('Request was unsuccessful');
				};
			}
		};
	});

	// This will make an ajax request to get plan name according to keyup event of subscriber registration form's plan name column.
	document.getElementById('plan_name').addEventListener('keyup', function(e){
		e.preventDefault();

		// This variable is used to store the plan name, filled on the subscriber registration form's plan name column.
		let plan_name = document.getElementById('plan_name').value;
		
		// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '<?php echo base_url("index.php/plan/active_plan_name"); ?>', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send("plan_name=" + plan_name);
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4){
				if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
					if(xhr.responseText){
						
						// newResponse variable is used to store the ajax success result.
						var newResponse = JSON.parse(xhr.responseText);
						
						// This code will set the plan name list to empty string. 
						document.getElementById('plan_name_datalist').innerHTML = "";
						if(newResponse.not_found === undefined){
							for(let i=0; i<newResponse.length; i++){
								var new_option = document.createElement('option');
								new_option.value = newResponse[i]['PLANNAME'];
								document.getElementById('plan_name_datalist').appendChild(new_option);
							}
						}
						else{
							// This code will set the status message for 5 seconds to denote the user what type of error occurred.
							// After completion of 5 seconds, status message automatically gets hide.
							let status_message = document.getElementById('status_message');
							status_message.style.display = "block";
							status_message.style.opacity = 1;
							status_message.textContent = newResponse.not_found;
							let status_message_id = setInterval(() => {
								if(status_message.style.opacity > 0){
									status_message.style.opacity -= 0.1;
								}
								else{
									status_message.style.display = "none";
									clearInterval(status_message_id);
								}
							}, 500);
						}
					}
				}
				else{
					console.log('Request was unsuccessful');
				};
			}
		};
	});

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
	
	// This will validate plan name field for non empty and only special character value.
	function plan_name(){
		result = required({element_id : "plan_name"});
		if(result === true){
			result = allow_special_character({element_id : "plan_name"});
			if(result === true){
				return result;
			}
			return result;
		}
		return result;
	}		
		
	// This will validate pay mode field for non empty.
	function pay_mode(){ 
		return required({element_id : "pay_mode"});
	}

	// This will attach element with event handler for validating the fields.
	document.getElementById("member_name").addEventListener('blur', member_name);
	document.getElementById("plan_name").addEventListener('blur', plan_name);
	document.getElementById("pay_mode").addEventListener('blur', pay_mode);
	document.getElementById("subscriber_registration_form").addEventListener('submit', function(e){
		e.preventDefault();
		
		// This variable is used to store the validate_form function result.
		var form_submit_result;
		
		// If form_submit_result will be true, then subscriber_registration_form will be submitted, else not.
		form_submit_result = validate_form([member_name, plan_name, pay_mode]);
		if(form_submit_result === true){
			document.getElementById("subscriber_registration_form").submit();
		}
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>