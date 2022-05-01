<?php

/**
 * Class ModelConversations
 */
Class ModelConversations extends CI_Model
{

    /**
     * ModelConversation constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $talent_id
     *
     * @return mixed
     */
    public function getAllByUserId($user_id, $talent_id)
    {
        if ($user_id < 1) {
            return false;
        }

        $sql
            = ' SELECT * FROM conversations
                        WHERE (talent_id = :talent_id
                        OR user_id = :user_id)
                        ORDER BY date DESC
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':talent_id', $talent_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $talent_id
     *
     * @return mixed
     */
    public function getAllForQuestionnaire($user_id)
    {
        if ($user_id < 1) {
            return false;
        }

        $sql
            = ' SELECT conversations.* FROM conversations
                        INNER JOIN talent_demandes
                        ON conversations.demandes_talent_id = talent_demandes.id
                          AND talent_demandes.status = :status
                        WHERE user_id = :user_id
                          AND CONCAT( talent_demandes.date_livraison, " ", SUBSTR(talent_demandes.horaire, 4, 2), ":00:00" ) < DATE_SUB(NOW(), INTERVAL 2 HOUR)
                          AND conversations.id NOT IN(
                            SELECT conversation_id FROM questionnaire WHERE conversation_id = conversations.id
                          )
                          AND conversations.user_id = :user_id
                        ORDER BY CONCAT( talent_demandes.date_livraison, " ", SUBSTR(talent_demandes.horaire, 4, 2), ":00:00" ) ASC
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindValue(':status', BusinessTalentDemande::STATUS_VALIDER);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * @param $talent_id
     *
     * @return mixed
     */
    public function getAllForQuestionnaireMentor($talent_id)
    {
        if ($talent_id < 1) {
            return false;
        }

        $sql
            = ' SELECT conversations.* FROM conversations
                        INNER JOIN talent_demandes
                        ON conversations.demandes_talent_id = talent_demandes.id
                          AND talent_demandes.status = :status
                        WHERE talent_demandes.talent_id = :talent_id
                          AND CONCAT( talent_demandes.date_livraison, " ", SUBSTR(talent_demandes.horaire, 4, 2), ":00:00" ) < DATE_SUB(NOW(), INTERVAL 2 HOUR)
                          AND conversations.id NOT IN(
                            SELECT conversation_id FROM questionnaire_mentor WHERE conversation_id = conversations.id
                          )
                          AND conversations.talent_id = :talent_id
                        ORDER BY CONCAT( talent_demandes.date_livraison, " ", SUBSTR(talent_demandes.horaire, 4, 2), ":00:00" ) ASC
                      ';

        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':talent_id', $talent_id);
        $stmt->bindValue(':status', BusinessTalentDemande::STATUS_VALIDER);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }
}