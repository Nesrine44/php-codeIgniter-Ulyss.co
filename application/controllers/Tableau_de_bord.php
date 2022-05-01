<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tableau_de_bord extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('demande_model', 'demande');
        $this->load->library('encrypt');
        $this->load->library('user_info');
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
    }

    public function index()
    {
        /*get total transactions*/
        $data['visualisee']      = $this->demande->GetTotalTalentsVisualise($this->id_user_decode);
        $data['responses']       = $this->getBusinessUser()->getMentor()->getTauxDeReponsesMessages();
        $data['rdvRealises']     = $this->getBusinessUser()->getMentor()->countRDVRealises();
        $data['recommandations'] = $this->getBusinessUser()->getMentor()->countRecommandations();

        /*get total vente*/
        $data["talents"] = $this->user->GetTalentsUser($this->id_user_decode);
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile', $this->datas);
        $this->load->view('profil/compte/tableau_de_bord', $data);
        $this->load->view('template/footer', $this->datas);
    }

}

