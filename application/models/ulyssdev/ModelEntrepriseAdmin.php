<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class ModelEntrepriseAdmin extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->p_tablename = 'admin_employeur';
    }

    const VALID_STATUT = 1;

    function checkStatut($id_pro)
    {
        $resutlt = $this->db->select('statut')
            ->from('admin_employeur')
            ->where('id', $id_pro)
            ->get()
            ->row()
            ->statut;

        return $resutlt;

    }

    function checkDuplicate($Email_pro)
    {
        $this->db->select('Email_pro');
        $this->db->from('admin_employeur');
        $this->db->like('Email_pro', $Email_pro);

        return $this->db->count_all_results();

    }

    function getByNom()
    {
        $this->db->select('nom');
        $this->db->from('entreprise');
        $query = $this->db->get();
        $data  = $query->result();

        return $data;
    }

    public function getAdminEntByMail($mail)
    {

        $this->db->select('*');
        $this->db->from('admin_employeur');
        $this->db->where('email_pro', $mail);
        $query = $this->db->get();
        $data  = $query->row();

        return $data;
    }


    public function update_profile($mail, $fields)
    {
        $this->db->where('email_pro', $mail);
        $this->db->update('admin_employeur', $fields);
    }





}
