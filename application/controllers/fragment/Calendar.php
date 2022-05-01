<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Calendar extends CI_Controller
{

    public function __construct()
    {
        Parent::__construct();
        $this->load->model("ModelCalendar");
    }

    public function get_events_ent()
    {
        if (!$this->session->userdata('ent_logged_in_site_web')) {
            show_404();
        }

        $events = $this->ModelCalendar->get_events($this->id_ent_decode);

        $event_sources = [];


        foreach ($events as $r) {

            switch ($r->heure) {
                case "8h-10h":
                    $h_debut = $r->date_rdv . "T08:00:00";
                    $h_fin   = $r->date_rdv . "T10:00:00";
                    break;
                case "10h-12h":
                    $h_debut = $r->date_rdv . "T10:00:00";
                    $h_fin   = $r->date_rdv . "T12:00:00";
                    break;
                case "12h-14h":
                    $h_debut = $r->date_rdv . "T12:00:00";
                    $h_fin   = $r->date_rdv . "T14:00:00";
                    break;
                case "14h-16h":
                    $h_debut = $r->date_rdv . "T14:00:00";
                    $h_fin   = $r->date_rdv . "T16:00:00";
                    break;
                case "16h-18h":
                    $h_debut = $r->date_rdv . "T16:00:00";
                    $h_fin   = $r->date_rdv . "T18:00:00";
                    break;
                case "18h-20h":
                    $h_debut = $r->date_rdv . "T18:00:00";
                    $h_fin   = $r->date_rdv . "T20:00:00";
                    break;
            }


            $startdt = new DateTime('now'); // setup a local datetime
            $startdt = $startdt->format('Y-m-d');

            $data = [
                "description" => 'Mentor : ' . $r->nom . ' ' . $r->prenom . ' <br> Departement : ' . $r->dep_nom,
                "end"         => $h_debut,
                "start"       => $h_fin,
                "imageurl"    => $r->avatar
            ];

            if ($r->status_demande == 'validé' && $r->date_rdv < $startdt) {
                $data['title']        = 'Rendez vous [Terminer]';
                $event_sources['T'][] = $data;
            } elseif ($r->status_demande == 'validé' && $r->date_rdv >= $startdt) {
                $data['title']        = 'Rendez vous [Validé]';
                $event_sources['V'][] = $data;
            } elseif ($r->status_demande == 'en-attente') {
                $data['title']        = 'Rendez vous [En Attente]';
                $event_sources['A'][] = $data;
            } elseif ($r->status_demande == 'rejeté') {
                $data['title']        = 'Rendez vous [Rejeté]';
                $event_sources['R'][] = $data;
            }
        }

        echo json_encode($event_sources);
        exit();
    }

}

?>