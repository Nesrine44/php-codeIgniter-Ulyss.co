<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller
{
    function __construct(){
        parent::__construct();
    }

    /**
     * @param $registrationID
     */
    public function callbackCardRegistration($registrationID, $userID){
        $data                   = $this->input->get('data');
        $errorCode              = $this->input->get('errorCode');
        $message                = '';
        if( $data != '' && $errorCode == '' ){
            $this->load->library('andafter/Business/BusinessMangopay', null, 'BusinessMangopay');
            $this->load->Model('andafter/ModelUserPaymentProvider', 'ModelUserPaymentProvider');
            $CardRegister       = $this->BusinessMangopay->editCard($registrationID, $data);
            $ModelUserPaymentProvider   = $this->ModelUserPaymentProvider->save(array(
                                            'user_id'   => $userID,
                                            'type'      => ModelUserPaymentProvider::TYPE_MANGOPAY_CARD,
                                            'value'     => $CardRegister->CardId
                                        ));
        } elseif ($errorCode != ''){
            switch ($errorCode){
                case '02625':
                    $message    = 'Veuillez contrôler votre numéro de carte';
                    break;
                case '02626':
                    $message    = 'Veuillez contrôler la date de validité';
                    break;
                case '02627':
                    $message    = 'Veuillez contrôler le cryptogramme';
                    break;
                case '02624':
                    $message    = 'La date de validité semble expirée';
                    break;
                default:
                    $message    = 'Une erreur s\'est produite. Veuillez recommencer ultérieurement';
                    break;
            }
        }
        echo $message; die();
    }
}

