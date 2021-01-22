<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Member extends MY_Controller{
		// This function will display the member registration form.
		public function index(){
			if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $title = 'Member Registeration Panel';
            $this->load->view('member/register_view', compact('title'));
		}

        // This function will verify the member details filled on the member registration form.
        public function register_check()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            $config['upload_path'] = 'assets/uploads/images/member/';
            $config['allowed_types'] = '*';
            $config['remove_spaces'] = TRUE;
            $config['overwrite'] = TRUE;            
            $this->upload->initialize($config);

            if($this->upload->do_upload('member_image')):
                $register_data['image'] = $this->upload->data()['file_name'];
            endif;

            if($this->upload->do_upload('member_signature')):
                $register_data['signature'] = $this->upload->data()['file_name'];
            endif;
            
            if($this->upload->do_upload('member_signature') && $this->upload->do_upload('member_image')):
                // This code will generate random number so that this number could be used in email confirmation.
                $random_key = rand(1, 100000);
                $register_data['CONFIRM_KEY'] = $random_key;
                $register_data['MEMBERNAME'] = strtoupper($this->input->post('member_name'));
                $register_data['CONTACT'] = strtoupper($this->input->post('member_contact'));
                $register_data['EMAIL'] = strtoupper($this->input->post('member_email'));
                $register_data['ZIP'] = $this->input->post('member_zip');
                $register_data['CITY'] = strtoupper($this->input->post('member_city'));
                $register_data['STATE'] = strtoupper($this->input->post('member_state'));
                $register_data['GENDER'] = strtoupper($this->input->post('member_gender'));
                $register_data['DOB'] = $this->input->post('member_dob');
                $register_data['DOJ'] = $this->input->post('member_doj');
                $result = $this->MemberBMS->member_operation('insert', [], $register_data);
                if($result === TRUE):
                    // This code will set the link where to go after clicking the email confirmation link.
                    $send_email_url = base_url("index.php/member/confirm_email/" . $random_key);                    
                    // This code will set the link where to go after clicking the resend email button.
                    $resend_email_url = base_url("index.php/member/resend_email/" . $random_key . '/' . $register_data['EMAIL']);                    
                    $message =
                        '<html>
                            <head>
                                <title>Confirm Your Email</title>
                            </head>
                            <body>
                                <p>Click the below link to verify your account.</p>
                                <a href="' . $send_email_url. '">Confirm email</a>
                            </body>
                        </html>
                        ';
                    $this->email->from('chinmaymishra.falna@gmail.com', 'Admin@BMS');
                    $this->email->to($register_data['EMAIL']);
                    // $this->email->to('chinmaymishra.falna@gmail.com');
                    $this->email->subject('Email verification');
                    $this->email->message($message);
                    if($this->email->send()){
                        $this->session->set_flashdata('member_register_message', 'Member has successfully registered. Please confirm your email. <a href="' . $resend_email_url . '" class="text-success">Resend email?</a>');
                        $this->session->set_flashdata('member_register_status', 'success');
                    }
                    else{
                        $this->session->set_flashdata('register_message', 'Member has successfully registered. Mail not sent. <a href="' . $resend_email_url . '" class="text-danger">Resend email?</a>');
                        $this->session->set_flashdata('register_status', 'danger');
                    }
                else:
                    $this->session->set_flashdata('member_register_message', 'Member could not be registered.');
                    $this->session->set_flashdata('member_register_status', 'danger');
                endif;                    
                redirect('member/');
            else:
                $title = 'Member Registeration Panel';
                $this->load->view('member/register_view', compact('title'));
            endif;
        }
        
        // This function is used to check confirm the member on clicking link sent to the email..
        public function confirm_email($key)
        {
            $db_key = $this->MemberBMS->member_operation('select', array('CONFIRM_KEY'=>$key), array('EMAIL', 'CONFIRM_KEY'));
            if(count($db_key) > 0):
                $update_librarian_status = $this->MemberBMS->member_operation('update', array('EMAIL'=>$db_key[0]['EMAIL'],'CONFIRM_KEY'=>$key), '',  array('CONFIRM_KEY'=>'NULL'));
                if($update_librarian_status):
                    $this->session->set_flashdata('email_confirmation_message', 'Email confirmed successfully.');
                    $this->session->set_flashdata('email_confirmation_status', 'success');
                    $title = "Email Confirmation Panel";
                    $this->load->view('member/confirm_email', compact('title'));
                else:
                    $this->session->set_flashdata('email_confirmation_message', 'Email not confirmed due to some reason. Please try again...');
                    $this->session->set_flashdata('email_confirmation_status', 'danger');
                    $title = "Email Confirmation Panel";
                    $this->load->view('member/confirm_email', compact('title'));
                endif;
            else:
                redirect('member/');
            endif;
        }
        
        // This function will resend the email to member on clicking resend button.
        public function resend_email($key, $email)
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            if(($key !== null) && ($email !== null)):
                // This code will set the link where to go after clicking the email confirmation link.
                $send_email_url = base_url("index.php/member/confirm_email/" . $key);
                
                // This code will set the link where to go after clicking the resend email button.
                $resend_email_url = base_url("index.php/member/resend_email/" . $key . '/' . $email);
                
                $message =
                    '<html>
                        <head>
                            <title>your title</title>
                        </head>
                        <body>
                            <p>Click the below link to verify your account.</p>
                            <a href="' . $send_email_url . '">Confirm email</a>
                        </body>
                    </html>';
                $this->email->from('chinmaymishra.falna@gmail.com', 'Admin@BMS');
                $this->email->to($email);
                // $this->email->to('chinmaymishra.falna@gmail.com');
                $this->email->subject('Email verification');
                $this->email->message($message);
                if($this->email->send()){
                    $this->session->set_flashdata('member_register_message', 'Mail sent successfully. Please confirm your email. <a href="' . $resend_email_url . '" class="text-success">Resend email?</a>');
                    $this->session->set_flashdata('member_register_status', 'success');
                }
                else{
                    $this->session->set_flashdata('member_register_message', 'Mail not sent. <a href="' . $resend_email_url . '" class="text-success">Resend email?</a>');
                    $this->session->set_flashdata('member_register_status', 'success');
                }
                redirect('member/');
            else:
                redirect('member/');
            endif;
        }

        // This function will return the member name according to key up event  on the update subscriber form's subscriber name column.,
        // search member update form's member name column and search member details form's member name column.
        public function member_name()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $member_name = strtoupper($this->input->post('member_name'));
            $member_names = $this->MemberBMS->member_name($member_name);
            header('Content-Type:application/json');
            if(count($member_names) > 0):
                echo json_encode($member_names);
            else:
                echo array('not_found'=>'No data found.');
            endif;
        }

        // This function will display all members in a tabular form..
        public function all_members()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $title = 'All Member Panel';
            $all_members = $this->MemberBMS->member_operation('select');
            $this->load->view('member/all_members_view', compact(['title', 'all_members']));            
        }
        
        // This function will display search member form for updation.
        public function search_member_update()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $title = 'Search Member Update Panel';
            $this->load->view('member/search_member_update_view', compact('title'));
        }

        // This function will display the member details in updation form for updation.
        public function update_member()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            if($this->input->post("member_id") !== null):
                $member_id = $this->input->post("member_id");
                $updated_member_data = $this->MemberBMS->member_operation('select', array('MEMID'=>$member_id));            
            elseif($this->input->post("member_name") !== null):
                $member_name = $this->input->post("member_name");
                $updated_member_data = $this->MemberBMS->member_operation('select', array('MEMBERNAME'=>$member_name));
            endif;

            if(count($updated_member_data) > 0):
                $this->session->set_flashdata('book_member_message', 'No data found.');
                $this->session->set_flashdata('book_member_status', 'danger');
                $title = 'Update Member Panel';
                $this->load->view('member/update_member_view', compact(['title', 'updated_member_data']));            
            else:
                $this->session->set_flashdata('member_search_message', 'No data found.');
                $this->session->set_flashdata('member_search_status', 'danger');
                redirect('member/search_member_update');
            endif;
        }

        // This function will update the member details.
        public function update_member_check()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            $config['upload_path'] = 'assets/uploads/images/member/';
            $config['allowed_types'] = '*';
            $config['remove_spaces'] = TRUE;
            $config['overwrite'] = TRUE;            
            $this->upload->initialize($config);

            // This will check whether the member signature uploaded field is empty or not and also check member signature successfully uploaded or not?
            if(!empty($_FILES['member_signature']['name']) && $this->upload->do_upload('member_signature')):
                $update_member_data['signature'] = $this->upload->data()['file_name'];
            endif;

            // This will check whether the member image uploaded field is empty or not and also check member image successfully uploaded or not?
            if(!empty($_FILES['member_image']['name']) && $this->upload->do_upload('member_image')):
                $update_member_data['image'] = $this->upload->data()['file_name'];
            endif;

            if($this->input->post('member_id') !== null):
                $member_id = $this->input->post('member_id');
                $update_member_data['MEMBERNAME'] = strtoupper($this->input->post('member_name'));
                $update_member_data['CONTACT'] = $this->input->post('member_contact');
                $update_member_data['EMAIL'] = strtoupper($this->input->post('member_email'));
                $update_member_data['ZIP'] = $this->input->post('member_zip');
                $update_member_data['CITY'] = strtoupper($this->input->post('member_city'));
                $update_member_data['STATE'] = strtoupper($this->input->post('member_state'));
                $update_member_data['GENDER'] = strtoupper($this->input->post('member_gender'));
                $update_member_data['DOB'] = $this->input->post('member_dob');
                $update_member_data['DOJ'] = $this->input->post('member_doj');
                $update_result = $this->MemberBMS->member_operation('update', array("MEMID"=>$member_id), '', $update_member_data);
                if($update_result === true):
                    $this->session->set_flashdata('member_update_message', 'Member has successfully updated.');
                    $this->session->set_flashdata('member_update_status', 'success');
                else:
                    $this->session->set_flashdata('member_update_message', 'Member could not be updated.');
                    $this->session->set_flashdata('member_update_status', 'danger');
                endif;
                
                $title = 'Member Temporary Panel';
                $this->load->view('member/member_temporary_view', compact(['title', 'member_id']));
            else:
                redirect('member/search_member_update');                
            endif;
        }

        // This function will check whether specified id's member or specified name's member is exist or not?
        public function member_details_check()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            if($this->input->post("member_id") !== null):
                $member_id = $this->input->post("member_id");
                $member_details = $this->MemberBMS->member_operation('select', array('MEMID'=>$member_id));
            elseif(($this->input->post("member_name") !== null) && ($librarian_contact = $this->input->post("member_contact") !== null)):
                $member_name = $this->input->post("member_name");
                $member_contact = $this->input->post("member_contact");
                $member_details = $this->MemberBMS->member_operation('select', array('MEMBERNAME'=>$member_name, 'CONTACT'=>$member_contact));
            endif;

            if(count($member_details) > 0):
                $title = 'Member Details Panel';
                $this->load->view('member/member_details_view', compact(['title', 'member_details']));            
            else:
                $this->session->set_flashdata('member_search_message', 'No data found.');
                $this->session->set_flashdata('member_search_status', 'danger');
                redirect('member/search_member_details');
            endif;
        }

        // This function will dipslay the search member details form.
        public function search_member_details()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $title = 'Search Member Details Panel';
            $this->load->view('member/search_member_details_view', compact('title'));            
        }
	}        
?>