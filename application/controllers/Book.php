<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Book extends MY_Controller{
		// This function will load book registration form.
		public function index(){
			if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            $title = "Book Registeration Panel";
			$this->load->view('book/register_view', compact('title'));
		}

        // This function will verify the book details filled on the book registration form.
        public function register_check()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;

            // This is file configuration settings.
            $config['upload_path'] = 'assets/uploads/images/book';
            $config['allowed_types'] = '*';
            $config['remove_spaces'] = TRUE;
            $config['overwrite'] = TRUE;
            $this->upload->initialize($config);

            if($this->upload->do_upload('book_image')):
                $register_data['BOOKNAME'] = strtoupper($this->input->post('book_name'));
                $register_data['AUTHOR'] = strtoupper($this->input->post('book_author'));
                $register_data['PUBLISHER'] = strtoupper($this->input->post('book_publisher'));
                $register_data['PRICE'] = $this->input->post('book_price');
                $register_data['QUANTITY'] = $this->input->post('book_quantity');
                $register_data['IMAGE'] = $this->upload->data()['file_name'];
                $result = $this->BookBMS->book_operation('insert', '', $register_data);
                if($result === TRUE):
                    $this->session->set_flashdata('book_register_message', 'Book has successfully registered.');
                    $this->session->set_flashdata('book_register_status', 'success');
                else:
                    $this->session->set_flashdata('book_register_message', 'Book could not be registered.');
                    $this->session->set_flashdata('book_register_status', 'danger');
                endif;                    
                redirect('book/');
            else:
                $title = 'Book Registeration Panel';
                $this->load->view('book/register_view', compact('title'));
            endif;
        }

        // This function will display all books in a tabular form.
        public function all_books()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            $title = 'All Books Panel';
            $all_books = $this->BookBMS->book_operation('select');
            $this->load->view('book/all_books_view', compact(['title', 'all_books']));
        }

        // This function will display search book form for updation.
        public function search_book_update()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('book')):
                redirect('librarian/');
            endif;
            $title = 'Search Book Update Panel';
            $this->load->view('book/search_book_update_view', compact('title'));
        }

        // This function will display the book details in tabular form for updation.
        public function update_book()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            if($this->input->post("book_id") !== null):
                $book_id = $this->input->post("book_id");
                $updated_book_data = $this->BookBMS->book_operation('select', array('BOOKID'=>$book_id));
            elseif(($this->input->post("book_name") !== null) && ($this->input->post("book_author") !== null) && ($this->input->post("book_publisher") !== null)):
                $book_name = $this->input->post("book_name");
                $book_author = $this->input->post("book_author");
                $book_publisher = $this->input->post("book_publisher");
                $updated_book_data = $this->BookBMS->book_operation('select', array('BOOKNAME'=>$book_name, 'AUTHOR'=>$book_author, 'PUBLISHER'=>$book_publisher));
            endif;
            
            if(count($updated_book_data) > 0):
                $title = 'Update Book Panel';
                $this->load->view('book/update_book_view', compact(['title', 'updated_book_data']));            
            else:
                $this->session->set_flashdata('book_search_message', 'No data found.');
                $this->session->set_flashdata('book_search_status', 'danger');
                redirect('book/search_book_update');
            endif;
        }

        // This function will update the book details.
        public function update_book_check()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
                
            if($this->input->post('book_id') !== null):            
                // This is file configuration settings.
                $config['upload_path'] = 'assets/uploads/images/book';
                $config['allowed_types'] = '*';
                $config['remove_spaces'] = TRUE;
                $config['overwrite'] = TRUE;
                $this->upload->initialize($config);

                // This will check whether the book image uploaded field is empty or not and also check book image successfully uploaded or not?
                if(!empty($_FILES['book_image']['name']) && $this->upload->do_upload('book_image')):
                    $update_book_data['IMAGE'] = $this->upload->data()['file_name'];
                endif;

                $book_id = $this->input->post("book_id");
                $update_book_data['BOOKNAME'] = $this->input->post('book_name');
                $update_book_data['AUTHOR'] = $this->input->post('book_author');
                $update_book_data['PUBLISHER'] = $this->input->post('book_publisher');
                $update_book_data['PRICE'] = $this->input->post('book_price');
                $update_book_data['QUANTITY'] = $this->input->post('book_quantity');
                $book_id = $this->input->post('book_id');
                $update_result = $this->BookBMS->book_operation('update', array('BOOKID'=>$book_id), '', $update_book_data);
                if($update_result === true):
                    $this->session->set_flashdata('book_update_message', 'Book has successfully updated.');
                    $this->session->set_flashdata('book_update_status', 'success');
                else:
                    $this->session->set_flashdata('book_update_message', 'Book could not be updated.');
                    $this->session->set_flashdata('book_update_status', 'danger');
                endif;                            
                $title = 'Book Temporary Panel';
                $this->load->view('book/book_temporary_view', compact(['title', 'book_id']));
            else:
                redirect('book/search_book_update');
            endif;
        }
        
        // This function will display book issue form.
        public function book_issue()
        {
           if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            $title = 'Books Issue Panel';
            $this->load->view('book/book_issue_view', compact('title'));
        }

        // This function will return the book details according to subscriber id on blur event of subscriber id column of book issue view.
        public function subscriber_details()
        {
           if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            if($this->input->post('subscriber_id') !== null):
                $subscriber_id = $this->input->post('subscriber_id');
                $subscriber_details = $this->BookBMS->subscriber_details($subscriber_id);
                header('Content-Type:application/json');
                if(count($subscriber_details) > 0):
                    if($subscriber_details[0]['STATUS'] === 'ACTIVATE'):
                        echo json_encode($subscriber_details);
                    else:
                        echo json_encode(array("plan_renewal"=>"Please renew your plan."));
                    endif;
                else:
                    echo json_encode(array("not_found"=>"No data found."));
                endif;
            else:
                redirect('book/book_issue');
            endif;
        }

        // This function will return the book name according to key up event in the book issue form's book name column.
        public function book_name()
        {
           if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            $book_name = strtoupper($this->input->post('book_name'));
            $book_names = $this->BookBMS->book_name($book_name);
            header('Content-Type:application/json');
            if(count($book_names) > 0):
                echo json_encode($book_names);
            else:
                echo array('not_found'=>'No data found.');
            endif;
        }
        
        // This function will return the author name according to key up event in the book issue form's author name column.
        public function author_name()
        {
           if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            $author_name = strtoupper($this->input->post('author_name'));
            $author_names = $this->BookBMS->author_name($author_name);
            header('Content-Type:application/json');
            if($author_names):
                echo json_encode($author_names);
            else:
                echo array('not_found'=>'No data found.');
            endif;
        }

        // This function will return the publisher name according to key up event in the book issue form's publisher name column.
        public function publisher_name()
        {
           if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            $book_publisher = strtoupper($this->input->post('publisher_name'));
            $book_publishers = $this->BookBMS->publisher_name($book_publisher);
            header('Content-Type:application/json');
            if(count($book_publishers) > 0):
                echo json_encode($book_publishers);
            else:
                echo array('not_found'=>'No data found.');
            endif;
        }

        // This function will return the book price according to details filled on the book issue form.
        public function book_price()
        {
           if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;

            if(($this->input->post('book_name') !== null) && ($this->input->post('author_name') !== null) && $this->input->post('publisher_name') !== null):
                $book_name = strtoupper($this->input->post('book_name'));
                $author_name = strtoupper($this->input->post('author_name'));
                $publisher_name = strtoupper($this->input->post('publisher_name'));
                $book_price = $this->BookBMS->book_price($book_name, $author_name, $publisher_name);
                if(count($book_price) > 0):
                    echo json_encode($book_price);
                else:
                    echo json_encode(array('not_found'=>'Books is not available with these details.'));
                endif;            
            else:
                redirect('book/book_issue');
            endif;
        }

        // This funciton will issue the books.
        public function book_issue_check(){
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;

            if($this->input->post('issued_book') !== null):
                $all_issued_book = json_decode($this->input->post('issued_book'));
                $member_id = $this->SubscriberBMS->subscriber_operation('select', array('SUBID'=>$all_issued_book->subscriber_id), 'MEMID');
                $transaction_details['MEMID'] = $member_id[0]['MEMID'];
                $transaction_details['ISSUE_DATE'] = date("Y/m/d");
                $transaction_details['DUE_DATE'] = date('Y/m/d', strtotime("+ " . 15 . " day"));
                $transaction_details['AMOUNT_PAID'] = $all_issued_book->total_price;
                $transaction_id = $this->BookBMS->book_transaction('insert', '', $transaction_details);
                if($transaction_id > 0):
                    for($i=0; $i<count($all_issued_book->book_details); $i++):
                        $book = $this->BookBMS->book_operation('select', array('BOOKNAME'=>$all_issued_book->book_details[$i]->book, 'AUTHOR'=>$all_issued_book->book_details[$i]->author, 'PUBLISHER'=>$all_issued_book->book_details[$i]->publisher), ['BOOKID', 'QUANTITY']);
                        $transaction_products_details['TRANSID'] = $transaction_id;
                        $transaction_products_details['BOOKID'] = $book[0]['BOOKID'];
                        $product_details = $this->BookBMS->book_trans_product('insert', '', $transaction_products_details);
                        $book_update = $this->BookBMS->book_operation('update', array('BOOKID'=>$book[0]['BOOKID']), '', array('QUANTITY'=>$book[0]['QUANTITY'] - 1));
                    endfor;
                    $book_details = $this->MemberBMS->member_operation('select', array('MEMID'=>$member_id[0]['MEMID']), ['TOTAL_PAID']);
                    $book_update = $this->MemberBMS->member_operation('update', array('MEMID'=>$member_id[0]['MEMID']), '', array('TOTAL_PAID'=>($book_details[0]['TOTAL_PAID'] + $all_issued_book->total_price)));
                    echo json_encode(array('transaction_id'=>$transaction_id));
                else:
                    echo json_encode(array('status'=>'Book could not be issued.'));
                endif;
            else:
                redirect('book/book_issue');
            endif;
        }

        // This funciton will issue the books.
        public function issued_book(){
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            if($this->session->userdata('admin')):
                $email = $this->session->userdata('admin');
            else:
                $email = $this->session->userdata('librarian');
            endif;
            
            if(($this->input->post('subscriber_id') !== null) && ($this->input->post('transaction_id') !== null)):
                $subscriber_id = $this->input->post('subscriber_id');
                $transaction_id = $this->input->post('transaction_id');
                $subscriber_book_details = $this->BookBMS->subscriber_book_details_by_id($subscriber_id, $transaction_id, $email);            
                if(count($subscriber_book_details) > 0):
                    $title = 'Issued Books Panel';
                    $this->load->view('book/issued_book_details_view', compact(['title', 'subscriber_book_details']));
                else:
                    $this->session->set_flashdata('issued_book_details_message', 'No data found.');
                    $this->session->set_flashdata('issued_book_details_status', 'danger');
                    redirect('book/search_issued_book_details');
                endif;
            else:
                redirect('book/book_issue');
            endif;
        }
        
        // This funciton will display the all issued books.
        public function all_issued_books(){
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            $all_issued_books = $this->BookBMS->all_subscriber_book_details();
            $title = 'All Issued Books Panel';
            $this->load->view('book/all_issued_books_view', compact(['title', 'all_issued_books']));
        } 

        // This function will display the search form for searching issued book.
        public function search_issued_book()
        {
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            $title = 'Search Issued Book Panel';
            $this->load->view('book/search_issued_book_view', compact('title'));
	    }

        // This function will check the book according to book details filled on search issued book form.
        public function search_issued_book_check(){
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            if($this->session->userdata('admin')):
                $email = $this->session->userdata('admin');
            else:
                $email = $this->session->userdata('librarian');
            endif;
            
            if(($this->input->post('subscriber_id') !== null) && ($this->input->post('transaction_id') !== null)):
                $subscriber_id = $this->input->post('subscriber_id');
                $transaction_id = $this->input->post('transaction_id');
                $subscriber_book_details = $this->BookBMS->subscriber_book_details_by_id($subscriber_id, $transaction_id, $email);
                if(count($subscriber_book_details) > 0):
                    $transaction_details = $this->BookBMS->book_transaction('select', array('TRANSID'=>$transaction_id, 'STATUS'=>'HOLD'), array('AMOUNT_PAID', 'MEMID'));
                    if(count($transaction_details) > 0):                
                        $title = 'Issued Books Panel';
                        $this->load->view('book/return_issued_book_view', compact(['title', 'subscriber_book_details']));
                    else:
                        $title = 'Returned Issued Books Panel';
                        $this->load->view('book/returned_issued_book_view', compact(['title', 'subscriber_book_details']));                    
                    endif;
                else:
                    $this->session->set_flashdata('issued_book_details_message', 'No data found.');
                    $this->session->set_flashdata('issued_book_details_status', 'danger');
                    redirect('book/search_issued_book');
                endif;
            else:
                redirect('book/search_issued_book');
            endif;
        }

        // This function will return the issued book.
        public function return_issued_book(){
            if(!$this->session->userdata('admin') && !$this->session->userdata('librarian')):
                redirect('librarian/');
            endif;
            
            if(($this->input->post('subscriber_id') !== null) && ($this->input->post('transaction_id') !== null)):
                $subscriber_id = $this->input->post('subscriber_id');
                $transaction_id = $this->input->post('transaction_id');
                $transaction_details = $this->BookBMS->book_transaction('select', array('TRANSID'=>$transaction_id, 'STATUS'=>'HOLD'), array('AMOUNT_PAID', 'MEMID'));
                if(count($transaction_details) > 0):
                    $transaction_book_details = $this->BookBMS->book_trans_product('select', array('TRANSID'=>$transaction_id), array('BOOKID', 'STATUS'));
                    if(count($transaction_book_details) > 0):
                        foreach($transaction_book_details as $book_details):
                            $transaction_book_return = $this->BookBMS->book_trans_product('update', array('BOOKID'=>$book_details['BOOKID'],'TRANSID'=>$transaction_id), '', array('STATUS'=>'RETURN'));
                            if($transaction_book_return === true):
                                $book_data = $this->BookBMS->book_operation('select', array('BOOKID'=>$book_details['BOOKID']), array('QUANTITY'));
                                if(count($book_data) > 0):
                                    $book_update = $this->BookBMS->book_operation('update', array('BOOKID'=>$book_details['BOOKID']), '', array('QUANTITY'=>$book_data[0]['QUANTITY'] + 1));
                                endif;
                            endif;
                        endforeach;
                        $get_transaction_status = $this->BookBMS->book_transaction('select', array('TRANSID'=>$transaction_id), array('STATUS'));
                        if(count($get_transaction_status) > 0):
                            $update_transaction_status = $this->BookBMS->book_transaction('update', array('TRANSID'=>$transaction_id), '', array('STATUS'=>'RETURN'));
                            if($update_transaction_status === true):
                                $member_total_paid = $this->MemberBMS->member_operation('select', array('MEMID'=>$transaction_details[0]['MEMID']), array('TOTAL_PAID'));
                                if(count($member_total_paid)):                        
                                    $return_member_amount = $this->MemberBMS->member_operation('update', array('MEMID'=>$transaction_details[0]['MEMID']), '', array('TOTAL_PAID'=>$member_total_paid[0]['TOTAL_PAID'] - $transaction_details[0]['AMOUNT_PAID']));
                                endif;
                            endif;
                        endif;
                    endif;

                    if($this->session->userdata('admin')):
                        $email = $this->session->userdata('admin');
                    else:
                        $email = $this->session->userdata('librarian');
                    endif;
                    
                    $subscriber_book_details = $this->BookBMS->subscriber_book_details_by_id($subscriber_id, $transaction_id, $email);
                    if(count($subscriber_book_details) > 0):
                        $title = 'Returned Issued Books Panel';
                        $this->load->view('book/returned_issued_book_view', compact(['title', 'subscriber_book_details']));
                    else:
                        $this->session->set_flashdata('issued_book_details_message', 'No data found.');
                        $this->session->set_flashdata('issued_book_details_status', 'danger');
                        redirect('book/search_issued_book');
                    endif;
                else:
                    redirect('book/search_issued_book');
                endif;
            else:
                redirect('book/search_issued_book');
            endif;
        }

        public function demo(){
            $title = "Demo";
            $this->load->view('book/demo', compact('title'));
        }
    }
?>