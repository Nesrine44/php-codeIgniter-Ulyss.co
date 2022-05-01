<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mes_activites extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('talent_model', 'talent');
        $this->load->model('demande_model', 'demande');
        $this->load->model('user_model', 'user');
        $this->load->library('encrypt');
        $this->load->library('user_info');
        $this->load->helper('text');
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
    }

    public function index()
    {
        $this->talents_encours();
    }

    public function talents()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $id_user = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);

        if ($this->input->post("titre")) {
            $data_info['titre']       = $this->input->post("titre");
            $data_info['description'] = $this->input->post("description");
            $data_info['prix']        = $this->input->post("prix");
            $data_info['horaire']     = $this->input->post("horaire");
            $data_info['horaire_de']  = $this->input->post("horaire_de");
            $data_info['horaire_a']   = $this->input->post("horaire_a");

            $data_info['description_forfait'] = $this->input->post("description_forfait");
            $data_info['prix_forfait']        = $this->input->post("prix_forfait");
            $data_info['prix_journee']        = $this->input->post("prix_journee");


            $data_info['alias']   = $this->create_alias($this->input->post("titre"));
            $data_info['user_id'] = $id_user;
            if (isset($_FILES["file"]["name"]) && $_FILES["file"]["error"] == 0) {
                $allowedExts            = ["gif", "jpeg", "jpg", "png"];
                $temp                   = explode(".", $_FILES["file"]["name"]);
                $extension              = end($temp);
                $_FILES["file"]["name"] = $this->_unique_field_name($_FILES["file"]["name"]);
                $_FILES["file"]["name"] .= "." . $extension;
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } else {
                    //CB : Utilisation du module S3File
                    if ($this->s3file->file_exists("upload/talents/" . $_FILES["file"]["name"])) {
                        $this->s3file->unlink("upload/talents/" . $_FILES["file"]["name"]);
                    }
                    $this->s3file->move_uploaded_file($_FILES["file"]["tmp_name"], "upload/talents/" . $_FILES["file"]["name"]);
                    $data_info['cover'] = $_FILES["file"]["name"];
                }
            }
            $id_t = $this->talent->AddTalent($data_info);
            if ($this->input->post("list_cat")) {
                foreach ($this->input->post("list_cat") as $key => $value) {
                    $data_ca['talent_id']    = $id_t;
                    $data_ca['categorie_id'] = $value;
                    $this->talent->AddTalentCategorie($data_ca);
                }
            }

            if ($this->input->post("id_wish") && $this->input->post("id_wish") != 0) {
                /*new notifications*/
                $this->load->model('wishlist_model', 'wish');
                $wish_detail = $this->wish->getWishById($this->input->post("id_wish"));
                if (!empty($wish_detail)) {
                    $this->load->library('mailing');
                    $type_notification = $this->user_info->getTypeNotificationsNewMsg($wish_detail->user_id);
                    if (!empty($type_notification) && $type_notification->notifications_msg_membre == "email") {
                        $data_notification['wish']   = $wish_detail->titre;
                        $data_notification['talent'] = $data_info['titre'];
                        $data_notification['email']  = $type_notification->email;
                        $data_notification['name']   = $type_notification->prenom . ' ' . $type_notification->nom;
                        $data_notification['sender'] = $this->user_info->getNameUser($this->id_user_decode);
                        $this->mailing->notifications_new_alerte_msg_email($data_notification);
                    } elseif (!empty($type_notification) && $type_notification->notifications_msg_membre == "sms") {
                        $data_notification['wish']   = $wish_detail->titre;
                        $data_notification['talent'] = $data_info['titre'];

                        $data_notification['name']   = $type_notification->prenom . ' ' . $type_notification->nom;
                        $data_notification['phone']  = $type_notification->tel;
                        $data_notification['sender'] = $this->user_info->getNameUser($this->id_user_decode);
                        $this->mailing->notifications_new_alerte_msg_sms($data_notification);
                    } else {

                    }
                }
            }


        }

        $data["talents"] = $this->user->GetTalentsUser($id_user);
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile', $this->datas);
        $this->load->view('profil/compte/mes_activites_item/talents', $data);
        $this->load->view('template/footer', $this->datas);
    }

    private function _unique_field_name($field_name)
    {
        return $field_name . '_' . random_string('alnum', 20);  //This s is because is better for a string to begin with a letter and not a number
    }

    private function create_alias($string)
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $this->load->model('user_model', 'user');
            $this->load->library('urlify');
            //$search = array ('@[éèêëÊË]@i','@[àâäÂÄ]@i','@[îïÎÏ]@i','@[ûùüÛÜ]@i','@[ôöÔÖ]@i','@[ç]@i','@[ ]@i','@[^a-zA-Z0-9_]@');
            //$replace = array ('e','a','i','u','o','c','_','');
            //$result=preg_replace($search, $replace, $in);
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
        }

        return $verifcation;
    }

    public function activer($id = null)
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $data['status'] = true;
        $this->talent->EditTalentByiAndIduser($id, $this->id_user_decode, $data);
        $this->talents();
    }

    public function desactiver($id = null)
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $data['status'] = false;
        $this->talent->EditTalentByiAndIduser($id, $this->id_user_decode, $data);
        $this->talents();
    }

    public function favoris()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $favoris         = $this->talent->GetFavorisUser($this->id_user_decode);
        $data["favoris"] = [];

        foreach ($favoris as $favori) {
            $ModelTalent       = $this->ModelTalent->getById($favori->talent_id);
            $BusinessTalent    = new BusinessTalent($ModelTalent);
            $data["favoris"][] = $BusinessTalent;
        }
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile', $this->datas);
        $this->load->view('profil/compte/mes_activites_item/favoris', $data);
        $this->load->view('profil/footer');
        $this->load->view('template/footer', $this->datas);

    }

    public function dislike_favoris($id = null)
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }

        $this->talent->DislikeFavoris($id, $this->id_user_decode);
        $this->favoris();
    }

    public function talents_encours()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }

        $ModelDemandes         = $this->ModelTalent->getAllRDV($this->getBusinessUser()->getBusinessTalent()->getId());
        $data['ModelDemandes'] = [];
        foreach ($ModelDemandes as $ModelDemande) {
            $BusinessDemande = new BusinessTalentDemande($ModelDemande);
            if ($BusinessDemande->estPassee() == false) {
                $data['ModelDemandes'][] = $BusinessDemande;
            }
        }

        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile', $this->datas);
        $this->load->view('profil/compte/mes_activites_item/talents_encours', $data);
        $this->load->view('template/footer', $this->datas);
    }

    public function historiques_des_prestations()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }

        $ModelDemandes         = $this->ModelTalent->getAllRDV($this->getBusinessUser()->getBusinessTalent()->getId());
        $data['ModelDemandes'] = [];
        foreach ($ModelDemandes as $ModelDemande) {
            $BusinessDemande = new BusinessTalentDemande($ModelDemande);
            if ($BusinessDemande->estPassee()) {
                $data['ModelDemandes'][] = $BusinessDemande;
            }
        }
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile', $this->datas);
        $this->load->view('profil/compte/mes_activites_item/historiques_des_prestations', $data);
        $this->load->view('template/footer', $this->datas);
    }

    public function historiques_des_prestations_demande()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }

        $ModelDemandes         = $this->ModelUser->getAllRDV($this->getBusinessUser()->getId());
        $data['ModelDemandes'] = [];
        foreach ($ModelDemandes as $ModelDemande) {
            $BusinessDemande = new BusinessTalentDemande($ModelDemande);
            if ($BusinessDemande->estPassee()) {
                $data['ModelDemandes'][] = $BusinessDemande;
            }
        }
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile', $this->datas);
        $this->load->view('profil/compte/mes_activites_item/historiques_des_prestations_demande', $data);
        $this->load->view('template/footer', $this->datas);
    }

    public function demandes()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $ModelDemandes         = $this->ModelUser->getAllRDV($this->getBusinessUser()->getId());
        $data['ModelDemandes'] = [];
        foreach ($ModelDemandes as $ModelDemande) {
            $BusinessDemande = new BusinessTalentDemande($ModelDemande);
            if ($BusinessDemande->estPassee() == false) {
                $data['ModelDemandes'][] = $BusinessDemande;
            }
        }

        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile', $this->datas);
        $this->load->view('profil/compte/mes_activites_item/demandes', $data);
        $this->load->view('profil/footer');
        $this->load->view('template/footer', $this->datas);

    }

    public function questionnaires()
    {
        $data['ModelQuestionnaires'] = $this->getBusinessUser()->getAllWaitingQuestionaires();
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile', $this->datas);
        $this->load->view('profil/compte/mes_activites_item/questionnaires', $data);
        $this->load->view('profil/footer');
        $this->load->view('template/footer', $this->datas);
    }

    public function questionnaires_mentor()
    {
        $data['ModelQuestionnaires'] = $this->getBusinessUser()->getBusinessTalent()->getAllWaitingQuestionaires();
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile', $this->datas);
        $this->load->view('profil/compte/mes_activites_item/questionnaires_mentor', $data);
        $this->load->view('profil/footer');
        $this->load->view('template/footer', $this->datas);
    }

    public function alertes()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile', $this->datas);
        $this->load->view('profil/compte/mes_activites_item/alertes');
        $this->load->view('profil/footer');
        $this->load->view('template/footer', $this->datas);
    }

    public function facture($id = null)
    {
        if (!$id) {
            show_404();
        }
        $facture = $this->demande->getFacture($id, $this->id_user_decode);
        if (!$facture) {
            show_404();
        }
        $data['facture'] = $facture;
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile', $this->datas);
        $this->load->view('profil/compte/mes_activites_item/facture', $data);
        $this->load->view('profil/footer');
        $this->load->view('template/footer', $this->datas);
    }

    public function telecharger_facture($id = null)
    {
        if (!$id) {
            show_404();
        }
        $facture = $this->demande->getFacture($id, $this->id_user_decode);
        if (!$facture) {
            show_404();
        }
        $data['facture'] = $facture;
        $source          = $this->load->view('profil/compte/mes_activites_item/facture_pdf', $data, true);
        $footer          = "<table align='center'><tr><td style='font-size:11px;color:#333;text-align:center !important'>" . $this->user_info->getconfig(9) . "</td></tr></table>";
        $header          = "<table align='left'><tr><td><img src='" . base_url() . "/assets/img/logo_2.png' ></td></tr></table>";
        $this->load->helper(['mpdf/my_pdf_helper']);
        $random = 'facture_' . $facture->titre;
        telecharger_facture($source, $random, $footer, $header, false);
    }

    public function etanche_on($id = null)
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $data['etanche'] = false;
        $this->talent->EditTalentByiAndIduser($id, $this->id_user_decode, $data);
        $this->talents();
    }

    public function etanche_off($id = null)
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $data['etanche'] = true;
        $this->talent->EditTalentByiAndIduser($id, $this->id_user_decode, $data);
        $this->talents();
    }
}

