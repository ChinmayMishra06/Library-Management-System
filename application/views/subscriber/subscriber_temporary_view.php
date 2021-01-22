<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<?= form_open("subscriber/update_subscriber", ["id"=>"subscriber_temporary_form"]); ?>
					<input type="hidden" name="subscriber_id" id="subscriber_id" class="form-control" value="<?= $subscriber_id; ?>">                
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
<script>
	"use strict";

	// This code will submit the form on loading the window successfully.	
	window.addEventListener('load', function(e){
		e.preventDefault();
        document.getElementById("subscriber_temporary_form").submit();
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>