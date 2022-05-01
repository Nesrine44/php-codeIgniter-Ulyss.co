<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mentor extends CI_Controller
{
    private static $hashString = 'E9sz.g-.@\mDE:z?+GZ~-KH`b5NnpCR-T7';

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
        /* METAS SEO */
        $this->datas['SEO_title_page'] = 'ULYSS.CO : Rejoingez notre communauté de mentors';
        $this->datas['SEO_desc_page']  = 'Des candidats souhaitent intégrer les entreprises où vous avez travaillé. Partagez votre expérience pour les aider à faire le bon choix de carrière. Vous souhaitez devenir mentor et aider les candidats ?';

        /* FACEBOOK SHARING */
        $this->datas['sharing']['facebook']['og:type']        = 'website';
        $this->datas['sharing']['facebook']['og:url']         = base_url();
        $this->datas['sharing']['facebook']['og:site_name']   = 'Ulyss';
        $this->datas['sharing']['facebook']['og:title']       = 'Ulyss.co';
        $this->datas['sharing']['facebook']['og:description'] = 'Un Mentor travaille dans la société que vous convoitez. Discutez directement avec lui afin de mieux connaitre l’entreprise et faire le bon choix de carrière.';
        $this->datas['sharing']['facebook']['og:image']       = base_url('assets/img/social/partage.jpg');

        /* TWITTER SHARING */
        $this->datas['sharing']['twitter']['twitter:card']        = 'summary_large_image';
        $this->datas['sharing']['twitter']['twitter:site']        = '@Ulyss.co';
        $this->datas['sharing']['twitter']['twitter:creator']     = '@Ulyss.co';
        $this->datas['sharing']['twitter']['twitter:title']       = $this->datas['sharing']['facebook']['og:title'];
        $this->datas['sharing']['twitter']['twitter:description'] = 'Vous êtes candidat? Faites le bon choix d\'entreprise en échangeant directement avec des employés sur Ulyss.co';
        $this->datas['sharing']['twitter']['twitter:image']       = $this->datas['sharing']['facebook']['og:image'];

        $data['list_language']   = $this->user->GetListLangues();
        $data['list_tags']       = $this->user->GetListTags();
        $data['list_categories'] = $this->talent->GetCategoriesList();
        $data['temoignages']     = $this->talent->GetTemoignages("devenir_mentor");

        $this->load->view('template/header', $this->datas);
        $this->load->view('mentor/step1', $data);
        $this->load->view('template/footer', $this->datas);

    }


    public function etape1()
    {

        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }

        $data['departements'] = $this->ModelGeneral->getAllDepartementName();
        $data['chapeauTab']   = $this->ModelGeneral->getSecteurOrderByChapeau();
        $all_xp               = $this->getBusinessUser()->getProfileTalent()->getExperiences();
        $exp                  = $this->getBusinessUser()->getProfileTalent()->getLastExperience();
        if (!empty($exp) && $exp != false) {
            $exp->ent        = $this->ModelEntreprise->getById($exp->entreprise_id)->nom;
            $data['lastExp'] = $exp;
        }

        $data['length_exp'] = 1;

        if (!empty($all_xp)) {
            foreach ($all_xp as $key => $xp) {
                $all_xp[$key]->secteur_nom      = $this->ModelGeneral->getSecteurNameByIdBdd($xp->secteur_id);
                $all_xp[$key]->entreprise_nom   = $this->ModelEntreprise->getNameEntrepriseById($xp->entreprise_id);
                $all_xp[$key]->departement_nom  = $this->ModelGeneral->getDepartementNameByIdBdd($xp->departement_id);
                $date_debut                     = date_parse($all_xp[$key]->date_debut);
                $date_fin                       = date_parse($all_xp[$key]->date_fin);
                $all_xp[$key]->date_debut_mois  = (string)$date_debut['month'];
                $all_xp[$key]->date_debut_annee = (string)$date_debut['year'];
                $all_xp[$key]->date_fin_mois    = (string)$date_fin['month'];
                $all_xp[$key]->date_fin_annee   = (string)$date_fin['year'];
                unset($all_xp[$key]->date_debut);
                unset($all_xp[$key]->date_fin);
            }
            $data['all_exp']    = $all_xp;
            $data['length_exp'] = sizeof($all_xp);
        }

        $data['num_exp'] = sizeof($all_xp) + 1;
        $data['mois']    = [
            '1'  => 'Janvier',
            '2'  => 'Février',
            '3'  => 'Mars',
            '4'  => 'Avril',
            '5'  => 'Mai',
            '6'  => 'Juin',
            '7'  => 'Juillet',
            '8'  => 'Août',
            '9'  => 'Septembre',
            '10' => 'Octobre',
            '11' => 'Novembre',
            '12' => 'Décembre',
        ];


        $this->load->view('template/header', $this->datas);
        $this->load->view('mentor/etape1', $data);
        $this->load->view('template/footer', $this->datas);
    }

    public function etape2Validation()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $allExpUser = $this->input->post('experience');
        $allentUser = $this->input->post('entreprise');
        if ($allExpUser != null) {
            if ($allentUser != null) {
                foreach ($allExpUser as $numExp => $exp) {
                    if ($exp['entreprise_id'] == '' || $exp['entreprise_id'] == 0) {
                        // enregistrer l'entreprise si elle n'existe pas
                        $compagny['nom']                      = $allentUser[$numExp];
                        $compagny['secteur_id']               = $exp['secteur_id'];
                        $compagny['alias']                    = $this->create_alias_entreprise($compagny['nom']);
                        $ModelEntreprise                      = $this->ModelEntreprise->save($compagny);
                        $allExpUser[$numExp]['entreprise_id'] = $ModelEntreprise->id;
                    }
                }
            }
            // Recuperer l'experience
            $this->session->set_userdata('experience_saisie', $allExpUser);

        } else {
            redirect(base_url() . 'mentor/etape1');
        }
        $data['info_user']       = $this->getBusinessUser()->getUser();
        $data['list_language']   = $this->user->GetListLangues();
        $data['list_tags']       = $this->user->GetListTags();
        $data['list_categories'] = $this->talent->GetCategoriesList();
        $this->load->view('template/header', $this->datas);
        $this->load->view('mentor/step3', $data);
        $this->load->view('template/footer', $this->datas);
    }

    public function step4()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $data['info_user']       = $this->getBusinessUser()->getUser();
        $data['list_language']   = $this->user->GetListLangues();
        $data['list_tags']       = $this->user->GetListTags();
        $data['list_categories'] = $this->talent->GetCategoriesList();
        if ($this->input->post()) {
            $data_p['prix'] = $this->input->post("prix_journee");
            $this->session->set_userdata("price_step3", $data_p['prix']);
            $data_horaire['lundi_8_10']     = $this->input->post("lundi_8_10");
            $data_horaire['mardi_8_10']     = $this->input->post("mardi_8_10");
            $data_horaire['mercredi_8_10']  = $this->input->post("mercredi_8_10");
            $data_horaire['jeudi_8_10']     = $this->input->post("jeudi_8_10");
            $data_horaire['vendredi_8_10']  = $this->input->post("vendredi_8_10");
            $data_horaire['samedi_8_10']    = $this->input->post("samedi_8_10");
            $data_horaire['dimanche_8_10']  = $this->input->post("dimanche_8_10");
            $data_horaire['lundi_10_12']    = $this->input->post("lundi_10_12");
            $data_horaire['mardi_10_12']    = $this->input->post("mardi_10_12");
            $data_horaire['mercredi_10_12'] = $this->input->post("mercredi_10_12");
            $data_horaire['jeudi_10_12']    = $this->input->post("jeudi_10_12");
            $data_horaire['vendredi_10_12'] = $this->input->post("vendredi_10_12");
            $data_horaire['samedi_10_12']   = $this->input->post("samedi_10_12");
            $data_horaire['dimanche_10_12'] = $this->input->post("dimanche_10_12");
            $data_horaire['lundi_12_14']    = $this->input->post("lundi_12_14");
            $data_horaire['mardi_12_14']    = $this->input->post("mardi_12_14");
            $data_horaire['mercredi_12_14'] = $this->input->post("mercredi_12_14");
            $data_horaire['jeudi_12_14']    = $this->input->post("jeudi_12_14");
            $data_horaire['vendredi_12_14'] = $this->input->post("vendredi_12_14");
            $data_horaire['samedi_12_14']   = $this->input->post("samedi_12_14");
            $data_horaire['dimanche_12_14'] = $this->input->post("dimanche_12_14");
            $data_horaire['lundi_14_16']    = $this->input->post("lundi_14_16");
            $data_horaire['mardi_14_16']    = $this->input->post("mardi_14_16");
            $data_horaire['mercredi_14_16'] = $this->input->post("mercredi_14_16");
            $data_horaire['jeudi_14_16']    = $this->input->post("jeudi_14_16");
            $data_horaire['vendredi_14_16'] = $this->input->post("vendredi_14_16");
            $data_horaire['samedi_14_16']   = $this->input->post("samedi_14_16");
            $data_horaire['dimanche_14_16'] = $this->input->post("dimanche_14_16");
            $data_horaire['lundi_16_18']    = $this->input->post("lundi_16_18");
            $data_horaire['mardi_16_18']    = $this->input->post("mardi_16_18");
            $data_horaire['mercredi_16_18'] = $this->input->post("mercredi_16_18");
            $data_horaire['jeudi_16_18']    = $this->input->post("jeudi_16_18");
            $data_horaire['vendredi_16_18'] = $this->input->post("vendredi_16_18");
            $data_horaire['samedi_16_18']   = $this->input->post("samedi_16_18");
            $data_horaire['dimanche_16_18'] = $this->input->post("dimanche_16_18");
            $data_horaire['lundi_18_20']    = $this->input->post("lundi_18_20");
            $data_horaire['mardi_18_20']    = $this->input->post("mardi_18_20");
            $data_horaire['mercredi_18_20'] = $this->input->post("mercredi_18_20");
            $data_horaire['jeudi_18_20']    = $this->input->post("jeudi_18_20");
            $data_horaire['vendredi_18_20'] = $this->input->post("vendredi_18_20");
            $data_horaire['samedi_18_20']   = $this->input->post("samedi_18_20");
            $data_horaire['dimanche_18_20'] = $this->input->post("dimanche_18_20");
            $data_horaire['lundi_20_22']    = $this->input->post("lundi_20_22");
            $data_horaire['mardi_20_22']    = $this->input->post("mardi_20_22");
            $data_horaire['mercredi_20_22'] = $this->input->post("mercredi_20_22");
            $data_horaire['jeudi_20_22']    = $this->input->post("jeudi_20_22");
            $data_horaire['vendredi_20_22'] = $this->input->post("vendredi_20_22");
            $data_horaire['samedi_20_22']   = $this->input->post("samedi_20_22");
            $data_horaire['dimanche_20_22'] = $this->input->post("dimanche_20_22");
            $this->session->set_userdata("horaire", $data_horaire);
        }
        $this->load->view('template/header', $this->datas);
        $this->load->view('mentor/step4', $data);
        $this->load->view('template/footer', $this->datas);
    }

    public function add()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        // recuperation des experien du saission user
        $allExpUser = $this->session->userdata('experience_saisie');
        foreach ($allExpUser as $exp) { // enregistrement de tout les experience saisie
            $exp['talent_id'] = $this->getBusinessUser()->getProfileTalent()->getId();
            $this->ModelTalent->saveExperiences($exp);
        }
        $this->session->unset_userdata('experience_saisie'); //enlever les experience du userdata session

        if (!$this->input->post("description")) {
            $this->index();
        }
        $sendMail                 = false;
        $langues                  = [];
        $data_info['description'] = $this->input->post("description");
        if (trim($this->input->post("countrylangue1")) != '') {
            $langues[1] = $this->input->post("countrylangue1");
        }
        if (trim($this->input->post("countrylangue2")) != '') {
            $langues[2] = $this->input->post("countrylangue2");
        }
        $data_info['prix']           = $this->session->userdata('price_step3');
        $data_info['centre_interet'] = $this->input->post("description");
        $data_info['prix_journee']   = $this->input->post("prix_journee");
        $Talent                      = $this->ModelTalent->getTalentByUserId($this->getBusinessUser()->getId());
        if ($Talent != null && $Talent->id > 0) {
            $data_info['id'] = $Talent->id;
            if ($Talent->status == ModelTalent::UNVALID) {
                $data_info['date_creation'] = date('Y-m-d H:i:s');
                $sendMail                   = true;
            }
        } else {
            $sendMail           = true;
            $data_info['alias'] = $this->create_alias_mentor($this->session->userdata('logged_in_site_web')['name_complet']);
        }
        $data_info['user_id']      = $this->getBusinessUser()->getId();
        $data_info['status']       = ModelTalent::VALID;
        $Talent                    = $this->ModelTalent->save($data_info);
        $id_t                      = $Talent->id;
        $data_horaire              = $this->session->userdata("horaire");
        $data_horaire['talent_id'] = $id_t;
        $this->talent->AddTalentHoraire($data_horaire);
        if (count($langues) > 0) {
            $this->ModelTalent->deleteLang($id_t);
            foreach ($langues as $key => $langue) {
                if (trim($langue) != '') {
                    $datalang['talent_id'] = (int)$id_t;
                    $datalang['langue_id'] = (int)$langue;
                    $datalang['niveau']    = $key == 1 ? '100' : '80';
                    $this->ModelTalent->saveLang($datalang);
                }
            }
        }
        if ($sendMail) {
            SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_MENTOR_ACCOUNT_CREATED,
                $this->getBusinessUser()->getEmail(),
                [
                    'HASH'      => $this->getBusinessUser()->getHash(),
                    'FIRSTNAME' => $this->getBusinessUser()->getPrenom()
                ]
            );
        }
        redirect(base_url() . 'mentor/success');
    }

    //****************************************************************************
    //******************** !! DEBUT !! ISCRIPTION MENTOR *************************

    // Tunnel D'inscription mentor a pas confondre avec devenir mentor

    /**
     * function de l'a premiere connection, qui entregistre le user dans la table talent
     * avec un nouveaux ID et met a jour ses info user(formation, niveaux ...)
     */
    public function step2MentorInscription()
    {
        if ($this->userIsAuthentificate() && !$this->isfirstTimeConnect()) {
            show_404();
        }


        if ($this->input->post()) {

            // Recuperer des info de l'etape 1
            $user['Logged']          = $this->userIsAuthentificate();
            $user['nom']             = $this->security->xss_clean($this->input->post('nom'));
            $user['prenom']          = $this->security->xss_clean($this->input->post('prenom'));
            $user['email']           = $this->security->xss_clean($this->input->post('email'));
            $user['lieu']            = $this->security->xss_clean($this->input->post('lieu'));
            $user['ville']           = $this->security->xss_clean($this->input->post('ville'));
            $user['departement_geo'] = $this->security->xss_clean($this->input->post('departement_geo'));
            $user['region']          = $this->security->xss_clean($this->input->post('region'));
            $user['pays']            = $this->security->xss_clean($this->input->post('pays'));
            $user['levelSchool']     = $this->security->xss_clean((int)$this->input->post('levelSchool'));
            $user['schoollabel']     = $this->security->xss_clean($this->input->post('schoollabel'));
            $user['school_id']       = $this->security->xss_clean((int)$this->input->post('school_id'));
            $user['autre']           = $this->security->xss_clean($this->input->post('autre'));
            $user['autre_checkbox']  = $this->security->xss_clean($this->input->post('autre_checkbox'));
            $user['departement']     = $this->security->xss_clean($this->input->post('dept'));
            $user['password']        = $this->encrypt->encode($this->security->xss_clean($this->input->post('password')));


            // si l'utilisateur s'inscrit via ulyss
            if (!$this->userIsAuthentificate()) {

                //AJOUT DE L'AVATAR
                if (!empty($_FILES['avatar']) && $_FILES['avatar']['error'] == 0 && $_FILES['avatar']['name'] != '') {

                    // File upload configuration
                    $uploadPath              = 'upload/avatar/temp';
                    $config['upload_path']   = $uploadPath;
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size']      = '0';
                    $config['encrypt_name']  = true;

                    // Load and initialize upload library
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);


                    // Upload file to server
                    if ($this->upload->do_upload('avatar')) {
                        // Uploaded file data
                        $fileData       = $this->upload->data();
                        $user['avatar'] = $fileData['file_name'];
                        @unlink($_FILES['avatar']);
                    }
                } else {
                    $user['avatar'] = '/upload/avatar/default.jpg';
                }
            }

            $this->session->set_userdata('InscriptionMentorInfo', $user);
            $data['user']         = $user;
            $data['departements'] = $this->ModelGeneral->getAllDepartementName();
            $data['chapeauTab']   = $this->ModelGeneral->getSecteurOrderByChapeau();


            $this->load->view('template/header', $this->datas);
            $this->load->view('mentor/inscription_mentor2', $data);
            $this->load->view('template/footer', $this->datas);

        } else {
            redirect(base_url());
        }
    }

    public function step3MentorInscription()
    {
        if ($this->userIsAuthentificate() && !$this->isfirstTimeConnect()) {
            show_404();
        }

        $allExpUser = $this->input->post('experience');
        $allentUser = $this->input->post('entreprise');

        if ($allExpUser != null) {
            if ($allentUser != null) {
                foreach ($allExpUser as $numExp => $exp) {
                    if ($exp['entreprise_id'] == '' || $exp['entreprise_id'] == 0) {

                        // enregistrer l'entreprise si elle n'existe pas
                        $compagny['nom']        = $allentUser[$numExp];
                        $compagny['secteur_id'] = $exp['secteur_id'];
                        $compagny['alias']      = $this->create_alias_entreprise($compagny['nom']);

                        $ModelEntreprise                      = $this->ModelEntreprise->save($compagny);
                        $allExpUser[$numExp]['entreprise_id'] = $ModelEntreprise->id;
                    }

                    $exp['date_debut'] = $exp['date_debut_annee'] . '-' . $exp['date_debut_mois'] . '-01';
                    unset($exp['date_debut_mois']);
                    unset($exp['date_debut_annee']);

                    if ($exp['date_fin_annee'] == '9999') {
                        $exp['date_fin'] = '9999-12-31';
                        unset($exp['date_fin_mois']);
                        unset($exp['date_fin_annee']);
                    } else {
                        $exp['date_fin'] = $exp['date_fin_annee'] . '-' . $exp['date_fin_mois'] . '-01';
                        unset($exp['date_fin_mois']);
                        unset($exp['date_fin_annee']);
                    }

                    $allExpUser[$numExp] = $exp;
                }
            }
            // Recuperer l'experience
            $this->session->set_userdata('experience_saisie', $allExpUser);

        } else {
            $this->session->set_flashdata('message_error', 'Une erreur est survenue, veuillez réessayer ultérieurement. Si le problème persiste, veuillez nous contacter.');
            redirect(base_url() . 'inscription/insider');
        }


        $data['user']            = $this->session->userdata('InscriptionMentorInfo');
        $data['list_language']   = $this->user->GetListLangues();
        $data['list_tags']       = $this->user->GetListTags();
        $data['list_categories'] = $this->talent->GetCategoriesList();

        $this->load->view('template/header', $this->datas);
        $this->load->view('mentor/inscription_mentor3', $data);
        $this->load->view('template/footer', $this->datas);
    }


    public function step4MentorInscription()
    {
        if ($this->userIsAuthentificate() && !$this->isfirstTimeConnect()) {
            show_404();
        }


        $data['user']            = $this->session->userdata('InscriptionMentorInfo');
        $data['list_language']   = $this->user->GetListLangues();
        $data['list_tags']       = $this->user->GetListTags();
        $data['list_categories'] = $this->talent->GetCategoriesList();
        if ($this->input->post()) {
            $data_p['prix'] = $this->input->post("prix_journee");
            $this->session->set_userdata("price_step3", $data_p['prix']);

            $data_horaire['lundi_8_10']    = $this->input->post("lundi_8_10");
            $data_horaire['mardi_8_10']    = $this->input->post("mardi_8_10");
            $data_horaire['mercredi_8_10'] = $this->input->post("mercredi_8_10");
            $data_horaire['jeudi_8_10']    = $this->input->post("jeudi_8_10");
            $data_horaire['vendredi_8_10'] = $this->input->post("vendredi_8_10");
            $data_horaire['samedi_8_10']   = $this->input->post("samedi_8_10");
            $data_horaire['dimanche_8_10'] = $this->input->post("dimanche_8_10");

            $data_horaire['lundi_10_12']    = $this->input->post("lundi_10_12");
            $data_horaire['mardi_10_12']    = $this->input->post("mardi_10_12");
            $data_horaire['mercredi_10_12'] = $this->input->post("mercredi_10_12");
            $data_horaire['jeudi_10_12']    = $this->input->post("jeudi_10_12");
            $data_horaire['vendredi_10_12'] = $this->input->post("vendredi_10_12");
            $data_horaire['samedi_10_12']   = $this->input->post("samedi_10_12");
            $data_horaire['dimanche_10_12'] = $this->input->post("dimanche_10_12");

            $data_horaire['lundi_12_14']    = $this->input->post("lundi_12_14");
            $data_horaire['mardi_12_14']    = $this->input->post("mardi_12_14");
            $data_horaire['mercredi_12_14'] = $this->input->post("mercredi_12_14");
            $data_horaire['jeudi_12_14']    = $this->input->post("jeudi_12_14");
            $data_horaire['vendredi_12_14'] = $this->input->post("vendredi_12_14");
            $data_horaire['samedi_12_14']   = $this->input->post("samedi_12_14");
            $data_horaire['dimanche_12_14'] = $this->input->post("dimanche_12_14");

            $data_horaire['lundi_14_16']    = $this->input->post("lundi_14_16");
            $data_horaire['mardi_14_16']    = $this->input->post("mardi_14_16");
            $data_horaire['mercredi_14_16'] = $this->input->post("mercredi_14_16");
            $data_horaire['jeudi_14_16']    = $this->input->post("jeudi_14_16");
            $data_horaire['vendredi_14_16'] = $this->input->post("vendredi_14_16");
            $data_horaire['samedi_14_16']   = $this->input->post("samedi_14_16");
            $data_horaire['dimanche_14_16'] = $this->input->post("dimanche_14_16");


            $data_horaire['lundi_16_18']    = $this->input->post("lundi_16_18");
            $data_horaire['mardi_16_18']    = $this->input->post("mardi_16_18");
            $data_horaire['mercredi_16_18'] = $this->input->post("mercredi_16_18");
            $data_horaire['jeudi_16_18']    = $this->input->post("jeudi_16_18");
            $data_horaire['vendredi_16_18'] = $this->input->post("vendredi_16_18");
            $data_horaire['samedi_16_18']   = $this->input->post("samedi_16_18");
            $data_horaire['dimanche_16_18'] = $this->input->post("dimanche_16_18");


            $data_horaire['lundi_18_20']    = $this->input->post("lundi_18_20");
            $data_horaire['mardi_18_20']    = $this->input->post("mardi_18_20");
            $data_horaire['mercredi_18_20'] = $this->input->post("mercredi_18_20");
            $data_horaire['jeudi_18_20']    = $this->input->post("jeudi_18_20");
            $data_horaire['vendredi_18_20'] = $this->input->post("vendredi_18_20");
            $data_horaire['samedi_18_20']   = $this->input->post("samedi_18_20");
            $data_horaire['dimanche_18_20'] = $this->input->post("dimanche_18_20");

            $data_horaire['lundi_20_22']    = $this->input->post("lundi_20_22");
            $data_horaire['mardi_20_22']    = $this->input->post("mardi_20_22");
            $data_horaire['mercredi_20_22'] = $this->input->post("mercredi_20_22");
            $data_horaire['jeudi_20_22']    = $this->input->post("jeudi_20_22");
            $data_horaire['vendredi_20_22'] = $this->input->post("vendredi_20_22");
            $data_horaire['samedi_20_22']   = $this->input->post("samedi_20_22");
            $data_horaire['dimanche_20_22'] = $this->input->post("dimanche_20_22");
            $this->session->set_userdata("horaire", $data_horaire);

        }


        $this->load->view('template/header', $this->datas);
        $this->load->view('mentor/inscription_mentor4', $data);
        $this->load->view('template/footer', $this->datas);
    }


    public function addMentorInscription()
    {
        if ($this->userIsAuthentificate() && !$this->isfirstTimeConnect()) {
            show_404();
        }

        $step1MentorInfo = $this->session->userdata('InscriptionMentorInfo');
        $step2MentorInfo = $this->session->userdata('experience_saisie');


        // ********************* !!DEBUT!! CREATION DU USER **************************** \\
        //*****************(Uniquement inscription via ulyss) ***************** \\

        $User = $this->ModelUser->getUserByEmail($step1MentorInfo['email']);

        if ($User == null) {

            $array = [
                'nom'            => isset($step1MentorInfo['nom']) ? $step1MentorInfo['nom'] : '',
                'prenom'         => isset($step1MentorInfo['prenom']) ? $step1MentorInfo['prenom'] : '',
                'email'          => isset($step1MentorInfo['email']) ? $step1MentorInfo['email'] : '',
                'password'       => $step1MentorInfo['password'],
                'cover'          => 'default.jpg',
                'fermer'         => '0',
                'student'        => '0',
                'hash'           => sha1($step1MentorInfo['email'] . self::$hashString),
                'date_connexion' => date('Y-m-d H:i:s'),
                'code_phone'     => null,
                'tel_verified'   => $step1MentorInfo['tel_verified'],
                'extension_tel'  => $step1MentorInfo['extension_tel'],
                'tel'            => $step1MentorInfo['tel'],
            ];

            $array['alias'] = $this->create_alias_user($step1MentorInfo['nom'] . '-' . $step1MentorInfo['prenom']);


            if ($step1MentorInfo['avatar'] != '/upload/avatar/default.jpg') {
                $c               = copy('./upload/avatar/temp/' . $step1MentorInfo['avatar'], './upload/avatar/' . $step1MentorInfo['avatar']);
                $d               = unlink('./upload/avatar/temp/' . $step1MentorInfo['avatar']);
                $array['avatar'] = $c && $d ? '/upload/avatar/' . $step1MentorInfo['avatar'] : '/upload/avatar/default.jpg';
            } else {
                $array['avatar'] = '/upload/avatar/default.jpg';
            }


            $this->load->model('ModelUser');
            $User = $this->ModelUser->save($array);
        }


        // ********************* !!FIN!! CREATION DU USER **************************** \\

        // ********************* VERIFICATION ET CREATION DU TALENT **************************** \\

        $Talent                        = $this->ModelTalent->getTalentByUserId($User->id);
        $data_info['user_id']          = $User->id;
        $data_info['niveau_formation'] = $step1MentorInfo['levelSchool'];
        $data_info['departement_id']   = $step1MentorInfo['departement'];
        $data_info['lieu']             = $step1MentorInfo['lieu'];
        $data_info['ville']            = $step1MentorInfo['ville'];
        $data_info['departement_geo']  = $step1MentorInfo['departement_geo'];
        $data_info['region']           = $step1MentorInfo['region'];
        $data_info['pays']             = $step1MentorInfo['pays'];


        if ($Talent != null && $Talent->id > 0) {
            $data_info['id'] = $Talent->id;
        } else {
            $data_info['alias'] = $this->create_alias_mentor($User->nom . ' ' . $User->prenom);
        }

        $Talent = $this->ModelTalent->save($data_info);


        // ********************* !!!FIN!! VERIFICATION ET CREATION DU TALENT **************************** \\


        // *************************** !! DEBUT !! EXPERIENCES ADD OR UPDATE ***************************** \\
        if (!empty($step2MentorInfo)) {
            foreach ($step2MentorInfo as $expMentor) {

                // virification si l'entreprise elle existe ou pas par rapport a son nom
                // entreprise id
                if ($expMentor['entreprise_id'] != 0 && $expMentor['entreprise_id'] != '') {
                    $compagny_id = $expMentor['entreprise_id'];
                } else {
                    $compagny_id = $this->ModelEntreprises->getEntrepriseIdByName($expMentor['entreprise']);
                }

                if (!empty($compagny_id) && $compagny_id != false) {
                    $talent_experience['entreprise_id'] = $compagny_id;
                    $talent_experience['secteur_id']    = $this->ModelEntreprises->getEntrepriseSecteurIdById($compagny_id);
                } else {
                    // enregistrer l'entreprise si elle n'existe pas
                    $compagny['nom']        = $expMentor['entreprise'];
                    $compagny['secteur_id'] = $expMentor['secteur_id'];
                    $compagny['alias']      = $this->create_alias_entreprise($expMentor['entreprise']);

                    //var_dump('entreprise :');
                    //var_dump($compagny);
                    $ModelEntreprise = $this->ModelEntreprise->save($compagny);

                    $talent_experience['secteur_id']    = $ModelEntreprise->secteur_id;
                    $talent_experience['entreprise_id'] = $ModelEntreprise->id;
                }

                /************************************/
                /*     EXPERIENCES ADD OR UPDATE    */
                /************************************/
                // Recuperer l'experience depuit la table linkedin user

                $talent_experience['talent_id']       = $Talent->id;
                $talent_experience['date_debut']      = $expMentor['date_debut'];
                $talent_experience['date_fin']        = $expMentor['date_fin'];
                $talent_experience['lieu']            = $expMentor['lieu'];
                $talent_experience['ville']           = $expMentor['ville'];
                $talent_experience['departement_geo'] = $expMentor['departement_geo'];
                $talent_experience['departement_id']  = $expMentor['departement_id'];
                $talent_experience['region']          = $expMentor['region'];
                $talent_experience['pays']            = $expMentor['pays'];
                $talent_experience['titre_mission']   = $expMentor['titre_mission'];

                // Enregistrer l'experience avec l'id de l'entreprise
                $this->ModelTalent->saveExperiences($talent_experience);
            }
        }

        // *************************** !! FIN !! EXPERIENCES ADD OR UPDATE ***************************** \\


        //***************************** !! DEBUT !! FORMATIONS ADD *************************************** \\

        if ($step1MentorInfo['levelSchool'] != 99 && $step1MentorInfo['levelSchool'] > 1) {

            if ($step1MentorInfo['schoollabel'] == '' && $step1MentorInfo['autre_checkbox'] == 'on') {
                $existFormation = $this->ModelTalent->getFormationsByIdTalentAndSchoolName($Talent->id, $step1MentorInfo['autre']);
            } else {
                $existFormation = $this->ModelTalent->getFormationsByIdTalentAndSchoolName($Talent->id, $step1MentorInfo['schoollabel']);
            }

            // Enregistrer le nom dans la formation

            if (empty($existFormation)) {
                $talent_formation['talent_id'] = $Talent->id;

                if ($step1MentorInfo['schoollabel'] == '' && $step1MentorInfo['autre_checkbox'] == 'on') {
                    $talent_formation['university'] = $step1MentorInfo['autre'];
                    $talent_formation['ecole_id']   = '0';
                } else {
                    $talent_formation['ecole_id']   = $step1MentorInfo['school_id'];
                    $talent_formation['university'] = $step1MentorInfo['schoollabel'];
                }
                //var_dump('Formation :');
                //var_dump($talent_formation);
                $formation = $this->ModelTalent->saveFormations($talent_formation);
            }
        }


        //***************************** !! FIN !! FORMATIONS ADD *************************************** \\


        //***************************** !! DEBUT !! LAST STEP 4 VALIDATION AND PASS MENTOR  *************************************** \\

        if (!$this->input->post("description")) {
            $this->index();
        }

        $sendMail                       = false;
        $langues                        = [];
        $step4MentorInfo['description'] = $this->input->post("description");
        if (trim($this->input->post("countrylangue1")) != '') {
            $langues[1] = $this->input->post("countrylangue1");
        }
        if (trim($this->input->post("countrylangue2")) != '') {
            $langues[2] = $this->input->post("countrylangue2");
        }
        $step4MentorInfo['prix']           = $this->session->userdata('price_step3');
        $step4MentorInfo['centre_interet'] = $this->input->post("description");
        $step4MentorInfo['prix_journee']   = $this->input->post("prix_journee");

        if ($Talent != null && $Talent->id > 0) {
            $step4MentorInfo['id'] = $Talent->id;
            if ($Talent->status == ModelTalent::UNVALID) {
                $data_info['date_creation'] = date('Y-m-d H:i:s');
                $sendMail                   = true;
            }
        } else {
            $sendMail = true;
        }
        $step4MentorInfo['user_id']   = $User->id;
        $step4MentorInfo['status']    = ModelTalent::VALID;
        $Talent                       = $this->ModelTalent->save($step4MentorInfo);
        $id_t                         = $Talent->id;
        $step3MentorInfo              = $this->session->userdata("horaire");
        $step3MentorInfo['talent_id'] = $id_t;
        $this->talent->AddTalentHoraire($step3MentorInfo);

        if (count($langues) > 0) {
            $this->ModelTalent->deleteLang($id_t);
            foreach ($langues as $key => $langue) {
                if (trim($langue) != '') {
                    $datalang['talent_id'] = (int)$id_t;
                    $datalang['langue_id'] = (int)$langue;
                    $datalang['niveau']    = $key == 1 ? '100' : '80';
                    $this->ModelTalent->saveLang($datalang);
                }
            }
        }

        if ($sendMail) {
            SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_MENTOR_ACCOUNT_CREATED,
                $User->email,
                [
                    'HASH'      => $User->hash,
                    'FIRSTNAME' => $User->prenom
                ]
            );
        }

        //***************************** !! FIN !! LAST STEP 4 VALIDATION AND PASS MENTOR  *************************************** \\

        if (!$this->userIsAuthentificate()) {
            $id = $this->encrypt->encode($User->id);

            $sess_array = [
                'id'           => $id,
                'email'        => $User->email,
                'avatar'       => $User->avatar,
                'name_complet' => $User->prenom . ' ' . $User->nom,
                'tel'          => $User->tel,
                'name'         => $User->prenom . ' ' . strtoupper(substr($User->nom, 0, 1))
            ];

            $this->session->set_userdata('logged_in_site_web', $sess_array);
        }


        $this->session->set_flashdata('message_valid', "Bienvenue Insider sur Ulyss.co, vous êtes à présent bien inscrit.");
        redirect(base_url() . 'mentor/success');
    }

    //******************** !! FIN !! INSCPRIPTION MENTOR *************************
    //****************************************************************************


    public function ProfilUpdate()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }

        $allExpUser = $this->input->post('experience');
        $allentUser = $this->input->post('entreprise');
        if ($allExpUser != null) {
            if ($allentUser != null) {
                foreach ($allExpUser as $numExp => $exp) {
                    if ($exp['entreprise_id'] == '' || $exp['entreprise_id'] == 0) {
                        // enregistrer l'entreprise si elle n'existe pas
                        $compagny['nom']                      = $allentUser[$numExp];
                        $compagny['secteur_id']               = $exp['secteur_id'];
                        $compagny['alias']                    = $this->create_alias_entreprise($compagny['nom']);
                        $ModelEntreprise                      = $this->ModelEntreprise->save($compagny);
                        $allExpUser[$numExp]['entreprise_id'] = $ModelEntreprise->id;
                    }
                }
            }
            // Recuperer l'experience
            $this->session->set_userdata('experience_saisie', $allExpUser);
            var_dump($allExpUser);
            die();
        } else {
            redirect(base_url() . 'mentor/etape1');
        }
        $data['info_user']       = $this->getBusinessUser()->getUser();
        $data['list_language']   = $this->user->GetListLangues();
        $data['list_tags']       = $this->user->GetListTags();
        $data['list_categories'] = $this->talent->GetCategoriesList();
        $this->load->view('template/header', $this->datas);
        $this->load->view('home', $data);
        $this->load->view('template/footer', $this->datas);
    }

    public function UpdateProfilValidation()
    {

        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }

        $allExpUser = $this->input->post('experience');
        $allentUser = $this->input->post('entreprise');
        $profilUrl  = $this->getBusinessUser()->getMentor()->getUrlProfile();

        if ($allExpUser != null) {
            if ($allentUser != null) {
                foreach ($allExpUser as $numExp => $exp) {
                    if ($exp['entreprise_id'] == '' || $exp['entreprise_id'] == 0) {
                        // enregistrer l'entreprise si elle n'existe pas
                        $compagny['nom']        = $allentUser[$numExp];
                        $compagny['secteur_id'] = $exp['secteur_id'];
                        $compagny['alias']      = $this->create_alias_entreprise($compagny['nom']);

                        $ModelEntreprise                      = $this->ModelEntreprise->save($compagny);
                        $allExpUser[$numExp]['entreprise_id'] = $ModelEntreprise->id;
                    }
                }
            }

            foreach ($allExpUser as $exp) { // enregistrement de tout les experience saisie
                $exp['talent_id'] = $this->getBusinessUser()->getProfileTalent()->getId();
                $this->ModelTalent->saveExperiences($exp);
            }
        } else {
            redirect(base_url() . $profilUrl);
        }

        $this->session->set_flashdata('message_valid', 'Vos expériences sont mises à jour. ');
        redirect(base_url() . $profilUrl);
    }

    public function etape2VerificationForm()
    {

        $experience = $this->input->post('experience');

        // Loop through hotels and add the validation
        foreach ($experience as $id => $datas) {
            $this->form_validation->set_rules('entreprise[' . $id . ']', 'entreprise', 'required',
                [
                    'required' => 'Veuillez indiquer une entreprise'
                ]);
            $this->form_validation->set_rules('experience[' . $id . '][titre_mission]', 'experience', 'required|max_length[100]',
                [
                    'required'   => 'Veuillez indiquer un poste',
                    'max_length' => 'Description maximum 100 caractères'
                ]);
            $this->form_validation->set_rules('experience[' . $id . '][secteur_id]', 'secteur', 'required',
                [
                    'required' => 'Veuillez choisir un secteur d\'activité'
                ]);
            $this->form_validation->set_rules('experience[' . $id . '][date_debut_mois]', 'DateDebutMois', 'required',
                [
                    'required' => 'Veuillez indiquer un mois pour la date de début'
                ]);
            $this->form_validation->set_rules('experience[' . $id . '][date_debut_annee]', 'DateDebutAnnee', 'required',
                [
                    'required' => 'Veuillez indiquer une anneé pour la date de début'
                ]);
            $this->form_validation->set_rules('experience[' . $id . '][date_fin_mois]', 'DateFinMois', 'required',
                [
                    'required' => 'Veuillez indiquer un mois pour la date de fin'
                ]);
            $this->form_validation->set_rules('experience[' . $id . '][date_fin_annee]', 'DateFinAnnee', 'required',
                [
                    'required' => 'Veuillez indiquer une anneé pour la date de fin'
                ]);
            $this->form_validation->set_rules('experience[' . $id . '][ville]', 'lieu', 'required',
                [
                    'required' => 'Veuillez indiquer un lieu valide'
                ]);
            $this->form_validation->set_rules('experience[' . $id . '][departement_id]', 'departement', 'required',
                [
                    'required' => 'Veuillez choisir un departement professionnel'
                ]);
            $this->form_validation->set_rules('experience[' . $id . '][description]', 'description', 'min_length[50]',
                [
                    'min_length' => 'Description minimum 50 caractères'
                ]);
        }

        if ($this->form_validation->run() == false) {
            $data['valid_exp'] = false;
            $data['errors']    = $this->form_validation->error_array();
            echo json_encode($data);
        } else {
            $data['valid_exp'] = true;
            echo json_encode($data);
        }
    }

    private
    function set_upload_options()
    {
        //upload an image options
        $config                  = [];
        $config['upload_path']   = 'upload/talents/portfolio/';
        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';

        return $config;
    }

    public
    function success()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $this->datas['header_class'] = 'h_r_comp';
        $this->datas['header_logo']  = 'logo_2';
        $this->load->view('template/header', $this->datas);
        $this->load->view('donner_des_cours_success');
        $this->load->view('template/footer', $this->datas);
    }

    private
    function create_alias_user(
        $string
    ){

        $this->load->model('user_model', 'user');
        $this->load->library('urlify');
        $verifcation  = $this->urlify->filter($string);
        $verifcation1 = $verifcation;
        $result       = $this->talent->verifcationExistAlias($verifcation);
        if ($result) {
            $i = 1;
            while ($result) {
                $verifcation = $verifcation1 . "." . $i;
                $result      = $this->talent->verifcationExistAlias($verifcation);
                $i++;
            }

        }


        return $verifcation;
    }

    private
    function create_alias_mentor(
        $string
    ){

        $this->load->model('user_model', 'user');
        $this->load->library('urlify');
        $verifcation  = $this->urlify->filter($string);
        $verifcation1 = $verifcation;
        $result       = $this->talent->verifcationExistAlias($verifcation);
        if ($result) {
            $i = 1;
            while ($result) {
                $verifcation = $verifcation1 . "." . $i;
                $result      = $this->talent->verifcationExistAlias($verifcation);
                $i++;
            }

        }


        return $verifcation;
    }

    public
    function ajouter_document()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }

        $data = [];

        if ($this->session->userdata('logged_in_site_web')) {
            $status            = "";
            $msg               = "";
            $file_element_name = 'userfile';
            if ($status != "error") {
                $config['upload_path']   = 'upload/talents/portfolio/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|doc|txt|docx';
                $config['max_size']      = 1024 * 8;
                $config['encrypt_name']  = true;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload($file_element_name)) {
                    $status = 'error';
                    $msg    = $this->upload->display_errors('', '');
                    echo json_encode(['status' => $status, "error" => "problem upload"]);

                } else {
                    $data   = $this->upload->data();
                    $status = "success";
                    $msg    = "File successfully uploaded";
                    @unlink($_FILES[$file_element_name]);

                    echo json_encode(['status' => $status, 'value' => $data['file_name'], 'msg' => base_url() . $config['upload_path'] . $data['file_name']]);
                }

            }
        }
    }

}

