<?php
    defined('BASEPATH') OR exit('No direct script access allowed.');

    class LibrarianBMS extends CI_Model{
        public function __construct(){
            parent::__construct();            
        }

        // This function will return librarian name.
        public function librarian_name($librarian_name){
            return $this->db->distinct()->like('LIBNAME', $librarian_name)->select(['CONTACT', 'LIBNAME'])->get('librarians')->result_array();
        }

        // This function will insert, update, select and delete the transaction details into the librarians table.
        public function librarian_operation($operation_name='', $condition_data=[], $operation_data='*', $set_value=[]){
            // This will handle all selection related operation.
            if($operation_name === 'select'):
                return ($this->db->where($condition_data)->select($operation_data)->get('librarians'))->result_array();
                
            // This will handle all insertion related operation.
            elseif($operation_name === 'insert'):
                if($set_value !== []):
                    return $this->db->set($set_value)->insert('librarians');
                else:
                    return $this->db->insert('librarians', $operation_data);
                endif;            
            
            // This will handle all updation related operation.
            elseif($operation_name === 'update'):
                if($set_value !== []):
                    return $this->db->set($set_value)->where($condition_data)->update('librarians');
                else:
                    return $this->db->where($condition_data)->update('librarians', $operation_data);
                endif;            
            
            // This will handle all deletion related operation.
            elseif($operation_name === 'delete'):
                return ($this->db->where($condition_data)->delete('librarians'))->result_array();
            
            // This will handle all unknow known operation name related problem.
            else:
                return 'Unknown operation name.';
            endif;
        }
    }
?>