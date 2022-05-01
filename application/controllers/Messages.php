<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Messages extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('demande_model', 'demande');
        $this->load->model('messagerie_model', 'msg');
        $this->load->model('talent_model', 'talent');
        $this->load->library('encrypt');
        $this->load->library('user_info');
        $this->load->library('pagination');

        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
    }

    /**
     *
     */
    public function index()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect('/');
        }

        $data['BusinessConversations'] = $this->BusinessConversations->getAllByUser();
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile');
        $this->load->view('profil/compte/messagerie/conversations', $data);
        $this->load->view('template/footer', $this->datas);
    }


    /**
     * @param null $id
     */
    public function conversation($id = null)
    {
        if (!$id || !$this->session->userdata('logged_in_site_web')) {
            show_404();
        }

        $Conversation         = $this->ModelConversation->getById($id);
        $BusinessConversation = new BusinessConversation($Conversation);

        if ($BusinessConversation->getTalentId() != $this->getBusinessUser()->getBusinessTalent()->getId() && $BusinessConversation->getUserId() != $this->getBusinessUser()->getId()) {
            show_404();
        }

        /* On met en lu les messages consultés */
        if (is_array($BusinessConversation->getAllMessages()) && count($BusinessConversation->getAllMessages()) > 0) {
            foreach ($BusinessConversation->getAllMessages() as $BusinessMessage) {
                /* @var BusinessMessage $BusinessMessage */
                if ($BusinessMessage->getUserIdRecept() == $this->getBusinessUser()->getId()) {
                    $data['id']     = $BusinessMessage->getId();
                    $data['status'] = true;
                    $this->ModelMessage->save($data);
                }
            }
        }

        if ($this->input->post('envoyer')) {
            /* Insertion du message en BDD */
            $data                     = [];
            $data['user_id_send']     = $this->getBusinessUser()->getId();
            $data['user_id_recep']    = $BusinessConversation->getBusinessUserInterlocutor()->getId();
            $data["text"]             = $this->removeEmailAndPhoneFromString($this->input->post('message'));
            $data["id_conversations"] = $BusinessConversation->getId();
            $ModelMessage             = $this->ModelMessage->save($data);

            /* Update table conversation en BDD */
            $conv['id']              = $BusinessConversation->getId();
            $conv['last_message_id'] = $ModelMessage->id;
            $this->ModelConversation->save($conv);

            /*new notifications*/
            $this->load->library('mailing');
            $type_notification = $this->user_info->getTypeNotificationsNewMsg($data['user_id_recep']);
            if ($type_notification->notifications_msg_membre == "email" || $type_notification->notifications_msg_membre == "sms_email") {
                SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_MAIL_NOUVEAU_MESSAGE_RECU,
                    $type_notification->email,
                    [
                        'HASH'            => $type_notification->hash,
                        'FIRSTNAME'       => $type_notification->prenom,
                        'FULLNAME_MENTOR' => $this->user_info->getNameUser($this->getBusinessUser()->getId()),
                        'URL_BUTTON'      => site_url('messages/conversation/' . $data["id_conversations"]),
                    ]
                );
            }
            if ($type_notification->notifications_msg_membre == "sms" || $type_notification->notifications_msg_membre == "sms_email") {
                $data_notification['name']   = $type_notification->prenom . ' ' . $type_notification->nom;
                $data_notification['phone']  = $type_notification->tel;
                $data_notification['sender'] = $this->user_info->getNameUser($this->getBusinessUser()->getId());
                $this->mailing->notifications_nouveau_msg_sms($data_notification);
            }
            redirect('/messages/conversation/' . $BusinessConversation->getId());
        }
        $data['BusinessConversation'] = $BusinessConversation;
        $data['timeStampNow']         = new DateTime();
        $data['timeStampNow']         = $data['timeStampNow']->getTimestamp();
        $ModelQestionnaire            = $this->ModelQuestionnaire->getByConversationId($BusinessConversation->getId());
        $data['showedQuestionnaire']  = (($ModelQestionnaire instanceof StdClass) == false || $ModelQestionnaire->status == false);
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile');
        $this->load->view('profil/compte/messagerie/messages', $data);
        $this->load->view('template/footer', $this->datas);
    }

    /**
     * @param $id_conversation
     */
    public function questionaire($id_conversation)
    {
        if (!$id_conversation || !$this->session->userdata('logged_in_site_web')) {
            show_404();
        }

        $Conversation         = $this->ModelConversation->getById($id_conversation);
        $BusinessConversation = new BusinessConversation($Conversation);

        if ($BusinessConversation->getTalentId() != $this->getBusinessUser()->getBusinessTalent()->getId()
            && $BusinessConversation->getUserId() != $this->getBusinessUser()->getId()) {
            show_404();
        }

        $entreprise               = $this->input->post('entreprise');
        $innoventreprise          = $this->input->post('entInnovante');
        $alecoute                 = $this->input->post('ecouteCollabo');
        $bonnes_conditions        = $this->input->post('goodconditions');
        $ambiance_ent             = $this->input->post('ambianceEnt');
        $evolution_ent            = $this->input->post('evolutionEnt');
        $valorise_colla           = $this->input->post('valoriseCollabo');
        $remuneration             = $this->input->post('remuneration');
        $integration_entreprise   = $this->input->post('integration_entreprise');
        $recommandation           = (bool)$this->input->post('recommandation');
        $recommandation_ulyss     = (bool)$this->input->post('recommandation_ulyss');
        $recommandation_ulyss_non = $this->input->post('recommandation_ulyss_non');

        /* Insertion questionnaire en BDD */
        $ModelQestionnaire = $this->ModelQuestionnaire->getByConversationId($BusinessConversation->getId());
        if ($ModelQestionnaire instanceof StdClass) {
            $data['id'] = $ModelQestionnaire->id;
        }
        $data['entreprise_id']            = $entreprise;
        $data['innovante_entreprise']     = $innoventreprise;
        $data['a_lecoute']                = $alecoute;
        $data['bonnes_conditions']        = $bonnes_conditions;
        $data['ambiance']                 = $ambiance_ent;
        $data['evolution_interne']        = $evolution_ent;
        $data['valorise_collab']          = $valorise_colla;
        $data['remuneration']             = $remuneration;
        $data['integrer_entreprise']      = $integration_entreprise;
        $data['recommandation_ulyss']     = $recommandation_ulyss;
        $data['recommandation_ulyss_non'] = $recommandation_ulyss_non;

        $data['user_id']           = $this->getBusinessUser()->getId();
        $data['talent_id']         = $BusinessConversation->getBusinessUserInterlocutor()->getBusinessTalent()->getId();
        $data['talent_demande_id'] = $BusinessConversation->getBusinessDemandeRDV()->getId();
        $data['conversation_id']   = $BusinessConversation->getId();
        $data['date_creation']     = date('Y-m-d H:i:s');
        $data['status']            = true;
        $this->ModelQuestionnaire->save($data);

        /* Insertion recommandation si positive en BDD */
        if ($recommandation) {
            $TalentComment = $this->ModelTalent->getTalentTestimonialByDemandeTalentId($BusinessConversation->getBusinessDemandeRDV()->getId());
            if ($TalentComment instanceof StdClass) {
                $datas['id'] = $TalentComment->id;
            }
            $datas['talent_id']        = $BusinessConversation->getBusinessUserInterlocutor()->getBusinessTalent()->getId();
            $datas['comment_user_id']  = $this->getBusinessUser()->getId();
            $datas['note']             = $recommandation;
            $datas['demande_talen_id'] = $BusinessConversation->getBusinessDemandeRDV()->getId();
            $this->ModelTalent->saveComment($datas);
        }
        die();
    }

    /**
     * @param $id_conversation
     */
    public function questionairementor($id_conversation)
    {
        if (!$id_conversation || !$this->session->userdata('logged_in_site_web')) {
            show_404();
        }

        $Conversation         = $this->ModelConversation->getById($id_conversation);
        $BusinessConversation = new BusinessConversation($Conversation);

        if ($BusinessConversation->getTalentId() != $this->getBusinessUser()->getBusinessTalent()->getId()
            && $BusinessConversation->getUserId() != $this->getBusinessUser()->getId()) {
            show_404();
        }


        $issetrdv                 = $this->input->post('issetrdv');
        $experience_globale       = $this->input->post('experience_globale');
        $experience_globale_non   = $this->input->post('experience_globale_non');
        $recommandation_ulyss     = $this->input->post('recommandation_ulyss');
        $recommandation_ulyss_non = $this->input->post('recommandation_ulyss_non');

        /* Insertion questionnaire en BDD */
        $ModelQestionnaire = $this->ModelQuestionnaire->getQuestionnaireMentorByConversationId($BusinessConversation->getId());
        if ($ModelQestionnaire instanceof StdClass) {
            $data['id'] = $ModelQestionnaire->id;
        }

        $data['user_id']           = $this->getBusinessUser()->getId();
        $data['talent_id']         = $BusinessConversation->getBusinessUserInterlocutor()->getBusinessTalent()->getId();
        $data['talent_demande_id'] = $BusinessConversation->getBusinessDemandeRDV()->getId();
        $data['conversation_id']   = $BusinessConversation->getId();

        $data['issetrdv']                 = (bool)$issetrdv;
        $data['experience_globale']       = $experience_globale;
        $data['experience_globale_non']   = $experience_globale_non;
        $data['recommandation_ulyss']     = (bool)$recommandation_ulyss;
        $data['recommandation_ulyss_non'] = $recommandation_ulyss_non;

        $data['status'] = true;


        // verifier le resultat renvoier pour enregister le formulaire
        $this->ModelQuestionnaire->saveQuestMentor($data);
        die();
    }

    public function valider_demande()
    {

        if (!$this->input->post("id") || !$this->session->userdata('logged_in_site_web')) {
            die();
        }

        $ConversationID       = $this->input->post('conversations');
        $Conversation         = $this->ModelConversation->getById($ConversationID);
        $BusinessConversation = new BusinessConversation($Conversation);

        /* Securité control */
        if ($BusinessConversation->getTalentId() != $this->getBusinessUser()->getBusinessTalent()->getId() && $BusinessConversation->getUserId() != $this->getBusinessUser()->getId()) {
            die();
        }

        /* Mise a jour statut demande */
        $demande['id']      = $BusinessConversation->getDemandeTalentId();
        $demande['status']  = BusinessTalentDemande::STATUS_VALIDER;
        $demande['valider'] = "oui";
        $this->ModelTalent->saveDemande($demande);

        /* Send new message */
        $text = "Rendez-vous confirmé le " . $BusinessConversation->getBusinessDemandeRDV()->getDateHourRdvInText();
        $text .= '<br />' . $this->getBusinessUser()->getPrenom() . ' contactera ' . $BusinessConversation->getBusinessUserInterlocutor()->getPrenom() . " à l'heure convenue. <br />Pensez à préciser entre vous l’heure de début ainsi que les modalités de RDV (RDV téléphonique, RDV physique, Skype...)";
        $text .= '<br /><br />Bon RDV !';
        $text
              .= '<br />Camille de l’équipe ULYSS.CO <br />
                                    NB : Si vous rencontrez des problèmes, n’hésitez pas à me contacter sur <a href="mailto:camille@ulyss.co">camille@ulyss.co</a>';
        $BusinessConversation->sendNewMessage($text, true);

        /* Send Mail / SMS notification to Candidat */
        if ($BusinessConversation->getBusinessUserInterlocutor()->acceptMailsConfirmationRDVDemande()) {
            /* SendInBlue */
            SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_CANDIDAT_RDV_CONFIRMED,
                $BusinessConversation->getBusinessUserInterlocutor()->getEmail(),
                [
                    'FULLNAME_USER' => $BusinessConversation->getBusinessUserInterlocutor()->getPrenom(),
                    'FIRSTNAME'     => $this->getBusinessUser()->getFullName(),
                    'DATE'          => $BusinessConversation->getBusinessDemandeRDV()->getDateHourRdvInText(),
                    'URL_BOUTON'    => base_url('messages/conversation/' . $BusinessConversation->getId() . '?hash=' . $BusinessConversation->getBusinessUserInterlocutor()->getHash()),
                ]
            );

        }
        if ($BusinessConversation->getBusinessUserInterlocutor()->acceptSMSConfirmationRDVDemande()) {
            /* Envoi SMS */
            SendInBlue::sendSms($BusinessConversation->getBusinessUserInterlocutor()->getTelephoneWithoutSign(),
                'Bonjour, votre demande de RDV a été acceptée par le Mentor ! RDV sur ulyss.co pour en savoir +');
        }

        /* Send Mail to Mentor */
        /* SendInBlue */
        SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_MAIL_MENTOR_VALIDATION_RDV,
            $this->getBusinessUser()->getEmail(),
            [
                'FIRSTNAME'     => $this->getBusinessUser()->getPrenom(),
                'FULLNAME_USER' => $BusinessConversation->getBusinessUserInterlocutor()->getFullName(),
                'DATE'          => $BusinessConversation->getBusinessDemandeRDV()->getDateHourRdvInText(),
                'URL_BOUTON'    => base_url('messages/conversation/' . $BusinessConversation->getId() . '?hash=' . $this->getBusinessUser()->getHash()),
            ]
        );

        echo json_encode(['msg' => 'oki']);
    }

    /**
     * Quand le mentor refuse le RDV
     */
    public function refuser_demande()
    {
        if (!$this->input->post("id") || !$this->session->userdata('logged_in_site_web')) {
            die();
        }

        $ConversationID       = $this->input->post('conversations');
        $Conversation         = $this->ModelConversation->getById($ConversationID);
        $BusinessConversation = new BusinessConversation($Conversation);
        $lastState            = $BusinessConversation->getBusinessDemandeRDV()->getStatus();

        /* Securité control */
        if ($BusinessConversation->getTalentId() != $this->getBusinessUser()->getBusinessTalent()->getId() && $BusinessConversation->getUserId() != $this->getBusinessUser()->getId()) {
            die();
        }

        /* Mise a jour statut demande */
        $demande['id']     = $BusinessConversation->getDemandeTalentId();
        $demande['status'] = BusinessTalentDemande::STATUS_REJETER;
        $this->ModelTalent->saveDemande($demande);

        /* Send new message */
        $text = $this->getBusinessUser()->getFullName() . " a annulé le RDV du " . $BusinessConversation->getBusinessDemandeRDV()->getDateHourRdvInText();
        if ($this->input->post("messageperso") != '') {
            $text .= "<br /><br />Voici le message du mentor laissé à votre attention :<br />";
            $text .= '&laquo; ' . $this->input->post("messageperso") . ' &raquo;';
        }
        $text
            .= '<br /><br />Camille de l’équipe ULYSS.CO <br />
                                    NB : Si vous rencontrez des problèmes, n’hésitez pas à me contacter sur <a href="mailto:camille@ulyss.co">camille@ulyss.co</a>';
        $BusinessConversation->sendNewMessage($text, true);

        /* Send Mail / SMS notification to Candidat */
        if ($BusinessConversation->getBusinessUserInterlocutor()->acceptMailsConfirmationRDVDemande()) {
            /* SendInBlue */
            SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_CANDIDAT_RDV_ANNULE_ALERT,
                $BusinessConversation->getBusinessUserInterlocutor()->getEmail(),
                [
                    'FULLNAME_MENTOR' => $this->getBusinessUser()->getFullName(),
                    'FIRSTNAME'       => $BusinessConversation->getBusinessUserInterlocutor()->getPrenom(),
                    'URL_BOUTON'      => base_url('messages/conversation/' . $BusinessConversation->getId() . '?hash=' . $BusinessConversation->getBusinessUserInterlocutor()->getHash()),
                ]
            );

        }
        if ($BusinessConversation->getBusinessUserInterlocutor()->acceptSMSConfirmationRDVDemande()) {
            /* Envoi SMS */
            if ($lastState == BusinessTalentDemande::STATUS_ENATTENTE) {
                SendInBlue::sendSms($BusinessConversation->getBusinessUserInterlocutor()->getTelephoneWithoutSign(),
                    'Bonjour, votre demande de RDV a été refusée par le Mentor ! RDV sur ulyss.co pour en savoir +');
            } else {
                SendInBlue::sendSms($BusinessConversation->getBusinessUserInterlocutor()->getTelephoneWithoutSign(),
                    'Bonjour, votre RDV a finalement été annulé par le Mentor. RDV sur ulyss.co pour en savoir +');
            }
        }

        /* Send Mail to Mentor */
        /* SendInBlue */
        SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_MENTOR_CONFIRMATION_RDV_ANNULE_SELF,
            $this->getBusinessUser()->getEmail(),
            [
                'FIRSTNAME'     => $this->getBusinessUser()->getPrenom(),
                'FULLNAME_USER' => $BusinessConversation->getBusinessUserInterlocutor()->getFullName(),
                'URL_BOUTON'    => base_url('messages/conversation/' . $BusinessConversation->getId() . '?hash=' . $this->getBusinessUser()->getHash()),
            ]
        );

        echo json_encode(['msg' => 'oki']);
    }

    /**
     * Quand le candidat annule le RDV
     */
    public function refuser_demande_candidat()
    {
        if (!$this->input->post("id") || !$this->session->userdata('logged_in_site_web')) {
            die();
        }

        $ConversationID       = $this->input->post('conversations');
        $Conversation         = $this->ModelConversation->getById($ConversationID);
        $BusinessConversation = new BusinessConversation($Conversation);

        /* Securité control */
        if ($BusinessConversation->getTalentId() != $this->getBusinessUser()->getBusinessTalent()->getId() && $BusinessConversation->getUserId() != $this->getBusinessUser()->getId()) {
            die();
        }

        /* Mise a jour statut demande */
        $demande['id']     = $BusinessConversation->getDemandeTalentId();
        $demande['status'] = BusinessTalentDemande::STATUS_REJETER;
        $this->ModelTalent->saveDemande($demande);

        /* Send new message */
        $text = $this->getBusinessUser()->getFullName() . " a annulé sa demande de RDV du " . $BusinessConversation->getBusinessDemandeRDV()->getDateHourRdvInText();
        if ($this->input->post("messageperso") != '') {
            $text .= "<br /><br />Voici le message du candidat laissé à votre attention :<br />";
            $text .= '&laquo; ' . $this->input->post("messageperso") . ' &raquo;';
        }
        $text
            .= '<br /><br />Camille de l’équipe ULYSS.CO <br />
                                    NB : Si vous rencontrez des problèmes, n’hésitez pas à me contacter sur <a href="mailto:camille@ulyss.co">camille@ulyss.co</a>';
        $BusinessConversation->sendNewMessage($text, true);

        /* Send Mail / SMS notification to Mentor */
        if ($BusinessConversation->getBusinessUserInterlocutor()->acceptMailsConfirmationRDVDemande()) {
            /* SendInBlue */
            SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_MENTOR_RDV_ANNULE_ALERT,
                $BusinessConversation->getBusinessUserInterlocutor()->getEmail(),
                [
                    'FULLNAME_USER' => $this->getBusinessUser()->getFullName(),
                    'FIRSTNAME'     => $BusinessConversation->getBusinessUserInterlocutor()->getPrenom(),
                    'URL_BOUTON'    => base_url('messages/conversation/' . $BusinessConversation->getId() . '?hash=' . $BusinessConversation->getBusinessUserInterlocutor()->getHash()),
                ]
            );

        }
        if ($BusinessConversation->getBusinessUserInterlocutor()->acceptSMSConfirmationRDVDemande()) {
            /* SMS */
            SendInBlue::sendSms($BusinessConversation->getBusinessUserInterlocutor()->getTelephoneWithoutSign(),
                'Bonjour, votre RDV a finalement été annulé par le candidat. RDV sur ulyss.co pour en savoir +');
        }

        /* Send Mail to Candidat */
        /* SendInBlue */
        SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_CANDIDAT_CONFIRMATION_RDV_ANNULE_SELF,
            $this->getBusinessUser()->getEmail(),
            [
                'FULLNAME_MENTOR' => $BusinessConversation->getBusinessUserInterlocutor()->getFullName(),
                'FIRSTNAME'       => $this->getBusinessUser()->getPrenom(),
                'URL_BOUTON'      => base_url('messages/conversation/' . $BusinessConversation->getId() . '?hash=' . $this->getBusinessUser()->getHash()),
            ]
        );
        $html['msg'] = "oki";
        echo json_encode($html);
    }

    private function removeEmailAndPhoneFromString($string)
    {
        // remove email
        $string = preg_replace('/([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/', '', $string);
        $string = preg_replace('/(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$/', '[********]', $string);

        return $string;
    }

}

