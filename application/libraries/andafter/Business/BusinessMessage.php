<?php

/**
 * Class BusinessMessage
 */
class BusinessMessage extends Business{

    protected $_Message, $_BusinessUserInterlocuteur, $_BusinessUserSender;

    /**
     * BusinessMessage constructor.
     * @param null $Message
     */
    public function __construct( $Message = null ){
        parent::__construct();
        $this->_Message  = $Message;
    }

    /**
     * @return StdClass
     */
    public function getMessage(){
        return $this->_Message;
    }

    /**
     * @return bool
     */
    public function hasMessage(){
        return $this->getMessage() instanceof stdClass && $this->getMessage()->id>0;
    }

    public function getId()                 { return $this->hasMessage() ? (int)$this->getMessage()->id                 : -1; }
    public function getUserIdSender()       { return $this->hasMessage() ? (int)$this->getMessage()->user_id_send       : -1; }
    public function getUserIdRecept()       { return $this->hasMessage() ? (int)$this->getMessage()->user_id_recep      : -1; }
    public function getDate()               { return $this->hasMessage() ? $this->getMessage()->date_creation           : ''; }
    public function getText()               { return $this->hasMessage() ? $this->getMessage()->text                    : ''; }
    public function getIdConversation()     { return $this->hasMessage() ? (int)$this->getMessage()->id_conversations   : -1; }
    public function getStatus()             { return $this->hasMessage() ? (bool)$this->getMessage()->status            : false; }
    public function isAdminMessage()        { return $this->hasMessage() ? (bool)$this->getMessage()->admin_message     : false; }

    /**
     * @return BusinessUser
     */
    public function getBusinessUserInterlocutor(){
        if( $this->_BusinessUserInterlocuteur == null ){
            $idInterlocutor                     = $this->getContext()->getBusinessUser()->getId() != $this->getUserIdSender()
                                                    ? $this->getUserIdSender()
                                                    : $this->getUserIdRecept();
            $ModelUser                          = $this->getContext()->ModelUser->getById( $idInterlocutor );
            $this->_BusinessUserInterlocuteur   = new BusinessUser( $ModelUser );
        }
        return $this->_BusinessUserInterlocuteur;
    }

    /**
     * @return BusinessUser
     */
    public function getBusinessUserSender(){
        if( $this->_BusinessUserSender == null ){
            $ModelUser                      = $this->getContext()->ModelUser->getById( $this->getUserIdSender() );
            $this->_BusinessUserSender      = new BusinessUser( $ModelUser );
        }
        return $this->_BusinessUserSender;
    }

    /**
     * @return string
     */
    public function getDateInText(){
        if( $this->getDate() != '' )
            return ucfirst(strftime("%A %d %B %Y - %H:%M", strtotime($this->getDate())));
        return '';
    }

    /**
     * @return string
     */
    public function getStatusInClass(){
        return $this->getStatus()==false && $this->getUserIdRecept() == $this->getContext()->getBusinessUser()->getId() ? 'non_lu' : '';
    }

    /**
     * @return string
     */
    public function getBoxInClass(){
        if( $this->isAdminMessage() )
            return 'item_msg_chat_left';
        return $this->getUserIdSender() == $this->getContext()->getBusinessUser()->getId() ? 'item_msg_chat_right' : 'item_msg_chat_left';
    }
}
