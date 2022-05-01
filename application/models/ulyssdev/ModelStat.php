<?php

/**
 * Class ModelStat
 */
Class ModelStat extends CI_Model
{
    /**
     * ModelStat constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $id_ent
     *
     * @return mixed
     */
    public function NbrVisiteurEnt($IdEnt)
    {
        return $this->db->select('COUNT(id) as result')
            ->from('entreprise_vues')
            ->where('entreprise_id', $IdEnt)
            ->get()
            ->row()->result;

    }

    /**
     * @param $id_ent
     * @param $last_connection
     *
     * @return mixed
     */
    public function LastNbrVisiteurEnt($IdEnt, $LastConnection)
    {
        return $this->db->select('COUNT(id) as result')
            ->from('entreprise_vues')
            ->where('entreprise_id', $IdEnt)
            ->where('date_creation  <= ', $LastConnection)
            ->get()
            ->row()->result;
    }


    // return le resultat du nombre total des mentor de l'entreprise
    function getNbrMentorByEntrepriseId($IdEnt)
    {
        $query = $this->db->select('COUNT(DISTINCT(talent.id)) AS nbr_mentor')
            ->from('talent')
            ->join('talent_experience', 'talent_experience.talent_id = talent.id')
            ->where('talent_experience.entreprise_id', $IdEnt)
            ->where('talent_experience.date_fin', '9999-12-31')
            ->where('talent.status', ModelTalent::VALID)
            ->get();

        return $query->row()->nbr_mentor;
    }

    // return le Last resultat du nombre total des mentor de l'entreprise
    function getLastNbrMentorByEntrepriseId($IdEnt, $LastConnection)
    {
        $query = $this->db->select('COUNT(DISTINCT(talent.id)) AS last_nbr_mentor')
            ->from('talent')
            ->join('talent_experience', 'talent_experience.talent_id = talent.id')
            ->where('talent_experience.entreprise_id', $IdEnt)
            ->where('talent_experience.date_fin', '9999-12-31')
            ->where('talent.date_creation  <=', $LastConnection)
            ->where('talent.status', ModelTalent::VALID)
            ->get();

        return $query->row()->last_nbr_mentor;
    }

    public function getAncienNbrMentorByEntrepriseId($IdEnt)
    {

        $query = $this->db->select('COUNT(DISTINCT(talent.id)) AS nbr_mentor')
            ->from('talent')
            ->join('talent_experience', 'talent_experience.talent_id = talent.id')
            ->where('talent_experience.entreprise_id', $IdEnt)
            ->where('talent_experience.date_fin != ', '9999-12-31')
            ->where('talent.status', ModelTalent::VALID)
            ->get();

        return $query->row()->nbr_mentor;
    }

    public function getLastNbrAncienMentorByEntrepriseId($IdEnt, $LastConnection)
    {
        $query = $this->db->select('COUNT(DISTINCT(talent.id)) AS last_nbr_mentor')
            ->from('talent')
            ->join('talent_experience', 'talent_experience.talent_id = talent.id')
            ->where('talent_experience.entreprise_id', $IdEnt)
            ->where('talent_experience.date_fin != ', '9999-12-31')
            ->where('talent.date_creation  <=', $LastConnection)
            ->where('talent.status', ModelTalent::VALID)
            ->get();

        return $query->row()->last_nbr_mentor;
    }

    // return le resultat du nombre total des ambassador de l'entreprise
    public function getNbrAmbassadeurByEntrepriseId($IdEnt)
    {
        $query = $this->db->select('COUNT(id) AS nbr_ambassador')
            ->from('mentor_ambassadeur')
            ->where('id_entreprise', $IdEnt)
            ->get();

        return $query->row()->nbr_ambassador;

    }

    public function getLastNbrAmbassadeurByEntrepriseId($IdEnt, $LastConnection)
    {
        $query = $this->db->select('COUNT(id) AS last_nbr_ambassador')
            ->from('mentor_ambassadeur')
            ->where('id_entreprise', $IdEnt)
            ->where('date_creation  <=', $LastConnection)
            ->get();

        return $query->row()->last_nbr_ambassador;
    }


    // return le resultat du nombre total d'offres de l'entreprise
    function getTotalNbrOffreByEntrepriseId($IdEnt)
    {
        $query = $this->db->select('COUNT(id) AS nbr_offre')
            ->from('offre_emplois')
            ->where('entreprise_id', $IdEnt)
            ->get();

        return $query->row()->nbr_offre;
    }

    // return le resultat du nombre total d'offres de l'entreprise
    function getNbrOffrePublicByEntrepriseId($IdEnt)
    {
        $query = $this->db->select('COUNT(id) AS nbr_offre_public')
            ->from('offre_emplois')
            ->where('entreprise_id', $IdEnt)
            ->where('public_offre ', ModelOffre::PUBLIC_OFFRE)
            ->get();

        return $query->row()->nbr_offre_public;
    }

    // return le resultat du nombre total d'offres de l'entreprise
    function getNbrOffreNonPublicByEntrepriseId($IdEnt)
    {
        $query = $this->db->select('COUNT(id) AS nbr_offre_non_public')
            ->from('offre_emplois')
            ->where('entreprise_id', $IdEnt)
            ->where('public_offre ', ModelOffre::NON_PUBLIC_OFFRE)
            ->get();

        return $query->row()->nbr_offre_non_public;
    }

    // return le resultat du nombre total des rdv de l'entreprise
    function getNbrRdvByEntrepriseId($IdEnt)
    {

        $query = $this->db->select('COUNT(*) AS nbr_rdv')
            ->from('talent_demandes')
            ->join('talent', 'talent.id = talent_demandes.talent_id')
            ->join('talent_experience', 'talent_experience.talent_id = talent_demandes.talent_id')
            ->where('talent_experience.entreprise_id', $IdEnt)
            ->where('talent_experience.date_fin', '9999-12-31')
            ->where('talent.status', ModelTalent::VALID)
            ->where('talent_demandes.status', 'validé')
            ->where('talent_demandes.date_livraison < ', 'NOW()', false)
            ->get();

        return $query->row()->nbr_rdv;
    }

    // return le resultat du nombre total des rdv de l'entreprise
    function getLastNbrRdvByEntrepriseId($IdEnt, $LastConnection)
    {
        $query = $this->db->select('COUNT(*) AS last_nbr_rdv')
            ->from('talent_demandes')
            ->join('talent', 'talent.id = talent_demandes.talent_id')
            ->join('talent_experience', 'talent_experience.talent_id = talent_demandes.talent_id')
            ->where('talent_experience.entreprise_id', $IdEnt)
            ->where('talent_experience.date_fin', '9999-12-31')
            ->where('talent.status', ModelTalent::VALID)
            ->where('talent_demandes.status', 'validé')
            ->where('talent_demandes.date_livraison < ', 'NOW()', false)
            ->where('talent_demandes.date_livraison <= ', $LastConnection)
            ->get();

        return $query->row()->last_nbr_rdv;
    }

    // return le resultat du nombre total des rdv de l'entreprise pour les Ambassadeurs
    function getNbrRdvAmbassadeursByEntrepriseId($IdEnt)
    {

        $query = $this->db->select('COUNT(*) AS nbr_rdv_amb')
            ->from('talent_demandes')
            ->join('talent', 'talent.id = talent_demandes.talent_id')
            ->join('talent_experience', 'talent_experience.talent_id = talent_demandes.talent_id')
            ->join('mentor_ambassadeur', 'mentor_ambassadeur.talent_id = talent_demandes.talent_id')
            ->where('talent_experience.entreprise_id', $IdEnt)
            ->where('talent_experience.date_fin', '9999-12-31')
            ->where('talent.status', ModelTalent::VALID)
            ->where('talent_demandes.status', 'validé')
            ->where('talent_demandes.date_livraison < ', 'NOW()', false)
            ->get();

        return $query->row()->nbr_rdv_amb;
    }


}