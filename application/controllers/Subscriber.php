<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Subscriber extends MY_Controller{
        // This function will display subscriber registration form.
		public function index(){
			if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $title = 'Subscriber Registeration Panel';
            $subscriber_names = $this->PlanBMS->plan_operation('select', array('STATUS'=>'ACTIVATE'), 'PLANNAME');
            $subscriber_names = $this->MemberBMS->member_operation('select', [], array('MEMBERNAME', 'CONTACT'));
            $this->load->view('subscriber/register_view', compact(['title', 'subscriber_names', 'subscriber_names']));
		}

        // This function will verify the subscriber details filled on the subscriber registration form.
        public function register_check()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $plan_details = $this->PlanBMS->plan_operation('select', array('PLANNAME'=>$this->input->post('plan_name')), array('PLANID', 'AMOUNT', 'VALIDITY'));
            $member_details = $this->MemberBMS->member_operation('select', array('MEMBERNAME'=>$this->input->post('member_name'), 'CONTACT'=>$this->input->post('member_contact')), array('MEMID', 'CONFIRM_KEY'));
            if($member_details[0]['CONFIRM_KEY'] === '0'):
                if($plan_details && $member_details):
                    $register_data['PLANID'] = $plan_details[0]['PLANID'];
                    $register_data['MEMID'] = $member_details[0]['MEMID'];
                    $register_data['START'] = date("Y/m/d");
                    $register_data['END'] = date('Y/m/d', strtotime("+ " . $plan_details[0]['VALIDITY'] . " day"));
                    $register_data['PAY_MODE'] = strtoupper($this->input->post('pay_mode'));
                    $result = $this->SubscriberBMS->subscriber_operation('insert', '', $register_data);
                    if($result === TRUE):
                        $this->session->set_flashdata('subscriber_register_message', 'Subscriber has successfully registered.');
                        $this->session->set_flashdata('subscriber_register_status', 'success');
                    else:
                        $this->session->set_flashdata('subscriber_register_message', 'Subscriber could not be registered.');
                        $this->session->set_flashdata('subscriber_register_status', 'danger');
                    endif;                    
                    redirect('subscriber/');
                else:
                    $title = 'Subscriber Registeration Panel';
                    $subscriber_names = $this->PlanBMS->subscriber_operation('select', array('STATUS'=>'ACTIVATE'), 'PLANNAME');
                    $subscriber_names = $this->SubscriberBMS->subscriber_operation('select', [], array('NAME', 'CONTACT'));
                    $this->load->view('subscriber/register_view', compact(['title', 'subscriber_names', 'subscriber_names']));
                endif;
            else:    
                $this->session->set_flashdata('subscriber_register_message', 'Please confirm your email.');
                $this->session->set_flashdata('subscriber_register_status', 'danger');
                redirect('subscriber/');
            endif;
        }

        // This function will display all active subscribers in a tabular form.
        public function all_subscribers()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $all_subscribers = $this->SubscriberBMS->subscriber_operation('join');
            $title = 'All Subscribers Panel';
            $this->load->view('subscriber/all_subscribers_view', compact(['title', 'all_subscribers']));
        }

        // This function will display search subscriber details form?
        public function search_subscriber_details()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            $title = 'Search Subscriber Details Panel';
            $this->load->view('subscriber/search_subscriber_details_view', compact('title'));            
        }

        // This function will check whether specified id's subscriber or specified name's subscriber is exist or not?
        public function subscriber_details_check()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            if($this->input->post("subscriber_id") !== null):
                $subscriber_id = $this->input->post("subscriber_id");
                $subscriber_details = $this->SubscriberBMS->subscriber_details_by_id($subscriber_id);
            elseif(($this->input->post("subscriber_name") !== null) && ($this->input->post("subscriber_name") !== null)):
                $subscriber_name = $this->input->post("subscriber_name");
                $subscriber_contact = $this->input->post("subscriber_contact");
                $subscriber_details = $this->SubscriberBMS->subscriber_details_by_name($subscriber_name, $subscriber_contact);
            endif;
            
            if(count($subscriber_details) > 0):
                $title = 'Subscriber Details Panel';
                $this->load->view('subscriber/subscriber_details_view', compact(['title', 'subscriber_details']));            
            else:
                $this->session->set_flashdata('subscriber_details_message', 'No data found.');
                $this->session->set_flashdata('subscriber_details_status', 'danger');
                redirect('subscriber/search_subscriber_details');
            endif;
        }

        // This function will return the subscriber name according to key up event on  on the serach subscriber details form's subscriber name column
        // and search subscriber update form's subscriber name column.
        public function subscriber_name()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;

            if($this->input->post('subscriber_name') !== null):
                $subscriber_name = strtoupper($this->input->post('subscriber_name'));
                $subscriber_names = $this->SubscriberBMS->subscriber_name($subscriber_name);
                header('Content-Type:application/json');
                if(count($subscriber_names) > 0):
                    echo json_encode($subscriber_names);
                else:
                    echo array('not_found'=>'No data found.');
                endif;
            else:
                redirect('subscriber/search_subscriber_details');
            endif;
        }

        // This function will display search subscriber form for updation.
        public function search_subscriber_update()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $title = 'Search Subscriber Update Panel';
            $this->load->view('subscriber/search_subscriber_update_view', compact('title'));
        }

        // This function will display the subscriber details in updation form for the updation.
        public function update_subscriber()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            if($this->input->post("subscriber_id") !== null):
                $subscriber_id = $this->input->post("subscriber_id");
                $updated_subscriber_data = $this->SubscriberBMS->subscriber_details_by_id($subscriber_id);
            elseif(($this->input->post("subscriber_name") !== null) && ($this->input->post("subscriber_contact") !== null)):
                $subscriber_name = $this->input->post("subscriber_name");
                $subscriber_contact = $this->input->post("subscriber_contact");
                $updated_subscriber_data = $this->SubscriberBMS->subscriber_details_by_name($subscriber_name, $subscriber_contact);
            endif;
            
            if(count($updated_subscriber_data) > 0):
                $title = 'Update Subscriber Panel';
                $this->load->view('subscriber/update_subscriber_view', compact(['title', 'updated_subscriber_data']));
            else:
                $this->session->set_flashdata('subscriber_search_message', 'No data found.');
                $this->session->set_flashdata('subscriber_search_status', 'danger');
                redirect('subscriber/search_subscriber_update');
            endif;
        }

        // This function will update the subscriber.
        public function update_subscriber_check()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;            

            if(($this->input->post('subscriber_name') !== null) && ($this->input->post('subscriber_contact') !== null)):
                $subscriber_data['MEMBERNAME'] = strtoupper($this->input->post('subscriber_name'));
                $subscriber_data['CONTACT'] = $this->input->post('subscriber_contact');
                $subscriber_id = $this->input->post("subscriber_id");
                $subscriber_data_result = $this->MemberBMS->member_operation('select', $subscriber_data, ['MEMID']);
                if(count($subscriber_data_result) > 0):
                    $plan_data['PLANNAME'] = strtoupper($this->input->post('plan_name'));
                    $plan_data['STATUS'] = "ACTIVATE";
                    $plan_data_result = $this->PlanBMS->plan_operation('select', $plan_data, ['PLANID', "VALIDITY"]);
                    if(count($plan_data_result) > 0):
                        $subscriber_data = $this->SubscriberBMS->subscriber_operation('select', array('SUBID'=>$subscriber_id));
                        if(count($subscriber_data) > 0):                        
                            $update_subscriber_data['PLANID'] = $plan_data_result[0]['PLANID'];
                            $update_subscriber_data['MEMID'] = $subscriber_data_result[0]['MEMID'];
                            $update_subscriber_data['END'] = date("Y/m/d", strtotime($subscriber_data[0]['START'] . " + " . $plan_data_result[0]['VALIDITY'] . " day"));
                            $update_subscriber_data['PAY_MODE'] = strtoupper($this->input->post('subscription_pay_mode'));
                            $update_subscriber_data['STATUS'] = strtoupper($this->input->post('subscription_status'));                        
                            $update_result = $this->SubscriberBMS->subscriber_operation('update', array('SUBID'=>$subscriber_id), '', $update_subscriber_data);
                            if($update_result === true):
                                $this->session->set_flashdata('subscriber_update_message', 'Subscription has successfully updated.');
                                $this->session->set_flashdata('subscriber_update_status', 'success');
                            else:
                                $this->session->set_flashdata('subscriber_update_message', 'Subscription could not be updated.');
                                $this->session->set_flashdata('subscriber_update_status', 'danger');
                            endif;
                        else:
                            $this->session->set_flashdata('subscriber_update_message', 'Subscriber details not found.');
                            $this->session->set_flashdata('subscriber_update_status', 'danger');
                        endif;
                    else:
                        $this->session->set_flashdata('subscriber_update_message', 'Plan not found.');
                        $this->session->set_flashdata('subscriber_update_status', 'danger');
                    endif;
                else:
                    $this->session->set_flashdata('subscriber_update_message', 'Subscriber not found.');
                    $this->session->set_flashdata('subscriber_update_status', 'danger');
                endif;

                $title = 'Subscriber Temporary Panel';
                $this->load->view('subscriber/subscriber_temporary_view', compact(['title', 'subscriber_id']));            
            else:
                redirect('subscriber/search_subscriber_update');
            endif;
        }
	}        
?>