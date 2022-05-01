<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Recherche extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('talent_model', 'talent');
        $this->load->model('demande_model', 'demande');
        $this->load->model('andafter/ModelSearch', 'ModelSearch');
        $this->load->library('encrypt');
        $this->load->library('pagination');
        $this->load->library('user_info');
        if ($this->session->userdata('logged_in_site_web')) {
            $this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
        }


    }


    public function search()
    {
        $searchOption['ent_name']    = $this->input->post('entrepriselabel') != '' && $this->input->post('entrepriselabel') != null ? $this->input->post('entrepriselabel') : null;
        $searchOption['secteur']     = $this->input->post('secteur') != '' && $this->input->post('secteur') != null ? $this->input->post('secteur') : null;
        $searchOption['departement'] = $this->input->post('departement') != '' && $this->input->post('departement') != null ? $this->input->post('departement') : null;
        $searchOption['region']      = $this->input->post('region') != '' && $this->input->post('region') != null ? $this->input->post('region') : null;

        $datas['entreprises'] = [];
        $datas['filters']     = [];

        // recherche des mentors
        $mentors = $this->ModelSearch->getSearchHomeProfilsByFilter($searchOption);

        if (is_array($mentors) && count($mentors) > 0) {
            foreach ($mentors as $item) {
                $datas['entreprises'][$item->id_entreprise]['mentors'][] = $item;
            }


            // recherche des entreprises
            $this->load->model('ulyssdev/AutoComplete_model', 'ModelAutoComplete');
            foreach ($datas['entreprises'] as $key => $item) {
                $datas['entreprises'][$key]['card'] = $this->ModelAutoComplete->getEntrepriseListForCardsByIdEnt($key);
            }

            foreach ($datas['entreprises'] as $ment) {
                foreach ($ment['mentors'] as $key2 => $mentor) {
                    $datas['filters']['entreprise'][$mentor->id_entreprise]['name']  = $mentor->nom_entreprise;
                    $datas['filters']['entreprise'][$mentor->id_entreprise]['count'] = isset($datas['filters']['entreprise'][$mentor->id_entreprise]['count']) ? $datas['filters']['entreprise'][$mentor->id_entreprise]['count'] + 1 : 1;

                    $datas['filters']['departement'][$mentor->id_departement]['name']  = $mentor->nom_departement;
                    $datas['filters']['departement'][$mentor->id_departement]['count'] = isset($datas['filters']['departement'][$mentor->id_departement]['count']) ? $datas['filters']['departement'][$mentor->id_departement]['count'] + 1 : 1;

                    $datas['filters']['secteur'][$mentor->filter_secteur_id]['name']  = $mentor->nom_secteur;
                    $datas['filters']['secteur'][$mentor->filter_secteur_id]['count'] = isset($datas['filters']['secteur'][$mentor->nom_secteur]['count']) ? $datas['filters']['secteur'][$mentor->nom_secteur]['count'] + 1 : 1;


                }
            }

            foreach ($datas['filters'] as $k => $v) {
                uasort($datas['filters'][$k], function ($a, $b){
                    return $b['count'] - $a['count'];
                });
            }
        } else {
            $datas['entreprises'] = null;
            $datas['filters']     = null;
        }

        echo json_encode($datas);
    }


    public function searchHomeVerifNotConnected()
    {

        if (!$this->userIsAuthentificate()) {
            $datas['a']          = 'vous êtes non connecté';
            $datas['entreprise'] = $this->input->post('entreprise');
        } else {
            $datas['a']          = 'vous êtes connecté';
            $datas['entreprise'] = $this->input->post('entreprise');
            $this->session->set_flashdata('message_valid', 'Votre message a été envoyé aux équipes Ulyss.co ');
        }

        echo json_encode($datas);
    }


    /**
     *
     */
    public function nomentor()
    {
        $entreprise = $this->input->post('entreprise');
        $poste      = $this->input->post('poste');

        if ($entreprise != '' && $poste != '') {
            SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_MAIL_AUTO_NOMENTOR_SEARCH,
                'hello@ulyss.co',
                [
                    'FIRSTNAME_CANDIDAT' => $this->getBusinessUser()->getPrenom(),
                    'FULLNAME_CANDIDAT'  => $this->getBusinessUser()->getPrenom() . ' ' . $this->getBusinessUser()->getNom(),
                    'EMAIL_CANDIDAT'     => $this->getBusinessUser()->getEmail(),
                    'ENTREPRISE'         => $entreprise,
                    'POSTE'              => $poste
                ]
            );
        }
    }

    public function searchPage()
    {
        $datas['chapeauTab'] = $this->ModelGeneral->getChapeau();
        $datas["categories"] = $this->user->getCategorieParent();

        // Suggest Talent random if is not logged in site web :
        if (!$this->userIsAuthentificate()) {
            $datas['randomTalents'] = $this->ModelSearch->getRandomTalent();
        }
        // Suggest Mentors if is logged in site web :
        if ($this->userIsAuthentificate()) {
            $datas['SuggestMentors'] = $this->ModelSearch->getTalentsByUserLoggedDepartement($this->getBusinessUser());
        }

        $this->load->view('template/header', $this->datas);
        $this->load->view('recherche', $datas);
        $this->load->view('template/footer', $this->datas);
    }
}

