<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="col">
		<div class="card min-vh-100">
			<div class="card-header p-0">
				<h4 class="text-center text-white">All Plans</h4>
			</div>
			<div class="card-body">
				<?php if(isset($all_plans) && count($all_plans) > 0): ?>
					<table class="table table-bordered table-striped" id="all_plans_table">
						<tr>
							<th class="text-center">Name</th>
							<th class="text-center">Price</th>
							<th class="text-center">Validity</th>
							<th class="text-center">Status</th>
							<th class="text-center">Action</th>
						</tr>
						<?php $count = 1; ?>
						<?php foreach($all_plans as $plan): ?>
							<tr>
								<td class="text-left"><?= ucwords(strtolower($plan['PLANNAME'])); ?></td>
								<td class="text-center"><?= $plan['AMOUNT']; ?></td>
								<td class="text-center"><?= $plan['VALIDITY']; ?></td>
								<td class="text-center"><?= ucwords(strtolower($plan['STATUS'])); ?></td>
								<td class="text-center">
									<?= form_open('plan/update_plan/', ["id"=>"hidden_plan_updation_form" . $count, "name"=>"hidden_plan_updation_form" . $count, "class"=>"updation_form", "target"=>"_blank"]); ?>
										<input type="hidden" name="plan_id" id="plan_id" value="<?= $plan['PLANID']; ?>">
										<a href="" id="<?= 'plan_update_button' . $count; ?>" name="<?= 'plan_update_button' . $count; ?>"><i class="fa fa-edit" title="Update"></i></a>
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
			document.getElementById("plan_update_button" + count).addEventListener("click", function(e){
				e.preventDefault();
				document.getElementById("hidden_plan_updation_form" + count).submit();
			});
		}
	</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>