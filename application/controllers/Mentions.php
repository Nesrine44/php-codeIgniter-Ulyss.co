<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Mentions extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('talent_model', 'talent');
        $this->load->library('encrypt');
        $this->load->library('user_info');
        if ($this->session->userdata('logged_in_site_web')) {
            $this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
        }
    }

    public function cgu()
    {
        $this->datas['header_class'] = 'h_r_comp';
        $this->datas['header_logo']  = 'logo_2';
        $this->load->view('template/header', $this->datas);
        $this->load->view('mentions/cgu', $this->datas);
        $this->load->view('template/footer', $this->datas);
    }

    public function charte_ethique()
    {
        $this->datas['header_class'] = 'h_r_comp';
        $this->datas['header_logo']  = 'logo_2';
        $this->load->view('template/header', $this->datas);
        $this->load->view('mentions/charte_graphique', $this->datas);
        $this->load->view('template/footer', $this->datas);
    }

    public function politique_cookies()
    {
        $this->datas['header_class'] = 'h_r_comp';
        $this->datas['header_logo']  = 'logo_2';
        $this->load->view('template/header', $this->datas);
        $this->load->view('mentions/politique_cookies', $this->datas);
        $this->load->view('template/footer', $this->datas);
    }

    public function politique_confidentialite()
    {
        $this->datas['header_class'] = 'h_r_comp';
        $this->datas['header_logo']  = 'logo_2';
        $this->load->view('template/header', $this->datas);
        $this->load->view('mentions/confidentialites', $this->datas);
        $this->load->view('template/footer', $this->datas);
    }
}
