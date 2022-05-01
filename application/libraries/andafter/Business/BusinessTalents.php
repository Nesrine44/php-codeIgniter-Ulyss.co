<?php

/**
 * Class BusinessTalents
 */
class BusinessTalents extends ArrayObjectPlus{

    private $_Talents, $_BusinessTalents;

    /**
     * BusinessTalents constructor.
     * @param null $Talent
     */
    public function __construct( $Talents = array() ){
        parent::__construct();
        $this->_Talents     = $Talents;

        if( $this->hasTalents() ){
            foreach($this->getTalents() as $Talent) {
                $this->append(new BusinessTalent($Talent));
            }
        }
    }

    /**
     * @return array
     */
    private function getTalents(){
        return $this->_Talents;
    }

    /**
     * @return int
     */
    public function count(){
        return count($this->getTalents());
    }

    /**
     * @return bool
     */
    private function hasTalents(){
        return $this->count()>0;
    }

    /**
     * @param $id_entreprise
     * @return BusinessTalents
     */
    public function getAllByEntrepriseId( $id_entreprise ){
        return new BusinessTalents($this->getContext()->ModelTalents->getByEntrepriseId( $id_entreprise ));
    }

    /**
     * @param $id_secteur
     * @return BusinessTalents
     */
    public function getAllBySecteurId( $id_secteur ){
        return new BusinessTalents($this->getContext()->ModelTalents->getBySecteurId( $id_secteur ));
    }

}
