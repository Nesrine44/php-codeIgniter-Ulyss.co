<?php

/**
 * Class BusinessTalentDemande
 * 'contractualisé','archivé','rejeté','pré-approuvé','en-attente','validé','undefined'
 */
class BusinessTalentDemande extends Business
{

    const STATUS_CONTRACTUALISER = 'contractualisé';
    const STATUS_ARCHIVER        = 'archivé';
    const STATUS_REJETER         = 'rejeté';
    const STATUS_PREAPPROUVER    = 'pré-approuvé';
    const STATUS_ENATTENTE       = 'en-attente';
    const STATUS_VALIDER         = 'validé';
    const STATUS_UNDEFINED       = 'undefined';

    private $_TalentDemande, $_BusinessUserInterlocutor, $_BusinessConversation, $_BusinessUser, $_BusinessTalent;

    public function __construct($TalentDemande = null)
    {
        parent::__construct();
        $this->_TalentDemande = $TalentDemande;
    }

    public function getTalentDemande()
    {
        return $this->_TalentDemande;
    }

    public function hasTalentDemande()
    {
        return $this->getTalentDemande() instanceof stdClass && $this->getTalentDemande()->id > 0;
    }

    public function getId()
    {
        return $this->hasTalentDemande() ? (int)$this->getTalentDemande()->id : -1;
    }

    public function getTalentId()
    {
        return $this->hasTalentDemande() ? (int)$this->getTalentDemande()->talent_id : -1;
    }

    public function getUserIdAcheteur()
    {
        return $this->hasTalentDemande() ? (int)$this->getTalentDemande()->user_id_acheteur : -1;
    }

    public function getDateRdv()
    {
        return $this->hasTalentDemande() ? $this->getTalentDemande()->date_livraison : '';
    }

    public function getLieuLivraison()
    {
        return $this->hasTalentDemande() ? $this->getTalentDemande()->lieu_livraison : '';
    }

    public function getDateCreation()
    {
        return $this->hasTalentDemande() ? $this->getTalentDemande()->date_creation : '';
    }

    public function getStatus()
    {
        return $this->hasTalentDemande() ? $this->getTalentDemande()->status : '';
    }

    public function getTitre()
    {
        return $this->hasTalentDemande() ? $this->getTalentDemande()->titre : '';
    }

    public function getEtat()
    {
        return $this->hasTalentDemande() ? $this->getTalentDemande()->etat : '';
    }

    public function gethoraireText()
    {
        return $this->hasTalentDemande() ? $this->getTalentDemande()->horaire : '';
    }

    public function getReservationJson()
    {
        return $this->hasTalentDemande() ? $this->getTalentDemande()->reservation_j : '';
    }

    public function getDuree()
    {
        return $this->hasTalentDemande() ? $this->getTalentDemande()->duree : '';
    }

    public function isValid()
    {
        return $this->hasTalentDemande() ? (bool)$this->getTalentDemande()->valider : false;
    }

    public function isAccepter()
    {
        return $this->hasTalentDemande() ? (bool)$this->getTalentDemande()->accepter : false;
    }

    /**
     * @return string
     */
    public function getDateRdvInText()
    {
        if ($this->getDateRdv() != '') {
            return ucfirst(strftime("%A %d %B %Y", strtotime($this->getDateRdv())));
        }

        return '';
    }

    /**
     * @return string
     */
    public function getDateHourRdvInText()
    {
        if ($this->getDateRdv() != '') {
            return ucfirst(strftime("%A %d %B %Y", strtotime($this->getDateRdv()))) . ' - ' . $this->gethoraireText();
        }

        return '';
    }

    /**
     * @return bool
     */
    public function BusinessUserIsTalent()
    {
        if ($this->getContext()->getBusinessUser() == null) {
            return false;
        }

        return $this->getContext()->getBusinessUser()->getBusinessTalent()->getId() == $this->getTalentId();
    }

    /**
     * @return bool
     */
    public function BusinessUserIsDemandeur()
    {
        if ($this->getContext()->getBusinessUser() == null) {
            return false;
        }

        return $this->getContext()->getBusinessUser()->getId() != $this->getTalentId();
    }

    /**
     * @return string
     */
    public function getStatusInText()
    {
        switch ($this->getStatus()) {
            case 'en-attente':
                return $this->BusinessUserIsTalent() ? 'Rendez-vous à confirmer' : 'Attente confirmation mentor';
                break;
            case 'validé':
                return 'Rendez-vous confirmé';
                break;
            case 'rejeté':
                return 'Rendez-vous annulé';
                break;
            default:
                return '';
        }
    }

    /**
     * @return string
     */
    public function getStatusClassCSS()
    {
        switch ($this->getStatus()) {
            case 'validé':
                return 'contractualiser';
                break;
            case 'rejeté':
                return 'rejeter';
                break;
            default:
                return 'aprouver';
        }
    }

    /**
     * @return int
     */
    public function getTimestampRDV($add2hours = true)
    {
        $dateRDV  = $this->getDateRdv();
        $endhour  = substr(strstr($this->gethoraireText(), '-'), 1, 2);
        $datehour = $dateRDV . ' ' . $endhour . ':00:00';
        $DateTime = new DateTime($datehour);
        if ($add2hours) {
            $DateTime->add(new DateInterval('PT02H'));
        }

        return $DateTime->getTimestamp();
    }

    public function estPassee()
    {
        $DateTime  = new DateTime();
        $TimeStamp = $DateTime->getTimestamp();

        return $this->getStatus() == self::STATUS_REJETER
            || ($this->getStatus() == self::STATUS_VALIDER && $this->getTimestampRDV(false) < $TimeStamp);
    }

    /**
     * @return BusinessUser
     */
    public function getBusinessUserInterlocutor()
    {
        if ($this->_BusinessUserInterlocutor == null) {
            if ($this->getUserIdAcheteur() == $this->getContext()->getBusinessUser()->getId()) {
                $Talent                          = $this->getContext()->ModelTalent->getById($this->getTalentId());
                $BusinessTalent                  = new BusinessTalent($Talent);
                $this->_BusinessUserInterlocutor = $BusinessTalent->getBusinessUser();
            } else {
                $User                            = $this->getContext()->ModelUser->getById($this->getUserIdAcheteur());
                $this->_BusinessUserInterlocutor = new BusinessUser($User);
            }
        }

        return $this->_BusinessUserInterlocutor;
    }

    /**
     * @return BusinessConversation
     */
    public function getBusinessConversation()
    {
        if ($this->_BusinessConversation == null) {
            $Conversation                = $this->getContext()->ModelConversation->getByTalentDemandeId($this->getId());
            $this->_BusinessConversation = new BusinessConversation($Conversation);
        }

        return $this->_BusinessConversation;
    }

    /**
     * @return BusinessUser
     */
    public function getBusinessUser()
    {
        if ($this->_BusinessUser == null) {
            $User                = $this->getContext()->ModelUser->getById($this->getUserIdAcheteur());
            $this->_BusinessUser = new BusinessUser($User);
        }

        return $this->_BusinessUser;
    }

    /**
     * @return BusinessTalent
     */
    public function getBusinessTalent()
    {
        if ($this->_BusinessTalent == null) {
            $Talent                = $this->getContext()->ModelTalent->getById($this->getTalentId());
            $this->_BusinessTalent = new BusinessTalent($Talent);
        }

        return $this->_BusinessTalent;
    }
}
