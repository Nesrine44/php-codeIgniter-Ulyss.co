<?php

/**
 * Class ModelGeneral
 */
Class ModelGeneral extends CI_Model
{

    function getSecteurNameByIdBdd($id)
    {

        $sql  = 'SELECT nom  FROM secteur_activite WHERE id=' . $id;
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function getDepartementFrance()
    {
        $query = $this->db->get('departement_france');

        return $query->result();
    }

    public function getJourFromTwoDate($date1, $date2)
    {
        if ($date1 == '' && $date2 == '') {
            return false;
        }

        // on recupere la date d'aujourd'hui
        $aujourdhui = new DateTime("", new DateTimezone("Europe/Paris"));

        // on recupere la date de debut
        $dateDebut = new DateTime($date1, new DateTimezone("Europe/Paris"));

        if ($date2 == '9999-12-31') {
            $dateFin = $aujourdhui;
        } else {
            // on recupere la date de fin
            $dateFin = new DateTime($date2, new DateTimezone("Europe/Paris"));
        }

        // On obtient la différence ainsi,
        //diff fait le calcul et retourne le DateInterval donc on peut l'afficher avec format
        $nbMois   = $dateFin->diff($dateDebut)->format('%m');
        $nbAnnees = $dateFin->diff($dateDebut)->format('%y');

        //si la date de la creation date du jour meme on aura un resultat de 0 , alor on ajoute moin de un jour au lieu de 0
        if ($nbAnnees == 0 && $nbMois > 0) {
            return $nbMois . ' mois'; // quand il n'y a que des mois
        } elseif ($nbMois == 0 && $nbAnnees > 1) {
            return $nbAnnees . ' ans'; // quand il n'y a que des années et superieur a 1 ans
        } elseif ($nbAnnees == 1 && $nbMois == 0) {
            return $nbAnnees . ' an'; // quand il n'y a que un an
        } elseif ($nbAnnees == 1 && $nbMois > 0) {
            return $nbAnnees . ' an,' . $nbMois . ' mois'; // quand années == 1 et mois >0
        } elseif ($nbAnnees > 1 && $nbMois > 0) {
            return $nbAnnees . ' ans,' . $nbMois . ' mois'; // quand années > 1 et mois >0
        } elseif ($nbAnnees == 0 && $nbMois == 0) {
            return 'Nouveaux'; // quand c'est 0années et 0 mois alor c'est un nouveaux dans la boite
        } else {
            return null;
        }
    }

    function getDepartementNameByIdBdd($id)
    {
        if ($id == null) {
            return null;
        }
        $sql = $this->db->query('SELECT nom FROM `categorie_groupe` where id=' . $id);

        return $sql->row()->nom;

    }

    function getAllDepartementName()
    {
        $sql = $this->db->query(
            'SELECT categorie_groupe.id, nom 
                    FROM `talent_experience` 
                    INNER JOIN categorie_groupe 
                    ON talent_experience.departement_id = categorie_groupe.id 
                    WHERE date_fin=\'9999-12-31\' 
                    GROUP BY nom 
                    ORDER BY COUNT(nom) DESC'
        );


        return $sql->result_array();

    }


    function getSecteurOrderByChapeau()
    {
        $chap = $this->db->select('*')
            ->from('chapeaux')
            ->get()
            ->result_array();

        foreach ($chap as $row) {

            $secteur = $this->db->select('id,nom')
                ->from('secteur_activite')
                ->where('id_chapeau', $row['id'])
                ->order_by('nom', 'asc')
                ->get()
                ->result_array();

            foreach ($secteur as $sect) {
                $chapeaux[$row['nom_chapeau']][$sect['id']] = $sect['nom'];
            }
        }

        return $chapeaux;
    }

    function getChapeau()
    {
        return $this->db->select('*')
            ->from('chapeaux')
            ->get()
            ->result_array();
    }
}
