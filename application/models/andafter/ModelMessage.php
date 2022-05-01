<?php

/**
 * Class ModelMessage
 */
Class ModelMessage extends CI_Model{

    /**
     * ModelMessage constructor.
     */
    public function __construct(){
        parent::__construct();
        $this->p_tablename  = 'messagerie';
    }

    /**
     * @param $id_experience
     * @return mixed
     */
    public function getAllByConversation( $id_conversation ){
        $sql        = ' SELECT messagerie.* FROM messagerie 
                        WHERE messagerie.id_conversations = :id_conversations
                        ORDER BY date_creation DESC
                      ';

        $stmt           = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id_conversations', $id_conversation);
        $stmt->execute();
        return $stmt->fetchAll( PDO::FETCH_CLASS );
    }
}