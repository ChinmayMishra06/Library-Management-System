<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
?>	
<div class="row">
	<div class="colform-center">
		<div class="card">
			<div class="card-body">
				<?= form_open(base_url('index.php/librarian/change_password'), ["id"=>"forgot_password_send_email_form", "name"=>"forgot_password_send_email_form"]); ?>
				    <input type="hidden" name="forgot_email" id="forgot_email" value="<?= $forgot_email; ?>">
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</div>
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
<script>
	"use strict";
	
	// This function will be submitted automatically on successfully window loading.
	window.addEventListener("load", function(e){
		document.getElementById("forgot_password_send_email_form").submit();
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>