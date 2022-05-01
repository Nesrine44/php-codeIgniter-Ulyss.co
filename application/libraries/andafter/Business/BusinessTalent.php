<?php

/**
 * Class BusinessTalent
 */
class BusinessTalent extends Business
{

    private $_Talent, $_User, $_Entreprises, $_Entreprise, $_Testimoniaux, $_ville, $_Experiences, $_LastExperience, $p_messageReceived, $p_messageSend, $p_countrecos, $p_Formations, $_Questionnaires;

    public function __construct($Talent = null)
    {
        parent::__construct();
        $this->_Talent = $Talent;
    }

    public function getTalent()
    {
        return $this->_Talent;
    }

    public function hasTalent()
    {
        return $this->getTalent() instanceof stdClass && $this->getTalent()->id > 0;
    }

    public function getId()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->id : -1;
    }

    public function getUserId()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->user_id : -1;
    }

    public function getEntrepriseId()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->entreprise_id : -1;
    }

    public function getTitre()
    {
        return $this->hasTalent() ? $this->getTalent()->titre : '';
    }

    public function getAlias()
    {
        return $this->hasTalent() ? $this->getTalent()->alias : '';
    }

    public function getNiveauFormation()
    {
        return $this->hasTalent() ? $this->getTalent()->niveau_formation : null;
    }

    public function getDepartementId()
    {
        return $this->hasTalent() ? $this->getTalent()->departement_id : null;
    }

    public function getPrixJournee()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->prix_journee : 0;
    }

    public function getPrix()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->prix : 0;
    }

    public function getPrixForfait()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->prix_forfait : 0;
    }

    public function getDescriptionForfait()
    {
        return $this->hasTalent() ? $this->getTalent()->description_forfait : '';
    }

    public function getDescription()
    {
        return $this->hasTalent() ? strip_tags($this->getTalent()->description) : '';
    }

    public function getCover()
    {
        return $this->hasTalent() ? $this->getTalent()->cover : '';
    }

    public function getProfession()
    {
        return $this->hasTalent() ? $this->getTalent()->profession : '';
    }

    public function getHoraire()
    {
        return $this->hasTalent() ? $this->getTalent()->horaire : '';
    }

    public function getHoraireStart()
    {
        return $this->hasTalent() ? $this->getTalent()->horaire_de : '00:00';
    }

    public function getHoraireEnd()
    {
        return $this->hasTalent() ? $this->getTalent()->horaire_a : '23:59';
    }

    public function getCoverture()
    {
        return $this->hasTalent() ? $this->getTalent()->coverture : '';
    }

    public function getDateCreation()
    {
        return $this->hasTalent() ? new DateTime($this->getTalent()->date_creation) : new DateTime();
    }

    public function getStatus()
    {
        return $this->hasTalent() ? $this->getTalent()->status : '';
    }

    public function getCentreInterets()
    {
        return $this->hasTalent() ? $this->getTalent()->centre_interet : '';
    }

    public function getLieu()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->Lieu : null;
    }

    public function getville()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->ville : null;
    }

    public function getDepartementGeographique()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->departement_geo : null;
    }

    public function getRegion()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->Region : null;
    }

    public function getPays()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->Pays : null;
    }

    public function getCodePostal()
    {
        return $this->hasTalent() ? $this->getTalent()->cp : '';
    }

    public function getReduction()
    {
        return $this->hasTalent() ? (float)$this->getTalent()->reduction : 0.00;
    }

    public function getReductionHeure()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->reduction_heure : 0;
    }

    public function getReductionPersonne()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->reduction_personne : 0;
    }

    public function getCoutDesCours()
    {
        return $this->hasTalent() ? (int)$this->getTalent()->coup_des_cour : 0;
    }

    public function getPhotoCoutDesCours()
    {
        return $this->hasTalent() ? $this->getTalent()->photo_coup_de_coeur : '';
    }

    public function getStatutAdmin()
    {
        return $this->hasTalent() ? $this->getTalent()->statut_admin : '';
    }

    public function getBout()
    {
        return $this->hasTalent() ? $this->getTalent()->bout : '';
    }

    public function getPublicProfil()
    {
        return $this->hasTalent() ? $this->getTalent()->public_profil : '';
    }

    public function getFormatRendezVous()
    {
        return $this->hasTalent() ? $this->getTalent()->format_rendez_vous : '';
    }

    public function isEtanche()
    {
        return $this->hasTalent() ? (bool)$this->getTalent()->etanche : false;
    }

    public function isValid()
    {
        return $this->hasTalent() ? (bool)$this->getTalent()->valide : false;
    }

    public function isPro()
    {
        return $this->hasTalent() ? (bool)$this->getTalent()->pro : false;
    }

    /**
     * @return string
     */
    public function getUrlProfile()
    {
        return $this->getBusinessUser()->getAlias() . '/' . $this->getAlias() . '/apropos';
    }

    /**
     * @return BusinessUser
     */
    public function getBusinessUser()
    {
        if ($this->_User == null) {
            $User        = $this->getContext()->ModelUser->getById($this->getUserId());
            $this->_User = new BusinessUser($User);
        }

        return $this->_User;
    }

    /**
     * @return BusinessEntreprises
     */
    public function getBusinessEntreprises()
    {
        if ($this->_Entreprises == null && $this->hasTalent()) {
            $Entreprises        = $this->getContext()->ModelEntreprises->getByTalentId($this->getId());
            $this->_Entreprises = new BusinessEntreprises($Entreprises);
        }

        return $this->_Entreprises;
    }

    /**
     * @return BusinessEntreprise
     */
    public function getBusinessEntreprise()
    {
        if ($this->_Entreprise == null && $this->hasTalent()) {
            $EntrepriseId = -1;
            if ($this->hasTalent() && property_exists($this->getTalent(), 'entreprise_id')) {
                $EntrepriseId = $this->getTalent()->entreprise_id;
            }
            $Entreprise        = $this->getContext()->ModelEntreprise->getById($EntrepriseId);
            $this->_Entreprise = new BusinessEntreprise($Entreprise);
        }

        return $this->_Entreprise;
    }


    /**
     * @return BusinessEntreprise
     */
    public function getFonctionName()
    {
        if ($this->_fonction == null && $this->hasTalent()) {
            $fonctionId = -1;
            if ($this->hasTalent() && property_exists($this->getTalent(), 'fonction_id')) {
                $fonctionId = $this->getTalent()->fonction_id;
            }
            $this->_fonction = $this->getContext()->ModelCategorie_Fonction->getById($fonctionId);
        }

        return $this->_fonction->nom;
    }

    /**
     * @return array
     */
    public function getTestimoniaux()
    {
        if ($this->_Testimoniaux == null && $this->hasTalent()) {
            $this->_Testimoniaux = $this->getContext()->ModelTalent->getTalentTestimoniauxById($this->getId());
            if ($this->_Testimoniaux == false) {
                $this->_Testimoniaux = [];
            }
        }

        return $this->_Testimoniaux;
    }

    /**
     * @return array
     */
    public function getNote()
    {
        if (count($this->getTestimoniaux()) < 1) {
            return 0;
        }

        $note           = 0;
        $nbTestimoniaux = count($this->getTestimoniaux());
        foreach ($this->getTestimoniaux() as $Testimonial) {
            $note += $Testimonial->note;
        }

        return floor($note / $nbTestimoniaux);
    }

    public function getUrl()
    {
        return $this->hasTalent() ? '/' . $this->getBusinessUser()->getAlias() . '/' . $this->getAlias() . '/' : '#';
    }

    /**
     * @return mixed|talent_experience
     */
    public function getExperiences()
    {
        if ($this->_Experiences == null && $this->hasTalent()) {
            $this->_Experiences = $this->getContext()->ModelTalent->getExperiencesByIdTalent($this->getId());
        }

        return $this->_Experiences;
    }

    /**
     * @return mixed
     */
    public function getLastExperience()
    {
        if ($this->_LastExperience == null && $this->hasTalent()) {
            $this->_LastExperience = $this->getContext()->ModelTalent->getLastExperienceByIdTalent($this->getId());
        }

        return $this->_LastExperience;
    }

    /**
     * @return mixed
     */
    public function hasLastExperience()
    {
        return $this->getLastExperience() != null;
    }

    /**
     * @return mixed
     */
    public function getMessagesReceived()
    {
        if ($this->p_messageReceived === null && $this->hasTalent()) {
            $this->getContext()->load->model('andafter/ModelMessagerie', 'ModelMessagerie');
            $this->p_messageReceived = $this->getContext()->ModelMessagerie->getMessagesReceived_GroupingConversation($this->getId());
        }

        return $this->p_messageReceived;
    }

    /**
     * @return int
     */
    public function countMessagesReceived()
    {
        return is_array($this->getMessagesReceived()) ? count($this->getMessagesReceived()) : 0;
    }

    /**
     * @return mixed
     */
    public function getMessagesSend()
    {
        if ($this->p_messageSend === null && $this->hasTalent()) {
            $this->getContext()->load->model('andafter/ModelMessagerie', 'ModelMessagerie');
            $this->p_messageSend = $this->getContext()->ModelMessagerie->getMessagesSend_GroupingConversation($this->getId());
        }

        return $this->p_messageSend;
    }

    /**
     * @return mixed
     */
    public function getFormations()
    {
        if ($this->p_Formations === null && $this->hasTalent()) {
            $this->p_Formations = $this->getContext()->ModelTalent->getFormationsByIdTalent($this->getId());
        }

        return $this->p_Formations;
    }

    /**
     * @return mixed
     */
    public function getFormationsGroupedByUniversity()
    {
        if ($this->p_Formations === null && $this->hasTalent()) {
            $this->p_Formations = $this->getContext()->ModelTalent->getFormationsByIdTalentGroupedByUniversity($this->getId());
        }

        return $this->p_Formations;
    }

    /**
     * @return int
     */
    public function countMessagesSend()
    {
        $retour = 0;
        if (is_array($this->getMessagesSend())) {
            foreach ($this->getMessagesSend() as $message) {
                if (isset($message->COUNT_MESSAGES) && (int)$message->COUNT_MESSAGES > 1) {
                    $retour++;
                }
            }
        }

        return $retour;
    }

    /**
     * @return float|null
     */
    public function getTauxDeReponsesMessages()
    {
        if ($this->countMessagesReceived() > 0) {
            return round(($this->countMessagesSend() / $this->countMessagesReceived()) * 100);
        } else {
            return 0;
        }
    }

    /**
     * @return mixed
     */
    public function countRDVRealises()
    {
        return $this->getContext()->ModelTalent->countRDVRealises($this->getId());
    }

    /**
     * @return mixed
     */
    public function countRDVValides()
    {
        return $this->getContext()->ModelTalent->countRDVRealises($this->getId());
    }

    /**
     * @return mixed
     */
    public function countRDVAnnules()
    {
        return $this->getContext()->ModelTalent->countRDVAnnules($this->getId());
    }

    /**
     * @return mixed
     */
    public function countRDVEnAttente()
    {
        return $this->getContext()->ModelTalent->countRDVEnAttente($this->getId());
    }

    /**
     * @return mixed
     */
    public function countRecommandations()
    {
        if ($this->p_countrecos == null && $this->hasTalent()) {
            $this->p_countrecos = $this->getContext()->ModelTalent->countRecommandations($this->getId());
        }

        return (int)$this->p_countrecos;
    }

    public function getRDVFromTwoDate($date_from, $date_to)
    {
        return $this->getContext()->ModelTalent->getRDVFromTwoDate($date_from, $date_to, $this->getBusinessUser()->getId(), $this->getId());
    }

    /**
     * @return array
     */
    public function getAllWaitingQuestionaires()
    {
        if ($this->_Questionnaires == null && $this->hasTalent()) {
            $this->_Questionnaires = $this->getContext()->ModelConversations->getAllForQuestionnaireMentor($this->getId());
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
}
