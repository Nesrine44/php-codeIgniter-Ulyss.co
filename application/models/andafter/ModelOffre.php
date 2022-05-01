<?php

/**
 * Class ModelOffre
 */
Class ModelOffre extends CI_Model
{
    const PUBLIC_OFFRE     = 1;
    const NON_PUBLIC_OFFRE = 0;

    /**
     * ModelOffre constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->p_tablename = 'offre_emplois';
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getOffresByEntrepriseId($id)
    {
        if ($id == '') {
            return false;
        }

        $sql
            = ' SELECT offre_emplois.* FROM offre_emplois
                        WHERE entreprise_id = :entreprise_id ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':entreprise_id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $idOffre
     *
     * @return mixed
     */
    public function getOffreById($idOffre)
    {
        if ($idOffre == '') {
            return false;
        }

        $select = '*';
        $where  = ["id" => $idOffre];

        return $this->db->select($select)
            ->from('offre_emplois')
            ->where($where)
            ->get()
            ->row();
    }


    /**
     * @param $idOffre
     *
     * @return boolean
     */
    public function deleteOffreById($idOffre)
    {
        if ($idOffre == '') {
            return false;
        }

        $sql
            = ' DELETE FROM offre_emplois
                        WHERE id = :offre_id ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':offre_id', $idOffre);

        return $stmt->execute();
    }

    public function updateOffrePublicById($idOffre, $value)
    {
        if ($idOffre == '') {
            return false;
        }


        $sql
            = ' UPDATE offre_emplois SET public_offre = ' . $value . ' WHERE id = ' . $idOffre;

        $stmt = $this->db->conn_id->prepare($sql);

        return $stmt->execute();
    }


    public function saveMontorOffre($idOffre, $idMentor)
    {
        $data = [
            'offre_id '  => $idOffre,
            'id_mentor ' => $idMentor,
        ];

        return $this->db->insert('offre_mentors', $data);
    }


    /**
     * @param $idOffre
     *
     * @return mixed
     */
    public function getAllMentorOffre($idOffre)
    {
        if ($idOffre == '') {
            return false;
        }

        $sql
            = ' SELECT offre_mentors.* FROM offre_mentors
                        WHERE offre_id  = :offre_id ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':offre_id', $idOffre);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function deleteMentorOffre($idOffre, $idMentor)
    {
        if ($idOffre == null && $idMentor == null) {
            return false;
        }

        $this->db->delete('offre_mentors', ['offre_id' => $idOffre, 'id_mentor' => $idMentor]);

        // Produces:
        // DELETE FROM mytable
        // WHERE id = $id
    }


    /**
     * @param $idOffre
     *
     * @return array
     */
    public function getIdMentorAffiliatedById($idOffre)
    {
        if ($idOffre == '') {
            return false;
        }

        $sql
            = ' SELECT id_mentor FROM offre_mentors
                        WHERE offre_id  = :offre_id ';

        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':offre_id', $idOffre);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }


    /**
     * @param $idOffre
     *
     * @return array
     */
    public function
    getBusinessMontorAffiliatedById(
        $idOffre,
        $idEnt
    ){

        $this->db->select('offre_mentors.id,
                              offre_mentors.id_mentor,
                              offre_mentors.offre_id,
                              CONCAT("/",user.alias, "/", talent.alias, "/") AS url,
                              user.prenom,
                              user.nom,
                              user.avatar,
                              talent.user_id,
                              talent.description,                             
                              talent_experience.titre_mission,
                              talent_experience.lieu,
                              talent_experience.date_debut,
                              talent_experience.date_fin,
                              COUNT(talent_comment.id) AS recommandations,
                              entreprise.id AS id_entreprise,
                              entreprise.nom AS nom_entreprise,
                              entreprise.alias AS alias_entreprise,');
        $this->db->from('offre_mentors');
        $this->db->join('talent', 'talent.user_id = offre_mentors.id_mentor', 'LEFT');
        $this->db->join('user', 'user.id = offre_mentors.id_mentor', 'LEFT');
        $this->db->join('talent_experience', 'talent_experience.talent_id = talent.id', 'LEFT');
        $this->db->join('talent_comment', 'talent_comment.talent_id = talent.id AND talent_comment.note = 1', 'LEFT');
        $this->db->join('entreprise', 'entreprise.id = ' . $idEnt, 'LEFT');
        $this->db->where('talent.status', ModelTalent::VALID);
        $this->db->where('offre_mentors.offre_id', $idOffre);
        $this->db->group_by('offre_mentors.id_mentor');
        $retour = $this->db->get();
        $retour = $retour->result();

        return $retour != null ? $retour : [];
    }

    public function getEntrepriseIdByIdfOffre($offre_id)
    {
        $select = 'entreprise_id';

        return $this->db->select($select)
            ->from('offre_emplois')
            ->where("id", $offre_id)
            ->get()
            ->row()->entreprise_id;
    }

    public function saveCondidature($array_fields)
    {
        $this->p_tablename = 'offre_candidat';
        $result            = $this->save($array_fields);
        $this->p_tablename = 'offre_emplois';
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function isCondidatOffre($offre_id, $talent_id)
    {
        $select = '*';

        $result = $this->db->select($select)
            ->from('offre_candidat')
            ->where('offre_id', $offre_id)
            ->where('talent_id', $talent_id)
            ->get()
            ->result();
        if (isset($result) && !empty($result)) {
            return true;
        } else {
            return false;
        }
    }

}
