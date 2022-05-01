<?php

/**
 * Class ModelSecteur
 */
Class ModelSecteur extends CI_Model{

    /**
     * ModelEntreprise constructor.
     */
    public function __construct(){
        parent::__construct();
        $this->p_tablename  = 'secteur_activite';
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getByName( $name ){
        if( $name=='' )
            return false;

        $sql        = ' SELECT * FROM secteur_activite
                        WHERE nom = :nom
                        LIMIT 0,1
                      ';

        $stmt           = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':nom', $name);
        $stmt->execute();
        return $stmt->fetch( PDO::FETCH_OBJ );
    }
}