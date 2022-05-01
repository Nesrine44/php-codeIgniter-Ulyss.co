<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_ca_marche extends CI_Controller
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

    public function index()
    {
        $data['temoignages'] = $this->talent->GetTemoignages("reussir_mon_entretien");
        $data['parlents']    = $this->talent->GetParlents("reussir_mon_entretien");

        $this->load->view('template/header', $this->datas);
        $this->load->view('comment_ca_marche', $data);
        $this->load->view('template/footer', $this->datas);
    }
}
