<?php

/**
 * Class BusinessEntreprises
 */
class BusinessEntreprises extends ArrayObjectPlus
{

    private $_Entreprises, $_EntrepriseProfil;

    /**
     * BusinessTalents constructor.
     *
     * @param null $Talent
     */
    public function __construct($Entreprises = [])
    {
        parent::__construct();
        $this->_Entreprises = $Entreprises;

        if ($this->hasEntreprises()) {
            foreach ($this->getEntreprises() as $Entreprise) {
                $this->append(new BusinessEntreprise($Entreprise));
            }
        }
    }

    /**
     * @return array
     */
    private function getEntreprises()
    {
        return $this->_Entreprises;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->getEntreprises());
    }

    /**
     * @return bool
     */
    private function hasEntreprises()
    {
        return $this->count() > 0;
    }

    public function getEntrepriseProfilById($id)
    {
        if ($this->_EntrepriseProfil == null) {
            $Entreprise              = $this->getContext()->ModelEntreprise->getById($id);
            $this->_EntrepriseProfil = new BusinessEntreprise($Entreprise);
        }

        return $this->_EntrepriseProfil;
    }

}
