<?php
    Class Wishlist_model extends CI_Model
    {
    protected $table ='wishlist';

    public function __construct()
        {
            parent::__construct();

        }
  public function getWishlistBysearch($data=array())
    {
                $select = '*';
                $this->db->select($select);
                $this->db->from($this->table);
               if(!empty($data['quoi'])){
                 $this->db->like('titre',$data['quoi']);
                 $this->db->or_like('description',$data['quoi']);
                }
                if(!empty($data['scat'])){
                $this->db->where_in('categorie_id',$data['scat']);
                }
               if(!empty($data['ville']) && $data['ville']!=0){
                $this->db->where("ville_id",$data['ville']);
                }
                $this->db->order_by('date_creation', 'desc');  
                return $this->db->get()->result();
    }
/*with limit and offset*/
  public function getWishlistBysearchWithOffset($data=array(),$limit, $start)
    {
                $select = '*';
                $this->db->select($select);
                $this->db->from($this->table);
               if(!empty($data['quoi'])){
                 $this->db->like('titre',$data['quoi']);
                 $this->db->or_like('description',$data['quoi']);
                }
                if(!empty($data['scat'])){
                $this->db->where_in('categorie_id',$data['scat']);
                }
               if(!empty($data['ville']) && $data['ville']!=0){
                $this->db->where("ville_id",$data['ville']);
                }
                $this->db->order_by('date_creation', 'desc');  
                $this->db->limit($limit, $start);
                return $this->db->get()->result();
    }

public function getNombreVote($id){
            $select = '*';
            $where = array('wishlist_id' => $id);
            return $this->db->select($select)
                      ->from("wishlist_vote")
                      ->where($where)
                      ->count_all_results();
}
public function checkVote($id,$user){
                $select = '*';
                $where = array('wishlist_id' => $id,"user_id"=>$user);
                return $this->db->select($select)
                          ->from("wishlist_vote")
                          ->where($where)
                          ->get()->row();
    }
  public function addVote($add = array())
    {
      //  Vérification des données à insérer
      if(empty($add))
      {
        return false;
      }

                 $this->db->set($add)
                               ->insert("wishlist_vote");
                                return $this->db->insert_id();
    }

  public function deleteVote($id,$id_user)
    {
    $this->db->delete('wishlist_vote', array('wishlist_id' => $id,"user_id"=>$id_user)); 
    return true;
    }
public function getWishById($id){
                $select = '*';
                $where = array('id' => $id);
                return $this->db->select($select)
                          ->from("wishlist")
                          ->where($where)
                          ->get()->row();
    }
  public function addWish($add = array())
    {
      //  Vérification des données à insérer
      if(empty($add))
      {
        return false;
      }

                 $this->db->set($add)
                               ->insert("wishlist");
                                return $this->db->insert_id();
    }
/*get top ten wishlist*/
public function getTopTen()
        {
              $this->db->select('w.id as id,w.titre as titre,w.description as description,COUNT(v.wishlist_id) AS nbr_vote');
              $this->db->from('wishlist w');
              $this->db->join('wishlist_vote v','v.wishlist_id = w.id');
              $this->db->group_by('w.id');
              $this->db->order_by("nbr_vote",'DESC');
              return $this->db->get()->result();  
             
        }

}
?>