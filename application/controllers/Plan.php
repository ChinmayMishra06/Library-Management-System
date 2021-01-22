<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Plan extends MY_Controller{
        // This function will display plan registration form.
		public function index(){            
			if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            $title = 'Plan Registeration Panel';
            $this->load->view('plan/register_view', compact('title'));
		}

        // This function will verify the plan details filled on the plan registration form.
        public function register_check()
        {

            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $plan_data['AMOUNT'] = $this->input->post('plan_amount');
            $plan_data['VALIDITY'] = $this->input->post('plan_validity');
            $plan_data['PLANNAME'] = ' INR ' . $plan_data['AMOUNT'] . ' - VALIDITY ' . $plan_data['VALIDITY'] . ' DAYS';
            $plan_data['STATUS'] = strtoupper($this->input->post('plan_status'));
            $result = $this->PlanBMS->plan_operation('insert', '', $plan_data);
            if($result === true):
                $this->session->set_flashdata('plan_register_message', 'Plan has successfully registered.');
                $this->session->set_flashdata('plan_register_status', 'success');
            else:
                $this->session->set_flashdata('plan_register_message', 'Plan could not be registered.');
                $this->session->set_flashdata('plan_register_status', 'danger');
            endif;
            redirect('plan/');            
        }      
        
        // This function will display all plans in a tabular form.
        public function all_plans()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $title = 'All Plan Panel';
            $all_plans = $this->PlanBMS->plan_operation('select');
            $this->load->view('plan/all_plans_view', compact(['title', 'all_plans']));
        }
        
        // This function will return the plan name according to key up event on search plan update form's plan name column.
        public function plan_name()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            $plan_name = strtoupper($this->input->post('plan_name'));
            $plan_names = $this->PlanBMS->plan_name($plan_name);
            header('Content-Type:application/json');
            if(count($plan_names) > 0):
                echo json_encode($plan_names);
            else:
                echo array('not_found'=>'No data found.');
            endif;
        }
        
        // This code will return the all active plan name according to keyup event on subscriber registration form's plan name column
        // and update subscriber details form's plan name column. 
        public function active_plan_name()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            $plan_name = strtoupper($this->input->post('plan_name'));
            $plan_names = $this->PlanBMS->active_plan_name($plan_name);
            header('Content-Type:application/json');
            if(count($plan_names) > 0):
                echo json_encode($plan_names);
            else:
                echo array('not_found'=>'No data found.');
            endif;
        }

        // This function will display search plan form for updation.
        public function search_plan_update()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            $title = 'Search Plan Update Panel';
            $this->load->view('plan/search_plan_update_view', compact('title'));
        }

        // This function will display the plan details in updation form for updation.
        public function update_plan()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            if($this->input->post("plan_id") !== null):
                $plan_id = $this->input->post("plan_id");
                $updated_plan_data = $this->PlanBMS->plan_operation('select', array('PLANID'=>$plan_id));
            elseif($this->input->post("plan_name") !== null):
                $plan_name = $this->input->post("plan_name");
                $updated_plan_data = $this->PlanBMS->plan_operation('select', array('PLANNAME'=>$plan_name));
            endif;
            
            if(count($updated_plan_data) > 0):
                $title = 'Update Plan Panel';
                $this->load->view('plan/update_plan_view', compact(['title', 'updated_plan_data']));
            else:
                $this->session->set_flashdata('plan_search_message', 'No data found.');
                $this->session->set_flashdata('plan_search_status', 'danger');
                redirect('plan/search_plan_update');
            endif; 
        }

        // This function will update the plan details.
        public function update_plan_check()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/login_view');
            endif;
            
            if(($this->input->post('plan_name') !== null) && ($this->input->post('plan_amount') !== null) && ($this->input->post('plan_validity') !== null) && ($this->input->post('plan_status') !== null)):
                $update_plan_data['PLANNAME'] = $this->input->post('plan_name');
                $update_plan_data['AMOUNT'] = $this->input->post('plan_amount');
                $update_plan_data['VALIDITY'] = $this->input->post('plan_validity');
                $update_plan_data['STATUS'] = strtoupper($this->input->post('plan_status'));
                $plan_id = $this->input->post("plan_id");
                $update_result = $this->PlanBMS->plan_operation('update', array('PLANID'=>$plan_id), '', $update_plan_data);
                if($update_result === true):
                    $this->session->set_flashdata('plan_update_message', 'Plan has successfully updated.');
                    $this->session->set_flashdata('plan_update_status', 'success');
                else:
                    $this->session->set_flashdata('plan_update_message', 'Plan could not be updated.');
                    $this->session->set_flashdata('plan_update_status', 'danger');
                endif;           
                
                $title = 'Plan Temporary Panel';
                $this->load->view('plan/plan_temporary_view', compact(['title', 'plan_id']));
            else:
                redirect('plan/search_plan_update');
            endif;
        }
    }
?>