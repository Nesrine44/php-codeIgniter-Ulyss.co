<?php

/**
 * Class BusinessEntreprise
 */
class BusinessEntreprise extends Business
{

    private $_Entreprise, $_offre;

    /**
     * BusinessEntreprise constructor.
     *
     * @param null $Entreprise
     */
    public function __construct($Entreprise = null)
    {
        parent::__construct();
        $this->_Entreprise = $Entreprise;
    }

    /**
     * @return null
     */
    public function getEntreprise()
    {
        return $this->_Entreprise;
    }

    /**
     * @return bool
     */
    public function hasEntreprise()
    {
        return $this->getEntreprise() instanceof stdClass && $this->getEntreprise()->id > 0;
    }

    public function getId()
    {
        return $this->hasEntreprise() ? (int)$this->getEntreprise()->id : -1;
    }

    public function getDateCreation()
    {
        return $this->hasEntreprise() ? new DateTime($this->getEntreprise()->date_creation) : new DateTime();
    }

    public function getNom()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->nom : '';
    }

    public function getSecteurId()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->secteur_id : '';
    }

    public function hasLogo()
    {
        return $this->hasEntreprise() ? (bool)$this->getEntreprise()->logo : false;
    }

    public function getLogo()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->logo : '';
    }


    public function getNumberOfEmployee()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->effectif : '';
    }

    /**
     * @return bool
     */
    public function hasEmployees()
    {
        return $this->getNumberOfEmployee() > 0;
    }

    public function getSite()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->site : '';
    }

    public function getVille()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->ville : '';
    }

    public function getRegion()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->region : '';
    }

    public function getPays()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->pays : '';
    }

    public function hasAlias()
    {
        return $this->hasEntreprise() ? (bool)$this->hasEntreprise()->alias : false;
    }

    public function getAlias()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->alias : '';
    }

    public function getDescTitre()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->description_titre : '';
    }

    public function getDesc()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->description : '';
    }

    public function hasTwitterLink()
    {
        return $this->hasEntreprise() ? (bool)$this->getEntreprise()->twitter_link : false;
    }

    public function getTwitterLink()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->twitter_link : '';
    }

    public function hasFacebookLink()
    {
        return $this->hasEntreprise() ? (bool)$this->getEntreprise()->facebook_link : false;
    }

    public function getFacebookLink()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->facebook_link : '';
    }

    public function hasInstagramLink()
    {
        return $this->hasEntreprise() ? (bool)$this->getEntreprise()->instagram_link : false;
    }

    public function getInstagramLink()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->instagram_link : '';
    }

    public function getLinkedinLink()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->linkedin_link : '';
    }

    public function hasBackground()
    {
        return $this->hasEntreprise() ? (bool)$this->getEntreprise()->background : false;
    }


    public function getBackground()
    {
        return $this->hasEntreprise() ? $this->getEntreprise()->background : '';
    }

    public function getImages()
    {
        if ($this->hasEntreprise()) {
            $images = $this->getContext()->ModelMedia->getRows($this->getId());
        }

        return isset($images) ? $images : null;
    }

    public function getVideos()
    {
        if ($this->hasEntreprise()) {
            $videos = $this->getContext()->ModelMedia->getRowsVid($this->getId());
        }

        return isset($videos) ? $videos : null;
    }

    /**
     * @return mixed|entreprse_offres
     */
    public function getOffres()
    {
        if ($this->_offre == null && $this->hasEntreprise()) {
            $this->_offre = $this->getContext()->ModelOffre->getOffresByEntrepriseId($this->getId());
        }

        return $this->_offre;
    }

    public function getOffreDisponible()
    {
        if ($this->hasEntreprise()) {
            $OffreDisponible = $this->getContext()->ModelEntreprise->getOffresPublic($this->getId());
        }

        return isset($OffreDisponible) ? $OffreDisponible : null;
    }

    public function getNbrTotalOffre()
    {
        if ($this->hasEntreprise()) {
            $nbrOffre = $this->getContext()->ModelEntreprise->getTotalNbrOffreByEntrepriseId($this->getId());
        }

        return isset($nbrOffre) ? $nbrOffre : null;
    }

    public function getNbrOffrePublic()
    {
        if ($this->hasEntreprise()) {
            $nbrOffre = $this->getContext()->ModelEntreprise->getNbrOffrePublicByEntrepriseId($this->getId());
        }

        return isset($nbrOffre) ? $nbrOffre : null;
    }

    public function getNbrOffreNonPublic()
    {
        if ($this->hasEntreprise()) {
            $nbrOffre = $this->getContext()->ModelEntreprise->getNbrOffreNonPublicByEntrepriseId($this->getId());
        }

        return isset($nbrOffre) ? $nbrOffre : null;
    }

    public function getAllOffre()
    {
        if ($this->hasEntreprise()) {
            $AllOffre = $this->getContext()->ModelEntreprise->getOffres($this->getId());
        }

        return isset($AllOffre) ? $AllOffre : null;
    }

    public function getAllSections()
    {
        if ($this->hasEntreprise()) {
            $AllSection = $this->getContext()->ModelEntreprise_Sections->getSectionByIdEntreprise($this->getId());
        }

        return isset($AllSection) ? $AllSection : null;
    }

    public function getMentorProfil()
    {
        if ($this->hasEntreprise()) {
            $MentorProfil = $this->getContext()->ModelEntreprise->getAllProfilMentorById($this->getId());

        }

        return isset($MentorProfil) ? $MentorProfil : null;
    }

    public function getNbrMentor()
    {
        if ($this->hasEntreprise()) {
            $nbrMentor = $this->getContext()->ModelEntreprise->getTotalMentorByEntrepriseId($this->getId());
        }

        return isset($nbrMentor) ? $nbrMentor : null;
    }


    public function getMentorProfilWithoutAmbassador()
    {
        if ($this->hasEntreprise()) {
            $MentorProfilWithoutAmbassador = $this->getContext()->ModelEntreprise->getProfilMentorWithoutAmbassadeurById($this->getId());
        }

        return isset($MentorProfilWithoutAmbassador) ? $MentorProfilWithoutAmbassador : null;
    }

    public function getNbrAmbassador()
    {
        if ($this->hasEntreprise()) {
            $nbrAmbassador = $this->getContext()->ModelEntreprise->getTotalAmbassadorByEntrepriseId($this->getId());
        }

        return isset($nbrAmbassador) ? $nbrAmbassador : null;
    }


    public function getAllAmbassadorProfil()
    {
        if ($this->hasEntreprise()) {
            $AllAmbassadorProfil = $this->getContext()->ModelEntreprise->getProfilAmabassadeursById($this->getId());
        }

        return isset($AllAmbassadorProfil) ? $AllAmbassadorProfil : null;
    }

    public function getNbrRdv()
    {
        if ($this->hasEntreprise()) {
            $nbrRdv = $this->getContext()->ModelEntreprise->getTotalRdvByEntrepriseId($this->getId());
        }

        return isset($nbrRdv) ? $nbrRdv : null;
    }

    public function getUrlOnUlyss()
    {
        if ($this->hasEntreprise()) {
            $url = base_url() . 'entreprise/' . $this->getAlias();
        }

        return isset($url) ? $url : null;
    }

    /**
     * @return boolean
     */
    public function isClient()
    {
        if ($this->hasEntreprise()) {
            return $this->getContext()->ModelEntreprise->verifIfEntIsClient($this->getId());
        } else {
            return false;
        }
    }

}

