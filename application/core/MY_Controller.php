<?php
    defined('BASEPATH') OR exit('No direct script access allowed.');

    class MY_Controller extends CI_Controller{
        public function __construct(){
            parent::__construct();
            $this->load->database();
            $this->load->library('form_validation');
            $this->load->library('session');
            $this->load->helper('form');
            $this->load->helper('url');
            $this->load->helper('html');
            $this->load->model('LibrarianBMS');
            $this->load->model('MemberBMS');
            $this->load->model('PlanBMS');
            $this->load->model('BookBMS');
            $this->load->model('SubscriberBMS');
            $this->load->library('upload');
            $this->load->library('email');
        }
    }
?>