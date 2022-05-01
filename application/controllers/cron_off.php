<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron extends CI_Controller {

	function __construct(){
		parent::__construct();
        $this->load->model('user_model','user');
        $this->load->model('demande_model','demande');
        $this->load->model('paiement_model','pay');
        $this->load->library('mangopay_lib');
        $this->load->library('user_info');

	}


public function index()
{
}
 
public function transfere()
{
$list=$this->pay->getListTransfere();

foreach ($list as $item) {

  if(empty($this->user_info->getWalletUserById($item->user_id_acheteur))){
    /*get information utilisateur*/
    $utilisateur=$this->user->GetUserByid($item->user_id_acheteur);
    $data['nom']=$utilisateur->nom;
    $data['prenom']=$utilisateur->prenom;
    $data['date_naissance']=strtotime($utilisateur->date_naissance);
    $data['adresse']=$utilisateur->adresse;
    $data['email']=$utilisateur->email;
    $wallet_id=$this->mangopay_lib->create_user($data);
    $data_info['wallet']=$wallet_id;
    $this->user->EditUser($item->user_id_acheteur,$data_info);
  }
/*verification existe wallet to user talent*/ 
if(empty($this->user_info->getWalletUserById($item->talent_user))){
    /*get information utilisateur*/
    $utilisateur=$this->user->GetUserByid($item->talent_user);
    $data_talent['nom']=$utilisateur->nom;
    $data_talent['prenom']=$utilisateur->prenom;
    $data_talent['date_naissance']=strtotime($utilisateur->date_naissance);
    $data_talent['adresse']=$utilisateur->adresse;
    $data_talent['email']=$utilisateur->email;
    $wallet_id=$this->mangopay_lib->create_user($data_talent);
    $data_info_t['wallet']=$wallet_id;
    $this->user->EditUser($item->talent_user,$data_info_t);
  }

   $wallet_user_hunter=$this->user_info->getWalletUserById($item->user_id_acheteur);
   $wallet_user_wanted=$this->user_info->getWalletUserById($item->talent_user);
   $comission_h=($item->pay_in_montant*($this->user_info->getconfig(7)/100))*100;
   $comission_w=($item->pay_in_montant*($this->user_info->getconfig(8)/100))*100;
   $comission=$comission_h+$comission_w;
   $result=$this->mangopay_lib->transfereBetweenTowallet($wallet_user_hunter,$wallet_user_wanted,$item->pay_in_montant,$comission);

/*add element transfer*/
   $data_transfer['transfer_id']=$result->Id;
   $data_transfer['transfer_date']=date('Y-m-d  H:i:s');
   $data_transfer['transfer_montant']=$item->pay_in_montant-($comission/100);
   $this->pay->EditPaiement($item->id_p,$data_transfer);
   /*hunter facture*/
   $facture_hunter['talent_demande_id']=$item->id_d;
   $facture_hunter['montant']=$comission_h/100;
   $facture_hunter['user_id']=$item->user_id_acheteur;
   $this->pay->Addfacture($facture_hunter);
   /*wanted facture*/
       $facture_wanted['talent_demande_id']=$item->id_d;
       $facture_wanted['montant']=$comission_w/100;
       $facture_wanted['user_id']=$item->talent_user;
       $this->pay->Addfacture($facture_wanted);
           /*pay out to bank*/
           if(!empty($this->user_info->getBankAccountUserById($item->talent_user))){
             $result=$this->mangopay_lib->payOut($wallet_user_wanted,$data_transfer['transfer_montant'],$this->user_info->getBankAccountUserById($item->talent_user));
           /*edit paiement*/
           $pay_out['pay_out_id']=$result->Id;
           $pay_out['pay_out_date']=date('Y-m-d  H:i:s');
           $pay_out['pay_out_montant']=$data_transfer['transfer_montant'];
           $pay_out['comission_hunter_montant']=$facture_hunter['montant'];
           $pay_out['comission_wanted_montant']=$facture_wanted['montant'];
           $this->pay->EditPaiement($item->id_p,$pay_out);
           //update demande
           $data_demande['etat']=true;
           $data_demande['paye']=true;
           $this->demande->editerDemande($item->id_d,$data_demande);

   }

}
}
/*partie notifications*/
 

}