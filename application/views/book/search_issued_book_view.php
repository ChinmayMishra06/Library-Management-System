<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>	
<div class="row">
	<div class="offset-sm-4 col-sm-4">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">Search Issued Books</h4>
			</div>
			<div class="card-body">			
				<?php if($this->session->flashdata('issued_book_details_message')): ?>
					<div class="alert alert-<?php if($this->session->flashdata('issued_book_details_status')): echo $this->session->flashdata('issued_book_details_status'); ?> alert-dismissible"><?= $this->session->flashdata("issued_book_details_message"); endif; ?>
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
				<?php endif; ?>
				<?= form_open('book/search_issued_book_check', ["id"=>"search_issued_book_form", "name"=>"search_issued_book_form"]); ?>
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
								<label for="transaction_id">Transaction ID</label>
								<input type="text" name="transaction_id" id="transaction_id" class="form-control" value="<?php echo set_value('transaction_id'); ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<input type="submit" name="search_issued_book_button" id="search_issued_book_button" class="btn btn-outline-secondary float-right" value="Serach">
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

	// This will validate librarian id field for non empty and only digit value.
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

	// This will validate librarian id field for non empty and only digit value.
	function transaction_id(){
		result = required({element_id : "transaction_id"});
		if(result === true){
			result = allow_only_digit({element_id : "transaction_id"});
			if(result === true){
				return result;
			}
			return result;
		}
		return result;
		
	}

	// This will attach element with event handler for validating the fields.
	document.getElementById("subscriber_id").addEventListener('blur', subscriber_id);	
	document.getElementById("transaction_id").addEventListener('blur', transaction_id);
	document.getElementById("search_issued_book_form").addEventListener('submit', function(e){
		e.preventDefault();
		
		// This variable is used to store the validate_form function result.
		var form_submit_result;
		
		// If form_submit_result will be true, then search_issued_book_form will be submitted, else not.
		form_submit_result = validate_form([subscriber_id, transaction_id]);
		if(form_submit_result === true){
			document.getElementById("search_issued_book_form").submit();
		}
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>