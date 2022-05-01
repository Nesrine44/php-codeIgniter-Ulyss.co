<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paiement extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('demande_model', 'demande');
        $this->load->library('encrypt');
        $this->load->model('talent_model', 'talent');
        $this->load->library('user_info');
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
    }


    public function index($id_demande = NULL){
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        if (!$id_demande) {
            show_404();
        }
        if (empty($this->demande->checkIfMyDemande($id_demande, $this->id_user_decode))) {
            show_404();
        }

        $demande = $this->demande->getDerniereOffre($id_demande);

        if (empty($demande)) {
            show_404();
        }
        $detail_demande = $this->demande->getDemandebYiD($id_demande);


        $data['utilisateur_pour'] = $this->user_info->getNameUserW($id_demande);
        $data['amount'] = $demande->total;
        $data['frais'] = 0;
        $data['user_quipay'] = $this->user->GetUserByid($this->id_user_decode);
        $this->session->set_userdata("amount", $demande->total);
        $this->session->set_userdata("talent_demande_id", $id_demande);
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile');
        $this->load->view('profil/compte/confirmation', $data);
        $this->load->view('profil/footer');
        $this->load->view('template/footer', $this->datas);

    }

    public function card()
    {
        $this->load->library('mangopay_lib');
        if (empty($this->user_info->getWalletUser())) {
            /*get information utilisateur*/
            $utilisateur = $this->user->GetUserByid($this->id_user_decode);
            if ($utilisateur->date_naissance != "0000-00-00" and $utilisateur->adresse != "" and $utilisateur->ville_id != "") {

                $data['nom'] = $utilisateur->nom;
                $data['prenom'] = $utilisateur->prenom;
                $data['date_naissance'] = strtotime($utilisateur->date_naissance);
                $data['adresse'] = $utilisateur->adresse;
                $data['email'] = $utilisateur->email;
                $wallet_id = $this->mangopay_lib->create_user($data);
                $data_info['wallet'] = $wallet_id;
                $this->user->EditUser($this->id_user_decode, $data_info);
            } else {
                redirect(base_url() . "compte");
            }

        }

        if ($this->input->post("numero_carte")) {
            $data['numero_carte'] = $this->input->post("numero_carte");
            $data['carte_type_id'] = $this->input->post("carte_type_id");
            $data['date_expiration'] = $this->input->post("annee") . "-" . $this->input->post("mois") . "-01";
            $data['titulaire_du_carte'] = $this->input->post("titulaire_du_carte");
            // $data['cryptogramme']=$this->input->post("cryptogramme");
            $data['user_id'] = $this->id_user_decode;
            $this->user->AddCarte($data);
        }
        $data_card['id'] = $this->user_info->getWalletUser();
        $data['createdCardRegister'] = $this->mangopay_lib->createCarde($data_card);

        $this->session->set_userdata("cardRegisterId", $data['createdCardRegister']->Id);
        $this->session->set_userdata("mywallet", $data_card['id']);

        $returnUrl = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'];
        $returnUrl .= substr($_SERVER['REQUEST_URI'], 0, strripos($_SERVER['REQUEST_URI'], '/') + 1);
        $returnUrl .= 'validation';
        $data['returnUrl'] = $returnUrl;

        $data['list_type_carte'] = $this->user->GetTypesCartes();
        $data['list_mode_de_paiement'] = $this->user->GetModePaiement($this->id_user_decode);
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile');
        $this->load->view('profil/compte/paiement', $data);
        $this->load->view('profil/footer');
        $this->load->view('template/footer', $this->datas);

    }

    public function validation()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }

        $this->load->library('mangopay_lib');
        if (!$this->session->userdata('amount')) {
            die('<div style="color:red;">No payment has been started<div>');
        }

        if ($this->mangopay_lib->validation_payement()) {
            $id_demande = $this->session->userdata('talent_demande_id');
            $detail_demande = $this->demande->getDemandebYiD($id_demande);
            if ($detail_demande->status != "contractualisé") {
                $data_etat['etat'] = 1;
                $data_etat['status'] = "contractualisé";
                $this->demande->editerDemande($this->id_user_decode, $id_demande, $data_etat);
                /*new notifications*/
                $this->load->library('mailing');
                if (!empty($detail_demande) && $detail_demande->user_id_acheteur == $this->id_user_decode) {
                    $user_talent = $this->user_info->getUserIdByDemande($id_demande);
                    $type_notification = $this->user_info->getTypeNotificationsNewMsg($user_talent);
                    if (!empty($type_notification) && $type_notification->notifications_msg_membre == "email") {
                        $data_notification['talent'] = $this->user_info->getNameTalent($detail_demande->talent_id);
                        $data_notification['email'] = $type_notification->email;
                        $data_notification['name'] = $type_notification->prenom . ' ' . $type_notification->nom;
                        $data_notification['sender'] = $this->user_info->getNameUser($this->id_user_decode);
                        $this->mailing->notifications_accepte_demande_msg_email($data_notification);
                    } elseif (!empty($type_notification) && $type_notification->notifications_msg_membre == "sms") {
                        $data_notification['talent'] = $this->user_info->getNameTalent($detail_demande->talent_id);
                        $data_notification['name'] = $type_notification->prenom . ' ' . $type_notification->nom;
                        $data_notification['phone'] = $type_notification->tel;
                        $data_notification['sender'] = $this->user_info->getNameUser($this->id_user_decode);
                        $data_notification['horaire'] = $detail_demande->horaire;
                        $data_notification['date'] = date("d/m/Y", strtotime($detail_demande->date_livraison));
                        $info_talent = $this->talent->GetTalentUser($detail_demande->talent_id);
                        $data_notification['lieu'] = $this->user_info->getVilleCodePostal($info_talent->ville);


                        $this->mailing->notifications_accepte_demande_msg_sms($data_notification);
                    } elseif (!empty($type_notification) && $type_notification->notifications_msg_membre == "sms_email") {
                        $data_notification['talent'] = $this->user_info->getNameTalent($detail_demande->talent_id);
                        $data_notification['name'] = $type_notification->prenom . ' ' . $type_notification->nom;
                        $data_notification['phone'] = $type_notification->tel;
                        $data_notification['sender'] = $this->user_info->getNameUser($this->id_user_decode);
                        $data_notification['horaire'] = $detail_demande->horaire;
                        $data_notification['date'] = date("d/m/Y", strtotime($detail_demande->date_livraison));
                        $info_talent = $this->talent->GetTalentUser($detail_demande->talent_id);
                        $data_notification['lieu'] = $this->user_info->getVilleCodePostal($info_talent->ville);


                        $this->mailing->notifications_accepte_demande_msg_sms($data_notification);

                        $data_notification_e['talent'] = $this->user_info->getNameTalent($detail_demande->talent_id);
                        $data_notification_e['email'] = $type_notification->email;
                        $data_notification_e['name'] = $type_notification->prenom . ' ' . $type_notification->nom;
                        $data_notification_e['sender'] = $this->user_info->getNameUser($this->id_user_decode);
                        $this->mailing->notifications_accepte_demande_msg_email($data_notification_e);


                    } else {

                    }

                }
            }

            $data_paiement['talent_demande_id'] = $this->session->userdata('talent_demande_id');
            $data_paiement['pay_in_montant'] = $this->session->userdata('amount');
            $data_paiement['pay_in_id'] = $this->mangopay_lib->validation_payement();
            $data_paiement['pay_in_date'] = date('Y-m-d  H:i:s');
            $this->load->model('paiement_model', 'pay');
            $this->pay->addPaiement($data_paiement);
            $data['message'] = 'Votre paiement a été validé par votre banque.';
        } else {
            $data['message'] = "Le paiement a été refusé par votre banque. Veuillez utiliser un autre carte de paiement.";
        }
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile');
        $this->load->view('profil/compte/validation', $data);
        $this->load->view('profil/footer');
        $this->load->view('template/footer', $this->datas);

    }

}