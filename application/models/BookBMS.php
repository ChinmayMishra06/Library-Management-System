<?php
    defined('BASEPATH') OR exit('No direct script access allowed.');

    class BookBMS extends CI_Model{
        public function __construct(){
            parent::__construct();            
        }

        // This function will return the subscriber details according to subscriber id.
        public function subscriber_details($subscriber_id){
            return $this->db
                    ->where(['subscribers.SUBID'=>$subscriber_id])
                    ->select(['members.TOTAL_PAID', 'members.MEMBERNAME', 'plans.PLANNAME', 'subscribers.START', 'subscribers.END', 'subscribers.PAY_MODE', 'subscribers.STATUS'])
                    ->from('subscribers')
                    ->join('members', 'members.MEMID=subscribers.MEMID')
                    ->join('plans', 'plans.PLANID=subscribers.PLANID')
                    ->get()
                    ->result_array();
        }
        
        // This function will return the author name.
        public function author_name($author_name){
            return $this->db->distinct()->like('AUTHOR', $author_name)->select('AUTHOR')->get('books')->result_array();
        }
        
        // This function will return the publisher name.
        public function publisher_name($publisher_name){
            return $this->db->distinct()->like('PUBLISHER', $publisher_name)->select('PUBLISHER')->get('books')->result_array();
        }
        
        // This function will return the book name.
        public function book_name($book_name){
            return $this->db->distinct()->like('BOOKNAME', $book_name)->select('BOOKNAME')->get('books')->result_array();
        }

        // This function will return the book price.
        public function book_price($book_name, $author_name, $publisher_name){
            return $this->db->distinct()->where(['BOOKNAME'=> $book_name, 'AUTHOR'=>$author_name, 'PUBLISHER'=>$publisher_name])->select('PRICE')->get('books')->result_array();
        }

        // This function will return the book taken by the subscriber according to $subscriber_id and $transaction_id.
        // $email variable is used to identify the librarian.
        public function subscriber_book_details_by_id($subscriber_id, $transaction_id, $email){
            return (
                    $this->db
                    ->from(['members', 'librarians'])
                    ->where(['subscribers.SUBID'=>$subscriber_id,'transactions.TRANSID'=>$transaction_id, 'librarians.EMAIL'=>$email])
                    ->select(['librarians.SIGNATURE', 'members.MEMBERNAME', 'members.CONTACT', 'members.CITY', 'members.TOTAL_PAID', 'transactions.ISSUE_DATE', 'transactions.DUE_DATE', 'transactions.AMOUNT_PAID', 'books.BOOKNAME', 'books.AUTHOR', 'books.PUBLISHER', 'books.PRICE', 'subscribers.SUBID', 'transactions.TRANSID'])
                    ->join('subscribers', 'members.MEMID=subscribers.MEMID')
                    ->join('transactions', 'members.MEMID=transactions.MEMID')
                    ->join('trans_products', 'transactions.TRANSID=trans_products.TRANSID')
                    ->join('books', 'trans_products.BOOKID=books.BOOKID')
                    ->get()
                    ->result_array());
        }

        // This function will return the book details, taken by the all subscribers.
        public function all_subscriber_book_details(){
            return (
                    $this->db
                    ->from(['members'])
                    ->select(['members.MEMBERNAME', 'members.CONTACT', 'members.CITY', 'subscribers.SUBID', 'transactions.TRANSID', 'transactions.ISSUE_DATE', 'transactions.DUE_DATE', 'transactions.AMOUNT_PAID', 'members.MEMID'])
                    ->join('subscribers', 'members.MEMID=subscribers.MEMID')
                    ->join('transactions', 'members.MEMID=transactions.MEMID')
                    ->get()
                    ->result_array());
        }

        // This function will insert, update, select and delete the book details into the books table.
        // $operation_name variable is used to store operation name i.e. select, insert, update, delete.
        // $operation_data variable is used to store condition data that is to be check.
        // $operation_data variable is used to store actual operation data that is to be stored into the database.
        // $set_value variable is used to store update data that is to be updated into the database.
        public function book_operation($operation_name='', $condition_data=[], $operation_data='*', $set_value=[]){
            // This will handle all selection related operation.
            if($operation_name === 'select'):
                return ($this->db->where($condition_data)->select($operation_data)->get('books'))->result_array();
            
            // This will handle all insertion related operation.
            elseif($operation_name === 'insert'):
                if($set_value !== []):
                    return $this->db->set($set_value)->insert('books');
                else:
                    return $this->db->insert('books', $operation_data);
                endif;            
            
            // This will handle all updation related operation.
            elseif($operation_name === 'update'):
                if($set_value !== []):
                    return $this->db->set($set_value)->where($condition_data)->update('books');
                else:
                    return $this->db->where($condition_data)->update('books', $operation_data);
                endif;            
            
            // This will handle all deletion related operation.
            elseif($operation_name === 'delete'):
                return $this->db->where($condition_data)->delete('books');
            
            // This will handle all unknow known operation name related problem.
            else:
                return 'Unknown operation name.';
            endif;
        }

        // This function will insert, update, select and delete the transaction details into the transactions table.
        public function book_transaction($operation_name='', $condition_data=[], $operation_data='*', $set_value=[]){
            // This will handle all selection related operation.
            if($operation_name === 'select'):
                return ($this->db->where($condition_data)->select($operation_data)->get('transactions'))->result_array();
            
            // This will handle all insertion related operation.
            elseif($operation_name === 'insert'):
                if($set_value !== []):
                    $this->db->set($set_value)->insert('transactions');
                    return $this->db->insert_id();
                else:
                    $this->db->insert('transactions', $operation_data);
                    return $this->db->insert_id();
                endif;            
            
            // This will handle all updation related operation.
            elseif($operation_name === 'update'):
                if($set_value !== []):
                    return $this->db->set($set_value)->where($condition_data)->update('transactions');
                else:
                    return $this->db->where($condition_data)->update('transactions', $operation_data);
                endif;            
            
            // This will handle all deletion related operation.
            elseif($operation_name === 'delete'):
                return $this->db->where($condition_data)->delete('transactions');
            
            // This will handle all unknow known operation name related problem.
            else:
                return 'Unknown operation name.';
            endif;
        }

        // This function will insert, update, select and delete the transaction product details into the trans_products table.
        public function book_trans_product($operation_name='', $condition_data=[], $operation_data='*', $set_value=[]){
            // This will handle all selection related operation.
            if($operation_name === 'select'):
                return ($this->db->where($condition_data)->select($operation_data)->get('trans_products'))->result_array();
            
            // This will handle all insertion related operation.
            elseif($operation_name === 'insert'):
                if($set_value !== []):
                    return $this->db->set($set_value)->insert('trans_products');
                else:
                    return $this->db->insert('trans_products', $operation_data);
                endif;            
            
            // This will handle all updation related operation.
            elseif($operation_name === 'update'):
                if($set_value !== []):
                    return $this->db->set($set_value)->where($condition_data)->update('trans_products');
                else:
                    return $this->db->where($condition_data)->update('trans_products', $operation_data);
                endif;            
            
            // This will handle all deletion related operation.
            elseif($operation_name === 'delete'):
                return $this->db->where($condition_data)->delete('trans_products');
            
            // This will handle all unknow known operation name related problem.
            else:
                return 'Unknown operation name.';
            endif;
        }
    }
?>