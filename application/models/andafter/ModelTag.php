<?php

/**
 * Class ModelTag
 */
Class ModelTag extends CI_Model{

    /**
     * ModelEntreprise constructor.
     */
    public function __construct(){
        parent::__construct();
        $this->p_tablename  = 'tags';
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById( $id ){
        if( $id<1 )
            return false;

        $sql        = ' SELECT * FROM tags
                        WHERE id = :id
                        LIMIT 0,1
                      ';

        $stmt           = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch( PDO::FETCH_OBJ );
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getByName( $name ){
        if( $name=='' )
            return false;

        $sql        = ' SELECT * FROM tags
                        WHERE nom = :nom
                        LIMIT 0,1
                      ';

        $stmt           = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':nom', $name);
        $stmt->execute();
        return $stmt->fetch( PDO::FETCH_OBJ );
    }
}