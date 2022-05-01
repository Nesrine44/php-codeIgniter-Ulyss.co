<?php

/**
 * Class ModelEntreprises
 */
Class ModelEntreprises extends CI_Model
{

    /**
     * ModelEntreprises constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $talent_id
     *
     * @return mixed
     */
    public function getByTalentId($talent_id)
    {
        if ($talent_id < 1) {
            return false;
        }

        $sql
            = ' SELECT entreprise.* FROM entreprise 
                        INNER JOIN talent_experience
                          ON talent_experience.entreprise_id = entreprise.id
                        WHERE talent_experience.talent_id = :talent_id
                      ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':talent_id', $talent_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function getAllEntreprisesByTagName($tag)
    {
        if ($tag == null) {
            return false;
        }

        $sql
            = ' SELECT id, nom FROM entreprise 
                        WHERE nom LIKE "' . $tag . '%"';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);

    }

    public function getEntrepriseIdByName($Name)
    {
        if ($Name == null) {
            return false;
        }

        $result = $this->db->select('id')
            ->from('entreprise')
            ->where('nom', $Name)
            ->get()
            ->row();

        if (isset($result->id)) {
            return $result->id;
        } else {
            return false;
        }

    }

    public function getEntrepriseSecteurIdById($id_ent)
    {
        if ($id_ent == null) {
            return false;
        }

        return $this->db->select('secteur_id')
            ->from('entreprise')
            ->where('id', $id_ent)
            ->get()
            ->row()
            ->secteur_id;

    }

    public function verifcationExistAliasEntreprise($string)
    {
        $select = '*';
        $where  = ["alias" => $string];

        return $this->db->select($select)
            ->from('entreprise')
            ->where($where)
            ->get()
            ->result();
    }

}
