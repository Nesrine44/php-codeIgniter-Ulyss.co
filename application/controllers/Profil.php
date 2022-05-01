<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Profil extends CI_Controller
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

    public function index($alias = null)
    {
        if (!$alias) {
            show_404();
        }
        $info = $this->user->GetUsersByAlias($alias);
        if (empty($info)) {
            show_404();
        }
        $data['droir_editer'] = false;
        if ($this->session->userdata('logged_in_site_web')) {
            if ($this->id_user_decode == $info->id) {
                $data['droir_editer'] = true;
            }
        }

        $data["info"]               = $info;
        $data["alias"]              = $alias;
        $data["talents"]            = $this->user->GetMesTalentsUser($info->id);
        $data["langues"]            = $this->user->GetLangues($info->id);
        $data['commentaires_recus'] = $this->talent->GetCommentairestomesTalent($info->id);

        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/user', $data);
        $this->load->view('profil/footer1', $data);
        $this->load->view('template/footer', $this->datas);
    }

    public function apropos($alias = null, $talent = null)
    {

        /* FACEBOOK SHARING */
        $this->datas['sharing']['facebook']['og:type']        = 'website';
        $this->datas['sharing']['facebook']['og:url']         = base_url();
        $this->datas['sharing']['facebook']['og:site_name']   = 'Ulyss.co';
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

        if (!$alias) {
            show_404();
        }
        $info = $this->user->GetUsersByAlias($alias);
        if (empty($info)) {
            show_404();
        }
        $data["info"]  = $info;
        $data["alias"] = $alias;
        if (!$talent) {
            show_404();
        }
        $info_talent = $this->talent->GetTalentsByAlias($talent);
        if (empty($info_talent) || (bool)$info_talent->status == false) {
            show_404();
        }
        $data['nombre_cmt']    = $this->talent->GetcountCompTalent($info_talent->id);
        $data['sum_note']      = $this->talent->GetSumNoteCmtTalent($info_talent->id);
        $data['nombre_etoile'] = 0;
        if (!empty($data['sum_note']) && $data['nombre_cmt'] > 0) {
            $data['nombre_etoile'] = round($data['sum_note']->note / $data['nombre_cmt']);
        }

        $data["info_talent"]  = $info_talent;
        $data["alias_talent"] = $talent;
        $data['droir_editer'] = false;

        if ($this->session->userdata('logged_in_site_web')) {
            if ($this->id_user_decode == $info_talent->user_id) {
                $data['droir_editer']             = true;
                $data['list_language']            = $this->user->GetListLangues();
                $data['list_tags']                = $this->user->GetListTags();
                $data['list_categories']          = $this->talent->GetCategoriesList();
                $data['disponibilites_of_talent'] = $this->talent->getDisponibiliteTalent($info_talent->id);

                if (empty($data['disponibilites_of_talent'])) {
                    $data_horaire['talent_id'] = $info_talent->id;
                    $this->talent->AddTalentHoraire($data_horaire);
                    $data['disponibilites_of_talent'] = $this->talent->getDisponibiliteTalent($info_talent->id);

                }
            } else {
                $daa_vues['talent_id'] = $info_talent->id;
                $daa_vues['user_id']   = $this->id_user_decode;
                $this->talent->AddVueTalent($daa_vues);
            }
        }

        $data["mode_operatoire"] = $this->talent->modeOperatoire($info_talent->id);
        $data["experiences"]     = $this->talent->GetExperiences($info_talent->id);

        // module Choix entreprise Rdv (filtre doublons)
        foreach ($data["experiences"] as $exp) {
            $data["tabEntRdv"][] = $exp->entreprise_id;
        }
        $data["tabEntRdv"] = array_unique($data["tabEntRdv"]);
        // End

        $data["formations"]  = $this->talent->GetFormations($info_talent->id);
        $data["portfolio"]   = $this->talent->GetPortfolio($info_talent->id);
        $data["references"]  = $this->talent->GetReferences($info_talent->id);
        $data["categories"]  = $this->talent->GetCategories($info_talent->id);
        $data["langues"]     = $this->talent->GetLangues($info_talent->id);
        $data["tags"]        = $this->talent->GetTags($info_talent->id);
        $data["nbr_talents"] = $this->user->getCountMesTalents($info->id);

        $BusinessUser         = new BusinessUser($info);
        $data["BusinessUser"] = $BusinessUser;
        $lastExp              = $BusinessUser->getProfileTalent()->getLastExperience();
        $lastExp->entName     = $this->user_info->getEntrepriseName($lastExp->entreprise_id);
        $data["lastExp"]      = $lastExp;

        /* METAS SEO */
        $this->datas['SEO_title_page'] = 'ULYSS.CO : ' . $data["BusinessUser"]->getFullName() . ', ' . $data["BusinessUser"]->getBusinessUserLinkedin()->getActualjobTitle() . ' chez ' . $data["BusinessUser"]->getBusinessUserLinkedin()->getCompagnyName() . ', Mentor ULYSS.CO';
        $this->datas['SEO_desc_page']  = $data["BusinessUser"]->getFullName() . ' est disponible pour échanger sur l\'entreprise que vous convoitez. Découvrez dès aujourd\'hui son profil et convenez d\'un rendez-vous téléphonique avec ' . $data["BusinessUser"]->getPrenom() . '.';

        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/talent/header', $data);
        $date = date("Y-m-d");

        // Suggest Mentors & Entreprise client write by Raphael Beneluz :
        // - Mentors :
        $this->load->model('andafter/ModelSearch', 'ModelSearch');
        $data['mentors'] = $this->ModelSearch->getTalentsByUserLoggedDepartement($BusinessUser);
        // - Entreprise cliente :
        $idEnt                     = $BusinessUser->getProfileTalent()->getLastExperience()->entreprise_id;
        $data['entreprise_client'] = $this->ModelEntreprise->verifIfEntIsClient($idEnt);
        $data['ent']               = $this->ModelEntreprise->GetEntrepriseById($idEnt);
        // End

        $data['disponible']                = $this->get_disponibilite($info_talent->id, date('Y-m-d', strtotime("+1 day")));
        $data['get_disponibilite_in_week'] = $this->get_disponibilite_in_week($info_talent->id);
        $this->load->model('demande_model', 'demande');

        $data['holidays']          = $this->demande->getHolidaysIndate($info_talent->user_id, $date);
        $data["all_holidays"]      = $this->get_holidays_user($info_talent->user_id);
        $data['secteur_activites'] = $this->user->getSecteurActivites();
        $data['fonctions']         = $this->user->getAllfonctions();
        $data['departements']      = $this->user->getCategorieParent();

        $this->load->view('profil/talent/apropos', $data);
        $this->load->view('template/footer', $this->datas);
    }

    function get_disponibilite($id_talent, $date = null)
    {
        if (!$date) {
            $date = date("Y-m-d");
        }
        $list_week      = ["jour", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche"];
        $disponible     = $this->talent->getDisponibiliteTalent($id_talent);
        $Talent         = $this->ModelTalent->getById($id_talent);
        $BusinessTalent = new BusinessTalent($Talent);
        $DatesOccupees  = $BusinessTalent->getRDVFromTwoDate($date, $date);
        $horaires       = [];

        if (is_array($DatesOccupees) && count($DatesOccupees) > 0) {
            foreach ($DatesOccupees as $DateOccupee) {
                $horaire   = str_replace(['h', '-'], ['', '_'], $DateOccupee->horaire);
                $horaires_ = explode('/', $horaire);

                foreach ($horaires_ as $horaire_) {
                    $horaires[] = $horaire_;
                }
            }
        }

        if (empty($disponible)) {
            $data_horaire['talent_id'] = $id_talent;
            $this->talent->AddTalentHoraire($data_horaire);
            $disponible = $this->talent->getDisponibiliteTalent($id_talent);
        }
        $day_number        = date('N', strtotime($date));
        $nombre_heure      = 1;
        $name_day          = $list_week[$day_number];
        $name_1            = $name_day . "_8_10";
        $data_date['8_10'] = $disponible->$name_1;
        if ($disponible->$name_1 == 1) {
            $nombre_heure = $nombre_heure + 2;
        }
        $name_2             = $name_day . "_10_12";
        $data_date['10_12'] = $disponible->$name_2;
        if ($disponible->$name_2 == 1) {
            $nombre_heure = $nombre_heure + 2;
        }
        $name_3             = $name_day . "_12_14";
        $data_date['12_14'] = $disponible->$name_3;
        if ($disponible->$name_3 == 1) {
            $nombre_heure = $nombre_heure + 2;
        }
        $name_4             = $name_day . "_14_16";
        $data_date['14_16'] = $disponible->$name_4;
        if ($disponible->$name_4 == 1) {
            $nombre_heure = $nombre_heure + 2;
        }
        $name_5             = $name_day . "_16_18";
        $data_date['16_18'] = $disponible->$name_5;
        if ($disponible->$name_5 == 1) {
            $nombre_heure = $nombre_heure + 2;
        }

        $name_6             = $name_day . "_18_20";
        $data_date['18_20'] = $disponible->$name_6;
        if ($disponible->$name_6 == 1) {
            $nombre_heure = $nombre_heure + 2;
        }

        $name_7             = $name_day . "_20_22";
        $data_date['20_22'] = $disponible->$name_7;
        if ($disponible->$name_7 == 1) {
            $nombre_heure = $nombre_heure + 2;
        }

        /* On supprime les horaires déja prises par d'autres RDV */
        foreach ($horaires as $key => $horaire) {
            if (isset($data_date[$horaire])) {
                $data_date[$horaire] = null;
            }
        }

        $data_date['nombre_heure'] = $nombre_heure;

        return $data_date;
    }

    function get_holidays_user($id_user)
    {
        $holidays = [];
        $this->load->model('demande_model', 'demande');
        $list = $this->demande->getAllHolidaysIndate($id_user);
        foreach ($list as $key => $item) {
            $holidays[] = $item->date_debut;
        }

        return $holidays;
    }

    function get_disponibilite_in_week($id_talent)
    {

        $list_week  = ["jour", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche"];
        $disponible = $this->talent->getDisponibiliteTalent($id_talent);
        if (empty($disponible)) {
            $data_horaire['talent_id'] = $id_talent;
            $this->talent->AddTalentHoraire($data_horaire);
            $disponible = $this->talent->getDisponibiliteTalent($id_talent);
        }

        $week_disp = [];
        if ($disponible->lundi_8_10 != 1 && $disponible->lundi_10_12 != 1 && $disponible->lundi_12_14 != 1 && $disponible->lundi_14_16 != 1 && $disponible->lundi_16_18 != 1 && $disponible->lundi_18_20 != 1 && $disponible->lundi_20_22 != 1) {
            $week_disp[] = 1;
        }
        if ($disponible->mardi_8_10 != 1 && $disponible->mardi_10_12 != 1 && $disponible->mardi_12_14 != 1 && $disponible->mardi_14_16 != 1 && $disponible->mardi_16_18 != 1 && $disponible->mardi_18_20 != 1 && $disponible->mardi_20_22 != 1) {
            $week_disp[] = 2;
        }
        if ($disponible->mercredi_8_10 != 1 && $disponible->mercredi_10_12 != 1 && $disponible->mercredi_12_14 != 1 && $disponible->mercredi_14_16 != 1 && $disponible->mercredi_16_18 != 1 && $disponible->mercredi_18_20 != 1 && $disponible->mercredi_20_22 != 1) {
            $week_disp[] = 3;
        }
        if ($disponible->jeudi_8_10 != 1 && $disponible->jeudi_10_12 != 1 && $disponible->jeudi_12_14 != 1 && $disponible->jeudi_14_16 != 1 && $disponible->jeudi_16_18 != 1 && $disponible->jeudi_18_20 != 1 && $disponible->jeudi_20_22 != 1) {
            $week_disp[] = 4;
        }
        if ($disponible->vendredi_8_10 != 1 && $disponible->vendredi_10_12 != 1 && $disponible->vendredi_12_14 != 1 && $disponible->vendredi_14_16 != 1 && $disponible->vendredi_16_18 != 1 && $disponible->vendredi_18_20 != 1 && $disponible->vendredi_20_22 != 1) {
            $week_disp[] = 5;
        }
        if ($disponible->samedi_8_10 != 1 && $disponible->samedi_10_12 != 1 && $disponible->samedi_12_14 != 1 && $disponible->samedi_14_16 != 1 && $disponible->samedi_16_18 != 1 && $disponible->samedi_18_20 != 1 && $disponible->samedi_20_22 != 1) {
            $week_disp[] = 6;
        }
        if ($disponible->dimanche_8_10 != 1 && $disponible->dimanche_10_12 != 1 && $disponible->dimanche_12_14 != 1 && $disponible->dimanche_14_16 != 1 && $disponible->dimanche_16_18 != 1 && $disponible->dimanche_18_20 != 1 && $disponible->dimanche_20_22 != 1) {
            $week_disp[] = 0;
        }

        return $week_disp;
    }

    public function get_html_dispo()
    {
        $date1 = explode("/", $this->input->post("date"));
        $date  = $date1[2] . "-" . $date1[1] . "-" . $date1[0];
        $this->load->model('demande_model', 'demande');
        $info_talent        = $this->talent->GetTalent($this->input->post("talent_id"));
        $data['disponible'] = $this->get_disponibilite($this->input->post("talent_id"), $date);
        $data['holidays']   = $this->demande->getHolidaysIndate($info_talent->user_id, $date);
        $html_nbr_heure     = "";
        if (empty($data['holidays'])) {
            for ($i = 1; $i < $data['disponible']['nombre_heure']; $i++) {
                $html_nbr_heure .= '<option value="' . $i . '">' . $i . '</option>';
            }
        }
        $data['html_heure'] = $html_nbr_heure;
        $data['html']       = $this->load->view('profil/talent/disponible', $data, true);
        echo json_encode($data);

    }

    public function autres_talents($alias = null, $talent = null)
    {
        if (!$alias) {
            show_404();
        }
        $info = $this->user->GetUsersByAlias($alias);
        if (empty($info)) {
            show_404();
        }
        $data["info"]  = $info;
        $data["alias"] = $alias;
        if (!$talent) {
            show_404();
        }
        $info_talent = $this->talent->GetTalentsByAlias($talent);
        if (empty($info_talent)) {
            show_404();
        }
        $data['droir_editer'] = false;
        if ($this->session->userdata('logged_in_site_web')) {
            if ($this->id_user_decode == $info_talent->user_id) {
                $data['droir_editer'] = true;
            }
        }


        $data['nombre_cmt']    = $this->talent->GetcountCompTalent($info_talent->id);
        $data['sum_note']      = $this->talent->GetSumNoteCmtTalent($info_talent->id);
        $data['nombre_etoile'] = 0;
        if (!empty($data['sum_note']) && $data['nombre_cmt'] > 0) {
            $data['nombre_etoile'] = round($data['sum_note']->note / $data['nombre_cmt']);
        }

        $data["info_talent"]        = $info_talent;
        $data["alias_talent"]       = $talent;
        $data['commentaires_recus'] = $this->talent->GetCommentairesByTalent($info_talent->id);
        $data["nbr_talents"]        = $this->user->getCountMesTalents($info->id);
        $data["talents"]            = $this->user->GetMesTalentsUser($info->id);
        $this->load->view('profil/talent/header', $data);
        $date                              = date("Y-m-d");
        $data['disponible']                = $this->get_disponibilite($info_talent->id);
        $data['get_disponibilite_in_week'] = $this->get_disponibilite_in_week($info_talent->id);
        $this->load->model('demande_model', 'demande');
        $data['holidays']     = $this->demande->getHolidaysIndate($info_talent->user_id, $date);
        $data["all_holidays"] = $this->get_holidays_user($info_talent->user_id);
        $this->load->view('profil/talent/services', $data);
        $this->load->view('profil/footer1', $data);
    }

    public function send_msg()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            show_404();
        }
        $this->load->model('messagerie_model', 'msg');
        $data_info['titre']            = $this->security->xss_clean($this->input->post("titre"));
        $data_info['talent_id']        = $this->input->post("talent_id");
        $data_info['user_id_acheteur'] = $this->id_user_decode;

        $this->load->model('demande_model', 'demande');
        $id_demande = $this->demande->Add($data_info);


        $result      = $this->msg->existenceConversation($this->input->post("talent_id"), $this->id_user_decode, $id_demande);
        $info_talent = $this->talent->GetTalent($this->input->post("talent_id"));

        if (!empty($info_talent)) {
            $data['user_id_send']     = $this->id_user_decode;
            $data['user_id_recep']    = $info_talent->user_id;
            $UserRecept               = $this->ModelUser->getById($info_talent->user_id);
            $data["text"]             = $this->removeEmailAndPhoneFromString($this->input->post('message_detail'));
            $data["id_conversations"] = $result;
            $this->msg->AddConversation($data);

            SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_MAIL_NOUVEAU_MESSAGE_RECU,
                $UserRecept->email,
                [
                    'HASH'            => $UserRecept->hash,
                    'FIRSTNAME'       => $UserRecept->prenom,
                    'FULLNAME_MENTOR' => $this->getBusinessUser()->getFullName(),
                    'URL_BUTTON'      => site_url('messages/conversation/' . $data["id_conversations"]),
                ]
            );
        }
        $html['msg'] = "<p class='succed_p'>succed</p>";
        echo json_encode($html);
    }

    public function add_reservation()
    {
        if ($this->session->userdata('logged_in_site_web') && $this->input->post("talent_id")) {
            $this->load->library('encrypt');

            /* Récupération des variables POST */
            $talent_id  = $this->input->post('talent_id');
            $date_offre = $this->input->post('date_offre');
            $crenaux    = $this->input->post('crenaux');

            $date       = explode('/', $date_offre);
            $date_offre = $date[2] . '-' . $date[1] . '-' . $date[0];
            $crenau     = is_array($crenaux) ? reset($crenaux) : $crenaux;
            /* Add Demande to BDD */
            $demande                     = [];
            $demande['talent_id']        = $talent_id;
            $demande['user_id_acheteur'] = $this->getBusinessUser()->getId();
            $demande['date_livraison']   = $date_offre;
            $demande['status']           = BusinessTalentDemande::STATUS_ENATTENTE;
            $demande['horaire']          = $crenau;
            $demande['reservation_j']    = json_encode(["creneaux" => $crenau, "date" => $date_offre]);
            $demande['duree']            = 30;
            $ModelTalent                 = $this->ModelTalent->saveDemande($demande);

            /* Create Conversation to BDD */
            $conversation                       = [];
            $conversation['talent_id']          = $talent_id;
            $conversation['user_id']            = $this->getBusinessUser()->getId();
            $conversation['demandes_talent_id'] = $ModelTalent->id;
            $ModelConversation                  = $this->ModelConversation->save($conversation);

            /* Set Business */
            $BusinessConversation = new BusinessConversation($ModelConversation);

            /* Send message to Internal Messagerie */
            $text
                = "Bonjour,<br><br>
                                                Voici un récapitulatif de la demande de " . $this->getBusinessUser()->getFullName() . " :<br>
                                                Date: " . $BusinessConversation->getBusinessDemandeRDV()->getDateRdvInText() . "<br>
                                                Créneau: " . $crenau . "<br>
                                                Durée : 30 minutes <br><br>
                                                " . $BusinessConversation->getBusinessUserInterlocutor()->getFullName() . " vous avez 24h pour confirmer le RDV.<br>
                                                Pensez à convenir ensemble d'une heure exacte de RDV ainsi que les modalités de RDV<br>(RDV téléphonique, RDV physique, Skype...)<br><br>
                                                Cordialement,<br>
                                                Camille de l’équipe ULYSS.CO<br>
                                                NB : Si vous rencontrez des problèmes, n’hésitez pas à me contacter sur <a href='mailto:camille@ulyss.co'>camille@ulyss.co</a>";

            $BusinessConversation->sendNewMessage($text, true);

            /* Send Emails */
            if ($BusinessConversation->getBusinessUserInterlocutor()->acceptMailsReceptionNouvelDemandeDUnCandidat()) {
                /* SendInBlue for Mentor */
                SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_MAIL_MENTOR_DEMANDE_RDV,
                    $BusinessConversation->getBusinessUserInterlocutor()->getEmail(),
                    [
                        'FULLNAME_USER' => $this->getBusinessUser()->getFullName(),
                        'FIRSTNAME'     => $BusinessConversation->getBusinessUserInterlocutor()->getPrenom(),
                        'DATE'          => $BusinessConversation->getBusinessDemandeRDV()->getDateHourRdvInText(),
                        'URL_BOUTON'    => base_url('messages/conversation/' . $BusinessConversation->getId() . '?hash=' . $BusinessConversation->getBusinessUserInterlocutor()->getHash()),
                    ]
                );
            }

            if ($BusinessConversation->getBusinessUserInterlocutor()->acceptSMSReceptionNouvelDemandeDUnCandidat()) {
                /* Envoi SMS */
                SendInBlue::sendSms($BusinessConversation->getBusinessUserInterlocutor()->getTelephoneWithoutSign(),
                    'Bonjour, un candidat a besoin de votre aide sur ulyss.co ! RDV sur ulyss.co pour en savoir +');
            }

            /* SendInBlue for Candidat */
            SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_CANDIDAT_ASK_RDV_PENDING,
                $this->getBusinessUser()->getEmail(),
                [
                    'FULLNAME_MENTOR' => $BusinessConversation->getBusinessUserInterlocutor()->getFullName(),
                    'FULLNAME_USER'   => $this->getBusinessUser()->getFullName(),
                    'FIRSTNAME'       => $this->getBusinessUser()->getPrenom(),
                    'DATE'            => $BusinessConversation->getBusinessDemandeRDV()->getDateHourRdvInText()
                ]
            );

            /* End */
            $html['msg'] = "<p class='succed_p'>succed</p>" . $BusinessConversation->getBusinessUserInterlocutor()->getNotifsDemandePourTalent();
            echo json_encode($html);
        }
    }

    /*editer description*/
    public function editer_description()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $data['description'] = $this->input->post("description");
            $this->talent->EditTalentByiAndIduser($this->input->post("talent_id"), $this->id_user_decode, $data);
            echo json_encode($data);
        }
    }

    public function editer_rendez_vous()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $data['format_rendez_vous'] = $this->input->post("description");
            $this->talent->EditTalentByiAndIduser($this->input->post("talent_id"), $this->id_user_decode, $data);
            echo json_encode($data);
        }
    }

    public function editer_centre_interet()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $data['centre_interet'] = $this->input->post("description");
            $this->talent->EditTalentByiAndIduser($this->input->post("talent_id"), $this->id_user_decode, $data);
            echo json_encode($data);
        }
    }

    public function ajouter_langue()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $data['langue_id'] = $this->input->post("lang");
            $data['talent_id'] = $this->input->post("talent_id");
            $this->talent->AddTalentLangue($data);
            $reponse['message'] = "la langue est ajouter";
            $html               = "";
            $html1              = "";
            $langues            = $this->talent->GetLangues($this->input->post("talent_id"));
            $virgule            = ",";
            foreach ($langues as $lang) {
                $html .= "<span>" . $lang->nom . "<a href='#' onclick='supprimerLang(" . $lang->id . "," . $lang->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></span>";
                if ($lang === end($langues)) {
                    $virgule = "";
                }
                $html1 .= "<span>" . $lang->nom . "</span>" . $virgule;
            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);
        }
    }

    public function ajouter_tag()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $data['tag_id']    = $this->input->post("tag");
            $data['talent_id'] = $this->input->post("talent_id");
            $this->talent->AddTalentTag($data);
            $reponse['message'] = "la langue est ajouter";
            $html               = "";
            $html1              = "";
            $tags               = $this->talent->GetTags($this->input->post("talent_id"));
            $virgule            = ",";
            foreach ($tags as $tag) {
                $html .= "<span>" . $tag->nom . "<a href='#' onclick='supprimerTag(" . $tag->id . "," . $tag->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></span>";
                if ($tag === end($tags)) {
                    $virgule = "";
                }
                $html1 .= "<span>" . $tag->nom . "</span>" . $virgule;
            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);
        }
    }

    public function supprimer_langue()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $id = $this->input->post("id");
            $this->talent->DeleteLangueT($id);
            $langues = $this->talent->GetLangues($this->input->post("talent_id"));
            $html    = "";
            $html1   = "";
            $virgule = ",";
            foreach ($langues as $lang) {
                $html .= "<span>" . $lang->nom . "<a href='#' onclick='supprimerLang(" . $lang->id . "," . $lang->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></span>";
                if ($lang === end($langues)) {
                    $virgule = "";
                }
                $html1 .= "<span>" . $lang->nom . "</span>" . $virgule;
            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);
        }
    }

    public function supprimer_tag()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $id = $this->input->post("id");
            $this->talent->DeleteTagT($id);
            $tags    = $this->talent->GetTags($this->input->post("talent_id"));
            $html    = "";
            $html1   = "";
            $virgule = ",";
            foreach ($tags as $tag) {
                $html .= "<span>" . $tag->nom . "<a href='#' onclick='supprimerTag(" . $tag->id . "," . $tag->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></span>";
                if ($tag === end($tags)) {
                    $virgule = "";
                }
                $html1 .= "<span>" . $tag->nom . "</span>" . $virgule;
            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);
        }
    }

    public function ajouter_mode()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $data['date_debut']  = $this->input->post("date_debut");
            $data['date_fin']    = $this->input->post("date_fin");
            $data['lieu']        = $this->input->post("lieu");
            $data['university']  = $this->input->post("university");
            $data['formation']   = $this->input->post("formation");
            $data['niveau']      = $this->input->post("niveau");
            $data['description'] = $this->input->post("description");
            $data['talent_id']   = $this->input->post("talent_id");
            $this->talent->AjouterModeTouser($data);
            $reponse['message'] = "la formation est ajouter";
            $html               = "";
            $html1              = "";
            $mode_operatoire    = $this->talent->GetFormations($this->input->post("talent_id"));
            foreach ($mode_operatoire as $mode) {
                $html
                    .= "<div class='operatoire_item'>
                        <p class='titre_operatoire'>" . $mode->formation . "<a href='#' onclick='supprimerMode(" . $mode->id . "," . $mode->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></p>  
                        <div class='text_operatoire'>
                           <p>" . $mode->description . "</p>
                        </div>                   
                     </div>";
                $html1
                    .= "                <div class='row list_exp list_formation'>
                  <div class='col-md-12'>
                     <h4>" . $mode->university . "</h4>
                     <p>" . $mode->formation . "</p>
                     <p>" . $mode->date_debut . " – " . $mode->date_fin . "</p>
                     <div><a href='#' class='d_plus_formation'><span ><i>+</i> Détail</span></a></div>
                  </div>
               </div>";
            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);
        }
    }

    public function supprimer_mode()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $id = $this->input->post("id");
            $this->talent->DeleteMode($id);
            $reponse['message'] = "la mode est supprimer";
            $html               = "";
            $html1              = "";
            $mode_operatoire    = $this->talent->GetFormations($this->input->post("talent_id"));
            foreach ($mode_operatoire as $mode) {
                $html
                    .= "<div class='operatoire_item'>
                        <p class='titre_operatoire'>" . $mode->formation . "<a href='#' onclick='supprimerMode(" . $mode->id . "," . $mode->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></p>  
                        <div class='text_operatoire'>
                           <p>" . $mode->description . "</p>
                        </div>                   
                     </div>";
                $html1
                    .= "                <div class='row list_exp list_formation'>
                  <div class='col-md-12'>
                     <h4>" . $mode->university . "</h4>
                     <p>" . $mode->formation . "</p>
                     <p>" . $mode->date_debut . " – " . $mode->date_fin . "</p>
                     <div><a href='#' class='d_plus_formation'><span ><i>+</i> Détail</span></a></div>
                  </div>
               </div>";
            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);
        }
    }

    public function ajouter_reference()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $data['fonction']  = $this->input->post("fonction");
            $data['lieu']      = $this->input->post("lieu");
            $data['talent_id'] = $this->input->post("talent_id");
            $this->talent->AjouterReferenceToTalent($data);
            $reponse['message'] = "la talent est ajouter";
            $html               = "";
            $html1              = "";
            $references         = $this->talent->GetReferences($this->input->post("talent_id"));

            foreach ($references as $ref) {
                $html  .= "<p><b>" . $ref->fonction . "</b>-<span>" . $ref->lieu . "</span><a href='#' onclick='supprimerReference(" . $ref->id . "," . $ref->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></p>";
                $html1 .= "<p><b>" . $ref->fonction . "</b>-<span>" . $ref->lieu . "</span></p>";
            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);
        }
    }

    public function supprimer_reference()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $id = $this->input->post("id");
            $this->talent->DeleteReferences($id);
            $reponse['message'] = "la talent est ajouter";
            $html               = "";
            $html1              = "";
            $references         = $this->talent->GetReferences($this->input->post("talent_id"));

            foreach ($references as $ref) {
                $html  .= "<p><b>" . $ref->fonction . "</b>-<span>" . $ref->lieu . "</span><a href='#' onclick='supprimerReference(" . $ref->id . "," . $ref->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></p>";
                $html1 .= "<p><b>" . $ref->fonction . "</b>-<span>" . $ref->lieu . "</span></p>";
            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);
        }
    }

    public function ajouter_experience()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $data['titre_mission'] = $this->input->post("titre");
            $data['lieu']          = $this->input->post("lieu");
            if ($this->input->post("entreprise") != 0) {
                $data['entreprise_id'] = $this->input->post("entreprise");
            } else {
                $data_entreprise['nom'] = $this->input->post("name_entreprise");
                $id_entreprise          = $this->talent->getIdEntrepriseByName($item['entreprise'], $data_entreprise);
                $data['entreprise_id']  = $id_entreprise;
            }
            $data['talent_id']      = $this->input->post("talent_id");
            $data['description']    = $this->input->post("description");
            $data['secteur_id']     = $this->input->post("secteur");
            $data['fonction_id']    = $this->input->post("fonction_id");
            $data['departement_id'] = $this->input->post("departement_id");

            $element_a = explode("/", $this->input->post('date_debut'));
            if (count($element_a) > 1) {
                $data['date_debut'] = $element_a[2] . "-" . $element_a[1] . "-" . $element_a[0];
            }
            $element_b = explode("/", $this->input->post('date_fin'));
            if (count($element_b) > 1) {
                $data['date_fin'] = $element_b[2] . "-" . $element_b[1] . "-" . $element_b[0];
            }
            $this->talent->AjouterExperienceToTalent($data);
            $reponse['message'] = "la talent est ajouter";
            $html               = "";
            $html1              = "";
            $experiences        = $this->talent->GetExperiences($this->input->post("talent_id"));

            foreach ($experiences as $exp) {


                $html
                    .= "<div class='mission_item'>
                        <p class='titre_mission'>" . $this->user_info->getSCatName($exp->fonction_id) . "- <span>" . $this->user_info->getNameEntreprise($exp->entreprise_id) . "</span><a href='#' onclick='supprimerExperience(" . $exp->id . "," . $exp->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></p>
                        <p class='date_mission'><i class='ion-calendar'></i>" . strftime("%B %Y", strtotime($exp->date_debut)) . "-" . strftime("%B %Y",
                        strtotime($exp->date_fin)) . "(" . $this->user_info->getDiffDate($exp->date_debut, $exp->date_fin) . ") " . $exp->lieu . "</p>
                     </div>";


                $html1
                    .= '<div class="list_exp list_formation row">
                  <div class="col-md-12">
                     <div class="row">
                        <div class="col-xs-8">
                           <h4>' . $this->user_info->getSCatName($exp->fonction_id) . '</h4>
                           <p class="cl_grey_p">' . $this->user_info->getNameEntreprise($exp->entreprise_id) . '</p>
                           <p>' . strftime("%B %Y", strtotime($exp->date_debut)) . ' - ' . strftime("%B %Y", strtotime($exp->date_fin)) . ' (' . $this->user_info->getDiffDate($exp->date_debut,
                        $exp->date_fin) . ')    ' . $exp->lieu . '</p>
                        </div>
                        <div class="col-xs-4 text-right">
                           <img src="' . $this->user_info->getLogoEntreprise($exp->entreprise_id) . '" alt="" class="mgt_15">
                        </div>
                        
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="btn_show_desc"><span class="d_plus "><i>+</i> Détail</span>
                              <div class="disc_exper">
                                 <p>
                                 ' . $exp->description . '
                                 </p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>';


            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);
        }
    }

    public function supprimer_experience()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $id = $this->input->post("id");
            $this->talent->DeleteExperience($id);
            $reponse['message'] = "la talent est ajouter";
            $html               = "";
            $html1              = "";
            $experiences        = $this->talent->GetExperiences($this->input->post("talent_id"));

            foreach ($experiences as $exp) {
                $html
                    .= "<div class='mission_item'>
                        <p class='titre_mission'>" . $this->user_info->getSCatName($exp->fonction_id) . "- <span>" . $this->user_info->getNameEntreprise($exp->entreprise_id) . "</span><a href='#' onclick='supprimerExperience(" . $exp->id . "," . $exp->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></p>
                        <p class='date_mission'><i class='ion-calendar'></i>" . strftime("%B %Y", strtotime($exp->date_debut)) . "-" . strftime("%B %Y",
                        strtotime($exp->date_fin)) . "(" . $this->user_info->getDiffDate($exp->date_debut, $exp->date_fin) . ") " . $exp->lieu . "</p>
                     </div>";


                $html1
                    .= '<div class="list_exp list_formation row">
                  <div class="col-md-12">
                     <div class="row">
                        <div class="col-xs-8">
                           <h4>' . $this->user_info->getSCatName($exp->fonction_id) . '</h4>
                           <p class="cl_grey_p">' . $this->user_info->getNameEntreprise($exp->entreprise_id) . '</p>
                           <p>' . strftime("%B %Y", strtotime($exp->date_debut)) . ' - ' . strftime("%B %Y", strtotime($exp->date_fin)) . ' (' . $this->user_info->getDiffDate($exp->date_debut,
                        $exp->date_fin) . ')    ' . $exp->lieu . '</p>
                        </div>
                        <div class="col-xs-4 text-right">
                           <img src="' . $this->user_info->getLogoEntreprise($exp->entreprise_id) . '" alt="" class="mgt_15">
                        </div>
                        
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="btn_show_desc"><span class="d_plus "><i>+</i> Détail</span>
                              <div class="disc_exper">
                                 <p>
                                 ' . $exp->description . '
                                 </p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>';
            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);
        }
    }

    private function _unique_field_name($field_name)
    {
        return $field_name . '_' . random_string('alnum', 20);  //This s is because is better for a string to begin with a letter and not a number
    }

    public function ajouter_portfolio()
    {

        if ($this->session->userdata('logged_in_site_web')) {
            $data['titre']     = $this->input->post("titre");
            $data['talent_id'] = $this->input->post("talent_id");

            if (isset($_FILES["file"]["name"]) && $_FILES["file"]["error"] == 0) {
                $allowedExts            = ["gif", "jpeg", "jpg", "png"];
                $temp                   = explode(".", $_FILES["file"]["name"]);
                $extension              = end($temp);
                $_FILES["file"]["name"] = $this->_unique_field_name($_FILES["file"]["name"]);
                $_FILES["file"]["name"] .= "." . $extension;
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } else {
                    //CB : Utilisation du module s3File
                    if ($this->s3file->file_exists($this->config->item('upload_portfolio') . $_FILES["file"]["name"])) {
                        $this->s3file->unlink($this->config->item('upload_portfolio') . $_FILES["file"]["name"]);
                    }
                    $this->s3file->move_uploaded_file($_FILES["file"]["tmp_name"], $this->config->item('upload_portfolio') . $_FILES["file"]["name"]);
                    $data['image'] = $_FILES["file"]["name"];
                }
            }

            $this->talent->AjouterPortfolioTotalent($data);
            $reponse['message'] = "la portfolio est ajouter";
            $html               = "";
            $html1              = "";
            $portfolio          = $this->talent->GetPortfolio($this->input->post("talent_id"));
            foreach ($portfolio as $port) {
                $html
                    .= "<div class='col-md-4  img_profotlio'>
                          <span>" . $port->titre . "<a href='#' onclick='supprimerPortfolio(" . $port->id . "," . $port->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></span>
                         <img src='" . base_url() . "image.php/" . $port->image . "?height=319&width=154&cropratio=2:1&image=" . base_url($this->config->item('upload_portfolio') . $port->image) . "' alt=''>   
                        </div>";
            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);
        }
    }


    public function supprimer_portfolio()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $id = $this->input->post("id");
            $this->talent->DeletePortfolio($id);
            $reponse['message'] = "la portfolio est ajouter";
            $html               = "";
            $html1              = "";
            $portfolio          = $this->talent->GetPortfolio($this->input->post("talent_id"));
            foreach ($portfolio as $port) {
                $html
                    .= "<div class='col-md-4  img_profotlio'>
                          <span>" . $port->titre . "<a href='#' onclick='supprimerPortfolio(" . $port->id . "," . $port->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></span>
                         <img src='" . base_url() . "image.php/" . $port->image . "?height=319&width=154&cropratio=2:1&image=" . base_url($this->config->item('upload_portfolio') . $port->image) . "' alt=''>   
                        </div>";
            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);
        }

    }

    public function like_favoris()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            $reponse['class'] = "server not work";
            echo json_encode($reponse);
        }
        if (!$this->input->post("talent_id")) {
            $reponse['class'] = "server not work";
            echo json_encode($reponse);
        }


        if ($this->user_info->checkFavoris($this->input->post("talent_id"))) {
            $this->user->DislikeFavoris($this->input->post("talent_id"), $this->id_user_decode);
            $reponse['class'] = "dislike";
            echo json_encode($reponse);
        } else {
            $data['talent_id'] = $this->input->post("talent_id");
            $data['user_id']   = $this->id_user_decode;
            $this->user->AddFavoris($data);
            $reponse['class'] = "active";
            echo json_encode($reponse);
        }

    }

    public function editer_talent()
    {

        if ($this->session->userdata('logged_in_site_web')) {
            $data_info['titre'] = $this->input->post("titre");
            // $data_info['prix']=$this->input->post("prix");
            $data_info['ville'] = $this->input->post("ville");
            /*            $data_info['reduction']=$this->input->post("reduction");
            $data_info['reduction_heure']=$this->input->post("reduction_heure");
            $data_info['reduction_personne']=$this->input->post("reduction_personne");*/
            //  $data_info['horaire']=$this->input->post("horaire");
            //$data_info['horaire_de']=$this->input->post("horaire_de");
            // $data_info['horaire_a']=$this->input->post("horaire_a");

            //$data_info['description_forfait']=$this->input->post("description_forfait");
            // $data_info['prix_forfait']=$this->input->post("prix_forfait");
            // $data_info['prix_journee']=$this->input->post("prix_journee");
            if (isset($_FILES["file"]["name"]) && $_FILES["file"]["error"] == 0) {
                $allowedExts            = ["gif", "jpeg", "jpg", "png"];
                $temp                   = explode(".", $_FILES["file"]["name"]);
                $extension              = end($temp);
                $_FILES["file"]["name"] = $this->_unique_field_name($_FILES["file"]["name"]);
                $_FILES["file"]["name"] .= "." . $extension;
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } else {
                    //CB : Utilisaiton du module s3File
                    if ($this->s3file->file_exists($this->config->item('upload_talents') . $_FILES["file"]["name"])) {
                        $this->s3file->unlink($this->config->item('upload_talents') . $_FILES["file"]["name"]);
                    }
                    $this->s3file->move_uploaded_file($_FILES["file"]["tmp_name"], $this->config->item('upload_talents') . $_FILES["file"]["name"]);
                    $data_info['cover'] = $_FILES["file"]["name"];
                }
            }
            $this->talent->EditTalentByiAndIduser($this->input->post("talent_id"), $this->id_user_decode, $data_info);

            $reponse['html1'] = "votre modification est fait avec success";
            echo json_encode($reponse);
        }
    }

    public function editer_talent_prix()
    {

        if ($this->session->userdata('logged_in_site_web')) {
            $data_info['prix']               = $this->input->post("prix");
            $data_info['reduction']          = $this->input->post("reduction");
            $data_info['reduction_heure']    = $this->input->post("reduction_heure");
            $data_info['reduction_personne'] = $this->input->post("reduction_personne");
            $data_info['prix_journee']       = $this->input->post("prix_journee");

            $this->talent->EditTalentByiAndIduser($this->input->post("talent_id"), $this->id_user_decode, $data_info);

            $reponse['html1'] = "votre modification est fait avec success";
            echo json_encode($reponse);
        }
    }

    public function supprimer_categorie()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $id = $this->input->post("id");
            $this->talent->DeleteCategorie($id);
            $categories = $this->talent->GetCategories($this->input->post("talent_id"));
            $html       = "";
            $html1      = "";
            $virgule    = ",";
            foreach ($categories as $cat) {
                if ($cat === end($categories)) {
                    $virgule = "";
                }
                $html  .= "<span>" . $cat->nom . "<a href='#' onclick='supprimerCategorie(" . $cat->id . ")' class='btn_edit_inf'><span>Supprimer</span></a></span>";
                $html1 .= "<span>" . $cat->nom . "</span>" . $virgule;
            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);
        }
    }

    public function ajouter_categorie()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $data['talent_id']    = $this->input->post("talent_id");
            $data['categorie_id'] = $this->input->post("categorie_id");
            $this->talent->AjouterCategorie($data);
            $reponse['message'] = "la langue est ajouter";
            $categories         = $this->talent->GetCategories($this->input->post("talent_id"));
            $html               = "";
            $html1              = "";
            $virgule            = ",";
            foreach ($categories as $cat) {
                if ($cat === end($categories)) {
                    $virgule = "";
                }

                $html  .= "<span>" . $cat->nom . "<a href='#' onclick='supprimerCategorie(" . $cat->id . ")' class='btn_edit_inf'><span>Supprimer</span></a></span>";
                $html1 .= "<span>" . $cat->nom . "</span>" . $virgule;
            }
            $reponse['html']  = $html;
            $reponse['html1'] = $html1;
            echo json_encode($reponse);

        }
    }

    public function editer_horaire_talent()
    {
        if ($this->session->userdata('logged_in_site_web')) {
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
            $this->talent->EditerTalentHoraire($this->input->post("talent_id"), $data_horaire);
            $reponse['html']  = "";
            $reponse['html1'] = $data_horaire;
            echo json_encode($reponse);
        }
    }

    private function removeEmailAndPhoneFromString($string)
    {
        // remove email
        $string = preg_replace('/([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/', '', $string);

        // remove phone
        $string = preg_replace('/(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$/', '[********]', $string);

        return $string;
    }

}
