<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mangopay_lib
{
    public function __construct()
    {
        require_once 'Mangopay/MangoPaySdk/Autoloader.php';
        $this->mangoPayApi = new MangoPay\MangoPayApi();
        $this->mangoPayApi->Config->ClientId = 'andafter';
        $this->mangoPayApi->Config->ClientPassword = 'Q8Eas5c8fdp9uyaMak3RxWhVPmk5bnBbKa0q4pOnpCzJ34GMXL';
        $this->mangoPayApi->Config->TemporaryFolder = 'tmp';
    }

//Build the parameters for the request
    public function create_user($data)
    {
        $User = new MangoPay\UserNatural();
        $User->Email                = $data['email'];
        $User->FirstName            = $data['prenom'];
        $User->LastName             = $data['nom'];
        $User->Birthday             = $data['date_naissance'];
        $User->Nationality          = "FR";
        $User->CountryOfResidence   = "FR";
        //Send the request
        $createdUser = $this->mangoPayApi->Users->Create($User);

        //Now for the wallet
        $Wallet = new MangoPay\Wallet();
        $Wallet->Owners = array($createdUser->Id);
        $Wallet->Description = "creating wallet";
        $Wallet->Currency = "EUR";
        //Send the request
        $createdWallet = $this->mangoPayApi->Wallets->Create($Wallet);
        return $createdWallet->Id;
    }

    public function createCarde($data)
    {
// Register card for user
        $Wallet = new MangoPay\Wallet();
        $wallet_info = $this->mangoPayApi->Wallets->Get($data['id']);

        $cardRegister = new \MangoPay\CardRegistration();
        $cardRegister->UserId = $wallet_info->Owners[0];
        $cardRegister->Currency = "EUR";
        $cardRegister->CardType = "CB_VISA_MASTERCARD";//or alternatively MAESTRO or DINERS
        $cardRegister->active = false;//or alternatively MAESTRO or DINERS
        $cardPreRegistration = $this->mangoPayApi->CardRegistrations->Create($cardRegister);
        return $cardPreRegistration;
    }

    public function validation_payement()
    {

        $this->CI =& get_instance();
        try {
            // update register card with registration data from Payline service

            $cardRegister = $this->mangoPayApi->CardRegistrations->Get($this->CI->session->userdata('cardRegisterId'));
            $cardRegister->RegistrationData = isset($_GET['data']) ? 'data=' . $_GET['data'] : 'errorCode=' . $_GET['errorCode'];
            $updatedCardRegister = $this->mangoPayApi->CardRegistrations->Update($cardRegister);

            if ($updatedCardRegister->Status != 'VALIDATED' || !isset($updatedCardRegister->CardId))
                die('<div style="color:red;">Cannot create virtual card. Payment has not been created.<div>');
            // get created virtual card object
            $card = $this->mangoPayApi->Cards->Get($updatedCardRegister->CardId);
            // create temporary wallet for user
            /*    $wallet = new \MangoPay\Wallet();
                $wallet->Owners = array( $updatedCardRegister->UserId );
                $wallet->Currency = 'EUR';
                $wallet->Description = 'Temporary wallet for payment demo';
                $createdWallet = $this->mangoPayApi->Wallets->Create($wallet);*/
            // create pay-in CARD DIRECT
            $payIn = new \MangoPay\PayIn();
            $payIn->CreditedWalletId = $this->CI->session->userdata('mywallet');
            $payIn->AuthorId = $updatedCardRegister->UserId;
            $payIn->DebitedFunds = new \MangoPay\Money();
            $payIn->DebitedFunds->Amount = $this->CI->session->userdata('amount') * 100;
            $payIn->DebitedFunds->Currency = 'EUR';
            $payIn->Fees = new \MangoPay\Money();
            $payIn->Fees->Amount = 0;
            $payIn->Fees->Currency = 'EUR';
            // payment type as CARD
            $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
            $payIn->PaymentDetails->CardType = $card->CardType;
            // execution type as DIRECT
            $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
            $payIn->ExecutionDetails->CardId = $card->Id;
            $payIn->ExecutionDetails->SecureModeReturnURL = base_url();
            // create Pay-In
            $createdPayIn = $this->mangoPayApi->PayIns->Create($payIn);
            // if created Pay-in object has status SUCCEEDED it's mean that all is fine
//var_dump($createdPayIn);
            if ($createdPayIn->Status == 'SUCCEEDED') {
                return $createdPayIn->Id;
            } else {
                return false;
            }
        } catch (\MangoPay\Libraries\ResponseException $e) {
            return false;
            /*    print '<div style="color: red;">'
                            .'\MangoPay\ResponseException: Code: '
                            . $e->getCode() . '<br/>Message: ' . $e->getMessage()
                            .'<br/><br/>Details: '; print_r($e->GetErrorDetails())
                    .'</div>';*/
        }
// clear data in session to protect against double processing
//$_SESSION = array();	
    }

    public function transfereBetweenTowallet($hunter_wallet, $wanted_wallet, $montant, $comission)
    {
//Build the parameters for the request
        $Transfer = new \MangoPay\Transfer();
        $Wallet = new MangoPay\Wallet();

        $wallet_hunter_info = $this->mangoPayApi->Wallets->Get($hunter_wallet);
        $Transfer->AuthorId = $wallet_hunter_info->Owners[0];

        $wallet_wanted_info = $this->mangoPayApi->Wallets->Get($wanted_wallet);
        $Transfer->CreditedUserId = $wallet_wanted_info->Owners[0];

        $Transfer->DebitedFunds = new \MangoPay\Money();
        $Transfer->DebitedFunds->Currency = "EUR";
        $Transfer->DebitedFunds->Amount = $montant * 100;

        $Transfer->Fees = new \MangoPay\Money();
        $Transfer->Fees->Currency = "EUR";
        $Transfer->Fees->Amount = $comission;

        $Transfer->DebitedWalletID = $hunter_wallet;
        $Transfer->CreditedWalletId = $wanted_wallet;
        $Transfer->Tag = "Prestation easylearn";
//Send the request

        $result = $this->mangoPayApi->Transfers->Create($Transfer);
//edit paiement


        return $result;

    }

    /*add acoount bank*/
    public function createBankAccount($wallet_id, $bank)
    {
        try {
            $Wallet = new MangoPay\Wallet();
            $info_wallet = $this->mangoPayApi->Wallets->Get($wallet_id);
            $UserId = $info_wallet->Owners[0];

            $BankAccount = new \MangoPay\BankAccount();
            $BankAccount->Type = "IBAN";
            $BankAccount->Details = new MangoPay\BankAccountDetailsIBAN();
            $BankAccount->Details->Country = $bank['code_country'];
            $BankAccount->Details->BIC = $bank['bic_swift'];
            $BankAccount->Details->IBAN = $bank['code_country'] . $bank['iban'];
            $BankAccount->OwnerName = $bank['titulaire_de_carte'];
            $BankAccount->OwnerAddress = array("AddressLine1" => $bank['adresse'], "AddressLine2" => "", "City" => $bank['ville_nom_simple'], "Region" => "", "PostalCode" => $bank['code_postal'], "Country" => $bank['code_country']);
            $result = $this->mangoPayApi->Users->CreateBankAccount($UserId, $BankAccount);

            return $result;
        } catch (\MangoPay\Libraries\ResponseException $e) {
            return false;
            /*    print '<div style="color: red;">'
                            .'\MangoPay\ResponseException: Code: '
                            . $e->getCode() . '<br/>Message: ' . $e->getMessage()
                            .'<br/><br/>Details: '; print_r($e->GetErrorDetails())
                    .'</div>';*/
        }


    }

    /*payement out*/
    public function payOut($wallet_id, $montant, $BankAccount)
    {
//Build the parameters for the request

        $PayOut = new \MangoPay\PayOut();
        $Wallet = new MangoPay\Wallet();
        $wallet_info = $this->mangoPayApi->Wallets->Get($wallet_id);
        $PayOut->AuthorId = $wallet_info->Owners[0];
        $PayOut->DebitedWalletID = $wallet_id;
        $PayOut->DebitedFunds = new \MangoPay\Money();
        $PayOut->DebitedFunds->Currency = "EUR";
        $PayOut->DebitedFunds->Amount = $montant * 100;
        $PayOut->Fees = new \MangoPay\Money();
        $PayOut->Fees->Currency = "EUR";
        $PayOut->Fees->Amount = 0;
        $PayOut->PaymentType = "BANK_WIRE";
        $PayOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
        $PayOut->MeanOfPaymentDetails->BankAccountId = $BankAccount;
        $PayOut->Tag = "payement out";
        //Send the request
        $result = $this->mangoPayApi->PayOuts->Create($PayOut);
        return $result;
    }
}
