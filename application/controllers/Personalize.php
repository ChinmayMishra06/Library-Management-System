<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Personalize extends MY_Controller{
		// This function will load the librarian profile who is currently logged in.
		public function index(){
			if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
			if($this->input->post('librarian_email') !== null):
				$librarian_email = $this->input->post('librarian_email');
				$librarian_details = $this->LibrarianBMS->librarian_operation('select', array('EMAIL'=>$librarian_email));
				$title = "My Profile";
				$this->load->view('librarian/librarian_details_view', compact(['title', 'librarian_details']));
			else:				
				$title = "My Profile";
				$this->load->view('personalize/profile_view', compact('title'));
			endif;
		}

		// This function will load the about me profile details.
		public function about(){
			if(!$this->session->userdata('admin')):
                redirect('librarian/login_view');
            endif;            
				
			$title = "About Me";
			$this->load->view('personalize/about_me_view', compact('title'));
		}
	}        
?>