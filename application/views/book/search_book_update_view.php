<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="offset-sm-4 col-sm-4" id="book_search_form">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">Update Book</h4>
			</div>
			<div class="card-body">
				<?php if($this->session->flashdata('book_search_message')): ?>
				<div class="alert alert-<?php if($this->session->flashdata('book_search_status')): echo $this->session->flashdata('book_search_status'); ?> alert-dismissible"><?= $this->session->flashdata("book_search_message"); endif; ?>
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
			<?= form_open('book/update_book', ["id"=>"search_book_by_id_form", "name"=>"search_book_by_id_form"]); ?>
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="book_id">Book ID</label>
							<input type="text" name="book_id" id="book_id" class="form-control" value="<?php echo set_value('book_id'); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="form-group">
							<input type="submit" name="search_book_button" id="search_book_button" class="btn btn-outline-secondary float-right" value="Search">
						</div>
					</div>
				</div>
			<?= form_close(); ?>
			<?= form_open('book/update_book', ["id"=>"search_book_by_name_form", "name"=>"search_book_by_name_form", "class"=>"d-none"]); ?>
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="book_name">Name</label>
							<input type="text" list="search_book_name_list" name="book_name" id="book_name" class="form-control" value="<?php echo set_value('book_name'); ?>">
							<datalist id="search_book_name_list"></datalist>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="book_author">Author</label>
							<input type="text" list="search_book_author_list" name="book_author" id="book_author" class="form-control" value="<?php echo set_value('book_name'); ?>">
							<datalist id="search_book_author_list"></datalist>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<div class="form-group">
							<label for="book_publisher">Publisher</label>
							<input type="text" list="search_book_publisher_list" name="book_publisher" id="book_publisher" class="form-control" value="<?php echo set_value('book_name'); ?>">
							<datalist id="search_book_publisher_list"></datalist>
						</div>
					</div>
				</div>				
				<div class="row">
					<div class="col">
						<div class="form-group">
							<input type="submit" name="search_book_update_button" id="search_book_update_button" class="btn btn-outline-secondary float-right" value="Search">
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
			document.getElementById("search_book_by_id_form").classList.remove("d-none");
			document.getElementById("search_book_by_name_form").classList.add("d-none");
		}
		else{
			document.getElementById("search_book_by_id_form").classList.add("d-none");
			document.getElementById("search_book_by_name_form").classList.remove("d-none");
		}
	});
	
	// This variable is used to store the validation result.
	var result;

	// This will validate book id field for non empty and only digit value.
	function book_id(){
		result = required({element_id : "book_id"});
		if(result === true){
			result = allow_only_digit({element_id : "book_id"});
			if(result === true){
				return result;
			}
			return result;
		}
		return result;
		
	}

	// This will validate book name field for non empty and only character value.
	function book_name(){
		result = required({element_id : "book_name"});
		if(result === true){
			result = allow_only_character({element_id : "book_name"});
			if(result === true){				
				return result;
			}
			return result;
		}
		return result;		
	}

	// This will validate book name field for non empty and only character value.
	function book_author(){
		result = required({element_id : "book_author"});
		if(result === true){
			result = allow_only_character({element_id : "book_author"});
			if(result === true){				
				return result;
			}
			return result;
		}
		return result;		
	}

	// This will validate book name field for non empty and only character value.
	function book_publisher(){
		result = required({element_id : "book_publisher"});
		if(result === true){
			result = allow_only_character({element_id : "book_publisher"});
			if(result === true){				
				return result;
			}
			return result;
		}
		return result;		
	}

	// This will attach element with event handler for validating the fields.
	document.getElementById("book_id").addEventListener('blur', book_id);	
	document.getElementById("book_name").addEventListener('blur', book_name);
	document.getElementById("book_author").addEventListener('blur', book_author);
	document.getElementById("book_publisher").addEventListener('blur', book_publisher);
	
	// If user search the book by the id then search_book_by_id_form will be submitted.
	document.getElementById("search_book_by_id_form").addEventListener('submit', function(e){
		e.preventDefault();
		
		// This variable is used to store the validate_form function result.
		var form_submit_result;
		
		// If form_submit_result will be true, then search_book_by_id_form will be submitted, else not.
		form_submit_result = validate_form([book_id]);
		if(form_submit_result === true){
			document.getElementById("search_book_by_id_form").submit();
		}
	});
	
	// If user search the book by the name then search_book_by_name_form will be submitted.
	document.getElementById("search_book_by_name_form").addEventListener('submit', function(e){
		e.preventDefault();

		// This variable is used to store the validate_form function result.
		var form_submit_result;
		
		// If form_submit_result will be true, then search_book_by_name_form will be submitted, else not.
		form_submit_result = validate_form([book_name, book_author, book_publisher]);
		if(form_submit_result === true){
			document.getElementById("search_book_by_name_form").submit();
		}
	});

	// This will make an ajax request to get book name according to keyup event of search_book_update form's book name column.
	document.getElementById('book_name').addEventListener('keyup', function(e){
		e.preventDefault();
		
		// This variable is used to store the book name, filled in the search_book_update form's book name column.
		let search_book_name = document.getElementById('book_name').value;
		
		// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '<?php echo base_url("index.php/book/book_name"); ?>', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send("book_name=" + search_book_name);
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4){
				if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
					if(xhr.responseText){
						// newResponse variable is used to store the ajax success result.
						var newResponse = JSON.parse(xhr.responseText);

						// This will set the book author list to empty string.
						document.getElementById('search_book_name_list').innerHTML = "";

						// If not_found variable is undefined, then this code will append the book name into the book name datalist.
						if(newResponse.not_found === undefined){
							for(let i=0; i<newResponse.length; i++){
								var new_option = document.createElement('option');
								new_option.value = newResponse[i]['BOOKNAME'];
								document.getElementById('search_book_name_list').appendChild(new_option);
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

	// This will make an ajax request to get book author according to keyup event of search_book_update form's author name column.
	document.getElementById('book_author').addEventListener('keyup', function(e){
		e.preventDefault();
		
		// This variable is used to store the author name, filled in the search_book_update form's author name column.
		let search_book_author = document.getElementById('book_author').value;
		
		// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '<?php echo base_url("index.php/book/author_name"); ?>', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send("author_name=" + search_book_author);
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4){
				if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
					if(xhr.responseText){						
						// newResponse variable is used to store the ajax success result.
						var newResponse = JSON.parse(xhr.responseText);
						
						// This will set the book author list to empty string.
						document.getElementById('search_book_author_list').innerHTML = "";
						
						// If not_found variable is undefined, then this code will append the author name into the author name datalist.
						if(newResponse.not_found === undefined){
							for(let i=0; i<newResponse.length; i++){
								var new_option = document.createElement('option');
								new_option.value = newResponse[i]['AUTHOR'];
								document.getElementById('search_book_author_list').appendChild(new_option);
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

	// This will make an ajax request to get book publisher according to keyup event of search_book_update form's publisher name column.
	document.getElementById('book_publisher').addEventListener('keyup', function(e){
		e.preventDefault();

		// This variable is used to store the publisher name, filled in the search book update form's publisher name column.
		let search_publisher_name = document.getElementById('book_publisher').value;
		
		// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '<?php echo base_url("index.php/book/publisher_name"); ?>', true);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.send("publisher_name=" + search_publisher_name);
		xhr.onreadystatechange = function(){
			if(xhr.readyState == 4){
				if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
					if(xhr.responseText){
						// newResponse variable is used to store the ajax success result.
						var newResponse = JSON.parse(xhr.responseText);
						
						// This will set the book author list to empty string.
						document.getElementById('search_book_publisher_list').innerHTML = "";
						
						// If not_found variable is undefined, then this code will append the publisher name into the publisher name datalist.
						if(newResponse.not_found === undefined){
							for(let i=0; i<newResponse.length; i++){
								var new_option = document.createElement('option');
								new_option.value = newResponse[i]['PUBLISHER'];
								document.getElementById('search_book_publisher_list').appendChild(new_option);
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