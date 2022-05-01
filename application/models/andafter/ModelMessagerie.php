<?php

/**
 * Class ModelMessagerie
 */
Class ModelMessagerie extends CI_Model{

    /**
     * ModelTalent constructor.
     */
    public function __construct(){
        parent::__construct();
        $this->p_tablename  = 'messagerie';
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function getMessagesReceived_GroupingConversation( $user_id ){
        $sql                = ' SELECT *, COUNT(id) AS COUNT_MESSAGES FROM messagerie
                                WHERE user_id_recep = :id_user
                                GROUP BY id_conversations
                              ';

        $stmt               = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id_user', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function getMessagesSend_GroupingConversation( $user_id ){
        $sql                = ' SELECT *, COUNT(id) AS COUNT_MESSAGES FROM messagerie
                                WHERE user_id_send = :id_user
                                GROUP BY id_conversations
                              ';

        $stmt               = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id_user', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $id_user
     * @return int
     */
    public function getAllNotReadByUser( $id_user ){
        $select = '*';
        $where = array('user_id_recep' => $id_user, 'status' => 0);
        return $this->db->select($select)
            ->from("messagerie")
            ->where($where)
            ->count_all_results();
    }
}