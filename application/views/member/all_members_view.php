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
				<h4 class="text-center text-white">All Members</h4>
			</div>
			<div class="card-body">
				<?php if(isset($all_members) && count($all_members) > 0): ?>				
					<table class="table table-bordered table-striped" id="all_members_table">
						<tr>
							<th class="text-center">Name</th>
							<th class="text-center">Contact</th>
							<th class="text-center">Email</th>
							<th class="text-center">City</th>
							<th class="text-center">DOB</th>
							<th class="text-center">DOJ</th>
							<th class="text-center">Gender</th>
							<th class="text-center" colspan="2">Action</th>
						</tr>
						<?php $count = 1; ?>
						<?php foreach($all_members as $member): ?>
							<tr>
								<td class="text-left"><?= ucwords(strtolower(($member['MEMBERNAME']))); ?></td>
								<td class="text-center"><?= $member['CONTACT']; ?></td>
								<td class="text-left"><?= strtolower($member['EMAIL']); ?></td>
								<td class="text-center"><?= ucwords(strtolower($member['CITY'])); ?></td>
								<td class="text-center"><?= date('d/m/y', strtotime($member['DOB'])); ?></td>
								<td class="text-center"><?= date('d/m/y', strtotime($member['DOJ'])); ?></td>
								<td class="text-center"><?= ucwords(strtolower($member['GENDER'])); ?></td>
								<td class="text-center">								
									<?= form_open('member/update_member/', ["id"=>"hidden_member_updation_form" . $count, "name"=>"hidden_member_updation_form" . $count, "class"=>"updation_form", "target"=>"_blank"]); ?>
										<input type="hidden" name="member_id" id="member_id" value="<?= $member['MEMID']; ?>">
										<a href="" id="<?= 'member_update_button' . $count; ?>" name="<?= 'member_update_button' . $count; ?>"><i class="fa fa-edit" title="Update"></i></a>
									<?= form_close(); ?>
								</td>
								<td class="text-center">
									<?= form_open('member/member_details_check/', ["id"=>"hidden_member_view_form" . $count, "name"=>"hidden_member_view_form" . $count, "class"=>"view_form", "target"=>"_blank"]); ?>
										<input type="hidden" name="member_id" id="member_id" value="<?= $member['MEMID']; ?>">
										<a href="" id="<?= 'member_view_button' . $count; ?>" name="<?= 'member_view_button>' . $count; ?>"><i class="fa fa-eye" title="View"></i></a>
									<?= form_close(); ?>
								</td>
							</tr>
							<?php $count++; ?>
						<?php endforeach; ?>
					</table>
				<?php else: ?>
					<div class="text-center text-white font-weight-bold">No data found.</div>
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
			document.getElementById("member_update_button" + count).addEventListener("click", function(e){
				e.preventDefault();
				document.getElementById("hidden_member_updation_form" + count).submit();
			});
		}

		// This code is used to get all element who has view_form class, so that event listener could be attached
		// and we can access details page belonging to that row.
		for(let count=1; count<=document.querySelectorAll(".view_form").length; count++){
			document.getElementById("member_view_button" + count).addEventListener("click", function(e){
				e.preventDefault();
				document.getElementById("hidden_member_view_form" + count).submit();
			});
		}	
	</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>