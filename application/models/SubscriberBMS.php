<?php
    defined('BASEPATH') OR exit('No direct script access allowed.');

    class SubscriberBMS extends CI_Model{
        public function __construct(){
            parent::__construct();
        }
        
        // This function will return the subscriber details according to subscriber id.
        public function subscriber_details_by_id($subscriber_id){
            return $this->db
                        ->where(['SUBID'=>$subscriber_id])
                        ->select(['members.MEMBERNAME', 'members.CONTACT', 'members.IMAGE', 'members.SIGNATURE', 'plans.PLANNAME', 'plans.AMOUNT', 'subscribers.SUBID', 'subscribers.START', 'subscribers.END', 'subscribers.PAY_MODE', 'subscribers.STATUS'])
                        ->from('subscribers')
                        ->join('plans', 'subscribers.PLANID=plans.PLANID')
                        ->join('members', 'subscribers.MEMID=members.MEMID')
                        ->get()
                        ->result_array();
        }

        // This function will return the subscriber details according to subscriber name and contact.
        public function subscriber_details_by_name($subscriber_name, $subscriber_contact){
            return $this->db
                        ->where(['MEMBERNAME'=>$subscriber_name, 'CONTACT'=>$subscriber_contact])
                        ->select(['members.MEMBERNAME', 'members.CONTACT', 'members.IMAGE', 'members.SIGNATURE', 'plans.PLANNAME', 'plans.AMOUNT', 'subscribers.SUBID', 'subscribers.START', 'subscribers.END', 'subscribers.PAY_MODE', 'subscribers.STATUS'])
                        ->from('members')
                        ->join('subscribers', 'subscribers.MEMID=members.MEMID')
                        ->join('plans', 'subscribers.PLANID=plans.PLANID')
                        ->get()
                        ->result_array();
        }
        
        // This function will return the subscriber name.
        public function subscriber_name($subscriber_name){
            return $this->db->distinct()->like('MEMBERNAME', $subscriber_name)->select(['CONTACT', 'MEMBERNAME'])->join('subscribers', 'members.MEMID=subscribers.MEMID')->get('members')->result_array();
        }
        
        // This function will insert, update, select and delete the transaction details into the subscribers table.        
        public function subscriber_operation($operation_name='', $condition_data=[], $operation_data='*', $set_value=[]){
            // This will handle all selection related operation.
            if($operation_name === 'select'):
                return ($this->db->where($condition_data)->select($operation_data)->get('subscribers'))->result_array();

            // This will handle join related selection operation.
            elseif($operation_name === 'join'):
                return $this->db->where($condition_data)->select(['members.MEMBERNAME', 'members.CONTACT', 'plans.PLANNAME', 'plans.AMOUNT', 'subscribers.SUBID', 'subscribers.START', 'subscribers.END', 'subscribers.PAY_MODE', 'subscribers.STATUS'])->from('subscribers')->join('plans', 'subscribers.PLANID=plans.PLANID')->join('members', 'subscribers.MEMID=members.MEMID')->get()->result_array();

            // This will handle all insertion related operation.
            elseif($operation_name === 'insert'):
                if($set_value !== []):
                    return $this->db->set($set_value)->insert('subscribers');
                else:
                    return $this->db->insert('subscribers', $operation_data);
                endif;            
            
            // This will handle all updation related operation.
            elseif($operation_name === 'update'):
                if($set_value !== []):
                    return $this->db->set($set_value)->where($condition_data)->update('subscribers');
                else:
                    return $this->db->where($condition_data)->update('subscribers', $operation_data);
                endif;            
            
            // This will handle all deletion related operation.
            elseif($operation_name === 'delete'):
                return $this->db->where($condition_data)->delete('subscribers');
            
            // This will handle all unknow known operation name related problem.
            else:
                return 'Unknown operation name.';
            endif;
        }
    }
?>