<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Librarian extends MY_Controller {
        // This function will executed automatically. This is default function.
        public function index()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $title = 'Librarian Registeration Panel';
            $this->load->view('librarian/register_view', compact('title'));            
        }
        
        // This function will display librarian registration form.
        public function login_view()
        {
            if($this->session->userdata('admin') || $this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            $title = 'Librarian Login Panel';
            $this->load->view('librarian/login_view', compact('title'));
        }

        // This function will verify whether the librarian valid or not?
        public function login_check()
        {
            if($this->session->userdata('admin') || $this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            if(($this->input->post('librarian_email') !== null) && ($this->input->post('librarian_password') !== null)):
                $login_data['EMAIL'] = strtoupper($this->input->post('librarian_email'));
                $login_data['PASSWORD'] = md5($this->input->post('librarian_password'));
                $login_credentials = $this->LibrarianBMS->librarian_operation('select', $login_data, array('STATUS', 'ROLE', 'EMAIL', 'CONFIRM_KEY'));
                if(count($login_credentials) > 0):
                    if($login_credentials[0]['CONFIRM_KEY'] === '0'):
                        if($login_credentials[0]['STATUS'] === 'ACTIVATE'):
                            if($login_credentials[0]['ROLE'] === 'ADMIN'):
                                $this->session->set_userdata('admin', $login_credentials[0]['EMAIL']);
                            else:
                                $this->session->set_userdata('librarian', $login_credentials[0]['EMAIL']);
                            endif;    
                            redirect('librarian/');
                        else:
                            $this->session->set_flashdata('login_message', 'Your account is deactivate.');
                            $this->session->set_flashdata('login_status', 'danger');
                            redirect('librarian/login_view');
                        endif;
                    else:
                        $this->session->set_flashdata('login_message', 'Please confirm your email.');
                        $this->session->set_flashdata('login_status', 'danger');
                        redirect('librarian/login_view');
                    endif;
                else:
                    $this->session->set_flashdata('login_message', 'Invalid credential details.');
                    $this->session->set_flashdata('login_status', 'danger');
                    redirect('librarian/login_view');
                endif;
            else:
                redirect('librarian/login_view');
            endif;
        }

        // This function will verify the librarian details filled on the registration form.
        public function register_check()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;

            $config['upload_path'] = 'assets/uploads/images/librarian';
            $config['allowed_types'] = '*';
            $config['remove_spaces'] = TRUE;
            $config['overwrite'] = TRUE;            
            $this->upload->initialize($config);
            
            
            if($this->upload->do_upload('librarian_image')):
                $register_data['IMAGE'] = $this->upload->data()['file_name'];
            endif;

            if($this->upload->do_upload('librarian_signature')):
                $register_data['SIGNATURE'] = $this->upload->data()['file_name'];
            endif;

            if($this->upload->do_upload('librarian_signature') && $this->upload->do_upload('librarian_image')):
                // This code will generate random number so that this number could be used in email confirmation.
                $random_key = rand(1, 100000);
                $register_data['CONFIRM_KEY'] = $random_key;
                $register_data['LIBNAME'] = trim(strtoupper($this->input->post('librarian_name')));
                $register_data['CONTACT'] = trim(strtoupper($this->input->post('librarian_contact')));
                $register_data['EMAIL'] = trim(strtoupper($this->input->post('librarian_email')));
                $register_data['GENDER'] = trim(strtoupper($this->input->post('librarian_gender')));
                $register_data['ZIP'] = trim($this->input->post('librarian_zip'));
                $register_data['CITY'] = trim(strtoupper($this->input->post('librarian_city')));
                $register_data['STATE'] = trim(strtoupper($this->input->post('librarian_state')));
                $register_data['PASSWORD'] = md5('password');
                $register_data['DOB'] = trim($this->input->post('librarian_dob'));
                $register_data['DOJ'] = trim($this->input->post('librarian_doj'));
                $register_data['ROLE'] = trim(strtoupper($this->input->post('librarian_role')));
                $result = $this->LibrarianBMS->librarian_operation('insert', '', $register_data);
                if($result === TRUE):
                    // This code will set the link where to go after clicking the email confirmation link.
                    $send_email_url = base_url("index.php/librarian/confirm_email/" . $random_key);                    
                    // This code will set the link where to go after clicking the resend email button.
                    $resend_email_url = base_url("index.php/librarian/resend_email/" . $random_key . '/' . $register_data['EMAIL']);                    
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
                    $this->email->subject('Email Verification');
                    $this->email->message($message);
                    if($this->email->send()){
                        $this->session->set_flashdata('register_message', 'Librarian has successfully registered. Please confirm your email. <a href="'. $resend_email_url . '" class="text-success">Resend email?</a>');
                        $this->session->set_flashdata('register_status', 'success');
                    }
                    else{
                        $this->session->set_flashdata('register_message', 'Librarian has successfully registered. Mail not sent. <a href="' . $resend_email_url . '" class="text-danger">Resend email?</a>');
                        $this->session->set_flashdata('register_status', 'danger');
                    }
                else:
                    $this->session->set_flashdata('register_message', 'Librarian could not be registered.');
                    $this->session->set_flashdata('register_status', 'danger');
                endif;                    
                redirect('librarian/');
            else:
                $title = 'Librarian Registeration Panel';
                $this->load->view('librarian/register_view', compact('title'));
            endif;
        }
        
        // This function is used to confirm the librarian on clicking link sent to the email..
        public function confirm_email($key)
        {
            $db_key = $this->LibrarianBMS->librarian_operation('select', array('CONFIRM_KEY'=>$key), array('EMAIL', 'STATUS', 'CONFIRM_KEY'));
            if(count($db_key) > 0):
                $update_librarian_status = $this->LibrarianBMS->librarian_operation('update', array('EMAIL'=>$db_key[0]['EMAIL'],'CONFIRM_KEY'=>$key), '',  array('STATUS'=>'ACTIVATE', 'CONFIRM_KEY'=>'NULL'));
                if($update_librarian_status):
                    // This code will set the link where to go after email confirmation on clicking Login link.
                    $login_url = base_url("index.php/librarian/login_view");
                    
                    $this->session->set_flashdata('email_confirmation_message', 'Email confirmed successfully. <a href="' . $login_url . '" class="text-success">Login?</a>');
                    $this->session->set_flashdata('email_confirmation_status', 'success');
                    $title = "Email Confirmation Panel";
                    $this->load->view('librarian/confirm_email', compact('title'));
                else:
                    $this->session->set_flashdata('email_confirmation_message', 'Email not confirmed due to some reason. Please try again...');
                    $this->session->set_flashdata('email_confirmation_status', 'danger');
                    $title = "Email Confirmation Panel";
                    $this->load->view('librarian/confirm_email', compact('title'));
                endif;
            else:
                redirect('librarian/');
            endif;
        }
        
        // This function will resend the email to librarian on clicking resend email button.
        public function resend_email($key, $email)
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            if(($key !== null) && ($email !== null)):
                // This code will set the link where to go after clicking the email confirmation link.
                $send_email_url = base_url("index.php/librarian/confirm_email/" . $key);
                
                // This code will set the link where to go after clicking the resend email button.
                $resend_email_url = base_url("index.php/librarian/resend_email/" . $key . '/' . $email);
                
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
                $this->email->subject('Email Verification');
                $this->email->message($message);
                if($this->email->send()){
                    $this->session->set_flashdata('register_message', 'Mail sent successfully. Please confirm your email. <a href="' . $resend_email_url . '" class="text-success">Resend email?</a>');
                    $this->session->set_flashdata('register_status', 'success');
                }
                else{
                    $this->session->set_flashdata('register_message', 'Mail not sent. <a href="' . $resend_email_url . '" class="text-success">Resend email?</a>');
                    $this->session->set_flashdata('register_status', 'success');
                }
                redirect('librarian/');
            else:
                redirect('librarian/');
            endif;
        }

        // This function will display forgot password form.
        public function forgot_password()
        {
            if($this->session->userdata('admin') || $this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            $title = 'Forgot Password Panel';
            $this->load->view('librarian/forgot_password_view', compact('title'));
        }

        // This function will check librarian details filled on forgot password form.
        public function forgot_password_check()
        {
            if($this->session->userdata('admin') || $this->session->userdata('librarian')):
                redirect('librarian/');
            endif;

            if($this->input->post('forgot_email') !== null):
                $forgot_email_password = $this->LibrarianBMS->librarian_operation('select', array('EMAIL'=>strtoupper($this->input->post('forgot_email'))), array('EMAIL', 'CONFIRM_KEY'));
                if(count($forgot_email_password) > 0):                    
                    // This code will check whether the librarian has confirmed his email or not?
                    if(($forgot_email_password[0]['CONFIRM_KEY'] === "0")):
                        // This code will be send to the email, so that email coulde be verified and changed.
                        $send_forgot_email_url = base_url("index.php/librarian/forgot_password_email/" . $this->input->post('forgot_email'));                        
                        // This code will be send to the email, so that email coulde be verified and changed.
                        $resend_forgot_email_url = base_url("index.php/librarian/forgot_password_resend_email/" . $this->input->post('forgot_email'));
                        $message =
                            '<html>
                                <head>
                                    <title>Confirm Your Forgot Email</title>
                                </head>
                                <body>
                                    <p>Click the below link to confirm your forgot email.</p>
                                    <a href="'. $send_forgot_email_url .'">Confirm forgot email</a>
                                </body>
                            </html>
                            ';
                        $this->email->from('chinmaymishra.falna@gmail.com', 'Admin@BMS');
                        $this->email->to($forgot_email_password[0]['EMAIL']);
                        $this->email->subject("Forgot Email Verification");
                        $this->email->message($message);
                        if($this->email->send()):
                            $this->session->set_flashdata('forgot_email_confirmation_message', 'Mail sent successfully. Please confirm your email.  <a href="'. $resend_forgot_email_url .'" class="text-success">Resend email?</a>');
                            $this->session->set_flashdata('forgot_email_confirmation_status', 'success');
                        else:
                            $this->session->set_flashdata('forgot_password_message', 'Mail not sent successfully. <a href="' . $resend_forgot_email_url . '" class="text-danger">Resend email?</a>');
                        endif;
                        redirect('librarian/confirm_forgot_password');
                    else:
                        $this->session->set_flashdata('forgot_password_message', 'First confirm your email.');
                        redirect('librarian/forgot_password');
                    endif;
                else:
                    $this->session->set_flashdata('forgot_password_message', 'Email doesn\'t exist.');
                    redirect('librarian/forgot_password');
                endif;
            else:
                redirect('librarian/forgot_password');                
            endif;
        }
        
        // This function will resend the email to librarian on clicking resend email button.
        public function resend_forgot_email()
        {
            if($this->session->userdata('admin') && $this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            if($this->input->post('forgot_email') !== null):
                $forgot_email = $this->input->post('forgot_email');
                // This code will set the link where to go after clicking the email confirmation link.
                $send_email_url = base_url("index.php/librarian/forgot_password_email/" . $forgot_email);                
                // This code will set the link where to go after clicking the resend email button.
                $resend_email_url = base_url("index.php/librarian/forgot_password_resend_email/" . $forgot_email);                
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
                $this->email->to($forgot_email);
                $this->email->subject('Forgot Email Verification');
                $this->email->message($message);
                if($this->email->send()){
                    $this->session->set_flashdata('forgot_email_confirmation_message', 'Mail sent successfully. Please confirm your email. <a href="' . $resend_email_url . '" class="text-success">Resend email?</a>');
                    $this->session->set_flashdata('forgot_email_confirmation_status', 'success');
                }
                else{
                    $this->session->set_flashdata('forgot_email_confirmation_message', 'Mail not sent. <a href="' . $resend_email_url . '" class="text-success">Resend email?</a>');
                    $this->session->set_flashdata('forgot_email_confirmation_status', 'success');
                }
                redirect('librarian/confirm_forgot_password');
            else:
                redirect('librarian/');
            endif;
        }

        // This function is used to store librarian email for temporary purpose so that email could be sent.
        public function forgot_password_email($forgot_email)
        {
            if($this->session->userdata('admin') || $this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            if($forgot_email !== null):
                $title = 'Forgot Password Send Email Panel';
                $this->load->view('librarian/forgot_password_send_email_view', compact(['title', 'forgot_email']));
            else:
                redirect('librarian/forgot_password');
            endif;
        }

        // This function is used to store librarian email for temporary purpose so that email could be resent.
        public function forgot_password_resend_email($forgot_email)
        {
            if($this->session->userdata('admin') || $this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            if($forgot_email !== null):
                $title = 'Forgot Password Resend Email Panel';
                $this->load->view('librarian/forgot_password_resend_email_view', compact(['title', 'forgot_email']));
            else:
                redirect('librarian/forgot_password');
            endif;
        }
        
        // This function is used to reflect the message of send, resend forgot email..
        public function confirm_forgot_password()
        {
            if($this->session->userdata('admin') || $this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
                
            $title = 'Confirm Forgot Email Panel';
            $this->load->view('librarian/confirm_forgot_password_view', compact(['title']));
        }
        
        // This function will display librarian change password form.
        public function change_password()
        {
            if($this->session->userdata('admin') || $this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            if($this->input->post('forgot_email') !== null):
                $forgot_email = $this->LibrarianBMS->librarian_operation('select', array('EMAIL'=>strtoupper($this->input->post('forgot_email'))), 'EMAIL');
                if(count($forgot_email) > 0):
                    $title = 'Change Password Panel';
                    $this->load->view('librarian/change_password_view', compact(['title', 'forgot_email']));
                else:
                    $this->session->set_flashdata('forgot_password_message', 'Invalid details.');
                    redirect('librarian/forgot_password');
                endif;
            else:
                redirect('librarian/forgot_password');
            endif;
        }

        // This function will verify the details filled on change password form.
        public function change_password_check()
        {
            if($this->session->userdata('admin') || $this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            if($this->input->post('forgot_email') !== null):
                $result = $this->LibrarianBMS->librarian_operation('update', array('EMAIL'=>strtoupper($this->input->post('forgot_email'))), '', array('PASSWORD'=>md5($this->input->post('new_password'))));
                if($result):
                    $this->session->set_flashdata('login_message', 'Password changed successfully.');
                    $this->session->set_flashdata('login_status', 'success');
                    redirect('librarian/login_view');
                else:
                    $this->session->set_flashdata('forgot_password_message', 'Email doesn\'t exist.');
                    redirect('librarian/forgot_password');
                endif;
            else:
                redirect('librarian/forgot_password');            
            endif;
        }        
        
        // This function will display all librarians in a tabular form.
        public function all_librarian()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $title = 'All Librarian Panel';
            $all_librarians = $this->LibrarianBMS->librarian_operation('select');
            $this->load->view('librarian/all_librarians_view', compact(['title', 'all_librarians']));
        }
        
        // This function will display search librarian form.
        public function profile_search()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $title = 'Profile Search Panel';
            $this->load->view('librarian/profile_search_view', compact('title'));
        }

        // This function will display search librarian form.
        public function search_librarian_update()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $title = 'Search Librarian Update Panel';
            $this->load->view('librarian/search_librarian_update_view', compact('title'));
        }

        // This function will display the librarian details in tabular form for updation.
        public function update_librarian()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            if($this->input->post("librarian_id") !== null):
                $librarian_id = $this->input->post("librarian_id");
                $updated_librarian_data = $this->LibrarianBMS->librarian_operation('select', array('LIBID'=>$librarian_id));
            elseif($this->input->post("librarian_name") !== null):
                $librarian_name = $this->input->post("librarian_name");
                $librarian_contact = $this->input->post("librarian_contact");
                $updated_librarian_data = $this->LibrarianBMS->librarian_operation('select', array('LIBNAME'=>$librarian_name, 'CONTACT'=>$librarian_contact));
            endif;

            if(count($updated_librarian_data) > 0):
                $title = 'Update Librarian Panel';
                $this->load->view('librarian/update_librarian_view', compact(['title', 'updated_librarian_data']));            
            else:
                $this->session->set_flashdata('librarian_search_message', 'No data found.');
                $this->session->set_flashdata('librarian_search_status', 'danger');
                redirect('librarian/search_librarian_update');
            endif;
            
        }

        // This function will update the librarian details.
        public function update_librarian_check()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;

            $config['upload_path'] = 'assets/uploads/images/librarian';
            $config['allowed_types'] = '*';
            $config['remove_spaces'] = TRUE;
            $config['overwrite'] = TRUE;            
            $this->upload->initialize($config);            
            
            // This will check whether the membelibrarian signature uploaded field is empty or not and also check librarian signature successfully uploaded or not?
            if(!empty($_FILES['librarian_signature']['name']) && $this->upload->do_upload('librarian_signature')):
                $update_librarian_data['signature'] = $this->upload->data()['file_name'];
            endif;

            // This will check whether the librarian signature uploaded field is empty or not and also check librarian signature successfully uploaded or not?
            if(!empty($_FILES['librarian_image']['name']) && $this->upload->do_upload('librarian_image')):
                $update_librarian_data['image'] = $this->upload->data()['file_name'];
            endif;

            if($this->input->post('librarian_id') !== null):
                $librarian_id = $this->input->post('librarian_id');
                $update_librarian_data['LIBNAME'] = strtoupper($this->input->post('librarian_name'));
                $update_librarian_data['CONTACT'] = $this->input->post('librarian_contact');
                $update_librarian_data['EMAIL'] = strtoupper($this->input->post('librarian_email'));
                $update_librarian_data['ZIP'] = $this->input->post('librarian_zip');
                $update_librarian_data['CITY'] = strtoupper($this->input->post('librarian_city'));
                $update_librarian_data['STATE'] = strtoupper($this->input->post('librarian_state'));
                $update_librarian_data['GENDER'] = strtoupper($this->input->post('librarian_gender'));
                $update_librarian_data['ROLE'] = strtoupper($this->input->post('librarian_role'));
                $update_librarian_data['DOB'] = $this->input->post('librarian_dob');
                $update_librarian_data['DOJ'] = $this->input->post('librarian_doj');
                $update_result = $this->LibrarianBMS->librarian_operation('update', array("LIBID"=>$librarian_id), '', $update_librarian_data);
                if($update_result === true):
                    $this->session->set_flashdata('librarian_update_message', 'Librarian has successfully updated.');
                    $this->session->set_flashdata('librarian_update_status', 'success');
                else:
                    $this->session->set_flashdata('librarian_update_message', 'Librarian could not be updated.');
                    $this->session->set_flashdata('librarian_update_status', 'danger');
                endif;
                
                $title = 'Librarian Temporary Panel';
                $this->load->view('librarian/librarian_temporary_view', compact(['title', 'librarian_id']));
            else:
                redirect('librarian/search_librarian_update');
            endif;
        }

        // This function will return the librarian name according to key up event on search librarian update form's librarian name column
        // and search librarian details form's librarian name column.
        public function librarian_name()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            $librarian_name = strtoupper($this->input->post('librarian_name'));
            $librarian_names = $this->LibrarianBMS->librarian_name($librarian_name);
            header('Content-Type:application/json');
            if(count($librarian_names) > 0):
                echo json_encode($librarian_names);
            else:
                echo array('not_found'=>'No data found.');
            endif;
        }

        // This function will check whether specified id's librarian exist or not?
        public function search_librarian_details()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $title = 'Search Librarian Details Panel';
            $this->load->view('librarian/search_librarian_details_view', compact('title'));            
        } 

        // This function will check whether specified id's librarian exist or not?
        public function librarian_details_check()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            if($this->input->post("librarian_id") !== null):
                $librarian_id = $this->input->post("librarian_id");
                $librarian_details = $this->LibrarianBMS->librarian_operation('select', array('LIBID'=>$librarian_id));
            elseif(($this->input->post("librarian_name") !== null) && ($librarian_contact = $this->input->post("librarian_contact") !== null)):
                $librarian_name = $this->input->post("librarian_name");
                $librarian_contact = $this->input->post("librarian_contact");
                $librarian_details = $this->LibrarianBMS->librarian_operation('select', array('LIBNAME'=>$librarian_name, 'CONTACT'=>$librarian_contact));
            endif;

            if(count($librarian_details) > 0):
                $title = 'Librarian Details Panel';
                $this->load->view('librarian/librarian_details_view', compact(['title', 'librarian_details']));            
            else:
                $this->session->set_flashdata('librarian_details_message', 'No data found.');
                $this->session->set_flashdata('librarian_details_status', 'danger');
                redirect('librarian/search_librarian_details');
            endif;
        }

        // This function will logout the librarian on clicking logout button.
        public function logout()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            if($this->session->userdata('admin')):
                $this->session->unset_userdata('admin');
            else:
                $this->session->unset_userdata('librarian');
            endif;
            $this->session->set_flashdata('logout_message', 'You have logout successfully.');
            redirect('librarian/login_view');
        }
    }
?>