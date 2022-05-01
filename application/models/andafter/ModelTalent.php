<?php

/**
 * Class ModelTalent
 */
Class ModelTalent extends CI_Model
{
    const UNVALID            = 0;
    const VALID              = 1;
    const VALID_AMBASSADOR   = 1;
    const UNVALID_AMBASSADOR = 0;
    const WAITING            = 2;

    /**
     * ModelTalent constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setDefaultTablename();
    }

    private function setDefaultTablename()
    {
        $this->p_tablename = 'talent';
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getTalentById($id)
    {
        return $this->getById($id);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getTalentByUserId($id)
    {
        if ($id < 1) {
            return false;
        }

        $sql
            = ' SELECT talent.* FROM talent 
                        WHERE talent.user_id = :user_id
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $id_experience
     *
     * @return mixed
     */
    public function getExperienceByIdExp($id)
    {
        $sql
            = ' SELECT talent_experience.* FROM talent_experience 
                        WHERE talent_experience.id = :talent_experience_id
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':talent_experience_id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function countRDVRealises($id)
    {
        $sql
            = ' SELECT COUNT(*) FROM talent_demandes
                        WHERE talent_id = :user_id
                        AND status = :status
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':user_id', $id);
        $stmt->bindValue(':status', 'validé');
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function countRDVAnnules($id)
    {
        $sql
            = ' SELECT COUNT(*) FROM talent_demandes
                        WHERE talent_id = :user_id
                        AND status = :status
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':user_id', $id);
        $stmt->bindValue(':status', 'rejeté');
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function countRDVEnAttente($id)
    {
        $sql
            = ' SELECT COUNT(*) FROM talent_demandes
                        WHERE talent_id = :user_id
                        AND status = :status
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':user_id', $id);
        $stmt->bindValue(':status', 'en-attente');
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function countRecommandations($id)
    {
        $sql
            = ' SELECT COUNT(*) FROM  talent_comment
                        WHERE talent_id = :user_id
                        AND note = 1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getRDVFromTwoDate($date_from, $date_to, $id_user, $id_talent)
    {
        $sql
            = ' SELECT * FROM talent_demandes 
                        WHERE (talent_id = :id_talent OR user_id_acheteur = :id_user)
                        AND (date_livraison BETWEEN :date_from AND :date_to )
                        AND status != "rejeté"
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_talent', $id_talent);
        $stmt->bindValue(':date_from', $date_from);
        $stmt->bindValue(':date_to', $date_to);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $id_rdv
     * @param $id_user
     *
     * @return mixed
     */
    public function getRDV($id_rdv, $id_talent, $id_user)
    {
        $sql
            = ' SELECT * FROM talent_demandes 
                                    WHERE (talent_id = :id_talent OR user_id_acheteur = :id_user)
                                    AND id = :id_rdv
                                  ';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id_talent', $id_talent);
        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_rdv', $id_rdv);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $id_experience
     *
     * @return mixed
     */
    public function getLastExperienceByIdTalent($id)
    {
        $sql
            = ' SELECT talent_experience.* FROM talent_experience 
                        WHERE talent_experience.talent_id = :id_talent
                        ORDER BY talent_experience.date_fin DESC
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id_talent', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $id_experience
     *
     * @return mixed
     */
    public function getExperiencesByIdTalent($id)
    {
        $select = '*, date_fin AS dates';
        $where  = ["talent_id" => $id];

        return $this->db->select($select)
            ->from('talent_experience')
            ->where($where)
            ->order_by('dates', 'DESC')
            ->get()
            ->result();
    }

    /**
     * @param $id_experience
     *
     * @return mixed
     */
    public function getFormationsByIdTalent($id)
    {
        $sql
            = ' SELECT talent_formation.* FROM talent_formation 
                        WHERE talent_formation.talent_id = :talent_id
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':talent_id', $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $id_experience
     *
     * @return mixed
     */
    public function getFormationsByIdTalentAndSchoolName($id, $SchoolName)
    {
        $sql
            = ' SELECT talent_formation.* 
                FROM talent_formation 
                WHERE talent_formation.talent_id = :talent_id 
                AND talent_formation.university_id = :university_id ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':talent_id', $id);
        $stmt->bindParam(':university_id', $SchoolName);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $id_experience
     *
     * @return mixed
     */
    public function getFormationsByIdTalentGroupedByUniversity($id)
    {
        $sql
            = ' SELECT talent_formation.* FROM talent_formation 
                        WHERE talent_formation.talent_id = :talent_id
                        GROUP BY talent_formation.university
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':talent_id', $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $id_experience
     *
     * @return mixed
     */
    public function getTalentTestimoniauxById($id)
    {
        $sql
            = ' SELECT talent_comment.* FROM talent_comment 
                        WHERE talent_comment.talent_id = :talent_id
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':talent_id', $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getTalentTestimonialByDemandeTalentId($id)
    {
        if ($id < 1) {
            return false;
        }

        $sql
            = ' SELECT talent_comment.* FROM talent_comment 
                        WHERE talent_comment.demande_talen_id = :demande_talen_id
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':demande_talen_id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }


    /**
     * @return mixed
     */
    public function getAllRDV($id)
    {
        $sql
            = ' SELECT * FROM talent_demandes 
                                WHERE (talent_id = :id)
                                AND status != "undefined"
                              ';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $fields_table
     *
     * @return stdClass
     */
    public function saveExperiences($fields_table)
    {
        $this->p_tablename = 'talent_experience';
        $return            = $this->save($fields_table);
        $this->setDefaultTablename();

        return $return;
    }

    /**
     * @param $id_talent
     */
    public function deleteExperiences($id_talent)
    {
        $this->p_tablename = 'talent_experience';
        $this->delete($id_talent, 'talent_id');
        $this->setDefaultTablename();
    }

    /**
     * @param $fields_table
     *
     * @return stdClass
     */
    public function saveFormations($fields_table)
    {
        $this->p_tablename = 'talent_formation';
        $return            = $this->save($fields_table);
        $this->setDefaultTablename();

        return $return;
    }

    /**
     * @param $id_talent
     */
    public function deleteFormations($id_talent)
    {
        $this->p_tablename = 'talent_formation';
        $this->delete($id_talent, 'talent_id');
        $this->setDefaultTablename();
    }

    /**
     * @param $fields_table
     *
     * @return stdClass
     */
    public function saveTags($fields_table)
    {
        $this->p_tablename = 'talent_tag';
        $return            = $this->save($fields_table);
        $this->setDefaultTablename();

        return $return;
    }

    /**
     * @param $id_talent
     */
    public function deleteTags($id_talent)
    {
        $this->p_tablename = 'talent_tag';
        $this->delete($id_talent, 'talent_id');
        $this->setDefaultTablename();
    }

    /**
     * @param $fields_table
     *
     * @return stdClass
     */
    public function saveComment($fields_table)
    {
        $this->p_tablename = 'talent_comment';
        $return            = $this->save($fields_table);
        $this->setDefaultTablename();

        return $return;
    }

    /**
     * @param $id_talent
     */
    public function deleteComment($id_talent)
    {
        $this->p_tablename = 'talent_comment';
        $this->delete($id_talent, 'talent_id');
        $this->setDefaultTablename();
    }

    /**
     * @param $fields_table
     *
     * @return stdClass
     */
    public function saveDemande($fields_table)
    {
        $this->p_tablename = 'talent_demandes';
        $return            = $this->save($fields_table);
        $this->setDefaultTablename();

        return $return;
    }

    /**
     * @param $fields_table
     *
     * @return stdClass
     */
    public function saveLang($fields_table)
    {
        $this->p_tablename = 'talent_language';
        $return            = $this->save($fields_table);
        $this->setDefaultTablename();

        return $return;
    }

    /**
     * @param $id_talent
     */
    public function deleteLang($id_talent)
    {
        $this->p_tablename = 'talent_language';
        $this->delete($id_talent, 'talent_id');
        $this->setDefaultTablename();
    }


    public function getAmbassadorIfExiste($id_talent, $id_ent)
    {
        $this->db->select('*');
        $this->db->from('mentor_ambassadeur');
        $this->db->where('talent_id', $id_talent);
        $this->db->where('id_entreprise', $id_ent);
        $result = $this->db->get();

        return $result->first_row();
    }

    /**
     * @param $fields_table
     *
     * @return stdClass
     */
    public function saveAmbassadeur($fields_table)
    {
        $this->p_tablename = 'mentor_ambassadeur';
        $return            = $this->save($fields_table);
        $this->setDefaultTablename();

        return $return;
    }

    /**
     * @param                $id_ambassadeur
     *
     */
    public function deleteAmbassadeur($id_ambassadeur)
    {
        $this->p_tablename = 'mentor_ambassadeur';
        $this->delete($id_ambassadeur, 'id');
        $this->setDefaultTablename();
    }

    public function updateLevelFormation($id_mentor, $level)
    {
        $this->db->set('niveau_formation', $level);
        $this->db->where('id', $id_mentor);
        $this->db->update('talent');
    }
}

?>