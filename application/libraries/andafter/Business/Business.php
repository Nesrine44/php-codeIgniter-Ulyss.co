<?php

/**
 * Class Business
 */
class Business {

    /**
     * Business constructor.
     */
    public function __construct(){

    }

    /**
     * @return CI_Controller
     */
    public function getContext(){
        $controllerInstance = & get_instance();
        return $controllerInstance;
    }

    public static function getDateFormatted($date){
        if( substr($date, 5, 5) == '01-01' || substr($date, 5, 5) == '12-31' )
            $date = substr($date, 0, 4);
        if( strlen($date) == '4' ){ /* Just Year */
            return $date;
        } else if(strlen($date) > '4') {
            return ucfirst(strftime('%B %Y', strtotime($date)));
        } else {
            return '';
        }
    }

    /**
     * @param $status
     * @param bool $is_mentor
     * @return string
     */
    public static function getTextPrestationStatut($status, $is_mentor = false){
        switch( $status ){
            case 'en-attente':
                $message 	= $is_mentor?'RDV à confirmer':'Attente confirmation mentor';
                break;
            case 'validé':
                $message 	= 'Rendez-vous confirmé';
                break;
            case 'rejeté':
                $message 	= 'Rendez-vous annulé';
                break;
            default:
                $message 	= '';
        }

        return $message;
    }
}
