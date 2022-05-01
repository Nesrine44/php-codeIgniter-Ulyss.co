<?php

Class Talent_model extends CI_Model
{
    protected $table = 'talent';

    public function __construct()
    {
        parent::__construct();

    }

    /*categories*/
    public function getBlock($id)
    {
        $where = ["id" => $id];

        return $this->db->select('*')
            ->from('block_site')
            ->where($where)
            ->get()->row();
    }

    public function getDisponibiliteTalent($id)
    {
        $where = ["talent_id" => $id];

        return $this->db->select('*')
            ->from('talent_horaire')
            ->where($where)
            ->get()->row();
    }

    public function GetLangues($id)
    {
        $select = '*,talent_language.id as id';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_language')
            ->join("language", "language.id=talent_language.langue_id")
            ->where($where)
            ->get()
            ->result();
    }

    public function GetLangue($id)
    {
        $select = '*';
        $where  = ["id" => $id];

        return $this->db->select($select)
            ->from('language')
            ->where($where)
            ->get()
            ->row();
    }

    /*get name entreprise*/
    public function getNameEntreprise($id)
    {
        $select = '*';
        $where  = ["id" => $id];

        return $this->db->select($select)
            ->from('entreprise')
            ->where($where)
            ->get()
            ->row();
    }

    public function GetTemoignages($type)
    {
        $select = '*';
        $where  = ["type" => $type];

        return $this->db->select($select)
            ->from('temoignage')
            ->where($where)
            ->get()
            ->result();
    }

    public function GetParlents($type)
    {
        $select = '*';
        $where  = ["type" => $type];

        return $this->db->select($select)
            ->from('parlents')
            ->where($where)
            ->get()
            ->result();
    }


    public function GetTags($id)
    {
        $select = '*,talent_tag.id as id';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_tag')
            ->join("tags", "tags.id=talent_tag.tag_id")
            ->where($where)
            ->get()
            ->result();
    }

    public function addCommentaire($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("talent_comment");

        return true;
    }

    public function getCommentaire($id)
    {
        $select = '*';
        $where  = ["demande_talen_id" => $id];

        return $this->db->select($select)
            ->from('talent_comment')
            ->where($where)
            ->get()
            ->row();
    }

    public function getIdEntrepriseByName($name, $data)
    {
        $select     = '*';
        $where      = ["nom" => $name];
        $entreprise = $this->db->select($select)
            ->from('entreprise')
            ->where($where)
            ->get()
            ->row();
        if (empty($entreprise)) {
            $data['nom'] = $name;

            return $this->addEntreprise($data);
        } else {
            return $entreprise->id;
        }

    }

    public function getIdTagByName($name)
    {
        $select = '*';
        $where  = ["nom" => $name];
        $tag    = $this->db->select($select)
            ->from('tags')
            ->where($where)
            ->get()
            ->row();

        if (empty($tag)) {
            $data['nom'] = $name;
            $this->addTag($data);
        } else {
            return $tag->id;
        }

    }

    public function addEntreprise($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("entreprise");

        return $this->db->insert_id();
    }

    public function addTag($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("tags");

        return $this->db->insert_id();
    }

    public function AjouterDocTotalent($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("talent_document");

        return true;
    }

    public function addReservation($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("talent_demandes_reservations");

        return true;
    }

    public function AddTalentFormation($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("talent_formation");

        return $this->db->insert_id();
    }

    public function AddTalentExperience($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("talent_experience");

        return $this->db->insert_id();
    }

    public function AddTalentTag($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("talent_tag");

        return true;
    }

    public function AddTalentLangue($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("talent_language");

        return $this->db->insert_id();
    }

    public function AddTalentHoraire($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }
        $this->db->where('talent_id', $add['talent_id']);
        $this->db->delete('talent_horaire');

        $this->db->set($add)
            ->insert("talent_horaire");

        return $this->db->insert_id();
    }

    public function GetGroupCategorie()
    {
        $select = '*';

        return $this->db->select($select)
            ->from('categorie_groupe')
            ->get()
            ->result();
    }

    public function getCatRow($id)
    {
        $select = '*';

        return $this->db->select($select)
            ->from('categorie_groupe')
            ->where('id', $id)
            ->get()
            ->row();
    }

    public function getSCatRow($id)
    {
        $select = '*';

        return $this->db->select($select)
            ->from('categorie')
            ->where('id', $id)
            ->get()
            ->row();
    }

    public function getTagName($id)
    {
        $select = '*';

        return $this->db->select($select)
            ->from('tags')
            ->where('id', $id)
            ->get()
            ->row();
    }

    public function getSecteurName($id)
    {
        $select = '*';

        return $this->db->select($select)
            ->from('secteur_activite')
            ->where('id', $id)
            ->get()
            ->row();
    }

    public function getsousCategories($id)
    {
        $select = '*';
        $where  = ["categorie_group_id" => $id];

        return $this->db->select($select)
            ->from('categorie')
            ->where($where)
            ->get()
            ->result();
    }

    public function getDepartByFonctions($id)
    {
        $select = 'categorie_groupe.id as id,categorie_groupe.nom as nom';

        return $this->db->select($select)
            ->from('departement_fonctions')
            ->join("categorie_groupe", "categorie_groupe.id=departement_fonctions.departement_id")
            ->where("fonction_id", $id)
            ->get()
            ->result();
    }

    public function getFonctionsByDepart($id)
    {
        $select = 'categorie.id as id,categorie.nom as nom';

        return $this->db->select($select)
            ->from('departement_fonctions')
            ->join("categorie", "categorie.id=departement_fonctions.fonction_id")
            ->where("departement_id", $id)
            ->get()
            ->result();
    }

    /*end cat*/
    public function GetCommentairestomesTalent($id)
    {
        $select = '*,talent_comment.date_creation as date_creation';
        $where  = ["talent.user_id" => $id];

        return $this->db->select($select)
            ->from('talent_comment')
            ->join('talent', 'talent.id=talent_comment.talent_id')
            ->join('user', 'user.id=talent_comment.comment_user_id')
            ->order_by("talent_comment.date_creation", "DESC")
            ->where($where)
            ->get()
            ->result();
    }

    public function GetCommentairestomesTalent1($id, $id_talent)
    {
        $select = '*,talent_comment.date_creation as date_creation';
        $where  = ["talent.user_id" => $id, "talent.id" => $id_talent];

        return $this->db->select($select)
            ->from('talent_comment')
            ->join('talent', 'talent.id=talent_comment.talent_id')
            ->join('user', 'user.id=talent_comment.comment_user_id')
            ->where($where)
            ->order_by("talent_comment.date_creation", "DESC")
            ->get()
            ->result();
    }

    public function getListTalentAyantCommentaire($id)
    {
        $select = 'talent.titre as titre,talent.id as id';
        $where  = ["talent.user_id" => $id];

        return $this->db->distinct('talent.id')->select($select)
            ->from('talent_comment')
            ->join('talent', 'talent.id=talent_comment.talent_id')
            ->join('user', 'user.id=talent_comment.comment_user_id')
            ->where($where)
            ->group_by('talent.id')
            ->get()
            ->result();
    }

    public function GetCommentairesEnvoyes($id)
    {
        $select = '*,talent_comment.date_creation as date_creation';
        $where  = ["talent_comment.comment_user_id" => $id];

        return $this->db->select($select)
            ->from('talent_comment')
            ->join('talent', 'talent.id=talent_comment.talent_id')
            ->join('user', 'user.id=talent_comment.comment_user_id')
            ->where($where)
            ->order_by("talent_comment.date_creation", "DESC")
            ->get()
            ->result();
    }

    public function GetCommentairesEnvoyes1($id, $id_talent)
    {
        $select = '*,talent_comment.date_creation as date_creation';
        $where  = ["talent_comment.comment_user_id" => $id, "talent.id" => $id_talent];

        return $this->db->select($select)
            ->from('talent_comment')
            ->join('talent', 'talent.id=talent_comment.talent_id')
            ->join('user', 'user.id=talent_comment.comment_user_id')
            ->where($where)
            ->order_by("talent_comment.date_creation", "DESC")
            ->get()
            ->result();
    }

    public function GetCommentairesAyantEnvoyes($id)
    {
        $select = 'talent.titre as titre,talent.id as id';

        $where = ["talent_comment.comment_user_id" => $id];

        return $this->db->distinct('talent.id')->select($select)
            ->from('talent_comment')
            ->join('talent', 'talent.id=talent_comment.talent_id')
            ->join('user', 'user.id=talent_comment.comment_user_id')
            ->where($where)
            ->order_by("talent_comment.date_creation", "DESC")
            ->group_by('talent.id')
            ->get()
            ->result();
    }

    public function GetCommentairesByTalent($id)
    {
        $select = '*,talent_comment.date_creation as date_creation';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_comment')
            ->join('user', 'user.id=talent_comment.comment_user_id')
            ->where($where)
            ->get()
            ->result();
    }

    public function GetcountCompTalent($id)
    {
        $select = '*,talent_comment.date_creation as date_creation';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_comment')
            ->join('user', 'user.id=talent_comment.comment_user_id')
            ->where($where)
            ->count_all_results();
    }

    public function GetSumNoteCmtTalent($id)
    {
        $select = '*,talent_comment.date_creation as date_creation';
        $where  = ["talent_id" => $id];

        return $this->db->select_sum('note')
            ->from('talent_comment')
            ->join('user', 'user.id=talent_comment.comment_user_id')
            ->where($where)
            ->get()->row();
    }

    public function GetCategorie_search($q)
    {
        $this->db->select('*');
        $this->db->like('nom', $q);
        $query   = $this->db->get('categorie_groupe');
        $row_set = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['value'] = $row['nom'];
                $new_row['id']    = $row['id'];
                $row_set[]        = $new_row;
            }

        }
        echo json_encode($row_set); //format the array into json data
    }

    public function getFonctionsearch($q)
    {
        $this->db->select('*');
        $this->db->like('nom', $q);
        $query   = $this->db->get('categorie');
        $row_set = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['value'] = $row['nom'];
                $new_row['id']    = $row['id'];
                $row_set[]        = $new_row;
            }

        }
        echo json_encode($row_set); //format the array into json data
    }

    public function getSecteursList($q)
    {
        $this->db->select('*');
        $this->db->like('nom', $q);
        $query   = $this->db->get('secteur_activite');
        $row_set = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['value'] = $row['nom'];
                $new_row['id']    = $row['id'];
                $row_set[]        = $new_row;
            }
        }
        echo json_encode($row_set); //format the array into json data
    }


    public function getCmpList($q)
    {
        $this->db->select('*');
        $this->db->like('nom', $q);
        $query   = $this->db->get('tags');
        $row_set = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['value'] = $row['nom'];
                $new_row['id']    = $row['id'];
                $row_set[]        = $new_row;
            }

        }
        echo json_encode($row_set); //format the array into json data
    }

    public function getEntrepriseList($q)
    {
        $sql
            = ' SELECT entreprise.nom AS value, entreprise.logo as logo, entreprise.id AS id, entreprise.secteur_id as secteur_id,secteur_activite.nom as secteur_nom
                        FROM entreprise 
                        INNER JOIN talent_experience
                          ON talent_experience.entreprise_id = entreprise.id
                        INNER JOIN talent
                          ON talent.id = talent_experience.talent_id
                          AND talent.status = :status
                        INNER JOIN secteur_activite
                          ON entreprise.secteur_id = secteur_activite.id
                        WHERE entreprise.nom LIKE :nom
                        GROUP BY entreprise.id
                        ORDER BY entreprise.nom ASC
                        LIMIT 10
                      ';
        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindValue(':nom', '%' . $q . '%');
        $stmt->bindValue(':status', ModelTalent::VALID);
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function getAllEntrepriseList($q)
    {
        $sql
            = ' SELECT entreprise.nom AS value, entreprise.logo as logo, entreprise.id AS id
                        FROM entreprise
                        WHERE entreprise.nom LIKE :nom
                        GROUP BY entreprise.id
                        ORDER BY entreprise.nom ASC
                        LIMIT 10
                      ';
        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindValue(':nom', '%' . $q . '%');
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function getEntrepriseListAvanced($q)
    {
        $sql
            = ' SELECT entreprise.nom AS value, entreprise.logo as logo, entreprise.id AS id, entreprise.secteur_id as secteur_id,secteur_activite.nom as secteur_nom
                        FROM entreprise
                        INNER JOIN talent_experience
                          ON talent_experience.entreprise_id = entreprise.id
                        INNER JOIN secteur_activite
                          ON entreprise.secteur_id = secteur_activite.id
                        WHERE entreprise.nom LIKE :nom
                        GROUP BY entreprise.id
                        ORDER BY entreprise.nom ASC
                        LIMIT 10';
        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindValue(':nom', $q . '%');
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSchoolList($q)
    {
        $sql
            = ' SELECT ecoles.name AS value, ecoles.id AS id
                        FROM ecoles 
                        WHERE ecoles.name LIKE :nom
                        GROUP BY ecoles.id
                        ORDER BY name ASC limit 10
                      ';
        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindValue(':nom', '%' . $q . '%');
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function GetVille_search($q)
    {
        $this->db->select('*');
        $this->db->like('ville_nom', $q, 'after');
        $this->db->or_like('ville_code_postal', $q);
        $query   = $this->db->get('villes');
        $row_set = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $new_row['value'] = $row['ville_nom'] . '-' . $row['ville_code_postal'];
                $new_row['id']    = $row['ville_id'];
                $row_set[]        = $new_row;
            }

        }
        echo json_encode($row_set); //format the array into json data
    }

    public function GetTalentsByAlias($alias = "")
    {
        $select = '*';
        $where  = ["alias" => $alias];

        return $this->db->select($select)
            ->from('talent')
            ->where($where)
            ->get()
            ->row();
    }

    public function GetReferences($id)
    {
        $select = '*';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_reference')
            ->where($where)
            ->get()
            ->result();
    }

    public function GetCategories($id)
    {
        $select = 'talent_categorie.id as id,categorie_groupe.nom as nom,talent_id';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_categorie')
            ->join("categorie_groupe", "categorie_groupe.id=talent_categorie.categorie_id")
            ->where($where)
            ->get()
            ->result();
    }

    public function GetCategoriesList()
    {
        $select = 'nom,id';

        return $this->db->select($select)
            ->from('categorie_groupe')
            ->where("active", 1)
            ->get()
            ->result();
    }

    public function GetCategoriesTalent($id)
    {
        $select = '*';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_categorie')
            ->join("categorie", "categorie.id=talent_categorie.categorie_id")
            ->where($where)
            ->get()
            ->result();
    }

    public function GetExperiences($id)
    {
        $select = '*, CONCAT(date_debut, date_fin) AS dates';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_experience')
            ->where($where)
            ->order_by('dates', 'DESC')
            ->get()
            ->result();
    }

    public function GetExperiencesWithEntrepise($id)
    {
        $select = '*,categorie_groupe.nom as departement,entreprise.nom as nom,categorie.nom as fonction,secteur_activite.nom as secteur';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_experience')
            ->join("entreprise", "entreprise.id=talent_experience.entreprise_id")
            ->join("categorie_groupe", "categorie_groupe.id=talent_experience.departement_id", 'left')
            ->join("categorie", "categorie.id=talent_experience.fonction_id", 'left')
            ->join("secteur_activite", "secteur_activite.id=talent_experience.secteur_id", 'left')
            ->where($where)
            ->get()
            ->result();
    }

    public function GetFormations($id)
    {
        $select = '*';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_formation')
            ->where($where)
            ->get()
            ->result();
    }

    public function GetPortfolio($id)
    {
        $select = '*';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_portfolio')
            ->where($where)
            ->get()
            ->result();
    }

    public function GetDocuments($id)
    {
        $select = '*';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_document')
            ->where($where)
            ->get()
            ->result();
    }

    public function GetDisponibleOftalent($id)
    {
        $select = '*';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_horaire')
            ->where($where)
            ->get()
            ->row();
    }

    public function modeOperatoire($id)
    {
        $select = '*';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_mode_operatoire')
            ->where($where)
            ->get()
            ->result();
    }

    public function AddTalent($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $Talent = $this->GetTalentByUserId($add['user_id']);
        if (isset($Talent->id)) {
            $this->db->set($add)
                ->update("talent");

            return $Talent->id;
        } else {
            $this->db->set($add)
                ->insert("talent");

            return $this->db->insert_id();
        }

    }

    public function AjouterCategorie($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $select = '*';
        $where  = ["talent_id" => $add['talent_id'], "categorie_id" => $add['categorie_id']];
        $verif  = $this->db->select($select)
            ->from('talent_categorie')
            ->where($where)
            ->get()
            ->row();
        if (empty($verif)) {
            $this->db->set($add)
                ->insert("talent_categorie");

            return $this->db->insert_id();
        } else {
            return true;
        }
    }

    public function AddVueTalent($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        //prendre la derniere date de la Base de doneés
        $select = '*';
        $where  = ["talent_id" => $add['talent_id'], "user_id" => $add['user_id']];
        $verif  = $this->db->select($select)
            ->from('talent_vues')
            ->where($where)
            ->where('date_creation IN ', '(SELECT max(date_creation) FROM talent_vues WHERE talent_id = ' . $add['talent_id'] . ' AND user_id = ' . $add['user_id'] . ')', false)
            ->get()
            ->row();
        if (empty($verif)) {
            $this->db->set($add)
                ->insert("talent_vues");

            return $this->db->insert_id();
        } elseif (!empty($verif) && isset($verif->date_creation)) {
            $jourActuel = date('d');
            $jour       = date('d', strtotime($verif->date_creation));
            if ($jourActuel != $jour) {
                $this->db->set($add)
                    ->insert("talent_vues");

                return $this->db->insert_id();
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function AddTalentCategorie($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("talent_categorie");

        return $this->db->insert_id();
    }

    public function AjouterLangueTouser($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("user_language");

        return true;
    }

    public function AjouterModeTouser($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("talent_formation");

        return true;
    }

    public function AjouterPortfolioTotalent($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("talent_portfolio");

        return true;
    }

    public function AjouterReferenceToTalent($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("talent_reference");

        return true;
    }

    public function AjouterExperienceToTalent($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        $this->db->set($add)
            ->insert("talent_experience");

        return true;
    }

    public function verifcationExistAlias($string)
    {
        $select = '*';
        $where  = ["alias" => $string];

        return $this->db->select($select)
            ->from('talent')
            ->where($where)
            ->get()
            ->result();
    }

    public function EditTalentByiAndIduser($id, $id_user, $data = [])
    {
        //  Vérification des données à mettre à jour
        if (empty($data)) {
            return false;
        }


        return (bool)$this->db->set($data)
            ->where('id', $id)
            ->where('user_id', $id_user)
            ->update("talent");
    }

    public function EditerTalentHoraire($id, $data = [])
    {
        //  Vérification des données à mettre à jour
        if (empty($data)) {
            return false;
        }


        return (bool)$this->db->set($data)
            ->where('talent_id', $id)
            ->update("talent_horaire");
    }


    public function EditTalent($id, $data = [])
    {
        //  Vérification des données à mettre à jour
        if (empty($data)) {
            return false;
        }


        return (bool)$this->db->set($data)
            ->where('id', $id)
            ->update("talent");
    }

    public function GetFavorisUser($id)
    {
        $select = '*,talent_favoris.id as id,talent.user_id as talent_user_id';
        $where  = ["talent_favoris.user_id" => $id];

        return $this->db->select($select)
            ->from('talent_favoris')
            ->join('talent', 'talent.id=talent_favoris.talent_id')
            ->where($where)
            ->get()
            ->result();
    }

    public function deleteReservationDemande($id)
    {
        $this->db->delete('talent_demandes_reservations', ['talent_demandes_id' => $id]);
    }

    public function DeleteCategorie($id)
    {
        $this->db->delete('talent_categorie', ['id' => $id]);
    }

    public function DeleteLangueT($id)
    {
        $this->db->delete('talent_language', ['id' => $id]);
    }

    public function DeleteTagT($id)
    {
        $this->db->delete('talent_tag', ['id' => $id]);
    }

    public function DeleteLangue($id, $id_user)
    {
        $this->db->delete('user_language', ['id' => $id, "user_id" => $id_user]);
    }

    public function DeleteMode($id)
    {
        $this->db->delete('talent_formation', ['id' => $id]);
    }

    public function DeleteReferences($id)
    {
        $this->db->delete('talent_reference', ['id' => $id]);
    }

    public function DeleteExperience($id)
    {
        $this->db->delete('talent_experience', ['id' => $id]);
    }

    public function DeletePortfolio($id)
    {
        $this->db->delete('talent_portfolio', ['id' => $id]);
    }

    public function DislikeFavoris($id, $id_user)
    {
        $this->db->delete('talent_favoris', ['id' => $id, "user_id" => $id_user]);
    }

    public function GetTalent($id = "")
    {
        $select = '*';
        $where  = ["id" => $id];

        return $this->db->select($select)
            ->from('talent')
            ->where($where)
            ->get()
            ->row();
    }

    public function GetTalentUser($id = "")
    {
        $select = '*,user.alias as alias,talent.alias as alias_t';
        $where  = ["talent.id" => $id];

        return $this->db->select($select)
            ->from('user')
            ->join('talent', 'talent.user_id=user.id')
            ->where($where)
            ->get()
            ->row();
    }

    public function GetTalentByUserId($user_id = "")
    {
        $select = '*';
        $where  = ["user_id" => $user_id];

        return $this->db->select($select)
            ->from('talent')
            ->where($where)
            ->get()
            ->row();
    }

    public function GetUserByid($id = 0)
    {
        $select = '*';
        $where  = ["id" => $id];

        return $this->db->select($select)
            ->from('user')
            ->where($where)
            ->get()
            ->row();
    }

    public function GetUser($id = 0)
    {
        $select = '*';
        $where  = ["id" => $id];

        return $this->db->select($select)
            ->from('user')
            ->where($where)
            ->get()
            ->row();
    }

    public function getTalentBysearch($data = [])
    {
        $select = 'talent.id as id,talent.description as description,talent.alias as alias_t,user.alias as alias_u,villes.ville_latitude_deg as lat,villes.ville_longitude_deg as lng,villes.ville_nom as ville';
        $this->db->select($select);
        $this->db->from('talent');
        if (!empty($data['categorie']) && $data['categorie'] != 0) {
            $this->db->join('talent_categorie', 'talent.id=talent_categorie.talent_id');
            //$this->db->join('categorie','categorie.id=talent_categorie.categorie_id');
            $this->db->join('categorie_groupe', 'categorie_groupe.id=talent_categorie.categorie_id');
        }
        $this->db->join('user', 'user.id=talent.user_id');
        $this->db->join('villes', 'talent.ville=villes.ville_id', 'left');

        if (!empty($data['langue']) && $data['langue'] != 0) {
            $this->db->join('talent_language', 'talent.id=talent_language.talent_id');
        }
        if (!empty($data['niveau']) && $data['niveau'] != 0) {
            $this->db->join('talent_tag', 'talent.id=talent_tag.talent_id');
        }
        if (empty($data['niveau']) && $data['materiel'] != 0) {
            $this->db->join('talent_tag', 'talent.id=talent_tag.talent_id');
        }
        if (!empty($data['date']) && $data['date'] != 0) {
            $this->db->join('talent_horaire', 'talent.id=talent_horaire.talent_id');
        }
        $this->db->where("talent.status", true);
        $this->db->where("talent.statut_admin", "Accepté");

        // $this->db->where("talent.valide",true);
        if (!empty($data['categorie']) && $data['categorie'] != 0) {
            $this->db->where("categorie_groupe.id", $data['categorie']);
        }
        if (!empty($data['ville']) && $data['ville'] != 0) {


            /*                $this->db->where("villes.ville_longitude_deg >=",$data['lng']-$data['config_distance']);
                            $this->db->where("villes.ville_longitude_deg <=",$data['lng']+$data['config_distance']);

                            $this->db->where("villes.ville_latitude_deg >=",$data['lat']-$data['config_distance']);
                            $this->db->where("villes.ville_latitude_deg <=",$data['lat']+$data['config_distance']); */
            $this->db->where("talent.ville", $data['ville']);
        }
        if (!empty($data['sous_cat']) && $data['sous_cat'] != 0) {
            $this->db->where("categorie.id", $data['sous_cat']);
        }
        if (!empty($data['langue']) && $data['langue'] != 0) {
            $this->db->where_in("talent_language.langue_id", $data['langue']);

        }
        if (!empty($data['niveau']) && $data['niveau'] != 0) {
            $this->db->where("talent_tag.tag_id", $data['niveau']);
        }

        /*disponibilite*/
        if (!empty($data['date']) && $data['date'] != 0) {
            $name_day = $this->getNameDay($data['date']);

            $name_1   = $name_day . "_8_10";
            $name_2   = $name_day . "_10_12";
            $name_3   = $name_day . "_12_14";
            $name_4   = $name_day . "_14_16";
            $name_5   = $name_day . "_16_18";
            $name_6   = $name_day . "_18_20";
            $name_7   = $name_day . "_20_22";
            $where_au = "(talent_horaire." . $name_1 . " ='1' OR talent_horaire." . $name_2 . " ='1' OR talent_horaire." . $name_3 . " ='1' OR talent_horaire." . $name_4 . " ='1' OR talent_horaire." . $name_5 . " ='1' OR talent_horaire." . $name_6 . " ='1' OR talent_horaire." . $name_7 . " ='1')";
            $this->db->where($where_au);

        }


        if ($data['materiel'] != 0) {
            $this->db->where("talent_tag.tag_id", $data['materiel']);
        }
        if ($data['prof'] != 0) {
            $this->db->where("talent.pro", 1);
        }
        if ($data['experience_pro'] != 0) {
            $nbr_month     = $data['experience_pro'];
            $effectiveDate = date("Y-m-d h:i:s");
            $effectiveDate = strtotime("-" . $nbr_month . " months", strtotime($effectiveDate));
            $next          = date("Y-m-d h:i:s", $effectiveDate);
            $this->db->where("user.date_creation <=", $next);
        }

        $this->db->where("talent.prix >=", $data['min_t']);
        $this->db->where("talent.prix <=", $data['max_t']);
        $this->db->order_by('talent.date_creation', 'desc');
        $this->db->group_by("talent.id");

        return $this->db->get()->result();
    }

    function getNameDay($date = null)
    {
        if (!$date) {
            $date = date("Y-m-d");
        }
        $date1      = explode("/", $date);
        $date       = $date1[2] . "-" . $date1[1] . "-" . $date1[0];
        $list_week  = ["jour", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche"];
        $day_number = date('N', strtotime($date));
        $name_day   = $list_week[$day_number];

        return $name_day;
    }

    /*with limit and offset*/
    public function getTalentBysearchWithOffset($data = [], $limit, $start)
    {

        $select = 'talent.prix as prix,user.avatar as avatar,user.nom as nom,user.prenom as prenom,talent.id as id,talent.description as description,talent.alias as alias_t,user.alias as alias_u,villes.ville_latitude_deg as lat,villes.ville_longitude_deg as lng,,villes.ville_nom as ville,ville_code_postal';
        $this->db->select($select);
        $this->db->from('talent');
        if (!empty($data['categorie']) && $data['categorie'] != 0) {
            $this->db->join('talent_categorie', 'talent.id=talent_categorie.talent_id');
            //$this->db->join('categorie','categorie.id=talent_categorie.categorie_id');
            $this->db->join('categorie_groupe', 'categorie_groupe.id=talent_categorie.categorie_id');
        }
        $this->db->join('user', 'user.id=talent.user_id');
        $this->db->join('villes', 'talent.ville=villes.ville_id', 'left');
        if (!empty($data['langue']) && $data['langue'] != 0) {
            $this->db->join('talent_language', 'talent.id=talent_language.talent_id');
        }
        if (!empty($data['niveau']) && $data['niveau'] != 0) {
            $this->db->join('talent_tag', 'talent.id=talent_tag.talent_id');
        }
        if (empty($data['niveau']) && $data['materiel'] != 0) {
            $this->db->join('talent_tag', 'talent.id=talent_tag.talent_id');
        }


        if (!empty($data['date']) && $data['date'] != 0) {
            $this->db->join('talent_horaire', 'talent.id=talent_horaire.talent_id');
        }

        $this->db->where("talent.status", true);
        $this->db->where("talent.statut_admin", "Accepté");
        //$this->db->where("talent.valide",true);

        if (!empty($data['categorie']) && $data['categorie'] != 0) {
            $this->db->where("categorie_groupe.id", $data['categorie']);
        }
        if (!empty($data['ville']) && $data['ville'] != 0) {


            /*                $this->db->where("villes.ville_longitude_deg >=",$data['lng']-$data['config_distance']);
                            $this->db->where("villes.ville_longitude_deg <=",$data['lng']+$data['config_distance']);

                            $this->db->where("villes.ville_latitude_deg >=",$data['lat']-$data['config_distance']);
                            $this->db->where("villes.ville_latitude_deg <=",$data['lat']+$data['config_distance']);*/
            $this->db->where("talent.ville", $data['ville']);
        }
        if (!empty($data['sous_cat']) && $data['sous_cat'] != 0) {
            $this->db->where("categorie.id", $data['sous_cat']);
        }
        if (!empty($data['langue']) && $data['langue'] != 0) {
            $this->db->where_in("talent_language.langue_id", $data['langue']);
        }
        if (!empty($data['niveau']) && $data['niveau'] != 0) {
            $this->db->where("talent_tag.tag_id", $data['niveau']);
        }

        /*disponibilite*/

        if (!empty($data['date']) && $data['date'] != 0) {
            $name_day = $this->getNameDay($data['date']);

            $name_1   = $name_day . "_8_10";
            $name_2   = $name_day . "_10_12";
            $name_3   = $name_day . "_12_14";
            $name_4   = $name_day . "_14_16";
            $name_5   = $name_day . "_16_18";
            $name_6   = $name_day . "_18_20";
            $name_7   = $name_day . "_20_22";
            $where_au = "(talent_horaire." . $name_1 . " ='1' OR talent_horaire." . $name_2 . " ='1' OR talent_horaire." . $name_3 . " ='1' OR talent_horaire." . $name_4 . " ='1' OR talent_horaire." . $name_5 . " ='1' OR talent_horaire." . $name_6 . " ='1' OR talent_horaire." . $name_7 . " ='1')";
            $this->db->where($where_au);

        }
        if ($data['materiel'] != 0) {
            $this->db->where("talent_tag.tag_id", $data['materiel']);
        }
        if ($data['prof'] != 0) {
            $this->db->where("talent.pro", 1);
        }
        if ($data['experience_pro'] != 0) {
            $nbr_month     = $data['experience_pro'];
            $effectiveDate = date("Y-m-d h:i:s");
            $effectiveDate = strtotime("-" . $nbr_month . " months", strtotime($effectiveDate));
            $next          = date("Y-m-d h:i:s", $effectiveDate);
            $this->db->where("user.date_creation <=", $next);
        }
        $this->db->where("talent.prix >=", $data['min_t']);
        $this->db->where("talent.prix <=", $data['max_t']);

        if ($data['order'] == 'date') {
            $this->db->order_by('talent.date_creation', 'desc');
        } elseif ($data['order'] == 'nom') {
            $this->db->order_by('talent.titre', 'desc');
        } elseif ($data['order'] == 'profession') {
            $this->db->order_by('talent.profession', 'desc');
        } else {
            $this->db->order_by('talent.titre', 'desc');
        }
        $this->db->group_by("talent.id");

        $this->db->limit($limit, $start);

        return $this->db->get()->result();
    }

    public function getTalentBysearchWithOffsetULYSS($data = [], $limit, $start)
    {

        $select = 'entreprise.nom as entreprise,DATEDIFF(date_fin,date_debut) + 1 AS total_date,talent.prix as prix,user.avatar as avatar,user.nom as nom,user.prenom as prenom,talent.id as id,talent.description as description,talent.alias as alias_t,user.alias as alias_u,villes.ville_latitude_deg as lat,villes.ville_longitude_deg as lng,,villes.ville_nom as ville,ville_code_postal';
        $this->db->select($select);
        $this->db->from('talent');
        $this->db->join('talent_experience', 'talent.id=talent_experience.talent_id');
        $this->db->join('entreprise', 'entreprise.id=talent_experience.entreprise_id');
        $this->db->join('user', 'user.id=talent.user_id');
        $this->db->join('villes', 'talent.ville=villes.ville_id', 'left');

        if (!empty($data['date']) && $data['date'] != 0) {
            $this->db->join('talent_horaire', 'talent.id=talent_horaire.talent_id');
        }

        if (!empty($data['categorie']) && $data['categorie'] != 0) {
            $this->db->where("talent_experience.departement_id", $data['categorie']);
        }
        if (!empty($data['entreprise']) && $data['entreprise'] != 0) {
            $this->db->where("entreprise.id", $data['entreprise']);
        }

        if (!empty($data['ville']) && $data['ville'] != 0) {
            $this->db->where("talent.ville", $data['ville']);
        }
        if (!empty($data['sous_cat']) && $data['sous_cat'] != 0) {
            $this->db->where("talent_experience.fonction_id", $data['sous_cat']);
        }
        if (!empty($data['secteur']) && $data['secteur'] != 0) {
            $this->db->where("talent_experience.secteur_id", $data['secteur']);
        }


        /*disponibilite*/

        if (!empty($data['date']) && $data['date'] != 0) {
            $name_day = $this->getNameDay($data['date']);

            $name_1   = $name_day . "_8_10";
            $name_2   = $name_day . "_10_12";
            $name_3   = $name_day . "_12_14";
            $name_4   = $name_day . "_14_16";
            $name_5   = $name_day . "_16_18";
            $name_6   = $name_day . "_18_20";
            $name_7   = $name_day . "_20_22";
            $where_au = "(talent_horaire." . $name_1 . " ='1' OR talent_horaire." . $name_2 . " ='1' OR talent_horaire." . $name_3 . " ='1' OR talent_horaire." . $name_4 . " ='1' OR talent_horaire." . $name_5 . " ='1' OR talent_horaire." . $name_6 . " ='1' OR talent_horaire." . $name_7 . " ='1')";
            $this->db->where($where_au);

        }
        /*               if($data['materiel']!=0){
                        $this->db->where("talent_tag.tag_id",$data['materiel']);
                        }
                       if($data['prof']!=0){
                        $this->db->where("talent.pro",1);
                        }  */
        /*                if($data['experience_pro']!=0){
                        $nbr_month=$data['experience_pro'];
                        $effectiveDate=date("Y-m-d h:i:s");
                        $effectiveDate = strtotime("-".$nbr_month." months", strtotime($effectiveDate));
                        $next=date("Y-m-d h:i:s",$effectiveDate);
                        $this->db->where("user.date_creation <=",$next);
                        }*/
        /*                $this->db->where("talent.prix >=",$data['min_t']);
                        $this->db->where("talent.prix <=",$data['max_t']);*/

        /*                if($data['order']=='date'){
                        $this->db->order_by('talent.date_creation', 'desc');
                        }elseif($data['order']=='nom'){
                        $this->db->order_by('talent.titre', 'desc');
                        }elseif($data['order']=='profession'){
                        $this->db->order_by('talent.profession', 'desc');
                        }else{
                        $this->db->order_by('talent.titre', 'desc');
                        }*/
        $this->db->order_by('total_date', 'desc');
        $this->db->group_by("entreprise.id");

        $this->db->limit($limit, $start);

        return $this->db->get()->result();
    }

    public function getTalentBysearchULYSS($data = [])
    {

        $select = 'entreprise.nom as entreprise,DATEDIFF(date_fin,date_debut) + 1 AS total_date,talent.id as id,talent.description as description,talent.alias as alias_t,user.alias as alias_u,villes.ville_latitude_deg as lat,villes.ville_longitude_deg as lng,villes.ville_nom as ville';
        $this->db->select($select);
        $this->db->from('talent');
        $this->db->join('talent_experience', 'talent.id=talent_experience.talent_id');
        $this->db->join('entreprise', 'entreprise.id=talent_experience.entreprise_id');

        $this->db->join('user', 'user.id=talent.user_id');
        $this->db->join('villes', 'talent.ville=villes.ville_id', 'left');


        if (!empty($data['date']) && $data['date'] != 0) {
            $this->db->join('talent_horaire', 'talent.id=talent_horaire.talent_id');
        }

        if (!empty($data['categorie']) && $data['categorie'] != 0) {
            $this->db->where("talent_experience.departement_id", $data['categorie']);
        }
        if (!empty($data['entreprise']) && $data['entreprise'] != 0) {
            $this->db->where("entreprise.id", $data['entreprise']);
        }

        if (!empty($data['ville']) && $data['ville'] != 0) {
            $this->db->where("talent.ville", $data['ville']);
        }
        if (!empty($data['sous_cat']) && $data['sous_cat'] != 0) {
            $this->db->where("talent_experience.fonction_id", $data['sous_cat']);
        }
        if (!empty($data['secteur']) && $data['secteur'] != 0) {
            $this->db->where("talent_experience.secteur_id", $data['secteur']);
        }


        /*disponibilite*/
        if (!empty($data['date']) && $data['date'] != 0) {
            $name_day = $this->getNameDay($data['date']);

            $name_1   = $name_day . "_8_10";
            $name_2   = $name_day . "_10_12";
            $name_3   = $name_day . "_12_14";
            $name_4   = $name_day . "_14_16";
            $name_5   = $name_day . "_16_18";
            $name_6   = $name_day . "_18_20";
            $name_7   = $name_day . "_20_22";
            $where_au = "(talent_horaire." . $name_1 . " ='1' OR talent_horaire." . $name_2 . " ='1' OR talent_horaire." . $name_3 . " ='1' OR talent_horaire." . $name_4 . " ='1' OR talent_horaire." . $name_5 . " ='1' OR talent_horaire." . $name_6 . " ='1' OR talent_horaire." . $name_7 . " ='1')";
            $this->db->where($where_au);

        }


        /*                $this->db->where("talent.prix >=",$data['min_t']);
                        $this->db->where("talent.prix <=",$data['max_t']);*/
        $this->db->order_by('total_date', 'desc');
        $this->db->group_by("entreprise.id");

        return $this->db->get()->result();
    }


    /*get list coup de coeur*/
    public function GetTalentsCoupDeCoeur()
    {
        $select = 'talent.id as id,user.prenom as prenom,user.avatar as avatar,adresse,talent.titre as titre,talent.cover as cover,user.alias as alias_u,talent.alias as alias_t,photo_coup_de_coeur';

        return $this->db->select($select)
            ->from('talent')
            //->join('talent_featured','talent.id=talent_featured.talent_id')
            ->join('user', 'user.id=talent.user_id')
            ->where('coup_des_cour', true)
            // ->order_by('ordre','asc')
            ->get()
            ->result();
    }

    public function getTalentBysearchBYComp($data = [])
    {
        $select = 'entreprise.nom as entreprise,DATEDIFF(date_fin,date_debut) + 1 AS total_date,talent.id as id,talent.description as description,talent.alias as alias_t,user.alias as alias_u,villes.ville_latitude_deg as lat,villes.ville_longitude_deg as lng,villes.ville_nom as ville';
        $this->db->select($select);
        $this->db->from('talent');
        $this->db->join('talent_experience', 'talent.id=talent_experience.talent_id');
        $this->db->join('entreprise', 'entreprise.id=talent_experience.entreprise_id');

        $this->db->join('user', 'user.id=talent.user_id');
        $this->db->join('villes', 'talent.ville=villes.ville_id', 'left');

        if (!empty($data['competence_id']) && $data['competence_id'] != 0) {
            $this->db->join('talent_tag', 'talent.id=talent_tag.talent_id');
        }


        if (!empty($data['competence_id']) && $data['competence_id'] != 0) {
            $this->db->where_in("talent_tag.tag_id", $data['competence_id']);
        }
        if (!empty($data['secteur']) && $data['secteur'] != 0) {
            $this->db->where("talent_experience.secteur_id", $data['secteur']);
        }
        if (!empty($data['sous_cat']) && $data['sous_cat'] != 0) {
            $this->db->where("talent_experience.fonction_id", $data['sous_cat']);
        }


        if (!empty($data['entreprise']) && $data['entreprise'] != 0) {
            $this->db->where("entreprise.id", $data['entreprise']);
        }
        if (!empty($data['categorie']) && $data['categorie'] != 0) {
            $this->db->where("talent_experience.departement_id", $data['categorie']);
        }
        $this->db->order_by('total_date', 'desc');
        $this->db->group_by("talent.id");

        return $this->db->get()->result();
    }

    public function getTalentBysearchWithOffsetComp($data = [], $limit, $start)
    {

        $select = 'entreprise.nom as entreprise,DATEDIFF(date_fin,date_debut) + 1 AS total_date,talent.prix as prix,user.avatar as avatar,user.nom as nom,user.prenom as prenom,talent.id as id,talent.description as description,talent.alias as alias_t,user.alias as alias_u,villes.ville_latitude_deg as lat,villes.ville_longitude_deg as lng,,villes.ville_nom as ville,ville_code_postal';
        $this->db->select($select);
        $this->db->from('talent');
        $this->db->join('talent_experience', 'talent.id=talent_experience.talent_id');
        $this->db->join('entreprise', 'entreprise.id=talent_experience.entreprise_id');
        $this->db->join('user', 'user.id=talent.user_id');
        $this->db->join('villes', 'talent.ville=villes.ville_id', 'left');
        if (!empty($data['competence_id']) && $data['competence_id'] != 0) {
            $this->db->join('talent_tag', 'talent.id=talent_tag.talent_id');
        }


        if (!empty($data['entreprise']) && $data['entreprise'] != 0) {
            $this->db->where("entreprise.id", $data['entreprise']);
        }
        if (!empty($data['competence_id']) && $data['competence_id'] != 0) {
            $this->db->where_in("talent_tag.tag_id", $data['competence_id']);
        }
        if (!empty($data['secteur']) && $data['secteur'] != 0) {
            $this->db->where("talent_experience.secteur_id", $data['secteur']);
        }
        if (!empty($data['sous_cat']) && $data['sous_cat'] != 0) {
            $this->db->where("talent_experience.fonction_id", $data['sous_cat']);
        }

        if (!empty($data['categorie']) && $data['categorie'] != 0) {
            $this->db->where("talent_experience.departement_id", $data['categorie']);
        }

        $this->db->order_by('total_date', 'desc');
        $this->db->group_by("talent.id");

        $this->db->limit($limit, $start);

        return $this->db->get()->result();
    }

}

?>