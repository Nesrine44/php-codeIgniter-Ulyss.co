<?php

/**
 * Class ModelQuestionnaire
 */
Class ModelQuestionnaire extends CI_Model
{

    /**
     * ModelQuestionnaire constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->p_tablename = 'questionnaire';
    }

    public function getByConversationId($id)
    {
        if ($id < 1) {
            return false;
        }

        $sql
            = ' SELECT questionnaire.* FROM questionnaire
                        WHERE questionnaire.conversation_id = :conversation_id
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':conversation_id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAllQuestionnairesForGestion()
    {
        $sql
              = ' SELECT questionnaire.* FROM questionnaire 
                        WHERE questionnaire.status = "1"
                      ';
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function getQuestionnaireMentorByConversationId($id)
    {
        if ($id < 1) {
            return false;
        }

        $sql
            = ' SELECT questionnaire_mentor.* FROM questionnaire
                        WHERE questionnaire_mentor.conversation_id = :conversation_id
                        LIMIT 0,1
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':conversation_id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAllQuestionnairesMentorForGestion()
    {
        $sql
              = ' SELECT questionnaire_mentor.* FROM questionnaire_mentor 
                        WHERE questionnaire_mentor.status = "1"
                      ';
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function saveQuestMentor($array_fields)
    {
        $this->p_tablename = 'questionnaire_mentor';
        $this->save($array_fields);
        $this->p_tablename = 'questionnaire';
    }
}