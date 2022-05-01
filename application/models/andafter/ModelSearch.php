<?php

/**
 * Class ModelSearch
 */
Class ModelSearch extends CI_Model
{

    /**
     * ModelTalent constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param BusinessUser $BusinessUser
     * @param StdClass     $Entreprise
     *
     * @return array
     */
    public function getSearchBasicProfile(BusinessUser $BusinessUser, StdClass $Entreprise)
    {
        $entreprise_id = $Entreprise->id;
        $sql
                       = '
                            SELECT user.prenom,
                              user.avatar,
                              CONCAT("/",user.alias, "/", talent.alias, "/") AS url,
                              talent.user_id,
                              talent.description,
                              talent_experience.titre_mission,
                              talent_experience.lieu,
                              talent_experience.date_debut,
                              talent_experience.date_fin,
                              COUNT(talent_comment.id) AS recommandations,
                              entreprise.id AS id_entreprise,
                              entreprise.nom AS nom_entreprise,
                              categorie_groupe.id AS id_departement,
                              categorie_groupe.nom AS nom_departement,
                              talent_experience.entreprise_id AS filter_entreprise_id,
                              talent_experience.departement_id AS filter_departement_id,
                              talent_experience.secteur_id AS filter_secteur_id
                            FROM talent
                            INNER JOIN user
                              ON talent.user_id = user.id
                            INNER JOIN talent_experience
                              ON talent_experience.talent_id = talent.id
                            LEFT JOIN talent_comment
                              ON talent_comment.talent_id = talent.id AND talent_comment.note = 1
                            INNER JOIN categorie_groupe
                              ON talent_experience.departement_id = categorie_groupe.id
                            INNER JOIN entreprise
                              ON entreprise.id = talent_experience.entreprise_id
                            WHERE 
                              (
                                talent_experience.entreprise_id = :entreprise_id
                                OR
                                talent_experience.secteur_id = :secteur_entreprise_id
                              )
                              AND talent.status = :status
                              AND talent.user_id != :user_id
                            GROUP BY user_id
                            ORDER BY
                              date_fin DESC,
                              filter_entreprise_id ASC
                      ';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':entreprise_id', $entreprise_id);
        $stmt->bindValue(':status', ModelTalent::VALID);
        $stmt->bindValue(':user_id', $BusinessUser->getId());
        $stmt->bindParam(':secteur_entreprise_id', $Entreprise->secteur_id);
        $stmt->execute();

        $retour = $stmt->fetchAll(PDO::FETCH_CLASS);

        return $retour != null ? $retour : [];
    }

    /**
     * @param BusinessUser $BusinessUser
     * @param StdClass     $entreprise_id
     *
     * @return array
     */
    public function getSearchFullProfile(BusinessUser $BusinessUser, StdClass $Entreprise)
    {
        $entreprise_id  = $Entreprise->id;
        $BusinessTalent = $BusinessUser->getProfileTalent();
        $LastExperience = $BusinessTalent->getLastExperience();

        if ($LastExperience == null) {
            return $this->getSearchBasicProfile($BusinessUser, $Entreprise);
        }

        $departement_id = $LastExperience->departement_id;

        $sql
            = '
                            SELECT user.prenom,
                              user.avatar,
                              CONCAT("/",user.alias, "/", talent.alias, "/") AS url,
                              talent.user_id,
                              talent.description,
                              talent_experience.titre_mission,
                              talent_experience.lieu,
                              talent_experience.date_debut,
                              talent_experience.date_fin,
                              COUNT(talent_comment.id) AS recommandations,
                              entreprise.id AS id_entreprise,
                              entreprise.nom AS nom_entreprise,
                              categorie_groupe.id AS id_departement,
                              categorie_groupe.nom AS nom_departement,,
                              talent_experience.entreprise_id AS filter_entreprise_id,
                              talent_experience.departement_id AS filter_departement_id,
                              talent_experience.secteur_id AS filter_secteur_id
                            FROM talent
                            INNER JOIN user
                              ON talent.user_id = user.id
                            INNER JOIN talent_experience
                              ON talent_experience.talent_id = talent.id
                            LEFT JOIN talent_comment
                              ON talent_comment.talent_id = talent.id AND talent_comment.note = 1
                            INNER JOIN categorie_groupe
                              ON talent_experience.departement_id = categorie_groupe.id
                            INNER JOIN entreprise
                              ON entreprise.id = talent_experience.entreprise_id
                            WHERE 
                              (
                                talent_experience.entreprise_id = 3 
                                OR
                                (
                                  talent.id NOT IN (
                                    SELECT talent_id FROM talent_experience WHERE 
                                    entreprise_id = :entreprise_id
                                  )
                                  AND (talent_experience.departement_id = :departement_id
                                  OR talent_experience.secteur_id = :secteur_entreprise_id)
                                )
                              )
                              AND talent.status = :status
                              AND talent.user_id != :user_id
                            GROUP BY user_id
                            ORDER BY
                              date_fin DESC,
                              filter_entreprise_id ASC,
                              filter_departement_id ASC,
                              filter_secteur_id ASC
                      ';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':entreprise_id', $entreprise_id);
        $stmt->bindParam(':departement_id', $departement_id);
        $stmt->bindParam(':secteur_entreprise_id', $Entreprise->secteur_id);
        $stmt->bindValue(':status', ModelTalent::VALID);
        $stmt->bindValue(':user_id', $BusinessUser->getId());
        $stmt->execute();
        $retour = $stmt->fetchAll(PDO::FETCH_CLASS);

        return $retour != null ? $retour : [];
    }


    /**
     * @param BusinessUser $BusinessUser
     *
     * @return array
     */
    public function getSearchSecteurProfil(BusinessUser $BusinessUser)
    {
        $sql
            = '
                            SELECT user.prenom,
                              user.avatar,
                              CONCAT("/",user.alias, "/", talent.alias, "/") AS url,
                              talent.prix,
                              talent.user_id,
                              talent.description,
                              talent_experience.titre_mission,
                              talent_experience.lieu,
                              talent_experience.date_debut,
                              talent_experience.date_fin,
                              COUNT(talent_comment.id) AS recommandations,
                              entreprise.id AS id_entreprise,
                              entreprise.nom AS nom_entreprise,
                              categorie_groupe.id AS id_departement,
                              categorie_groupe.nom AS nom_departement,
                              categorie.id AS id_fonction,
                              categorie.nom AS nom_fonction,
                              talent_experience.entreprise_id AS filter_entreprise_id,
                              talent_experience.fonction_id AS filter_fonction_id,
                              talent_experience.departement_id AS filter_departement_id,
                              talent_experience.secteur_id AS filter_secteur_id,
                              GROUP_CONCAT(talent_formation.university) AS filter_university
                            FROM talent
                            INNER JOIN user
                              ON talent.user_id = user.id
                            INNER JOIN talent_experience
                              ON talent_experience.talent_id = talent.id
                            LEFT JOIN talent_comment
                              ON talent_comment.talent_id = talent.id AND talent_comment.note = 1
                            LEFT JOIN talent_formation
                              ON talent_formation.talent_id = talent.id
                            INNER JOIN categorie
                              ON talent_experience.fonction_id = categorie.id
                            INNER JOIN categorie_groupe
                              ON talent_experience.departement_id = categorie_groupe.id
                            INNER JOIN entreprise
                              ON entreprise.id = talent_experience.entreprise_id
                            WHERE 
                                talent_experience.secteur_id = :secteur_id 
                              AND talent.status = :status
                              AND talent.user_id != :user_id
                            GROUP BY user_id
                            ORDER BY
                              date_fin DESC,
                              filter_entreprise_id ASC,
                              filter_departement_id ASC,
                              filter_secteur_id ASC,
                              filter_fonction_id ASC
                      ';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindValue(':secteur_id', $BusinessUser->getProfileTalent()->getLastExperience()->secteur_id);
        $stmt->bindValue(':status', ModelTalent::VALID);
        $stmt->bindValue(':user_id', $BusinessUser->getId());
        $stmt->execute();

        $retour = $stmt->fetchAll(PDO::FETCH_CLASS);

        return $retour != null ? $retour : [];
    }


    /**
     *
     * @param array $searchOption
     *
     * @return array
     */
    public function getSearchHomeProfilsByFilter(array $searchOption)
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
                              DATE_FORMAT(talent_experience.date_debut, \'%d-%m-%Y\') as date_debut,
                              IF(talent_experience.date_fin=  \'9999-12-31\',  \'Aujourd\\\'hui\', talent_experience.date_fin) as date_fin,
                              COUNT(talent_comment.id) AS recommandations,
                              entreprise.id AS id_entreprise,
                              entreprise.nom AS nom_entreprise,
                              entreprise.alias AS alias_entreprise,                         
                              categorie_groupe.id AS id_departement,
                              categorie_groupe.nom AS nom_departement,
                               secteur_activite.nom AS nom_secteur,
                              talent_experience.entreprise_id AS filter_entreprise_id,
                              talent_experience.departement_id AS filter_departement_id,
                              talent_experience.secteur_id AS filter_secteur_id');
        $this->db->from('talent');
        $this->db->join('user', 'user.id = talent.user_id', 'LEFT');
        $this->db->join('talent_experience', 'talent_experience.talent_id = talent.id', 'LEFT');
        $this->db->join('categorie_groupe', 'talent_experience.departement_id = categorie_groupe.id', 'LEFT');
        $this->db->join('talent_comment', 'talent_comment.talent_id = talent.id AND talent_comment.note = 1', 'LEFT');
        $this->db->join('entreprise', 'entreprise.id = talent_experience.entreprise_id', 'LEFT');
        $this->db->join('secteur_activite', 'talent_experience.secteur_id = secteur_activite.id', 'LEFT');

        //--------------------------------------------------------------------
        $this->db->where('talent.status', ModelTalent::VALID);
        $this->db->order_by('talent_experience.date_fin', 'DESC', ModelTalent::VALID);
        $this->db->order_by('talent_experience.date_debut', 'ASC', ModelTalent::VALID);

        if ($searchOption['ent_name'] !== null) {
            $this->db->like('entreprise.nom', $searchOption['ent_name']);
        }

        if ($searchOption['secteur'] !== null) {
            $this->db->where('entreprise.secteur_id IN (SELECT id from secteur_activite where id_chapeau = ' . $searchOption['secteur'] . ')');
        }

        if ($searchOption['departement'] !== null) {
            $this->db->where('talent_experience.departement_id', $searchOption['departement']);
        }

        if ($searchOption['region'] !== null) {
            $this->db->like('talent_experience.lieu', $searchOption['region']);
            $this->db->or_like('talent_experience.ville', $searchOption['region']);
            $this->db->or_like('talent_experience.departement_geo', $searchOption['region']);
            $this->db->or_like('talent_experience.region', $searchOption['region']);
            $this->db->or_like('talent_experience.pays', $searchOption['region']);
        }

        //--------------------------------------------------------------------
        $this->db->group_by('talent.id');
        $this->db->order_by('entreprise.id');
        $retour = $this->db->get();
        $retour = $retour->result();


        return $retour != null ? $retour : [];
    }

    /** Write by Raph.B */
    /**
     * @param BusinessUser $BusinessUser
     *
     * @return array of MentorSuggest
     */
    public function getTalentsByUserLoggedDepartement($BusinessUser)
    {
        $retour = $this->db->select('talent.id,
                              CONCAT("/",user.alias, "/", talent.alias, "/") AS url,
                              user.prenom,
                              user.nom,
                              user.avatar,
                              talent.user_id,
                              talent.description,                             
                              talent_experience.titre_mission,
                              talent_experience.lieu,
                              DATE_FORMAT(talent_experience.date_debut, \'%d-%m-%Y\') as date_debut,
                              IF(talent_experience.date_fin=  \'9999-12-31\',  \'Aujourd\\\'hui\', talent_experience.date_fin) as date_fin,
                              COUNT(talent_comment.id) AS recommandations,
                              entreprise.id AS id_entreprise,
                              entreprise.nom AS nom_entreprise,
                              entreprise.alias AS alias_entreprise,                         
                              categorie_groupe.id AS id_departement,
                              categorie_groupe.nom AS nom_departement,
                               secteur_activite.nom AS nom_secteur,
                              talent_experience.entreprise_id AS filter_entreprise_id,
                              talent_experience.departement_id AS filter_departement_id,
                              talent_experience.secteur_id AS filter_secteur_id')
            ->from('talent')
            ->join('user', 'user.id = talent.user_id', 'LEFT')
            ->join('talent_experience', 'talent_experience.talent_id = talent.id', 'LEFT')
            ->join('categorie_groupe', 'talent_experience.departement_id = categorie_groupe.id', 'LEFT')
            ->join('talent_comment', 'talent_comment.talent_id = talent.id AND talent_comment.note = 1', 'LEFT')
            ->join('entreprise', 'entreprise.id = talent_experience.entreprise_id', 'LEFT')
            ->join('secteur_activite', 'talent_experience.secteur_id = secteur_activite.id', 'LEFT')
            ->where('talent_experience.departement_id',
                $BusinessUser->getProfileTalent()->getDepartementId() != null ? $BusinessUser->getProfileTalent()->getDepartementId() : $BusinessUser->getProfileTalent()->getLastExperience()->departement_id)
            ->where('talent_experience.secteur_id', $BusinessUser->getProfileTalent()->getLastExperience()->secteur_id)
            ->where('talent.id !=', $BusinessUser->getProfileTalent()->getId())
            ->where('talent.status', ModelTalent::VALID)
            ->group_by('talent.id')
            ->get()
            ->result();

        return $retour != null ? $retour : [];
    }

    public function getRandomTalent()
    {
        $retour = $this->db->select('talent.id,
                              CONCAT("/",user.alias, "/", talent.alias, "/") AS url,
                              user.prenom,
                              user.nom,
                              user.avatar,
                              talent.user_id,
                              talent.description,                             
                              talent_experience.titre_mission,
                              talent_experience.lieu,
                              DATE_FORMAT(talent_experience.date_debut, \'%d-%m-%Y\') as date_debut,
                              IF(talent_experience.date_fin=  \'9999-12-31\',  \'Aujourd\\\'hui\', talent_experience.date_fin) as date_fin,
                              COUNT(talent_comment.id) AS recommandations,
                              entreprise.id AS id_entreprise,
                              entreprise.nom AS nom_entreprise,
                              entreprise.alias AS alias_entreprise,                         
                              categorie_groupe.id AS id_departement,
                              categorie_groupe.nom AS nom_departement,
                               secteur_activite.nom AS nom_secteur,
                              talent_experience.entreprise_id AS filter_entreprise_id,
                              talent_experience.departement_id AS filter_departement_id,
                              talent_experience.secteur_id AS filter_secteur_id')
            ->from('talent')
            ->join('user', 'user.id = talent.user_id', 'LEFT')
            ->join('talent_experience', 'talent_experience.talent_id = talent.id', 'LEFT')
            ->join('categorie_groupe', 'talent_experience.departement_id = categorie_groupe.id', 'LEFT')
            ->join('talent_comment', 'talent_comment.talent_id = talent.id AND talent_comment.note = 1', 'LEFT')
            ->join('entreprise', 'entreprise.id = talent_experience.entreprise_id', 'LEFT')
            ->join('secteur_activite', 'talent_experience.secteur_id = secteur_activite.id', 'LEFT')
            ->where('talent.status', ModelTalent::VALID)
            ->group_by('talent.id')
            ->order_by('talent.id', 'RANDOM')
            ->limit('12')
            ->get()
            ->result();

        return $retour != null ? $retour : [];
    }
}
