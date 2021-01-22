<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="alert alert-danger" id="status_message" style="display:none;"></div>
<div class="row">
	<div class="col-sm-4">
		<div class="row">
			<div class="col">
				<div class="card mb-3">
					<div class="card-header p-0">
						<h4 class="text-center text-white">Subscriber Details</h4>
					</div>                            
					<!-- It will display subscribers details in readonly mode. -->
					<div class="card-body pb-1" id="subscriber_details">
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="subscriber_id">ID</label>
								</div>
							</div>
							<div class="col-sm-9">
								<div class="form-group">
									<input type="text" class="form-control" id="subscriber_id" name="subscriber_id">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="">Name</label>
								</div>
							</div>
							<div class="col-sm-9">
								<div class="form-group">
									<input type="text" class="form-control" id="subscriber_name" name="subscriber_name" readonly="true">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="">Plan</label>
								</div>
							</div>
							<div class="col-sm-9">
								<div class="form-group">
									<input type="text" class="form-control" id="plan_name" name="plan_name" readonly="true">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="">Start</label>
								</div>
							</div>
							<div class="col-sm-9">
								<div class="form-group">
									<input type="text" class="form-control" id="start_date" name="start_date" readonly="true">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="">End</label>
								</div>
							</div>
							<div class="col-sm-9">
								<div class="form-group">
									<input type="text" class="form-control" id="end_date" name="end_date" readonly="true">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="">Status</label>
								</div>
							</div>
							<div class="col-sm-9">
								<div class="form-group">
									<input type="text" class="form-control" id="plan_status" name="plan_status" readonly="true">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="form-group">
									<label for="">Paid</label>
								</div>
							</div>
							<div class="col-sm-9">
								<div class="form-group">
									<input type="text" class="form-control" id="total_paid" name="total_paid" readonly="true">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-header p-0">
						<h4 class="text-center text-white">Book Details</h4>
					</div>                            
					<!-- It will display subscribers details in readonly mode. -->
					<div class="card-body pb-3" id="book_details">
						<?= form_open('', ["id"=>"book_issue_form"]); ?>
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label for="">Book</label>
									</div>
								</div>
								<div class="col-sm-9">
									<div class="form-group">
										<input type="text" list="book_name_list" class="form-control" id="book_name" name="book_name">
										<datalist id="book_name_list"></datalist>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label for="">Author</label>
									</div>
								</div>
								<div class="col-sm-9">
									<div class="form-group">
										<input type="text" list="book_author_list" class="form-control" id="book_author" name="book_author">
										<datalist id="book_author_list"></datalist>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3">
									<div class="form-group">
										<label for="">Publisher</label>
									</div>
								</div>
								<div class="col-sm-9">
									<div class="form-group">
										<input type="text" list="book_publisher_list" class="form-control" id="book_publisher" name="book_publisher">
										<datalist id="book_publisher_list"></datalist>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col ">
									<div class="form-group">
										<input type="submit" name="add_book_button" id="add_book_button" class="btn btn-outline-secondary float-right" value="Add">
									</div>
								</div>
							</div>
						<?= form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col" id="issued_book_card">
		<div class="row">
			<div class="col">
				<div class="card min-vh-100">
					<div class="card-header p-0">
						<h4 class="text-center text-white">Issued Book Details</h4>
					</div>                            
					<!-- It will display subscribers details in readonly mode. -->
					<div class="card-body" id="issued_book_table">
						<table class="table table-bordered">
							<thead>
								<tr><th width="30%" class="text-center">Book</th><th width="30%" class="text-center">Author</th><th width="30%" class="text-center">Publisher</th><th width="6%" class="text-center">Price</th><th width="4%" class="text-center">Qty</th><th width="4%" class="text-center"></th></tr>
							</thead>
							<tbody></tbody>
							<tfoot>
								<tr><td class="text-center"></td><td class="text-center"></th><th class="text-center">Total</th><th id="total_price" class="text-center">0</th><th id="total_quantity" class="text-right">0</th><td class="text-right"></td></tr>
							</tfoot>
						</table>
						<div class="row">
							<div class="col">
								<div class="form-group">
									<input type="submit" name="issued_book_button" id="issued_book_button" class="btn btn-outline-secondary float-right" style="width:72px;" value="Issue">
									<input type="submit" name="issued_clear_button" id="issued_clear_button" class="btn btn-outline-secondary float-right mr-1" style="width:72px;" value="Clear">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?= form_open('book/issued_book',["id"=>"hidden_issued_book_form", "name"=>"hidden_issued_book_form"]); ?>
			<input type="hidden" name="subscriber_id" id="subscriber_id" value="">
			<input type="hidden" name="transaction_id" id="transaction_id" value="">
	<?= form_close(); ?>
</div>
	
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
	<script>
		"use strict";
		
		// This result variable is used to store the validation result.
		var result;
		
		// This will validate book name field for non empty and only character value.
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

		// This will validate book name field for non empty and only character value.
		function book_names(){
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

		// This will validate book author field for non empty and only character value.
		function book_authors(){
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

		// This will validate book name publisher field for non empty and only character value.
		function book_publishers(){
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
		document.getElementById("book_name").addEventListener('blur', book_names);
		document.getElementById("book_author").addEventListener('blur', book_authors);
		document.getElementById("book_publisher").addEventListener('blur', book_publishers);
		document.getElementById("subscriber_id").addEventListener('blur', subscriber_id);	
		
		// These all are global variables.
		// rowID variable is used to uniquely identify all the row of the issued book table.
		// total_price variable is used to store the total amount of issued book.
		// total_quantity variable is used to store the total quantity of issued book.
		// issued_book json variable is used to store the all issued book details.
		var rowID = 1, total_price=0, total_quantity=0, issued_book = {};

		// This will make an ajax request to get member details on blur event in the book issue form's subscriber id column.
		document.getElementById('subscriber_id').addEventListener('blur', function(e){
			e.preventDefault();
			if(result === true){
				// This variable is used to store the subscriber id, filled in the book issue form's subscriber id column.
				let subscriber_id = document.getElementById('subscriber_id').value;

				// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.
				var xhr = new XMLHttpRequest();
				xhr.open('POST', '<?php echo base_url("index.php/book/subscriber_details"); ?>', true);
				xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				xhr.send("subscriber_id=" + subscriber_id);
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4){
						if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
							if(xhr.responseText){
								// newResponse variable is used to store the ajax success result.
								var newResponse = JSON.parse(xhr.responseText);

								// If not_found variable is undefined, it means that subscriber is available, else subscriber is not available.
								if(newResponse.not_found === undefined){
									// If plan_renewal variable is undefined, it means that subscriber's plan is activate, else subscriber's needs to renew their plan.
									if(newResponse.plan_renewal === undefined){
										// If not_found and plan_renewal variable is undefined, then this code will set the subscriber details to the success value, on blur event on subscriber id column of book issue view.
										document.getElementById('subscriber_name').value = newResponse[0]['MEMBERNAME'];
										document.getElementById('plan_name').value = newResponse[0]['PLANNAME'];
										document.getElementById('start_date').value = newResponse[0]['START'];
										document.getElementById('end_date').value = newResponse[0]['END'];
										document.getElementById('plan_status').value = newResponse[0]['STATUS'];
										document.getElementById('total_paid').value= newResponse[0]['TOTAL_PAID'];
									}
									else{
										// If plan_renewal variable is defined, then this code will set the subscriber details to empty string on blur event on subscriber id column of book issue view.
										document.getElementById('subscriber_name').value = "";
										document.getElementById('plan_name').value = "";
										document.getElementById('start_date').value = "";
										document.getElementById('end_date').value = "";
										document.getElementById('plan_status').value = "";
										document.getElementById('total_paid').value= "";
										
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
								else{
									// If not_found variable is defined, then this code will set the subscriber details to empty string on blur event on subscriber id column of book issue view.
									document.getElementById('subscriber_name').value = "";
									document.getElementById('plan_name').value = "";
									document.getElementById('start_date').value = "";
									document.getElementById('end_date').value = "";
									document.getElementById('plan_status').value = "";
									document.getElementById('total_paid').value= "";
									
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
						}
					}
				};
			}
			else{
				// If result variable is not true, then this code will set subscriber details to empty string.
				document.getElementById('subscriber_name').value = "";
				document.getElementById('plan_name').value = "";
				document.getElementById('start_date').value = "";
				document.getElementById('end_date').value = "";
				document.getElementById('plan_status').value = "";
				document.getElementById('total_paid').value= "";
			}
		});

		// This will make an ajax request to get book name according to keyup event in the book issue form's book name column.
		document.getElementById('book_name').addEventListener('keyup', function(e){
		    e.preventDefault();
			
			// This variable is used to store the book name, filled in the book issue form's book name column.
			let book_name = document.getElementById('book_name').value;
			
			// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '<?php echo base_url("index.php/book/book_name"); ?>', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.send("book_name=" + book_name);
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4){
					if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
						if(xhr.responseText){
							// newResponse variable is used to store the ajax success result.
							var newResponse = JSON.parse(xhr.responseText);

							// This code will set the book name list to empty string. 
							document.getElementById('book_name_list').innerHTML = "";
							// If not_found variable is undefined, then this code will append the book name in book name list.
							if(newResponse.not_found === undefined){
								for(let i=0; i<newResponse.length; i++){
									var new_option = document.createElement('option');
									new_option.value = newResponse[i]['BOOKNAME'];
									document.getElementById('book_name_list').appendChild(new_option);
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
		
		// This will make an ajax request to get author name according to keyup event in the book issue form's author name column.
		document.getElementById('book_author').addEventListener('keyup', function(e){
		    e.preventDefault();
			
			// This variable is used to store the author name, filled in the book issue form's author name column.
			let author_name = document.getElementById('book_author').value;
			
			// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '<?php echo base_url("index.php/book/author_name"); ?>', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.send("author_name=" + author_name);
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4){
					if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
						if(xhr.responseText){							
							// newResponse variable is used to store the ajax success result.
							var newResponse = JSON.parse(xhr.responseText);
							// This will set the book author list to empty string.
							document.getElementById('book_author_list').innerHTML = "";
							
							// If not_found variable is undefined, then this code will append the author name in author name list.
							if(newResponse.not_found === undefined){
								for(let i=0; i<newResponse.length; i++){
									var new_option = document.createElement('option');
									new_option.value = newResponse[i]['AUTHOR'];
									document.getElementById('book_author_list').appendChild(new_option);
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

		// This will make an ajax request to get publisher name according to keyup event in the book issue form's publisher name column.
		document.getElementById('book_publisher').addEventListener('keyup', function(e){
		    e.preventDefault();
			
			// This variable is used to store the publisher name, filled in the book issue form's publisher name column.
			let publisher_name = document.getElementById('book_publisher').value;
			
			// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '<?php echo base_url("index.php/book/publisher_name"); ?>', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.send("publisher_name=" + publisher_name);
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4){
					if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
						if(xhr.responseText){
							// newResponse variable is used to store the ajax success result.
							var newResponse = JSON.parse(xhr.responseText);							
							
							// This code will set the book publisher list to empty string.
							document.getElementById('book_publisher_list').innerHTML = "";
							
							// If not_found variable is undefined, then this code will append the publisher name in publisher name list.
							if(newResponse.not_found === undefined){
								for(let i=0; i<newResponse.length; i++){
									var new_option = document.createElement('option');
									new_option.value = newResponse[i]['PUBLISHER'];
									document.getElementById('book_publisher_list').appendChild(new_option);
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

		// This will add book into the issued book table.
		document.getElementById("book_issue_form").addEventListener('submit', function(e){
			e.preventDefault();

			// This variable is used to store the validate_form function result.
			var form_submit_result;
			
			// If form_submit_result is true then book_details_form will be submitted, else not.
			form_submit_result = validate_form([book_names, book_authors, book_publishers]);
			if(form_submit_result === true){
				var book_name = document.getElementById('book_name').value;
				var author_name = document.getElementById('book_author').value;
				var publisher_name = document.getElementById('book_publisher').value;

				// This will check whether the book is already added to the cart or not?
				var all_added_book = document.querySelectorAll('#issued_book_table tbody tr');

				// This code will check whether the book is already added to the cart or not?
				for(var i=0; i<all_added_book.length; i++){
					if((book_name === all_added_book[i].children[0].textContent) && (author_name === all_added_book[i].children[1].textContent) && (publisher_name === all_added_book[i].children[2].textContent)){
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
						break;					
					}				
					else{ continue; }
				}
				
				// If book is not already added to the cart then this code will be executed.
				if(i === all_added_book.length){
					var xhr = new XMLHttpRequest();
					xhr.open('POST', '<?php echo base_url("index.php/book/book_price"); ?>');
					xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					xhr.send('book_name='+book_name+"&author_name="+author_name+"&publisher_name="+publisher_name);
					xhr.onreadystatechange = function(){
						if(xhr.readyState == 4){
							if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
								if(xhr.responseText){
									// newResponse variable is used to store the ajax success result.
									var newResponse = JSON.parse(xhr.responseText);
									
									// This code will set the book publisher list to empty string.
									document.getElementById('book_publisher_list').innerHTML = "";
									
									// If not_found variable is undefined, then this code will append the publisher name in publisher name list.
									if(newResponse.not_found === undefined){
										// This variable is used to store the issued book details.
										var book_details_body = document.querySelectorAll('#issued_book_table tbody')[0];
										
										// This will create a new row and append it to the issued book table as a last child.
										var newRow = book_details_body.insertRow(-1);
										newRow.setAttribute('id', 'row'+ rowID++);
										
										// This will create six new cell into the created last table row.
										var cell1, cell2, cell3, cell4, cell5, cell6;

										cell1 = newRow.insertCell(0);
										cell1.setAttribute('class', 'text-left');
										cell1.textContent = document.getElementById('book_name').value;

										cell2 = newRow.insertCell(1);
										cell2.setAttribute('class', 'text-left');
										cell2.textContent = document.getElementById('book_author').value;

										cell3 = newRow.insertCell(2);
										cell3.setAttribute('class', 'text-left');
										cell3.textContent = document.getElementById('book_publisher').value;

										cell4 = newRow.insertCell(3);
										cell4.setAttribute('class', 'text-right');
										cell4.textContent = newResponse[0]['PRICE'];

										cell5 = newRow.insertCell(4);
										cell5.setAttribute('class', 'text-right');
										cell5.textContent = 1;
										
										cell6 = newRow.insertCell(5);
										cell6.setAttribute('class', 'text-center');
										cell6.innerHTML = '<a href="" class="remove_item"><i class="fa fa-trash" title="Delete"></i></a>';

										let price = parseFloat(document.getElementById('total_price').textContent);
										total_price += parseFloat(newResponse[0]['PRICE']);
										document.getElementById('total_price').textContent = total_price;
										document.getElementById('total_quantity').textContent = ++total_quantity;

										document.getElementById('book_name').value = "";
										document.getElementById('book_author').value = "";
										document.getElementById('book_publisher').value = "";

										// This code will select the id of the row is to be deleted from the issued book table.
										let last_row_id = document.querySelector("#issued_book_table tbody tr:last-child").getAttribute("id");
										// This code will select last row according to lasw_row_id.
										let last_row = document.getElementById(last_row_id);

										// This code will attach the event handler with that element who has remove_item class
										// and remove the particular item from the table on clicking remove icon of the issued book.
										let remove_element = document.getElementById(last_row_id).querySelector(".remove_item");
										
										remove_element.addEventListener('click', function(e){
											e.preventDefault();											
											
											// This code will select the last row;
											let delete_row = this.parentElement.parentElement;

											// This code will deduct the book price from the total_price and quantity from the total_quantity.
											total_price -= parseFloat(delete_row.children[3].textContent);
											total_quantity -= 1;

											// After deduction this code will reset the total_price and total_quantity;
											document.getElementById("total_price").textContent = total_price;
											document.getElementById("total_quantity").textContent = total_quantity;
											
											// This code will remove the issued book from the issued book table.
											document.querySelector("#issued_book_table tbody").removeChild(this.parentElement.parentElement);
										});
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
							else{ console.log('Request was unsuccessful'); };
						}
					}
				}
			}			
		});		
				
		// This will issue the book on clicking issue button.
		document.getElementById('issued_book_button').addEventListener('click', function(){
			// This code will check whether the subscriber id is empty or not?
			if(document.getElementById('subscriber_id').value !== ""){
				// This code will check whether the at least one book is added to the cart or not?
				if(document.querySelectorAll('#issued_book_table tbody tr').length !== 0){
					var all_issued_book = document.querySelectorAll('#issued_book_table tbody tr');
					issued_book['subscriber_id'] = document.getElementById('subscriber_id').value;
					issued_book['total_price'] = total_price;
					
					// This code will store all book details into the array.
					issued_book['book_details'] = [];
					for(let i=0; i<all_issued_book.length; i++){
						let book = {
							book : all_issued_book[i].children[0].textContent,
							author : all_issued_book[i].children[1].textContent,
							publisher : all_issued_book[i].children[2].textContent,
							price : all_issued_book[i].children[3].textContent,
						};
						issued_book['book_details'].push(book);
					}

					// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.
					var xhr = new XMLHttpRequest();
					xhr.open('POST', '<?php echo base_url("index.php/book/book_issue_check"); ?>', true);
					xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					xhr.send("issued_book=" + JSON.stringify(issued_book));
					xhr.onreadystatechange = function(){
						if(xhr.readyState == 4){
							if((xhr.status >= 200 && xhr.status < 300) || xhr.status == 304){
								if(xhr.responseText){
									// This variable is used to store XMLHttpRequest object reference. So that we could make ajax request.									
									var newResponse = JSON.parse(xhr.responseText);
									
									// If transaction_id variable is undefined, it means that book issued successfully and now hidden_issued_book_form will be submitted.
									if(newResponse.transaction_id !== undefined){
										document.getElementById('hidden_issued_book_form').subscriber_id.value = document.querySelector('#subscriber_details #subscriber_id').value;
										document.getElementById('hidden_issued_book_form').transaction_id.value = newResponse.transaction_id;
										document.getElementById('hidden_issued_book_form').submit();
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
							}
						}
					};	
				}
				else{
					// This code will set the status message for 5 seconds to denote the user what type of error occurred.
					// After completion of 5 seconds, status message automatically gets hide.
					let status_message = document.getElementById('status_message');
					status_message.style.display = "block";
					status_message.style.opacity = 1;
					status_message.textContent = "Please select some books to issue.";
					let status_message_id = setInterval(() => {
						if(status_message.style.opacity > 0){
							status_message.style.opacity -= 0.1;
						}
						else{
							clearInterval(status_message_id);
							status_message.style.display = "none";
						}
					}, 500);
				}
			}
			else{
				// This code will set the status message for 5 seconds to denote the user what type of error occurred.
				// After completion of 5 seconds, status message automatically gets hide.
				let status_message = document.getElementById('status_message');
				status_message.style.display = "block";
				status_message.style.opacity = 1;
				status_message.textContent = "Please fill member details.";
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
		});

		// This code will clear entire table on cliking clear button of Issued Book Details table's clear button.
		document.getElementById('issued_clear_button').addEventListener('click', function(){
			document.querySelector("#issued_book_table tbody").innerHTML = "";
			rowID = 1, total_price=0, total_quantity=0, issued_book = {};
			document.getElementById('total_price').textContent = 0;
			document.getElementById('total_quantity').textContent = 0;
		});
	</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>