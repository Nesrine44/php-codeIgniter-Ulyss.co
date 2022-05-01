<?php

/**
 * Class LinkedinScraping
 */
class LinkedinScraping
{

    private $p_pre_delimiter_user = "{&quot;data&quot;:{&quot;positionGroupView",
        $p_post_delimiter_user = "MiniProfile&quot;}]}",
        $p_pre_delimiter_company = "{&quot;data&quot;:{&quot;elements&quot;:[&quot;urn:li:fs_normalized_company:",
        $p_post_delimiter_company = ",staffCountRange&quot;}]}",
        $p_url_images = "https://media.licdn.com/mpr/mpr",
        $p_BusinessUserLinkedin,
        $p_ch_login,
        $p_response_login,
        $p_userProfile,
        $p_companyProfile,
        $p_userProfileDetailsFormatted;

    const TYPE_ITEMS         = 'com.linkedin.voyager.identity.profile.Profile';
    const TYPE_PROFILE       = 'com.linkedin.voyager.identity.shared.MiniProfile';
    const TYPE_EXPERIENCES   = 'com.linkedin.voyager.identity.profile.Position';
    const TYPE_FORMATIONS    = 'com.linkedin.voyager.identity.profile.Education';
    const TYPE_COMPETENCES   = 'com.linkedin.voyager.identity.profile.Skill';
    const TYPE_COMPAGNY_URL  = 'https://www.linkedin.com/company/';
    const TYPE_COMPAGNY_CITY = 'com.linkedin.voyager.organization.OrganizationAddress';

    /**
     * LinkedinScraping constructor.
     *
     * @param array $params
     */
    public function __construct($params)
    {
        $this->p_BusinessUserLinkedin = $params['BusinessUserLinkedin'];
        $this->p_id_compte_scrap      = isset($params['id_compte']) ? $params['id_compte'] : '1';
        $this->p_email                = isset($params['email']) ? $params['email'] : 'matthieu.billon@gmail.com';
        $this->p_password             = isset($params['password']) ? $params['password'] : 'Mymentor13*';
        $this->loginSubmit();
        $this->getUserProfile();

    }


    /**
     * @return BusinessUserLinkedin
     */
    private function getBusinessUserLinkedin()
    {
        return $this->p_BusinessUserLinkedin;
    }

    /**
     * @param $string
     * @param $start
     * @param $end
     *
     * @return bool|string
     */
    private function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini    = strpos($string, $start);
        if ($ini == 0) {
            return '';
        }
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);
    }

    /**
     * @param        $str
     * @param string $find_start
     * @param string $find_end
     *
     * @return bool|string
     */
    private function fetch_value($str, $find_start = '', $find_end = '')
    {
        if ($find_start == '') {
            return '';
        }

        $start = strpos($str, $find_start);
        if ($start === false) {
            return '';
        }

        $length = strlen($find_start);
        $substr = substr($str, $start + $length);
        if ($find_end == '') {
            return $substr;
        }

        $end = strpos($substr, $find_end);
        if ($end === false) {
            return $substr;
        }

        return substr($substr, 0, $end);
    }

    /**
     * @param $array
     * @param $key
     *
     * @return null
     */
    public function getValueInArray($array, $key)
    {
        return isset($array[$key]) ? $array[$key] : null;
    }

    /**
     * @param $array
     * @param $key
     *
     * @return null
     */
    public function getFormattedDate($date)
    {
        if (strlen($date) == '4') { /* Just Year */
            return $date;
        } else {
            if (strlen($date) > '4') {
                return ucfirst(strftime('%B %Y', strtotime($date)));
            } else {
                return '';
            }
        }
    }

    /**
     * @return CI_Controller
     */
    public function getContext()
    {
        $controllerInstance = &get_instance();

        return $controllerInstance;
    }

    /**
     * @param $a
     * @param $b
     *
     * @return bool
     */
    private static function cmp($a, $b)
    {
        $aperiodstart = isset($a['period']['start']) ? str_replace('-', '', $a['period']['start']) : 000000;
        $aperiodend   = isset($a['period']['end']) ? str_replace('-', '', $a['period']['end']) : 999912;
        $aperiode     = $aperiodstart . $aperiodend;

        $bperiodstart = isset($b['period']['start']) ? str_replace('-', '', $b['period']['start']) : 000000;
        $bperiodend   = isset($b['period']['end']) ? str_replace('-', '', $b['period']['end']) : 999912;
        $bperiode     = $bperiodstart . $bperiodend;

        return $aperiode < $bperiode;
    }

    /**
     *
     */
    public function loginSubmit()
    {
        if ($this->p_ch_login == null) {
            $linkedin_login_page = "https://www.linkedin.com/uas/login";
            $linkedin_ref        = "https://www.linkedin.com";

            $this->p_ch_login = curl_init();
            curl_setopt($this->p_ch_login, CURLOPT_URL, $linkedin_login_page);
            curl_setopt($this->p_ch_login, CURLOPT_REFERER, $linkedin_ref);
            curl_setopt($this->p_ch_login, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7)');
            curl_setopt($this->p_ch_login, CURLOPT_AUTOREFERER, true);
            curl_setopt($this->p_ch_login, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->p_ch_login, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($this->p_ch_login, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->p_ch_login, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($this->p_ch_login, CURLOPT_COOKIEJAR, 'cookie.txt');
            curl_setopt($this->p_ch_login, CURLOPT_COOKIEFILE, 'cookie.txt');

            $login_content = curl_exec($this->p_ch_login);

            if (curl_error($this->p_ch_login)) {
                die('error:' . curl_error($this->p_ch_login));
            }

            $var                   = [
                'isJsEnabled'       => 'false',
                'source_app'        => '',
                'clickedSuggestion' => 'false',
                'session_key'       => trim($this->p_email),
                'session_password'  => trim($this->p_password),
                'signin'            => 'Sign In',
                'session_redirect'  => '',
                'trk'               => '',
                'fromEmail'         => ''
            ];
            $var['loginCsrfParam'] = $this->fetch_value($login_content, 'type="hidden" name="loginCsrfParam" value="', '"');
            $var['csrfToken']      = $this->fetch_value($login_content, 'type="hidden" name="csrfToken" value="', '"');
            $var['sourceAlias']    = $this->fetch_value($login_content, 'input type="hidden" name="sourceAlias" value="', '"');

            $post_array = [];
            foreach ($var as $key => $value) {
                $post_array[] = urlencode($key) . '=' . urlencode($value);
            }

            $post_string = implode('&', $post_array);

            curl_setopt($this->p_ch_login, CURLOPT_URL, "https://www.linkedin.com/uas/login-submit");
            curl_setopt($this->p_ch_login, CURLOPT_POST, true);
            curl_setopt($this->p_ch_login, CURLOPT_POSTFIELDS, $post_string);

            $this->p_response_login = curl_exec($this->p_ch_login);
        }
    }

    /**
     * @return mixed
     */
    private function getUserProfile()
    {
        if ($this->p_userProfile == null) {

            $url_profil = str_replace('http:', 'https:', $this->getBusinessUserLinkedin()->getPublicProfileUrl());
            curl_setopt($this->p_ch_login, CURLOPT_URL, $url_profil);
            //curl_setopt($this->p_ch_login, CURLOPT_URL, 'https://www.linkedin.com/in/ulyss/');
            //            curl_setopt($this->p_ch_login, CURLOPT_URL, 'https://www.linkedin.com/in/mathieu-lebrun-a547a857/');
            //            curl_setopt($this->p_ch_login, CURLOPT_URL, 'https://www.linkedin.com/in/jerem2003/');
            //            curl_setopt($this->p_ch_login, CURLOPT_URL, 'https://www.linkedin.com/in/laure-baudry-64869614a/');
            //            curl_setopt($this->p_ch_login, CURLOPT_URL, 'https://www.linkedin.com/in/emma-barraud-92131714a');
            //            curl_setopt($this->p_ch_login, CURLOPT_URL, 'https://www.linkedin.com/in/lucie-hottin-8bb68bb1');
            //            curl_setopt($this->p_ch_login, CURLOPT_URL, 'https://www.linkedin.com/in/emma-barraud-92131714a');
            //            curl_setopt($this->p_ch_login, CURLOPT_URL, 'https://www.linkedin.com/in/matthieu-billon-97b60926');
            //            curl_setopt($this->p_ch_login, CURLOPT_URL, 'https://www.linkedin.com/in/nicolasmermin');
            //curl_setopt($this->p_ch_login, CURLOPT_URL, 'https://www.linkedin.com/in/julien-balthazar-ulyss/');
            $retour              = curl_exec($this->p_ch_login);
            $this->p_userProfile = $this->p_pre_delimiter_user . $this->get_string_between($retour, $this->p_pre_delimiter_user, $this->p_post_delimiter_user) . $this->p_post_delimiter_user;

            $this->p_userProfile = json_decode(html_entity_decode($this->p_userProfile), true);

            if (is_array($this->p_userProfile) == false) {
                redirect('/error/700');
            }

            //--------------- FIN DU MODULE DE SCRAP AVEC LES COMPTE --------

            $this->p_userProfile = array_reverse($this->p_userProfile['included'], true);


            foreach ($this->p_userProfile as $key => $item) {
                $this->p_userProfile[$key] = array_reverse($this->p_userProfile[$key], true);
            }
        }

        return $this->p_userProfile;
    }

    /**
     * @return array
     */
    public function getProfileDetailsFormatted()
    {

        $this->getContext()->load->model('andafter/ModelUpdate');
        $this->getContext()->load->model('andafter/ModelEntreprise');

        if ($this->p_userProfile == null) {
            return null;
        }
        if ($this->p_userProfileDetailsFormatted == null) {
            $arrayProfile            = $this->getUserProfile();
            $array_items             = [];
            $array_profile           = [];
            $array_exp               = [];
            $array_formations        = [];
            $array_competences       = [];
            $profileDetailsFormatted = [];


            foreach ($arrayProfile as $itemProfile) {


                //var_dump($itemProfile);
                //die();

                if (isset($itemProfile['$type']) && $itemProfile['$type'] == self::TYPE_ITEMS) {
                    $array_items = $itemProfile;
                }
                if (isset($itemProfile['$type']) && $itemProfile['$type'] == self::TYPE_PROFILE) {
                    $array_profile[] = $itemProfile;
                }
                if (isset($itemProfile['$type']) && $itemProfile['$type'] == self::TYPE_EXPERIENCES) {
                    $array_exp[] = $itemProfile;
                }
                if (isset($itemProfile['$type']) && $itemProfile['$type'] == self::TYPE_FORMATIONS) {
                    $array_formations[] = $itemProfile;
                }
                if (isset($itemProfile['$type']) && $itemProfile['$type'] == self::TYPE_COMPETENCES) {
                    $array_competences[] = $itemProfile;
                }
            }

            //initialisation de la photo par default
            $profileDetailsFormatted['profile']['url_picture'] = '/upload/avatar/default.jpg';

            /* PROFILE */
            foreach ($array_profile as $itemprofile_key => $itemprofile_label) {

                if (in_array($this->getValueInArray($array_items, 'miniProfile'), $itemprofile_label) == false) {
                    continue;
                }

                /* Specific treatments */
                $pictureId = $this->getValueInArray($itemprofile_label, 'picture');
                $pictureId = is_array($pictureId) ? reset($pictureId) : $pictureId;

                $profileDetailsFormatted['profile']['firstName']        = $this->getValueInArray($itemprofile_label, 'firstName');
                $profileDetailsFormatted['profile']['lastName']         = $this->getValueInArray($itemprofile_label, 'lastName');
                $profileDetailsFormatted['profile']['fullName']         = $this->getValueInArray($itemprofile_label, 'firstName') . ' ' . $this->getValueInArray($itemprofile_label, 'lastName');
                $profileDetailsFormatted['profile']['publicIdentifier'] = $this->getValueInArray($itemprofile_label, 'publicIdentifier');
                $profileDetailsFormatted['profile']['occupation']       = $this->getValueInArray($itemprofile_label, 'occupation');

                foreach ($arrayProfile as $itemProfile) {
                    /* get first part of URL media */
                    if (isset($itemProfile['$id']) && $itemProfile['$id'] == $pictureId) {
                        $profileDetailsFormatted['profile']['url_picture'] = $this->getValueInArray($itemProfile, 'rootUrl');
                        $pictureIdUri                                      = $this->getValueInArray($itemProfile, 'artifacts');
                        $pictureIdUri                                      = is_array($pictureIdUri) ? end($pictureIdUri) : $pictureIdUri;
                    }
                }

                if (isset($pictureIdUri) && isset($profileDetailsFormatted['profile']['url_picture'])) {
                    foreach ($arrayProfile as $itemProfile) {
                        /* get last part of URL media */
                        if (isset($itemProfile['$id']) && $itemProfile['$id'] == $pictureIdUri) {
                            $profileDetailsFormatted['profile']['url_picture'] .= $this->getValueInArray($itemProfile, 'fileIdentifyingUrlPathSegment');
                        }
                    }
                }
            }


            /* EXPERIENCES */
            foreach ($array_exp as $itemexp_key => $itemexp_label) {


                /* Specific treatments */
                $idJob        = $this->getValueInArray($itemexp_label, 'entityUrn');
                $idJob        = substr(strrchr($idJob, ","), 1, -1);
                $compagnycode = $this->getValueInArray($itemexp_label, 'companyUrn');
                $compagnycode = substr(strrchr($compagnycode, ":"), 1);


                $profileDetailsFormatted['experiences'][$idJob]['idjob']            = $idJob;
                $profileDetailsFormatted['experiences'][$idJob]['title']            = $this->getValueInArray($itemexp_label, 'title');
                $profileDetailsFormatted['experiences'][$idJob]['description']      = $this->getValueInArray($itemexp_label, 'description');
                $profileDetailsFormatted['experiences'][$idJob]['compagny']['code'] = $compagnycode;

                $array_compagny_url  = [];
                $array_compagny_city = [];
                $CompanyProfil       = [];

                $CompanyProfil = $this->getCompanyDetail($compagnycode);

                if ($CompanyProfil !== null) {

                    foreach ($CompanyProfil as $item) {
                        if (isset($item['url']) && $item['url'] == self::TYPE_COMPAGNY_URL . $compagnycode) {
                            $array_compagny_url = $item;
                        }

                        if (isset($item['$type']) && $item['$type'] == self::TYPE_COMPAGNY_CITY) {
                            $array_compagny_city = $item;
                        }
                    }

                    $profileDetailsFormatted['experiences'][$idJob]['compagny']['name']           = $this->getValueInArray($array_compagny_url, 'name');
                    $profileDetailsFormatted['experiences'][$idJob]['compagny']['page']           = $this->getValueInArray($array_compagny_url, 'companyPageUrl');
                    $profileDetailsFormatted['experiences'][$idJob]['compagny']['city']           = $this->getValueInArray($array_compagny_city, 'city');
                    $profileDetailsFormatted['experiences'][$idJob]['compagny']['geographicArea'] = $this->getValueInArray($array_compagny_city, 'geographicArea');
                    $profileDetailsFormatted['experiences'][$idJob]['compagny']['country']        = $this->getValueInArray($array_compagny_city, 'country');
                    $profileDetailsFormatted['experiences'][$idJob]['compagny']['cityExp']        = $this->getValueInArray($itemexp_label, 'locationName');
                    $profileDetailsFormatted['experiences'][$idJob]['compagny']['alias']          = $this->getValueInArray($array_compagny_url, 'universalName');
                } else {
                    $profileDetailsFormatted['experiences'][$idJob]['compagny']['name']    = $this->getValueInArray($itemexp_label, 'companyName');
                    $profileDetailsFormatted['experiences'][$idJob]['compagny']['cityExp'] = $this->getValueInArray($itemexp_label, 'locationName');
                }


                //recuperation du model entreprise par rapport a son code unique et son nom , si elle existe dans la BDD
                $ModelEntreprise = $this->getContext()->ModelEntreprise->getByCode($compagnycode);
                $nameEntreprise  = $profileDetailsFormatted['experiences'][$idJob]['compagny']['name'];
                $nameEntreprise  = $this->getContext()->ModelEntreprise->getByName($nameEntreprise);


                //si l'entreprise n'existe pas on recupere tout les entreprises que le nom de l'entreprise srapper existe dans une des entreprise dans notre BDD
                if ($ModelEntreprise == false && $nameEntreprise == false && $compagnycode == false) {
                    //recup du nom
                    $name                                                              = $profileDetailsFormatted['experiences'][$idJob]['compagny']['name'];
                    $name                                                              = explode(" ", $name);
                    $profileDetailsFormatted['experiences'][$idJob]['entrepriseChoix'] = $this->checkExist($name);
                }


                /* get other infos in other array */
                $timePeriod = $this->getValueInArray($itemexp_label, 'timePeriod');
                $compagny   = $this->getValueInArray($itemexp_label, 'company');
                //                var_dump($arrayProfile); die();
                foreach ($arrayProfile as $itemProfile) {
                    /* get Start Date */
                    if (isset($itemProfile['$id']) && $itemProfile['$id'] == $timePeriod . ',startDate') {
                        $profileDetailsFormatted['experiences'][$idJob]['period']['start'] = $this->getValueInArray($itemProfile, 'year');
                        if ($this->getValueInArray($itemProfile, 'month') != null) {
                            $profileDetailsFormatted['experiences'][$idJob]['period']['start'] .= '-' . str_pad($this->getValueInArray($itemProfile, 'month'), 2, "0", STR_PAD_LEFT);
                        }
                    }

                    /* get End Date */
                    if (isset($itemProfile['$id']) && $itemProfile['$id'] == $timePeriod . ',endDate') {
                        $profileDetailsFormatted['experiences'][$idJob]['period']['end'] = $this->getValueInArray($itemProfile, 'year');
                        if ($this->getValueInArray($itemProfile, 'month') != null) {
                            $profileDetailsFormatted['experiences'][$idJob]['period']['end'] .= '-' . str_pad($this->getValueInArray($itemProfile, 'month'), 2, "0", STR_PAD_LEFT);
                        }
                    }

                    /* get Industry Compagny */
                    if (isset($itemProfile['$id']) && $itemProfile['$id'] == $compagny) {
                        $profileDetailsFormatted['experiences'][$idJob]['compagny']['industry'] = is_array($this->getValueInArray($itemProfile,
                            'industries')) ? $this->getValueInArray($itemProfile,
                            'industries')[0] : $this->getValueInArray($itemProfile, 'industries');
                        if (isset($itemProfile['employeeCountRange']) && $itemProfile['employeeCountRange'] != '') {
                            $employeeCountRange = $itemProfile['employeeCountRange'];
                            foreach ($arrayProfile as $_itemProfile) {
                                if (isset($_itemProfile['$id']) && $_itemProfile['$id'] == $employeeCountRange) {
                                    $startEmployee                                                                    = $this->getValueInArray($_itemProfile, 'start');
                                    $endEmployee                                                                      = $this->getValueInArray($_itemProfile, 'end');
                                    $profileDetailsFormatted['experiences'][$idJob]['compagny']['employeeCountRange'] = $startEmployee . '-' . $endEmployee;
                                    break;
                                }
                            }
                        }
                    }


                    /* get Logo Compagny */
                    if (isset($itemProfile['$id']) && $itemProfile['$id'] == 'urn:li:fs_miniCompany:' . $compagnycode . ',logo,com.linkedin.voyager.common.MediaProcessorImage') {
                        $profileDetailsFormatted['experiences'][$idJob]['compagny']['logo'] = $this->p_url_images . $this->getValueInArray($itemProfile, 'id');
                    } else {
                        if (isset($itemProfile['$id']) && $itemProfile['$id'] == 'urn:li:fs_miniCompany:' . $compagnycode . ',logo,com.linkedin.common.VectorImage') {
                            $first_uri    = $this->getValueInArray($itemProfile, 'rootUrl');
                            $lasts_uri    = $this->getValueInArray($itemProfile, 'artifacts');
                            $last_key_uri = is_array($lasts_uri) ? end($lasts_uri) : $lasts_uri;
                            foreach ($arrayProfile as $itemProfile_) {
                                if (isset($itemProfile_['$id']) && $itemProfile_['$id'] == $last_key_uri) {
                                    $last_uri = $this->getValueInArray($itemProfile_, 'fileIdentifyingUrlPathSegment');
                                    break;
                                }
                            }
                            $profileDetailsFormatted['experiences'][$idJob]['compagny']['logo'] = $first_uri . $last_uri;
                        }
                    }
                }
            }
            /* Sort array by date */
            usort($profileDetailsFormatted['experiences'], ['LinkedinScraping', 'cmp']);


            /* FORMATIONS */
            $profileDetailsFormatted['formations'] = [];
            foreach ($array_formations as $itemformation_key => $itemformation_label) {
                $idFormation = $this->getValueInArray($itemformation_label, 'entityUrn');
                $idFormation = substr(strrchr($idFormation, ","), 1, -1);
                $SchoolUrnId = $this->getValueInArray($itemformation_label, 'schoolUrn');
                $idSchool    = substr(strrchr($SchoolUrnId, ":"), 1);

                if (isset($itemformation_label['schoolName'])) {
                    $profileDetailsFormatted['formations'][$idFormation]['Name'] = $this->getValueInArray($itemformation_label, 'schoolName');
                }
                if (isset($itemformation_label['fieldOfStudy'])) {
                    $profileDetailsFormatted['formations'][$idFormation]['fonction'] = $this->getValueInArray($itemformation_label, 'fieldOfStudy');
                }

                /* get other infos in other array */
                $timePeriod = $this->getValueInArray($itemformation_label, 'timePeriod');

                if ($timePeriod != '' || $SchoolUrnId != '') {
                    foreach ($arrayProfile as $itemProfile) {
                        /* Dates formations */
                        if ($timePeriod != '') {
                            /* get Start Date */
                            if (isset($itemProfile['$id']) && $itemProfile['$id'] == $timePeriod . ',startDate') {
                                $profileDetailsFormatted['formations'][$idFormation]['period']['start'] = $this->getValueInArray($itemProfile, 'year');
                                if ($this->getValueInArray($itemProfile, 'month') != null) {
                                    $profileDetailsFormatted['formations'][$idFormation]['period']['start'] .= '-' . str_pad($this->getValueInArray($itemProfile, 'month'), 2, "0", STR_PAD_LEFT);
                                }
                            }

                            /* get End Date */
                            if (isset($itemProfile['$id']) && $itemProfile['$id'] == $timePeriod . ',endDate') {
                                $profileDetailsFormatted['formations'][$idFormation]['period']['end'] = $this->getValueInArray($itemProfile, 'year');
                                if ($this->getValueInArray($itemProfile, 'month') != null) {
                                    $profileDetailsFormatted['formations'][$idFormation]['period']['end'] .= '-' . str_pad($this->getValueInArray($itemProfile, 'month'), 2, "0", STR_PAD_LEFT);
                                }
                            }
                        }

                        /* School Informations */
                        if ($SchoolUrnId != '') {
                            if (isset($itemProfile['entityUrn']) && $itemProfile['entityUrn'] == $SchoolUrnId) {
                                $profileDetailsFormatted['formations'][$idFormation]['Name'] = $this->getValueInArray($itemProfile, 'schoolName');
                            }
                            if (isset($itemProfile['$id']) && $itemProfile['$id'] == 'urn:li:fs_miniSchool:' . $idSchool . ',logo,com.linkedin.voyager.common.MediaProcessorImage') {
                                $profileDetailsFormatted['formations'][$idFormation]['logo'] = $this->p_url_images . $this->getValueInArray($itemProfile, 'id');
                            }
                        }
                    }
                }
                krsort($profileDetailsFormatted['formations']);
            }
            /* Sort array by date */
            usort($profileDetailsFormatted['formations'], ['LinkedinScraping', 'cmp']);

            /* COMPETENCES */
            foreach ($array_competences as $itemcompetence_key => $itemcompetence_label) {
                $profileDetailsFormatted['competences'][] = $this->getValueInArray($itemcompetence_label, 'name');
            }

            $this->p_userProfileDetailsFormatted = $profileDetailsFormatted;

        }

        return $this->p_userProfileDetailsFormatted;
    }


    //ENTREPRISE SCRPING

    /**
     * @return mixed|null
     */
    private
    function getCompanyProfile(
        $code
    ){
        $delimiter_debut = $this->p_pre_delimiter_company;

        $delimiter_fin = $code . $this->p_post_delimiter_company;

        $url_company = 'https://www.linkedin.com/company/' . $code;

        curl_setopt($this->p_ch_login, CURLOPT_URL, $url_company);

        // SCRAP test
        //curl_setopt($this->p_ch_login, CURLOPT_URL, 'https://www.linkedin.com/company/axa/');
        //curl_setopt($this->p_ch_login, CURLOPT_URL, 'https://www.linkedin.com/company/aix-ynov-campus/');

        $retour = curl_exec($this->p_ch_login);

        $retour                 = $this->get_string_between($retour, $delimiter_debut, $delimiter_fin) . $delimiter_fin;
        $this->p_companyProfile = json_decode(html_entity_decode($delimiter_debut . $retour), true);


        $tentative = 0;

        while (is_array($this->p_companyProfile) == false) {

            $tentative++;


            $retour                 = $this->get_string_between($retour, $delimiter_debut, $delimiter_fin) . $delimiter_fin;
            $this->p_companyProfile = json_decode(html_entity_decode($delimiter_debut . $retour), true);

            if ($tentative == 4) {
                break;
            }
        }

        if ($tentative == 4) {
            //l'entreprise n'a pas de page sur linkdin
            return null;
        }

        $this->p_companyProfile = array_reverse($this->p_companyProfile['included'], true);

        foreach ($this->p_companyProfile as $key => $item) {
            $this->p_companyProfile[$key] = array_reverse($this->p_companyProfile[$key], true);
        }


        return $this->p_companyProfile;
    }


    /**
     * @return mixed|null
     */
    public
    function getProfileProfile()
    {
        $DetailsProfile = $this->getProfileDetailsFormatted();

        return isset($DetailsProfile['profile']) ? $DetailsProfile['profile'] : null;
    }


    //LES GET DES UTILISATEUR


    /**
     * @return mixed|null
     */
    public
    function getProfileExperiences()
    {
        $DetailsProfile = $this->getProfileDetailsFormatted();

        return isset($DetailsProfile['experiences']) ? $DetailsProfile['experiences'] : null;
    }

    /**
     * @return mixed|null
     */
    public
    function getProfileFormations()
    {
        $DetailsProfile = $this->getProfileDetailsFormatted();

        return isset($DetailsProfile['formations']) ? $DetailsProfile['formations'] : null;
    }

    /**
     * @return mixed|null
     */
    public
    function getProfileCompetences()
    {
        $DetailsProfile = $this->getProfileDetailsFormatted();

        return isset($DetailsProfile['competences']) ? $DetailsProfile['competences'] : null;
    }

    //LES GET DES ENTREPRISE

    public
    function getCompanyDetail(
        $id
    ){
        $DetailsCompany = $this->getCompanyProfile($id);

        return $DetailsCompany;
    }


    //VÃ©rification des doublon au moment du scrap
    function checkExist($nom)
    {
        if ($nom[0] === '') {
            return null;
        }
        $doublon     = [];
        $entreprises = $this->getContext()->ModelUpdate->recupToutesEntreprises();


        foreach ($entreprises as $entreprise) {
            if ($entreprise->nom != '') {

                $position = stristr($entreprise->nom, $nom[0]);


                if ($position != null) {
                    $doublon[] = $entreprise;
                }
            }
        }


        if (empty($doublon)) {
            return null;
        } else {
            return $doublon;
        }


    }

    /**
     * @return mixed
     */
    public
    function getScrapUrlProfil(
        $url
    ){


        $url_profil = str_replace('http:', 'https:', $url);
        curl_setopt($this->p_ch_login, CURLOPT_URL, $url_profil);
        $retour = curl_exec($this->p_ch_login);
        $profil = $this->p_pre_delimiter_user . $this->get_string_between($retour, $this->p_pre_delimiter_user, $this->p_post_delimiter_user) . $this->p_post_delimiter_user;
        $profil = json_decode(html_entity_decode($profil), true);
        if (is_array($profil) == false) {
            return false;
        }

        $profil = array_reverse($profil['included'], true);


        foreach ($profil as $key => $item) {
            $profil[$key] = array_reverse($profil[$key], true);
        }


        return $profil;
    }


}
