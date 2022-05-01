<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Inscription extends CI_Controller
{
    private static $hashString = 'E9sz.g-.@\mDE:z?+GZ~-KH`b5NnpCR-T7';

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->library('mailing');
        $this->load->library('form_validation');

    }

    function verfy()
    {
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Mot de passe', 'required');
        if ($this->form_validation->run() == false) {
            $data['erreur'] = "on";
            echo json_encode($data);
        } else {
            $this->load->library('encrypt');
            $data1['email']      = $this->input->post('email');
            $data1['nom']        = $this->input->post('nom');
            $data1['prenom']     = $this->input->post('prenom');
            $data1['biographie'] = $this->input->post('biographie');


            $data1['tel']      = "+33" . $this->input->post('tel');
            $data1['ville_id'] = $this->input->post('ville');
            $data1['student']  = ($this->input->post('etudiant') == "oui") ? true : false;

            $data1['password'] = $this->encrypt->encode($this->input->post('password'));
            if ($this->input->post('code') and $this->session->userdata('code_phone') and $this->input->post('code') == $this->session->userdata('code_phone')) {
                $data1['tel_verified']                         = true;
                $data1['notifications_demande_accepte_refuse'] = "sms_email";
                $data1['notifications_demande_pour_talent']    = "sms_email";


            }
            //code_activation
            $code                     = random_string('alnum', 16);
            $data1['code_activation'] = $code;
            $data1['alias']           = $this->create_alias($data1['prenom'] . '-' . $data1['nom']);


            $element = $this->user->AddUser($data1);
            $this->mailing->email_inscription($data1);

            $data['erreur'] = "off";
            $data['msg']    = "votre compte a été creer avec success";
            echo json_encode($data);
        }

    }

    private function create_alias($string)
    {

        $this->load->model('user_model', 'user');
        $this->load->library('urlify');
        $verifcation = $this->urlify->filter($string);
        $result      = $this->user->verifcationExistAlias($verifcation);
        if ($result) {
            $i   = 1;
            $old = $verifcation;
            while ($result) {
                $verifcation = $old . "." . $i;
                $result      = $this->user->verifcationExistAlias($verifcation);
                $i++;
            }
        }

        return $verifcation;

    }

    public function verified_email()
    {
        $this->form_validation->set_rules('email', 'email', 'required|valid_email|is_unique[user.email]');
        if ($this->form_validation->run() == false) {
            $data['on'] = "on";
            echo json_encode($data);
        } else {
            $data['on'] = "off";
            echo json_encode($data);

        }
    }

    public function confirmation_phone()
    {
        $phoneext    = trim($this->input->get('ext'));
        $phonenumber = trim($this->input->get('phone'));
        if ($phoneext == '33' && strlen($phonenumber) == '10' && substr($phonenumber, 0, 1) == 0) {
            $phonenumber = substr($phonenumber, 1);
        }

        $BusinessUser          = $this->getBusinessUser();
        $User['id']            = $BusinessUser->getId();
        $User['tel_verified']  = 0;
        $User['extension_tel'] = $phoneext;
        $User['tel']           = $phonenumber;
        $User['code_phone']    = $BusinessUser->getCodePhone() == '' ? random_string('nozero', 4) : $BusinessUser->getCodePhone();
        $retour                = SendInBlue::sendSms($phoneext . $phonenumber, 'Bonjour, pour vérifier votre numéro, veuillez rentrer le code ' . $User['code_phone'] . ' sur le site ulyss.co');
        $jsonretour            = json_decode($retour, true);

        if (isset($jsonretour['status']) && $jsonretour['status'] == 'OK') {
            $this->ModelUser->save($User);
        } else {
            if (isset($jsonretour['description']) && stristr($jsonretour['description'], 'Invalid telephone number')) {
                $jsonretour['description'] = 'Veuillez contrôler votre numéro de téléphone';
                $retour                    = json_encode($jsonretour);
            }
        }
        echo $retour;
    }

    public function confirmation_phoneMentor()
    {
        $phoneext    = trim($this->input->get('ext'));
        $phonenumber = trim($this->input->get('phone'));
        $code_phone  = random_string('nozero', 4);
        if ($phoneext == '33' && strlen($phonenumber) == '10' && substr($phonenumber, 0, 1) == 0) {
            $phonenumber = substr($phonenumber, 1);
        }

        $User                  = $this->session->userdata('InscriptionMentorInfo');
        $User['code_phone']    = $code_phone;
        $User['tel_verified']  = 0;
        $User['extension_tel'] = $phoneext;
        $User['tel']           = $phonenumber;

        $this->session->set_userdata('InscriptionMentorInfo', $User);

        $retour     = SendInBlue::sendSms($phoneext . $phonenumber, 'Bonjour, pour vérifier votre numéro, veuillez rentrer le code ' . $code_phone . ' sur le site ulyss.co');
        $jsonretour = json_decode($retour, true);

        if (isset($jsonretour['description']) && stristr($jsonretour['description'], 'Invalid telephone number')) {
            $jsonretour['description'] = 'Veuillez contrôler votre numéro de téléphone';
            $retour                    = json_encode($jsonretour);
        }

        echo $retour;
    }


    public function InscriptionEtape1()
    {
        if ($this->userIsAuthentificate() && !$this->isfirstTimeConnect()) {
            show_404();
        }

        $data['Logged'] = $this->userIsAuthentificate();

        $data['departements'] = $this->ModelGeneral->getAllDepartementName();

        $this->load->view('template/header', $this->datas);
        $this->load->view('inscription', $data);
        $this->load->view('template/footer', $this->datas);
    }

    public function inscriptionEtape1Mentor()
    {
        if ($this->userIsAuthentificate() && !$this->isfirstTimeConnect()) {
            show_404();
        }

        $data['Logged'] = $this->userIsAuthentificate();

        $data['departements'] = $this->ModelGeneral->getAllDepartementName();

        $this->load->view('template/header', $this->datas);
        $this->load->view('mentor/inscription_mentor1', $data);
        $this->load->view('template/footer', $this->datas);
    }


    /**
     * function de l'a premiere connection, qui entregistre le user dans la table talent
     * avec un nouveaux ID et met a jour ses info user(formation, niveaux ...)
     */
    public function firstTime()
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


            // si l'utilisateur s'inscri via ulyss
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

            $this->session->set_userdata('step1', $user);
            $data['user']         = $user;
            $data['departements'] = $this->ModelGeneral->getAllDepartementName();
            $data['chapeauTab']   = $this->ModelGeneral->getSecteurOrderByChapeau();

            $this->load->view('template/header', $this->datas);
            $this->load->view('inscription_xp', $data);
            $this->load->view('template/footer', $this->datas);

        } else {
            redirect(base_url());
        }
    }


    /**
     * function de l'a premiere connection,etape 2 enregistre l'experience du user
     * et elle a en memoire les information du user saisie dans l'etape de de l'inscription
     *
     * 1- si l'utilisateur c'est connecté avec Linkedin ( user et linkedin user est crée) alor on crée le talent et on enregistre sont experience ( si il on a une).
     * 2- on crée le user dans user et dans talent et on enregistre sont experience ( si il on a une)
     */
    public function firstTimeStep2()
    {
        if ($this->userIsAuthentificate() && !$this->isfirstTimeConnect()) {
            show_404();
        }

        $step1_info = $this->session->userdata('step1');

        if ($step1_info == null) {
            $this->session->set_flashdata('message_error', 'Veuillez compléter la première étape');
            redirect('inscription/etape1');
        }

        if ($this->input->post()) {
            $User       = $this->ModelUser->getUserByEmail($step1_info['email']);
            $step2_info = $this->input->post();

            // var_dump('STEP 1  :');
            //var_dump($step1_info);
            //var_dump('STEP 2 :');
            //var_dump($step2_info);

            // ********************* CREATION DU USER **************************** \\
            //*****************(Uniquement inscription via ulyss) ***************** \\
            if ($User == null) {

                $array = [
                    'nom'            => isset($step1_info['nom']) ? $step1_info['nom'] : '',
                    'prenom'         => isset($step1_info['prenom']) ? $step1_info['prenom'] : '',
                    'email'          => isset($step1_info['email']) ? $step1_info['email'] : '',
                    'password'       => $step1_info['password'],
                    'cover'          => 'default.jpg',
                    'fermer'         => '0',
                    'student'        => '0',
                    'hash'           => sha1($step1_info['email'] . self::$hashString),
                    'date_connexion' => date('Y-m-d H:i:s')
                ];

                $array['alias'] = $this->create_alias($step1_info['nom'] . '-' . $step1_info['prenom']);


                if ($step1_info['avatar'] != '/upload/avatar/default.jpg') {
                    $c               = copy('./upload/avatar/temp/' . $step1_info['avatar'], './upload/avatar/' . $step1_info['avatar']);
                    $d               = unlink('./upload/avatar/temp/' . $step1_info['avatar']);
                    $array['avatar'] = $c && $d ? '/upload/avatar/' . $step1_info['avatar'] : '/upload/avatar/default.jpg';
                } else {
                    $array['avatar'] = '/upload/avatar/default.jpg';
                }


                $this->load->model('ModelUser');
                $User = $this->ModelUser->save($array);

                SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_MAIL_CREATION_COMPTE,
                    $User->email,
                    [
                        'HASH'      => $User->hash,
                        'FIRSTNAME' => $User->prenom
                    ]
                );
            }


            // ********************* VERIFICATION ET CREATION DU TALENT **************************** \\

            $Talent                        = $this->ModelTalent->getTalentByUserId($User->id);
            $data_info['user_id']          = $User->id;
            $data_info['niveau_formation'] = $step1_info['levelSchool'];
            $data_info['departement_id']   = $step1_info['departement'];
            $data_info['lieu']             = $step1_info['lieu'];
            $data_info['ville']            = $step1_info['ville'];
            $data_info['departement_geo']  = $step1_info['departement_geo'];
            $data_info['region']           = $step1_info['region'];
            $data_info['pays']             = $step1_info['pays'];


            if ($Talent != null && $Talent->id > 0) {
                $data_info['id'] = $Talent->id;
            } else {
                $data_info['alias'] = $this->create_alias($User->nom . ' ' . $User->prenom);
            }

            //var_dump('Talent :');
            //var_dump($data_info);
            $Talent = $this->ModelTalent->save($data_info);

            if (empty($step2_info['no_xp'])) {

                // virification si l'entreprise elle existe ou pas par rapport a son nom
                // entreprise id
                if ($step2_info['entreprise_id'] != 0 && $step2_info['entreprise_id'] != '') {
                    $compagny_id = $step2_info['entreprise_id'];
                } else {
                    $compagny_id = $this->ModelEntreprises->getEntrepriseIdByName($step2_info['entreprise']);
                }

                if (!empty($compagny_id) && $compagny_id != false) {
                    $talent_experience['entreprise_id'] = $compagny_id;
                    $talent_experience['secteur_id']    = $this->ModelEntreprises->getEntrepriseSecteurIdById($compagny_id);
                } else {
                    // enregistrer l'entreprise si elle n'existe pas
                    $compagny['nom']        = $step2_info['entreprise'];
                    $compagny['secteur_id'] = $step2_info['secteur_id'];
                    $compagny['alias']      = $this->create_alias_entreprise($step2_info['entreprise']);

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
                $talent_experience['lieu']            = $step2_info['lieu'];
                $talent_experience['ville']           = $step2_info['ville'];
                $talent_experience['departement_geo'] = $step2_info['departement_geo'];
                $talent_experience['region']          = $step2_info['region'];
                $talent_experience['pays']            = $step2_info['pays'];
                $talent_experience['titre_mission']   = $step2_info['titre_mission'];
                $talent_experience['departement_id']  = $step2_info['departement_id'];
                $talent_experience['date_debut']      = $step2_info['date_debut_annee'] . '-' . $step2_info['date_debut_mois'] . '-01';
                $talent_experience['date_fin']        = $step2_info['date_fin_annee'] == '9999' ? '9999-12-31' : $step2_info['date_fin_annee'] . '-' . $step2_info['date_fin_mois'] . '-01';


                //var_dump('experience :');
                //var_dump($talent_experience);

                $this->ModelTalent->saveExperiences($talent_experience);
            }


            /************************************/
            /*          FORMATIONS ADD          */
            /************************************/


            if ($step1_info['levelSchool'] > 1) {

                if ($step1_info['schoollabel'] == '' && $step1_info['autre_checkbox'] == 'on') {
                    $existFormation = $this->ModelTalent->getFormationsByIdTalentAndSchoolName($Talent->id, $step1_info['autre']);
                } else {
                    $existFormation = $this->ModelTalent->getFormationsByIdTalentAndSchoolName($Talent->id, $step1_info['schoollabel']);
                }

                // Enregistrer le nom dans la formation

                if (empty($existFormation)) {
                    $talent_formation['talent_id'] = $Talent->id;

                    if ($step1_info['schoollabel'] == '' && $step1_info['autre_checkbox'] == 'on') {
                        $talent_formation['university'] = $step1_info['autre'];
                        $talent_formation['ecole_id']   = '0';
                    } else {
                        $talent_formation['ecole_id']   = $step1_info['school_id'];
                        $talent_formation['university'] = $step1_info['schoollabel'];
                    }
                    //var_dump('Formation :');
                    //var_dump($talent_formation);
                    $this->ModelTalent->saveFormations($talent_formation);
                }
            }

            // die();

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
            $this->session->set_flashdata('message_valid', "Bienvenue sur Ulyss.co, vous êtes à présent bien inscrit.");
            redirect(base_url());
        } else {
            $this->session->set_flashdata('message_error', "Un incident technique est survenu. Veuillez vous réinscrire à nouveau. Si le problème persiste, merci de nous contacter.");
            redirect(base_url());
        }
    }


    // firstTimeVerification gere les erreur dans la page inscription
    public function firstTimeVerification()
    {

        $schoolid    = $this->input->post('school_id');
        $validbox    = $this->input->post('autre_checkbox');
        $levelSchool = $this->input->post('levelSchool');


        $this->form_validation->set_rules('nom', 'nom', 'required',
            [
                'required' => 'Veuillez indiquer un nom' . $validbox
            ]);

        $this->form_validation->set_rules('prenom', 'prenom', 'required',
            [
                'required' => 'Veuillez indiquer un prenom'
            ]);

        if (!$this->userIsAuthentificate()) {
            $this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|is_unique[user.email]',
                [
                    'required'    => 'Veuillez indiquer un email',
                    'valid_email' => 'le format de l\'adresse électronique n\'est pas respecté',
                    'is_unique'   => 'Cette adresse email est déjà enregistrée'
                ]);

            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[20]',
                [
                    'required'   => 'Veuillez saisir votre mot de passe ',
                    'min_length' => 'votre mot de passe doit comprendre entre 6 à 20 caractères',
                    'max_length' => 'votre mot de passe doit comprendre entre 6 à 20 caractères'
                ]
            );
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]',
                [
                    'required' => 'Veuillez saisir à nouveau votre mot de passe',
                    'matches'  => 'Les deux mots de passe ne sont pas identiques'
                ]
            );
        } else {
            $this->form_validation->set_rules('email', 'email', 'required|valid_email',
                [
                    'required'  => 'Veuillez indiquer un email',
                    'is_unique' => 'Cette adresse email est déjà enregistrée'
                ]);
        }


        $this->form_validation->set_rules('ville', 'ville', 'required',
            [
                'required' => 'Veuillez indiquer un lieu de la liste deroulante'
            ]);

        $this->form_validation->set_rules('levelSchool', 'levelSchool', 'required',
            [
                'required' => 'Veuillez selectionner un niveau d\'étude'
            ]);

        if ($levelSchool != null && $levelSchool > 1 && $levelSchool != 99) {
            if ($schoolid == '0' && $validbox == null) {
                $this->form_validation->set_rules('school_id', 'school_id', 'required|greater_than[0]',
                    [
                        'greater_than' => 'Veuillez choisir une école ou cocher "Mon ecole n\'existe pas"'
                    ]);
            }
            if ($schoolid == '0' && $validbox == 'on') {
                $this->form_validation->set_rules('autre', 'autre', 'required',
                    [
                        'required' => 'Veuillez indiquer une autre ecole'
                    ]);
            }
        }
        $this->form_validation->set_rules('dept', 'dept', 'required',
            [
                'required' => 'Veuilez choisir un département'
            ]);

        if ($this->form_validation->run() == false) {
            $data['valid_info'] = false;
            $data['errors']     = $this->form_validation->error_array();
            echo json_encode($data);
        } else {
            $data['valid_info'] = true;
            echo json_encode($data);
        }
    }

    public function InscriptionStep2Verification()
    {
        $this->form_validation->set_rules('entreprise', 'entreprise', 'required',
            [
                'required' => 'Veuillez indiquer une entreprise'
            ]);
        $this->form_validation->set_rules('titre_mission', 'experience', 'required|max_length[100]',
            [
                'required'   => 'Veuillez indiquer un poste',
                'max_length' => 'Description maximum 100 caractères'
            ]);
        $this->form_validation->set_rules('secteur_id', 'secteur', 'required',
            [
                'required' => 'Veuillez choisir un secteur d\'activité'
            ]);
        $this->form_validation->set_rules('date_debut_mois', 'DateDebutMois', 'required',
            [
                'required' => 'Veuillez indiquer un mois pour la date de début'
            ]);
        $this->form_validation->set_rules('date_debut_annee', 'DateDebutAnnee', 'required',
            [
                'required' => 'Veuillez indiquer une anneé pour la date de début'
            ]);
        $this->form_validation->set_rules('date_fin_mois', 'DateFinMois', 'required',
            [
                'required' => 'Veuillez indiquer un mois pour la date de fin'
            ]);
        $this->form_validation->set_rules('date_fin_annee', 'DateFinAnnee', 'required',
            [
                'required' => 'Veuillez indiquer une anneé pour la date de fin'
            ]);

        $this->form_validation->set_rules('ville', 'lieu', 'required',
            [
                'required' => 'Veuillez indiquer un lieu valide'
            ]);
        $this->form_validation->set_rules('departement_id', 'departement', 'required',
            [
                'required' => 'Veuillez choisir un departement professionnel'
            ]);

        if ($this->form_validation->run() == false) {
            $data['valid_info'] = false;
            $data['errors']     = $this->form_validation->error_array();
            echo json_encode($data);
        } else {
            $data['valid_info'] = true;
            echo json_encode($data);
        }
    }


}