<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
?>
<div class="container-fluid">
    <div class="row">
    	<div class="col">
    		<div class="card">
    			<div class="card-header p-0">
    				<h4 class="text-center text-white">Forgot Email Confirmation</h4>
    			</div>
    			<div class="card-body">
    				<?php if($this->session->flashdata('forgot_email_confirmation_message')): ?>
    					<div class="alert alert-<?php if($this->session->flashdata('forgot_email_confirmation_status')): echo $this->session->flashdata('forgot_email_confirmation_status'); ?> alert-dismissible"><?= $this->session->flashdata("forgot_email_confirmation_message"); endif; ?>
    						<button type="button" class="close" data-dismiss="alert">&times;</button>
    					</div>
    				<?php endif; ?>					
    			</div>
    		</div>
    	</div>
    </div>
</div>
<script>
	"use strict";
</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>