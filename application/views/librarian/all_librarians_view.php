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
					<h4 class="text-center text-white">All Librarians</h4>
				</div>
				<div class="card-body">
					<?php if(isset($all_librarians) && count($all_librarians) > 0): ?>
						<table class="table table-bordered" id="all_librarians_table">
							<tr>
								<th class="text-center">Name</th>
								<th class="text-center">Contact</th>
								<th class="text-center">Email</th>
								<th class="text-center">City</th>
								<th class="text-center">DOB</th>
								<th class="text-center">DOJ</th>
								<th class="text-center">Gender</th>
								<th class="text-center">Status</th>
								<th class="text-center" colspan="2">Action</th>
							</tr>
							<?php $count = 1; ?>
							<?php foreach($all_librarians as $librarian): ?>
								<tr>
									<td class="text-left"><?= ucwords(strtolower(($librarian['LIBNAME']))); ?></td>
									<td class="text-center"><?= $librarian['CONTACT']; ?></td>
									<td class="text-left"><?= strtolower($librarian['EMAIL']); ?></td>
									<td class="text-center"><?= ucwords(strtolower($librarian['CITY'])); ?></td>
									<td class="text-left"><?= date('d/m/y', strtotime($librarian['DOB'])); ?></td>
									<td class="text-left"><?= date('d/m/y', strtotime($librarian['DOJ'])); ?></td>
									<td class="text-center"><?= ucwords(strtolower($librarian['GENDER'])); ?></td>
									<td class="text-center"><?= ucwords(strtolower($librarian['STATUS'])); ?></td>
									<td class="text-center">								
										<?= form_open('librarian/update_librarian/', ["id"=>"hidden_librarian_updation_form" . $count, "name"=>"hidden_librarian_updation_form" . $count, "class"=>"updation_form", "target"=>"_blank"]); ?>
											<input type="hidden" name="librarian_id" id="librarian_id" value="<?= $librarian['LIBID']; ?>">
											<a href="" id="<?= 'librarian_update_button' . $count; ?>" name="<?= 'librarian_update_button' . $count; ?>"><i class="fa fa-edit" title="Update"></i></a>
										<?= form_close(); ?>
									</td>
									<td class="text-center">
										<?= form_open('librarian/librarian_details_check/', ["id"=>"hidden_librarian_view_form" . $count, "name"=>"hidden_librarian_view_form" . $count, "class"=>"view_form", "target"=>"_blank"]); ?>
											<input type="hidden" name="librarian_id" id="librarian_id" value="<?= $librarian['LIBID']; ?>">
											<a href="" id="<?= 'librarian_view_button' . $count; ?>" name="<?= 'librarian_view_button>' . $count; ?>"><i class="fa fa-eye" title="View"></i></a>
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
			document.getElementById("librarian_update_button" + count).addEventListener("click", function(e){
				e.preventDefault();
				document.getElementById("hidden_librarian_updation_form" + count).submit();
			});
		}

		// This code is used to get all element who has view_form class, so that event listener could be attached
		// and we can access details page belonging to that row.
		for(let count=1; count<=document.querySelectorAll(".view_form").length; count++){
			document.getElementById("librarian_view_button" + count).addEventListener("click", function(e){
				e.preventDefault();
				document.getElementById("hidden_librarian_view_form" + count).submit();
			});
		}
	</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>