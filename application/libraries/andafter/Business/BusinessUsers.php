<?php

/**
 * Class BusinessUsers
 */
class BusinessUsers extends Business{

    private $_Users, $_BusinessUsers;

    /**
     * BusinessUsers constructor.
     * @param null $Talent
     */
    public function __construct( $Users = array() ){
        parent::__construct();
        $this->_Users     = $Users;
    }

    /**
     * @return array
     */
    public function getUsers(){
        return $this->_Users;
    }

    /**
     * @return bool
     */
    public function hasUsers(){
        return is_array($this->getUsers()) && count($this->getUsers())>0;
    }

    /**
     * @return array
     */
    public function getAll(){
        if( $this->hasUsers() && $this->_BusinessUsers === NULL ){
            $this->_BusinessUsers     = array();
            foreach($this->getUsers() as $User) {
                $this->_BusinessUsers[]   = new BusinessUser($User);
            }
        }
        return $this->_BusinessUsers;
    }

}
