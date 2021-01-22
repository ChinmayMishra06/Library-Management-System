<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<?= form_open("plan/update_plan", ["id"=>"plan_temporary_form"]); ?>
					<input type="hidden" name="plan_id" id="plan_id" class="form-control" value="<?= $plan_id; ?>">                
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
        document.getElementById("plan_temporary_form").submit();
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>