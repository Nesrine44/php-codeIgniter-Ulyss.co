<?php

Class User_model extends CI_Model
{
    protected $table = 'user';

    public function __construct()
    {
        parent::__construct();

    }

//COUNT RESULT RECHERCHE
    public function getCountEntreprise($id = 0)
    {
        $select = 'talent_id';
        $where = array("talent_experience.entreprise_id" => $id);
        return $this->db->select($select)
            ->from('talent_experience')
            ->join("talent", "talent.id=talent_experience.talent_id")
            ->where($where)
            ->group_by("talent.id")
            ->get()
            ->result();
    }

    //get count talent by fonction
    public function getCountFonctions($id = 0)
    {
        $select = '*';
        $where = array("talent_experience.fonction_id" => $id);
        $result = $this->db->select($select)
            ->from('talent_experience')
            ->join("talent", "talent.id=talent_experience.talent_id")
            ->where($where)
            ->group_by("talent.id")
            ->get()
            ->result();
        return count($result);
    }

    //get count talent by departement
    public function getCountDepartement($id = 0)
    {
        $select = '*';
        $where = array("talent_experience.departement_id" => $id);
        $result = $this->db->select($select)
            ->from('talent_experience')
            ->join("talent", "talent.id=talent_experience.talent_id")
            ->where($where)
            ->group_by("talent.id")
            ->get()
            ->result();
        return count($result);
    }

    public function getEntrepriseList()
    {
        $select = '*';
        return $this->db->select($select)
            ->from('entreprise')
            ->get()
            ->result();
    }


    public function GetAllPagesParentByid($id)
    {
        $select = '*';
        return $this->db->select($select)
            ->from('pages_content')
            ->where("parent_id", $id)
            ->get()
            ->result();
    }

    public function GetConfigValue($id = 0)
    {
        $select = '*';
        $where = array("id" => $id);
        return $this->db->select($select)
            ->from('config')
            ->where($where)
            ->get()
            ->row()->value;
    }

    public function GetConfigName($id = 0)
    {
        $select = '*';
        $where = array("id" => $id);
        return $this->db->select($select)
            ->from('config')
            ->where($where)
            ->get()
            ->row()->name;
    }


    public function checkFavoris($id, $user)
    {
        $select = '*';
        $where = array('talent_id' => $id, "user_id" => $user);
        return $this->db->select($select)
            ->from("talent_favoris")
            ->where($where)
            ->get()->row();
    }

    public function DislikeFavoris($id, $id_user)
    {
        $this->db->delete('talent_favoris', array('talent_id' => $id, "user_id" => $id_user));
    }

    public function AddFavoris($add = array())
    {
        if (empty($add)) {
            return false;
        }
        $this->db->set($add)
            ->insert("talent_favoris");
        return true;
    }

    public function AddRaison($add = array())
    {
        if (empty($add)) {
            return false;
        }
        $this->db->set($add)
            ->insert("user_ferme");
        return true;
    }

    public function GetNameOrsubject($id = 0)
    {
        $select = '*';
        $where = array("id" => $id);
        return $this->db->select($select)
            ->from('config')
            ->where($where)
            ->get()
            ->row()->name;
    }

    public function getVillebYuserID($id = 0)
    {
        $select = 'ville_nom_simple as ville';
        $where = array("user.id" => $id);
        return $this->db->select($select)
            ->from('villes')
            ->join("user", "user.ville_id=villes.ville_id")
            ->where($where)
            ->get()
            ->row();
    }

    public function GetVilleInfo($id = 0)
    {
        $select = 'ville_longitude_deg as lang,ville_latitude_deg as lat,ville_code_postal,ville_nom,ville_nom_simple';
        $where = array("ville_id" => $id);
        return $this->db->select($select)
            ->from('villes')
            ->where($where)
            ->get()
            ->row();
    }

    public function getListCoverture($id = 0)
    {
        $select = 'id,image';
        return $this->db->select($select)
            ->from('covertures')
            ->get()
            ->result();
    }

    public function GetVilleRow($id = 0)
    {
        $select = 'ville_nom,ville_code_postal';
        $where = array("ville_id" => $id);
        return $this->db->select($select)
            ->from('villes')
            ->where($where)
            ->get()
            ->row();
    }


    public function getCodePays($id = 0)
    {
        $select = 'alpha2';
        $where = array("id" => $id);
        return $this->db->select($select)
            ->from('pays')
            ->where($where)
            ->get()
            ->row();
    }

    public function ActivationCompte($code, $data = array())
    {
        //  Vérification des données à mettre à jour
        if (empty($data)) {
            return false;
        }


        return (bool)$this->db->set($data)
            ->where('code_activation', $code)
            ->update($this->table);
    }

    public function getTotalNonLus($id_utilisateur_rec)
    {
        $select = '*';
        $where = array('user_id_recep' => $id_utilisateur_rec, 'status' => 0);
        return $this->db->select($select)
            ->from("messagerie")
            ->where($where)
            ->count_all_results();
    }

    public function deleteVersement($id_user)
    {
        $this->db->delete('versement', array("user_id" => $id_user));
    }

    public function GetUsersByAlias($alias = "")
    {
        $select = '*';
        $where = array("alias" => $alias);
        return $this->db->select($select)
            ->from('user')
            ->where($where)
            ->get()
            ->row();
    }

    public function GetUsersByCodeReinitialiser($code = "")
    {
        $select = '*';
        $where = array("code_reinitialiser" => $code);
        return $this->db->select($select)
            ->from('user')
            ->where($where)
            ->get()
            ->row();
    }

    public function GetUtilisateurtByEmail($email = "")
    {
        $select = '*';
        $where = array("email" => $email);
        return $this->db->select($select)
            ->from('user')
            ->where($where)
            ->get()
            ->row();
    }

    public function GetInfoversementUser($id_user)
    {
        $select = '*';
        $where = array("user_id" => $id_user);
        return $this->db->select($select)
            ->from('versement')
            ->where($where)
            ->get()
            ->row();
    }

    public function GetInfocarte($id, $id_user)
    {
        $select = '*';
        $where = array("id" => $id, "user_id" => $id_user);
        return $this->db->select($select)
            ->from('cartes')
            ->where($where)
            ->get()
            ->row();
    }

    public function GetListLangues()
    {
        $select = '*';
        return $this->db->select($select)
            ->from('language')
            ->get()
            ->result();
    }

    public function GetListTags()
    {
        $select = '*';
        return $this->db->select($select)
            ->from('tags')
            ->get()
            ->result();
    }

    public function Editcarte($id, $id_user, $data = array())
    {
        if (empty($data)) {
            return false;
        }
        return (bool)$this->db->set($data)
            ->where('id', $id)
            ->where('user_id', $id_user)
            ->update("cartes");
    }

    public function GetModePaiement($id = "")
    {
        $select = '*,cartes.id as id';
        $where = array("user_id" => $id);
        return $this->db->select($select)
            ->from('cartes')
            ->join('carte_type', 'carte_type.id=cartes.carte_type_id')
            ->where($where)
            ->get()
            ->result();
    }

    public function listePays($id = "")
    {
        $select = '*';
        return $this->db->select($select)
            ->from('pays')
            ->get()
            ->result();
    }

    public function GetTypesCartes($id = "")
    {
        $select = '*';
        return $this->db->select($select)
            ->from('carte_type')
            ->get()
            ->result();
    }

    public function GetReferences($id)
    {
        $select = '*';
        $where = array("id_user" => $id);
        return $this->db->select($select)
            ->from('user_reference')
            ->where($where)
            ->get()
            ->result();
    }

    public function GetVilles()
    {
        $select = '*';
        return $this->db->select($select)
            ->from('villes')
            ->order_by("ville_nom")
            ->get()
            ->result();
    }

    public function GetLangues($id)
    {
        $select = '*,user_language.id as id';
        $where = array("user_id" => $id);
        return $this->db->select($select)
            ->from('user_language')
            ->join("language", "language.id=user_language.langue_id")
            ->where($where)
            ->get()
            ->result();
    }

    public function GetExperiences($id)
    {
        $select = '*';
        $where = array("id_user" => $id);
        return $this->db->select($select)
            ->from('user_experience')
            ->where($where)
            ->get()
            ->result();
    }

    public function GetMesTalentsUser($id){
        $select = 'id,titre,alias,prix_journee,prix_forfait,prix,description_forfait,description,cover,profession,horaire,coverture,date_creation,status,etanche,valide';
        $where = array("user_id" => $id, "valide" => true, "etanche" => false, "status" => true);
        return $this->db->select($select)
            ->from('talent')
            ->where($where)
            ->get()
            ->result();
    }

    public function getCountMesTalents($id){
        $select = 'id,titre,alias,prix_journee,prix_forfait,prix,description_forfait,description,cover,profession,horaire,coverture,date_creation,status,etanche,valide';
        $where = array("user_id" => $id, "valide" => true, "etanche" => false, "status" => true);
        return $this->db->select($select)
            ->from('talent')
            ->where($where)
            ->count_all_results();
    }

    public function GetTalentsUser($id){
        $select = '*';
        $where = array("user_id" => $id, "statut_admin !=" => "Refusé");
        return $this->db->select($select)
            ->from('talent')
            ->where($where)
            ->order_by("date_creation", "DESC")
            ->limit(1)
            ->get()
            ->result();
    }

    public function modeOperatoire($id){
        $select = '*';
        $where = array("id_user" => $id);
        return $this->db->select($select)
            ->from('mode_operatoire')
            ->where($where)
            ->get()
            ->result();
    }

    public function AddCarte($add = array()){
        if (empty($add)) {
            return false;
        }
        $this->db->set($add)
            ->insert("cartes");
        return true;
    }

    public function AddVersement($add = array()){
        if (empty($add)) {
            return false;
        }
        $this->db->set($add)
            ->insert("versement");
        return true;
    }

    public function EditVersement($id, $data = array()){
        //  Vérification des données à mettre à jour
        if (empty($data)) {
            return false;
        }


        return (bool)$this->db->set($data)
            ->where('user_id', $id)
            ->update("versement");
    }

    public function AddUser($add = array()){
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("user");
        $id = $this->db->insert_id();
        if (empty($add['alias'])) {
            $data['alias'] = $this->db->insert_id();
            $id = $this->db->insert_id();
            $this->EditUser($id, $data);
        }
        $result = $this->GetUserByid($id);
        return $result;
    }

    public function AddUserSociauxFacebook($add = array()){
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("user");
        $id = $this->db->insert_id();
        if (!isset($add['alias'])) {
            $data['alias'] = $this->db->insert_id();
            $this->EditUser($id, $data);
        }
        $result = $this->GetUserByid($id);
        return $result;
    }

    public function addApropos($add = array())
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("user_apropos");
        return $this->db->insert_id();

    }

    public function EditUserAdmin($id, $data = array())
    {
        //  Vérification des données à mettre à jour
        if (empty($data)) {
            return false;
        }


        return (bool)$this->db->set($data)
            ->where('id', $id)
            ->update("utilisateur");
    }

    public function EditUser($id, $data = array())
    {
        //  Vérification des données à mettre à jour
        if (empty($data)) {
            return false;
        }


        return (bool)$this->db->set($data)
            ->where('id', $id)
            ->update("user");
    }

    public function EditApropos($id, $data = array())
    {
        //  Vérification des données à mettre à jour
        if (empty($data)) {
            return false;
        }


        return (bool)$this->db->set($data)
            ->where('id', $id)
            ->update("user_apropos");
    }

    function verify_user($email, $password)
    {
        $this->db->select('*');
        $this->db->from('utilisateur');
        $this->db->where('email = ' . "'" . $email . "'");
        $this->db->where('account_type ="administrateurs"');
        $this->db->limit(1);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $acte_data = $query->result();
            $acte_data = $acte_data[0];
            $this->load->library('encrypt');
            $pass = $this->encrypt->decode($acte_data->password);
            if ($password == $pass) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function GetUserNomaDMIN($id)
    {
        $query = $this->db->query("select *  from administrateurs where id='" . $id . "'");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->nom_complet;
        } else {
            Return "";
        }


    }

    //site web
    function LoginWithEmail($email, $password)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $acte_data = $query->result();
            $acte_data = $acte_data[0];
            $this->load->library('encrypt');
            $pass = $this->encrypt->decode($acte_data->password);
            if ($password == $pass) {
                return $query->result();
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function GetUsers($select = '*,user.type as type,user.id as id')
    {
        if ($this->session->userdata('nom') == "nombre") {
            $select = '*,count(activite.id) as nombre,user.type as type,user.id as id';
        }
        $signe = "";
        if ($this->session->userdata('type') != "specialiste") {
            $signe = "!=";
        }
        $this->db->select($select);
        $this->db->from('user');
        if ($this->session->userdata('nom') == "nombre") {
            $this->db->join('activite', 'activite.user_id = user.id', 'left');
        }
        $this->db->where("user.type " . $signe . "", "specialiste");
        if ($this->session->userdata('search')) {
            $this->db->like('nom', $this->session->userdata('search'), 'both');
            $this->db->or_like('prenom', $this->session->userdata('search'), 'both');
            $this->db->or_like('specialite', $this->session->userdata('search'), 'both');
            $this->db->or_like('biographie', $this->session->userdata('search'), 'both');
        }
        if ($this->session->userdata('nom') == "nombre") {
            $this->db->group_by('user.id');
            $this->db->order_by($this->session->userdata('nom'), 'DESC');

        } else {
            $this->db->order_by($this->session->userdata('nom'), 'asc');
        }
        $query = $this->db->get();
        return $query->result();
    }


    public function GetUsersApropos($alias = "", $type)
    {
        $select = '*';
        $id = $this->GetIdByalias($alias);
        $where = array("user_id" => $id, "type" => $type);
        return $this->db->select($select)
            ->from('user_apropos')
            ->where($where)
            ->get()
            ->result();
    }

    public function GetUsersAproposByID($id = "", $type)
    {
        $select = '*';
        $where = array("user_id" => $id, "type" => $type);
        return $this->db->select($select)
            ->from('user_apropos')
            ->where($where)
            ->get()
            ->result();
    }

    public function GetUserNom($id)
    {
        $query = $this->db->query("select *  from user where id_user='" . $id . "'");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->nom . ' ' . $row->prenom;
        } else {
            Return false;
        }


    }

    public function GetIdByalias($alias)
    {
        $query = $this->db->query("select *  from user where alias='" . $alias . "'");

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->id;
        } else {
            Return 0;
        }


    }

    public function GetAllActivities()
    {
        $this->load->library('somme_lib');
        $select = '*';
        $result = $this->db->select($select)
            ->from("activite")
            ->join('user', 'user.id = activite.user_id')
            ->order_by('activite.date', 'DESC')
            ->limit(25)
            ->get()
            ->result();
        $row_set = array();
        foreach ($result as $key) {
            $new_row['name'] = $key->nom . ' ' . $key->prenom;
            $new_row['avatar'] = $key->avatar;
            $new_row['date'] = $this->somme_lib->humanizeDateDiffference($key->date);
            $new_row['text'] = $key->text;
            $row_set[] = $new_row; //build an array
        }
        return $row_set;
    }

    public function GetAllMesActivities($alias)
    {
        $this->load->library('somme_lib');
        $select = '*';
        $id = $this->GetIdByalias($alias);
        $result = $this->db->select($select)
            ->from("activite")
            ->join('user', 'user.id = activite.user_id')
            ->where("user_id", $id)
            ->order_by('activite.date', 'DESC')
            ->limit(25)
            ->get()
            ->result();
        $row_set = array();
        foreach ($result as $key) {
            $new_row['name'] = $key->nom . ' ' . $key->prenom;
            $new_row['avatar'] = $key->avatar;
            $new_row['date'] = $this->somme_lib->humanizeDateDiffference($key->date);
            $new_row['text'] = $key->text;
            $row_set[] = $new_row; //build an array
        }
        return $row_set;
    }

    /*get notification by user*/
    public function GetNotificationsUserByid($id = 0)
    {
        $select = 'notifications_msg_membre,notifications_demande_accepte_refuse,notifications_demande_pour_talent,notifcations_alertes';
        $where = array("id" => $id);
        return $this->db->select($select)
            ->from('user')
            ->where($where)
            ->get()
            ->row();
    }

    public function GetUserByid($id = 0)
    {
        $select = '*';
        $where = array("id" => $id);
        return $this->db->select($select)
            ->from('user')
            ->where($where)
            ->get()
            ->row();
    }

    //get coverture
    public function GetCoverturePhoto()
    {
        $select = '*';
        return $this->db->select($select)
            ->from('photo_de_coverture')
            ->get()
            ->result();
    }

    public function verifcationExistAlias($string)
    {
        $select = '*';
        $where = array("alias" => $string);
        return $this->db->select($select)
            ->from('user')
            ->where($where)
            ->get()
            ->result();
    }

    function ExistenceUidSociaux($uid, $provider)
    {

        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('uid = ' . "'" . $uid . "'");
        $this->db->where('type_sociaux = ' . "'" . $provider . "'");
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }

    }

    function GetUSERbYeMAIL($email)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }

    }

    public function ActiVerMonCompte($code, $data = array())
    {
        //  Vérification des données à mettre à jour
        if (empty($data)) {
            return false;
        }


        return (bool)$this->db->set($data)
            ->where('code_activation', $code)
            ->update("user");
    }

    public function getCategorieParent()
    {
        $select = 'id,nom,description,image,active,affiche_home';
        return $this->db->select($select)
            ->from('categorie_groupe')
            ->get()
            ->result();
    }

    public function getSecteurActivites()
    {
        $select = '*';
        return $this->db->select($select)
            ->from('secteur_activite')
            ->get()
            ->result();
    }

    public function getAllfonctions()
    {
        $select = '*';
        return $this->db->select($select)
            ->from('categorie')
            ->get()
            ->result();
    }

    public function GetuserHunter($id_demande)
    {
        $select = '*';
        return $this->db->select($select)
            ->from('talent_demandes')
            ->join('user', 'talent_demandes.user_id_acheteur = user.id')
            ->where('talent_demandes.id', $id_demande)
            ->get()
            ->row();
    }

    public function GetuserWanted($id_demande)
    {
        $select = '*';
        return $this->db->select($select)
            ->from('talent_demandes')
            ->join('talent', 'talent_demandes.talent_id = talent.id')
            ->join('user', 'talent.user_id = user.id')
            ->where('talent_demandes.id', $id_demande)
            ->get()
            ->row();
    }
}

?>