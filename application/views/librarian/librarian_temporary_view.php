<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="container">
	<div class="row">
		<div class="col">
            <?= form_open("librarian/update_librarian", ["id"=>"librarian_temporary_form"]); ?>
                <input type="hidden" name="librarian_id" id="librarian_id" class="form-control" value="<?= $librarian_id; ?>">                
            <?= form_close(); ?>
		</div>
	</div>
</div>
<?php include_once(APPPATH.'views/sidebar_end.php'); ?>
<script>
	"use strict";

	// This code will submit the form on loading the window successfully.
	window.addEventListener('load', function(e){
		e.preventDefault();
        document.getElementById("librarian_temporary_form").submit();
	});
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>