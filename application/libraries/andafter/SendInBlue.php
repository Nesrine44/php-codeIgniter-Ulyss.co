<?php

include_once 'MailinSendInBlue.php';
include_once 'SMSSendInBlue.php';

/**
 * Class SendInBlue
 */
class SendInBlue
{

    private static $API_KEY = 'dC0UXBINEq3cVLD4';
    private static $URLAPI  = "https://api.sendinblue.com/v2.0";

    const TEMPLATE_MAIL_CREATION_COMPTE                  = 2;
    const TEMPLATE_MAIL_NOUVEAU_MESSAGE_RECU             = 3;
    const TEMPLATE_MAIL_MENTOR_VALIDATION_RDV            = 4;
    const TEMPLATE_MAIL_CANDIDAT_VALIDATION_RDV          = 99;
    const TEMPLATE_MAIL_CONTACT_EMPLOYEUR                = 5;
    const TEMPLATE_MAIL_AUTO_NOMENTOR_SEARCH             = 25;
    const TEMPLATE_MAIL_MENTOR_DEMANDE_RDV               = 8;
    const TEMPLATE_CANDIDAT_CONFIRMATION_RDV_REALISE     = 24;
    const TEMPLATE_MENTOR_CONFIRMATION_RDV_REALISE       = 23;
    const TEMPLATE_MENTOR_CONFIRMATION_RDV_REFUSE_SELF   = 11;
    const TEMPLATE_MENTOR_CONFIRMATION_RDV_ANNULE_SELF   = 12;
    const TEMPLATE_CANDIDAT_CONFIRMATION_RDV_ANNULE_SELF = 13;
    const TEMPLATE_MENTOR_RDV_ANNULE_ALERT               = 14;
    const TEMPLATE_CANDIDAT_RDV_ANNULE_ALERT             = 16;
    const TEMPLATE_MENTOR_RAPPEL_RDV                     = 18;
    const TEMPLATE_MENTOR_RDV_NOT_HONORED                = 20;
    const TEMPLATE_CANDIDAT_RDV_NOT_HONORED              = 21;
    const TEMPLATE_MENTOR_RDV_NOT_HONORED_SELF           = 22;
    const TEMPLATE_CANDIDAT_ASK_RDV_PENDING              = 7;
    const TEMPLATE_CANDIDAT_RDV_REFUSE_ALERT             = 9;
    const TEMPLATE_CANDIDAT_RDV_CONFIRMED                = 10;
    const TEMPLATE_MENTOR_ACCOUNT_CREATED                = 37;
    const TEMPLATE_MOT_DE_PASSE_OUBLIER                  = 91;


    /**
     * SendInBlue constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param       $template_mail
     * @param       $email_destinataire
     * @param array $variables_personnalisation
     */
    public static function sendEmail($email_destinataire, $name_destinataire, $sujet, $corps_message)
    {
        $mailin = new MailinSendInBlue(self::$URLAPI, self::$API_KEY);
        $data   = [
            "to"      => [$email_destinataire => $name_destinataire],
            "from"    => ["camille@ulyss.co", "Camille Ulyss.co"],
            "subject" => $sujet,
            "html"    => $corps_message,
        ];
        $mailin->send_email($data);
    }

    /**
     * @param       $template_mail
     * @param       $email_destinataire
     * @param array $variables_personnalisation
     */
    public static function sendTemplateMail($template_mail, $email_destinataire, $variables_personnalisation = [])
    {
        $mailin = new MailinSendInBlue(self::$URLAPI, self::$API_KEY);
        $data   = [
            "id"      => (int)$template_mail,
            "to"      => $email_destinataire,
            "attr"    => $variables_personnalisation,
            "headers" => ["Content-Type" => "text/html;charset=uft-8"]
        ];
        $mailin->send_transactional_template($data);
    }

    /**
     * @param        $to_number => 33XXXXXXXXXX
     * @param        $text
     * @param string $tag
     *
     * @return array|mixed
     */
    public static function sendSms($to_number, $text, $tag = '')
    {
        $mailin = new SMSSendInBlue(self::$API_KEY);

        $mailin->addTo($to_number)
            ->setFrom('ULYSS')// If numeric, then maximum length is 17 characters and if alphanumeric maximum length is 11 characters.
            ->setText($text)// 160 characters per SMS.
            ->setTag($tag)
            ->setType('transactional');

        return $mailin->send();
    }
}
