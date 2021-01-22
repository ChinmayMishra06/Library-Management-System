<?php
    defined('BASEPATH') OR exit('No direct script access allowed.');

    class PlanBMS extends CI_Model{
        public function __construct(){
            parent::__construct();            
        }

        // This function will return the all plan name whether it is active or deactive?.
        public function plan_name($plan_name){
            return $this->db->distinct()->like('PLANNAME', $plan_name)->select(['PLANNAME'])->get('plans')->result_array();
        }

        // This function will return the all active plan name.
        public function active_plan_name($plan_name){
            return $this->db->distinct()->like(array('PLANNAME'=>$plan_name))->where('STATUS','ACTIVATE')->select(['PLANNAME'])->get('plans')->result_array();
        }
        
        // This function will insert, update, select and delete the book details into the plans table.
        // $operation_name variable is used to store operation name i.e. select, insert, update, delete.
        // $operation_data variable is used to store condition data that is to be check.
        // $operation_data variable is used to store actual operation data that is to be stored into the database.
        // $set_value variable is used to store update data that is to be updated into the database.
        public function plan_operation($operation_name='', $condition_data=[], $operation_data='*', $set_value=[]){
            // This will handle all selection related operation.
            if($operation_name === 'select'):
                return ($this->db->where($condition_data)->select($operation_data)->get('plans'))->result_array();
            
            // This will handle all insertion related operation.
            elseif($operation_name === 'insert'):
                if($set_value !== []):
                    return $this->db->set($set_value)->insert('plans');
                else:
                    return $this->db->insert('plans', $operation_data);
                endif;            
            
            // This will handle all updation related operation.
            elseif($operation_name === 'update'):
                if($set_value !== []):
                    return $this->db->set($set_value)->where($condition_data)->update('plans');
                else:
                    return $this->db->where($condition_data)->update('plans', $operation_data);
                endif;            
            
            // This will handle all deletion related operation.
            elseif($operation_name === 'delete'):
                return $this->db->where($condition_data)->delete('plans');
            
            // This will handle all unknow known operation name related problem.
            else:
                return 'Unknown operation name.';
            endif;
        }
    }
?>