<?php

/**
 * Class BusinessOffre
 */
class BusinessOffre extends Business
{

    protected $_offre;

    /**
     * BusinessOffre constructor.
     *
     * @param null $Offre
     */
    public function __construct($Offre = null)
    {
        parent::__construct();
        $this->_offre = $Offre;
    }

    /**
     * @return StdClass
     */
    public function getOffre()
    {
        return $this->_offre;
    }

    /**
     * @return bool
     */
    public function hasOffre()
    {
        return $this->getOffre() instanceof stdClass && $this->getOffre()->id > 0;
    }

    public function getId()
    {
        return $this->hasOffre() ? (int)$this->getOffre()->id : -1;
    }

    public function getSecureId()
    {
        return $this->hasOffre() ? $this->getContext()->encrypt->encode($this->getId()) : -1;
    }

    public function getEntrepriseId()
    {
        return $this->hasOffre() ? (int)$this->getOffre()->entreprise_id : -1;
    }

    public function getTitre()
    {
        return $this->hasOffre() ? $this->getOffre()->titre_offre : '';
    }

    public function getLieu()
    {
        return $this->hasOffre() ? $this->getOffre()->lieu_offre : '';
    }

    public function getNiveau()
    {
        return $this->hasOffre() ? $this->getOffre()->niveau : '';
    }

    public function getTypeContrat()
    {
        return $this->hasOffre() ? $this->getOffre()->type_offre : '';
    }

    public function getDateCreation()
    {
        return $this->hasOffre() ? $this->getOffre()->creation_date : '';
    }

    public function getUpdateDate()
    {
        return $this->hasOffre() ? $this->getOffre()->update_date : '';
    }


    public function getSalaire()
    {
        return $this->hasOffre() ? $this->getOffre()->salaire_offre : '';
    }

    public function getDescriptif()
    {
        return $this->hasOffre() ? $this->getOffre()->descriptif_offre : '';
    }

    public function getProfilDiscriptif()
    {
        return $this->hasOffre() ? $this->getOffre()->profil_offre : '';
    }

    public function getDepartement()
    {
        return $this->hasOffre() ? (int)$this->getOffre()->departement_id : -1;
    }

    public function getUrl()
    {
        return $this->hasOffre() && $this->getOffre()->url_offre != null ? $this->getOffre()->url_offre : '';
    }

    public function getMentorAvatars()
    {
        if ($this->hasOffre()) {
            $mentors = $this->getBusinessMontorAffiliated();
            if (empty($mentors) || $mentors == null) {
                return null;
            } else {
                foreach ($mentors as $mentor) {
                    $avatars[] = $mentor->avatar;
                }

                return $avatars;
            }
        } else {
            return null;
        }

    }

    public function getJourFromDate($date)
    {
        if ($date == '') {
            return false;
        }

        // on recupere la date de aujourdhuit
        $aujourdhui = new DateTime("", new DateTimezone("Europe/Paris"));

        // on recupere la date de la creation
        $dateCreation = new DateTime($date, new DateTimezone("Europe/Paris"));


        // On obtient la différence ainsi,
        //diff fait le calcul et retourne le DateInterval donc on peut l'afficher avec format
        $nbJours = $aujourdhui->diff($dateCreation)->format('%d');

        //si la date de la creation date du jour meme on aura un resultat de 0 , alor on ajoute moin de un jour au lieu de 0
        if ($nbJours == 0) {
            return $nbJours = 'Aujourd\'hui';
        } elseif ($nbJours == 1) {
            return $nbJours = $nbJours . ' Jour';
        } else {
            return $nbJours = $nbJours . ' Jours ';
        }

    }

    /**
     * @return bool
     */
    public function DeleteOffre()
    {
        return $this->getContext()->ModelOffre->deleteOffreById($this->getId());
    }

    public function getIdMentorAffiliated()
    {
        return $this->getContext()->ModelOffre->getIdMentorAffiliatedById($this->getId());
    }

    /**
     * @return array
     */
    public function getBusinessMontorAffiliated()
    {
        return $this->getContext()->ModelOffre->getBusinessMontorAffiliatedById($this->getId(), $this->getEntrepriseId());
    }
}
