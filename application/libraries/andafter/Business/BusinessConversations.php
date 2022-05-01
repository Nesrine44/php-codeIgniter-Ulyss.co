<?php

/**
 * Class BusinessConversations
 */
class BusinessConversations extends Business{

    private $_BusinessConversations;

    /**
     * BusinessConversations constructor.
     * @param null $Message
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * @return array
     */
    public function getAllByUser(){
        if( $this->_BusinessConversations == null ){
            $this->_BusinessConversations    = array();
            $Conversations                   = $this->getContext()->ModelConversations->getAllByUserId(
                                                    $this->getContext()->getBusinessUser()->getId(),
                                                    $this->getContext()->getBusinessUser()->getBusinessTalent()->getId()
                                                );

            if( is_array($Conversations) ){
                foreach ($Conversations as $Conversation) {
                    $BusinessConversation  = new BusinessConversation( $Conversation );
                    if( $BusinessConversation->getBusinessUserInterlocutor()->getId() > 0 )
                        $this->_BusinessConversations[]   = $BusinessConversation;
                }
            }
        }
        return $this->_BusinessConversations;
    }
}
