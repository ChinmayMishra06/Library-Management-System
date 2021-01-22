<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="alert alert-danger" id="status_message" style="display:none;"></div>
<div class="row">
	<div class="offset-sm-4 col-sm-4">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">Update Subscriber</h4>
			</div>
			<div class="card-body">	
				<?php if($this->session->flashdata('subscriber_update_message')): ?>
					<div class="alert alert-<?php if($this->session->flashdata('subscriber_update_status')): echo $this->session->flashdata('subscriber_update_status'); ?> alert-dismissible"><?= $this->session->flashdata("subscriber_update_message"); endif; ?>
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
				<?php endif; ?>			
				<?php if(isset($updated_subscriber_data) && count($updated_subscriber_data) > 0): ?>
					<?= form_open('subscriber/update_subscriber_check', ["id"=>"subscriber_updation_form"]); ?>
						<input type="hidden" name="subscriber_contact" id="subscriber_contact" value="<?= $updated_subscriber_data[0]['CONTACT']; ?>">
						<input type="hidden" name="subscriber_id" id="subscriber_id" value="<?= $updated_subscriber_data[0]['SUBID']; ?>">
						<div class="row">
							<div class="col">
								<div class="form-group">
									<label for="subscriber_name">Subscriber Name</label>
									<input type="text" list="subscriber_name_datalist" name="subscriber_name" id="subscriber_name" class="form-control" value="<?= $updated_subscriber_data[0]['MEMBERNAME']; ?>">
									<datalist id="subscriber_name_datalist"></datalist>
								</div>
							</div>
						</div>					
						<div class="row">
							<div class="col">
								<div class="form-group">
									<label for="plan_name">Plan Name</label>
									<input type="text" list="plan_name_datalist" name="plan_name" id="plan_name" class="form-control" value="<?= $updated_subscriber_data[0]['PLANNAME']; ?>">
									<datalist id="plan_name_datalist"></datalist>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-group">
									<label for="plan_amount">Amount</label>
									<input type="text" name="plan_amount" id="plan_amount" class="form-control" value="<?= $updated_subscriber_data[0]['AMOUNT']; ?>" readonly>
								</div>
							</div>
						</div>					
						<div class="row">
							<div class="col">
								<div class="form-group">
									<label for="start_date">Start Date</label>
									<input type="date" name="start_date" id="start_date" class="form-control" value="<?= $updated_subscriber_data[0]['START']; ?>" readonly>
								</div>
							</div>
						</div>					
						<div class="row">
							<div class="col">
								<div class="form-group">
									<label for="end_date">End Date</label>
									<input type="text" name="end_date" id="end_date" class="form-control" value="<?= $updated_subscriber_data[0]['END']; ?>" readonly>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-group">
									<label for="subscription_pay_mode">Pay Mode</label>
									<select name="subscription_pay_mode" id="subscription_pay_mode" class="form-control">
										<option value="">Pay Mode</option>
										<?php if($updated_subscriber_data[0]['PAY_MODE'] === "ONLINE"): ?>
											<option value="online" selected="selected">ONLINE</option>
											<option value="offline">OFFLINE</option>
										<?php else: ?>
											<option value="online">ONLINE</option>
											<option value="offline" selected="selected">OFFLINE</option>
										<?php endif; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-group">
									<label for="subscription_status">Status</label>
									<select name="subscription_status" id="subscription_status" class="form-control">
										<option value="">Status</option>
										<?php if($updated_subscriber_data[0]['STATUS'] === "ACTIVATE"): ?>
											<option value="activate" selected="selected">ACTIVATE</option>
											<option value="deactivate">DEACTIVATE</option>
										<?php else: ?>
											<option value="activate">ACTIVATE</option>
											<option value="deactivate" selected="selected">DEACTIVATE</option>
										<?php endif; ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="form-group">
									<input type="submit" name="subscriber_update_button" id="subscriber_update_button" class="btn btn-outline-secondary float-right" value="Update">
								</div>
							</div>
						</div>
					<?= form_close(); ?>
				<?php else: ?>
					<div class="text-center text-danger font-weight-bold">No data found.</div>			
				<?php endif; ?>					
			</div>
		</div>			
	</div>
</div>
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
	<script>
		"use strict";
		var result;

		// This code will separate subscriber name and subscriber contact detail.
		document.getElementById('subscriber_name').addEventListener('change', function(e){
			e.preventDefault();
			document.getElementById('subscriber_contact').value = document.getElementById('subscriber_name').value.split(',')[1].trim();
			document.getElementById('subscriber_name').value = document.getElementById('subscriber_name').value.split(',')[0].trim();
		});
		
		// This will make an ajax request to get member name according to keyup event on the update subscriber form's subscriber name column.
		document.getElementById('subscriber_name').addEventListener('keyup', function(e){
			e.preventDefault();

			// This variable is used to store the subscriber name, filled on the update subscriber form's subscriber name column.
			let subscriber_name = document.getElementById('subscriber_name').value;
			
			// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '<?php echo base_url("index.php/member/member_name"); ?>', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.send("member_name=" + subscriber_name);
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4){
					if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
						if(xhr.responseText){
							// newResponse variable is used to store the ajax success result.							
							var newResponse = JSON.parse(xhr.responseText);
							
							// This code will set the subscriber name list to empty string. 							
							document.getElementById('subscriber_name_datalist').innerHTML = "";
							
							// If not_found variable is undefined, then this code will append the book name in book name list.
							if(newResponse.not_found === undefined){
								for(let i=0; i<newResponse.length; i++){
									var new_option = document.createElement('option');
									new_option.value = newResponse[i]['MEMBERNAME'] + ', ' + newResponse[i]['CONTACT'] ;
									document.getElementById('subscriber_name_datalist').appendChild(new_option);
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

		// This will make an ajax request to get plan name according to keyup event on the update subscriber details form's plan name column.
		document.getElementById('plan_name').addEventListener('keyup', function(e){
			e.preventDefault();
			// This variable is used to store the plan name, filled on the update subscriber details form's plan name column.
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
	
							// This code will set the plan name datalist to empty string. 
							document.getElementById('plan_name_datalist').innerHTML = "";
							
							// If not_found variable is undefined, then this code will append the plan name in plan name datalist.
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
		
		// This will validate subscriber name field for non empty, only character, digit, hiphen and space value.
		function subscriber_name(){
			result = required({element_id : "subscriber_name"});
			if(result === true){
				result = allow_only_character({element_id : "subscriber_name"});
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

		// This will validate start date field for non empty.
		function start_date(){
			result = required({element_id : "start_date"});
			if(result === true){				
				return result;
			}
			return result;
		}

		// This will validate end date field for non empty.
		function end_date(){
			result = required({element_id : "end_date"});
			if(result === true){
				return result;
			}
			return result;
		}

		// This will validate plan amount field for non empty and only number value.
		function plan_amount(){
			result = required({element_id : "plan_amount"});
			if(result === true){
				result = allow_only_number({element_id : "plan_amount"});
				if(result === true){
					return result;
				}
				return result;
			}
			return result;
		}

		// This will validate pay mode field for non empty.
		function subscription_pay_mode(){ 
			return required({element_id : "subscription_pay_mode"});
		}

		// This will validate pay mode field for non empty.
		function subscription_status(){ 
			return required({element_id : "subscription_status"});
		}

		// This will attach element with event handler for validating the fields.
		document.getElementById("subscriber_name").addEventListener('blur', subscriber_name);
		document.getElementById("plan_name").addEventListener('blur', plan_name);
		document.getElementById("plan_amount").addEventListener('blur', plan_amount);
		document.getElementById("start_date").addEventListener('blur', start_date);
		document.getElementById("end_date").addEventListener('blur', end_date);
		document.getElementById("subscription_pay_mode").addEventListener('blur', subscription_pay_mode);
		document.getElementById("subscription_status").addEventListener('blur', subscription_status);
		document.getElementById("subscriber_updation_form").addEventListener('submit', function(e){
			e.preventDefault();			
			
			// This variable is used to store the validate_form function result.
			var form_submit_result;
			
			// If form_submit_result will be true, then subscriber_updation_form will be submitted, else not.
			form_submit_result = validate_form([subscriber_name, plan_name, plan_amount, start_date, end_date, subscription_pay_mode, subscription_status]);
			if(form_submit_result === true){
				document.getElementById("subscriber_updation_form").submit();
			}
		});
	</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>