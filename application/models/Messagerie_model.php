<?php
    Class Messagerie_model extends CI_Model
    {
    protected $table ='messagerie';

    public function __construct()
        {
            parent::__construct();

        }
  public function AddConversation($add = array())
    {
      //  Vérification des données à insérer
      if(empty($add))
      {
        return false;
      }

                               $this->db->set($add)
                               ->insert("messagerie");
                               $data['last_message_id']=$this->db->insert_id();
                               $id_conver=$add["id_conversations"];
                               return (bool) $this->db->set($data)
                                       ->where("id",$id_conver)
                                       ->update("conversations");

    }
public function GetDemande($id)
    {
      $select ='*';
      $where=array("id"=>$id);
      return $this->db->select($select)
                ->from('talent_demandes')
                ->where($where)
                ->get()
                ->row();
    } 


public function GetLastOffre($id)
    {
      $select ='*';
      $where=array("talent_demande_id"=>$id);
      return $this->db->select($select)
                ->from('talent_demande_offre')
                ->where($where)
                ->order_by("date_creation","DESC")
                ->get()
                ->row();
    }  
     public function GetAllConversationsWithlimit($data=array(),$limit, $start)
    {
      $session=$this->session->userdata('logged_in_site_web');
      $this->load->library('encrypt');
      $id_user=$this->encrypt->decode($session['id']);
                    $this->load->library('convertdate');
                    $select = '*,conversations.id as id_conver,messagerie.date_creation as date_creation,messagerie.status as status';
                    $result= $this->db->select($select)
                                ->from("conversations")
                                ->join('messagerie', 'messagerie.id = conversations.last_message_id')
                                ->join('talent', 'talent.id = conversations.talent_id')
                                ->where('conversations.user_id',$id_user)
                                ->or_where('talent.user_id',$id_user)
                                ->order_by('messagerie.date_creation','DESC')
                                ->limit($limit, $start)
                                ->get()
                                ->result();
                        $row_set=array();
                        foreach ($result as $key){
                                         if($id_user==$key->user_id_send)
                                         {
                                          $new_row['name']=$this->GetUserNom($key->user_id_recep);
                                          $new_row['avatar']=$this->GetUserPicture($key->user_id_recep);
                                        }else{
                                          $new_row['name']=$this->GetUserNom($key->user_id_send);
                                          $new_row['avatar']=$this->GetUserPicture($key->user_id_send);
                                        }
                                        $new_row['avatar_sender']=$this->GetUserPicture($key->user_id_send);
                                          $new_row['date']=$this->convertdate->humanizeDateDiffference($key->date_creation);
                                         // $new_row['date']=$key->date_creation;
                                          $new_row['text']=$key->text;
                                         // $new_row['prix']=$key->prix;
                                          $new_row['prix']=$this->GetLastOffre($key->demandes_talent_id);
                                          $new_row['info_demande']=$this->GetDemande($key->demandes_talent_id);
                                          $new_row['id_conver']=$key->id_conver;
                                          $new_row['class']="";
                                          $new_row['class1']="";
                                         
                                         if($id_user==$key->user_id_recep && $key->status==0)
                                         {
                                          $new_row['status']=$key->status;
                                          $new_row['class']="non_lu";
                                          $new_row['class1']="non_lu_bleu";

                                         }else{
                                           $new_row['status']=1;
                                         }
                                          $row_set[] = $new_row; //build an array
                                        }
                                        return $row_set;
    }


     public function GetAllConversations()
    {
      $session=$this->session->userdata('logged_in_site_web');
      $this->load->library('encrypt');
      $id_user=$this->encrypt->decode($session['id']);
                    $this->load->library('convertdate');
                    $select = '*,conversations.id as id_conver';
                    $result= $this->db->select($select)
                                ->from("conversations")
                                ->join('messagerie', 'messagerie.id = conversations.last_message_id')
                                ->join('talent', 'talent.id = conversations.talent_id')
                                ->where('conversations.user_id',$id_user)
                                ->or_where('talent.user_id',$id_user)
                                ->order_by('messagerie.date_creation','DESC')
                                ->get()
                                ->result();
                        $row_set=array();
                        foreach ($result as $key){
                                         if($id_user==$key->user_id_send)
                                         {
                                          $new_row['name']=$this->GetUserNom($key->user_id_recep);
                                          $new_row['avatar']=$this->GetUserPicture($key->user_id_recep);
                                        }else{
                                          $new_row['name']=$this->GetUserNom($key->user_id_send);
                                          $new_row['avatar']=$this->GetUserPicture($key->user_id_send);
                                        }
                                        $new_row['avatar_sender']=$this->GetUserPicture($key->user_id_send);
                                          $new_row['date']=$this->convertdate->humanizeDateDiffference($key->date_creation);
                                         // $new_row['date']=$key->date_creation;
                                          $new_row['text']=$key->text;
                                          $new_row['prix']=$key->prix;
                                          $new_row['info_demande']=$this->GetDemande($key->demandes_talent_id);
                                          $new_row['id_conver']=$key->id_conver;
                                         if($id_user==$key->user_id_recep)
                                         {
                                          $new_row['status']=$key->status;
                                         }else{
                                           $new_row['status']=1;
                                         }
                                          $row_set[] = $new_row; //build an array
                                        }
                                        return $row_set;
    }
     public function GetConversationsOne()
    {
      $session=$this->session->userdata('logged_in_site_web');
      $this->load->library('encrypt');
      $id_user=$this->encrypt->decode($session['id']);
                  $this->load->library('somme_lib');
                    $select = '*,conversations.id as id_conver';
                    $result= $this->db->select($select)
                                ->from("conversations")
                                ->join('messagerie', 'messagerie.id = conversations.last_message_id')
                                ->where('user1',$id_user)
                                ->or_where('user2',$id_user)
                                ->order_by('date_creation','DESC')
                                ->limit(1)
                                ->get()
                                ->row();
                        $row_set=array();

                        if($result){
                                $this->EditStatusConversations($result->id_conversations,$id_user);
                                $select1 = '*';
                                $result1= $this->db->select($select1)
                                ->from("messagerie")
                                ->where('id_conversations',$result->id_conversations)
                                ->order_by('date_creation','ASC')
                                ->get()
                                ->result();

                        foreach ($result1 as $key){
                                         if($id_user==$key->user_id_send)
                                             {
                                              $new_row['id_to']=$key->user_id_recep;
                                              $new_row['name_conversation']=$this->GetUserNom($key->user_id_recep);
                                            }else{
                                              $new_row['id_to']=$key->user_id_send;
                                              $new_row['name_conversation']=$this->GetUserNom($key->user_id_send);
                                            }
                                          $new_row['name']=$this->GetUserNom($key->user_id_send);
                                          $new_row['avatar']=$this->GetUserPicture($key->user_id_send);
                                          $new_row['date']=$this->somme_lib->humanizeDateDiffference($key->date_creation);
                                          $new_row['text']=$key->text;
                                          $new_row['id_conver']=$key->id_conversations;
                                          $row_set[] = $new_row; //build an array
                                        }
                                        }
                                        return $row_set;
    }
    public function getConversation($id)
    {
                                $select1 = '*';
                                $result1= $this->db->select($select1)
                                ->from("messagerie")
                                ->where('id_conversations',$id)
                                ->order_by('date_creation','ASC')
                                ->get()
                                ->result();

                        foreach ($result1 as $key){
                                         if($id_user==$key->user_id_send)
                                             {
                                              $new_row['id_to']=$key->user_id_recep;
                                            }else{
                                              $new_row['id_to']=$key->user_id_send;
                                            }
                                          $new_row['name']=$this->GetUserNom($key->user_id_send);
                                          $new_row['avatar']=$this->GetUserPicture($key->user_id_send);
                                          $new_row['date']=$this->somme_lib->humanizeDateDiffference($key->date_creation);
                                          $new_row['text']=$key->text;
                                          $new_row['id_conver']=$key->id_conversations;
                                          $row_set[] = $new_row; //build an array
                                        }
                                        return $row_set;
    }
 public function checkItMyConversation($id)
    {
      $this->load->library('encrypt');
      $select = '*,conversations.id as id_conver,conversations.user_id as user1,talent.user_id as user2,talent.id as talent_id,messagerie.status as status';
      return $this->db->select($select)
                    ->from("conversations")
                    ->join('messagerie', 'messagerie.id = conversations.last_message_id')
                    ->join('talent', 'talent.id = conversations.talent_id')
                    ->where('conversations.id',$id)
                    ->order_by('messagerie.date_creation','DESC')
                    ->get()
                    ->row();
    }  
    public function GetConversationsOneById($id)
    {
      $session=$this->session->userdata('logged_in_site_web');
      $this->load->library('encrypt');
      $id_user=$this->encrypt->decode($session['id']);
                   $this->load->library('convertdate');
                                $this->EditStatusConversations($id,$id_user);
                                $select1 = '*';
                                $result1= $this->db->select($select1)
                                ->from("messagerie")
                                ->where('id_conversations',$id)
                                ->order_by('date_creation','DESC')
                                ->get()
                                ->result();
                        $row_set=array();
                        foreach ($result1 as $key){
                                            if($id_user==$key->user_id_send)
                                             {
                                              $new_row['class']="item_msg_chat_right";
                                              $new_row['id_to']=$key->user_id_recep;
                                              $new_row['name_conversation']=$this->GetUserNom($key->user_id_recep);
                                            }else{
                                              $new_row['class']="item_msg_chat_left";
                                              $new_row['id_to']=$key->user_id_send;
                                              $new_row['name_conversation']=$this->GetUserNom($key->user_id_send);
                                            }
                                          $new_row['name']=$this->GetUserNom($key->user_id_send);
                                          $new_row['avatar']=$this->GetUserPicture($key->user_id_send);
                                          $new_row['date']=$this->convertdate->humanizeDateDiffference($key->date_creation);
                                       //   $new_row['date']=$key->date_creation;
                                          $new_row['text']=$key->text;
                                          $new_row['id_conver']=$key->id_conversations;
                                          $row_set[] = $new_row; //build an array
                                        }
                          
                                        return $row_set;
    }
      public function GetUserNom($id)
		{
      		   $query = $this->db->query("select *  from user where id='".$id."'");

      		if ($query->num_rows() > 0)
      		{
      		   $row = $query->row();
      		   return   $row->nom.' '.$row->prenom;
      		}
      		else
      				{
      				Return false;
      				}


    }
    public function GetUserPicture($id)
    {
       $query = $this->db->query("select *  from user where id='".$id."'");

    if ($query->num_rows() > 0)
    {
       $row = $query->row();
       return   $row->avatar;
    }
    else
        {
        Return false;
        }


    }
    public function EditStatusConversations($id,$id_user)
        {   
          //  Vérification des données à mettre à jour
           $data = array("status"=>1);
          if(empty($data))
          {
            return false;
          }
          

          $where=array("id_conversations"=>$id,"user_id_recep"=>$id_user);
          return (bool) $this->db->set($data)
                                       ->where($where)
                                       ->update("messagerie");
        }
    public function existenceConversation($id_talent,$id_user,$id_demande){
           $result= $this->db->select("*")
                                ->from("conversations")
                                ->where("talent_id",$id_talent)
                                ->where("user_id",$id_user)
                                ->where("demandes_talent_id",$id_demande)
                                ->get()
                                ->row();
              if(!empty($result)){
               return $result->id;
              }else{
                $add['talent_id']=$id_talent;
                $add['user_id']=$id_user;
                $add['demandes_talent_id']=$id_demande;
                $this->db->set($add)
                ->insert("conversations");
                return $this->db->insert_id();
              }

    }
   
 }
    ?>