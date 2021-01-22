<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>		
<div class="row">
	<div class="offset-sm-2 col-sm-8">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">Librarian Profile</h4>
			</div>
			<div class="card-body">
				<?php if(isset($librarian_details)): ?>
					<table class="table" id="librarian_profile">
						<div id="librarian_profile_image">
							<img src="<?= base_url('assets/uploads/images/librarian/'. $librarian_details[0]['IMAGE']); ?>" alt="librarian Image" class="img-thumbnail" height="100px" width="100px">
						</div>
						<tr><th>Name</th><td><?= ucwords(strtolower($librarian_details[0]['LIBNAME'])); ?></td></tr>
						<tr><th>Contact</th><td><?= $librarian_details[0]['CONTACT']; ?></td></tr>
						<tr><th>Email</th><td><?= strtolower($librarian_details[0]['EMAIL']); ?></td></tr>
						<tr><th>Gender</th><td><?= $librarian_details[0]['GENDER']; ?></td></tr>
						<tr><th>Date of Birth</th><td><?= date('d/m/y', strtotime($librarian_details[0]['DOB'])); ?></td></tr>
						<tr><th>Date of Joining</th><td><?= date('d/m/y', strtotime($librarian_details[0]['DOJ'])); ?></td></tr>
						<tr><th>Zip</th><td><?= $librarian_details[0]['ZIP']; ?></td></tr>
						<tr><th>City</th><td><?= ucwords(strtolower($librarian_details[0]['CITY'])); ?></td></tr>
						<tr><th>State</th><td><?= ucwords(strtolower($librarian_details[0]['STATE'])); ?></td></tr>
						<tr><th>Role</th><td><?= ucwords(strtolower($librarian_details[0]['ROLE'])); ?></td></tr>
						<tr><th>Status</th><td><?= ucwords(strtolower($librarian_details[0]['STATUS'])); ?></td></tr>
						<div id="librarian_profile_signature">
							<img src="<?= base_url('assets/uploads/images/librarian/'. $librarian_details[0]['SIGNATURE']); ?>" alt="librarian Signature" class="img-thumbnail" height="100px" width="100px">
						</div>
					</table>
					<div class="row">
						<div class="col">
							<button type="button" id="librarian_profile_details_print_button" name="librarian_profile_details_print_button" class="d-print-none btn btn-outline-secondary">Print</button>
						</div>
					</div>
				<?php else: ?>
					<div class="text-center text-danger font-weight-bold">No data found.</div>
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
