<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>		
<div class="container">
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-header p-0">
					<h4 class="text-center text-white">Member Email Confirmation</h4>			
				</div>
				<div class="card-body">
					<?php if($this->session->flashdata('email_confirmation_message')): ?>
						<div class="alert alert-<?php if($this->session->flashdata('email_confirmation_status')): echo $this->session->flashdata('email_confirmation_status'); ?> alert-dismissible"><?= $this->session->flashdata("email_confirmation_message"); endif; ?>
							<button type="button" class="close" data-dismiss="alert">&times;</button>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
<script>
	"use strict";
	
	// This code will print the librarian details on clicking the print button.
	document.getElementById("librarian_profile_details_print_button").addEventListener('click', function(){
		window.print();
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>
