<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="offset-sm-4 col-sm-4 mt-2">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">New Book</h4>
			</div>
			<div class="card-body">
				<?php if($this->session->flashdata('book_register_message')): ?>
					<div class="alert alert-<?php if($this->session->flashdata('book_register_status')): echo $this->session->flashdata('book_register_status'); ?> alert-dismissible"><?= $this->session->flashdata("book_register_message"); endif; ?>
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
				<?php endif; ?>
				<?= form_open_multipart('book/register_check', ["id"=>"book_registration_form", "name"=>"book_registration_form"]); ?>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="book_name">Name</label>
								<input type="text" name="book_name" id="book_name" class="form-control" value="<?php echo set_value('book_name'); ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="book_author">Author</label>
								<input type="text" name="book_author" id="book_author" class="form-control" value="<?php echo set_value('book_author'); ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="book_publisher">Pulisher</label>
								<input type="text" name="book_publisher" id="book_publisher" class="form-control" value="<?php echo set_value('book_publisher'); ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="book_price">Price</label>
								<input type="text" name="book_price" id="book_price" class="form-control" value="<?php echo set_value('book_price'); ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="book_quantity">Quantity</label>
								<input type="text" name="book_quantity" id="book_quantity" class="form-control" value="<?php echo set_value('book_quantity'); ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="book_image">Image</label>
								<input type="file" name="book_image" id="book_image" class="form-control" value="<?php echo set_value('book_image'); ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<input type="submit" name="book_register_button" id="book_register_button" class="btn btn-outline-secondary float-right" value="Register">
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
	
	// This variable is used to store the validation result.
	var result;
	
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
	
	// This will validate book author field for non empty and only character value.
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
	
	// This will validate book publisher field for non empty and only character value.
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
	
	// This will validate book price field for non empty and only number value.
	function book_price(){
		result = required({element_id : "book_price"});
		if(result === true){
			result = allow_only_number({element_id : "book_price"});
			if(result === true){
				return result;
			}
			return result;
		}
		return result;
	}
	
	// This will validate book name quantity for non empty and only digit value.
	function book_quantity(){
		result = required({element_id : "book_quantity"});
		if(result === true){
			result = allow_only_digit({element_id : "book_quantity"});
			if(result === true){
				return result;
			}
			return result;
		}
		return result;
	}
	
	// This will validate book image field for non empty and only for jpeg, jpg, png, gif, and bmp files.
	function book_image(){
		result = required({element_id : "book_image"});
		if(result === true){
			result = allow_file_type({element_id : "book_image", extension : ["jpeg", "jpg", "png", "gif", "bmp"]});
			if(result === true){
				return result;
			}
			return result;		
		}
		return result;
	}

	// This will attach element with event handler for validating the fields.
	document.getElementById("book_name").addEventListener('blur', book_name);
	document.getElementById("book_author").addEventListener('blur', book_author);
	document.getElementById("book_publisher").addEventListener('blur', book_publisher);
	document.getElementById("book_price").addEventListener('blur', book_price);
	document.getElementById("book_quantity").addEventListener('blur', book_quantity);
	document.getElementById("book_image").addEventListener('blur', book_image);
	document.getElementById("book_registration_form").addEventListener('submit', function(e){
		e.preventDefault();		
		// This variable is used to store the validate_form function result.
		var form_submit_result;
		form_submit_result = validate_form([book_name, book_author, book_publisher, book_price, book_quantity, book_image]);

		// If form_submit_result will be true, then book_registration_form will be submitted, else not.
		if(form_submit_result === true){
			document.getElementById("book_registration_form").submit();
		}
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>