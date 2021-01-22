<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="offset-sm-4 col-sm-4" id="subscriber_search_form">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">Update Subscriber</h4>
			</div>
			<div class="card-body">
				<?php if($this->session->flashdata('subscriber_search_message')): ?>
					<div class="alert alert-<?php if($this->session->flashdata('subscriber_search_status')): echo $this->session->flashdata('subscriber_search_status'); ?> alert-dismissible"><?= $this->session->flashdata("subscriber_search_message"); endif; ?>
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
				<?= form_open('subscriber/update_subscriber', ["id"=>"search_subscriber_by_id_form", "name"=>"search_subscriber_by_id_form"]); ?>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="subscriber_id">Subscriber ID</label>
								<input type="text" name="subscriber_id" id="subscriber_id" class="form-control" value="<?php echo set_value('subscriber_id'); ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<input type="submit" name="search_subscriber_button" id="search_subscriber_button" class="btn btn-outline-secondary float-right" value="Search">
							</div>
						</div>
					</div>
				<?= form_close(); ?>
				<?= form_open('subscriber/update_subscriber', ["id"=>"search_subscriber_by_name_form", "name"=>"search_subscriber_by_name_form", "class"=>"d-none"]); ?>
					<div class="row">
						<div class="col">
							<input type="hidden" name="subscriber_contact" id="subscriber_contact" class="form-control" value="">
							<div class="form-group">
								<label for="subscriber_name">Subscriber Name</label>
								<input type="text" list="search_subscriber_name_list" name="subscriber_name" id="subscriber_name" class="form-control" value="<?php echo set_value('subscriber_name'); ?>">
								<datalist id="search_subscriber_name_list"></datalist>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<input type="submit" name="search_subscriber_update_button" id="search_subscriber_update_button" class="btn btn-outline-secondary float-right" value="Search">
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

	// This variable is used to store the validation result.
	var result;

	// This code will display the form according to selection of user search option.
	document.getElementById("search_by").addEventListener('change', function(){
		if(document.getElementById("search_by").value === "search_id"){
			document.getElementById("search_subscriber_by_id_form").classList.remove("d-none");
			document.getElementById("search_subscriber_by_name_form").classList.add("d-none");
		}
		else{
			document.getElementById("search_subscriber_by_id_form").classList.add("d-none");
			document.getElementById("search_subscriber_by_name_form").classList.remove("d-none");
		}
	});

	// This will validate subscriber id field for non empty and only digit value.
	function subscriber_id(){
		result = required({element_id : "subscriber_id"});
		if(result === true){
			result = allow_only_digit({element_id : "subscriber_id"});
			if(result === true){
				return result;
			}
			return result;
		}
		return result;
		
	}

	// This will validate subscriber name field for non empty and only character value.
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

	// This will attach element with event handler for validating the fields.
	document.getElementById("subscriber_id").addEventListener('blur', subscriber_id);	
	document.getElementById("subscriber_name").addEventListener('blur', subscriber_name);
	
	// If user serach subscriber by the id, then search_subscriber_by_id_form will be submitted.
	document.getElementById("search_subscriber_by_id_form").addEventListener('submit', function(e){
		e.preventDefault();
		
		// This variable is used to store the validate_form function result.
		var form_submit_result;
		
		// If form_submit_result will be true, then plan_registration_form will be submitted, else not.
		form_submit_result = validate_form([subscriber_id]);
		if(form_submit_result === true){
			document.getElementById("search_subscriber_by_id_form").submit();
		}
	});
	
	// If user serach subscriber by the id, then search_subscriber_by_name_form will be submitted.
	document.getElementById("search_subscriber_by_name_form").addEventListener('submit', function(e){
		e.preventDefault();
		
		// This variable is used to store the validate_form function result.
		var form_submit_result;
		
		// If form_submit_result will be true, then plan_registration_form will be submitted, else not.
		form_submit_result = validate_form([subscriber_name]);
		if(form_submit_result === true){
			document.getElementById("search_subscriber_by_name_form").submit();
		}
	});

	// This code will separate name and contact number with each other.
	document.getElementById('subscriber_name').addEventListener("change", function(e){
		e.preventDefault();
		document.getElementById('subscriber_contact').value = document.getElementById('subscriber_name').value.split(',')[1].trim();
		document.getElementById('subscriber_name').value = document.getElementById('subscriber_name').value.split(',')[0].trim();
	});
		
	// This will make an ajax request to get subscriber name according to keyup event of search subscriber update form's subscriber name column.
	document.getElementById('subscriber_name').addEventListener('keyup', function(e){
		e.preventDefault();
		
		// This variable is used to store the subscriber name, filled on the search subscriber update form's subscriber name column.
		let search_subscriber_name = document.getElementById('subscriber_name').value;
		
		// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '<?php echo base_url("index.php/subscriber/subscriber_name"); ?>', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send("subscriber_name=" + search_subscriber_name);
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4){
				if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
					if(xhr.responseText){
						// newResponse variable is used to store the ajax success result.						
						var newResponse = JSON.parse(xhr.responseText);

						// This code will set the book name list to empty string.						
						document.getElementById('search_subscriber_name_list').innerHTML = "";
						if(newResponse.not_found === undefined){
							for(let i=0; i<newResponse.length; i++){
								var new_option = document.createElement('option');
								new_option.value = newResponse[i]['MEMBERNAME'] + ', ' + newResponse[i]['CONTACT'] ;
								document.getElementById('search_subscriber_name_list').appendChild(new_option);
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