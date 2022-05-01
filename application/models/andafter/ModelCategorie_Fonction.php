<?php

/**
 * Class ModelCategorie_Fonction
 */
Class ModelCategorie_Fonction extends CI_Model{

    /**
     * ModelEntreprise constructor.
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById( $id ){
        if( $id<1 )
            return false;

        $sql        = ' SELECT categorie.*
                        FROM categorie
                        WHERE categorie.id = :categorie_id
                        LIMIT 0,1
                      ';

        $stmt           = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':categorie_id', $id);
        $stmt->execute();
        return $stmt->fetch( PDO::FETCH_OBJ );
    }
}