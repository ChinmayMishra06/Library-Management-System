<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="alert alert-danger" id="status_message" style="display:none;"></div>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-header p-0">
				<h4 class="text-center text-white">Issued Books Detail</h4>
			</div>
			<div class="card-body">
				<?php if(count($subscriber_book_details) > 0): ?>
					<div class="row pb-2">
						<div class="col">
							<label for="issued_member_name">Name</label>
							<input type="text" name="issued_member_name" id="issued_member_name" class="form-control" value="<?=ucwords(strtolower($subscriber_book_details[0]['MEMBERNAME'])); ?>" readonly="true;">
						</div>
						<div class="col">
							<label for="issued_member_contact">Contact</label>
							<input type="text" name="issued_member_contact" id="issued_member_contact" class="form-control" value="<?=$subscriber_book_details[0]['CONTACT']; ?>" readonly="true;">
						</div>			
						<div class="col">
							<div class="row">
								<div class="col">
									<label for="issued_member_city">City</label>
									<input type="text" name="issued_member_city" id="issued_member_city" class="form-control" value="<?=ucwords(strtolower($subscriber_book_details[0]['CITY'])); ?>" readonly="true;">
								</div>
								<div class="col">
									<label for="member_total_paid">Total Paid</label>
									<input type="text" name="member_total_paid" id="member_total_paid" class="form-control" value="<?=$subscriber_book_details[0]['TOTAL_PAID']; ?>" readonly="true;">
								</div>
							</div>
						</div>
					</div><br>
					<div class="row pb-2">
						<div class="col">
							<label for="issued_date">Issue Date</label>
							<input type="text" name="issued_date" id="issued_date" class="form-control" value="<?=date('d/m/Y', strtotime($subscriber_book_details[0]['ISSUE_DATE'])); ?>" readonly="true;">
						</div>
						<div class="col">
							<label for="due_date">Due Date</label>
							<input type="text" name="due_date" id="due_date" class="form-control" value="<?=date('d/m/Y', strtotime($subscriber_book_details[0]['DUE_DATE'])); ?>" readonly="true;">
						</div>			
						<div class="col">
							<div class="row">
								<div class="col">
									<label for="subscriber_id">SubID</label>
									<input type="text" name="subscriber_id" id="subscriber_id" class="form-control" value="<?=ucwords(strtolower($subscriber_book_details[0]['SUBID'])); ?>" readonly="true;">
								</div>
								<div class="col">
									<label for="transaction_id">TransID</label>
									<input type="text" name="transaction_id" id="transaction_id" class="form-control" value="<?=$subscriber_book_details[0]['TRANSID']; ?>" readonly="true;">
								</div>
							</div>
						</div>
					</div>
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th class="text-center">Book</th>
								<th class="text-center">Author</th>
								<th class="text-center">Publisher</th>
								<th class="text-center">Price</th>
								<th class="text-center">Quantity</th>
							</tr>
						</thead>
						<tbody>
							<?php $price = 0; $quantity = 0; ?>
							<?php foreach($subscriber_book_details as $sub_book_detail): ?>
								<?php $price += $sub_book_detail['PRICE']; $quantity++?>
								<tr>
									<td class="text-left"><?= ucwords(strtolower($sub_book_detail['BOOKNAME']));?></td>
									<td class="text-left"><?= ucwords(strtolower($sub_book_detail['AUTHOR']));?></td>
									<td class="text-left"><?= ucwords(strtolower($sub_book_detail['PUBLISHER'])); ?></td>
									<td class="text-right"><?= $sub_book_detail['PRICE'];?></td>								
									<td class="text-right">1</td>								
								</tr>
							<?php endforeach; ?>
						</tbody>
						<tfoot>
							<tr>
								<td class="text-center"></td>
								<td class="text-center"></td>
								<th class="text-center">Total</th>
								<th class="text-right"><?= $price; ?></th>
								<th class="text-right"><?= $quantity; ?></th>
							</tr>
						</tfoot>
					</table>
					<div class="row">
						<div class="col">
							<button type="button" id="issued_book_details_print_button" name="issued_book_details_print_button" class="d-print-none btn btn-outline-secondary" style="width:72px;">Print</button>
						</div>
						<div class="col mb-1 text-right">
							<img src="<?= base_url('assets/uploads/images/librarian/' . $subscriber_book_details[0]['SIGNATURE']); ?>" alt="Librarian Signature" width="100px;" height="60px;">
						</div>
					</div>
				<?php else: ?>
					<p class="text-center text-danger font-weight-bold">No data found.</p>
				<?php endif; ?>				
			</div>
		</div>
	</div>
</div>
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
	<script>
		"use strict";
		
		// This code will print the issued book details page on clicking the print button.
		document.getElementById("issued_book_details_print_button").addEventListener('click', function(){
			window.print();
		});
	</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>