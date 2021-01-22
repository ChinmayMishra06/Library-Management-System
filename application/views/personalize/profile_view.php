<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once(APPPATH.'views/header_view.php');
	include_once(APPPATH.'views/sidebar_start.php');
?>
<div class="row">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<?= form_open('personalize/', ['id'=>'hidden_librarian_profile_form', 'name'=>'hidden_librarian_profile_form']); ?>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<?php
									if($this->session->userdata('admin')):
										$librarian_email = $this->session->userdata('admin');
									else:
										$librarian_email = $this->session->userdata('librarian');
									endif;
								?>
								<input type="hidden" name="librarian_email" id="librarian_email" class="form-control" value="<?php echo $librarian_email; ?>">
							</div>
						</div>
					</div>
				<?= form_close(); ?>				
			</div>
		</div>	
	</div>
</div>
<?php include_once(APPPATH.'views/sidebar_start.php'); ?>
	<script>
		// This code will submit the form when window will load successfully.
		window.addEventListener('load', function(){
			document.getElementById('hidden_librarian_profile_form').submit();
		});
	</script>
<?php include_once(APPPATH.'views/footer_view.php'); ?>