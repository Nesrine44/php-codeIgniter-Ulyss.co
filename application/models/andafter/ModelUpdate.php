<?php

/**
 * Class ModelUpdate
 */
Class ModelUpdate extends CI_Model
{

    function recupToutesEntreprises()
    {

        $sql
            = ' SELECT entreprise.* 
                FROM entreprise';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);

    }

    function recupEntrepriseAvecCode()
    {

        $sql
            = ' SELECT entreprise.* 
                FROM entreprise
                WHERE entreprise.code IS NOT NULL ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);

    }

    function recupEntrepriseSansCode()
    {

        $sql
            = ' SELECT entreprise.* 
                FROM entreprise
                WHERE entreprise.code IS NULL ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);


    }

    function Doublon($idvrai, $nom)
    {
        if ($nom == null) {
            return false;
        }

        $sql
            = ' SELECT * 
                FROM entreprise
                        WHERE nom LIKE "' . $nom . '%"
                        AND code IS NULL 
                        AND NOT id =' . $idvrai;

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    function toutLesDoublon($nom)
    {
        if ($nom == null) {
            return false;
        }

        $sql
            = ' SELECT * 
                FROM entreprise
                        WHERE nom LIKE "%' . $nom . '%"';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    function SearchAndDestroyIdEntrepriseInExperience($idreel, $idfaut)
    {

        $sql
            = ' UPDATE talent_experience
                SET entreprise_id = ' . $idreel . '
                WHERE entreprise_id = ' . $idfaut;

        $stmt = $this->db->conn_id->prepare($sql);

        return $stmt->execute();
    }


    function DestroyDoublon($idvrai, $idfaut)
    {

        $sql
            = ' DELETE FROM entreprise
                WHERE entreprise.code IS NULL
                AND id =' . $idfaut . ' 
                AND NOT id =' . $idvrai;

        $stmt = $this->db->conn_id->prepare($sql);

        return $stmt->execute();
    }

    /**
     * @return mixed
     */
    public function getAllUserLinkedin()
    {
        $sql = 'SELECT * FROM user_linkedin ORDER BY id_user LIMIT 0,15';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @return mixed
     */
    public function getAllUser()
    {
        $sql = 'SELECT * FROM user ORDER BY id 0,15';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @return mixed
     */
    public function getAllEnt()
    {
        $sql = 'SELECT * FROM entreprise ORDER BY id limit 0,50';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }


    /**
     * @return boolean
     */
    public function saveAvatarById($id, $new_avatar)
    {


        $sql = ' UPDATE user SET avatar = "' . $new_avatar . '"WHERE id = ' . $id;

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);

        return $stmt->execute();

    }


    /**
     * @return boolean
     */
    public function saveAvatarEntById($id, $new_avatar)
    {


        $sql = ' UPDATE entreprise SET logo = "' . $new_avatar . '"WHERE id = ' . $id;

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);

        return $stmt->execute();

    }


    /**
     * @return boolean
     */
    public function saveAvatarByIdInLinkedinTable($id, $new_avatar)
    {
        $sql = ' UPDATE user_linkedin SET `picture-url` = "' . $new_avatar . '"WHERE id_user = ' . $id;

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);

        return $stmt->execute();

    }

    public function getIndustry()
    {
        return $this->db->select('*')
            ->from('industries')
            ->get();

    }

    public function updateIndFr($id, $nomEn)
    {
        return $this->db->set('name', $nomEn, false)
            ->where('id', $id)
            ->update('secteur_activté');

    }
}
