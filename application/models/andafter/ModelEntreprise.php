<?php

/**
 * Class ModelEntreprise
 */
Class ModelEntreprise extends CI_Model
{
    /**
     * ModelEntreprise constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultTablename();
    }

    private function setDefaultTablename()
    {
        $this->p_tablename = 'entreprise';
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getByName($name)
    {
        if ($name == '') {
            return false;
        }

        $sql
            = ' SELECT entreprise.* FROM entreprise
                        WHERE nom = :entreprise_nom
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':entreprise_nom', $name);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getByCode($code)
    {
        if ($code == '') {
            return false;
        }

        $sql
            = ' SELECT * FROM entreprise
                        WHERE entreprise.code = :entreprise_code
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':entreprise_code', $code);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $talent_id
     *
     * @return mixed
     */
    public function getByTalentId($id)
    {
        if ($id < 1) {
            return false;
        }

        $sql
            = ' SELECT entreprise.*, talent_experience.secteur_id FROM entreprise
                        LEFT JOIN talent_experience
                          ON talent_experience.entreprise_id = entreprise.id
                        WHERE entreprise.id = :entreprise_id
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':entreprise_id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getById($id)
    {
        if ($id == '') {
            return false;
        }

        $sql
            = ' SELECT entreprise.* FROM entreprise
                        WHERE id = :id
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);

    }

    public function GetEntrepriseByAlias($alias)
    {
        if ($alias == '') {
            return false;
        }

        $sql
            = ' SELECT entreprise.* FROM entreprise
                        WHERE alias = :alias
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':alias', $alias);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function GetEntrepriseById($id)
    {
        if ($id == null || $id == '') {
            return false;
        }

        $sql
            = ' SELECT entreprise.* FROM entreprise
                        WHERE id = :id
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $id integer
     *
     * @return integer
     */
    public function getAliasEntrepriseById($id)
    {
        $this->db->select('alias');
        $this->db->where('id', $id);
        $query = $this->db->get('entreprise');

        return $query->row()->alias;
    }

    /**
     * @param $id integer
     *
     * @return string
     */
    public function getNameEntrepriseById($id)
    {
        $result = $this->db->select('nom')
            ->where('id', $id)
            ->get('entreprise')
            ->row();

        return $result->nom;

    }

    /**
     * @param $entId integer
     *
     * @return array
     */

    public function getOffres($entId)
    {


        if ($entId < 1) {
            return false;
        }

        $sql
            = ' SELECT offre_emplois.* FROM offre_emplois
                        WHERE entreprise_id = :entreprise_id ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':entreprise_id', $entId);
        $stmt->execute();

        $retour = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $retour != null ? $retour : [];
    }

    /**
     * @param $entId integer
     *
     * @return array
     */

    public function getOffresPublic($entId)
    {


        if ($entId < 1) {
            return false;
        }

        $sql
            = ' SELECT offre_emplois.* FROM offre_emplois
                        WHERE entreprise_id = :entreprise_id AND public_offre = 1';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':entreprise_id', $entId);
        $stmt->execute();

        $retour = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $retour != null ? $retour : [];
    }

    public function addSocial($social, $link, $id_ent)
    {
        $this->db->set($social, $link);
        $this->db->where('id', $id_ent);
        $this->db->update('entreprise');
    }


    //save compagny decription and description title in entreprise table in database
    public function EditDescriptionByIdEntreprise($id, $data = [])
    {
        //  Vérification des données à mettre à jour
        if (empty($data)) {
            return false;
        }

        return (bool)$this->db->set($data)
            ->where('id', $id)
            ->update("entreprise");
    }


    // return le resultat du nombre total d'offres de l'entreprise
    function getTotalNbrOffreByEntrepriseId($id)
    {
        $this->db->select('COUNT(id) AS nbr_offre');
        $this->db->from('offre_emplois');
        $this->db->where('entreprise_id', $id);
        $query = $this->db->get();

        return $query->row()->nbr_offre;
    }

    // return le resultat du nombre total d'offres de l'entreprise
    function getNbrOffrePublicByEntrepriseId($id)
    {
        $this->db->select('COUNT(id) AS nbr_offre');
        $this->db->from('offre_emplois');
        $this->db->where('entreprise_id', $id);
        $this->db->where('public_offre ', ModelOffre::PUBLIC_OFFRE);
        $query = $this->db->get();

        return $query->row()->nbr_offre;
    }

    // return le resultat du nombre total d'offres de l'entreprise
    function getNbrOffreNonPublicByEntrepriseId($id)
    {
        $this->db->select('COUNT(id) AS nbr_offre_public');
        $this->db->from('offre_emplois');
        $this->db->where('entreprise_id', $id);
        $this->db->where('public_offre ', ModelOffre::NON_PUBLIC_OFFRE);
        $query = $this->db->get();

        return $query->row()->nbr_offre_public;
    }

    // return le resultat du nombre total des mentor de l'entreprise
    function getTotalMentorByEntrepriseId($id)
    {
        $this->db->select('COUNT(DISTINCT(talent.id)) AS nbr_mentor');
        $this->db->from('talent');
        $this->db->join('talent_experience', 'talent_experience.talent_id = talent.id');
        $this->db->where('talent_experience.entreprise_id', $id);
        $this->db->where('talent_experience.date_fin', '9999-12-31');
        $this->db->where('talent.status', ModelTalent::VALID);
        $query = $this->db->get();

        return $query->row()->nbr_mentor;
    }

    // return le resultat du nombre total des ambassador de l'entreprise
    function getTotalAmbassadorByEntrepriseId($id)
    {
        $this->db->select('COUNT(id) AS nbr_ambassador');
        $this->db->from('mentor_ambassadeur');
        $this->db->where('id_entreprise', $id);
        $query = $this->db->get();

        return $query->row()->nbr_ambassador;
    }

    /**
     * @param $idEnt
     *
     * @return array
     */
    public function getAllProfilMentorById($idEnt)
    {

        $this->db->select('talent.id,
                              CONCAT("/",user.alias, "/", talent.alias, "/") AS url,
                              user.prenom,
                              user.nom,
                              user.avatar,
                              talent.user_id,
                              talent.description,                             
                              talent_experience.titre_mission,
                              talent_experience.lieu,
                              talent_experience.date_debut,
                              talent_experience.date_fin,
                              COUNT(talent_comment.id) AS recommandations,
                              entreprise.id AS id_entreprise,
                              entreprise.nom AS nom_entreprise,
                              entreprise.alias AS alias_entreprise,                         
                              categorie_groupe.id AS id_departement,
                              categorie_groupe.nom AS nom_departement,
                              categorie.id AS id_fonction,
                              categorie.nom AS nom_fonction');
        $this->db->from('talent');
        $this->db->join('user', 'user.id = talent.user_id', 'LEFT');
        $this->db->join('talent_experience', 'talent_experience.talent_id = talent.id', 'LEFT');
        $this->db->join('categorie', 'talent_experience.fonction_id = categorie.id', 'LEFT');
        $this->db->join('categorie_groupe', 'talent_experience.departement_id = categorie_groupe.id', 'LEFT');
        $this->db->join('talent_comment', 'talent_comment.talent_id = talent.id AND talent_comment.note = 1', 'LEFT');
        $this->db->join('entreprise', 'entreprise.id = talent_experience.entreprise_id', 'LEFT');
        $this->db->where('talent.status', ModelTalent::VALID);
        $this->db->where('entreprise.id', $idEnt);
        $this->db->where('talent_experience.date_fin', '9999-12-31');
        $this->db->group_by('talent.id');
        $retour = $this->db->get();
        $retour = $retour->result();

        return $retour != null ? $retour : [];
    }

    /**
     * @param $idEnt
     *
     * @return array
     */
    public function
    getProfilMentorWithoutAmbassadeurById(
        $idEnt
    ){

        $this->db->select('talent.id,
                              CONCAT("/",user.alias, "/", talent.alias, "/") AS url,
                              user.prenom,
                              user.nom,
                              user.avatar,
                              talent.user_id,
                              talent.description,                             
                              talent_experience.titre_mission,
                              talent_experience.lieu,
                              talent_experience.date_debut,
                              talent_experience.date_fin,
                              COUNT(talent_comment.id) AS recommandations,
                              entreprise.id AS id_entreprise,
                              entreprise.nom AS nom_entreprise,
                              entreprise.alias AS alias_entreprise,                         
                              categorie_groupe.id AS id_departement,
                              categorie_groupe.nom AS nom_departement,
                              categorie.id AS id_fonction,
                              categorie.nom AS nom_fonction');
        $this->db->from('talent');
        $this->db->join('user', 'user.id = talent.user_id', 'LEFT');
        $this->db->join('talent_experience', 'talent_experience.talent_id = talent.id', 'LEFT');
        $this->db->join('categorie', 'talent_experience.fonction_id = categorie.id', 'LEFT');
        $this->db->join('categorie_groupe', 'talent_experience.departement_id = categorie_groupe.id', 'LEFT');
        $this->db->join('talent_comment', 'talent_comment.talent_id = talent.id AND talent_comment.note = 1', 'LEFT');
        $this->db->join('entreprise', 'entreprise.id = talent_experience.entreprise_id', 'LEFT');
        $this->db->where('talent.status', ModelTalent::VALID);
        $this->db->where('entreprise.id', $idEnt);
        $this->db->where('talent_experience.date_fin', '9999-12-31');
        $this->db->where('talent.id NOT IN (SELECT talent_id FROM mentor_ambassadeur WHERE id_entreprise = ' . $idEnt . ')');
        $this->db->group_by('talent.id');
        $retour = $this->db->get();
        $retour = $retour->result();

        return $retour != null ? $retour : [];
    }

    /**
     * @param $idEnt
     *
     * @return array
     */
    public function getProfilAmabassadeursById($idEnt)
    {

        $this->db->select('mentor_ambassadeur.id,
                              mentor_ambassadeur.talent_id,
                              mentor_ambassadeur.id_entreprise,
                              CONCAT("/",user.alias, "/", talent.alias, "/") AS url,
                              user.prenom,
                              user.nom,
                              user.avatar,
                              talent.user_id,
                              talent.description,                             
                              talent_experience.titre_mission,
                              talent_experience.lieu,
                              talent_experience.date_debut,
                              talent_experience.date_fin,
                              COUNT(talent_comment.id) AS recommandations,
                              entreprise.id AS id_entreprise,
                              entreprise.nom AS nom_entreprise,
                              entreprise.alias AS alias_entreprise,                         
                              categorie_groupe.id AS id_departement,
                              categorie_groupe.nom AS nom_departement,
                              categorie.id AS id_fonction,
                              categorie.nom AS nom_fonction');
        $this->db->from('mentor_ambassadeur');
        $this->db->join('talent', 'talent.id = mentor_ambassadeur.talent_id', 'LEFT');
        $this->db->join('user', 'user.id = talent.user_id', 'LEFT');
        $this->db->join('talent_experience', 'talent_experience.talent_id = talent.id', 'LEFT');
        $this->db->join('categorie', 'talent_experience.fonction_id = categorie.id', 'LEFT');
        $this->db->join('categorie_groupe', 'talent_experience.departement_id = categorie_groupe.id', 'LEFT');
        $this->db->join('talent_comment', 'talent_comment.talent_id = talent.id AND talent_comment.note = 1', 'LEFT');
        $this->db->join('entreprise', 'entreprise.id = mentor_ambassadeur.id_entreprise', 'LEFT');
        $this->db->where('talent.status', ModelTalent::VALID);
        $this->db->where('mentor_ambassadeur.id_entreprise', $idEnt);
        //Pour afficher que les ambassadeur qui sont actuellment en entreprise
        //$this->db->where('talent_experience.date_fin', '9999-12-31');
        // je l'ai commenté en cas ou un mentor quitte la boite et que il est embassadeur ,
        // si le where est active alor il saffichera plus meme si il est mentor
        $this->db->group_by('mentor_ambassadeur.talent_id');
        $retour = $this->db->get();
        $retour = $retour->result();

        return $retour != null ? $retour : [];
    }

    // return le resultat du nombre total des rdv de l'entreprise
    function getTotalRdvByEntrepriseId($id)
    {
        $this->db->select('COUNT(talent.id) AS nbr_rdv');
        $this->db->from('talent');
        $this->db->join('talent_experience', 'talent_experience.talent_id = talent.id');
        $this->db->join('talent_demandes', 'talent_demandes.talent_id = talent.id');
        $this->db->where('talent_experience.entreprise_id', $id);
        $this->db->where('talent.status', 1);
        $this->db->group_by('talent_experience.talent_id');
        $query = $this->db->get();


        return $query->row()->nbr_rdv;
    }

    public function AddVueEntreprise($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        //prendre la derniere date de la Base de doneés
        $select = '*';
        $where  = ["entreprise_id" => $add['entreprise_id'], "talent_id" => $add['talent_id']];
        $verif  = $this->db->select($select)
            ->from('entreprise_vues')
            ->where($where)
            ->where('date_creation IN ', '(SELECT max(date_creation) FROM entreprise_vues WHERE entreprise_id = ' . $add['entreprise_id'] . ' AND talent_id = ' . $add['talent_id'] . ')', false)
            ->get()
            ->row();

        if (empty($verif)) {
            $this->db->set($add)
                ->insert("entreprise_vues");

            return $this->db->insert_id();
        } elseif (!empty($verif) && isset($verif->date_creation)) {
            $jourActuel = date('d');
            $jour       = date('d', strtotime($verif->date_creation));
            if ($jourActuel != $jour) {
                $this->db->set($add)
                    ->insert("entreprise_vues");

                return $this->db->insert_id();
            } else {
                return true;
            }
        } else {
            return true;
        }


    }

    public function AddRechercheEntreprise($add = [])
    {
        //  Vérification des données à insérer
        if (empty($add)) {
            return false;
        }

        //prendre la derniere date de la Base de doneés
        $select = '*';
        $where  = ["entreprise_id" => $add['entreprise_id'], "talent_id" => $add['talent_id']];
        $verif  = $this->db->select($select)
            ->from('entreprise_recherche')
            ->where($where)
            ->where('date_creation IN ', '(SELECT max(date_creation) FROM entreprise_recherche WHERE entreprise_id = ' . $add['entreprise_id'] . ' AND talent_id = ' . $add['talent_id'] . ')', false)
            ->get()
            ->row();

        if (empty($verif)) {
            $this->db->set($add)
                ->insert("entreprise_recherche");

            return $this->db->insert_id();
        } elseif (!empty($verif) && isset($verif->date_creation)) {
            $jourActuel = date('d');
            $jour       = date('d', strtotime($verif->date_creation));
            if ($jourActuel == $jour) {

                $this->db->set('nbr_vues', 'nbr_vues+1', false);
                $this->db->where('id', $verif->id);

                return $this->db->update('entreprise_recherche');

            } else {
                $this->db->set($add)
                    ->insert("entreprise_recherche");

                return $this->db->insert_id();
            }
        } else {
            return true;
        }


    }

    public function AddCiblageDepEntreprise($add = [])
    {
        $this->p_tablename = 'entreprise_ciblage_dep';
        $this->save($add);
        $this->setDefaultTablename();
    }

    public function AddCiblageRegionEntreprise($add = [])
    {
        $this->p_tablename = 'entreprise_ciblage_region';
        $this->save($add);
        $this->setDefaultTablename();
    }

    public function deleteCiblage($idOffre, $idMentor)
    {
        if ($idOffre == null && $idMentor == null) {
            return false;
        }

        return $this->db->delete('offre_mentors', ['offre_id' => $idOffre, 'id_mentor' => $idMentor]);

        // Produces:
        // DELETE FROM mytable WHERE id = $id
    }

    public function getDepartementCiblage($id, $idDept)
    {
        $this->db->select('*');
        $this->db->from('entreprise_ciblage_dep');
        $this->db->where('entreprise_id', $id);
        $this->db->where('departement_id', $idDept);

        $query = $this->db->get();


        return $query;
    }

    public function getRegionCiblage($id, $idDept)
    {
        $this->db->select('*');
        $this->db->from('entreprise_ciblage_region');
        $this->db->where('entreprise_id', $id);
        $this->db->where('region_nom_map', $idDept);

        $query = $this->db->get();


        return $query;
    }

    public function verifIfEntIsClient($id)
    {
        $this->db->select('*');
        $this->db->from('admin_employeur');
        $this->db->where('id_entreprise', $id);
        $this->db->where('statut', ModelEntrepriseAdmin::VALID_STATUT);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }
}
