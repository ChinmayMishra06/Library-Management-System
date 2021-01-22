<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="offset-sm-2 col-sm-8" id="member_details_table">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">Member Profile</h4>
			</div>
			<div class="card-body">
				<?php if(isset($member_details)): ?>
					<table class="table" id="member_profile">
						<div id="member_profile_image"><img src="<?= base_url('assets/uploads/images/member/'. $member_details[0]['IMAGE']); ?>" alt="Member Image" class="img-thumbnail" height="100px" width="100px"></div>
						<tr><th>Name</th><td><?= ucwords(strtolower($member_details[0]['MEMBERNAME'])); ?></td></tr>
						<tr><th>Contact</th><td><?= $member_details[0]['CONTACT']; ?></td></tr>
						<tr><th>Email</th><td><?= strtolower($member_details[0]['EMAIL']); ?></td></tr>
						<tr><th>Gender</th><td><?= $member_details[0]['GENDER']; ?></td></tr>
						<tr><th>Date of Birth</th><td><?= date('d/m/y', strtotime($member_details[0]['DOB'])); ?></td></tr>
						<tr><th>Date of Joining</th><td><?= date('d/m/y', strtotime($member_details[0]['DOJ'])); ?></td></tr>
						<tr><th>Zip</th><td><?= $member_details[0]['ZIP']; ?></td></tr>
						<tr><th>City</th><td><?= ucwords(strtolower($member_details[0]['CITY'])); ?></td></tr>
						<tr><th>State</th><td><?= ucwords(strtolower($member_details[0]['STATE'])); ?></td></tr>
						<tr><th>Total Paid</th><td><?= $member_details[0]['TOTAL_PAID']; ?></td></tr>
						<div id="member_profile_signature"><img src="<?= base_url('assets/uploads/images/member/'. $member_details[0]['SIGNATURE']); ?>" alt="Member Signature" class="img-thumbnail" height="100px" width="100px"></div>
					</table>
					<div class="row">
						<div class="col">
							<button type="button" id="member_profile_details_print_button" name="member_profile_details_print_button" class="d-print-none btn btn-outline-secondary ml-2">Print</button>
						</div>
					</div>
				<?php else: ?>
					<div class="text-center text-danger font-weight-bold">No data found.</div>
				<?php endif; ?>				
			</div>
		</div>
	</div>
</div>
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
<script>
	"use strict";
	
	// This code will print the member details on clicking the print button.	
	document.getElementById("member_profile_details_print_button").addEventListener('click', function(){
		window.print();
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>
