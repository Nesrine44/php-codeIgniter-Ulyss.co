<?php

/**
 * Class BusinessConversation
 */
class BusinessConversation extends Business{

    private $_Conversation, $_LastBusinessMessage, $_AllMessages, $_TalentDemande, $_BusinessUserInterlocuteur;

    /**
     * BusinessConversation constructor.
     * @param null $Conversation
     */
    public function __construct( $Conversation = null ){
        parent::__construct();
        $this->_Conversation  = $Conversation;
    }

    /**
     * @return StdClass
     */
    public function getConversation(){
        return $this->_Conversation;
    }

    /**
     * @return bool
     */
    public function hasConversation(){
        return $this->getConversation() instanceof stdClass && $this->getConversation()->id>0;
    }

    public function getId()                 { return $this->hasConversation() ? (int)$this->getConversation()->id                   : -1; }
    public function getTalentId()           { return $this->hasConversation() ? (int)$this->getConversation()->talent_id            : -1; }
    public function getUserId()             { return $this->hasConversation() ? (int)$this->getConversation()->user_id              : -1; }
    public function getDate()               { return $this->hasConversation() ? (int)$this->getConversation()->date                 : ''; }
    public function getDemandeTalentId()    { return $this->hasConversation() ? (int)$this->getConversation()->demandes_talent_id   : -1; }
    public function getLastMessageId()      { return $this->hasConversation() ? (int)$this->getConversation()->last_message_id      : -1; }

    /**
     * @return BusinessMessage
     */
    public function getLastBusinessMessage(){
        if( $this->_LastBusinessMessage == null ){
            $ModelMessage                   = $this->getContext()->ModelMessage->getById( $this->getLastMessageId() );
            $this->_LastBusinessMessage     = new BusinessMessage( $ModelMessage );
        }
        return $this->_LastBusinessMessage;
    }

    /**
     * @return array
     */
    public function getAllMessages(){
        if( $this->_AllMessages == null ){
            $ModelMessage                   = $this->getContext()->ModelMessage->getAllByConversation( $this->getId() );
            $this->_AllMessages             = array();
            foreach ($ModelMessage as $Message) {
                $this->_AllMessages[]       = new BusinessMessage( $Message );
            }
        }
        return $this->_AllMessages;
    }

    /**
     * @return BusinessTalentDemande
     */
    public function getBusinessDemandeRDV(){
        if( $this->_TalentDemande == null ){
            $TalentDemande              = $this->getContext()->ModelTalent->getRDV( $this->getDemandeTalentId(), $this->getTalentId(), $this->getUserId() );
            $this->_TalentDemande       = new BusinessTalentDemande( $TalentDemande );
        }
        return $this->_TalentDemande;
    }

    /**
     * @return BusinessUser
     */
    public function getBusinessUserInterlocutor(){
        if( $this->_BusinessUserInterlocuteur == null ){
            if( $this->getContext()->getBusinessUser()->getId() != $this->getUserId() ){
                $ModelUser                      = $this->getContext()->ModelUser->getById( $this->getUserId() );
            } else {
                $ModelTalent                    = $this->getContext()->ModelTalent->getById( $this->getTalentId() );
                $BusinessTalent                 = new BusinessTalent( $ModelTalent );
                $ModelUser                      = $BusinessTalent->getBusinessUser()->getUser();
            }
            $this->_BusinessUserInterlocuteur   = new BusinessUser( $ModelUser );
        }
        return $this->_BusinessUserInterlocuteur;
    }

    /**
     * @return bool
     */
    public function IamTalentInConversation(){
        return $this->getContext()->getBusinessUser()->getId() != $this->getUserId();
    }

    /**
     * @return bool
     */
    public function IamCandidatInConversation(){
        return $this->getContext()->getBusinessUser()->getId() == $this->getUserId();
    }

    /**
     * @param $text
     * @param $is_admin_message
     * @return bool
     */
    public function sendNewMessage( $text, $is_admin_message ){
        $Message['user_id_send']            = $this->getContext()->getBusinessUser()->getId();
        $Message['user_id_recep']           = $this->getBusinessUserInterlocutor()->getId();
        $Message['text']                    = $text;
        $Message['id_conversations']        = $this->getId();
        $Message['admin_message']           = $is_admin_message;
        $ModelMessage                       = $this->getContext()->ModelMessage->save( $Message );

        $Conversation['id']                 = $this->getId();
        $Conversation['last_message_id']    = $ModelMessage->id;
        $this->getContext()->ModelConversation->save( $Conversation );
        return true;
    }
}
