<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Error extends CI_Controller{
    const ERROR_SCRAPING    = 700;

    function __construct(){
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->library('user_info');
        if ($this->session->userdata('logged_in_site_web')) {
            $this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
        }
    }

    public function index($code_error){
        if( isset($code_error) == false )
            redirect('/');
        $this->load->view('template/header', $this->datas);
        $this->load->view('errors/'.$code_error);
        $this->load->view('template/footer', $this->datas);
    }
}