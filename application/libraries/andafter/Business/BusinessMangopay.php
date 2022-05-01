<?php

/**
 * Class BusinessMangopay
 */
class BusinessMangopay {

    /**
     * @var \MangoPay\MangoPayApi
     */
    private $mangoPayApi;

    /**
     * MongopayAPI constructor.
     */
    public function __construct(){
        require_once APPPATH.'libraries/Mangopay/MangoPaySdk/Autoloader.php';
        $this->mangoPayApi                          = new MangoPay\MangoPayApi();
        $this->mangoPayApi->Config->ClientId        = 'andafter';
        $this->mangoPayApi->Config->ClientPassword  = 'Q8Eas5c8fdp9uyaMak3RxWhVPmk5bnBbKa0q4pOnpCzJ34GMXL';
        $this->mangoPayApi->Config->TemporaryFolder = 'tmp';
    }

    /**
     * @param $UserId
     * @return mixed
     */
    public function getUser($UserId){
        return $this->mangoPayApi->Users->Get($UserId);
    }

    /**
     * @param array $data
     * @return \MangoPay\UserLegal
     * @throws \MangoPay\Libraries\Exception
     */
    public function createUser($data){
        $User                       = new MangoPay\UserNatural();
        $User->Email                = $data['email'];
        $User->FirstName            = $data['prenom'];
        $User->LastName             = $data['nom'];
        $User->Birthday             = $data['date_naissance'];
        $User->Nationality          = "FR";
        $User->CountryOfResidence   = "FR";
        $User->Capacity             = "NORMAL";
        //Send the request
        return $this->mangoPayApi->Users->Create($User);
    }

    /**
     * @param int $id_user
     * @return \MangoPay\Card[]
     */
    public function getCardsByUser($id_user){
        $Pagination     = new MangoPay\Pagination();
        $Pagination->ItemsPerPage   = 100;
        return $this->mangoPayApi->Users->GetCards($id_user, $Pagination);
    }

    /**
     * @param int $idUserMangoPay
     * @return \MangoPay\CardRegistration
     */
    public function createCard($idUserMangoPay){
        $cardRegister               = new \MangoPay\CardRegistration();
        $cardRegister->UserId       = $idUserMangoPay;
        $cardRegister->Currency     = "EUR";
        $cardRegister->CardType     = "CB_VISA_MASTERCARD";//or alternatively MAESTRO or DINERS
        $cardPreRegistration        = $this->mangoPayApi->CardRegistrations->Create($cardRegister);
        return $cardPreRegistration;
    }

    /**
     * @param string $hashData
     * @return \MangoPay\CardRegistration
     */
    public function editCard($cardRegisterId, $hashData){
        $cardRegister                       = $this->mangoPayApi->CardRegistrations->Get($cardRegisterId);
        $cardRegister->RegistrationData     = 'data='.$hashData;
        $updatedCardRegister                = $this->mangoPayApi->CardRegistrations->Update($cardRegister);
        return $updatedCardRegister;
    }

    /**
     * @param int $card_id
     * @return \MangoPay\CardRegistration
     */
    public function desactivateCard($card_id){
        $cardRegister                       = $this->mangoPayApi->Cards->Get($card_id);
        $cardRegister->Active               = false;
        $updatedCardRegister                = $this->mangoPayApi->Cards->Update($cardRegister);
        return $updatedCardRegister;
    }

    /**
     * @param $user_id
     * @param $card_id
     * @param $callbackUrl
     * @return \MangoPay\CardPreAuthorization
     */
    public function checkCard($user_id, $card_id, $callbackUrl){
        $cardRegister                           = new \MangoPay\CardPreAuthorization();
        $cardRegister->AuthorId                 = $user_id;
        $cardRegister->CardId                   = $card_id;
        $cardRegister->SecureModeReturnURL      = $callbackUrl;
        $cardRegister->DebitedFunds             = new \MangoPay\Money();
        $cardRegister->DebitedFunds->Amount     = '100';
        $cardRegister->DebitedFunds->Currency   = 'EUR';
        $cardRegister->SecureMode               = "DEFAULT";
        $updatedCardRegister                    = $this->mangoPayApi->CardPreAuthorizations->Create($cardRegister);
        return $updatedCardRegister;
    }
}
