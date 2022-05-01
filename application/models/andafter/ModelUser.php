<?php

/**
 * Class ModelUser
 */
Class ModelUser extends CI_Model
{

    /**
     * ModelUser constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->p_tablename = 'user';
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        if ($id < 1) {
            return false;
        }

        $sql
            = ' SELECT user.* FROM user 
                        WHERE user.id = :user_id
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':user_id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    public function getUserByEmail($email)
    {
        if ($email == '') {
            return false;
        }

        $sql
            = ' SELECT user.* FROM user 
                        WHERE user.email = :user_email
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':user_email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    public function getUserByHash($hash)
    {
        if ($hash == '') {
            return false;
        }

        $sql
            = ' SELECT user.* FROM user 
                        WHERE user.hash = :user_hash
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':user_hash', $hash);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $id_linkedin
     *
     * @return mixed
     */
    public function getUserByIdLinkedin($id_linkedin)
    {
        if ($id_linkedin == '') {
            return false;
        }

        $sql
            = ' SELECT user.* FROM user 
                        WHERE user.uid = :uid
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':uid', $id_linkedin);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if ($result == false || $result = null) {
            return $result = null;
        } else {
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
    }

    /**
     * @param $param
     */
    public function insertUser($param)
    {
        $this->db->set($param);
        $this->db->insert($this->table);
    }

    public function getRDVFromTwoDates($id, $from, $to)
    {
        $sql
            = ' SELECT * FROM talent_demandes 
                                    WHERE (talent_id = :id OR user_id_acheteur = :id)
                                    AND (date_livraison BETWEEN :date_from AND :date_to )
                                    
                                  ';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':date_from', $from);
        $stmt->bindParam(':date_to', $to);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function countAllRDVValides($id)
    {
        $sql
            = ' SELECT COUNT(*) FROM talent_demandes 
                                    WHERE user_id_acheteur = :id
                                    AND talent_demandes.status = "validé"
                                  ';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function countAllRDVAnnules($id)
    {
        $sql
            = ' SELECT COUNT(*) FROM talent_demandes 
                                    WHERE user_id_acheteur = :id
                                    AND talent_demandes.status = "rejeté"
                                  ';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * @param $id
     *
     * @return int
     */
    public function countAllRDVEnAttente($id)
    {
        $sql
            = ' SELECT COUNT(*) FROM talent_demandes 
                                    WHERE user_id_acheteur = :id
                                    AND talent_demandes.status = "en-attente"
                                  ';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function getRDV($id_rdv, $id_user)
    {
        $sql
            = ' SELECT * FROM talent_demandes 
                                WHERE (talent_id = :id OR user_id_acheteur = :id)
                                AND id = :id_rdv
                                LIMIT 0,1
                              ';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id', $id_user);
        $stmt->bindParam(':id_rdv', $id_rdv);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @return mixed
     */
    public function getAllRDV($id_user)
    {
        $sql
            = ' SELECT * FROM talent_demandes 
                                WHERE (user_id_acheteur = :id)
                                AND status != "undefined"
                              ';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id', $id_user);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }


    public function getEntrepriseList($q)
    {
        $sql
            = ' SELECT entreprise.nom AS value, entreprise.id AS id 
                        FROM entreprise 
                        INNER JOIN talent_experience
                          ON talent_experience.entreprise_id = entreprise.id
                        INNER JOIN talent
                          ON talent.id = talent_experience.talent_id
                          AND talent.status = :status
                        WHERE entreprise.nom LIKE :nom
                        GROUP BY entreprise.id
                        ORDER BY nom ASC
                      ';
        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindValue(':nom', '%' . $q . '%');
        $stmt->bindValue(':status', ModelTalent::VALID);
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function getEcoleLieuById($id)
    {
        return $this->db->select('lieu')
            ->from('ecole')
            ->where('id', $id)
            ->get()
            ->lieu;
    }


    public function CheckIfUserIsTalentByUserId($id_user)
    {
        return $this->db->select('*')
            ->from('talent')
            ->where('user_id', $id_user)
            ->get()
            ->row();
    }

    /**
     * @param $user_id
     */
    function verifFirstTime($user_id)
    {
        $talent = $this->db->select('niveau_formation,departement_id')
            ->from('talent')
            ->where('user_id', $user_id)
            ->get()
            ->row();

        if (empty($talent) || $talent->niveau_formation == null || $talent->departement_id == null) {
            return true;
        } else {
            return false;
        }
    }


}