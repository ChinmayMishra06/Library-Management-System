<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="offset-sm-4 col-sm-4" id="plan_registration_card">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">New Plan</h4>
			</div>
			<div class="card-body">
				<?php if($this->session->flashdata('plan_register_message')): ?>
					<div class="alert alert-<?php if($this->session->flashdata('plan_register_status')): echo $this->session->flashdata('plan_register_status'); ?> alert-dismissible"><?= $this->session->flashdata("plan_register_message"); endif; ?>
						<button type="button" class="close" data-dismiss="alert">&times;</button>
					</div>
				<?php endif; ?>
				<?= form_open("plan/register_check", ["id"=>"plan_registration_form"]); ?>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="plan_amount">Amount</label>
								<input type="text" name="plan_amount" id="plan_amount" class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="plan_validity">Validity</label>
								<input type="text" name="plan_validity" id="plan_validity" class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="plan_status">Status</label>
								<select name="plan_status" id="plan_status" class="form-control">
									<option value="">Status</option>
									<option value="activate">Activate</option>
									<option value="deactivate">Deactivate</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<input type="submit" name="plan_register_button" id="plan_register_button" class="btn btn-outline-secondary float-right" value="Register">
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
		
		// This will validate plan validity field for non empty and only digit value.
		function plan_validity(){
			result = required({element_id : "plan_validity"});
			if(result === true){
				result = allow_only_digit({element_id : "plan_validity"});
				if(result === true){
					return result;
				}
				return result;
			}
			return result;
		}
		
		// This will validate plan status field for non empty.
		function plan_status(){
			return required({element_id : "plan_status"});
		}

		// This will attach element with event handler for validating the fields.
		document.getElementById("plan_amount").addEventListener('blur', plan_amount);
		document.getElementById("plan_validity").addEventListener('blur', plan_validity);
		document.getElementById("plan_status").addEventListener('blur', plan_status);
		document.getElementById("plan_registration_form").addEventListener('submit', function(e){
			e.preventDefault();			
			
			// This variable is used to store the validate_form function result.
			var form_submit_result;
			
			// If form_submit_result will be true, then plan_registration_form will be submitted, else not.
			form_submit_result = validate_form([plan_amount, plan_validity, plan_status]);
			if(form_submit_result === true){
				document.getElementById("plan_registration_form").submit();
			}
		});
	</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>