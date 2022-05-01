<?php
defined('BASEPATH') OR exit('No direct script access allowed');


use JonnyW\PhantomJs\Client;


class Linkedin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->library('user_info');

    }

    public function phantom()
    {
        echo file_exists('/opt/phantomjs/bin/phantom');
        echo file_exists('parser/index.js');
    }


    public function pjs()
    {

        $this->load->library('simple_html_dom');


        $client   = Client::getInstance();
        $request  = $client->getMessageFactory()->createRequest('https://www.linkedin.com/', 'GET');
        $response = $client->getMessageFactory()->createResponse();

        // Send the request
        $client->send($request, $response);


        if ($response->getStatus() === 200) {


            $html = str_get_html($response->getContent());
            // Find all article blocks
            foreach ($html->find('form.login-form') as $form) {
                $nodes = $form->find("input");
                $data  = [];
                foreach ($nodes as $node) {
                    $data[$node->name] = $node->value;
                }
                $this->fakeLogin($data);
            }
        }
    }

    private function fakeLogin($data)
    {
        $client = Client::getInstance();

        $file = 'cookie.txt';
        $client->getEngine()->addOption('--cookies-file=' . $file);


        $request  = $client->getMessageFactory()->createRequest();
        $response = $client->getMessageFactory()->createResponse();
        $request->setMethod('POST');
        $request->addHeader('REFERER', 'https://www.linkedin.com/');
        $request->addHeader('USERAGENT', 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7)');
        $request->addHeader('AUTOREFERER', true);
        $request->addHeader('RETURNTRANSFER', true);
        $request->addHeader('FOLLOWLOCATION', true);
        $request->addHeader('SSL_VERIFYPEER', false);
        $request->addHeader('SSL_VERIFYHOST', 2);
        $request->addHeader('COOKIEJAR', 'cookie.txt');
        $request->addHeader('COOKIEFILE', 'cookie.txt');

        $request->setUrl('https://www.linkedin.com/uas/login-submit');
        $request->setRequestData($data); // Set post data

        $client->send($request, $response);

        if ($response->getStatus() === 200) {
            echo $response->getContent();
            var_dump($request->getHeaders());
            var_dump($response->getHeaders());
        }
    }

    public function logintwo()
    {


        //$username = $this->input->post("email");
        //$password =$this->input->post("password");

        $linkedin_login_page = "https://www.linkedin.com/uas/login";
        $linkedin_ref        = "https://www.linkedin.com";

        $username = 'khalid@carre.co.ma';
        $password = 'alert19khatar';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $linkedin_login_page);
        curl_setopt($ch, CURLOPT_REFERER, $linkedin_ref);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7)');
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');


        $login_content = curl_exec($ch);


        if (curl_error($ch)) {
            echo 'error:' . curl_error($ch);
        }

        $var                   = [
            'isJsEnabled'       => 'false',
            'source_app'        => '',
            'clickedSuggestion' => 'false',
            'session_key'       => trim($username),
            'session_password'  => trim($password),
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

        curl_setopt($ch, CURLOPT_URL, "https://www.linkedin.com/uas/login-submit");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

        $store = curl_exec($ch);

        echo $store;


        //$parsed = $this->get_string_between($store, 'publicIdentifier', 'picture');
        //$user_url = "https://www.linkedin.com/in/".$this->get_string_between($parsed, ':&quot;', '&quot;,');

        // TO REMOVE
        $user_url = "https://www.linkedin.com/in/jarjinimohamed/";
        //        curl_setopt($ch, CURLOPT_URL, $user_url);
        //        $user_profile = curl_exec($ch);
        //        echo $user_profile;

        $client = Client::getInstance();
        $client->isLazy();

        $request  = $client->getMessageFactory()->createRequest($user_url, 'GET');
        $response = $client->getMessageFactory()->createResponse();

        // Send the request
        $client->send($request, $response);

        //        echo $response->getContent();

        var_dump($response->getHeaders());
        var_dump($response);
        if ($response->getStatus() === 200) {
            //            echo $response->getContent();
        }


    }

    private function get_date_end($user_data, $id)
    {
        $dates = (explode("com.linkedin.common.Date", $user_data));
        foreach ($dates as $key => $value) {
            if ($key == 0) {
                continue;
            }
            if ($key == count($dates) - 1) {
                continue;
            }
            echo $dates[$key] . "<br>";
            echo "explode by ID<br>";
            explode($id, $dates[$key]);
            # code...
        }
    }

    public function getStartdate($user_data = "", $id)
    {
        $list_exp = explode('$deletedFields', $user_data);
        //  var_dump($list_exp);
        foreach ($list_exp as $key => $item) {
            # code...
            $start_date = explode("urn:li:fs_education", $item);
            if (count($start_date) > 1) {
                $start_date1 = explode("timePeriod,startDate", $item);
                if (count($start_date1) > 1) {
                    $start_date2 = !empty($id) && !empty($item) ? explode($id, $item) : "";

                    if (count($start_date2) > 1) {
                        $year = explode("year", $item);
                        if (count($year) > 1) {
                            $year_n = explode(",", $year[1]);
                            if (count($year_n) > 1) {

                                return $year_n[0];
                            }

                        }

                    }
                }

            }
        }

        return "No";
    }

    public function getEnddate($user_data = "", $id)
    {
        $list_exp = explode('$deletedFields', $user_data);
        //  var_dump($list_exp);
        foreach ($list_exp as $key => $item) {
            # code...
            $start_date = explode("urn:li:fs_education", $item);
            if (count($start_date) > 1) {
                $start_date1 = explode("timePeriod,endDate", $item);
                if (count($start_date1) > 1) {
                    $start_date2 = !empty($id) && !empty($item) ? explode($id, $item) : "";

                    if (count($start_date2) > 1) {
                        $year = explode("year", $item);
                        if (count($year) > 1) {
                            $year_n = explode(",", $year[1]);
                            if (count($year_n) > 1) {

                                return $year_n[0];
                            }

                        }

                    }
                }

            }
        }

        return "No";
    }

    public function getStartdateExp($user_data = "", $id)
    {
        $list_exp = explode('$deletedFields', $user_data);
        //  var_dump($list_exp);
        foreach ($list_exp as $key => $item) {
            # code...
            $start_date = explode("urn:li:fs_position", $item);
            if (count($start_date) > 1) {
                $start_date1 = explode("timePeriod,startDate", $item);
                if (count($start_date1) > 1) {
                    $start_date2 = explode($id, $item);

                    if (count($start_date2) > 1) {
                        $year = explode("year", $item);
                        if (count($year) > 1) {
                            $year_n = explode(",", $year[1]);
                            if (count($year_n) > 1) {

                                return $year_n[0];
                            }

                        }

                    }
                }

            }
        }

        return "No";
    }

    public function getStartdateExpMonth($user_data = "", $id)
    {
        $list_exp = explode('$deletedFields', $user_data);
        //  var_dump($list_exp);
        foreach ($list_exp as $key => $item) {
            # code...
            $start_date = explode("urn:li:fs_position", $item);
            if (count($start_date) > 1) {
                $start_date1 = explode("timePeriod,startDate", $item);
                if (count($start_date1) > 1) {
                    $start_date2 = explode($id, $item);

                    if (count($start_date2) > 1) {
                        $year = explode("month", $item);
                        if (count($year) > 1) {
                            $year_n = explode(",", $year[1]);
                            if (count($year_n) > 1) {

                                return $year_n[0];
                            }

                        }

                    }
                }

            }
        }

        return "No";
    }


    public function getEnddateExp($user_data = "", $id)
    {
        $list_exp = explode('$deletedFields', $user_data);
        //  var_dump($list_exp);
        foreach ($list_exp as $key => $item) {
            # code...
            $start_date = explode("urn:li:fs_position", $item);
            if (count($start_date) > 1) {
                $start_date1 = explode("timePeriod,endDate", $item);
                if (count($start_date1) > 1) {
                    $start_date2 = explode($id, $item);

                    if (count($start_date2) > 1) {
                        $year = explode("year", $item);
                        if (count($year) > 1) {
                            $year_n = explode(",", $year[1]);
                            if (count($year_n) > 1) {

                                return $year_n[0];
                            }

                        }

                    }
                }

            }
        }

        return "0000";
    }

    public function getEnddateExpMonth($user_data = "", $id)
    {
        $list_exp = explode('$deletedFields', $user_data);
        //  var_dump($list_exp);
        foreach ($list_exp as $key => $item) {
            # code...
            $start_date = explode("urn:li:fs_position", $item);
            if (count($start_date) > 1) {
                $start_date1 = explode("timePeriod,endDate", $item);
                if (count($start_date1) > 1) {
                    $start_date2 = explode($id, $item);

                    if (count($start_date2) > 1) {
                        $year = explode("month", $item);
                        if (count($year) > 1) {
                            $year_n = explode(",", $year[1]);
                            if (count($year_n) > 1) {

                                return $year_n[0];
                            }

                        }

                    }
                }

            }
        }

        return "00";
    }


    public function getIdCourse($id)
    {


        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $id);
        $ID_New = str_replace("quot", "", $string);

        return $ID_New;

    }

    public function getIdCourse1($id)
    {
        $entreprise_l = str_replace(":", "", $id);
        $entreprise_l = html_entity_decode($entreprise_l);
        $entreprise_l = preg_replace('/\\\n/', '<br/>', $entreprise_l);
        $entreprise_l = preg_replace('/\\\"/', '&quot;', $entreprise_l);
        $entreprise_l = preg_replace('/\",\"/', '', $entreprise_l);
        $entreprise_l = str_replace(['","', '"'], '', $entreprise_l);

        return $entreprise_l;

    }

    public function getVilleInArray($villes)
    {
        foreach ($villes as $key => $item) {
            $item_ville = explode("locationName", $item);
            if (count($item_ville) > 1) {
                return $item_ville[1];
            }
        }

        return "Inconu";
    }

    public function login1()
    {


        $username = $this->input->post("email");
        $password = $this->input->post("password");

        $linkedin_login_page = "https://www.linkedin.com/uas/login";
        $linkedin_ref        = "https://www.linkedin.com";


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $linkedin_login_page);
        curl_setopt($ch, CURLOPT_REFERER, $linkedin_ref);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7)');
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');


        $login_content = curl_exec($ch);


        if (curl_error($ch)) {
            echo 'error:' . curl_error($ch);
        }

        $var                   = [
            'isJsEnabled'       => 'false',
            'source_app'        => '',
            'clickedSuggestion' => 'false',
            'session_key'       => trim($username),
            'session_password'  => trim($password),
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

        curl_setopt($ch, CURLOPT_URL, "https://www.linkedin.com/uas/login-submit");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

        $store = curl_exec($ch);


        $parsed   = $this->get_string_between($store, 'publicIdentifier', 'picture');
        $user_url = "https://www.linkedin.com/in/" . $this->get_string_between($parsed, ':&quot;', '&quot;,');

        // TO REMOVE
        $user_url = "https://www.linkedin.com/in/jarjinimohamed/";

        curl_setopt($ch, CURLOPT_URL, $user_url);

        $user_profile = curl_exec($ch);

        $pre_delimiter  = "{&quot;data&quot;:{&quot;patentView";
        $post_delimiter = "MiniProfile&quot;}]}";
        $user_data      = $pre_delimiter . $this->get_string_between($user_profile, $pre_delimiter, $post_delimiter) . $post_delimiter;
        //   var_dump(json_encode($this->get_string_between($user_profile, $pre_delimiter, $post_delimiter),true));
        //  var_dump(explode("[\"day\"]",$user_data));
        $new_user_data = strip_tags($user_data);
        // echo $user_data;
        $formations = (explode("degreeName", $user_data));
        $list_f     = [];
        foreach ($formations as $key => $value) {
            # code...
            if ($key == 0) {
                $forma  = $formations[$key];
                $niveau = explode(",", $forma);
                // echo $forma;
                // break;
                continue;
            }
            if ($key == count($formations) - 1) {
                // var_dump($niveau);
            }
            $forma  = $formations[$key];
            $niveau = explode(",", $forma);

            $school = explode("schoolName", $niveau[1]);
            //echo $value;
            if (count($school) == 2) {
                $university = $school[1];
                $branche    = explode("fieldOfStudy", $niveau[2]);
                $type_study = $branche[1];

            } else {
                $branche      = explode("fieldOfStudy", $niveau[1]);
                $type_study   = isset($branche[1]) ? $branche[1] : "";
                $study_id     = explode("schoolUrn", $niveau[2]);
                $study_id_new = isset($study_id[1]) ? explode(":", $study_id[1]) : "";
                $string       = isset($study_id_new[4]) ? preg_replace('/[^A-Za-z0-9\-]/', '', $study_id_new[4]) : "";
                $ID_New       = str_replace("quot", "", $string);
                $name_univer  = explode('' . trim($ID_New) . ',logo,com.linkedin.voyager.common.MediaProcessorImage', $user_data);
                //var_dump($name_univer);
                $step_univer = explode(",", $name_univer[2]);
                $step_univer = explode(":", $step_univer[1]);
                $university  = $step_univer[1];
                //break;

            }
            $university = $this->get_string_between($value, "schoolName", ",");

            if ($key == 1) {
                $format      = $formations[0];
                $niveau_last = explode(",", $format);
                $id          = $niveau_last[count($niveau_last) - 3];
            } else {
                $format      = $formations[$key - 1];
                $niveau_last = explode(",", $format);
                // $id=isset($niveau_last[20]) ? $niveau_last[20]:"";
                $id = $this->getIdInarray($niveau_last);
            }
            //echo $id."fff <br>";

            $list_f[] = [
                'niveau'     => $this->getIdCourse1($niveau[0]),
                'type'       => $this->getIdCourse1($type_study),
                "university" => $this->getIdCourse1($university),
                "start_y"    => $this->getIdCourse1($this->getStartdate($user_data, $this->getIdCourse($id))),
                "end_y"      => $this->getIdCourse1($this->getEnddate($user_data, $this->getIdCourse($id)))
            ];

        }


        /*get experiences*/
        $experiences = (explode("locationName", $user_data));
        $list_exp    = [];
        foreach ($experiences as $key => $item) {
            if ($key == 0) {
                continue;
            }
            $exp    = $experiences[$key];
            $niveau = explode(",", $exp);


        }
        $experiences = (explode("companyName", $user_data));
        foreach ($experiences as $key => $item) {
            if ($key == 0) {
                continue;
            }
            $exp    = $experiences[$key];
            $niveau = explode(",", $exp);
            // var_dump($niveau);

            $id         = $this->getIdCourse($niveau[2]);
            $bille      = $this->getVilleInArray($niveau);
            $list_exp[] = [
                'ville'         => $this->getIdCourse1($bille),
                'entreprise'    => $this->getIdCourse1($niveau[0]),
                'titre_mission' => $this->getIdCourse1($niveau[7]),
                "description"   => $this->getIdCourse1(explode(':', $niveau[4])[1]),
                "logo"          => "/assets/img/logo_post.png",
                "start_y"       => $this->getIdCourse1($this->getStartdateExp($user_data, $this->getIdCourse($id))),
                "start_m"       => $this->getIdCourse1($this->getStartdateExpMonth($user_data, $this->getIdCourse($id))),
                "end_y"         => $this->getIdCourse1($this->getEnddateExp($user_data, $this->getIdCourse($id))),
                "end_m"         => $this->getIdCourse1($this->getEnddateExp($user_data, $this->getIdCourse($id)))
            ];
        }
        $list_comp = [];

        $this->session->set_userdata('format', $list_f);
        $this->session->set_userdata('exp', $list_exp);
        $this->session->set_userdata('competence', $list_comp);
        $this->session->set_userdata('profil-public', $user_url);


        $user_hash = $this->get_string_between($user_profile, $pre_delimiter, $post_delimiter);

        $position_url = "https://www.linkedin.com/voyager/api/identity/profiles/" . $user_hash . "/positions?count=5&start=5";

        curl_setopt($ch, CURLOPT_URL, $position_url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

        /// GET POSISITON AJAX
        ///
        $linkedin_ref = "https://www.linkedin.com";

        $chpos = curl_init();
        curl_setopt($chpos, CURLOPT_URL, $position_url);
        curl_setopt($chpos, CURLOPT_REFERER, $linkedin_ref);
        curl_setopt($chpos, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7)');
        curl_setopt($chpos, CURLOPT_AUTOREFERER, true);
        curl_setopt($chpos, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chpos, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($chpos, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($chpos, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($chpos, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($chpos, CURLOPT_COOKIEFILE, 'cookie.txt');

        curl_setopt($chpos, CURLOPT_HTTPHEADER, [
            ":authority"       => "www.linkedin.com",
            ":method"          => "GET",
            "Host"             => "linkedin.com",
            "Accept"           => "application/vnd.linkedin.normalized+json",
            "Accept-Language"  => "fr,ru;q=0.8,en-US;q=0.6,en;q=0.4",
            "Accept-Encoding"  => "gzip, deflate, br",
            "Accept-Charset"   => "ISO-8859-1,utf-8;q=0.7,*;q=0.7",
            "Keep-Alive"       => "115",
            "Connection"       => "keep-alive",
            "X-Requested-With" => "XMLHttpRequest",
            "csrf-token"       => $var['csrfToken'],
            "Referer"          => "https://www.linkedin.com/"
        ]);


        $position_data = curl_exec($chpos);
        // echo $position_data;

        $information = curl_getinfo($chpos);
        //var_dump($information);
        echo $information["url"];
        /*mes skills*/
        //  echo $information["url"];
        $skills     = explode("com.linkedin.voyager.identity.profile.Skill", $information["url"]);
        $list_skill = [];
        //var_dump($skills);
        foreach ($skills as $key => $skill) {
            if ($key == 0) {
                $skill = $this->getSkill($skill);
            } else {
                $skill = $this->getSkill($skill);
            }
            if ($key != count($skills) - 2 && $key != count($skills) - 1) {
                $list_skill[] = ["name" => $skill];
            }

        }

        $this->session->set_userdata('list_skill', $list_skill);

        //   redirect(base_url()."mentor/step2");


    }

    private function getSkill($skill)
    {
        $skill = explode("name", $skill);
        if ($skill > 0) {
            $new_skill = $skill[count($skill) - 1];
            // return $new_skill;
            $new_skill = explode("type", $new_skill);

            return str_replace(",$", "", $this->getIdCourse1($new_skill[0]));

        } else {
            return "";
        }
    }

    private function getSkill1($skill)
    {
        $skill = explode("name", $skill);
        if ($skill > 0) {
            return $skill[count($skill) - 1];
        } else {
            return "";
        }
    }

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

    // Fetches the CSRF for login authentication
    private function fetchCSRF()
    {
        $url      = 'https://linkedin.com/uas/login';
        $html     = file_get_contents($url);
        $precsrf  = (int)strpos($html, '<input type="hidden" name="loginCsrfParam" value="');
        $postcsrf = (int)strpos($html, '" id="loginCsrfParam-login">');
        $length   = $postcsrf - $precsrf - 50; // The -50 / + 50 is to correct for: <input type="hidden" name="login...
        $csrf     = substr($html, $precsrf + 50, $length);
        if ($csrf == false) {
            return false;
        }

        return $csrf;
    }

    public function loginpo()
    {


        $username = $this->input->post("email");
        $password = $this->input->post("password");

        $linkedin_login_page = "https://www.linkedin.com/uas/login";
        $linkedin_ref        = "https://www.linkedin.com";


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $linkedin_login_page);
        curl_setopt($ch, CURLOPT_REFERER, $linkedin_ref);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7)');
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');


        $login_content = curl_exec($ch);


        if (curl_error($ch)) {
            echo 'error:' . curl_error($ch);
        }

        $var                   = [
            'isJsEnabled'       => 'false',
            'source_app'        => '',
            'clickedSuggestion' => 'false',
            'session_key'       => trim($username),
            'session_password'  => trim($password),
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

        curl_setopt($ch, CURLOPT_URL, "https://www.linkedin.com/uas/login-submit");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

        $store = curl_exec($ch);


        $parsed   = $this->get_string_between($store, 'publicIdentifier', 'picture');
        $user_url = "https://www.linkedin.com/in/" . $this->get_string_between($parsed, ':&quot;', '&quot;,');

        // TO REMOVE

        curl_setopt($ch, CURLOPT_URL, $user_url);

        $user_profile = curl_exec($ch);

        $pre_delimiter  = "{&quot;data&quot;:{&quot;patentView";
        $post_delimiter = "MiniProfile&quot;}]}";
        $user_data      = $pre_delimiter . $this->get_string_between($user_profile, $pre_delimiter, $post_delimiter) . $post_delimiter;

        $new_user_data = strip_tags($user_data);
        $formations    = (explode("degreeName", $user_data));
        $list_f        = [];
        foreach ($formations as $key => $value) {
            # code...
            if ($key == 0) {
                $forma  = $formations[$key];
                $niveau = explode(",", $forma);
                continue;
            }
            $forma  = $formations[$key];
            $niveau = explode(",", $forma);

            $school = explode("schoolName", $niveau[1]);
            //echo $value;
            if (count($school) == 2) {
                $university = $school[1];
                $branche    = explode("fieldOfStudy", $niveau[2]);
                $type_study = $branche[1];

            } else {
                $branche      = explode("fieldOfStudy", $niveau[1]);
                $type_study   = isset($branche[1]) ? $branche[1] : "";
                $study_id     = explode("schoolUrn", $niveau[2]);
                $study_id_new = isset($study_id[1]) ? explode(":", $study_id[1]) : "";
                $string       = isset($study_id_new[4]) ? preg_replace('/[^A-Za-z0-9\-]/', '', $study_id_new[4]) : "";
                $ID_New       = str_replace("quot", "", $string);
                $name_univer  = explode('' . trim($ID_New) . ',logo,com.linkedin.voyager.common.MediaProcessorImage', $user_data);
                $step_univer  = explode(",", $name_univer[2]);
                $step_univer  = explode(":", $step_univer[1]);
                $university   = $step_univer[1];

            }
            $university = $this->get_string_between($value, "schoolName", ",");

            if ($key == 1) {
                $format      = $formations[0];
                $niveau_last = explode(",", $format);
                $id          = $niveau_last[count($niveau_last) - 3];
            } else {
                $format      = $formations[$key - 1];
                $niveau_last = explode(",", $format);
                $id          = isset($niveau_last[20]) ? $niveau_last[20] : "";
            }
            //echo $id."fff <br>";

            $list_f[] = [
                'niveau'     => $this->getIdCourse1($niveau[0]),
                'type'       => $this->getIdCourse1($type_study),
                "university" => $this->getIdCourse1($university),
                "start_y"    => $this->getIdCourse1($this->getStartdate($user_data, $this->getIdCourse($id))),
                "end_y"      => $this->getIdCourse1($this->getEnddate($user_data, $this->getIdCourse($id)))
            ];

        }


        /*get experiences*/
        $experiences = (explode("locationName", $user_data));
        $list_exp    = [];

        foreach ($experiences as $key => $item) {
            if ($key == 0) {
                continue;
            }
            $exp    = $experiences[$key];
            $niveau = explode(",", $exp);


        }
        $experiences = (explode("companyName", $user_data));
        foreach ($experiences as $key => $item) {
            if ($key == 0) {
                continue;
            }
            $exp    = $experiences[$key];
            $niveau = explode(",", $exp);

            $id         = $this->getIdCourse($niveau[2]);
            $bille      = $this->getVilleInArray($niveau);
            $list_exp[] = [
                'ville'         => $this->getIdCourse1($bille),
                'entreprise'    => $this->getIdCourse1($niveau[0]),
                'titre_mission' => $this->getIdCourse1($niveau[7]),
                "description"   => $this->getIdCourse1(explode(':', $niveau[4])[1]),
                "logo"          => "/assets/img/logo_post.png",
                "start_y"       => $this->getIdCourse1($this->getStartdateExp($user_data, $this->getIdCourse($id))),
                "start_m"       => $this->getIdCourse1($this->getStartdateExpMonth($user_data, $this->getIdCourse($id))),
                "end_y"         => $this->getIdCourse1($this->getEnddateExp($user_data, $this->getIdCourse($id))),
                "end_m"         => $this->getIdCourse1($this->getEnddateExp($user_data, $this->getIdCourse($id)))
            ];

        }
        $list_comp = [];

        $this->session->set_userdata('format', $list_f);
        $this->session->set_userdata('exp', $list_exp);
        $this->session->set_userdata('competence', $list_comp);
        $this->session->set_userdata('profil-public', $user_url);


        $user_hash = $this->get_string_between($user_profile, $pre_delimiter, $post_delimiter);

        $position_url = "https://www.linkedin.com/voyager/api/identity/profiles/" . $user_hash . "/positions?count=5&start=5";

        curl_setopt($ch, CURLOPT_URL, $position_url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

        /// GET POSISITON AJAX
        ///
        $linkedin_ref = "https://www.linkedin.com";

        $chpos = curl_init();
        curl_setopt($chpos, CURLOPT_URL, $position_url);
        curl_setopt($chpos, CURLOPT_REFERER, $linkedin_ref);
        curl_setopt($chpos, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7)');
        curl_setopt($chpos, CURLOPT_AUTOREFERER, true);
        curl_setopt($chpos, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chpos, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($chpos, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($chpos, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($chpos, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($chpos, CURLOPT_COOKIEFILE, 'cookie.txt');

        curl_setopt($chpos, CURLOPT_HTTPHEADER, [
            ":authority"       => "www.linkedin.com",
            ":method"          => "GET",
            "Host"             => "linkedin.com",
            "Accept"           => "application/vnd.linkedin.normalized+json",
            "Accept-Language"  => "fr,ru;q=0.8,en-US;q=0.6,en;q=0.4",
            "Accept-Encoding"  => "gzip, deflate, br",
            "Accept-Charset"   => "ISO-8859-1,utf-8;q=0.7,*;q=0.7",
            "Keep-Alive"       => "115",
            "Connection"       => "keep-alive",
            "X-Requested-With" => "XMLHttpRequest",
            "csrf-token"       => $var['csrfToken'],
            "Referer"          => "https://www.linkedin.com/"
        ]);


        $position_data = curl_exec($chpos);
        // echo $position_data;

        $information = curl_getinfo($chpos);
        //var_dump($information);
        //  echo $information["url"];
        //get list logo entreprise
        $list_logo = explode("attribution", $information["url"]);
        $list_log  = [];
        foreach ($list_logo as $key => $logo) {
            if ($key == 0 or $key == 1 or $key == 2) {
                continue;
            }
            $logo_item = explode(",", $logo);


            $logo_final  = explode(":", $logo_item[1]);
            $type        = explode("type", $logo);
            $id_for_name = explode("id", $type[1]);
            //var_dump($logo_item);
            $id_for_name1    = explode("}", $id_for_name[1]);
            $name_entreprise = $this->getNameEntrepriseBy($id_for_name1[0], $information["url"]);
            $list_log[]      = ["name" => $this->getIdCourse1($logo_final[1]), "slug" => $id_for_name1[0], "name_entreprise" => $name_entreprise];

            # code...
        }

        /*mes skills*/

        $skills     = explode("com.linkedin.voyager.identity.profile.Skill", $information["url"]);
        $list_skill = [];
        //var_dump($skills);
        foreach ($skills as $key => $skill) {
            if ($key == 0) {
                $skill = $this->getSkill($skill);
            } else {
                $skill = $this->getSkill($skill);
            }
            if ($key != count($skills) - 2 && $key != count($skills) - 1) {
                $list_skill[] = ["name" => $skill];
            }

        }

        $this->session->set_userdata('list_skill', $list_skill);
        $this->session->set_userdata('list_log', $list_log);
        redirect(base_url() . "mentor/etape1");


    }


    public function login()
    {
        /* getUserInfos */

        $username = 'camille.ulyss@gmail.com';
        $password = 'mymentor';

        $linkedin_login_page = "https://www.linkedin.com/uas/login";
        $linkedin_ref        = "https://www.linkedin.com";


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $linkedin_login_page);
        curl_setopt($ch, CURLOPT_REFERER, $linkedin_ref);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7)');
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');


        $login_content = curl_exec($ch);


        if (curl_error($ch)) {
            echo 'error:' . curl_error($ch);
        }

        $var                   = [
            'isJsEnabled'       => 'false',
            'source_app'        => '',
            'clickedSuggestion' => 'false',
            'session_key'       => trim($username),
            'session_password'  => trim($password),
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

        curl_setopt($ch, CURLOPT_URL, "https://www.linkedin.com/uas/login-submit");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

        $store = curl_exec($ch);


        $parsed   = $this->get_string_between($store, 'publicIdentifier', 'picture');
        $user_url = "https://www.linkedin.com/in/benoitkourot/";

        // TO REMOVE
        // $user_url = "https://www.linkedin.com/in/freddycimper/";
        //  $user_url = "https://www.linkedin.com/in/eric-maharibatcha-74987431/";


        curl_setopt($ch, CURLOPT_URL, $user_url);

        $user_profile = curl_exec($ch);

        $pre_delimiter  = "{&quot;data&quot;:{&quot;patentView";
        $post_delimiter = "MiniProfile&quot;}]}";
        $user_data      = $pre_delimiter . $this->get_string_between($user_profile, $pre_delimiter, $post_delimiter) . $post_delimiter;
        $formations     = (explode("degreeName", $user_data));
        $list_f         = [];
        foreach ($formations as $key => $value) {
            # code...
            if ($key == 0) {
                $forma  = $formations[$key];
                $niveau = explode(",", $forma);
                continue;
            }
            if ($key == count($formations) - 1) {
            }
            $forma  = $formations[$key];
            $niveau = explode(",", $forma);

            $school = explode("schoolName", $niveau[1]);
            //echo $value;
            if (count($school) == 2) {
                $university = $school[1];
                $branche    = explode("fieldOfStudy", $niveau[2]);
                $type_study = isset($branche[1]) ? $branche[1] : "";

            } else {
                $branche      = explode("fieldOfStudy", $niveau[1]);
                $type_study   = isset($branche[1]) ? $branche[1] : "";
                $study_id     = explode("schoolUrn", $niveau[2]);
                $study_id_new = isset($study_id[1]) ? explode(":", $study_id[1]) : "";
                $string       = isset($study_id_new[4]) ? preg_replace('/[^A-Za-z0-9\-]/', '', $study_id_new[4]) : "";
                $ID_New       = str_replace("quot", "", $string);
                $name_univer  = explode('' . trim($ID_New) . ',logo,com.linkedin.voyager.common.MediaProcessorImage', $user_data);
                $step_univer  = explode(",", $name_univer[2]);
                $step_univer  = explode(":", $step_univer[1]);
                $university   = $step_univer[1];
                //break;

            }
            $university = $this->get_string_between($value, "schoolName", ",");
            if ($university == "") {
                $univer_exp = explode("schoolName", $formations[$key - 1]);
                $university = $this->get_string_between($univer_exp[1], ":", ",");
            }
            if ($key == 1) {
                $format      = $formations[0];
                $niveau_last = explode(",", $format);
                $id          = $niveau_last[count($niveau_last) - 3];
            } else {
                $format      = $formations[$key - 1];
                $niveau_last = explode(",", $format);
                //   $id=isset($niveau_last[20]) ? $niveau_last[20]:"";
                $id = $this->getIdInarray($niveau_last);
            }
            //echo $id."fff <br>";

            $list_f[] = [
                'niveau'     => $this->getIdCourse1($niveau[0]),
                'type'       => $this->getIdCourse1($type_study),
                "university" => $this->getIdCourse1($university),
                "start_y"    => $this->getIdCourse1($this->getStartdate($user_data, $this->getIdCourse($id))),
                "end_y"      => $this->getIdCourse1($this->getEnddate($user_data, $this->getIdCourse($id)))
            ];

        }

        /*get experiences*/
        $experiences = (explode("locationName", $user_data));
        $list_exp    = [];
        foreach ($experiences as $key => $item) {
            if ($key == 0) {
                continue;
            }
            $exp    = $experiences[$key];
            $niveau = explode(",", $exp);
        }

        $experiences = (explode("companyName", $user_data));
        foreach ($experiences as $key => $item) {
            if ($key == 0) {
                continue;
            }

            $exp                = $experiences[$key];
            $item_id_entreprise = '';
            $niveau             = explode(",", $exp);
            $description        = explode("description", $exp);
            $description_last   = isset($description[1]) ? explode("company", $description[1]) : "";
            if (isset($description_last[0]) && count(explode("title", $description_last[0])) > 0) {
                $description_last[0] = explode("title", $description_last[0])[0];
            }

            /* id entreprise */
            foreach ($niveau as $key => $_niveau) {
                if (stristr($_niveau, 'urn:li:fs_miniCompany')) {
                    $item_id_entreprise = $niveau[$key];
                    break;
                }
            }
            $item_id_entreprise = $this->get_string_between($item_id_entreprise, 'fs_miniCompany:', '&quot;');
            $secteurId          = [];

            /* Secteur Label */
            if ($item_id_entreprise != '') {
                $re = '/miniCompany":"urn:li:fs_miniCompany:(.+?)","industries":\["(.+?)"\]/';
                preg_match_all($re, html_entity_decode($exp), $matches, PREG_SET_ORDER);
                if (is_array($matches)) {
                    foreach ($matches as $matche) {
                        $secteurId[$matche[1]] = $matche[2];
                    }
                }
            }

            $id         = $this->getIdCourse($niveau[2]);
            $bille      = $this->getVilleInArray($niveau);
            $des_ulyss1 = isset($description_last[0]) ? $this->getIdCourse1($description_last[0]) : "";
            $new_ulysss = explode("organizations", $des_ulyss1);
            if (count($new_ulysss) > 1) {
                $description_ulyss = "";
            } else {
                $description_ulyss = $des_ulyss1;
            }
            $list_exp[] = [
                'ville'         => $this->getIdCourse1($bille),
                'entreprise'    => $this->getIdCourse1($niveau[0]),
                'id_entreprise' => $item_id_entreprise,
                'secteur_nom'   => isset($secteurId[$item_id_entreprise]) ? $secteurId[$item_id_entreprise] : '',
                'titre_mission' => $this->getIdCourse1($niveau[7]),
                "description"   => $description_ulyss,
                "logo"          => "/assets/img/logo_post.png",
                "start_y"       => $this->getIdCourse1($this->getStartdateExp($user_data, $this->getIdCourse($id))),
                "start_m"       => $this->getIdCourse1($this->getStartdateExpMonth($user_data, $this->getIdCourse($id))),
                "date_debut"    => $this->getIdCourse1($this->getEnddateExp($user_data, $this->getIdCourse($id))) . "-" . $this->getIdCourse1($this->getEnddateExp($user_data,
                        $this->getIdCourse($id))) . "01",
                "end_y"         => $this->getIdCourse1($this->getEnddateExp($user_data, $this->getIdCourse($id))),
                "end_m"         => $this->getIdCourse1($this->getEnddateExpMonth($user_data, $this->getIdCourse($id)))
            ];
        }
        $list_comp = [];
        $this->session->set_userdata('format', $list_f);
        $this->session->set_userdata('exp', $list_exp);
        $this->session->set_userdata('competence', $list_comp);
        $this->session->set_userdata('profil-public', $user_url);


        $user_hash = $this->get_string_between($user_profile, $pre_delimiter, $post_delimiter);

        $position_url = "https://www.linkedin.com/voyager/api/identity/profiles/" . $user_hash . "/positions?count=5&start=5";

        curl_setopt($ch, CURLOPT_URL, $position_url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

        /// GET POSISITON AJAX
        ///
        $linkedin_ref = "https://www.linkedin.com";

        $chpos = curl_init();
        curl_setopt($chpos, CURLOPT_URL, $position_url);
        curl_setopt($chpos, CURLOPT_REFERER, $linkedin_ref);
        curl_setopt($chpos, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7)');
        curl_setopt($chpos, CURLOPT_AUTOREFERER, true);
        curl_setopt($chpos, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chpos, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($chpos, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($chpos, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($chpos, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($chpos, CURLOPT_COOKIEFILE, 'cookie.txt');

        curl_setopt($chpos, CURLOPT_HTTPHEADER, [
            ":authority"       => "www.linkedin.com",
            ":method"          => "GET",
            "Host"             => "linkedin.com",
            "Accept"           => "application/vnd.linkedin.normalized+json",
            "Accept-Language"  => "fr,ru;q=0.8,en-US;q=0.6,en;q=0.4",
            "Accept-Encoding"  => "gzip, deflate, br",
            "Accept-Charset"   => "ISO-8859-1,utf-8;q=0.7,*;q=0.7",
            "Keep-Alive"       => "115",
            "Connection"       => "keep-alive",
            "X-Requested-With" => "XMLHttpRequest",
            "csrf-token"       => $var['csrfToken'],
            "Referer"          => "https://www.linkedin.com/"
        ]);


        $position_data = curl_exec($chpos);
        // echo $position_data;

        $information = curl_getinfo($chpos);
        //var_dump($information);
        //  echo $information["url"];
        //get list logo entreprise
        $list_logo = explode("attribution", $information["url"]);
        $list_log  = [];
        foreach ($list_logo as $key => $logo) {
            if ($key == 0) {
                continue;
            }
            $logo_item = explode(",", $logo);


            $logo_final  = explode(":", $logo_item[1]);
            $type        = explode("type", $logo);
            $id_for_name = explode("id", $type[1]);
            //var_dump($logo_item);
            $id_for_name1      = explode("}", $id_for_name[1]);
            $name_entreprise   = $this->getNameEntrepriseBy($id_for_name1[0], $information["url"]);
            $verification_logo = explode("fs_miniCompany", $id_for_name1[0]);
            if (count($verification_logo) > 1) {
                $list_log[] = ["name" => $this->getIdCourse1($logo_final[1]), "slug" => $id_for_name1[0], "name_entreprise" => $name_entreprise];
            }
            # code...
        }
        //  var_dump($list_log);
        /*mes skills*/

        $skills     = explode("com.linkedin.voyager.identity.profile.Skill", $information["url"]);
        $list_skill = [];
        //var_dump($skills);
        foreach ($skills as $key => $skill) {
            if ($key == 0) {
                $skill = $this->getSkill($skill);
            } else {
                $skill = $this->getSkill($skill);
            }
            if ($key != count($skills) - 2 && $key != count($skills) - 1) {
                $list_skill[] = ["name" => $skill];
            }

        }

        $this->session->set_userdata('list_skill', $list_skill);
        $this->session->set_userdata('list_log', $list_log);
        $list_exp_v   = $this->msort($list_exp, ['date_debut']);
        $list_exp_v1  = array_reverse($list_exp_v, true);
        $list_exp_new = [];
        foreach ($list_exp_v1 as $key => $item) {
            $logo           = $this->user_info->getPictureEntreprise($list_log, $item["entreprise"]);
            $list_exp_new[] = [
                'ville'         => $item["ville"],
                'entreprise'    => $item["entreprise"],
                'titre_mission' => $item["titre_mission"],
                "description"   => rtrim($item["description"], ","),
                "logo"          => $logo,
                "start_y"       => $item["start_y"],
                "start_m"       => $item["start_m"],
                "end_y"         => $item["end_y"],
                "end_m"         => $item["end_m"],
                'id_entreprise' => $item["id_entreprise"],
                'secteur_nom'   => isset($secteurId[$item["id_entreprise"]]) ? $secteurId[$item["id_entreprise"]] : '',
            ];
        }

        $this->session->set_userdata('exp', $list_exp_new);
        redirect(base_url() . "mentor/etape1");


    }

    function msort($array, $key, $sort_flags = SORT_ASC)
    {
        if (is_array($array) && count($array) > 0) {
            if (!empty($key)) {
                $mapping = [];
                foreach ($array as $k => $v) {
                    $sort_key = '';
                    if (!is_array($key)) {
                        $sort_key = $v[$key];
                    } else {
                        // @TODO This should be fixed, now it will be sorted as string
                        foreach ($key as $key_key) {
                            $sort_key .= $v[$key_key];
                        }
                        $sort_flags = SORT_ASC;
                    }
                    $mapping[$k] = $sort_key;
                }
                asort($mapping, $sort_flags);
                $sorted = [];
                foreach ($mapping as $k => $v) {
                    $sorted[] = $array[$k];
                }

                return $sorted;
            }
        }

        return $array;
    }

    public function getIdInarray($list)
    {
        foreach ($list as $key => $item) {
            if (strpos($item, ")") && 1 === preg_match('~[0-9][0-9]~', $item)) {
                $id = $this->getIdCourse($item);

                //echo $id;
                return $item;


            }
            # code...
        }

        return "";

    }

    public function login6()
    {


        $username = $this->input->post("email");
        $password = $this->input->post("password");

        $linkedin_login_page = "https://www.linkedin.com/uas/login";
        $linkedin_ref        = "https://www.linkedin.com";


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $linkedin_login_page);
        curl_setopt($ch, CURLOPT_REFERER, $linkedin_ref);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7)');
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');


        $login_content = curl_exec($ch);


        if (curl_error($ch)) {
            echo 'error:' . curl_error($ch);
        }

        $var                   = [
            'isJsEnabled'       => 'false',
            'source_app'        => '',
            'clickedSuggestion' => 'false',
            'session_key'       => trim($username),
            'session_password'  => trim($password),
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

        curl_setopt($ch, CURLOPT_URL, "https://www.linkedin.com/uas/login-submit");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

        $store = curl_exec($ch);


        $parsed   = $this->get_string_between($store, 'publicIdentifier', 'picture');
        $user_url = "https://www.linkedin.com/in/" . $this->get_string_between($parsed, ':&quot;', '&quot;,');

        // TO REMOVE
        $user_url = "https://www.linkedin.com/in/oualid-tahaoui-38383311/";

        curl_setopt($ch, CURLOPT_URL, $user_url);

        $user_profile = curl_exec($ch);

        $pre_delimiter  = "{&quot;data&quot;:{&quot;patentView";
        $post_delimiter = "MiniProfile&quot;}]}";
        $user_data      = $pre_delimiter . $this->get_string_between($user_profile, $pre_delimiter, $post_delimiter) . $post_delimiter;
        //   var_dump(json_encode($this->get_string_between($user_profile, $pre_delimiter, $post_delimiter),true));
        //  var_dump(explode("[\"day\"]",$user_data));
        $new_user_data = strip_tags($user_data);
        // echo $user_data;
        $formations = (explode("degreeName", $user_data));
        $list_f     = [];
        foreach ($formations as $key => $value) {
            # code...
            if ($key == 0) {
                $forma  = $formations[$key];
                $niveau = explode(",", $forma);
                // echo $forma;
                // break;
                continue;
            }
            if ($key == count($formations) - 1) {
                // var_dump($niveau);
            }
            $forma  = $formations[$key];
            $niveau = explode(",", $forma);

            $school = explode("schoolName", $niveau[1]);
            //echo $value;
            if (count($school) == 2) {
                $university = $school[1];
                $branche    = explode("fieldOfStudy", $niveau[2]);
                $type_study = isset($branche[1]) ? $branche[1] : "";

            } else {
                $branche      = explode("fieldOfStudy", $niveau[1]);
                $type_study   = isset($branche[1]) ? $branche[1] : "";
                $study_id     = explode("schoolUrn", $niveau[2]);
                $study_id_new = isset($study_id[1]) ? explode(":", $study_id[1]) : "";
                $string       = isset($study_id_new[4]) ? preg_replace('/[^A-Za-z0-9\-]/', '', $study_id_new[4]) : "";
                $ID_New       = str_replace("quot", "", $string);
                $name_univer  = explode('' . trim($ID_New) . ',logo,com.linkedin.voyager.common.MediaProcessorImage', $user_data);
                //var_dump($name_univer);
                $step_univer = explode(",", $name_univer[2]);
                $step_univer = explode(":", $step_univer[1]);
                $university  = $step_univer[1];
                //break;

            }
            $university = $this->get_string_between($value, "schoolName", ",");
            if ($university == "") {
                $univer_exp = explode("schoolName", $formations[$key - 1]);
                $university = $this->get_string_between($univer_exp[1], ":", ",");
            }
            echo $university;
            if ($key == 1) {
                $format      = $formations[0];
                $niveau_last = explode(",", $format);
                $id          = $niveau_last[count($niveau_last) - 3];
            } else {
                $format      = $formations[$key - 1];
                $niveau_last = explode(",", $format);
                // $id=isset($niveau_last[20]) ? $niveau_last[20]:"";
                $id = $this->getIdInarray($niveau_last);
                //var_dump($niveau_last);
            }
            //echo $id."fff <br>";

            $list_f[] = [
                'niveau'     => $this->getIdCourse1($niveau[0]),
                'id'         => $id,
                'type'       => $this->getIdCourse1($type_study),
                "university" => $this->getIdCourse1($university),
                "start_y"    => $this->getIdCourse1($this->getStartdate($user_data, $this->getIdCourse($id))),
                "end_y"      => $this->getIdCourse1($this->getEnddate($user_data, $this->getIdCourse($id)))
            ];

        }


        /*get experiences*/
        $experiences = (explode("locationName", $user_data));
        $list_exp    = [];

        foreach ($experiences as $key => $item) {
            if ($key == 0) {
                continue;
            }
            $exp    = $experiences[$key];
            $niveau = explode(",", $exp);


        }
        $experiences = (explode("companyName", $user_data));
        foreach ($experiences as $key => $item) {
            if ($key == 0) {
                continue;
            }
            $exp    = $experiences[$key];
            $niveau = explode(",", $exp);
            // var_dump($niveau);
            $description      = explode("description", $exp);
            $description_last = isset($description[1]) ? explode("company", $description[1]) : "";

            $id    = $this->getIdCourse($niveau[2]);
            $bille = $this->getVilleInArray($niveau);
            if (isset($description_last[0]) && count(explode("titleFondateur", $description_last[0])) > 0) {
                $description_last[0] = explode("titleFondateur", $description_last[0])[0];
            }

            $list_exp[] = [
                'ville'         => $this->getIdCourse1($bille),
                'entreprise'    => $this->getIdCourse1($niveau[0]),
                'titre_mission' => $this->getIdCourse1($niveau[7]),
                // "description"=>$this->getIdCourse1(explode(':', $niveau[4])[1]),
                "description"   => isset($description_last[0]) ? $description_last[0] : "",
                "logo"          => "/assets/img/logo_post.png",
                "start_y"       => $this->getIdCourse1($this->getStartdateExp($user_data, $this->getIdCourse($id))),
                "start_m"       => $this->getIdCourse1($this->getStartdateExpMonth($user_data, $this->getIdCourse($id))),
                "end_y"         => $this->getIdCourse1($this->getEnddateExp($user_data, $this->getIdCourse($id))),
                "end_m"         => $this->getIdCourse1($this->getEnddateExp($user_data, $this->getIdCourse($id)))
            ];
        }
        $list_comp = [];

        $this->session->set_userdata('format', $list_f);
        $this->session->set_userdata('exp', $list_exp);
        $this->session->set_userdata('competence', $list_comp);
        $this->session->set_userdata('profil-public', $user_url);


        $user_hash = $this->get_string_between($user_profile, $pre_delimiter, $post_delimiter);

        $position_url = "https://www.linkedin.com/voyager/api/identity/profiles/" . $user_hash . "/positions?count=5&start=5";

        curl_setopt($ch, CURLOPT_URL, $position_url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);

        /// GET POSISITON AJAX
        ///
        $linkedin_ref = "https://www.linkedin.com";

        $chpos = curl_init();
        curl_setopt($chpos, CURLOPT_URL, $position_url);
        curl_setopt($chpos, CURLOPT_REFERER, $linkedin_ref);
        curl_setopt($chpos, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.0; en-US; rv:1.7.12) Gecko/20050915 Firefox/1.0.7)');
        curl_setopt($chpos, CURLOPT_AUTOREFERER, true);
        curl_setopt($chpos, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chpos, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($chpos, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($chpos, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($chpos, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($chpos, CURLOPT_COOKIEFILE, 'cookie.txt');

        curl_setopt($chpos, CURLOPT_HTTPHEADER, [
            ":authority"       => "www.linkedin.com",
            ":method"          => "GET",
            "Host"             => "linkedin.com",
            "Accept"           => "application/vnd.linkedin.normalized+json",
            "Accept-Language"  => "fr,ru;q=0.8,en-US;q=0.6,en;q=0.4",
            "Accept-Encoding"  => "gzip, deflate, br",
            "Accept-Charset"   => "ISO-8859-1,utf-8;q=0.7,*;q=0.7",
            "Keep-Alive"       => "115",
            "Connection"       => "keep-alive",
            "X-Requested-With" => "XMLHttpRequest",
            "csrf-token"       => $var['csrfToken'],
            "Referer"          => "https://www.linkedin.com/"
        ]);


        $position_data = curl_exec($chpos);
        //echo $position_data;

        $information = curl_getinfo($chpos);
        echo $information["url"];
        //get list logo entreprise
        $list_logo = explode("attribution", $information["url"]);
        $list_log  = [];
        foreach ($list_logo as $key => $logo) {
            if ($key == 0) {
                continue;
            }
            $logo_item = explode(",", $logo);


            $logo_final  = explode(":", $logo_item[1]);
            $type        = explode("type", $logo);
            $id_for_name = explode("id", $type[1]);
            //var_dump($logo_item);
            $id_for_name1      = explode("}", $id_for_name[1]);
            $name_entreprise   = $this->getNameEntrepriseBy($id_for_name1[0], $information["url"]);
            $verification_logo = explode("fs_miniCompany", $id_for_name1[0]);
            if (count($verification_logo) > 1) {
                $list_log[] = ["name" => $this->getIdCourse1($logo_final[1]), "slug" => $id_for_name1[0], "name_entreprise" => $name_entreprise];
            }
            # code...
        }
        //  var_dump($list_log);
        /*mes skills*/
        //echo $information["url"];
        $skills     = explode("com.linkedin.voyager.identity.profile.Skill", $information["url"]);
        $list_skill = [];
        //var_dump($skills);
        foreach ($skills as $key => $skill) {
            if ($key == 0) {
                $skill = $this->getSkill($skill);
            } else {
                $skill = $this->getSkill($skill);
            }
            if ($key != count($skills) - 2 && $key != count($skills) - 1) {
                $list_skill[] = ["name" => $skill];
            }

        }

        $this->session->set_userdata('list_skill', $list_skill);
        $this->session->set_userdata('list_log', $list_log);
        $list_exp_new = [];
        foreach ($list_exp as $key => $item) {
            $logo           = $this->user_info->getPictureEntreprise($list_log, $item["entreprise"]);
            $list_exp_new[] = [
                'ville'         => $item["ville"],
                'entreprise'    => $item["entreprise"],
                'titre_mission' => $item["titre_mission"],
                "description"   => $item["description"],
                "logo"          => $logo,
                "start_y"       => $item["start_y"],
                "start_m"       => $item["start_m"],
                "end_y"         => $item["end_y"],
                "end_m"         => $item["end_m"]
            ];
        }
        $this->session->set_userdata('exp', $list_exp_new);
    }

    public function getNameEntrepriseBy($id, $html)
    {
        $name = explode($id, $html);
        if (count($name) < 1) {
            return "";
        }
        $university_log = explode("name", $name[1]);
        if (count($university_log) < 1) {
            return "";
        }

        $university_log1 = explode(",", $university_log[count($university_log) - 1]);
        if (count($university_log1[0]) >= 1) {
            return $this->getIdCourse1($university_log1[0]);
        } else {
            return "";
        }

        //var_dump($name);
        // return "";
    }

}
