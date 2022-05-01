<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Profil_avis extends CI_Controller
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

    public function index($slug = NULL, $demande = NULL)
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $info_talent = $this->talent->GetTalentsByAlias($slug);
        if (empty($info_talent)) {
            show_404();
        }
        $info = $this->user->GetUserByid($info_talent->user_id);
        if (empty($info)) {
            show_404();
        }

        if ($this->input->post('commentaire')) {
            $data_cmt['talent_id'] = $info_talent->id;
            $data_cmt['comment_user_id'] = $this->id_user_decode;
            $data_cmt['commentaire'] = $this->input->post('commentaire');
            $moyen = round(($this->input->post('note') + $this->input->post('note1') + $this->input->post('note2')) / 3);
            $data_cmt['note'] = $moyen;
            $data_cmt['demande_talen_id'] = $demande;
            $this->talent->addCommentaire($data_cmt);
        }
        $check_commentaire = $this->talent->getCommentaire($demande);
        $data['info_talent'] = $info_talent;
        $data['info'] = $info;
        if (empty($check_commentaire)) {
            $this->load->view('template/header', $this->datas);
            $this->load->view('profil_avis', $data);
            $this->load->view('template/footer', $this->datas);
        } else {
            $this->load->view('template/header', $this->datas);
            $this->load->view('success_commentaire', $data);
            $this->load->view('template/footer', $this->datas);
        }

    }
}
