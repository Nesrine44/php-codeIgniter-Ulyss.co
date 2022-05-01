<?php

/**
 * Class ModelEntreprise_Sections
 */
Class ModelEntreprise_Sections extends CI_Model
{

    /**
     * ModelEntreprise_Sections constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->p_tablename = 'entreprise_sections';
    }

    public function getSectionByIdEntreprise($ident)
    {
        $this->db->select('*');
        $this->db->from('entreprise_sections');
        $this->db->where('id_entreprise', $ident);
        $query  = $this->db->get();
        $result = $query->result_object();
        if (empty($result)) {
            return null;
        } else {
            return $result;
        }
    }
}