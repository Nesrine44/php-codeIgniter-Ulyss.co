<?php
    Class Demande_model extends CI_Model
    {
    protected $table ='talent_demandes';

    public function __construct()
        {
            parent::__construct();

        }
 public function checkIfMyDemande($id,$user_id)
    {
      $select ='*';
      $where=array("id"=>$id,"user_id_acheteur"=>$user_id);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->where($where)
                ->get()
                ->row();
    } 
/*get facture*/
 public function getFacture($id,$user_id)
    {
      $select ='factures.montant as montant,talent.titre as titre,talent_demandes.id as demande_id';
      $where=array("factures.talent_demande_id"=>$id,"factures.user_id"=>$user_id);

      return $this->db->select($select)
                ->from('factures')
                ->join('talent_demandes','factures.talent_demande_id=talent_demandes.id')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->order_by('factures.date_creation','DESC')
                ->where($where)
                ->get()
                ->row();
    } 
  public function Add($add = array())
    {
      //  Vérification des données à insérer
      if(empty($add))
      {
        return false;
      }

                 $this->db->set($add)
                               ->insert($this->table);
                                return $this->db->insert_id();
    }

  public function addIndiponible($add = array())
    {
      //  Vérification des données à insérer
      if(empty($add))
      {
        return false;
      }

                 $this->db->set($add)
                               ->insert("users_indispoinibilite");
                                return $this->db->insert_id();
    }

public function editerDemande($id_user,$id, $data = array())
        {   
          if(empty($data))
          {
            return false;
          }
          return (bool) $this->db->set($data)
                                       ->where('id', $id)
                                       ->where('talent_id',$id_user)
                                       ->update("talent_demandes");
        }
public function editerDemande_candidat($id_user,$id, $data = array())
        {
          if(empty($data))
          {
            return false;
          }
          return (bool) $this->db->set($data)
                                       ->where('id', $id)
                                       ->where('user_id_acheteur',$id_user)
                                       ->update("talent_demandes");
        }
public function editerDemande1($id, $data = array())
        {   
          if(empty($data))
          {
            return false;
          }
          return (bool) $this->db->set($data)
                                       ->where('id', $id)
                                       ->update("talent_demandes");
        }


  public function AddOffre($add = array())
    {
      //  Vérification des données à insérer
      if(empty($add))
      {
        return false;
      }

                 $this->db->set($add)
                               ->insert("talent_demande_offre");
                                return $this->db->insert_id();
    }
 public function GetMesTransactions($id)
    {
      $select ='talent.user_id as user_t,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations,talent_demandes.user_id_acheteur as user_achteur,talent_demandes.date_livraison as date_livraison,talent_demandes.horaire as horaire';
      $where=array("talent.user_id"=>$id,"etat"=>false);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->order_by('talent_demandes.date_creation','DESC')
                ->where($where)
                ->get()
                ->result();
    }  
/*historique prestations*/
 public function GetMesHistoriquesPrestations($id)
    {
      $select ='*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations,talent_demandes.date_livraison as date_livraison,talent_demandes.horaire as horaire';
      $where=array("talent.user_id"=>$id,"etat"=>false);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->order_by('talent_demandes.date_creation','DESC')
                ->where($where)
                ->get()
                ->result();
    }  

/*by status*/
 public function GetMesHistoriqueTransactionBystatus($id,$status)
    {
      $select ='talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations,talent_demandes.user_id_acheteur as user_achteur,talent_demandes.date_livraison as date_livraison,talent_demandes.horaire as horaire';
      $where=array("talent.user_id"=>$id,"etat"=>true,"talent_demandes.status"=>$status);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->order_by('talent_demandes.date_creation','DESC')
                ->where($where)
                ->get()
                ->result();
    }  
 public function GetMesDemandes($id)
    {
      $select ='talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent_demandes.date_livraison as date_livraison,talent_demandes.horaire as horaire,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations,talent.user_id as user_t';
      $where=array("user_id_acheteur"=>$id,"etat"=>false);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->order_by('talent_demandes.date_creation','DESC')
                ->where($where)
                ->get()
                ->result();
    }  
   public function GetMesHistoriquedemandesBystatus($id,$status)
    {
      $select ='*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations,talent.user_id as user_t,talent_demandes.date_livraison as date_livraison,talent_demandes.horaire as horaire';
      $where=array("user_id_acheteur"=>$id,"etat"=>true,"talent_demandes.status"=>$status);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->order_by('talent_demandes.date_creation','DESC')
                ->where($where)
                ->get()
                ->result();
    } 
   public function GetMesHistoriquesPrestationsdemande($id)
    {
      $select ='*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations,talent_demandes.date_livraison as date_livraison,talent_demandes.horaire as horaire';
      $where=array("user_id_acheteur"=>$id,"etat"=>true);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->order_by('talent_demandes.date_creation','DESC')
                ->where($where)
                ->get()
                ->result();
    }
/*calendrier*/  
 public function GetMesMissionJour($id)
    {
      $day=date("Y-m-d");
      $select ='*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,talent_demandes.horaire as horaire,talent_demandes.date_livraison as date_livraison,talent_demandes.horaire as horaire';
      $where=array("talent.user_id"=>$id,"DATE(date_livraison)"=>$day);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('user','talent_demandes.user_id_acheteur=user.id')
                ->where($where)
                ->get()
                ->result();
    } 
//get derniere offre
 public function getDerniereOffre($id)
    {
      $select ='*';
      $where=array("talent_demande_offre.talent_demande_id"=>$id);
      return $this->db->select($select)
                ->from('talent_demande_offre')
/*               ->join('talent_demandes','talent_demandes.id=talent_demande_offre.talent_demande_id')*/
                ->where($where)
                ->order_by('date_creation','DESC')
                ->get()
                ->row();
    }  
 public function getDemandebYiD($id)
    {
      $select ='*';
      $where=array("id"=>$id);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->where($where)
                ->get()
                ->row();
    } 
/*get statistique dashbord*/
public function GetTotalTransactionsPercu($id)
    {
      $total=0;
      $select ='*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations';
      $where=array("talent.user_id"=>$id,"talent_demandes.status"=>"contractualisé","paye"=>true);
      $result=$this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->where($where)
                ->get()
                ->result();
    foreach ($result as $row) {
      if(!empty($this->getDerniereOffre($row->id))){
       $total=$total+$this->getDerniereOffre($row->id)->total;
      }
    }
    return $total;
    } 
public function GetTotalTransactionsPercevoir($id)
    {
      $total=0;
      $select ='*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations';
      $where=array("talent.user_id"=>$id,"talent_demandes.status"=>"contractualisé","paye"=>false);
      $result=$this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->where($where)
                ->get()
                ->result();
    foreach ($result as $row) {
      if(!empty($this->getDerniereOffre($row->id))){
       $total=$total+$this->getDerniereOffre($row->id)->total;
      }
    }
    return $total;
    } 
/*total constractualisation*/
public function GetTotalConstractualisationRealiser($id)
    {
      $total=0;
      $date=date('Y-m-d');
      $select ='*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations,talent_demandes.date_livraison as date_livraison,talent_demandes.horaire as horaire';
      $where=array("talent.user_id"=>$id,"talent_demandes.status"=>"contractualisé");
      $result=$this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->where($where)
                ->get()
                ->result();

        foreach ($result as $row) {
        if(!empty($this->getDerniereOffre($row->id))){
           if($date>$this->getDerniereOffre($row->id)->date){
            $total=$total+1;
           }
          }
         }
        return $total;
    } 
public function GetTotalConstractualisationAvenir($id)
    {
      $total=0;
      $date=date('Y-m-d');
      $select ='*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations,talent_demandes.date_livraison as date_livraison,talent_demandes.horaire as horaire';
      $where=array("talent.user_id"=>$id,"talent_demandes.status"=>"contractualisé");
      $result=$this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->where($where)
                ->get()
                ->result();
        foreach ($result as $row) {
        if(!empty($this->getDerniereOffre($row->id))){
           if($date<$this->getDerniereOffre($row->id)->date){
            $total=$total+1;
           }
          }
         }
        return $total;
    } 
/*get all demandes recues*/
public function GetTotalDemandesRecues($id)
    {
      $select ='*';
      $where=array("talent.user_id"=>$id);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->where($where)
                ->count_all_results();

    }     
public function GetTotalDemandesRepondues($id)
    {
      $select ='*';
      $where=array("talent.user_id"=>$id);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->where($where)
                ->where('conversations.id IN (SELECT `id_conversations` FROM `messagerie` where user_id_send='.$id.')', NULL, FALSE)
                ->count_all_results();

    }
public function GetTotalDemandesConclues($id)
    {
      $select ='*';
      $where=array("talent.user_id"=>$id,"talent_demandes.status"=>"contractualisé");
      return $this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->where($where)
                ->count_all_results();

    }
/*Total des services achetés*/
 public function GetMesTotalServicesAchetes($id)
    {
      $total=0;
      $select ='*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations';
      $where=array("user_id_acheteur"=>$id,"talent_demandes.status"=>"contractualisé","paye"=>true);
      $result=$this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->where($where)
                ->get()
                ->result();
    foreach ($result as $row) {
      if(!empty($this->getDerniereOffre($row->id))){
       $total=$total+$this->getDerniereOffre($row->id)->total;
      }
     }
    return $total;
    }  
 public function GetMesTotalServicesAchetesNonPaye($id)
    {
      $total=0;
      $select ='*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations';
      $where=array("user_id_acheteur"=>$id,"talent_demandes.status"=>"contractualisé","paye"=>false);
      $result=$this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->where($where)
                ->get()
                ->result();
    foreach ($result as $row) {
      if(!empty($this->getDerniereOffre($row->id))){
       $total=$total+$this->getDerniereOffre($row->id)->total;
      }
     }
    return $total;
    } 

/*recevoir ou a recevoir*/
public function GetTotalConstractualisationRecues($id)
    {
      $total=0;
      $date=date('Y-m-d');
      $select ='*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations';
      $where=array("user_id_acheteur"=>$id,"talent_demandes.status"=>"contractualisé");
      $result=$this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->where($where)
                ->get()
                ->result();

        foreach ($result as $row) {
        if(!empty($this->getDerniereOffre($row->id))){
           if($date>$this->getDerniereOffre($row->id)->date){
            $total=$total+1;
           }
          }
         }
        return $total;
    } 
public function GetTotalConstractualisationARecevoir($id)
    {
      $total=0;
      $date=date('Y-m-d');
      $select ='*,talent_demandes.titre as demande,talent_demandes.id as id,talent_demandes.status as statut,talent.titre as talent,talent_demandes.date_creation as date_creation,conversations.id as conversations';
      $where=array("user_id_acheteur"=>$id,"talent_demandes.status"=>"contractualisé");
      $result=$this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->where($where)
                ->get()
                ->result();
        foreach ($result as $row) {
        if(!empty($this->getDerniereOffre($row->id))){
           if($date<$this->getDerniereOffre($row->id)->date){
            $total=$total+1;
           }
          }
         }
        return $total;
    }


public function GetTotalTalentSollicites($id)
    {
      $select ='*';
      $where=array("user_id_acheteur"=>$id);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->where($where)
                ->count_all_results();

    }
public function GetTotalTalentsAchetes($id)
    {
      $select ='*';
      $where=array("user_id_acheteur"=>$id,"talent_demandes.status"=>"contractualisé");
      return $this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->where($where)
                ->count_all_results();

    }

public function GetTotalTalentsVisualise($id)
    {
      $select ='*';
      $where=array("user_id"=>$id);
      return $this->db->select($select)
                ->from('talent_vues')
                ->where($where)
                ->count_all_results();

    }
public function GetTotalVentes($id)
    {
      $select ='*';
      $where=array("user_id"=>$id);
      $list=$this->db->select($select)
                ->from('talent')
                ->where($where)
                ->get()->result();
    $list_vente=array();
    foreach ($list as $row) {
    $vente['name']=$row->titre;
    $vente['somme']=$this->getTotalVenteByidTalent($row->id);
    $list_vente[]=$vente;
    }
    return $list_vente;
    }
 public function getTotalVenteByidTalent($id)
    {
      $total=0;
      $select ='*';
      $where=array("talent_demandes.talent_id"=>$id,"talent_demandes.status"=>"contractualisé");
      $result=$this->db->select($select)
                ->from('talent_demandes')
                ->where($where)
                ->get()
                ->result();
    foreach ($result as $row) {
      if(!empty($this->getDerniereOffre($row->id))){
       $total=$total+$this->getDerniereOffre($row->id)->total;
      }
     }
    return $total;
    }
/*get total vente par mois*/
 public function getVenteByNumberMoisContractualiser($id,$mois)
    {
     $total=0;
      $year=date('Y');
      $select ='*';
      $where=array("talent.user_id"=>$id,"talent_demandes.status"=>"contractualisé","MONTH(talent_demandes.date_creation)"=>$mois,"YEAR(talent_demandes.date_creation)"=>$year);
      $result=$this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->where($where)
                ->get()
                ->result();

        foreach ($result as $row) {
        if(!empty($this->getDerniereOffre($row->id))){
            $total=$total+$this->getDerniereOffre($row->id)->total;
          }
         }
        return $total;
}
 public function getVenteByNumberMoisDemandes($id,$mois)
    {
     $total=0;
      $year=date('Y');
      $select ='*';
      $where=array("talent.user_id"=>$id,"MONTH(talent_demandes.date_creation)"=>$mois,"YEAR(talent_demandes.date_creation)"=>$year);
      $result=$this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->join('conversations','conversations.demandes_talent_id=talent_demandes.id')
                ->where($where)
                ->get()
                ->result();

        foreach ($result as $row) {
        if(!empty($this->getDerniereOffre($row->id))){
            $total=$total+$this->getDerniereOffre($row->id)->total;
          }
         }
        return $total;
}
/*calendrier*/
public function getElementBetweenTwoDate($id,$date1,$date2){
      $select ='*,talent.titre as talent,talent_demandes.id as talent_demandes_id,talent_demandes.status as status';
      $where=array("talent.user_id"=>$id,"DATE(date_livraison) >="=>$date1,"DATE(date_livraison) <="=>$date2);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->where($where)
                ->get()
                ->result();
 }
public function getTwoDate($id,$date1,$date2){
                 $select ='*';
                 $where=array("date>="=>$date1,"date<="=>$date2,"talent_demande_offre.talent_demande_id"=>$id);
                 return $this->db->select($select)
                          ->from('talent_demande_offre')
                          ->where($where)
                          ->order_by('date_creation','DESC')
                          ->get()
                          ->row(); 
}
public function getTwoDateHolidays($id,$date1,$date2){
                 $select ='*';
                 $where=array("date_debut>="=>$date1,"date_debut<="=>$date2,"user_id"=>$id);
                 return $this->db->select($select)
                          ->from('users_indispoinibilite')
                          ->where($where)
                          ->get()
                          ->result(); 
}
public function getHolidaysIndate($id,$date1){
                 $select ='*';
                 $where=array("date_debut"=>$date1,"user_id"=>$id);
                 return $this->db->select($select)
                          ->from('users_indispoinibilite')
                          ->where($where)
                          ->get()
                          ->row(); 
}
public function getAllHolidaysIndate($id){
                 $select ='*';
                 $where=array("date_debut>="=>date("Y-m-d"),"user_id"=>$id);
                 return $this->db->select($select)
                          ->from('users_indispoinibilite')
                          ->where($where)
                          ->get()
                          ->result(); 
}
 public function CheckPaiement($id)
    {
      $select ='*';
      $where=array("talent_demande_id"=>$id);
      return $this->db->select($select)
                ->from('paiement')
                ->where($where)
                ->get()
                ->row();
    }  
}
?>