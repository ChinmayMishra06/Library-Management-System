<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="offset-sm-4 col-sm-4" id="plan_search_form">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">Update Plan</h4>
			</div>
			<div class="card-body">
				<?php if($this->session->flashdata('plan_search_message')): ?>
					<div class="alert alert-<?php if($this->session->flashdata('plan_search_status')): echo $this->session->flashdata('plan_search_status'); ?> alert-dismissible"><?= $this->session->flashdata("plan_search_message"); endif; ?>
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
				<?php endif; ?>
				<div class="row">
					<div class="offset-sm-7 col-sm-5">
						<select class="form-control" id="search_by" name="search_by">
							<option value="search_id">By ID</option>
							<option value="serach_name">By Name</option>
						</select>
					</div>			
				</div>
				<?= form_open('plan/update_plan', ["id"=>"search_plan_by_id_form", "name"=>"search_plan_by_id_form"]); ?>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="plan_id">Plan ID</label>
								<input type="text" name="plan_id" id="plan_id" class="form-control" value="<?php echo set_value('plan_id'); ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<input type="submit" name="search_plan_button" id="search_plan_button" class="btn btn-outline-secondary float-right" value="Search">
							</div>
						</div>
					</div>
				<?= form_close(); ?>
				<?= form_open('plan/update_plan', ["id"=>"search_plan_by_name_form", "name"=>"search_plan_by_name_form", "class"=>"d-none"]); ?>
					<div class="row">
						<div class="col">
							<input type="hidden" name="plan_contact" id="plan_contact" class="form-control" value="">
							<div class="form-group">
								<label for="plan_name">Plan Name</label>
								<input type="text" list="search_plan_name_list" name="plan_name" id="plan_name" class="form-control" value="<?php echo set_value('plan_name'); ?>">
								<datalist id="search_plan_name_list"></datalist>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<input type="submit" name="search_plan_update_button" id="search_plan_update_button" class="btn btn-outline-secondary float-right" value="Search">
							</div>
						</div>
					</div>
				<?= form_close(); ?>				
			</div>
		</div>
	</div>
</div>
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
<script>
	"use strict";

	// This code will display the form according to selection of user search option.
	document.getElementById("search_by").addEventListener('change', function(){
		if(document.getElementById("search_by").value === "search_id"){
			document.getElementById("search_plan_by_id_form").classList.remove("d-none");
			document.getElementById("search_plan_by_name_form").classList.add("d-none");
		}
		else{
			document.getElementById("search_plan_by_id_form").classList.add("d-none");
			document.getElementById("search_plan_by_name_form").classList.remove("d-none");
		}
	});
	
	// This variable is used to store the validation result.
	var result;

	// This will validate plan id field for non empty and only digit value.
	function plan_id(){
		result = required({element_id : "plan_id"});
		if(result === true){
			result = allow_only_digit({element_id : "plan_id"});
			if(result === true){
				return result;
			}
			return result;
		}
		return result;
		
	}

	// This will validate plan name field for non empty and only character value.
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

	// This will attach element with event handler for validating the fields.
	document.getElementById("plan_id").addEventListener('blur', plan_id);	
	document.getElementById("plan_name").addEventListener('blur', plan_name);
	
	// If user serach plan by id then search_plan_by_id_form will be submitted.
	document.getElementById("search_plan_by_id_form").addEventListener('submit', function(e){
		e.preventDefault();

		// This variable is used to store the validate_form function result.
		var form_submit_result;
		
		// If form_submit_result will be true, then search_plan_by_id_form will be submitted, else not.
		form_submit_result = validate_form([plan_id]);
		if(form_submit_result === true){
			document.getElementById("search_plan_by_id_form").submit();
		}
	});
	// If user serach plan by name then search_plan_by_name_form will be submitted.
	document.getElementById("search_plan_by_name_form").addEventListener('submit', function(e){
		e.preventDefault();

		// This variable is used to store the validate_form function result.
		var form_submit_result;

		// If form_submit_result will be true, then search_plan_by_name_form will be submitted, else not.
		form_submit_result = validate_form([plan_name]);
		if(form_submit_result === true){
			document.getElementById("search_plan_by_name_form").submit();
		}
	});
	
	// This will make an ajax request to get plan name according to keyup event of search plan update form's plan name column.
	document.getElementById('plan_name').addEventListener('keyup', function(e){
		e.preventDefault();
		
		// This variable is used to store the plan name filled on the plan name field of the search plan update form's plan name column.
		let search_plan_name = document.getElementById('plan_name').value;
		
		// This variable is used to store XMLHtpRequest object reference. So that we could make ajax request.
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '<?php echo base_url("index.php/plan/plan_name"); ?>', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send("plan_name=" + search_plan_name);
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4){
				if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
					if(xhr.responseText){
						// This variable is used to store the ajax success result.
						var newResponse = JSON.parse(xhr.responseText);
						
						// This code will set the book name list to empty string. 
						document.getElementById('search_plan_name_list').innerHTML = "";
						
						// If not_found variable is undefined, then this code will append the book name in plan name list.
						if(newResponse.not_found === undefined){
							for(let i=0; i<newResponse.length; i++){
								var new_option = document.createElement('option');
								new_option.value = newResponse[i]['PLANNAME'];
								document.getElementById('search_plan_name_list').appendChild(new_option);
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
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>