<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>		
<div class="row">
	<div class="offset-sm-4 col-sm-4" id="librarian_search_form">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">Update Librarian</h4>
			</div>
			<div class="card-body">
				<?php if($this->session->flashdata('librarian_search_message')): ?>
					<div class="alert alert-<?php if($this->session->flashdata('librarian_search_status')): echo $this->session->flashdata('librarian_search_status'); ?> alert-dismissible"><?= $this->session->flashdata("librarian_search_message"); endif; ?>
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
				<?= form_open('librarian/update_librarian', ["id"=>"search_librarian_by_id_form", "name"=>"search_librarian_by_id_form"]); ?>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="librarian_id">Librarian ID</label>
								<input type="text" name="librarian_id" id="librarian_id" class="form-control" value="<?php echo set_value('librarian_id'); ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<input type="submit" name="search_librarian_button" id="search_librarian_button" class="btn btn-outline-secondary float-right" value="Search">
							</div>
						</div>
					</div>
				<?= form_close(); ?>
				<?= form_open('librarian/update_librarian', ["id"=>"search_librarian_by_name_form", "name"=>"search_librarian_by_name_form", "class"=>"d-none"]); ?>
					<div class="row">
						<div class="col">
							<input type="hidden" name="librarian_contact" id="librarian_contact" class="form-control" value="">
							<div class="form-group">
								<label for="librarian_name">Librarian Name</label>
								<input type="text" list="search_librarian_name_list" name="librarian_name" id="librarian_name" class="form-control" value="<?php echo set_value('librarian_name'); ?>">
								<datalist id="search_librarian_name_list"></datalist>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<input type="submit" name="search_librarian_update_button" id="search_librarian_update_button" class="btn btn-outline-secondary float-right" value="Search">
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

	// This code will display the form according to selection of user i.e. according to id or name.
	document.getElementById("search_by").addEventListener('change', function(){
		if(document.getElementById("search_by").value === "search_id"){
			document.getElementById("search_librarian_by_id_form").classList.remove("d-none");
			document.getElementById("search_librarian_by_name_form").classList.add("d-none");
		}
		else{
			document.getElementById("search_librarian_by_id_form").classList.add("d-none");
			document.getElementById("search_librarian_by_name_form").classList.remove("d-none");
		}
	});
	
	// This variable is used to store the result of validaton function
	var result;

	// This will validate librarian id field for non empty and only digit value.
	function librarian_id(){
		result = required({element_id : "librarian_id"});
		if(result === true){
			result = allow_only_digit({element_id : "librarian_id"});
			if(result === true){
				return result;
			}
			return result;
		}
		return result;
		
	}

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

	// This will attach element with event handler for validating the fields.
	document.getElementById("librarian_id").addEventListener('blur', librarian_id);	
	document.getElementById("librarian_name").addEventListener('blur', librarian_name);
	// If user serach librarian details by the id, then details_librarian_by_id_form will be submitted.
	document.getElementById("search_librarian_by_id_form").addEventListener('submit', function(e){
		e.preventDefault();
		
		// This variable is used to store the valiate_form function result.
		var form_submit_result;
		
		// If form_submit_result will be true, then search_librarian_by_id_form will be submitted, else not.			
		form_submit_result = validate_form([librarian_id]);
		if(form_submit_result === true){
			document.getElementById("search_librarian_by_id_form").submit();
		}
	});
	// If user serach librarian details by the id, then details_librarian_by_name_form will be submitted.
	document.getElementById("search_librarian_by_name_form").addEventListener('submit', function(e){
		e.preventDefault();
		
		// This variable is used to store the valiate_form function result.
		var form_submit_result;
		
		// If form_submit_result will be true, then search_librarian_by_name_form will be submitted, else not.			
		form_submit_result = validate_form([librarian_name]);
		if(form_submit_result === true){
			document.getElementById("search_librarian_by_name_form").submit();
		}
	});

	// This code will separate name and contact number.
	document.getElementById('librarian_name').addEventListener("change", function(e){
		e.preventDefault();
		document.getElementById('librarian_contact').value = document.getElementById('librarian_name').value.split(',')[1].trim();
		document.getElementById('librarian_name').value = document.getElementById('librarian_name').value.split(',')[0].trim();
	});
		
	// This will make an ajax request to get librarian name according to keyup event of search librarian update form's librarian name column.
	document.getElementById('librarian_name').addEventListener('keyup', function(e){
		e.preventDefault();
		// This variable is used to store the librarian name, filled in the search librarian update form's librarian name column.
		let search_librarian_name = document.getElementById('librarian_name').value;
		
		// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '<?php echo base_url("index.php/librarian/librarian_name"); ?>', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send("librarian_name=" + search_librarian_name);
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4){
				if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
					if(xhr.responseText){
						// newResponse variable is used to store the ajax success result.
						var newResponse = JSON.parse(xhr.responseText);
		
						// This code will set the book name list to empty string. 
						document.getElementById('search_librarian_name_list').innerHTML = "";
		
						// If not_found variable is undefined, then this code will append the book name in book name list.
						if(newResponse.not_found === undefined){
							for(let i=0; i<newResponse.length; i++){
								var new_option = document.createElement('option');
								new_option.value = newResponse[i]['LIBNAME'] + ', ' + newResponse[i]['CONTACT'] ;
								document.getElementById('search_librarian_name_list').appendChild(new_option);
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