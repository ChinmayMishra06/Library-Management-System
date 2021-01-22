 min-vh-100<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="col">
    	<div class="card min-vh-100">
	    	<div class="card-header p-0">
		    	<h4 class="text-center text-white">All Issued Books</h4>
		    </div>
		    <div class="card-body">
			<?php if(count($all_issued_books) > 0): ?>
				<table class="table table-bordered table-striped" id="all_issued_books_table">
					<tr>
						<th class="text-center">Name</th>
						<th class="text-center">Contact</th>
						<th class="text-center">City</th>
						<th class="text-center">Issue</th>
						<th class="text-center">Due</th>
						<th class="text-center">Amount</th>
						<th class="text-center">Action</th>
					</tr>
					<?php $count = 1; ?>
					<?php foreach($all_issued_books as $all_issued_book): ?>
						<tr>
							<td class="text-left"><?= ucwords(strtolower($all_issued_book['MEMBERNAME'])); ?></td>
							<td class="text-center"><?= $all_issued_book['CONTACT']; ?></td>
							<td class="text-center"><?= ucwords(strtolower($all_issued_book['CITY'])); ?></td>
							<td class="text-center"><?= date('d/m/Y', strtotime($all_issued_book['ISSUE_DATE'])); ?></td>
							<td class="text-center"><?= date('d/m/Y', strtotime($all_issued_book['DUE_DATE'])); ?></td>
							<td class="text-right"><?= $all_issued_book['AMOUNT_PAID']; ?></td>
							<td class="text-center">								
								<?= form_open('book/search_issued_book_check/', ["id"=>"hidden_all_issued_view_form" . $count, "name"=>"hidden_all_issued_view_form" . $count, "class"=>"view_form", "target"=>"_blank"]); ?>
									<input type="hidden" name="subscriber_id" id="subscriber_id" value="<?= $all_issued_book['SUBID']; ?>">
									<input type="hidden" name="transaction_id" id="transaction_id" value="<?= $all_issued_book['TRANSID']; ?>">
									<a href="" id="<?= 'all_issued_view_button' . $count; ?>" name="<?= 'all_issued_view_button' . $count; ?>"><i class="fa fa-eye" title="View"></i></a>
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
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
	<script>
		"use strict";
		
		// This code is used to get all element who has view_form class, so that event listener could be attached.
		for(let count=1; count<=document.querySelectorAll(".view_form").length; count++){
			document.getElementById("hidden_all_issued_view_form" + count).addEventListener("click", function(e){
				e.preventDefault();
				document.getElementById("hidden_all_issued_view_form" + count).submit();
			});
		}
	</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>