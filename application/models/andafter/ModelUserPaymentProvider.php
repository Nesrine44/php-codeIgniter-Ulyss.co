<?php

/**
 * Class ModelUserPaymentProvider
 */
Class ModelUserPaymentProvider extends CI_Model{

    const TYPE_MANGOPAY_USER        = 1;
    const TYPE_MANGOPAY_CARD        = 2;
    const TYPE_MANGOPAY_WALLET      = 3;

    /**
     * ModelUser constructor.
     */
    public function __construct(){
        parent::__construct();
        $this->p_tablename  = 'user_paymentprovider';
    }

    /**
     * @param $id_user
     * @return bool
     */
    public function getByUser_TypeUser( $id_user ){
        if( $id_user == '' )
            return false;

        $sql        = ' SELECT * FROM '.$this->p_tablename.' 
                        WHERE user_id = :user_id
                        AND type = :type
                        LIMIT 0,1
                      ';

        $stmt           = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':user_id', $id_user);
        $stmt->bindValue(':type', self::TYPE_MANGOPAY_USER);
        $stmt->execute();
        return $stmt->fetch( PDO::FETCH_OBJ );
    }

    /**
     * @param $id_user
     * @return bool
     */
    public function getByUser_TypeCard( $id_user ){
        if( $id_user == '' )
            return false;

        $sql        = ' SELECT * FROM '.$this->p_tablename.' 
                        WHERE user_id = :user_id
                        AND type = :type
                        LIMIT 0,1
                      ';

        $stmt           = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':user_id', $id_user);
        $stmt->bindValue(':type', self::TYPE_MANGOPAY_CARD);
        $stmt->execute();
        return $stmt->fetch( PDO::FETCH_OBJ );
    }
}