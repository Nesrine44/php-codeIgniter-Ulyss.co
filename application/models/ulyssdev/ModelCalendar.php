<?php

/**
 * Class ModelCalendar
 */
class ModelCalendar extends CI_Model
{
    public function get_events($id_ent)
    {
        return $this->db->select(
            'talent_demandes.talent_id as talent_id,
                     user.nom as nom,
                     user.prenom as prenom,
                     user.avatar as avatar,
                     categorie_groupe.nom as dep_nom,
                     talent_demandes.status as status_demande,
                     talent_demandes.horaire as heure,
                     talent_demandes.date_livraison as date_rdv'
        )
            ->from("talent_demandes")
            ->join("talent", "talent_demandes.talent_id = talent.id")
            ->join('talent_experience', 'talent_experience.talent_id = talent_demandes.talent_id')
            ->join('user', 'talent.user_id = user.id')
            ->join('categorie_groupe', 'categorie_groupe.id = talent_experience.departement_id')
            ->where("talent_experience.entreprise_id", $id_ent)
            ->where("talent.status", ModelTalent::VALID)
            ->get()
            ->result();
    }

    public function add_event($data)
    {
        $this->db->insert("calendar_events", $data);
    }

    public function get_event($id)
    {
        return $this->db->where("ID", $id)->get("calendar_events");
    }

    public function update_event($id, $data)
    {
        $this->db->where("ID", $id)->update("calendar_events", $data);
    }

    public function delete_event($id)
    {
        $this->db->where("ID", $id)->delete("calendar_events");
    }
}
