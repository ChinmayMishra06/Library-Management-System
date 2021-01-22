<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<!-- This is main section. -->
	<div class="col">
		<div class="card min-vh-100">
			<div class="card-header p-0">
				<h4 class="text-center text-white">All Subscribers</h4>
			</div>
			<div class="card-body">				
				<?php if(isset($all_subscribers) && count($all_subscribers) > 0 ): ?>
					<table class="table table-bordered table-striped" id="all_subscribers_table">
						<tr>
							<th class="text-center">Subscriber Name</th>
							<th class="text-center">Contact</th>
							<th class="text-center">Plan Name</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Start Date</th>
							<th class="text-center">End Date</th>
							<th class="text-center">Pay Mode</th>
							<th class="text-center">Status</th>
							<th class="text-center" colspan="2">Action</th>
						</tr>
						<?php $count = 1; ?>
						<?php foreach($all_subscribers as $subscriber): ?>
							<tr>
								<td class="text-left"><?= ucwords(strtolower($subscriber['MEMBERNAME'])); ?></td>
								<td class="text-center"><?= ucwords(strtolower($subscriber['CONTACT'])); ?></td>
								<td class="text-left"><?= ucwords(strtolower($subscriber['PLANNAME'])); ?></td>
								<td class="text-center"><?= $subscriber['AMOUNT']; ?></td>
								<td class="text-center"><?= date('d/m/y', strtotime($subscriber['START'])); ?></td>
								<td class="text-center"><?= date('d/m/y', strtotime($subscriber['END'])); ?></td>
								<td class="text-center"><?= ucwords(strtolower($subscriber['PAY_MODE'])); ?></td>
								<td class="text-center"><?= ucwords(strtolower($subscriber['STATUS'])); ?></td>
								<td class="text-center">								
									<?= form_open('subscriber/update_subscriber/', ["id"=>"hidden_subscriber_updation_form" . $count, "name"=>"hidden_subscriber_updation_form" . $count, "class"=>"updation_form", "target"=>"_blank"]); ?>
										<input type="hidden" name="subscriber_id" id="subscriber_id" value="<?= $subscriber['SUBID']; ?>">
										<a href="" id="<?= 'subscription_update_button' . $count; ?>" name="<?= 'subscription_update_button' . $count; ?>"><i class="fa fa-edit" title="Update"></i></a>
									<?= form_close(); ?>
								</td>
								<td class="text-center">
									<?= form_open('subscriber/subscriber_details_check/', ["id"=>"hidden_subscriber_view_form" . $count, "name"=>"hidden_subscriber_view_form" . $count, "class"=>"view_form", "target"=>"_blank"]); ?>
										<input type="hidden" name="subscriber_id" id="subscriber_id" value="<?= $subscriber['SUBID']; ?>">
										<a href="" id="<?= 'subscription_view_button' . $count; ?>" name="<?= 'subscription_view_button>' . $count; ?>"><i class="fa fa-eye" title="View"></i></a>
									<?= form_close(); ?>
								</td>
							</tr>
							<?php $count++; ?>
						<?php endforeach; ?>
					</table>
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
		
		// This code is used to get all element who has updation_form class, so that event listener could be attached
		// and we can access update form belonging to that row.
		for(let count=1; count<=document.querySelectorAll(".updation_form").length; count++){
			document.getElementById("subscription_update_button" + count).addEventListener("click", function(e){
				e.preventDefault();
				document.getElementById("hidden_subscriber_updation_form" + count).submit();
			});
		}

		// This code is used to get all element who has view_form class, so that event listener could be attached
		// and we can access details page belonging to that row.
		for(let count=1; count<=document.querySelectorAll(".view_form").length; count++){
			document.getElementById("subscription_view_button" + count).addEventListener("click", function(e){
				e.preventDefault();
				document.getElementById("hidden_subscriber_view_form" + count).submit();
			});
		}
	</script>	
<?php include_once(APPPATH.'views/footer_view.php'); ?>