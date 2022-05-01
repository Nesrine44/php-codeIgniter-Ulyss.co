<?php

/**
 * Class ModelConversation
 */
Class ModelConversation extends CI_Model{

    /**
     * ModelConversation constructor.
     */
    public function __construct(){
        parent::__construct();
        $this->p_tablename  = 'conversations';
    }

    public function getByTalentDemandeId( $id ) {
        if( $id=='' )
            return false;

        $sql        = ' SELECT conversations.* FROM conversations
                        WHERE demandes_talent_id = :demandes_talent_id
                        LIMIT 0,1
                      ';

        $stmt           = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':demandes_talent_id', $id);
        $stmt->execute();
        return $stmt->fetch( PDO::FETCH_OBJ );
    }
}