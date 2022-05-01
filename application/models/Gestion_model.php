<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Gestion_model extends CI_Model
{
    public $admin = "administrateur";
    public $language = "language";
    public $carte_type = "carte_type";
    public $ville = "villes";
    public $categorie_groupe = "categorie_groupe";
    public $config = "config";
    public $user = "user";
    public $covertures = "covertures";

    public function getDepartFonctions($id)
    {
        $select = 'departement_fonctions.id as id,categorie_groupe.nom as name';
        return $this->db->select($select)
            ->from('departement_fonctions')
            ->join("categorie_groupe", "categorie_groupe.id=departement_fonctions.departement_id")
            ->where("fonction_id", $id)
            ->get()
            ->result();
    }

    public function getFonctionsDepart($id)
    {
        $select = 'departement_fonctions.id as id,categorie.nom as name';
        return $this->db->select($select)
            ->from('departement_fonctions')
            ->join("categorie", "categorie.id=departement_fonctions.fonction_id")
            ->where("departement_id", $id)
            ->get()
            ->result();
    }


    public function allVisiteurs()
    {
        $select = '*';
        return $this->db->select($select)
            ->from('ci_sessions')
            ->count_all_results();
    }

    public function allVisiteurs1($date1, $date2)
    {
        $select = '*';
        return $this->db->select($select)
            ->from('ci_sessions')
            ->where("timestamp >=", strtotime($date1))
            ->where("timestamp <=", strtotime($date2))
            ->count_all_results();
    }

    public function allDemandesCompte()
    {
        $select = '*';
        return $this->db->select($select)
            ->from('talent_demandes')
            ->count_all_results();
    }

    public function allDemandesCompte1($date1, $date2)
    {
        $select = '*';
        return $this->db->select($select)
            ->from('talent_demandes')
            ->where("date_creation >=", $date1)
            ->where("date_creation <=", $date2)
            ->count_all_results();
    }


    public function allDemandesCompteContractualiser()
    {
        $select = '*';
        return $this->db->select($select)
            ->from('talent_demandes')
            ->where("status", "contractualisé")
            ->count_all_results();
    }

    public function allDemandesCompteContractualiser1($date1, $date2)
    {
        $select = '*';
        return $this->db->select($select)
            ->from('talent_demandes')
            ->where("status", "contractualisé")
            ->where("date_creation >=", $date1)
            ->where("date_creation <=", $date2)
            ->count_all_results();
    }

    public function allUtilisateurCompte()
    {
        $select = '*';
        return $this->db->select($select)
            ->from('user')
            ->count_all_results();
    }

    public function allUtilisateurCompte1($date1, $date2)
    {
        $select = '*';
        return $this->db->select($select)
            ->from('user')
            ->where("date_creation >=", $date1)
            ->where("date_creation <=", $date2)
            ->count_all_results();
    }

    public function allUtilisateurCompteWitTalent()
    {
        $select = 'user_id';
        $annonceur = $this->db->select($select)
            ->from('user')
            ->join("talent", "talent.user_id", "user.id")
            ->group_by("user_id")
            ->get()
            ->result();
        //var_dump($annonceur);
        return count($annonceur);
    }

    public function allUtilisateurCompteWitTalent1($date1, $date2)
    {
        $select = 'user_id';
        $annonceur = $this->db->select($select)
            ->from('user')
            ->join("talent", "talent.user_id", "user.id")
            ->where("user.date_creation >=", $date1)
            ->where("user.date_creation <=", $date2)
            ->group_by("user_id")
            ->get()
            ->result();
        //var_dump($annonceur);
        return count($annonceur);
    }


    public function allAnnoncesCompte()
    {
        $select = '*';
        return $this->db->select($select)
            ->from('talent')
            ->count_all_results();
    }

    public function allAnnoncesCompte1($date1, $date2)
    {
        $select = '*';
        return $this->db->select($select)
            ->from('talent')
            ->where("date_creation >=", $date1)
            ->where("date_creation <=", $date2)
            ->count_all_results();
    }

    public function GetChiffreAffaire1($date1, $date2)
    {
        $total = 0;
        $select = '*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations';
        $where = array("talent_demandes.status" => "contractualisé");
        $result = $this->db->select($select)
            ->from('talent_demandes')
            ->join('talent', 'talent.id=talent_demandes.talent_id')
            ->join('conversations', 'conversations.demandes_talent_id=talent_demandes.id')
            ->where($where)
            ->where("talent_demandes.date_creation >=", $date1)
            ->where("talent_demandes.date_creation <=", $date2)
            ->get()
            ->result();
        foreach ($result as $row) {
            $dernier = $this->getDerniereOffre($row->id);
            if (!empty($dernier)) {
                $total = $total + $dernier->total;
            }
        }
        return $total;
    }

    public function GetChiffreAffaire()
    {
        $total = 0;
        $select = '*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations';
        $where = array("talent_demandes.status" => "contractualisé");
        $result = $this->db->select($select)
            ->from('talent_demandes')
            ->join('talent', 'talent.id=talent_demandes.talent_id')
            ->join('conversations', 'conversations.demandes_talent_id=talent_demandes.id')
            ->where($where)
            ->get()
            ->result();
        foreach ($result as $row) {
            $dernier = $this->getDerniereOffre($row->id);
            if (!empty($dernier)) {
                $total = $total + $dernier->total;
            }
        }
        return $total;
    }

    public function getDerniereOffre($id)
    {
        $select = '*';
        $where = array("talent_demande_offre.talent_demande_id" => $id);
        return $this->db->select($select)
            ->from('talent_demande_offre')
            /*               ->join('talent_demandes','talent_demandes.id=talent_demande_offre.talent_demande_id')*/
            ->where($where)
            ->order_by('date_creation', 'DESC')
            ->get()
            ->row();
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

    public function getElement($id, $table_)
    {
        $select = '*';
        $where = array('id' => $id);
        return $this->db->select($select)
            ->from($table_)
            ->where($where)
            ->get()
            ->row();

    }

    public function supprimerElement($id, $table)
    {
        $this->db->delete($table, array('id' => $id));
        return true;
    }

    public function ajouterElement($add = array(), $table, $ordre = false)
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert($table);
        if ($ordre) {
            $data['priority'] = $this->db->insert_id();
            $this->editerElement($this->db->insert_id(), $data, $table);
        }
        return true;

    }

    public function GetAllPagesParent()
    {
        $select = '*';
        return $this->db->select($select)
            ->from('pages_content')
            ->where("parent_id", 0)
            ->get()
            ->result();
    }

    public function GetDataTemoignages()
    {

        $select = '*';
        return $this->db->select($select)
            ->from("temoignage")
            ->get()->result();


    }

    public function GetDataBlocks()
    {

        $select = '*';
        return $this->db->select($select)
            ->from("block_site")
            ->get()->result();


    }

    public function GetDataCompetences()
    {

        $select = '*';
        return $this->db->select($select)
            ->from("competences")
            ->get()->result();


    }

    public function GetDataParlents()
    {

        $select = '*';
        return $this->db->select($select)
            ->from("parlents")
            ->get()->result();


    }

    public function GetDataCovertures()
    {

        $select = '*';
        return $this->db->select($select)
            ->from($this->covertures)
            ->get()->result();


    }

    public function getAnnonceById($id)
    {
        $select = '*,talent.id as id,talent.cover as cover,talent.date_creation as date_creation';
        return $this->db->select($select)
            ->from("talent")
            ->join("user", "user.id=talent.user_id")
            ->where("talent.id", $id)
            ->get()->row();
    }

    public function GetAllAnnonces()
    {
        $select = '*,talent.id as id,talent.cover as cover,talent.date_creation as date_creation';
        return $this->db->select($select)
            ->from("talent")
            ->join("user", "user.id=talent.user_id")
            ->where('status', '1')
            ->get()->result();
    }

    public function GetAllCoupDeCoeur()
    {
        $select = '*,talent.id as id,talent.cover as cover,talent.date_creation as date_creation';
        return $this->db->select($select)
            ->from("talent")
            ->join("user", "user.id=talent.user_id")
            ->where("talent.coup_des_cour", true)
            ->get()->result();
    }

    public function GetOneElement($id, $table, $column = null)
    {

        $select = '*';

        $where = array($column == null ? 'id' : "$column" => $id);

        return $this->db->select($select)
            ->from($table)
            ->where($where)->get()->row();

    }


    public function GetAllResultsElements($conf = array())
    {

        $select = '*';

        $where = array($conf['column'] == null ? 'id' : $conf['column'] => $conf['id'], 'status' => 1);

        return $this->db->select($select)
            ->from($conf['table'])
            ->where($where)->get()->result();

    }

    public function GetDataVille()
    {
        //$time_start = microtime(true);
        $rows_results = array();
        $select = 'ville_id,ville_nom';
        $this->db->cache_off();
        $list = $this->db->select($select)
            ->from($this->ville)
            //->limit($conf['limit'],$conf['start'])
            ->get()->result();


        // 0.00048995018005371
        //0.00077080726623535
        foreach ($list as $row) {

            $rows_results[] = array(
                'id' => $row->ville_id,
                'nom' => $row->ville_nom,
                'supp' => " <button class='btn btn-sm btn-icon btn-danger' onclick=\"angular.element(this).scope().supprimer(" . $row->ville_id . ")\"><i class='fa fa-trash-o'></i></button> <button class='btn btn-sm btn-icon btn-info' onclick=\"angular.element(this).scope().editer(" . $row->ville_id . ")\"><i class='fa fa-pencil'></i></button>",
                'ticked' => false
            );
        }
        // $time_end = microtime(true);
        // $time = date("H:i:s",$time_end - $time_start);

        $data['list'] = $rows_results;
        //$data['time']=$time ;
        return $data;


    }

    public function GetDataUsers()
    {

        $select = '*';
        return $this->db->select($select)
            ->from($this->user)
            ->order_by("date_creation", "desc")
            ->get()->result();

    }

    public function GetDataConfig()
    {

        $select = '*';
        return $this->db->select($select)
            ->from($this->config)
            ->get()->result();


    }

    public function GetDataCategorieGroupe()
    {

        $select = 'id, nom,image,active';
        return $this->db->select($select)
            ->from($this->categorie_groupe)
            ->get()->result();


    }

    public function GetDataCarteType()
    {

        $select = '*';
        return $this->db->select($select)
            ->from($this->carte_type)
            ->get()->result();


    }

    public function GetDataLang()
    {

        $select = '*';
        return $this->db->select($select)
            ->from($this->language)
            ->get()->result();


    }

    public function GetDataSecteurs()
    {

        $select = '*';
        return $this->db->select($select)
            ->from("secteur_activite")
            ->get()->result();


    }

    public function GetAllFonctions()
    {

        $select = '*';
        return $this->db->select($select)
            ->from("categorie")
            ->get()->result();


    }

    public function GetDataTags()
    {
        $select = '*';
        return $this->db->select($select)
            ->from("tags")
            ->get()->result();
    }

    public function GetDataEntreprise()
    {
        $select = '*';
        return $this->db->select($select)
            ->from("entreprise")
            ->get()->result();
    }

    public function GetDataAdmin()
    {

        $select = '*';
        return $this->db->select($select)
            ->from($this->admin)
            ->get()->result();


    }

    public function GetOneAdmin($id)
    {

        $select = '*';

        $where = array('id' => $id);

        return $this->db->select($select)
            ->from($this->admin)
            ->where($where)->get()->row();

    }

    public function AddElement($add = array(), $table)
    {

        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert($table);
        return $this->db->insert_id();

    }

    public function DeleteElement($id, $table, $column = null)

    {

        $this->db->delete($table, array($column == null ? 'id' : "$column" => $id));

        return true;

    }

    public function EditerElement($id, $data = array(), $table, $column = null)
    {
        if (empty($data)) {
            return false;
        }
        return (bool)$this->db->set($data)
            ->where($column == null ? 'id' : "$column", $id)->update($table);
    }

    public function ConnexionCheck($email, $password)
    {
        $this->load->library('encrypt');

        $select = '*';
        $where = array('email' => $email);
        $result = $this->db->select($select)
            ->from($this->admin)
            ->where($where)
            ->get()
            ->row();
        if (!empty($result)) {
            if ($this->encrypt->decode($result->password) == $password) {
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
}