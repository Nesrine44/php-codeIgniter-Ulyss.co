<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Bloquer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('talent_model', 'talent');
        $this->load->library('encrypt');
        $this->load->library('user_info');
        if (!$this->session->userdata('logged_in_site_web_bloquer')) {
            redirect(base_url());
        }

        if ($this->session->userdata('logged_in_site_web_bloquer')) {
            $this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web_bloquer')['id']);
        }
    }

    public function index()
    {
        $this->load->view('bloquer');
    }

    public function debloquer()
    {
        $data['fermer'] = false;
        $this->user->EditUser($this->id_user_decode, $data);
        $this->session->set_userdata('logged_in_site_web', $this->session->userdata('logged_in_site_web_bloquer'));
        redirect(base_url() . "compte");
    }
}

