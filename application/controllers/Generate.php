<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Generate extends CI_Controller
{

    function Generate()
    {
        parent::__construct();
        $this->load->model('Gestion_model','gestion');

        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('csv');
    }

        function create_csv(){

            $this->db->select('id,nom,prenom,email,tel,adresse');
            $quer = $this->db->get('user');
     
           query_to_csv($quer,TRUE,'User_with_annonce'.date('dMy').'.csv');
            
        }
}
