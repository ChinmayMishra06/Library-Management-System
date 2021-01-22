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
					<h4 class="text-center text-white card-title">All Books</h4>
				</div>
				<div class="card-body">
					<?php if(isset($all_books) && count($all_books) > 0): ?>
						<table class="table table-bordered table-striped" id="all_books_table">
							<tr>
								<th class="text-center">Name</th>
								<th class="text-center">Author</th>
								<th class="text-center">Publisher</th>
								<th class="text-center">Price</th>
								<th class="text-center">Quantity</th>
								<th class="text-center">Image</th>
								<th class="text-center" width="1%">Action</th>
							</tr>
							<?php $count = 1; ?>
							<?php foreach($all_books as $book): ?>
								<tr>
									<td class="text-left"><?= ucwords(strtolower($book['BOOKNAME'])); ?></td>
									<td class="text-left"><?= ucwords(strtolower($book['AUTHOR'])); ?></td>
									<td class="text-left"><?= ucwords(strtolower($book['PUBLISHER'])); ?></td>
									<td class="text-center"><?= ucwords(strtolower($book['PRICE'])); ?></td>
									<td class="text-center"><?= ucwords(strtolower($book['QUANTITY'])); ?></td>
									<td class="text-center"><img src="<?= base_url('assets/uploads/images/book/'. $book['IMAGE']); ?>" alt="<?= $book['BOOKNAME']; ?>" height="40" width="40"></td>
									<td class="text-center">								
										<?= form_open(base_url('index.php/book/update_book/'), ["id"=>"hidden_book_updation_form" . $count, "name"=>"hidden_book_updation_form" . $count, "class"=>"updation_form", "target"=>"_blank"]); ?>
											<input type="hidden" name="book_id" id="book_id" value="<?= $book['BOOKID']; ?>">
											<a href="" id="<?= 'book_update_button' . $count; ?>" name="<?= 'book_update_button' . $count; ?>"><i class="fa fa-edit" title="Update"></i></a>
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
			document.getElementById("hidden_book_updation_form" + count).addEventListener("click", function(e){
				e.preventDefault();
				document.getElementById("hidden_book_updation_form" + count).submit();
			});
		}
	</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>