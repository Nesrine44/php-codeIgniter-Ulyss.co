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

        $data["info"]    = $info;
        $data["alias"]   = $alias;
        $data["talents"] = $this->user->GetMesTalentsUser($info->id);
        $data["langues"] = $this->user->GetLangues($info->id);

        $data['commentaires_recus'] = $this->talent->GetCommentairestomesTalent($info->id);
        $this->load->view('profil/user', $data);
        $this->load->view('profil/footer', $data);
    }

    public function apropos($alias = null, $talent = null)
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

            } else {
                $daa_vues['talent_id'] = $info_talent->id;
                $daa_vues['user_id']   = $this->id_user_decode;
                $this->talent->AddVueTalent($daa_vues);
            }
        }

        $data["mode_operatoire"] = $this->talent->modeOperatoire($info_talent->id);
        $data["experiences"]     = $this->talent->GetExperiences($info_talent->id);
        $data["portfolio"]       = $this->talent->GetPortfolio($info_talent->id);

        $data["references"]  = $this->talent->GetReferences($info_talent->id);
        $data["categories"]  = $this->talent->GetCategories($info_talent->id);
        $data["langues"]     = $this->talent->GetLangues($info_talent->id);
        $data["tags"]        = $this->talent->GetTags($info_talent->id);
        $data["nbr_talents"] = $this->user->getCountMesTalents($info->id);
        $this->load->view('profil/talent/header', $data);
        $date                              = date("Y-m-d");
        $data['disponible']                = $this->get_disponibilite($info_talent->id);
        $data['get_disponibilite_in_week'] = $this->get_disponibilite_in_week($info_talent->id);

        $this->load->view('profil/talent/apropos', $data);
        //$this->load->view('profil/footer',$data);
    }

    function get_disponibilite($id_talent, $date = null)
    {
        if (!$date) {
            $date = date("Y-m-d");
        }
        $list_week  = ["jour", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche"];
        $disponible = $this->talent->getDisponibiliteTalent($id_talent);
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
        $data_date['nombre_heure'] = $nombre_heure;

        return $data_date;
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

        $data['disponible'] = $this->get_disponibilite($this->input->post("talent_id"), $date);
        $html_nbr_heure     = "";
        for ($i = 1; $i < $data['disponible']['nombre_heure']; $i++) {
            $html_nbr_heure .= '<option value="' . $i . '">' . $i . '</option>';
        }
        $data['html_heure'] = $html_nbr_heure;
        $data['html']       = $this->load->view('profil/talent/disponible', $data, true);
        echo json_encode($data);

    }

    public function commentaires($alias = null, $talent)
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
        $data["info_talent"]        = $info_talent;
        $data["alias_talent"]       = $talent;
        $data['commentaires_recus'] = $this->talent->GetCommentairesByTalent($info_talent->id);

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

        $data["nbr_talents"] = $this->user->getCountMesTalents($info->id);
        $this->load->view('profil/talent/header', $data);
        $date                              = date("Y-m-d");
        $data['disponible']                = $this->get_disponibilite($info_talent->id);
        $data['get_disponibilite_in_week'] = $this->get_disponibilite_in_week($info_talent->id);

        $this->load->view('profil/talent/commentaires', $data);
        $this->load->view('profil/footer', $data);
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

        $this->load->view('profil/talent/services', $data);
        $this->load->view('profil/footer', $data);
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
            $data["text"]             = $this->input->post("message_detail");
            $data["id_conversations"] = $result;
            $this->msg->AddConversation($data);
        }
        $html['msg'] = "<p class='succed_p'>succed</p>";
        echo json_encode($html);
    }

    public function add_reservation()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            if ($this->input->post("talent_id")) {
                $this->load->library('encrypt');
                $id = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);

                //CB : clean des données utilisateurs
                //besoin de clean si tu utilise $_POST mais codeigniter clean le code  on utilise $this->input->post !!
                $data_info['titre']            = $this->security->xss_clean($this->input->post("titre"));
                $data_info['talent_id']        = $this->input->post("talent_id");
                $data_info['user_id_acheteur'] = $id;

                $this->load->model('demande_model', 'demande');
                $element_a = explode("/", $this->input->post('date_offre'));
                if (count($element_a) > 1) {
                    $data_info['date_livraison'] = $element_a[2] . "-" . $element_a[1] . "-" . $element_a[0];
                }

                $creneaux         = "";
                $virgule          = "/";
                $data_reservation = [];
                if ($this->input->post("crenaux")) {
                    foreach ($this->input->post("crenaux") as $key => $value) {
                        if ($key == count($this->input->post("crenaux")) - 1) {
                            $virgule = "";
                        }
                        $creneaux .= $value . $virgule;
                        //$data_reservation['creneaux'][]=$value;
                        if (count($element_a) > 1) {
                            $date6 = $element_a[2] . "-" . $element_a[1] . "-" . $element_a[0];
                        } else {
                            $date6 = "2013-02-02";
                        }

                        $data_reservation[] = ["creneaux" => $value, "date" => $date6];
                    }
                }
                $data_info['horaire']       = $creneaux;
                $data_info['reservation_j'] = json_encode($data_reservation);
                $id_demande                 = $this->demande->Add($data_info);

                $this->load->model('messagerie_model', 'msg');
                $result      = $this->msg->existenceConversation($this->input->post("talent_id"), $id, $id_demande);
                $info_talent = $this->talent->GetTalent($this->input->post("talent_id"));


                $frais_de_service = 8;
                if ($this->input->post("nbr_personne") < 2) {
                    $total = $info_talent->prix * $this->input->post("nbr_heure");
                    if ($info_talent->reduction_heure != 0 && $this->input->post("nbr_heure") >= $info_talent->reduction_heure) {
                        $total = $total - $total * ($info_talent->reduction / 100);
                    }
                    $total = $total + $total * ($frais_de_service / 100);
                } else {
                    $total = $info_talent->prix * $this->input->post("nbr_heure");
                    if ($info_talent->reduction_heure != 0 && $this->input->post("nbr_heure") >= $info_talent->reduction_heure) {
                        $total = $total - $total * ($info_talent->reduction / 100);
                    }
                    $total = $total + ($this->input->post("nbr_personne") - 1) * $info_talent->reduction_personne;
                    $total = $total + $total * ($frais_de_service / 100);
                }

                $text = "Sujet : " . $info_talent->titre . " demande reçue !<br>
          Hello,<br><br>
          " . $this->session->userdata('logged_in_site_web')["name"] . " souhaite profiter de vos talents !<br>
          Cela concerne votre   talent " . $info_talent->titre . ".<br>
          Date: " . $this->input->post('date_offre') . "<br>
          Créneau: " . $creneaux . "<br>
          Nombre de personnes: " . $this->input->post("nbr_personne") . "<br>
          Nombre d'heure souhaitée " . $this->input->post("nbr_personne") . "<br>
          Total: " . $total . "<br>
          Sans réponse de votre part, cette demande expirera automatiquement dans  48h.<br>
          A vous de jouer.<br><br>
          Bonne journée !";

                if (!empty($info_talent)) {
                    $data['user_id_send']     = $id;
                    $data['user_id_recep']    = $info_talent->user_id;
                    $data["text"]             = $text;
                    $data["id_conversations"] = $result;
                    $this->msg->AddConversation($data);
                }

                /*add to offre*/
                $data_offre['reservation_json']  = json_encode($data_reservation);
                $data_offre['talent_demande_id'] = $id_demande;
                $data_offre['message']           = $this->security->xss_clean($this->input->post('description'));//CB clean des données utilisateurs

                if (count($element_a) > 1) {
                    $data_offre['date'] = $element_a[2] . "-" . $element_a[1] . "-" . $element_a[0];
                }


                $data_offre['heure'] = $this->input->post('time');

                if ($this->input->post("prix_offre") == "h") {
                    $data_offre['type_prix']     = "h";
                    $data_offre['prix_unitaire'] = $info_talent->prix;
                    $data_offre['quantite']      = $this->input->post("nbr_heure");
                    $data_offre['nbr_personne']  = $this->input->post("nbr_personne");
                    $data_offre['creneau']       = $creneaux;

                    $data_offre['total'] = $total;
                } elseif ($this->input->post("prix_offre") == "j") {
                    $data_offre['type_prix']     = "j";
                    $data_offre['prix_unitaire'] = $info_talent->prix_journee;
                    $data_offre['quantite']      = $this->input->post("quantite_j");
                    $data_offre['total']         = $this->input->post("quantite_j") * $info_talent->prix_journee;
                } elseif ($this->input->post("prix_offre") == "f") {
                    $data_offre['type_prix']     = "f";
                    $data_offre['prix_unitaire'] = $info_talent->prix_forfait;
                    $data_offre['quantite']      = $this->input->post("quantite_f");
                    $data_offre['total']         = $this->input->post("quantite_f") * $info_talent->prix_forfait;
                } else {
                    $html['msg'] = "<p class='succed_p'>Un probleme de serveur</p>";
                    echo json_encode($html);
                }
                $this->demande->AddOffre($data_offre);


                /*new notifications*/
                $this->load->library('mailing');
                $type_notification = $this->user_info->getTypeNotificationsNewMsg($info_talent->user_id);
                if (!empty($type_notification) && $type_notification->notifications_msg_membre == "email") {
                    $data_notification['talent'] = $info_talent->titre;
                    $data_notification['email']  = $type_notification->email;
                    $data_notification['name']   = $type_notification->prenom . ' ' . $type_notification->nom;
                    $data_notification['sender'] = $this->user_info->getNameUser($this->id_user_decode);
                    $this->mailing->notifications_new_demande_msg_email($data_notification);
                } elseif (!empty($type_notification) && $type_notification->notifications_msg_membre == "sms") {
                    $data_notification['talent'] = $info_talent->titre;
                    $data_notification['name']   = $type_notification->prenom . ' ' . $type_notification->nom;
                    $data_notification['phone']  = $type_notification->tel;
                    $data_notification['sender'] = $this->user_info->getNameUser($this->id_user_decode);
                    $this->mailing->notifications_new_demande_msg_sms($data_notification);
                } else {

                }


                $html['msg'] = "<p class='succed_p'>succed</p>";
                echo json_encode($html);
            }
        }
    }

    public function add_demande()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            if ($this->input->post("talent_id")) {
                $this->load->library('encrypt');
                $id = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);

                //CB : clean des données utilisateurs
                //besoin de clean si tu utilise $_POST mais codeigniter clean le code  on utilise $this->input->post !!
                $data_info['titre']            = $this->security->xss_clean($this->input->post("titre"));
                $data_info['talent_id']        = $this->input->post("talent_id");
                $data_info['user_id_acheteur'] = $id;

                $this->load->model('demande_model', 'demande');
                $id_demande = $this->demande->Add($data_info);

                $this->load->model('messagerie_model', 'msg');
                $result      = $this->msg->existenceConversation($this->input->post("talent_id"), $id, $id_demande);
                $info_talent = $this->talent->GetTalent($this->input->post("talent_id"));
                $text        = "Sujet : " . $this->input->post("titre") . " demande reçue !<br>
          Hello,<br><br>
          " . $this->session->userdata('logged_in_site_web')["name"] . " souhaite profiter de vos talents !<br>
          Cela concerne votre   talent " . $this->input->post("titre") . ".<br>
          Date " . $this->input->post('date_offre') . " à " . $this->input->post("time") . "<br><br>
          Sans réponse de votre part, cette demande expirera automatiquement dans 14 jours.<br>
          A vous de jouer.<br><br>
          Bonne journée !";

                if (!empty($info_talent)) {
                    $data['user_id_send']     = $id;
                    $data['user_id_recep']    = $info_talent->user_id;
                    $data["text"]             = $text;
                    $data["id_conversations"] = $result;
                    $this->msg->AddConversation($data);
                }

                /*add to offre*/
                $data_offre['talent_demande_id'] = $id_demande;
                $data_offre['message']           = $this->security->xss_clean($this->input->post('description'));//CB clean des données utilisateurs
                $element_a                       = explode("/", $this->input->post('date_offre'));
                if (count($element_a) > 1) {
                    $data_offre['date'] = $element_a[2] . "-" . $element_a[1] . "-" . $element_a[0];
                }


                $data_offre['heure'] = $this->input->post('time');

                if ($this->input->post("prix_offre") == "h") {
                    $data_offre['type_prix']     = "h";
                    $data_offre['prix_unitaire'] = $info_talent->prix;
                    $data_offre['quantite']      = $this->input->post("quantite_h");
                    $data_offre['total']         = $this->input->post("quantite_h") * $info_talent->prix;
                } elseif ($this->input->post("prix_offre") == "j") {
                    $data_offre['type_prix']     = "j";
                    $data_offre['prix_unitaire'] = $info_talent->prix_journee;
                    $data_offre['quantite']      = $this->input->post("quantite_j");
                    $data_offre['total']         = $this->input->post("quantite_j") * $info_talent->prix_journee;
                } elseif ($this->input->post("prix_offre") == "f") {
                    $data_offre['type_prix']     = "f";
                    $data_offre['prix_unitaire'] = $info_talent->prix_forfait;
                    $data_offre['quantite']      = $this->input->post("quantite_f");
                    $data_offre['total']         = $this->input->post("quantite_f") * $info_talent->prix_forfait;
                } else {
                    $html['msg'] = "<p class='succed_p'>Un probleme de serveur</p>";
                    echo json_encode($html);
                }
                $this->demande->AddOffre($data_offre);


                /*new notifications*/
                $this->load->library('mailing');
                $type_notification = $this->user_info->getTypeNotificationsNewMsg($info_talent->user_id);
                if (!empty($type_notification) && $type_notification->notifications_msg_membre == "email") {
                    $data_notification['talent'] = $info_talent->titre;
                    $data_notification['email']  = $type_notification->email;
                    $data_notification['name']   = $type_notification->prenom . ' ' . $type_notification->nom;
                    $data_notification['sender'] = $this->user_info->getNameUser($this->id_user_decode);
                    $this->mailing->notifications_new_demande_msg_email($data_notification);
                } elseif (!empty($type_notification) && $type_notification->notifications_msg_membre == "sms") {
                    $data_notification['talent'] = $info_talent->titre;
                    $data_notification['name']   = $type_notification->prenom . ' ' . $type_notification->nom;
                    $data_notification['phone']  = $type_notification->tel;
                    $data_notification['sender'] = $this->user_info->getNameUser($this->id_user_decode);
                    $this->mailing->notifications_new_demande_msg_sms($data_notification);
                } else {

                }


                $html['msg'] = "<p class='succed_p'>succed</p>";
                echo json_encode($html);
            }
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
            $data['titre']       = $this->input->post("titre");
            $data['description'] = $this->input->post("description");
            $data['talent_id']   = $this->input->post("talent_id");
            $this->talent->AjouterModeTouser($data);
            $reponse['message'] = "la mode est ajouter";
            $html               = "";
            $html1              = "";
            $mode_operatoire    = $this->talent->modeOperatoire($this->input->post("talent_id"));
            foreach ($mode_operatoire as $mode) {
                $html
                    .= "<div class='operatoire_item'>
                        <p class='titre_operatoire'>" . $mode->titre . "<a href='#' onclick='supprimerMode(" . $mode->id . "," . $mode->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></p>  
                        <div class='text_operatoire'>
                           <p>" . $mode->description . "</p>
                        </div>                   
                     </div>";
                $html1
                    .= "<div class='operatoire_item'>
                        <p class='titre_operatoire'>" . $mode->titre . "</p>  
                        <div class='text_operatoire'>
                           <p>" . $mode->description . "</p>
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
            $mode_operatoire    = $this->talent->modeOperatoire($this->input->post("talent_id"));
            foreach ($mode_operatoire as $mode) {
                $html
                    .= "<div class='operatoire_item'>
                        <p class='titre_operatoire'>" . $mode->titre . "<a href='#' onclick='supprimerMode(" . $mode->id . ")' class='btn_edit_inf'><span>Supprimer</span></a></p>  
                        <div class='text_operatoire'>
                           <p>" . $mode->description . "</p>
                        </div>                   
                     </div>";
                $html1
                    .= "<div class='operatoire_item'>
                        <p class='titre_operatoire'>" . $mode->titre . "</p>  
                        <div class='text_operatoire'>
                           <p>" . $mode->description . "</p>
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
            $data['talent_id']     = $this->input->post("talent_id");
            $element_a             = explode("/", $this->input->post('date_debut'));
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
                        <p class='titre_mission'>" . $exp->titre_mission . "- <span>" . $exp->lieu . "</span><a href='#' onclick='supprimerExperience(" . $exp->id . "," . $exp->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></p>
                        <p class='date_mission'><i class='ion-calendar'></i>" . date("d.m.Y", strtotime($exp->date_debut)) . "-" . date("d.m.Y", strtotime($exp->date_fin)) . "</p>
                     </div>";
                $html1
                    .= "<div class='mission_item'>
                        <p class='titre_mission'>" . $exp->titre_mission . "- <span>" . $exp->lieu . "</span></p>
                        <p class='date_mission'><i class='ion-calendar'></i>" . date("d.m.Y", strtotime($exp->date_debut)) . "-" . date("d.m.Y", strtotime($exp->date_fin)) . "</p>
                     </div>";
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
                        <p class='titre_mission'>" . $exp->titre_mission . "- <span>" . $exp->lieu . "</span><a href='#' onclick='supprimerExperience(" . $exp->id . "," . $exp->talent_id . ")' class='btn_edit_inf'><span>Supprimer</span></a></p>
                        <p class='date_mission'><i class='ion-calendar'></i>" . date("d.m.Y", strtotime($exp->date_debut)) . "-" . date("d.m.Y", strtotime($exp->date_fin)) . "</p>
                     </div>";
                $html1
                    .= "<div class='mission_item'>
                        <p class='titre_mission'>" . $exp->titre_mission . "- <span>" . $exp->lieu . "</span></p>
                        <p class='date_mission'><i class='ion-calendar'></i>" . date("d.m.Y", strtotime($exp->date_debut)) . "-" . date("d.m.Y", strtotime($exp->date_fin)) . "</p>
                     </div>";
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
            $data_info['titre']              = $this->input->post("titre");
            $data_info['prix']               = $this->input->post("prix");
            $data_info['ville']              = $this->input->post("ville");
            $data_info['reduction']          = $this->input->post("reduction");
            $data_info['reduction_heure']    = $this->input->post("reduction_heure");
            $data_info['reduction_personne'] = $this->input->post("reduction_personne");
            //  $data_info['horaire']=$this->input->post("horaire");
            //$data_info['horaire_de']=$this->input->post("horaire_de");
            // $data_info['horaire_a']=$this->input->post("horaire_a");

            //$data_info['description_forfait']=$this->input->post("description_forfait");
            // $data_info['prix_forfait']=$this->input->post("prix_forfait");
            $data_info['prix_journee'] = $this->input->post("prix_journee");
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
            var_dump($data_horaire);
            echo json_encode($reponse);
        }
    }

}