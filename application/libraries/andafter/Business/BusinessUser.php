<?php

/**
 * Class BusinessUser
 */
class BusinessUser extends Business
{

    private $_User, $_UserLinkedin, $_Talent, $_ProfilTalent, $_Questionnaires;

    /**
     * BusinessUser constructor.
     *
     * @param ModelUser $User
     */
    public function __construct($User = null)
    {
        $this->_User = $User;
    }

    /**
     * @return ModelUser
     */
    public function getUser()
    {
        return $this->_User;
    }

    /**
     * @return bool
     */
    public function hasUser()
    {
        return $this->_User != null && $this->_User instanceof stdClass && $this->getUser()->id > 0 ? true : false;
    }

    public function getId()
    {
        return $this->hasUser() ? (int)$this->getUser()->id : -1;
    }

    public function getNom()
    {
        return $this->hasUser() ? $this->getUser()->nom : '';
    }

    public function getPrenom()
    {
        return $this->hasUser() ? $this->getUser()->prenom : '';
    }

    public function getEmail()
    {
        return $this->hasUser() ? $this->getUser()->email : '';
    }

    public function getPassword()
    {
        return $this->hasUser() ? $this->getUser()->password : '';
    }

    public function getDateNaissance()
    {
        return $this->hasUser() ? new DateTime($this->getUser()->date_naissance) : null;
    }

    public function getPrefixeTelephone()
    {
        return $this->hasUser() ? $this->getUser()->extension_tel : '';
    }

    public function getTelephone()
    {
        return $this->hasUser() ? $this->getUser()->tel : '';
    }

    public function getTelephoneWithoutSign()
    {
        return $this->getPrefixeTelephone() . $this->getTelephone();
    }

    public function getAdresse()
    {
        return $this->hasUser() ? $this->getUser()->adresse : '';
    }

    public function getFacebookId()
    {
        return $this->hasUser() ? $this->getUser()->facebook_id : '';
    }

    public function getGoogleId()
    {
        return $this->hasUser() ? $this->getUser()->google_id : '';
    }

    public function getDateCreation()
    {
        return $this->hasUser() ? new DateTime($this->getUser()->date_creation) : null;
    }

    public function getDateConnexion()
    {
        return $this->hasUser() ? new DateTime($this->getUser()->date_connexion) : null;
    }

    public function getCodeActivation()
    {
        return $this->hasUser() ? $this->getUser()->code_activation : '';
    }

    public function getAlias()
    {
        return $this->hasUser() ? $this->getUser()->alias : '';
    }

    public function getUid()
    {
        return $this->hasUser() ? $this->getUser()->uid : '';
    }

    public function getTypeReseauSocial()
    {
        return $this->hasUser() ? $this->getUser()->type_sociaux : '';
    }

    public function getCover()
    {
        return $this->hasUser() ? $this->getUser()->cover : '';
    }

    public function getPresentation()
    {
        return $this->hasUser() ? $this->getUser()->presentation : '';
    }

    public function getVilleId()
    {
        return $this->hasUser() ? (int)$this->getUser()->ville_id : -1;
    }

    public function getCodeReinitialiser()
    {
        return $this->hasUser() ? $this->getUser()->code_reinitialiser : '';
    }

    public function getWallet()
    {
        return $this->hasUser() ? (int)$this->getUser()->wallet : -1;
    }

    public function getBankAccount()
    {
        return $this->hasUser() ? (int)$this->getUser()->bank_account : -1;
    }

    public function getCodePhone()
    {
        return $this->hasUser() ? $this->getUser()->code_phone : '';
    }

    public function getNotifsMsgMembre()
    {
        return $this->hasUser() ? $this->getUser()->notifications_msg_membre : '';
    }

    public function getNotifsDemandeAccepteRefuse()
    {
        return $this->hasUser() ? $this->getUser()->notifications_demande_accepte_refuse : '';
    }

    public function getNotifsDemandePourTalent()
    {
        return $this->hasUser() ? $this->getUser()->notifications_demande_pour_talent : '';
    }

    public function getNotifsAlerte()
    {
        return $this->hasUser() ? $this->getUser()->notifcations_alertes : '';
    }

    public function getBiographie()
    {
        return $this->hasUser() ? $this->getUser()->biographie : '';
    }

    public function getPublicProfileUrl()
    {
        return $this->hasUser() ? $this->getUser()->public_profile_url : '';
    }

    public function getHash()
    {
        return $this->hasUser() ? $this->getUser()->hash : '';
    }

    public function getLastExperienceDepartement()
    {
        return $this->hasUser() ? $this->getUser()->stdClass : '';
    }

    public function isActive()
    {
        return $this->hasUser() ? (bool)$this->getUser()->active : false;
    }

    public function isSuperUser()
    {
        return $this->hasUser() ? (bool)$this->getUser()->super_user : false;
    }

    public function isVerifiedEmail()
    {
        return $this->hasUser() ? (bool)$this->getUser()->email_verified : false;
    }

    public function isVerifiedTelephone()
    {
        return $this->hasUser() ? (bool)$this->getUser()->tel_verified : false;
    }

    public function isClosed()
    {
        return $this->hasUser() ? (bool)$this->getUser()->fermer : false;
    }

    public function isStudent()
    {
        return $this->hasUser() ? (bool)$this->getUser()->student : false;
    }

    public function isOptinNews()
    {
        return $this->hasUser() ? (bool)$this->getUser()->optin_news : false;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        if ($this->hasUser()) {
            return $this->getUser()->avatar;
        } else {
            return '';
        }
    }

    /**
     * @return BusinessUserLinkedin
     */
    public function getBusinessUserLinkedin()
    {
        if ($this->_UserLinkedin == null) {
            $UserLinkedin        = $this->getContext()->ModelUserLinkedin->getByIdUser($this->getId());
            $this->_UserLinkedin = new BusinessUserLinkedin($UserLinkedin);
        }

        return $this->_UserLinkedin;
    }

    /**
     * @return bool|BusinessTalent
     */
    public function getBusinessTalent()
    {
        if ($this->_Talent === null) {
            $BusinessTalent = $this->getProfileTalent();
            if ($BusinessTalent->hasTalent() && $BusinessTalent->getStatus() == ModelTalent::VALID) {
                $this->_Talent = $BusinessTalent;
            } else {
                $this->_Talent = new BusinessTalent();
            }
        }

        return $this->_Talent;
    }

    /**
     * @return bool
     */
    public function isBusinessTalent()
    {
        return $this->getBusinessTalent()->getStatus() != false;
    }

    /**
     * @return BusinessTalent
     */
    public function getMentor()
    {
        return $this->getBusinessTalent();
    }

    /**
     * @return bool
     */
    public function isMentor()
    {
        return $this->isBusinessTalent();
    }

    /**
     * @return BusinessTalent
     */
    public function getProfileTalent()
    {
        if ($this->_ProfilTalent === null) {
            $Talent              = $this->getContext()->ModelTalent->getTalentByUserId($this->getId());
            $this->_ProfilTalent = new BusinessTalent($Talent);
        }

        return $this->_ProfilTalent;
    }

    /**
     * @return bool
     */
    public function isBasicProfil()
    {
        return $this->getProfileTalent() == false;
    }

    /**
     * @return bool
     */
    public function isFullProfile()
    {
        return $this->getProfileTalent() != false;
    }

    /**
     * @param $from
     * @param $to
     *
     * @return array
     */
    public function getRDVFromTwoDates($from, $to)
    {
        return $this->getContext()->ModelUser->getRDVFromTwoDates($this->getId(), $from, $to);
    }

    /**
     * @param $id_rdv
     *
     * @return mixed
     */
    public function getRDV($id_rdv)
    {
        return $this->getContext()->ModelUser->getRDV($id_rdv, $this->getId());
    }

    /**
     * @return mixed
     */
    public function countAllRDVValides()
    {
        return $this->getContext()->ModelUser->countAllRDVValides($this->getId());
    }

    /**
     * @return mixed
     */
    public function countAllRDVAnnules()
    {
        return $this->getContext()->ModelUser->countAllRDVAnnules($this->getId());
    }

    /**
     * @return mixed
     */
    public function countAllRDVEnAttente()
    {
        return $this->getContext()->ModelUser->countAllRDVEnAttente($this->getId());
    }

    /**
     * @param $id_rdv
     *
     * @return mixed
     */
    public function getCreditCardNfo()
    {
        return $this->getContext()->ModelUserPaymentProvider->getByUser_TypeCard($this->getId());
    }

    /**
     * @param $id_rdv
     *
     * @return mixed
     */
    public function hasCreditCardNfo()
    {
        return $this->getCreditCardNfo() != null;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getPrenom() . ' ' . $this->getNom();
    }

    /**
     * @return bool
     */
    public function acceptMailsConversations()
    {
        return $this->getNotifsMsgMembre() == 'email';
    }

    /**
     * @return bool
     */
    public function acceptMailsConfirmationRDVDemande()
    {
        return $this->getNotifsDemandeAccepteRefuse() == 'email' || $this->getNotifsDemandeAccepteRefuse() == 'sms_email';
    }

    /**
     * @return bool
     */
    public function acceptMailsReceptionNouvelDemandeDUnCandidat()
    {
        return $this->getNotifsDemandePourTalent() == 'email' || $this->getNotifsDemandePourTalent() == 'sms_email';
    }

    /**
     * @return bool
     */
    public function acceptSMSConversations()
    {
        return $this->getNotifsMsgMembre() == 'sms';
    }

    /**
     * @return bool
     */
    public function acceptSMSConfirmationRDVDemande()
    {
        return $this->getNotifsDemandeAccepteRefuse() == 'sms' || $this->getNotifsDemandeAccepteRefuse() == 'sms_email';
    }

    /**
     * @return bool
     */
    public function acceptSMSReceptionNouvelDemandeDUnCandidat()
    {
        return $this->getNotifsDemandePourTalent() == 'sms' || $this->getNotifsDemandePourTalent() == 'sms_email';
    }

    /**
     * @return array
     */
    public function getAllWaitingQuestionaires()
    {
        if ($this->_Questionnaires == null) {
            $this->_Questionnaires = $this->getContext()->ModelConversations->getAllForQuestionnaire($this->getId());
        } else {
            $this->_Questionnaires = null;
        }

        return $this->_Questionnaires;
    }

    /**
     * @return int
     */
    public function countAllWaitingQuestionaires()
    {
        return is_array($this->getAllWaitingQuestionaires()) ? count($this->getAllWaitingQuestionaires()) : 0;
    }

    /**
     * @return bool
     */
    public function checkIfQuestionnaireIsWaiting()
    {
        return $this->countAllWaitingQuestionaires() > 0;
    }

    /**
     * @return int
     */
    public function getTotalMessagesNonLus()
    {
        return $this->getContext()->ModelMessagerie->getAllNotReadByUser($this->getId());
    }
}
