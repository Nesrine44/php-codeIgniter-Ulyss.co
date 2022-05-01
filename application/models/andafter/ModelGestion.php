<?php

/**
 * Class ModelGestion
 */
Class ModelGestion extends CI_Model
{

    /**
     * ModelGestion constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $password
     *
     * @return bool|mixed|string
     */
    public function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param $password
     * @param $bddpass
     *
     * @return bool
     */
    public function verifyPassword($password, $bddpass)
    {
        return password_verify($password, $bddpass);
    }

    /**
     * @param $email
     * @param $password
     *
     * @return null|StdClass
     */
    public function Authentificate($email, $password)
    {
        $sql
            = ' SELECT * FROM administrateur
                        WHERE email = :email
                        LIMIT 0,1
                      ';


        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $Administrateur = $stmt->fetch(PDO::FETCH_OBJ);

        if ($Administrateur != null && $Administrateur instanceof StdClass) {
            if ($this->verifyPassword($password, $Administrateur->password) == false) {
                return null;
            }
        }

        return $Administrateur;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getCountAllCandidats($dateStart = null, $dateEnd = null)
    {
        $sql
            = ' SELECT * FROM talent
                            WHERE status = 0
                          ';
        if ($dateStart != null && $dateEnd != null) {
            $sql .= ' AND (date_creation BETWEEN "' . $dateStart . '" AND "' . $dateEnd . '" ) ';
        }

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getAllCandidats($dateStart = null, $dateEnd = null)
    {
        $sql = ' SELECT talent.* FROM talent WHERE status = 0 ';
        if ($dateStart != null && $dateEnd != null) {
            $sql .= ' AND (talent.date_creation BETWEEN "' . $dateStart . '" AND "' . $dateEnd . '" ) ';
        }

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getCountAllTalents($dateStart = null, $dateEnd = null)
    {
        $sql
            = ' SELECT * FROM talent
                            WHERE status = 1
                          ';
        if ($dateStart != null && $dateEnd != null) {
            $sql .= ' AND (date_creation BETWEEN "' . $dateStart . '" AND "' . $dateEnd . '" ) ';
        }

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getAllTalents($dateStart = null, $dateEnd = null)
    {
        $sql = ' SELECT talent.* FROM talent WHERE status = 1 ';
        if ($dateStart != null && $dateEnd != null) {
            $sql .= ' AND (talent.date_creation BETWEEN "' . $dateStart . '" AND "' . $dateEnd . '" ) ';
        }

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getCountAllDemandes($dateStart = null, $dateEnd = null)
    {
        $sql
            = ' SELECT * FROM talent_demandes
                            WHERE status != "undefined"
                          ';
        if ($dateStart != null && $dateEnd != null) {
            $sql .= ' AND (date_livraison BETWEEN "' . $dateStart . '" AND "' . $dateEnd . '" ) ';
        }

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getAllDemandes($dateStart = null, $dateEnd = null)
    {
        $sql
            = ' SELECT * FROM talent_demandes
                            WHERE status != "undefined"
                          ';
        if ($dateStart != null && $dateEnd != null) {
            $sql .= ' AND (date_livraison BETWEEN "' . $dateStart . '" AND "' . $dateEnd . '" ) ';
        }
        $sql .= ' ORDER BY date_livraison, horaire ASC';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getCountAllDemandesValid($dateStart = null, $dateEnd = null)
    {
        $sql
            = ' SELECT * FROM talent_demandes
                            WHERE status = "validé"
                          ';
        if ($dateStart != null && $dateEnd != null) {
            $sql .= ' AND (date_livraison BETWEEN "' . $dateStart . '" AND "' . $dateEnd . '" ) ';
        }

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getAllDemandesRealises($dateStart = null, $dateEnd = null)
    {
        $sql
            = ' SELECT * FROM talent_demandes
                            WHERE status = "validé"
                          ';
        if ($dateStart != null && $dateEnd != null) {
            $sql .= ' AND (date_livraison BETWEEN "' . $dateStart . '" AND "' . $dateEnd . '" ) ';
        }
        $sql .= ' ORDER BY date_livraison, horaire ASC';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @return mixed
     */
    public function getAllEntreprises()
    {
        $sql
              = '  SELECT * FROM entreprise
                             WHERE 1
                          ';
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @return mixed
     */
    public function getStatusUserByEntreprises()
    {
        $sql
              = ' SELECT entreprise_id, status, entreprise.* FROM talent_experience
                            INNER JOIN talent
                              ON talent.id = talent_experience.talent_id
                            INNER JOIN entreprise 
                              ON entreprise.id = talent_experience.entreprise_id
                            GROUP BY entreprise_id, talent_id
                            ORDER BY talent_experience.entreprise_id ASC
                          ';
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @return mixed
     */
    public function getStatusUserBySecteurs()
    {
        $sql
              = ' SELECT secteur_id, status, secteur_activite.* FROM talent_experience
                            INNER JOIN talent
                              ON talent.id = talent_experience.talent_id
                            INNER JOIN secteur_activite 
                              ON secteur_activite.id = talent_experience.secteur_id
                            GROUP BY secteur_id, talent_id
                            ORDER BY talent_experience.secteur_id ASC
                          ';
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @return mixed
     */
    public function getStatusUserByDepartements()
    {
        $sql
              = ' SELECT departement_id, status, categorie_groupe.* FROM talent_experience
                            INNER JOIN talent
                              ON talent.id = talent_experience.talent_id
                            INNER JOIN categorie_groupe 
                              ON categorie_groupe.id = talent_experience.departement_id
                            GROUP BY departement_id, talent_id
                            ORDER BY talent_experience.departement_id ASC
                          ';
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @return mixed
     */
    public function getStatusUserByFonctions()
    {
        $sql
              = ' SELECT fonction_id, status, categorie.* FROM talent_experience
                            INNER JOIN talent
                              ON talent.id = talent_experience.talent_id
                            INNER JOIN categorie 
                              ON categorie.id = talent_experience.fonction_id
                            GROUP BY fonction_id, talent_id
                            ORDER BY talent_experience.fonction_id ASC
                          ';
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
}