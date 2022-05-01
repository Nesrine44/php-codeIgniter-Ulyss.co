<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Autocomplete extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('talent_model', 'talent');
        $this->load->model('demande_model', 'demande');
        $this->load->model('ulyssdev/AutoComplete_model', 'ModelAutoComplete');
        $this->load->library('encrypt');
        $this->load->library('user_info');
        if (!$this->session->userdata('logged_in_site_web')) {
            $this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
        }
    }

    public function index()
    {
        if (!empty($this->input->get('categorie'))) {
            $this->talent->GetCategorie_search($this->input->get('categorie'));
        } elseif (!empty($this->input->get('ville'))) {
            $this->talent->GetVille_search($this->input->get('ville'));
        }

    }

    public function fonction()
    {

        if (!empty($this->input->get('departement'))) {
            $result = $this->talent->getFonctionsByDepart($this->input->get('departement'));
            echo json_encode($result);
        }
    }

    public function departement()
    {

        if (!empty($this->input->get('departement'))) {
            $result = $this->talent->getDepartByFonctions($this->input->get('departement'));
            echo json_encode($result);
        }
    }

    public function fonction_ajax()
    {

        if (!empty($this->input->get('fonction'))) {
            $result = $this->talent->getFonctionsearch($this->input->get('fonction'));
        }
    }

    public function secteur()
    {

        if (!empty($this->input->get('secteur'))) {
            $result = $this->talent->getSecteursList($this->input->get('secteur'));
        }
    }

    public function competence()
    {
        if (!empty($this->input->get('cmp'))) {
            $result = $this->talent->getCmpList($this->input->get('cmp'));
        }
    }

    public function entreprise()
    {
        //function qui renvoi les resultat de recherche pour tout les input de recherche d'entreprise
        $result = $this->talent->getEntrepriseList($this->input->get('entreprise'));
    }

    public function entrepriseAll()
    {
        //function qui renvoi les resultat de recherche pour tout les input de recherche d'entreprise
        $result = $this->talent->getAllEntrepriseList($this->input->get('entreprise'));
    }

    public function entrepriseAvanced()
    {
        //function qui renvoi les resultat de recherche pour tout les input de recherche d'entreprise
        $result = $this->talent->getEntrepriseListAvanced($this->input->get('entreprise'));

        foreach ($result as $key => $item) {
            if ($item['logo'] == '' || $item['logo'] == null || !url_exists($item['logo'])) {
                $result[$key]['logo'] = base_url() . 'assets/img/entreprise.png';
            }
        }

        echo json_encode($result);

    }

    public function entrepriseCard()
    {
        $result = $this->ModelAutoComplete->getEntrepriseListForCards($this->input->get('entreprise'));
        echo json_encode($result);
    }

    public function school()
    {
        //function qui renvoi les resultat de recherche pour tout les input de recherche d'entreprise
        $result = $this->talent->getSchoolList($this->input->get('school'));

    }
}

