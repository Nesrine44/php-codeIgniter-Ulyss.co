<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('./application/libraries/REST_Controller.php');

class Gestion extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gestion_model', 'gestion');
        $this->load->model('andafter/ModelGestion', 'ModelGestion');
        $this->load->library('encrypt');
        $this->db->save_queries = false;
        $this->load->model('user_model', 'user');
        if ($this->input->ip_address() != '195.220.8.2'
            && $this->input->ip_address() != '90.63.250.240'
            && $this->input->ip_address() != '172.16.193.209'
            && $this->input->ip_address() != '77.158.70.34'
            && $this->input->ip_address() != '82.227.65.202'
            && $this->input->ip_address() != '10.208.0.110'
            && $this->input->ip_address() != '88.163.190.27'
            && $this->input->ip_address() != '84.14.157.66'
            && $this->input->ip_address() != '83.202.46.135'
            && $this->input->ip_address() != '80.215.217.51'
            && $this->input->ip_address() != '91.160.91.156'
        ) {
            die('server error');
        }
    }

    private function create_alias($string)
    {
        $this->load->model('talent_model', 'talent');
        $this->load->model('user_model', 'user');
        $this->load->library('urlify');
        //$search = array ('@[éèêëÊË]@i','@[àâäÂÄ]@i','@[îïÎÏ]@i','@[ûùüÛÜ]@i','@[ôöÔÖ]@i','@[ç]@i','@[ ]@i','@[^a-zA-Z0-9_]@');
        //$replace = array ('e','a','i','u','o'p_baseurlV1,'c','_','');
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

        return $verifcation;
    }

    public function add_annonce_post()
    {

        if ($this->post('user_id')) {

            $data['user_id']       = $this->post('user_id');
            $data['prix_journee']  = $this->post('prix');
            $data['prix']          = $this->post('prix');
            $data['reduction']     = $this->post('reduction');
            $data['description']   = $this->post('description');
            $data['public_profil'] = $this->post('public_profil');
            $row                   = $this->gestion->getElement($this->post('user_id'), 'user');
            $data['alias']         = $this->create_alias($row->nom . " " . $row->prenom);
            $this->load->model('talent_model', 'talent');
            $id_t = $this->talent->AddTalent($data);

            /*add competences*/
            foreach ($this->post('competences') as $key => $item) {
                $data_tag['talent_id'] = $id_t;
                $data_tag['tag_id']    = $item['id'];
                $this->talent->AddTalentTag($data_tag);
            }
            /*formations*/
            foreach ($this->post('formations') as $key => $item) {
                $data_formation['talent_id']  = $id_t;
                $data_formation['date_debut'] = $item['date_debut'];
                $data_formation['date_fin']   = $item['date_fin'];
                $data_formation['university'] = $item['university'];
                $data_formation['formation']  = $item['formation'];
                $data_formation['niveau']     = !empty($item['niveau']) ? $item['niveau'] : "";
                $this->talent->AddTalentFormation($data_formation);
            }
            /*experiences*/

            foreach ($this->post('experience') as $key => $item) {
                $data_experience['talent_id']      = $id_t;
                $data_experience['entreprise_id']  = $item['entreprise_id'];
                $data_experience['date_debut']     = $item['date_debut'];
                $data_experience['secteur_id']     = $item['secteur_id'];
                $data_experience['fonction_id']    = $item['fonction_id'];
                $data_experience['departement_id'] = $item['departement_id'];
                $data_experience['date_fin']       = $item['date_fin'];
                $data_experience['lieu']           = !empty($item['lieu']) ? $item['lieu'] : "";
                $data_experience['description']    = $item['description'];
                $data_experience['titre_mission']  = $item['titre_mission'];
                $this->talent->AddTalentExperience($data_experience);
            }

            $data_horaire['talent_id']     = $id_t;
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
            $this->talent->AddTalentHoraire($data_horaire);
            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);
        }
    }

    /*get all demandes*/


    public function paiements_get()
    {
        $rows_results = [];

        $this->load->model('paiement_model', 'pay');
        $list = $this->pay->getListTransfere();
        foreach ($list as $row) {
            $utilisateur    = $this->user->GetUserByid($row->user_id_acheteur);
            $rows_results[] = [
                'achteur'        => $utilisateur->prenom . " " . $utilisateur->nom,
                'pay_in_montant' => $row->pay_in_montant,
                'pay_in_date'    => $row->pay_in_date,
                'titre'          => $row->titre,
                'paye'           => ($row->paye == 0) ? "oui" : "non",
                'status'         => $row->status
            ];
        }

        $this->response(['data' => $rows_results]);
    }

    /*get pages liste*/

    public function visiteurs_get()
    {
        $MysqlDateStart          = date('Y-m-d 00:00:00');
        $MysqlDateEnd            = date('Y-m-d 23:59:59');
        $nombre_candidats        = $this->ModelGestion->getCountAllCandidats($MysqlDateStart, $MysqlDateEnd);
        $nombre_talents          = $this->ModelGestion->getCountAllTalents($MysqlDateStart, $MysqlDateEnd);
        $nombre_demandes         = $this->ModelGestion->getCountAllDemandes($MysqlDateStart, $MysqlDateEnd);
        $nombre_demandes_valides = $this->ModelGestion->getCountAllDemandesValid($MysqlDateStart, $MysqlDateEnd);

        $this->response([
                'candidats'       => $nombre_candidats,
                'talents'         => $nombre_talents,
                'demandes'        => $nombre_demandes,
                'demandes_valids' => $nombre_demandes_valides,
            ]
        );
    }

    public function visiteurs_periode_post()
    {
        $dateStart      = $this->post("date1");
        $MysqlDateStart = new DateTime($dateStart);
        $MysqlDateStart = $MysqlDateStart->format('Y-m-d 00:00:00');
        $dateEnd        = $this->post("date2");
        $MysqlDateEnd   = new DateTime($dateEnd);
        $MysqlDateEnd->modify('+1 day');
        $MysqlDateEnd            = $MysqlDateEnd->format('Y-m-d 23:59:59');
        $nombre_candidats        = $this->ModelGestion->getCountAllCandidats($MysqlDateStart, $MysqlDateEnd);
        $nombre_talents          = $this->ModelGestion->getCountAllTalents($MysqlDateStart, $MysqlDateEnd);
        $nombre_demandes         = $this->ModelGestion->getCountAllDemandes($MysqlDateStart, $MysqlDateEnd);
        $nombre_demandes_valides = $this->ModelGestion->getCountAllDemandesValid($MysqlDateStart, $MysqlDateEnd);

        $this->response([
                'candidats'       => $nombre_candidats,
                'talents'         => $nombre_talents,
                'demandes'        => $nombre_demandes,
                'demandes_valids' => $nombre_demandes_valides,
            ]
        );
    }

    public function candidat_export_get()
    {
        $dateStart = $this->get("date1");
        if ($dateStart != false) {
            $dateStart      = str_replace('"', '', $dateStart);
            $MysqlDateStart = new DateTime($dateStart);
            $MysqlDateStart = $MysqlDateStart->format('Y-m-d 00:00:00');
        } else {
            $MysqlDateStart = date('Y-m-d 00:00:00');
        }
        $dateEnd = $this->get("date2");
        if ($dateEnd != "") {
            $dateEnd      = str_replace('"', '', $dateStart);
            $MysqlDateEnd = new DateTime($dateEnd);
            $MysqlDateEnd->modify('+1 day');
            $MysqlDateEnd = $MysqlDateEnd->format('Y-m-d 23:59:59');
        } else {
            $MysqlDateEnd = date('Y-m-d 23:59:59');
        }

        $candidats = $this->ModelGestion->getAllCandidats($MysqlDateStart, $MysqlDateEnd);


        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=candidats.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-Transfer-Encoding: UTF-8");

        echo utf8_decode("Nom;"
            . "Prénom;"
            . "Adresse email;"
            . "Téléphone;"
            . "Date création compte;"
            . "Date dernière connexion;"
            . "Poste actuel;"
            . "Nom société;"
            . "Localisation société;"
            . "Date de commencement poste;"
            . "Nombre de RDV validés;"
            . "Nombre de RDV annulés;"
            . "Nombre de RDV en attente;"
            . "\n");

        foreach ($candidats as $candidat) {
            $BusinessTalent = new BusinessTalent($candidat);
            $BusinessUser   = $BusinessTalent->getBusinessUser();
            echo utf8_decode($BusinessUser->getNom() . ";"
                . $BusinessUser->getPrenom() . ";"
                . $BusinessUser->getEmail() . ";"
                . $BusinessUser->getTelephone() . ";"
                . $BusinessUser->getDateCreation()->format('d/m/Y H:i:s') . ";"
                . $BusinessUser->getDateConnexion()->format('d/m/Y H:i:s') . ";"
                . $BusinessUser->getBusinessUserLinkedin()->getActualjobTitle() . ";"
                . $BusinessUser->getBusinessUserLinkedin()->getCompagnyName() . ";"
                . $BusinessUser->getBusinessUserLinkedin()->getCompagnyLocation() . ";"
                . $BusinessUser->getBusinessUserLinkedin()->getActualjobStartDate()->format('d/m/Y') . ";"
                . $BusinessUser->countAllRDVValides() . ";"
                . $BusinessUser->countAllRDVAnnules() . ";"
                . $BusinessUser->countAllRDVEnAttente() . ";"
                . "\n");
        }

        die();
    }

    public function mentor_export_get()
    {
        $dateStart = $this->get("date1");
        if ($dateStart != false) {
            $dateStart      = str_replace('"', '', $dateStart);
            $MysqlDateStart = new DateTime($dateStart);
            $MysqlDateStart = $MysqlDateStart->format('Y-m-d 00:00:00');
        } else {
            $MysqlDateStart = date('Y-m-d 00:00:00');
        }
        $dateEnd = $this->get("date2");
        if ($dateEnd != "") {
            $MysqlDateEnd = new DateTime($dateEnd);
            $MysqlDateEnd->modify('+1 day');
            $MysqlDateEnd = $MysqlDateEnd->format('Y-m-d 23:59:59');
        } else {
            $MysqlDateEnd = date('Y-m-d 23:59:59');
        }

        $candidats = $this->ModelGestion->getAllTalents($MysqlDateStart, $MysqlDateEnd);

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=mentors.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-Transfer-Encoding: UTF-8");

        echo utf8_decode("Nom;"
            . "Prénom;"
            . "Adresse email;"
            . "Téléphone;"
            . "Date création compte;"
            . "Date dernière connexion;"
            . "Poste actuel;"
            . "Nom société;"
            . "Localisation société;"
            . "Date de commencement poste;"
            . "Nombre de RDV validés en tant que Mentor;"
            . "Nombre de RDV annulés en tant que Mentor;"
            . "Nombre de RDV en attente en tant que Mentor;"
            . "Nombre de RDV validés en tant que Candidat;"
            . "Nombre de RDV annulés en tant que Candidat;"
            . "Nombre de RDV en attente en tant que Candidat;"
            . "Recommandations;"
            . "\n");

        foreach ($candidats as $candidat) {
            $BusinessTalent = new BusinessTalent($candidat);
            $BusinessUser   = $BusinessTalent->getBusinessUser();
            echo utf8_decode($BusinessUser->getNom() . ";"
                . $BusinessUser->getPrenom() . ";"
                . $BusinessUser->getEmail() . ";"
                . $BusinessUser->getTelephone() . ";"
                . $BusinessUser->getDateCreation()->format('d/m/Y H:i:s') . ";"
                . $BusinessUser->getDateConnexion()->format('d/m/Y H:i:s') . ";"
                . $BusinessUser->getBusinessUserLinkedin()->getActualjobTitle() . ";"
                . $BusinessUser->getBusinessUserLinkedin()->getCompagnyName() . ";"
                . $BusinessUser->getBusinessUserLinkedin()->getCompagnyLocation() . ";"
                . $BusinessUser->getBusinessUserLinkedin()->getActualjobStartDate()->format('d/m/Y') . ";"
                . $BusinessTalent->countRDVValides() . ";"
                . $BusinessTalent->countRDVAnnules() . ";"
                . $BusinessTalent->countRDVEnAttente() . ";"
                . $BusinessUser->countAllRDVValides() . ";"
                . $BusinessUser->countAllRDVAnnules() . ";"
                . $BusinessUser->countAllRDVEnAttente() . ";"
                . $BusinessTalent->countRecommandations() . ";"
                . "\n");
        }

        die();
    }

    public function allrdv_export_get()
    {
        $dateStart = $this->get("date1");
        if ($dateStart != false) {
            $dateStart      = str_replace('"', '', $dateStart);
            $MysqlDateStart = new DateTime($dateStart);
            $MysqlDateStart = $MysqlDateStart->format('Y-m-d 00:00:00');
        } else {
            $MysqlDateStart = date('Y-m-d 00:00:00');
        }
        $dateEnd = $this->get("date2");
        if ($dateEnd != "") {
            $MysqlDateEnd = new DateTime($dateEnd);
            $MysqlDateEnd->modify('+1 day');
            $MysqlDateEnd = $MysqlDateEnd->format('Y-m-d 23:59:59');
        } else {
            $MysqlDateEnd = date('Y-m-d 23:59:59');
        }

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=touslesrendezvous.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-Transfer-Encoding: UTF-8");

        echo utf8_decode("Date heure RDV;"
            . "Statut;"
            . "CANDIDAT - nom prénom;"
            . "CANDIDAT - Email;"
            . "CANDIDAT - Nom société (Linkedin);"
            . "CANDIDAT - Type poste(Linkedin);"
            . "MENTOR - nom prénom;"
            . "MENTOR - Email;"
            . "MENTOR - Nom société (Linkedin);"
            . "MENTOR - Type poste(Linkedin);"
            . "\n");

        $Demandes = $this->ModelGestion->getAllDemandes($MysqlDateStart, $MysqlDateEnd);
        foreach ($Demandes as $Demande) {
            $BusinessTalent = new BusinessTalentDemande($Demande);
            echo utf8_decode($BusinessTalent->getDateHourRdvInText() . ";"
                . $BusinessTalent->getStatusInText() . ";"
                . $BusinessTalent->getBusinessUser()->getFullName() . ";"
                . $BusinessTalent->getBusinessUser()->getEmail() . ";"
                . $BusinessTalent->getBusinessUser()->getBusinessUserLinkedin()->getCompagnyName() . ";"
                . $BusinessTalent->getBusinessUser()->getBusinessUserLinkedin()->getIndustry() . ";"

                . $BusinessTalent->getBusinessTalent()->getBusinessUser()->getFullName() . ";"
                . $BusinessTalent->getBusinessTalent()->getBusinessUser()->getEmail() . ";"
                . $BusinessTalent->getBusinessTalent()->getBusinessUser()->getBusinessUserLinkedin()->getCompagnyName() . ";"
                . $BusinessTalent->getBusinessTalent()->getBusinessUser()->getBusinessUserLinkedin()->getIndustry() . ";"
                . "\n");
        }

        die();
    }

    public function rdvrealises_export_get()
    {
        $dateStart = $this->get("date1");
        if ($dateStart != false) {
            $dateStart      = str_replace('"', '', $dateStart);
            $MysqlDateStart = new DateTime($dateStart);
            $MysqlDateStart = $MysqlDateStart->format('Y-m-d 00:00:00');
        } else {
            $MysqlDateStart = date('Y-m-d 00:00:00');
        }
        $dateEnd = $this->get("date2");
        if ($dateEnd != "") {
            $MysqlDateEnd = new DateTime($dateEnd);
            $MysqlDateEnd->modify('+1 day');
            $MysqlDateEnd = $MysqlDateEnd->format('Y-m-d 23:59:59');
        } else {
            $MysqlDateEnd = date('Y-m-d 23:59:59');
        }

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=rendezvousrealises.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-Transfer-Encoding: UTF-8");

        echo utf8_decode("Date heure RDV;"
            . "Statut;"
            . "CANDIDAT - nom prénom;"
            . "CANDIDAT - Email;"
            . "CANDIDAT - Nom société (Linkedin);"
            . "CANDIDAT - Type poste(Linkedin);"
            . "MENTOR - nom prénom;"
            . "MENTOR - Email;"
            . "MENTOR - Nom société (Linkedin);"
            . "MENTOR - Type poste(Linkedin);"
            . "\n");

        $Demandes = $this->ModelGestion->getAllDemandesRealises($MysqlDateStart, $MysqlDateEnd);
        foreach ($Demandes as $Demande) {
            $BusinessTalent = new BusinessTalentDemande($Demande);
            echo utf8_decode($BusinessTalent->getDateHourRdvInText() . ";"
                . $BusinessTalent->getStatusInText() . ";"
                . $BusinessTalent->getBusinessUser()->getFullName() . ";"
                . $BusinessTalent->getBusinessUser()->getEmail() . ";"
                . $BusinessTalent->getBusinessUser()->getBusinessUserLinkedin()->getCompagnyName() . ";"
                . $BusinessTalent->getBusinessUser()->getBusinessUserLinkedin()->getIndustry() . ";"

                . $BusinessTalent->getBusinessTalent()->getBusinessUser()->getFullName() . ";"
                . $BusinessTalent->getBusinessTalent()->getBusinessUser()->getEmail() . ";"
                . $BusinessTalent->getBusinessTalent()->getBusinessUser()->getBusinessUserLinkedin()->getCompagnyName() . ";"
                . $BusinessTalent->getBusinessTalent()->getBusinessUser()->getBusinessUserLinkedin()->getIndustry() . ";"
                . "\n");
        }

        die();
    }

    public function ajouter_page_content_post()
    {
        if (!$this->session->userdata('logged')) {
            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);
        }


        $data['title']       = $this->post('title');
        $data['parent_id']   = $this->post('parent_id');
        $data['description'] = $this->post('description');

        $this->gestion->ajouterElement($data, "pages_content", false);


        $this->response(['status' => true, 'reponse' => "goooood"], 200);

    }

    public function detail_page_content_get($id = null)
    {

        if (!$id or !$this->session->userdata('logged')) {
            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);
        }
        $row = $this->gestion->getElement($id, 'pages_content');
        if ($row) {
            $this->response(['status' => true, 'reponse' => $row], 200);
        } else {
            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);
        }
    }

    public function editer_page_content_post()
    {
        if ($this->post('id')) {

            $data['title']       = $this->post('title');
            $data['description'] = $this->post('description');
            $this->gestion->editerElement($this->post('id'), $data, "pages_content");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);
        }
    }

    public function admin_delete_content_page_post()
    {
        if ($this->post('id')) {
            $this->gestion->supprimerElement($this->post('id'), "pages_content");
            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);
        }
    }

    public function pages_content_detail_get($id = null)
    {

        $response = [];
        $list     = $this->gestion->GetAllPagesParentByid($id);
        foreach ($list as $row) {

            $response[] = [
                'id'     => $row->id,
                'title'  => "<a href='" . base_url() . "gestion/#/app/pages_content/" . $row->id . "'>" . $row->title . "</a>",
                'supp'   => "<button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button><button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i>",
                'ticked' => false
            ];
        }

        $this->response(['aaData' => $response]);

    }

    public function pages_content_get()
    {

        $response = [];
        $list     = $this->gestion->GetAllPagesParent();
        foreach ($list as $row) {

            $response[] = [
                'id'     => $row->id,
                'title'  => "<a href='" . base_url() . "gestion/#/app/pages_content/" . $row->id . "'>" . $row->title . "</a>",
                'supp'   => "<button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>",
                'ticked' => false
            ];
        }

        $this->response(['aaData' => $response]);

    }

    public function check_session_get()
    {
        if ($this->session->userdata('logged')) {
            $this->response(['status' => true, 'reponse' => true], 200);
        } else {
            $this->response(['status' => false, 'reponse' => false], 200);
        }
    }


    function _unique_field_name($field_name)
    {

        return random_string('alnum', 20);

    }

    public function add_file_temoin_post()
    {

        if (isset($_FILES["file"]["name"])) {

            $allowedExts = ["gif", "jpeg", "jpg", "png", "docx", "doc", "pdf"];

            $temp = explode(".", $_FILES["file"]["name"]);

            $extension = end($temp);

            $_FILES["file"]["name"] = $this->_unique_field_name($_FILES["file"]["name"]);


            $_FILES["file"]["name"] .= "." . $extension;

            if ($_FILES["file"]["error"] > 0) {

                echo "Return Code: " . $_FILES["file"]["error"] . "<br>";

            } else {

                if ($this->s3file->file_exists("upload/temoignages/" . $_FILES["file"]["name"])) {

                    $this->s3file->unlink("upload/temoignages/" . $_FILES["file"]["name"]);

                }

                $this->s3file->move_uploaded_file($_FILES["file"]["tmp_name"], "upload/temoignages/" . $_FILES["file"]["name"]);

                $field_name = $_FILES["file"]["name"];

            }
            $this->response(['status' => true, 'file' => $field_name], 200);

        }

    }

    public function add_file_covertures_post()
    {

        if (isset($_FILES["file"]["name"])) {

            $allowedExts = ["gif", "jpeg", "jpg", "png", "docx", "doc", "pdf"];

            $temp = explode(".", $_FILES["file"]["name"]);

            $extension = end($temp);

            $_FILES["file"]["name"] = $this->_unique_field_name($_FILES["file"]["name"]);


            $_FILES["file"]["name"] .= "." . $extension;

            if ($_FILES["file"]["error"] > 0) {

                echo "Return Code: " . $_FILES["file"]["error"] . "<br>";

            } else {

                if ($this->s3file->file_exists("upload/covertures/" . $_FILES["file"]["name"])) {

                    $this->s3file->unlink("upload/covertures/" . $_FILES["file"]["name"]);

                }

                $this->s3file->move_uploaded_file($_FILES["file"]["tmp_name"], "upload/covertures/" . $_FILES["file"]["name"]);

                $field_name = $_FILES["file"]["name"];

            }
            $this->response(['status' => true, 'file' => $field_name], 200);

        }

    }

    public function add_file_post()
    {

        if (isset($_FILES["file"]["name"])) {

            $allowedExts = ["gif", "jpeg", "jpg", "png", "docx", "doc", "pdf"];

            $temp = explode(".", $_FILES["file"]["name"]);

            $extension = end($temp);

            $_FILES["file"]["name"] = $this->_unique_field_name($_FILES["file"]["name"]);


            $_FILES["file"]["name"] .= "." . $extension;

            if ($_FILES["file"]["error"] > 0) {

                echo "Return Code: " . $_FILES["file"]["error"] . "<br>";

            } else {

                if ($this->s3file->file_exists("upload/categories/" . $_FILES["file"]["name"])) {

                    $this->s3file->unlink("upload/categories/" . $_FILES["file"]["name"]);

                }

                $this->s3file->move_uploaded_file($_FILES["file"]["tmp_name"], "upload/categories/" . $_FILES["file"]["name"]);

                $field_name = $_FILES["file"]["name"];

            }
            $this->response(['status' => true, 'file' => $field_name], 200);

        }

    }

    public function add_file_talent_post()
    {

        if (isset($_FILES["file"]["name"])) {

            $allowedExts = ["gif", "jpeg", "jpg", "png", "docx", "doc", "pdf"];

            $temp = explode(".", $_FILES["file"]["name"]);

            $extension = end($temp);

            $_FILES["file"]["name"] = $this->_unique_field_name($_FILES["file"]["name"]);


            $_FILES["file"]["name"] .= "." . $extension;

            if ($_FILES["file"]["error"] > 0) {

                echo "Return Code: " . $_FILES["file"]["error"] . "<br>";

            } else {

                if ($this->s3file->file_exists("upload/talents/" . $_FILES["file"]["name"])) {

                    $this->s3file->unlink("upload/talents/" . $_FILES["file"]["name"]);

                }

                $this->s3file->move_uploaded_file($_FILES["file"]["tmp_name"], "upload/talents/" . $_FILES["file"]["name"]);

                $field_name = $_FILES["file"]["name"];

            }
            $this->response(['status' => true, 'file' => $field_name], 200);

        }

    }

    /**
     *
     */
    public function connexion_post()
    {
        $email    = trim($this->post('login'));
        $password = trim($this->post('password'));

        if (!$email || !$password) {
            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);
        }

        $Administrateur = $this->ModelGestion->Authentificate($email, $password);

        if ($Administrateur != null && $Administrateur instanceof StdClass) {
            $data_session = [
                'email' => $Administrateur->email,
                'nom'   => $Administrateur->nom . " " . $Administrateur->prenom,
                'id'    => $Administrateur->id
            ];
            $this->session->set_userdata('logged', $data_session); // stocker la session
            $this->response(['status' => true, 'reponse_request' => $Administrateur], 200);
        } else {
            $this->response(['status' => false, 'error_message' => 'No find Admin user.'], 200);
        }
    }

    public function photo_coeur_talent_post()
    {

        if ($this->post('id')) {

            $data['photo_coup_de_coeur'] = $this->post('photo_coup_de_coeur');
            $this->gestion->EditerElement($this->post('id'), $data, "talent");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }
    }

    public function activer_talent_post()
    {

        if ($this->post('id')) {

            $data['status'] = 1;
            $this->gestion->EditerElement($this->post('id'), $data, "talent");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function statut_admin_post()
    {
        if ($this->post('id')) {

            $data['statut_admin'] = $this->post('statut_admin');
            $this->gestion->EditerElement($this->post('id'), $data, "talent");
            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);
        }
    }

    public function statut_admin_accepter_post()
    {
        if ($this->post('id')) {

            $data_a['statut_admin'] = "Accepté";
            $data_a['status']       = true;
            $this->gestion->EditerElement($this->post('id'), $data_a, "talent");
            /*send message*/
            $this->load->model('messagerie_model', 'msg');
            $result                = $this->msg->existenceConversation($this->post("id"), 0, 0);
            $data['user_id_send']  = 0;
            $data['user_id_recep'] = $this->post('user_id');
            $this->load->library('user_info');
            $txt                      = $this->user_info->getconfig(35);
            $new_txt                  = str_replace("{{name}}", $this->post('titre'), $txt);
            $data["text"]             = $new_txt;
            $data["id_conversations"] = $result;
            $this->msg->AddConversation($data);
            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);
        }
    }

    public function statut_admin_refuser_post()
    {
        if ($this->post('id')) {

            $data_a['statut_admin'] = "Refusé";
            $this->gestion->EditerElement($this->post('id'), $data_a, "talent");
            /*send message*/
            $this->load->model('messagerie_model', 'msg');
            $result                = $this->msg->existenceConversation($this->post("id"), 0, 0);
            $data['user_id_send']  = 0;
            $data['user_id_recep'] = $this->post('user_id');
            $this->load->library('user_info');
            $txt                      = $this->user_info->getconfig(36);
            $new_txt                  = str_replace("{{name}}", $this->post('titre'), $txt);
            $new_txt                  .= "<br> " . $this->post('raison_refuser');
            $data["text"]             = $new_txt;
            $data["id_conversations"] = $result;
            $this->msg->AddConversation($data);
            $this->load->library('mailing');
            $data['email'] = $this->post('email');
            $this->mailing->refuserTalent($data);

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);
        }
    }

    public function ajouter_coup_post()
    {

        if ($this->post('id')) {

            $data['coup_des_cour'] = 1;
            $this->gestion->EditerElement($this->post('id'), $data, "talent");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function delete_coup_post()
    {

        if ($this->post('id')) {

            $data['coup_des_cour'] = 0;
            $this->gestion->EditerElement($this->post('id'), $data, "talent");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function desactiver_talent_post()
    {

        if ($this->post('id')) {

            $data['status'] = 0;
            $this->gestion->EditerElement($this->post('id'), $data, "talent");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function coup_talent_post()
    {

        if ($this->post('id')) {

            $data['coup_des_cour'] = 0;
            $this->gestion->EditerElement($this->post('id'), $data, "talent");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function talents_get($id = null)
    {
        $rows_results = [];
        if (!$id) {

            $this->response(['data' => $rows_results]);
        }

        $conf = ['table' => 'talent', 'column' => 'user_id', 'id' => $id];
        $list = $this->gestion->GetAllResultsElements($conf);

        foreach ($list as $row) {

            $rows_results[] = [
                'id'           => $row->id,
                'titre'        => $row->titre,
                'prix'         => $row->prix,
                'profession'   => $row->profession,
                'prix_journee' => $row->prix_journee,
                'prix_forfait' => $row->prix_forfait,
                'photo'        => '<img src="' . base_url() . 'upload/talents/' . $row->cover . '" width="60px"/>',
                'coup'         => $row->coup_des_cour == 0 ? "<a onclick=\"angular.element(this).scope().ajouter_coup(" . $row->id . ")\" style='color:blue;'>Non</a>" : "<a onclick=\"angular.element(this).scope().delete_coup(" . $row->id . ")\" style='color:red;'>Oui</a>",
                'active'       => $row->status == 0 ? "<a onclick=\"angular.element(this).scope().activer_talent(" . $row->id . ")\" style='color:blue;'>Activer</a>" : "<a onclick=\"angular.element(this).scope().desactiver_talent(" . $row->id . ")\" style='color:red;'>désactiver</a>",


            ];
        }

        $this->response(['data' => $rows_results]);
    }

    /*get all annonces*/
    public function coup_de_coeur_get()
    {
        $rows_results = [];
        $list         = $this->gestion->GetAllCoupDeCoeur();
        foreach ($list as $row) {
            $rows_results[] = [
                'id'            => $row->id,
                'titre'         => $row->titre,
                'prix'          => $row->prix,
                'ville'         => $row->ville,
                'statut'        => $row->statut_admin,
                'image_coup'    => "<img height='100' width='100' src='" . $this->s3file->getUrl($this->config->item('upload_talents') . $row->photo_coup_de_coeur) . "'>",
                'date_creation' => $row->date_creation,
                'email'         => $row->email,
                'nom'           => $row->nom,
                'prenom'        => $row->prenom,
                'tel'           => $row->tel,
                'active'        => $row->status == 0 ? "<a onclick=\"angular.element(this).scope().activer_talent(" . $row->id . ")\" style='color:blue;'>Activer</a>" : "<a onclick=\"angular.element(this).scope().desactiver_talent(" . $row->id . ")\" style='color:red;'>désactiver</a>",
                'supp'          => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimerCoup(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button>
				 <a href='" . base_url() . "gestion/#/app/coup_de_coeur/" . $row->id . "' class='btn btn-sm btn-icon btn-info' ><i class='fa icon-eye'></i></a>
				 ",

            ];
        }

        $this->response(['data' => $rows_results]);
    }

    public function annonces_get()
    {
        $rows_results = [];
        $list         = $this->gestion->GetAllAnnonces();
        foreach ($list as $row) {
            $rows_results[] = [
                'id'     => $row->id,
                'titre'  => $row->titre,
                'prix'   => $row->prix,
                'ville'  => $row->ville,
                'statut' => $row->statut_admin,

                'date_creation' => $row->date_creation,
                'email'         => $row->email,
                'nom'           => $row->nom,
                'prenom'        => $row->prenom,
                'tel'           => $row->tel,
                'active'        => $row->status == 0 ? "<a onclick=\"angular.element(this).scope().activer_talent(" . $row->id . ")\" style='color:blue;'>Activer</a>" : "<a onclick=\"angular.element(this).scope().desactiver_talent(" . $row->id . ")\" style='color:red;'>désactiver</a>",
                'supp'          => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button>
				 <a href='" . base_url() . "gestion/#/app/annonces/" . $row->id . "' class='btn btn-sm btn-icon btn-info' ><i class='fa icon-eye'></i></a>
				 ",

            ];
        }

        $this->response(['data' => $rows_results]);
    }

    public function annonces_one_get($id = null)
    {
        $rows_results = [];
        if (!$id) {

            $this->response(['data' => $rows_results]);
        }
        $this->load->model('talent_model', 'talent');
        $annonce    = $this->gestion->getAnnonceById($id);
        $langues    = $this->talent->GetLangues($id);
        $tags       = $this->talent->GetTags($id);
        $portfolio  = $this->talent->GetPortfolio($id);
        $documents  = $this->talent->GetDocuments($id);
        $disponible = $this->talent->GetDisponibleOftalent($id);

        $formations  = $this->talent->GetFormations($id);
        $experiences = $this->talent->GetExperiencesWithEntrepise($id);

        $img = [];
        foreach ($portfolio as $key => $port) {
            $img[] = ["image" => base_url($this->config->item('upload_portfolio') . $port->image)];
        }
        $doc = [];
        foreach ($documents as $key => $doc_) {
            $doc[] = ["fichier" => base_url($this->config->item('upload_portfolio') . $doc_->document)];
        }

        $this->response([
            "experiences" => $experiences,
            "formations"  => $formations,
            'annonce'     => $annonce,
            "langues"     => $langues,
            "tags"        => $tags,
            "portfolio"   => $img,
            "documents"   => $doc,
            "disponibles" => $disponible
        ]);
    }

    public function users_get()
    {

        $list = $this->gestion->GetDataUsers();
        foreach ($list as $row) {
            $supp = " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button>
				 <a href='#/app/utilisateur/" . $row->id . "' class='btn btn-sm btn-icon btn-info' ><i class='fa icon-eye'></i></a>
				 <a href='#/app/utilisateur_editer/" . $row->id . "' class='btn btn-sm btn-icon btn-info' ><i class='fa icon-pencil'></i></a>
				 ";
            if ($row->id == 0) {
                $supp = "<a href='#/app/utilisateur/" . $row->id . "' class='btn btn-sm btn-icon btn-info' ><i class='fa icon-eye'></i></a>
				 ";
            }
            $conf     = ['table' => 'talent', 'column' => 'user_id', 'id' => $row->id];
            $list_ann = $this->gestion->GetAllResultsElements($conf);
            $annonce  = "Non";
            if (count($list_ann) > 0) {
                $annonce = "Oui";
            }
            $rows_results[] = [
                'id'             => $row->id,
                'nom'            => $row->nom . ' ' . $row->prenom,
                'email'          => $row->email,
                'tel'            => $row->tel,
                'annonce'        => $annonce,
                'date_naissance' => $row->date_naissance,
                'active'         => $row->email_verified == 0 ? "<a onclick=\"angular.element(this).scope().activer(" . $row->id . ")\" style='color:blue;'>Activer</a>" : "<a onclick=\"angular.element(this).scope().desactiver(" . $row->id . ")\" style='color:red;'>désactiver</a>",
                'talent'         => "<a href='#/app/talents/" . $row->id . "' style='color:blue;'>Voir</a>",

                'supp' => $supp,

            ];
        }

        $this->response(['data' => $rows_results]);
    }

    public function editer_user_post()
    {

        if ($this->post('id')) {

            $data['nom']        = $this->post('nom');
            $data['prenom']     = $this->post('prenom');
            $data['biographie'] = $this->post('biographie');
            $data['adresse']    = $this->post('adresse');
            $data['email']      = $this->post('email');
            $data['tel']        = $this->post('tel');
            $data['sexe']       = $this->post('sexe');
            $this->gestion->EditerElement($this->post('id'), $data, "user");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function users_sans_annonce_get()
    {

        $list = $this->gestion->GetDataUsers();
        foreach ($list as $row) {
            $conf     = ['table' => 'talent', 'column' => 'user_id', 'id' => $row->id];
            $list_ann = $this->gestion->GetAllResultsElements($conf);
            $annonce  = "Non";
            if (count($list_ann) != 0) {
                continue;
            }
            $rows_results[] = [
                'id'             => $row->id,
                'nom'            => $row->nom . '&nbsp;' . $row->prenom,
                'email'          => $row->email,
                'tel'            => $row->tel,
                'annonce'        => $annonce,
                'date_naissance' => $row->date_naissance,
                'active'         => $row->email_verified == 0 ? "<a onclick=\"angular.element(this).scope().activer(" . $row->id . ")\" style='color:blue;'>Activer</a>" : "<a onclick=\"angular.element(this).scope().desactiver(" . $row->id . ")\" style='color:red;'>désactiver</a>",
                'talent'         => "<a href='#/app/talents/" . $row->id . "' style='color:blue;'>Voir</a>",

                'supp' => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button>
				 <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().detail(" . $row->id . "," . $row->alias . ")\"><i class='fa icon-eye'></i></button>
				 ",

            ];
        }

        $this->response(['data' => $rows_results]);
    }

    public function users_with_annonce_get()
    {

        $list = $this->gestion->GetDataUsers();
        foreach ($list as $row) {
            $conf     = ['table' => 'talent', 'column' => 'user_id', 'id' => $row->id];
            $list_ann = $this->gestion->GetAllResultsElements($conf);
            $annonce  = "Oui";
            if (count($list_ann) == 0) {
                continue;
            }
            $rows_results[] = [
                'id'             => $row->id,
                'nom'            => $row->nom . '&nbsp;' . $row->prenom,
                'email'          => $row->email,
                'tel'            => $row->tel,
                'annonce'        => $annonce,
                'date_naissance' => $row->date_naissance,
                'active'         => $row->email_verified == 0 ? "<a onclick=\"angular.element(this).scope().activer(" . $row->id . ")\" style='color:blue;'>Activer</a>" : "<a onclick=\"angular.element(this).scope().desactiver(" . $row->id . ")\" style='color:red;'>désactiver</a>",
                'talent'         => "<a href='#/app/talents/" . $row->id . "' style='color:blue;'>Voir</a>",

                'supp' => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button>
				 <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().detail(" . $row->id . "," . $row->alias . ")\"><i class='fa icon-eye'></i></button>
				 ",

            ];
        }

        $this->response(['data' => $rows_results]);
    }

    public function activer_post()
    {

        if ($this->post('id')) {

            $data['email_verified'] = 1;
            $this->gestion->EditerElement($this->post('id'), $data, "user");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }


    public function desactiver_post()
    {

        if ($this->post('id')) {

            $data['email_verified'] = 0;
            $this->gestion->EditerElement($this->post('id'), $data, "user");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function users_delete_post()

    {
        if ($this->post('id')) {

            $this->gestion->DeleteElement($this->post('id'), "user");

            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);

        }

    }

    public function talent_delete_post()

    {
        if ($this->post('id')) {

            $this->gestion->DeleteElement($this->post('id'), "talent");

            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);

        }

    }

    public function GetInfoUsers_get($id = null)
    {
        if (!$id) {

            //$this->response(array('status' => false, 'error_message' => 'No ID was provided.'), 400);

        }

        $row = $this->gestion->GetOneElement($id, "user");

        if ($row) {

            $this->response(['status' => true, 'reponse' => $row], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function GetInfoConfig_get($id = null)
    {
        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "config");

        if ($row) {


            $rows = [
                'name'  => $row->name,
                'alias' => $row->alias,
                'type'  => $row->type,
                'value' => htmlspecialchars_decode($row->value, ENT_NOQUOTES)
            ];

            $this->response(['status' => true, 'reponse' => $rows], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function editer_config_post()
    {

        if ($this->post('id')) {

            $data['name'] = $this->post('nom');
            //$data['alias']=$this->post('alias');
            $data['value'] = $this->post('value', false);

            $this->gestion->EditerElement($this->post('id'), $data, "config");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function config_get()
    {


        $list = $this->gestion->GetDataConfig();
        foreach ($list as $row) {

            $rows_results[] = [
                'id'    => $row->id,
                'nom'   => $row->name,
                'alias' => $row->alias,
                //'value' =>$row->value,
                'type'  => $row->type == 1 ? 'input text' : 'wysiwyg ',


                'supp' => $row->type == 3 ? "<button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer1(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>" : "<button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>",

            ];
        }

        $this->response(['data' => $rows_results]);
    }

    public function souscategorie_get($id = null)
    {

        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);
        }

        $conf         = ['table' => 'categorie', 'column' => 'categorie_group_id', 'id' => $id];
        $list         = $this->gestion->GetAllResultsElements($conf);
        $rows_results = [];
        foreach ($list as $row) {

            $rows_results[] = [
                'id'     => $row->id,
                'nom'    => $row->nom,
                'active' => $row->active == 1 ? 'Oui' : 'Non',

                'supp' => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button> <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>",

            ];
        }

        $this->response(['data' => $rows_results]);
    }

    public function souscategorie1_get($id = null)
    {

        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);
        }


        $list         = $this->gestion->getFonctionsDepart($id);
        $rows_results = [];
        foreach ($list as $row) {

            $rows_results[] = [
                'id'  => $row->id,
                'nom' => $row->name,

                'supp' => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button>"

            ];
        }

        $this->response(['data' => $rows_results]);
    }

    public function ajouter_data_souscategorie_post()

    {
        $data['nom']                = $this->post('nom');
        $data['categorie_group_id'] = $this->post('categorie_group_id');

        $data['active'] = $this->post('active');

        $this->gestion->AddElement($data, "categorie");
        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }

    public function ajouter_data_departement_fonction_post()

    {

        $data_fd['departement_id'] = $this->post('fonction');
        $data_fd['fonction_id']    = $this->post('departement_id');
        $this->gestion->AddElement($data_fd, "departement_fonctions");
        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }

    public function ajouter_data_souscategorie1_post()

    {
        $data['nom']                = $this->post('nom');
        $data['categorie_group_id'] = $this->post('categorie_group_id');
        $data['active']             = $this->post('active');
        $id                         = $this->gestion->AddElement($data, "categorie");
        /*			    foreach ($this->post('fonction') as $key => $value){
			    $data_fd['fonction_id']=$id;
			    $data_fd['departement_id']=$value;
				$this->gestion->AddElement($data_fd,"departement_fonctions");
			    }*/

        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }

    public function couvertures_delete_post()

    {

        if ($this->post('id')) {

            $this->gestion->DeleteElement($this->post('id'), "covertures");

            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);

        }

    }

    public function bloc_delete_post()

    {

        if ($this->post('id')) {
            $this->gestion->DeleteElement($this->post('id'), "block_site");
            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);
        }

    }

    public function temoin_delete_post()

    {

        if ($this->post('id')) {
            $this->gestion->DeleteElement($this->post('id'), "temoignage");
            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);
        }

    }

    public function entreprise_delete_post()

    {

        if ($this->post('id')) {
            $this->gestion->DeleteElement($this->post('id'), "entreprise");
            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);
        }

    }

    public function parlent_delete_post()

    {

        if ($this->post('id')) {
            $this->gestion->DeleteElement($this->post('id'), "parlents");
            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);
        }

    }

    public function GetInfoCouvertures_get($id = null)
    {
        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "covertures");

        if ($row) {


            $result['image'] = $row->image;


            $this->response(['status' => true, 'reponse' => $result], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function GetInfoTemoin_get($id = null)
    {
        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "temoignage");

        if ($row) {


            $result['image'] = $row->image;


            $this->response(['status' => true, 'reponse' => $row], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function GetInfoBloc_get($id = null)
    {
        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "block_site");

        if ($row) {


            $result['image'] = $row->image;


            $this->response(['status' => true, 'reponse' => $row], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function GetInfoEntreprise_get($id = null)
    {
        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "entreprise");

        if ($row) {


            $result['image'] = $row->logo;


            $this->response(['status' => true, 'reponse' => $row], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function GetInfoParlent_get($id = null)
    {
        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "parlents");

        if ($row) {


            $result['image'] = $row->image;


            $this->response(['status' => true, 'reponse' => $row], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function temoignages_get()
    {
        $list         = $this->gestion->GetDataTemoignages();
        $rows_results = [];
        foreach ($list as $row) {

            $rows_results[] = [
                'id'          => $row->id,
                'user'        => $row->user,
                'titre'       => $row->titre,
                'type'        => $row->type,
                'description' => $row->description,
                'photo'       => '<img src="' . base_url() . 'upload/temoignages/' . $row->image . '" width="70px"/>',
                'supp'        => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button> <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>",

            ];
        }
        $this->response(['data' => $rows_results]);
    }

    public function blocks_get()
    {
        $list         = $this->gestion->GetDataBlocks();
        $rows_results = [];
        foreach ($list as $row) {

            $rows_results[] = [
                'id'          => $row->id,
                'titre'       => $row->titre,
                'description' => $row->description,
                'photo'       => '<img src="' . base_url() . 'upload/temoignages/' . $row->image . '" width="70px"/>',
                'supp'        => " <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>",

            ];
        }
        $this->response(['data' => $rows_results]);
    }

    public function entreprises_get()
    {
        $Entreprises  = $this->ModelGestion->getStatusUserByEntreprises();
        $rows_results = [];
        foreach ($Entreprises as $key => $Entreprise) {
            $rows_results[$Entreprise->id]['id']    = $Entreprise->id;
            $rows_results[$Entreprise->id]['nom']   = $Entreprise->nom;
            $rows_results[$Entreprise->id]['photo'] = '<img src="' . $Entreprise->logo . '" width="70px"/>';
            if (isset($rows_results[$Entreprise->id]['nbr_candidat']) == false) {
                $rows_results[$Entreprise->id]['nbr_candidat'] = 0;
            }
            if (isset($rows_results[$Entreprise->id]['nbr_mentor']) == false) {
                $rows_results[$Entreprise->id]['nbr_mentor'] = 0;
            }
            if ($Entreprise->status == '0') {
                $rows_results[$Entreprise->id]['nbr_candidat'] = $rows_results[$Entreprise->id]['nbr_candidat'] + 1;
            }
            if ($Entreprise->status == '1') {
                $rows_results[$Entreprise->id]['nbr_mentor'] = $rows_results[$Entreprise->id]['nbr_mentor'] + 1;
            }
        }

        $key_count          = 0;
        $entreprises_export = [];
        foreach ($rows_results as $id_entreprise => $rows_result) {
            $entreprises_export[$key_count++] = $rows_result;
        }

        $this->response(['data' => $entreprises_export]);
    }

    public function entreprises_export_get()
    {
        $Entreprises  = $this->ModelGestion->getStatusUserByEntreprises();
        $rows_results = [];
        foreach ($Entreprises as $key => $Entreprise) {
            $rows_results[$Entreprise->id]['id']    = $Entreprise->id;
            $rows_results[$Entreprise->id]['nom']   = $Entreprise->nom;
            $rows_results[$Entreprise->id]['photo'] = '<img src="' . $Entreprise->logo . '" width="70px"/>';
            if (isset($rows_results[$Entreprise->id]['nbr_candidat']) == false) {
                $rows_results[$Entreprise->id]['nbr_candidat'] = 0;
            }
            if (isset($rows_results[$Entreprise->id]['nbr_mentor']) == false) {
                $rows_results[$Entreprise->id]['nbr_mentor'] = 0;
            }
            if ($Entreprise->status == '0') {
                $rows_results[$Entreprise->id]['nbr_candidat'] = $rows_results[$Entreprise->id]['nbr_candidat'] + 1;
            }
            if ($Entreprise->status == '1') {
                $rows_results[$Entreprise->id]['nbr_mentor'] = $rows_results[$Entreprise->id]['nbr_mentor'] + 1;
            }
        }

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=entreprises.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-Transfer-Encoding: UTF-8");

        echo utf8_decode(
            "Nom entreprise;"
            . "Nombre candidats;"
            . "Nombre mentors;"
            . "Total;"
            . "\n");

        foreach ($rows_results as $id_entreprise => $entreprise) {
            echo utf8_decode(str_replace(';', ',', $entreprise['nom']) . ";"
                . $entreprise['nbr_candidat'] . ";"
                . $entreprise['nbr_mentor'] . ";"
                . ($entreprise['nbr_candidat'] + $entreprise['nbr_mentor']) . ";"
                . "\n");
        }

        die();
    }

    public function secteurs_get()
    {
        $Secteurs     = $this->ModelGestion->getStatusUserBySecteurs();
        $rows_results = [];
        foreach ($Secteurs as $key => $Secteur) {
            $rows_results[$Secteur->id]['id']  = $Secteur->id;
            $rows_results[$Secteur->id]['nom'] = $Secteur->nom;
            if (isset($rows_results[$Secteur->id]['nbr_candidat']) == false) {
                $rows_results[$Secteur->id]['nbr_candidat'] = 0;
            }
            if (isset($rows_results[$Secteur->id]['nbr_mentor']) == false) {
                $rows_results[$Secteur->id]['nbr_mentor'] = 0;
            }
            if ($Secteur->status == '0') {
                $rows_results[$Secteur->id]['nbr_candidat'] = $rows_results[$Secteur->id]['nbr_candidat'] + 1;
            }
            if ($Secteur->status == '1') {
                $rows_results[$Secteur->id]['nbr_mentor'] = $rows_results[$Secteur->id]['nbr_mentor'] + 1;
            }
        }

        $key_count       = 0;
        $secteurs_export = [];
        foreach ($rows_results as $id_secteur => $rows_result) {
            $secteurs_export[$key_count++] = $rows_result;
        }

        $this->response(['data' => $secteurs_export]);
    }

    public function secteurs_export_get()
    {
        $Secteurs     = $this->ModelGestion->getStatusUserBySecteurs();
        $rows_results = [];
        foreach ($Secteurs as $key => $Secteur) {
            $rows_results[$Secteur->id]['id']  = $Secteur->id;
            $rows_results[$Secteur->id]['nom'] = $Secteur->nom;
            if (isset($rows_results[$Secteur->id]['nbr_candidat']) == false) {
                $rows_results[$Secteur->id]['nbr_candidat'] = 0;
            }
            if (isset($rows_results[$Secteur->id]['nbr_mentor']) == false) {
                $rows_results[$Secteur->id]['nbr_mentor'] = 0;
            }
            if ($Secteur->status == '0') {
                $rows_results[$Secteur->id]['nbr_candidat'] = $rows_results[$Secteur->id]['nbr_candidat'] + 1;
            }
            if ($Secteur->status == '1') {
                $rows_results[$Secteur->id]['nbr_mentor'] = $rows_results[$Secteur->id]['nbr_mentor'] + 1;
            }
        }

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=secteurs.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-Transfer-Encoding: UTF-8");

        echo utf8_decode(
            "Nom secteur;"
            . "Nombre candidats;"
            . "Nombre mentors;"
            . "Total;"
            . "\n");

        foreach ($rows_results as $id_secteur => $secteur) {
            echo utf8_decode(str_replace(';', ',', $secteur['nom']) . ";"
                . $secteur['nbr_candidat'] . ";"
                . $secteur['nbr_mentor'] . ";"
                . ($secteur['nbr_candidat'] + $secteur['nbr_mentor']) . ";"
                . "\n");
        }

        die();
    }

    public function departements_get()
    {
        $Departements = $this->ModelGestion->getStatusUserByDepartements();
        $rows_results = [];
        foreach ($Departements as $key => $Departement) {
            $rows_results[$Departement->id]['id']  = $Departement->id;
            $rows_results[$Departement->id]['nom'] = $Departement->nom;
            if (isset($rows_results[$Departement->id]['nbr_candidat']) == false) {
                $rows_results[$Departement->id]['nbr_candidat'] = 0;
            }
            if (isset($rows_results[$Departement->id]['nbr_mentor']) == false) {
                $rows_results[$Departement->id]['nbr_mentor'] = 0;
            }
            if ($Departement->status == '0') {
                $rows_results[$Departement->id]['nbr_candidat'] = $rows_results[$Departement->id]['nbr_candidat'] + 1;
            }
            if ($Departement->status == '1') {
                $rows_results[$Departement->id]['nbr_mentor'] = $rows_results[$Departement->id]['nbr_mentor'] + 1;
            }
        }

        $key_count           = 0;
        $departements_export = [];
        foreach ($rows_results as $id_departement => $rows_result) {
            $departements_export[$key_count++] = $rows_result;
        }

        $this->response(['data' => $departements_export]);
    }

    public function departements_export_get()
    {
        $Secteurs     = $this->ModelGestion->getStatusUserByDepartements();
        $rows_results = [];
        foreach ($Secteurs as $key => $Secteur) {
            $rows_results[$Secteur->id]['id']  = $Secteur->id;
            $rows_results[$Secteur->id]['nom'] = $Secteur->nom;
            if (isset($rows_results[$Secteur->id]['nbr_candidat']) == false) {
                $rows_results[$Secteur->id]['nbr_candidat'] = 0;
            }
            if (isset($rows_results[$Secteur->id]['nbr_mentor']) == false) {
                $rows_results[$Secteur->id]['nbr_mentor'] = 0;
            }
            if ($Secteur->status == '0') {
                $rows_results[$Secteur->id]['nbr_candidat'] = $rows_results[$Secteur->id]['nbr_candidat'] + 1;
            }
            if ($Secteur->status == '1') {
                $rows_results[$Secteur->id]['nbr_mentor'] = $rows_results[$Secteur->id]['nbr_mentor'] + 1;
            }
        }

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=departements.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-Transfer-Encoding: UTF-8");

        echo utf8_decode(
            "Nom secteur;"
            . "Nombre candidats;"
            . "Nombre mentors;"
            . "Total;"
            . "\n");

        foreach ($rows_results as $id_departement => $departement) {
            echo utf8_decode(str_replace(';', ',', $departement['nom']) . ";"
                . $departement['nbr_candidat'] . ";"
                . $departement['nbr_mentor'] . ";"
                . ($departement['nbr_candidat'] + $departement['nbr_mentor']) . ";"
                . "\n");
        }

        die();
    }

    public function fonctions_get()
    {
        $Fonctions    = $this->ModelGestion->getStatusUserByFonctions();
        $rows_results = [];
        foreach ($Fonctions as $key => $Fonction) {
            $rows_results[$Fonction->id]['id']  = $Fonction->id;
            $rows_results[$Fonction->id]['nom'] = $Fonction->nom;
            if (isset($rows_results[$Fonction->id]['nbr_candidat']) == false) {
                $rows_results[$Fonction->id]['nbr_candidat'] = 0;
            }
            if (isset($rows_results[$Fonction->id]['nbr_mentor']) == false) {
                $rows_results[$Fonction->id]['nbr_mentor'] = 0;
            }
            if ($Fonction->status == '0') {
                $rows_results[$Fonction->id]['nbr_candidat'] = $rows_results[$Fonction->id]['nbr_candidat'] + 1;
            }
            if ($Fonction->status == '1') {
                $rows_results[$Fonction->id]['nbr_mentor'] = $rows_results[$Fonction->id]['nbr_mentor'] + 1;
            }
        }

        $key_count        = 0;
        $fonctions_export = [];
        foreach ($rows_results as $id_fonction => $rows_result) {
            $fonctions_export[$key_count++] = $rows_result;
        }

        $this->response(['data' => $fonctions_export]);
    }

    public function fonctions_export_get()
    {
        $Fonctions    = $this->ModelGestion->getStatusUserByFonctions();
        $rows_results = [];
        foreach ($Fonctions as $key => $Fonction) {
            $rows_results[$Fonction->id]['id']  = $Fonction->id;
            $rows_results[$Fonction->id]['nom'] = $Fonction->nom;
            if (isset($rows_results[$Fonction->id]['nbr_candidat']) == false) {
                $rows_results[$Fonction->id]['nbr_candidat'] = 0;
            }
            if (isset($rows_results[$Fonction->id]['nbr_mentor']) == false) {
                $rows_results[$Fonction->id]['nbr_mentor'] = 0;
            }
            if ($Fonction->status == '0') {
                $rows_results[$Fonction->id]['nbr_candidat'] = $rows_results[$Fonction->id]['nbr_candidat'] + 1;
            }
            if ($Fonction->status == '1') {
                $rows_results[$Fonction->id]['nbr_mentor'] = $rows_results[$Fonction->id]['nbr_mentor'] + 1;
            }
        }

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=fonctions.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-Transfer-Encoding: UTF-8");

        echo utf8_decode(
            "Nom secteur;"
            . "Nombre candidats;"
            . "Nombre mentors;"
            . "Total;"
            . "\n");

        foreach ($rows_results as $id_fonction => $fonction) {
            echo utf8_decode(str_replace(';', ',', $fonction['nom']) . ";"
                . $fonction['nbr_candidat'] . ";"
                . $fonction['nbr_mentor'] . ";"
                . ($fonction['nbr_candidat'] + $fonction['nbr_mentor']) . ";"
                . "\n");
        }

        die();
    }

    public function parlents_get()
    {
        $list         = $this->gestion->GetDataParlents();
        $rows_results = [];
        foreach ($list as $row) {
            $rows_results[] = [
                'id'    => $row->id,
                'titre' => $row->titre,
                'link'  => $row->link,
                'type'  => $row->type,
                'photo' => '<img src="' . base_url() . 'upload/temoignages/' . $row->image . '" width="70px"/>',
                'supp'  => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button> <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>",

            ];
        }
        $this->response(['data' => $rows_results]);
    }

    public function ajouter_data_bloc_post()

    {
        $data['image']       = $this->post('photo');
        $data['titre']       = $this->post('titre');
        $data['description'] = $this->post('description');
        $this->gestion->AddElement($data, "block_site");
        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }

    public function ajouter_data_temoin_post()

    {
        $data['image']       = $this->post('photo');
        $data['titre']       = $this->post('titre');
        $data['user']        = $this->post('user');
        $data['description'] = $this->post('description');
        $data['type']        = $this->post('type');

        $this->gestion->AddElement($data, "temoignage");
        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }

    public function ajouter_data_parlent_post()

    {
        $data['image'] = $this->post('photo');
        $data['titre'] = $this->post('titre');
        $data['link']  = $this->post('link');

        $data['type'] = $this->post('type');

        $this->gestion->AddElement($data, "parlents");
        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }

    public function editer_temoin_post()
    {

        if ($this->post('id')) {


            $data['image']       = $this->post('photo');
            $data['titre']       = $this->post('titre');
            $data['user']        = $this->post('user');
            $data['description'] = $this->post('description');
            $data['type']        = $this->post('type');

            $this->gestion->EditerElement($this->post('id'), $data, "temoignage");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function editer_bloc_post()
    {

        if ($this->post('id')) {


            $data['image'] = $this->post('photo');
            $data['titre'] = $this->post('titre');

            $data['description'] = $this->post('description');


            $this->gestion->EditerElement($this->post('id'), $data, "block_site");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function editer_parlent_post()
    {

        if ($this->post('id')) {


            $data['image'] = $this->post('photo');
            $data['titre'] = $this->post('titre');
            $data['link']  = $this->post('link');

            $data['type'] = $this->post('type');

            $this->gestion->EditerElement($this->post('id'), $data, "parlents");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function souscategorie_delete_post()

    {

        if ($this->post('id')) {

            $this->gestion->DeleteElement($this->post('id'), "categorie");

            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);

        }

    }

    public function departement_fonction_delete_post()

    {

        if ($this->post('id')) {

            $this->gestion->DeleteElement($this->post('id'), "departement_fonctions");

            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);

        }

    }

    public function GetInfoSousCategorie_get($id = null)
    {
        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "categorie");

        if ($row) {

            $result['nom'] = $row->nom;

            $result['active'] = $row->active;
            $lis              = $this->gestion->getDepartFonctions($id);
            $rows_results     = [];
            foreach ($lis as $row) {
                $rows_results[] = [
                    'id'   => $row->id,
                    'name' => $row->name,
                ];
            }


            $this->response(['status' => true, 'reponse' => $result, "items" => $rows_results], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function GetInfoSousCategorie1_get($id = null)
    {
        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "categorie");

        if ($row) {

            $result['nom'] = $row->nom;

            $result['active'] = $row->active;

            $this->response(['status' => true, 'reponse' => $result], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function editer_souscategorie_post()
    {

        if ($this->post('id')) {

            $data['nom'] = $this->post('nom');

            $data['active'] = $this->post('active');

            $this->gestion->EditerElement($this->post('id'), $data, "categorie");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    //
    public function groupecategorie1_get()
    {
        $list         = $this->gestion->GetDataCategorieGroupe();
        $rows_results = [];
        foreach ($list as $row) {

            $rows_results[] = [
                'id'   => $row->id,
                'name' => $row->nom,
            ];
        }

        $this->response(['data' => $rows_results]);
    }

    public function departement_fonction_get($id = null)
    {


        $lis          = $this->gestion->getDepartFonctions($id);
        $rows_results = [];
        foreach ($lis as $row) {
            $rows_results[] = [
                'id'   => $row->id,
                'name' => $row->name,
                'supp' => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i>"
            ];
        }

        $this->response(['aaData' => $rows_results]);
    }

    public function groupecategorie_get()
    {
        $list = $this->gestion->GetDataCategorieGroupe();

        foreach ($list as $row) {

            $rows_results[] = [
                'id'     => $row->id,
                'active' => $row->active == 1 ? 'Oui' : 'Non',
                'nom'    => "<a href='#/app/souscategorie/" . $row->id . "' style='color:blue;'>" . $row->nom . "</a>",
                'photo'  => '<img src="' . base_url() . 'upload/categories/' . $row->image . '" width="50px"/>',

                'supp' => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button> <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>",

            ];
        }

        $this->response(['data' => $rows_results]);
    }


    public function groupecategorie_delete_post()

    {

        if ($this->post('id')) {

            $this->gestion->DeleteElement($this->post('id'), "categorie_groupe");

            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);

        }

    }


    public function GetInfoGroupeCategorie_get($id = null)
    {
        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "categorie_groupe");

        if ($row) {

            $result['nom']          = $row->nom;
            $result['desc']         = $row->description;
            $result['image']        = $row->image;
            $result['active']       = $row->active;
            $result['affiche_home'] = $row->affiche_home;


            $this->response(['status' => true, 'reponse' => $result], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function ajouter_data_groupecategorie_post()

    {
        $data['nom']          = $this->post('nom');
        $data['description']  = $this->post('desc');
        $data['image']        = $this->post('photo');
        $data['active']       = $this->post('active');
        $data['affiche_home'] = $this->post('affiche_home');

        $this->gestion->AddElement($data, "categorie_groupe");
        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }

    public function editer_groupecategorie_post()
    {

        if ($this->post('id')) {

            $data['nom']          = $this->post('nom');
            $data['description']  = $this->post('desc');
            $data['image']        = $this->post('photo');
            $data['active']       = $this->post('active');
            $data['affiche_home'] = $this->post('affiche_home');


            $this->gestion->EditerElement($this->post('id'), $data, "categorie_groupe");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    ///
    public function ville_get()
    {
        $this->load->driver('cache', ['adapter' => 'apc', 'backup' => 'file']);
        $this->cache->clean();
        $pas = 0;
        // for ($i=1000; $i <=36700; $i=$i+1000)
        // {


        //  $lists=$this->gestion->GetDataVille(array('limit'=>$i , 'start'=>$pas));

        //     $pas=$pas+1000 ;

        //  }
        $lists = $this->gestion->GetDataVille();

        $this->response(['data' => $lists['list']]);
        //sleep(3) ;


    }


    public function ajouter_data_ville_post()

    {
        $data['ville_nom']         = $this->post('nom');
        $data['ville_code_postal'] = $this->post('code_p');

        $this->gestion->AddElement($data, "villes");
        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }


    public function ville_delete_post()

    {

        if ($this->post('id')) {

            $this->gestion->DeleteElement($this->post('id'), "villes", "ville_id");

            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);

        }

    }


    public function edit_ville_post()
    {

        if ($this->post('id')) {

            $data['ville_nom'] = $this->post('nom');

            $this->gestion->EditerElement($this->post('id'), $data, "villes", "ville_id");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function GetInfoVille_get($id = null)
    {

        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "villes", "ville_id");

        if ($row) {

            $result['nom'] = $row->ville_nom;

            $this->response(['status' => true, 'reponse' => $result], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    ///

    public function cartetype_get()
    {
        $list = $this->gestion->GetDataCarteType();

        foreach ($list as $row) {

            $rows_results[] = [
                'id'     => $row->id,
                'nom'    => $row->nom,
                'supp'   => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button> <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>",
                'ticked' => false
            ];
        }

        $this->response(['data' => $rows_results]);
    }


    public function ajouter_data_cartetype_post()

    {
        $data['nom'] = $this->post('nom');

        $this->gestion->AddElement($data, "carte_type");
        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }


    public function cartetype_delete_post()

    {

        if ($this->post('id')) {

            $this->gestion->DeleteElement($this->post('id'), "carte_type");

            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);

        }

    }


    public function edit_cartetype_post()
    {

        if ($this->post('id')) {

            $data['nom'] = $this->post('nom');

            $this->gestion->EditerElement($this->post('id'), $data, "carte_type");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function GetInfoCarteType_get($id = null)
    {

        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "carte_type");

        if ($row) {

            $result['nom'] = $row->nom;

            $this->response(['status' => true, 'reponse' => $result], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }


    ////
    public function tags_get()
    {
        $list         = $this->gestion->GetDataTags();
        $rows_results = [];
        foreach ($list as $row) {

            $rows_results[] = [
                'id'     => $row->id,
                'nom'    => $row->nom,
                //'supp' =>" <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(".$row->id.")\"><i class='fa fa-trash-o'></i></button> <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(".$row->id.")\"><i class='fa fa-pencil'></i></button>",
                'supp'   => " <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>",
                'ticked' => false
            ];
        }

        $this->response(['data' => $rows_results]);
    }

    public function entreprise_get()
    {
        $list         = $this->gestion->GetDataEntreprise();
        $rows_results = [];
        foreach ($list as $row) {

            $rows_results[] = [
                'id'     => $row->id,
                'nom'    => $row->nom,
                'logo'   => $row->logo,
                //'supp' =>" <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(".$row->id.")\"><i class='fa fa-trash-o'></i></button> <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(".$row->id.")\"><i class='fa fa-pencil'></i></button>",
                'supp'   => " <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>",
                'ticked' => false
            ];
        }

        $this->response(['data' => $rows_results]);
    }

    public function language_get()
    {
        $list         = $this->gestion->GetDataLang();
        $rows_results = [];

        foreach ($list as $row) {

            $rows_results[] = [
                'id'     => $row->id,
                'nom'    => $row->nom,
                'supp'   => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button> <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>",
                'ticked' => false
            ];
        }

        $this->response(['data' => $rows_results]);
    }

    public function competences_get()
    {
        $list         = $this->gestion->GetDataCompetences();
        $rows_results = [];
        foreach ($list as $row) {
            $rows_results[] = [
                'id'     => $row->id,
                'nom'    => $row->nom,
                'supp'   => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button> <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>",
                'ticked' => false
            ];
        }
        $this->response(['data' => $rows_results]);
    }

    public function ajouter_data_lang_post()

    {
        $data['nom'] = $this->post('nom');

        $this->gestion->AddElement($data, "language");
        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }

    public function ajouter_data_secteur_post()

    {
        $data['nom'] = $this->post('nom');
        $this->gestion->AddElement($data, "secteur_activite");
        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }

    public function ajouter_data_competence_post()

    {
        $data['nom'] = $this->post('nom');
        $this->gestion->AddElement($data, "competences");
        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }

    public function ajouter_data_tag_post()

    {
        $data['nom'] = $this->post('nom');

        $this->gestion->AddElement($data, "tags");
        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }

    public function lang_delete_post()

    {

        if ($this->post('id')) {

            $this->gestion->DeleteElement($this->post('id'), "language");

            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);

        }

    }

    public function secteur_delete_post()

    {

        if ($this->post('id')) {

            $this->gestion->DeleteElement($this->post('id'), "secteur_activite");

            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);

        }

    }

    public function competence_delete_post()

    {

        if ($this->post('id')) {

            $this->gestion->DeleteElement($this->post('id'), "competences");

            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);

        }

    }

    public function tag_delete_post()

    {

        if ($this->post('id')) {

            $this->gestion->DeleteElement($this->post('id'), "tags");

            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);

        }

    }


    public function edit_lang_post()
    {

        if ($this->post('id')) {

            $data['nom'] = $this->post('nom');

            $this->gestion->EditerElement($this->post('id'), $data, "language");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function edit_secteur_post()
    {
        if ($this->post('id')) {
            $data['nom'] = $this->post('nom');
            $this->gestion->EditerElement($this->post('id'), $data, "secteur_activite");
            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);
        }
    }

    public function edit_competence_post()
    {
        if ($this->post('id')) {
            $data['nom'] = $this->post('nom');
            $this->gestion->EditerElement($this->post('id'), $data, "competences");
            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);
        }
    }

    public function edit_tag_post()
    {

        if ($this->post('id')) {

            $data['nom'] = $this->post('nom');

            $this->gestion->EditerElement($this->post('id'), $data, "tags");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function GetInfoLang_get($id = null)
    {

        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "language");

        if ($row) {

            $result['nom'] = $row->nom;

            $this->response(['status' => true, 'reponse' => $result], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function GetInfoSecteur_get($id = null)
    {

        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "secteur_activite");

        if ($row) {

            $result['nom'] = $row->nom;

            $this->response(['status' => true, 'reponse' => $result], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function GetInfoCompetence_get($id = null)
    {

        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "competences");

        if ($row) {

            $result['nom'] = $row->nom;

            $this->response(['status' => true, 'reponse' => $result], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function GetInfotag_get($id = null)
    {

        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneElement($id, "tags");

        if ($row) {

            $result['nom'] = $row->nom;

            $this->response(['status' => true, 'reponse' => $result], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function admin_get()
    {


        $list = $this->gestion->GetDataAdmin();

        foreach ($list as $row) {

            $rows_results[] = [
                'id'     => $row->id,
                'nom'    => $row->nom,
                'prenom' => $row->prenom,
                'email'  => $row->email,

                'supp'   => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->id . ")\"><i class='fa fa-trash-o'></i></button> <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->id . ")\"><i class='fa fa-pencil'></i></button>",
                'ticked' => false
            ];
        }

        $this->response(['data' => $rows_results]);
    }


    public function ajouter_data_admin_post()

    {
        $data['nom']      = $this->post('nom');
        $data['prenom']   = $this->post('prenom');
        $data['email']    = $this->post('email');
        $data['password'] = $this->ModelGestion->encryptPassword($this->post('password'));
        $this->gestion->AddElement($data, "administrateur");
        $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

    }


    public function admin_delete_post()

    {

        if ($this->post('id')) {

            $this->gestion->DeleteElement($this->post('id'), "administrateur");

            $this->response(['status' => true, 'message' => 'votre reponse est supprimer.'], 200);

        }

    }


    public function edit_admin_post()
    {

        if ($this->post('id')) {

            $data['nom']      = $this->post('nom');
            $data['prenom']   = $this->post('prenom');
            $data['email']    = $this->post('email');
            $data['password'] = $this->ModelGestion->encryptPassword($this->post('password'));
            $this->gestion->EditerElement($this->post('id'), $data, "administrateur");

            $this->response(['status' => true, 'message' => 'votre reponse est ajouter.'], 200);

        }

    }

    public function GetInfoAdmin_get($id = null)
    {

        if (!$id) {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

        $row = $this->gestion->GetOneAdmin($id);

        if ($row) {

            $result['nom']      = $row->nom;
            $result['prenom']   = $row->prenom;
            $result['email']    = $row->email;
            $result['password'] = "";


            $this->response(['status' => true, 'reponse' => $result], 200);

        } else {

            $this->response(['status' => false, 'error_message' => 'No ID was provided.'], 400);

        }

    }

    public function questionnaire_get()
    {
        $ModelQuestionnaire = $this->ModelQuestionnaire->getAllQuestionnairesForGestion();
        $rows_results       = [];
        if (is_array($ModelQuestionnaire) && count($ModelQuestionnaire) > 0) {
            foreach ($ModelQuestionnaire as $Questionnaire) {

                $User         = $this->ModelUser->getById($Questionnaire->user_id);
                $BusinessUser = new BusinessUser($User);

                $Talent         = $this->ModelTalent->getById($Questionnaire->talent_id);
                $BusinessTalent = new BusinessTalent($Talent);
                $TalentComment  = $this->ModelTalent->getTalentTestimonialByDemandeTalentId($Questionnaire->talent_demande_id);
                $isRecommanded  = $TalentComment instanceof StdClass && $TalentComment->note == 1;

                $Entreprise         = $this->ModelEntreprise->getById($Questionnaire->entreprise_id);
                $BusinessEntreprise = new BusinessEntreprise($Entreprise);
                $ModelSecteur       = $this->ModelSecteur->getById($BusinessEntreprise->getSecteurId());

                $rows_results[] = [
                    'id'                        => $Questionnaire->id,
                    'date_creation'             => $Questionnaire->date_creation,
                    'candidat_secteur_activite' => $BusinessUser->getBusinessUserLinkedin()->getIndustry(),
                    'candidat_est_mentor'       => $BusinessUser->isMentor() ? 'OUI' : 'NON',
                    'nom_mentor'                => $BusinessTalent->getBusinessUser()->getNom(),
                    'prenom_mentor'             => $BusinessTalent->getBusinessUser()->getPrenom(),
                    'nom_entreprise'            => $BusinessEntreprise->getNom(),
                    'secteur_activite'          => $ModelSecteur->nom,
                    'connait_entreprise'        => $Questionnaire->connait_entreprise == null ? '---' : ($Questionnaire->connait_entreprise ? 'OUI' : 'NON'),
                    'image_entreprise'          => $Questionnaire->echelle_satisfation == null ? '---' : ($Questionnaire->echelle_satisfation),
                    'image_entreprise_evolue'   => $Questionnaire->avis_change_entreprise == null ? '---' : ($Questionnaire->avis_change_entreprise ? 'OUI' : 'NON'),
                    'si_image_evolue'           => $Questionnaire->nouvel_avis_entreprise == null ? '---' : ($Questionnaire->nouvel_avis_entreprise ? 'Positif' : 'Négatif'),
                    'rejoindre_entreprise'      => $Questionnaire->integrer_entreprise == null ? '---' : ($Questionnaire->integrer_entreprise ? 'OUI' : 'NON'),
                    'recommandation_ulyss'      => $Questionnaire->recommandation_ulyss == null ? '---' : ($Questionnaire->recommandation_ulyss ? 'OUI' : 'NON'),
                    'recommandation_ulyss_non'  => $Questionnaire->recommandation_ulyss_non == null ? '---' : ($Questionnaire->recommandation_ulyss_non),
                    'mentor_recommande'         => $isRecommanded ? 'OUI' : 'NON',
                    'ticked'                    => false
                ];
            }
        }


        $this->response(['data' => $rows_results]);
    }

    public function questionnairementor_get()
    {
        $ModelQuestionnaire = $this->ModelQuestionnaire->getAllQuestionnairesMentorForGestion();
        $rows_results       = [];
        if (is_array($ModelQuestionnaire) && count($ModelQuestionnaire) > 0) {
            foreach ($ModelQuestionnaire as $Questionnaire) {

                $User         = $this->ModelUser->getById($Questionnaire->user_id);
                $BusinessUser = new BusinessUser($User);

                $Talent         = $this->ModelTalent->getById($Questionnaire->talent_id);
                $BusinessTalent = new BusinessTalent($Talent);

                $rows_results[] = [
                    'id'                        => $Questionnaire->id,
                    'date_creation'             => $Questionnaire->date_creation,
                    'candidat_secteur_activite' => $BusinessUser->getBusinessUserLinkedin()->getIndustry(),
                    'candidat_est_mentor'       => $BusinessUser->isMentor() ? 'OUI' : 'NON',
                    'nom_mentor'                => $BusinessTalent->getBusinessUser()->getNom(),
                    'prenom_mentor'             => $BusinessTalent->getBusinessUser()->getPrenom(),
                    'issetrdv'                  => $Questionnaire->issetrdv == null ? '---' : ($Questionnaire->issetrdv ? 'OUI' : 'NON'),
                    'experience_globale'        => $Questionnaire->experience_globale == null ? '---' : ($Questionnaire->experience_globale),
                    'experience_globale_non'    => $Questionnaire->experience_globale_non == null ? '---' : ($Questionnaire->experience_globale_non),
                    'recommandation_ulyss'      => $Questionnaire->recommandation_ulyss == null ? '---' : ($Questionnaire->recommandation_ulyss ? 'OUI' : 'NON'),
                    'recommandation_ulyss_non'  => $Questionnaire->recommandation_ulyss_non == null ? '---' : ($Questionnaire->recommandation_ulyss_non),
                    'ticked'                    => false
                ];
            }
        }
        $this->response(['data' => $rows_results]);
    }


    public function lougout_get()
    {
        $newdata = [
            'id'     => '',
            'nom'    => '',
            'email'  => '',
            'logged' => false,
        ];
        $this->session->unset_userdata($newdata);
        $this->session->sess_destroy();
        $this->response(['status' => true, 'reponse' => true], 200);


    }

}