<?php

/**
 * Class BusinessStat
 */
class BusinessStat extends Business
{

    private $_Stat;

    /**
     * BusinessStat constructor.
     *
     * @param null $Stat
     */
    public function __construct($Stat = [])
    {
        parent::__construct();
        $this->_Stat = $Stat;
    }

    /**
     * @return null
     */
    public function getStat()
    {
        return $this->_Stat;
    }

    /**
     * @return null
     */
    public function hasStat()
    {
        return $this->getStat() instanceof stdClass && $this->getStat()->id_ent > 0 && isset($this->getStat()->last_connection);
    }

    /**
     * @return null
     */
    public function getLastConnection()
    {
        return $this->getStat() ? $this->getStat()->last_connection : null;
    }

    /**
     * @return null
     */
    public function getIdEnt()
    {
        return $this->getStat() ? $this->getStat()->id_ent : -1;
    }


    public function getNbrVuEnt()
    {
        if ($this->hasStat()) {
            $result = $this->getContext()->ModelStat->NbrVisiteurEnt($this->getIdEnt());
        }

        return isset($result) ? $result : 0;

    }

    public function getLastNbrVuEnt()
    {
        if ($this->hasStat()) {
            $result = $this->getContext()->ModelStat->LastNbrVisiteurEnt($this->getIdEnt(), $this->getLastConnection());
        }

        return isset($result) ? $result : 0;

    }

    public function getNbrMentorsEnt()
    {
        if ($this->hasStat()) {
            $result = $this->getContext()->ModelStat->getNbrMentorByEntrepriseId($this->getIdEnt());
        }

        return isset($result) ? $result : 0;
    }


    public function getLastNbrMentorsEnt()
    {
        if ($this->hasStat()) {
            $result = $this->getContext()->ModelStat->getLastNbrMentorByEntrepriseId($this->getIdEnt(), $this->getLastConnection());
        }

        return isset($result) ? $result : 0;
    }


    public function getAncienNbrMentorsEnt()
    {
        if ($this->hasStat()) {
            $result = $this->getContext()->ModelStat->getAncienNbrMentorByEntrepriseId($this->getIdEnt());
        }

        return isset($result) ? $result : 0;
    }


    public function getLastAncienNbrMentorsEnt()
    {
        if ($this->hasStat()) {
            $result = $this->getContext()->ModelStat->getLastNbrAncienMentorByEntrepriseId($this->getIdEnt(), $this->getLastConnection());
        }

        return isset($result) ? $result : 0;
    }

    public function getNbrAmbassadeurEnt()
    {
        if ($this->hasStat()) {
            $result = $this->getContext()->ModelStat->getNbrAmbassadeurByEntrepriseId($this->getIdEnt());
        }

        return isset($result) ? $result : 0;
    }

    public function getLastNbrAmbassadeurEnt()
    {
        if ($this->hasStat()) {
            $result = $this->getContext()->ModelStat->getLastNbrAmbassadeurByEntrepriseId($this->getIdEnt(), $this->getLastConnection());
        }

        return isset($result) ? $result : 0;
    }

    public function getNbrRdvEnt()
    {
        if ($this->hasStat()) {
            $nbrRdv = $this->getContext()->ModelStat->getNbrRdvByEntrepriseId($this->getIdEnt());
        }

        return isset($nbrRdv) ? $nbrRdv : 0;
    }

    public function getLastNbrRdvEnt()
    {
        if ($this->hasStat()) {
            $nbrRdv = $this->getContext()->ModelStat->getLastNbrRdvByEntrepriseId($this->getIdEnt(), $this->getLastConnection());
        }

        return isset($nbrRdv) ? $nbrRdv : 0;

    }

    public function getNbrRdvAmbassadeurEnt()
    {
        if ($this->hasStat()) {
            $result = $this->getContext()->ModelStat->getNbrRdvAmbassadeursByEntrepriseId($this->getIdEnt());
        }

        return isset($result) ? $result : 0;
    }

    public function getNbrOffrePublicEnt()
    {
        if ($this->hasStat()) {
            $result = $this->getContext()->ModelStat->getNbrOffrePublicByEntrepriseId($this->getIdEnt());
        }

        return isset($result) ? $result : 0;
    }

    public function getNbrOffreNonPublicEnt()
    {
        if ($this->hasStat()) {
            $result = $this->getContext()->ModelStat->getNbrOffreNonPublicByEntrepriseId($this->getIdEnt());
        }

        return isset($result) ? $result : 0;
    }

    public function getNbrOffreTotalEnt()
    {
        if ($this->hasStat()) {
            $result = $this->getContext()->ModelStat->getTotalNbrOffreByEntrepriseId($this->getIdEnt());
        }

        return isset($result) ? $result : 0;
    }


}

