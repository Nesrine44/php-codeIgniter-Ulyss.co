<?php

/**
 * Class BusinessVille
 */
class BusinessVille extends Business{

    private $_ville;

    public function __construct( $Ville = null ){
        parent::__construct();
        $this->_ville  = $Ville;
    }

    public function getVille(){
        return $this->_ville;
    }

    public function hasVille(){
        return $this->getVille() instanceof stdClass && $this->getVille()->id>0;
    }

    public function getId()                 { return $this->hasVille() ? (int)$this->getVille()->ville_id                               : -1; }
    public function getDepartement()        { return $this->hasVille() ? $this->getVille()->ville_departement                           : ''; }
    public function getSlug()               { return $this->hasVille() ? $this->getVille()->ville_slug                                  : ''; }
    public function getNom()                { return $this->hasVille() ? $this->getVille()->ville_nom                                   : ''; }
    public function getNomSimple()          { return $this->hasVille() ? $this->getVille()->ville_nom_simple                            : ''; }
    public function getNomReel()            { return $this->hasVille() ? $this->getVille()->ville_nom_reel                              : ''; }
    public function getNomSoundex()         { return $this->hasVille() ? $this->getVille()->ville_nom_soundex                           : ''; }
    public function getNomMetaphone()       { return $this->hasVille() ? $this->getVille()->ville_nom_metaphone                         : ''; }
    public function getCodePostal()         { return $this->hasVille() ? $this->getVille()->ville_code_postal                           : ''; }
    public function getCommune()            { return $this->hasVille() ? $this->getVille()->ville_commune                               : ''; }
    public function getCodeCommune()        { return $this->hasVille() ? $this->getVille()->ville_code_commune                          : ''; }
    public function getArrondissement()     { return $this->hasVille() ? $this->getVille()->ville_arrondissement                        : ''; }
    public function getAmdi()               { return $this->hasVille() ? (int)$this->getVille()->ville_amdi                             : -1; }
}

