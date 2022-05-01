<?php

/**
 * Class ModelVille
 */
Class ModelVille extends CI_Model
{

    /**
     * ModelUser constructor.
     */
    public function __construct()
    {
        parent::__construct();
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
            = ' SELECT villes.* FROM villes 
                        WHERE villes.id = :villes_id
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':villes_id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}