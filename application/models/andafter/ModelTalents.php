<?php

/**
 * Class ModelTalents
 */
Class ModelTalents extends CI_Model
{

    /**
     * ModelTalents constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->p_tablename = 'talent';
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getByEntrepriseId($id)
    {
        if ($id < 1) {
            return false;
        }

        $sql
            = ' SELECT talent.*, talent_experience.entreprise_id, talent_experience.fonction_id FROM talent 
                                INNER JOIN talent_experience
                                  ON talent_experience.talent_id = talent.id
                                WHERE talent_experience.entreprise_id = :entreprise_id
                                  AND talent.status = :valid
                                GROUP BY talent.id
                              ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':entreprise_id', $id);
        $stmt->bindValue(':valid', ModelTalent::VALID);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function getBySecteurId($id)
    {
        if ($id < 1) {
            return false;
        }

        $sql
            = ' SELECT talent.*, talent_experience.entreprise_id FROM talent 
                                INNER JOIN talent_experience
                                  ON talent_experience.talent_id = talent.id
                                WHERE talent_experience.secteur_id = :secteur_id
                                  AND talent.status = :valid
                                GROUP BY talent.id';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':secteur_id', $id);
        $stmt->bindValue(':valid', ModelTalent::VALID);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getExperiencesByTalentId($id)
    {
        if ($id < 1) {
            return false;
        }

        $sql
            = ' SELECT * FROM talent_experience 
                                WHERE talent_id = :talent_id';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':talent_id', $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

}

?>