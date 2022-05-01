<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Calendrier extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('demande_model', 'demande');
        $this->load->model('talent_model', 'talent');
        $this->load->library('encrypt');
        $this->load->library('user_info');
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
    }

    public function index()
    {
        if ($this->getBusinessUser()->isMentor()) {
            $info_talent                      = $this->talent->GetTalentByUserId($this->getBusinessUser()->getId());
            $data["info_talent"]              = $info_talent;
            $data['disponibilites_of_talent'] = $this->talent->getDisponibiliteTalent($info_talent->id);
        }
        $data['mission_jour'] = $this->demande->GetMesMissionJour($this->id_user_decode);
        $this->load->view('template/header', $this->datas);
        $this->load->view('profil/compte/header_profile', $this->datas);
        $this->load->view('profil/compte/calendrier', $data);
        $this->load->view('template/footer', $this->datas);
    }

    public function events()
    {
        $date_from = date("Y-m-d", $this->input->get('from') / 1000);
        $date_to   = date("Y-m-d", $this->input->get('to') / 1000);
        $talentID  = $this->getBusinessUser()->getMentor() != null ? $this->getBusinessUser()->getMentor()->getId() : -1;
        $datesRDV  = $this->ModelTalent->getRDVFromTwoDate($date_from, $date_to, $this->getBusinessUser()->getId(), $talentID);
        $events    = [];

        if (is_array($datesRDV)) {
            foreach ($datesRDV as $dateRDV) {
                if ($dateRDV->talent_id != $this->getBusinessUser()->getBusinessTalent()->getId()) {
                    continue; /* On affiche les RDV que si le RDV rattaché est pour un mentor */
                }

                $idUserToContact = $dateRDV->user_id_acheteur;
                $User            = $this->ModelUser->getById($idUserToContact);
                $BusinessUser    = new BusinessUser($User);
                $Conversation    = $this->ModelConversation->getByTalentDemandeId($dateRDV->id);
                $id_conv         = $Conversation instanceof StdClass ? $Conversation->id : -1;
                $label           = $dateRDV->status == 'validé' ? 'rendez-vous validé avec ' : 'rendez-vous en attente de confirmation avec ';
                $state           = $dateRDV->status == 'validé' ? 'event-success' : 'event-warning';
                $horaire         = $dateRDV->horaire != '' ? ' ' . $dateRDV->horaire : '';
                $events[]        = [
                    'id'       => $dateRDV->id,
                    'id_conv'  => $id_conv,
                    "title"    => $label . ' ' . $User->prenom . ' ' . $User->nom . ' ' . $horaire,
                    "url"      => "#",
                    "class"    => $state,
                    "start"    => strtotime($dateRDV->date_livraison) * 1000, // Milliseconds
                    "end"      => strtotime($dateRDV->date_livraison) * 1000, // Milliseconds
                    "fullname" => $User->prenom . ' ' . $User->nom,
                    "societe"  => $BusinessUser->getBusinessUserLinkedin()->getCompagnyName(),
                    "state"    => $state,
                    "horaire"  => $dateRDV->horaire
                ];
            }
        }

        $html['success'] = 1;
        $html['result']  = $events;

        echo json_encode($html);
    }

    public function add_indisponible()
    {
        $element_a = explode("/", $this->input->post('date'));
        $date      = "";
        if (count($element_a) > 1) {
            $date = $element_a[2] . "-" . $element_a[1] . "-" . $element_a[0];
        }
        $data['date_debut'] = $date;
        $data['user_id']    = $this->id_user_decode;
        $data['titre']      = $this->input->post('titre');
        $this->demande->addIndiponible($data);
        echo json_encode($data);
    }

    public function supprimerredezvous()
    {
        $idRDV = $this->input->post('id');

        if ($idRDV != '') {
            $talentID = $this->getBusinessUser()->getMentor() != null ? $this->getBusinessUser()->getMentor()->getId() : -1;
            $RDV      = $this->ModelTalent->getRDV($idRDV, $talentID, $this->getBusinessUser()->getId());
            if ($RDV != false) {
                /* SEND MAIL */

                /* Remove RDV */
                $this->db->where('talent_demande_id', $idRDV);
                $this->db->delete('talent_demande_offre');

                $this->db->where('talent_demandes_id', $idRDV);
                $this->db->delete('talent_demandes_reservations');

                $this->db->where('id', $idRDV);
                $this->db->delete('talent_demandes');
            }
        }
    }
}

