<?php

Class autoComplete_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

    }


    public function getEntrepriseListForCards($q)
    {
        $list_ent = $this->db->select('entreprise.id AS idEnt,entreprise.nom as nomEnt,entreprise.alias as aliasEnt, entreprise.background AS backgroundEnt, entreprise.logo as logoEnt, secteur_activite.nom as secteurEnt')
            ->from('entreprise')
            ->join('talent_experience', 'talent_experience.entreprise_id = entreprise.id')
            ->join('talent', 'talent.id = talent_experience.talent_id AND talent.status = ' . ModelTalent::VALID)
            ->join('secteur_activite', 'entreprise.secteur_id = secteur_activite.id')
            ->join('admin_employeur', 'entreprise.id = admin_employeur.id_entreprise')
            ->where('admin_employeur.statut', ModelEntrepriseAdmin::VALID_STATUT)
            ->like('entreprise.nom', $q, 'both')
            ->group_by('entreprise.id')
            ->order_by('entreprise.nom', 'ASC')
            ->limit('10')
            ->get();


        if ($list_ent->num_rows() > 0) {
            foreach ($list_ent->result() as $row) {
                if ($row->logoEnt == '' || $row->logoEnt == null) {
                    $row->logoEnt = "assets/img/entreprise.png";
                }

                if ($row->backgroundEnt == '' || $row->backgroundEnt == null) {
                    $row->backgroundEnt = "COVER_GENERIQUE_ENTREPRISE.jpg";
                }

                $row->nbrMentorEnt = $this->getContext()->ModelEntreprise->getTotalMentorByEntrepriseId($row->idEnt);
                $row->avatarsEnt   = $this->getMentorEntrepriseAvatarForCards($row->idEnt);
                $row->nbrOffreEnt  = $this->getContext()->ModelEntreprise->getNbrOffrePublicByEntrepriseId($row->idEnt);
            }
        }

        return $list_ent->result();
    }

    public function getEntrepriseListForCardsByIdEnt($id)
    {
        $list_ent = $this->db->select('entreprise.id AS idEnt,entreprise.nom as nomEnt,entreprise.alias as aliasEnt, entreprise.background AS backgroundEnt, entreprise.logo as logoEnt, secteur_activite.nom as secteurEnt')
            ->from('entreprise')
            ->join('talent_experience', 'talent_experience.entreprise_id = entreprise.id')
            ->join('talent', 'talent.id = talent_experience.talent_id AND talent.status = ' . ModelTalent::VALID)
            ->join('secteur_activite', 'entreprise.secteur_id = secteur_activite.id')
            ->join('admin_employeur', 'entreprise.id = admin_employeur.id_entreprise')
            ->where('admin_employeur.statut', ModelEntrepriseAdmin::VALID_STATUT)
            ->where('entreprise.id', $id)
            ->group_by('entreprise.id')
            ->order_by('entreprise.nom', 'ASC')
            ->limit('10')
            ->get();


        if ($list_ent->num_rows() > 0) {
            foreach ($list_ent->result() as $row) {
                if ($row->logoEnt == '' || $row->logoEnt == null) {
                    $row->logoEnt = "assets/img/entreprise.png";
                }

                if ($row->backgroundEnt == '' || $row->backgroundEnt == null) {
                    $row->backgroundEnt = "COVER_GENERIQUE_ENTREPRISE.jpg";
                }

                $row->nbrMentorEnt = $this->getContext()->ModelEntreprise->getTotalMentorByEntrepriseId($row->idEnt);
                $row->avatarsEnt   = $this->getMentorEntrepriseAvatarForCards($row->idEnt);
                $row->nbrOffreEnt  = $this->getContext()->ModelEntreprise->getNbrOffrePublicByEntrepriseId($row->idEnt);
            }
        }


        return empty($list_ent->row()) ? null : $list_ent->row();
    }


    private function getMentorEntrepriseAvatarForCards($id_ent)
    {
        $query = $this->db->select('avatar')
            ->from('user')
            ->join('talent', 'talent.user_id = user.id')
            ->join('talent_experience', 'talent_experience.talent_id = talent.id')
            ->where('talent_experience.entreprise_id', $id_ent)
            ->where('talent_experience.date_fin', '9999-12-31')
            ->where('talent.status', ModelTalent::VALID)
            ->limit('4')
            ->get();

        $arr = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $arr[] = $row->avatar;
            }

            return $arr;
        } else {
            return null;
        }

    }

} ?>