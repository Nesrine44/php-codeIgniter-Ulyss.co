<?php

/**
 * Class BusinessUserLinkedin
 */
class BusinessUserLinkedin
{

    private $_UserLinkedinLinkedin;

    public function __construct($UserLinkedin = null)
    {
        $this->_UserLinkedin = $UserLinkedin;
    }

    public function getUserLinkedin()
    {
        return $this->_UserLinkedin;
    }

    public function hasUserLinkedin()
    {
        return $this->getUserLinkedin() instanceof stdClass && $this->getUserLinkedin()->id > 0;
    }

    public function getId()
    {
        return $this->hasUserLinkedin() ? (int)$this->getUserLinkedin()->id : -1;
    }

    public function getIdUser()
    {
        return $this->hasUserLinkedin() ? (int)$this->getUserLinkedin()->id_user : '';
    }

    public function getIdLinkedin()
    {
        return $this->hasUserLinkedin() ? $this->getUserLinkedin()->id_linkedin : '';
    }

    public function getFirstname()
    {
        return $this->hasUserLinkedin() ? $this->getUserLinkedin()->{'first-name'} : '';
    }

    public function getLastname()
    {
        return $this->hasUserLinkedin() ? $this->getUserLinkedin()->{'last-name'} : '';
    }

    public function getFormatedName()
    {
        return $this->hasUserLinkedin() ? $this->getUserLinkedin()->{'formatted-name'} : '';
    }

    public function getEmail()
    {
        return $this->hasUserLinkedin() ? $this->getUserLinkedin()->{'email-address'} : '';
    }


    public function getPictureUrl()
    {
        return $this->hasUserLinkedin() ? $this->getUserLinkedin()->{'picture-url'} : '#';
    }

    public function getLocationCountry()
    {
        return $this->hasUserLinkedin() ? $this->getUserLinkedin()->{'location-country'} : '';
    }


    //--------------------------------------------------------------//
    // pour tout se qui reste en dessous
    // a supprimer , a voir daboord tout les endrois la ou on l'utilise pour pas crée des erreur
    public function getIndustry()
    {
        return $this->hasUserLinkedin() ? $this->getUserLinkedin()->industry : '';
    }


    public function getActualjobTitle()
    {
        return $this->hasUserLinkedin() ? $this->getUserLinkedin()->{'actualjob-title'} : '';
    }

    public function getActualjobStartDate()
    {
        return $this->hasUserLinkedin() ? new DateTime($this->getUserLinkedin()->{'actualjob-startdate'}) : null;
    }

    public function getCompagnyName()
    {
        return $this->hasUserLinkedin() ? $this->getUserLinkedin()->{'company-name'} : '';
    }

    public function getCompagnyLocation()
    {
        return $this->hasUserLinkedin() ? $this->getUserLinkedin()->{'company-location'} : '';
    }

    public function getPublicProfileUrl()
    {
        return $this->hasUserLinkedin() ? $this->getUserLinkedin()->{'public-profile-url'} : '#';
    }


}
