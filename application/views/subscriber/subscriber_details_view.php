<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="offset-sm-2 col-sm-8">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">Subscriber Profile</h4>
			</div>
			<div class="card-body">
				<?php if(count($subscriber_details) !== 0): ?>
					<table class="table" id="subscriber_profile">
						<div id="subscriber_profile_image"><img src="<?= base_url('assets/uploads/images/member/'. $subscriber_details[0]['IMAGE']); ?>" alt="Member Image" class="img-thumbnail" height="100px" width="100px"></div>
						<tr><th>Name</th><td><?= $subscriber_details[0]['MEMBERNAME']; ?></td></tr>
						<tr><th>Contact</th><td><?= $subscriber_details[0]['CONTACT']; ?></td></tr>
						<tr><th>Plan Name</th><td><?= $subscriber_details[0]['PLANNAME']; ?></td></tr>
						<tr><th>Amount</th><td><?= $subscriber_details[0]['AMOUNT']; ?></td></tr>
						<tr><th>Start Date</th><td><?= $subscriber_details[0]['START']; ?></td></tr>
						<tr><th>End Date</th><td><?= $subscriber_details[0]['END']; ?></td></tr>
						<tr><th>Pay Mode</th><td><?= $subscriber_details[0]['PAY_MODE']; ?></td></tr>
						<tr><th>Status</th><td><?= $subscriber_details[0]['STATUS']; ?></td></tr>
						<div id="subscriber_profile_signature"><img src="<?= base_url('assets/uploads/images/member/'. $subscriber_details[0]['SIGNATURE']); ?>" alt="Member Signature" class="img-thumbnail" height="100px" width="100px"></div>
					</table>
					<div class="row">
						<div class="col">
							<button type="button" id="subscriber_profile_details_print_button" name="subscriber_profile_details_print_button" class="d-print-none btn btn-outline-secondary">Print</button>
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
	// This code will print the subscriber details on clicking the print button.
	document.getElementById("subscriber_profile_details_print_button").addEventListener('click', function(){
		window.print();
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>
