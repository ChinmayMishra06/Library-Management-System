<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Admin extends MY_Controller{
		// This is default admint controller function.
		public function index(){
			if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            $title = "Admin Panel";
			$this->load->view('admin/demo_view.php', compact('title'));
		}
	}
?>