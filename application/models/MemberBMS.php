<?php
    defined('BASEPATH') OR exit('No direct script access allowed.');

    class MemberBMS extends CI_Model{
        public function __construct(){
            parent::__construct();            
        }

        // This function will return the member name.
        public function member_name($member_name){
            return $this->db->distinct()->like(array('MEMBERNAME'=>$member_name))->where('CONFIRM_KEY',"0")->select(['CONTACT', 'MEMBERNAME'])->get('members')->result_array();
        }
        
        // This function will insert, update, select and delete the transaction details into the members table.
        public function member_operation($operation_name='', $condition_data=[], $operation_data='*', $set_value=[]){
            // This will handle all selection related operation.
            if($operation_name === 'select'):
                return ($this->db->where($condition_data)->select($operation_data)->get('members'))->result_array();
            
            // This will handle all insertion related operation.
            elseif($operation_name === 'insert'):
                if($set_value !== []):
                    return $this->db->set($set_value)->insert('members');
                else:
                    return $this->db->insert('members', $operation_data);
                endif;            
            
            // This will handle all updation related operation.
            elseif($operation_name === 'update'):
                if($set_value !== []):
                    return $this->db->set($set_value)->where($condition_data)->update('members');
                else:
                    return $this->db->where($condition_data)->update('members', $operation_data);
                endif;            
            
            // This will handle all deletion related operation.
            elseif($operation_name === 'delete'):
                return $this->db->where($condition_data)->delete('members');
            
            // This will handle all unknow known operation name related problem.
            else:
                return 'Unknown operation name.';
            endif;
        }
    }
?>