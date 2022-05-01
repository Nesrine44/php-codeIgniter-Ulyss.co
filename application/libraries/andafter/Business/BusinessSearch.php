<?php

/* @var array $mentors */
/* @var StdClass $mentor */
/* @var int $mentors_count */


/**
 * Class BusinessSearch
 */
class BusinessSearch extends Business
{
    private $_BusinessUser, $_entrepriseId, $_Entreprise;

    public function __construct($params = [])
    {
        parent::__construct();

        $this->_BusinessUser = $params['BusinessUser'];
        $this->_entrepriseId = $params['entrepriseId'];
        $this->_Entreprise   = $this->getContext()->ModelEntreprise->getById($this->_entrepriseId);
    }


    /**
     * @return BusinessUser
     */
    public function getBusinessUser()
    {
        return $this->_BusinessUser;
    }

    /**
     * @return int
     */
    public function getEntrepriseId()
    {
        return $this->_entrepriseId;
    }

    /**
     * @return StdClass
     */
    public function getEntreprise()
    {
        return $this->_Entreprise;
    }

    /**
     *
     */
    public function sendSearch()
    {
        if ($this->getBusinessUser()->isBasicProfil()) {
            $this->sendSearchBasicProfile();
        } else {
            if ($this->getBusinessUser()->isFullProfile()) {
                $this->sendSearchFullProfile();
            }
        }
    }

    /**
     * @return array
     */
    public function sendSearchBasicProfile()
    {
        $ModelSearch = new ModelSearch();
        if ($this->getEntreprise() == null) {
            return [];
        }

        return $ModelSearch->getSearchBasicProfile($this->getBusinessUser(), $this->getEntreprise());
    }


    /**
     * @return array
     */
    public function sendSearchByUserExpSecteur()
    {
        $ModelSearch = new ModelSearch();
        if ($this->getBusinessUser()->getProfileTalent()->getLastExperience()->secteur_id == null) {
            return [];
        }

        return $ModelSearch->getSearchSecteurProfil($this->getBusinessUser());
    }

    public function sendSearchFullProfile()
    {
        $ModelSearch = new ModelSearch();
        if ($this->getEntreprise() == null) {
            return [];
        }


        return $ModelSearch->getSearchFullProfile($this->getBusinessUser(), $this->getEntreprise());
    }

    public function getResultBasicProfile()
    {
        $Result = $this->sendSearchBasicProfile();
        $return = [];

        if (is_array($Result) && count($Result) > 0) {
            foreach ($Result as $mentor) {

                /* Si même entreprise */
                if ($mentor->id_entreprise == $this->getEntrepriseId()) {
                    /* Entreprise actuelle */
                    if ($mentor->date_fin == '9999-12-31' || $mentor->date_fin == '0000-00-00') {
                        $return[0][] = $mentor;
                    } else {
                        $return[10][] = $mentor;
                    }
                } /* Meme secteur d'activite pour l'entrprise selectionnée */
                else {
                    /* Job en cours */
                    if ($mentor->date_fin == '9999-12-31' || $mentor->date_fin == '0000-00-00') {
                        $return[20][] = $mentor;
                    } else {
                        $return[30][] = $mentor;
                    }
                }
            }
        }
        ksort($return);

        return $return;
    }

    public function getResultFullProfile()
    {
        $BusinessTalent = $this->getBusinessUser()->getProfileTalent();

        $LastExperience = $BusinessTalent->getLastExperience();

        if ($LastExperience == null) {
            return $this->getResultBasicProfile();
        }

        $Result = $this->sendSearchFullProfile();

        $return = [];

        if (is_array($Result) && count($Result) > 0) {
            foreach ($Result as $mentor) {

                /* Si même entreprise */
                if ($mentor->id_entreprise == $this->getEntrepriseId()) {
                    /* Si le job est en cours */
                    if ($mentor->date_fin == '9999-12-31' || $mentor->date_fin == '0000-00-00') {
                        /* Entreprise / même département / même fonction */
                        if ($mentor->id_departement == $LastExperience->departement_id) {
                            $return[0][] = $mentor;
                        } /* Entreprise / même département  */
                        else {
                            if ($mentor->id_departement == $LastExperience->departement_id) {
                                $return[10][] = $mentor;
                            } /* Entreprise / pas le même département */
                            else {
                                $return[20][] = $mentor;
                            }
                        }
                    } else {
                        /* Entreprise dans le passé / même département / même fonction */
                        if ($mentor->id_departement == $LastExperience->departement_id) {
                            $return[30][] = $mentor;
                        } /* Entreprise dans le passé / même département */
                        else {
                            if ($mentor->id_departement == $LastExperience->departement_id) {
                                $return[40][] = $mentor;
                            } /* Entreprise dans le passé / pas le même département */
                            else {
                                $return[50][] = $mentor;
                            }
                        }
                    }
                } /* Pas la même entreprise - On controle le même secteur d'activité */
                else {
                    if ($mentor->filter_secteur_id == $this->getEntreprise()->secteur_id) {
                        /* Secteur d'activité de l'entreprise renseignée / même département / même fonction  */
                        if ($mentor->id_departement == $LastExperience->departement_id) {
                            $return[60][] = $mentor;
                        } /* Entreprise dans le passé / même département */
                        else {
                            if ($mentor->id_departement == $LastExperience->departement_id) {
                                $return[70][] = $mentor;
                            } /* Entreprise dans le passé / pas le même département */
                            else {
                                $return[80][] = $mentor;
                            }
                        }
                    } /* Pas la même entreprise - On controle le même secteur d'activité */
                    else {
                        if ($mentor->filter_secteur_id == $LastExperience->secteur_id) {
                            /* Secteur d'activité de l'entreprise renseignée / même département / même fonction  */
                            if ($mentor->id_departement == $LastExperience->departement_id) {
                                $return[90][] = $mentor;
                            } /* Entreprise dans le passé / même département */
                            else {
                                if ($mentor->id_departement == $LastExperience->departement_id) {
                                    $return[100][] = $mentor;
                                } /* Entreprise dans le passé / pas le même département */
                                else {
                                    $return[110][] = $mentor;
                                }
                            }
                        } /* Aucune condition respectée */
                        else {
                            $return[120][] = $mentor;
                        }
                    }
                }
            }


        } elseif (count($this->sendSearchByUserExpSecteur()) > 0) {

            //recuperation de tout le montor du meme departement
            $Result = $this->sendSearchByUserExpSecteur();


            $departement = $this->getBusinessUser()->getProfileTalent()->getLastExperience()->departement_id;
            //Filtrage :
            foreach ($Result as $mentor) {
                //si il y a 0 mentor dans la recherche normal alor en affiche :

                $return[100][] = $mentor;
            }
        }
        ksort($return);

        return $return;
    }
}
