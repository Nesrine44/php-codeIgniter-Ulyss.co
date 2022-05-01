<?php
    Class Paiement_model extends CI_Model
    {
    protected $table ='paiement';

    public function __construct()
        {
            parent::__construct();

        }
public function editerDemande($id, $data = array())
        {   
          if(empty($data))
          {
            return false;
          }
          return (bool) $this->db->set($data)
                                       ->where('id', $id)
                                       ->update("talent_demandes");
        }
        
  public function addPaiement($add = array())
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
  public function Addfacture($add = array())
    {
      //  Vérification des données à insérer
      if(empty($add))
      {
        return false;
      }

                 $this->db->set($add)
                               ->insert("factures");
                                return $this->db->insert_id();
    }
  public function getListTransfere()
    {
      $where = array('transfer_montant!=' =>NULL);
      $select ='pay_in_date,pay_in_montant,paiement.id as id_p,talent_demandes.id as id_d,talent.user_id as talent_user,user_id_acheteur,talent.titre as titre,talent_demandes.status as status,talent_demandes.paye as paye';
      return $this->db->select($select)
                ->from('paiement')
                ->join('talent_demandes','paiement.talent_demande_id=talent_demandes.id')
                ->join('talent','talent.id=talent_demandes.talent_id')
                ->where($where)
                ->or_where('transfer_montant',"")
                ->get()
                ->result();
    }
     public function EditPaiement($id, $data = array())
        {   
          if(empty($data))
          {
            return false;
          }
          return (bool) $this->db->set($data)
                                       ->where('id', $id)
                                       ->update($this->table);
        }  
 }
    ?>