<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package      CodeIgniter
 * @author       EllisLab Dev Team
 * @copyright    Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @copyright    Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license      http://opensource.org/licenses/MIT	MIT License
 * @link         http://codeigniter.com
 * @since        Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package        CodeIgniter
 * @subpackage     Libraries
 * @category       Libraries
 * @author         EllisLab Dev Team
 * @link           http://codeigniter.com/user_guide/general/controllers.html
 * @property CI_DB_pdo_mysql_driver   $db                           This is the platform-independent base Active Record implementation class.
 * @property CI_DB_forge              $dbforge                      Database Utility Class
 * @property CI_Benchmark             $benchmark                    This class enables you to mark points and calculate the time difference between them.<br />  Memory consumption can also be displayed.
 * @property CI_Calendar              $calendar                     This class enables the creation of calendars
 * @property CI_Cart                  $cart                         Shopping Cart Class
 * @property CI_Config                $config                       This class contains functions that enable config files to be managed
 * @property CI_Controller            $controller                   This class object is the super class that every library in.<br />CodeIgniter will be assigned to.
 * @property CI_Email                 $email                        Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encrypt               $encrypt                      Provides two-way keyed encoding using XOR Hashing and Mcrypt
 * @property CI_Exceptions            $exceptions                   Exceptions Class
 * @property CI_Form_validation       $form_validation              Form Validation Class
 * @property CI_Ftp                   $ftp                          FTP Class
 * @property CI_Hooks                 $hooks                        Provides a mechanism to extend the base system without hacking.
 * @property CI_Image_lib             $image_lib                    Image Manipulation class
 * @property CI_Input                 $input                        Pre-processes global input data for security
 * @property CI_Lang                  $lang                         Language Class
 * @property CI_Loader                $load                         Loads views and files
 * @property CI_Log                   $log                          Logging Class
 * @property CI_Model                 $model                        CodeIgniter Model Class
 * @property CI_Output                $output                       Responsible for sending final output to browser
 * @property CI_Pagination            $pagination                   Pagination Class
 * @property CI_Parser                $parser                       Parses pseudo-variables contained in the specified template view,<br />replacing them with the data in the second param
 * @property CI_Profiler              $profiler                     This class enables you to display benchmark, query, and other data<br />in order to help with debugging and optimization.
 * @property CI_Router                $router                       Parses URIs and determines routing
 * @property CI_Session               $session                      Session Class
 * @property CI_Sha1                  $sha1                         Provides 160 bit hashing using The Secure Hash Algorithm
 * @property CI_Table                 $table                        HTML table generation<br />Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback             $trackback                    Trackback Sending/Receiving Class
 * @property CI_Typography            $typography                   Typography Class
 * @property CI_Unit_test             $unit_test                    Simple testing class
 * @property CI_Upload                $upload                       File Uploading Class
 * @property CI_URI                   $uri                          Parses URIs and determines routing
 * @property CI_User_agent            $user_agent                   Identifies the platform, browser, robot, or mobile devise of the browsing agent
 * @property CI_Validation            $validation                   //dead
 * @property CI_Xmlrpc                $xmlrpc                       XML-RPC request handler class
 * @property CI_Xmlrpcs               $xmlrpcs                      XML-RPC server class
 * @property CI_Zip                   $zip                          Zip Compression Class
 * @property CI_Javascript            $javascript                   Javascript Class
 * @property CI_Jquery                $jquery                       Jquery Class
 * @property CI_Utf8                  $utf8                         Provides support for UTF-8 environments
 * @property CI_Security              $security                     Security Class, xss, csrf, etc...
 * @property Talent_model             $talent                       Talent Model
 * @property User_model               $user                         User Model
 * @property Wishlist_model           $wish                         Wishlist Model
 * @property Linkedin                 $linkedin                     Linkedin Librairies
 * @property User_info                $user_info                    User_info Librairies
 *
 * @property ModelTalent              $ModelTalent
 * @property ModelTalents             $ModelTalents
 * @property ModelUser                $ModelUser
 * @property ModelUserLinkedin        $ModelUserLinkedin
 * @property ModelUserPaymentProvider $ModelUserPaymentProvider
 * @property ModelEntreprise          $ModelEntreprise
 * @property ModelEntreprises         $ModelEntreprises
 * @property ModelSecteur             $ModelSecteur
 * @property ModelVille               $ModelVille
 * @property ModelTag                 $ModelTag
 * @property ModelCategorie_Fonction  $ModelCategorie_Fonction
 * @property ModelSearch              $ModelSearch
 * @property ModelMessagerie          $ModelMessagerie
 * @property ModelConversations       $ModelConversations
 * @property ModelConversation        $ModelConversation
 * @property ModelMessage             $ModelMessage
 * @property ModelQuestionnaire       $ModelQuestionnaire
 * @property ModelGestion             $ModelGestion
 * @property ModelUpdate              $ModelUpdate
 * @property ModelOffre               $ModelOffre
 * @property ModelEntrepriseAdmin     $ModelEntrepriseAdmin
 * @property ModelMedia               $ModelMedia
 * @property ModelGeneral             $ModelGeneral
 * @property ModelEntreprise_Sections $ModelEntreprise_Sections
 * @property ModelCalendar            $ModelCalendar
 * @property ModelStat                $ModelStat
 * @property autoComplete_model       $ModelAutoComplete
 * @property ModelBackoffice          $ModelBackoffice
 *
 * @property BusinessMangopay         $BusinessMangopay
 * @property LinkedinScraping         $LinkedinScraping
 * @property BusinessTalent           $BusinessTalent
 * @property BusinessTalents          $BusinessTalents
 * @property BusinessUser             $BusinessUser
 * @property BusinessUsers            $BusinessUsers
 * @property BusinessUserLinkedin     $BusinessUserLinkedin
 * @property BusinessEntreprise       $BusinessEntreprise
 * @property BusinessEntreprises      $BusinessEntreprises
 * @property BusinessStat             $BusinessStat
 * @property BusinessVille            $BusinessVille
 * @property BusinessSearch           $BusinessSearch
 * @property BusinessConversation     $BusinessConversation
 * @property BusinessConversations    $BusinessConversations
 * @property BusinessTalentDemande    $BusinessTalentDemande
 * @property General_info             $General_info
 */
class CI_Controller
{

    /**
     * Reference to the CI singleton
     *
     * @var    object
     */
    private static $instance;
    protected      $datas;

    /**
     * Class constructor
     *
     * @return    void
     */
    public function __construct()
    {
        self::$instance =& $this;

        // Assign all the class objects that were instantiated by the
        // bootstrap file (CodeIgniter.php) to local class variables
        // so that CI can run as one big super object.
        foreach (is_loaded() as $var => $class) {
            $this->$var =& load_class($class);
        }

        $this->load =& load_class('Loader', 'core');
        $this->load->initialize();

        if ($this->input->get('hash') != '') {
            redirect('/connexion/' . $this->input->get('hash') . '?referer=' . $this->uri->uri_string, 'auto', '301');
        }

        $this->datas = [
            'header_class'   => '',
            'header_logo'    => 'logo',
            'User'           => false,
            'SEO_title_page' => 'Ulyss.co',
            'SEO_desc_page'  => 'Bienvenue sur le site ulyss.co'
        ];
        if ($this->session->has_userdata('logged_in_site_web')) {
            $userId                              = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
            $this->datas['User']                 = $this->ModelUser->getById($userId);
            $this->datas['UserLinkedin']         = $this->ModelUserLinkedin->getByIdUser($userId);
            $this->datas['BusinessUser']         = new BusinessUser($this->datas['User']);
            $this->datas['BusinessUserLinkedin'] = new BusinessUserLinkedin($this->datas['UserLinkedin']);

            //verif si il y a un element a afficher lors de la connection

            // on recupere les questionnaire et on les inser dans la datas
            if ($this->hasQuestionnairesUser()) {
                $this->datas['ModelQuestionnairesUser'] = $this->getBusinessUser()->getAllWaitingQuestionaires();
            }

            if ($this->getBusinessUser()->isMentor() && $this->hasQuestionnairesMentor()) {
                //on recup le nbr questionnaire pour les mentor
                $this->datas['ModelQuestionnairesMentor'] = $this->getBusinessUser()->getBusinessTalent()->getAllWaitingQuestionaires();
            }
        }

        if ($this->session->has_userdata('ent_logged_in_site_web')) {
            $this->id_admin_ent_decode         = $this->encrypt->decode($this->session->userdata('ent_logged_in_site_web')['id']);
            $this->id_ent_decode               = $this->encrypt->decode($this->session->userdata('ent_logged_in_site_web')['id_ent']);
            $entInfo                           = $this->ModelEntreprise->GetEntrepriseById($this->id_ent_decode);
            $this->datas['BusinessEntreprise'] = new BusinessEntreprise($entInfo);

            $last_connection = $this->session->userdata('ent_logged_in_site_web')['last_connection'];

            $stat = (object)[
                'id_ent'          => $this->id_ent_decode,
                'last_connection' => $last_connection
            ];

            $this->datas['BusinessStat'] = $stat;

        }
    }

    /**
     * @param $string
     *
     * @return string
     */
    protected function create_alias_entreprise($string)
    {
        $this->load->library('urlify');
        $verifcation  = $this->urlify->filter($string);
        $verifcation1 = $verifcation;
        $result       = $this->ModelEntreprises->verifcationExistAliasEntreprise($verifcation);
        if ($result) {
            $i = 1;
            while ($result) {
                $verifcation = $verifcation1 . "." . $i;
                $result      = $this->ModelEntreprises->verifcationExistAliasEntreprise($verifcation);
                $i++;
            }
        }

        return $verifcation;
    }

    /**
     * @return BusinessUser|null
     */
    public function getBusinessUser()
    {
        return isset($this->datas['BusinessUser']) ? $this->datas['BusinessUser'] : null;
    }

    /**
     * @return BusinessUserLinkedin|null
     */
    public function getBusinessUserLinkedin()
    {
        return isset($this->datas['BusinessUserLinkedin']) ? $this->datas['BusinessUserLinkedin'] : null;
    }

    /**
     * @return BusinessEntreprise|null
     */
    public function getBusinessEntreprise()
    {
        return isset($this->datas['BusinessEntreprise']) ? $this->datas['BusinessEntreprise'] : null;
    }

    /**
     * @return BusinessStat|null
     */
    public function getBusinessStat()
    {
        return isset($this->datas['BusinessStat']) ? $this->datas['BusinessStat'] : null;
    }

    /**
     * @return bool
     */
    public function userIsAuthentificate()
    {
        return (bool)$this->session->userdata('logged_in_site_web');
    }

    /**
     * @return bool
     */
    public function companyIsAuthentificate()
    {
        return (bool)$this->session->userdata('ent_logged_in_site_web');
    }

    /**
     * @return bool
     */
    public function hasQuestionnairesUser()
    {

        return (bool)$this->getBusinessUser()->countAllWaitingQuestionaires() > 0;

    }

    /**
     * @return bool
     */
    public function hasQuestionnairesMentor()
    {
        return (bool)$this->getBusinessUser()->getBusinessTalent()->countAllWaitingQuestionaires() > 0;
    }


    public function getModelQuestionnairesUser()
    {
        return isset($this->datas['ModelQuestionnairesUser']) ? $this->datas['ModelQuestionnairesUser'] : null;
    }


    public function getModelQuestionnairesMentor()
    {
        return isset($this->datas['ModelQuestionnairesMentor']) ? $this->datas['ModelQuestionnairesMentor'] : null;
    }

    public function isfirstTimeConnect()
    {
        return (bool)$this->ModelUser->verifFirstTime($this->datas['BusinessUser']->getId());
    }

    public function firstTimeConnect()
    {
        if ($this->isfirstTimeConnect()) {
            if ($this->session->userdata('last_v') == 'inscription/insider') {
                redirect(base_url('inscription/insider'));
            } else {
                redirect(base_url('inscription/etape1'));
            }
        }
    }
    // --------------------------------------------------------------------

    /**
     * Get the CI singleton
     *
     * @static
     * @return    object
     */
    public static function &get_instance()
    {
        return self::$instance;
    }

}
