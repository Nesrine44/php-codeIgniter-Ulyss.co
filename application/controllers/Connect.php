<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Connect extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->data['access'] = $this->config->item('api_key');
        $this->data['secret'] = $this->config->item('secret_key');

    }

    public function index($REFERRED_BY = 0)
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->session->set_userdata('last_v', $_SERVER['HTTP_REFERER']);
        }

        $this->data['callback'] = base_url() . "connect/receiver";
        $this->load->library('linkedin', $this->data);
        $this->linkedin->getRequestToken();
        $requestToken = serialize($this->linkedin->request_token);
        $this->session->set_userdata([
            'requestToken' => $requestToken
        ]);
        header("Location: " . $this->linkedin->generateAuthorizeUrl());

    }

    public function for2($REFERRED_BY = 0)
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->session->set_userdata('last_v', $_SERVER['HTTP_REFERER']);
        }

        $this->data['callback'] = base_url() . "connect/receiver1";
        $this->load->library('linkedin', $this->data);
        $this->linkedin->getRequestToken();
        $requestToken = serialize($this->linkedin->request_token);
        $this->session->set_userdata([
            'requestToken' => $requestToken
        ]);
        header("Location: " . $this->linkedin->generateAuthorizeUrl());

    }

    public function receiver()
    {

        if (isset($_GET['oauth_problem'])) {
            session_unset();
            $this->session->set_flashdata(
                'linkedinError',
                [
                    'type' => 'error',
                    'msg'  => 'Sorry! Something went wrong this time. Please try again later.'
                ]
            );
            redirect('.');
            exit;
        }

        $this->load->library('linkedin', [
            'access' => $this->data['access'],//"<your Consumer Key / API Key goes here>",
            'secret' => $this->data['secret'],//"<your Consumer Secret / Secret Key goes here>"
        ]);

        // get from session
        if (!$this->session->userdata('requestToken')) {
            redirect(base_url());
        }
        $requestToken = $this->session->userdata('requestToken');

        if ($this->input->get('oauth_verifier')) {
            $oauthVerifier                  = $this->input->get('oauth_verifier');
            $this->linkedin->request_token  = unserialize($requestToken);
            $this->linkedin->oauth_verifier = $oauthVerifier;
            $this->linkedin->getAccessToken($oauthVerifier);
            // set in session
            $this->session->set_userdata([
                'oauth_verifier'     => $oauthVerifier,
                'oauth_access_token' => serialize($this->linkedin->access_token)
            ]);
        } else {
            $oauthVerifier                  = $this->session->userdata('oauth_verifier');
            $oauthAccessToken               = $this->session->userdata('oauth_verifier');
            $this->linkedin->request_token  = unserialize($requestToken);
            $this->linkedin->oauth_verifier = $oauthVerifier;
            $this->linkedin->access_token   = unserialize($oauthAccessToken);
        }

        if ($this->input->get('oauth_verifier')) {
            $userData = $this->linkedin->getUserInfo(
                serialize($this->linkedin->request_token),
                $this->session->userdata('oauth_verifier'),
                $this->session->userdata('oauth_access_token')
            );

        } else {
            $userData['status'] = 404;
        }

        if (isset($userData['email-address'])) {
            $result = $this->user->GetUSERbYeMAIL($userData['email-address']);
            if (!$result) {
                if (isset($userData["first-name"])) {
                    $data['prenom'] = $userData["first-name"];
                }
                if (isset($userData["last-name"])) {
                    $data['nom'] = $userData["last-name"];
                }
                if (isset($userData["id"])) {
                    $data['uid'] = $userData["id"];
                }
                if (isset($userData["email-address"])) {
                    $data['email'] = $userData["email-address"];
                }
                if (isset($userData["public-profile-url"])) {
                    $data['public_profile_url'] = $userData["public-profile-url"];
                }
                if (isset($userData["picture-urls::(original)"])) {
                    $data['avatar'] = $userData["picture-urls::(original)"];
                }
                $data['type_sociaux'] = "linkedin";
                //create image facebook

                //create alias user
                if (isset($userData["first-name"])) {
                    $string        = $userData["first-name"] . "." . $userData["last-name"];
                    $data['alias'] = $this->create_alias($string);
                }
                $data['email_verified'] = true;

                //add user sociaux facebook
                $element = $this->user->AddUserSociauxFacebook($data);
                $this->autologin($element);
            } else {
                $this->autologin($result);
            }
        }
    }

    public function linkedauth()
    {       //optional
        $get = $this->input->get();
        print_r($get);
    }

    private function autologin($data)
    {

        $this->load->library('encrypt');

        $id = $this->encrypt->encode($data->id);


        $sess_array = [
            'id'           => $id,
            'email'        => $data->email,
            'avatar'       => $data->avatar,
            'name_complet' => $data->prenom . ' ' . $data->nom,

            'name' => $data->prenom . ' ' . strtoupper(substr($data->nom, 0, 1))
        ];
        $this->session->set_userdata('logged_in_site_web', $sess_array);
        if ($this->session->userdata('last_v')) {
            redirect($this->session->userdata('last_v'));
        } else {
            redirect(base_url() . "compte");
        }

    }

    private function autologin1($data)
    {
        $this->load->library('encrypt');

        $id = $this->encrypt->encode($data->id);


        $sess_array = [
            'id'           => $id,
            'email'        => $data->email,
            'avatar'       => $data->avatar,
            'name_complet' => $data->prenom . ' ' . $data->nom,

            'name' => $data->prenom . ' ' . strtoupper(substr($data->nom, 0, 1))
        ];
        $this->session->set_userdata('logged_in_site_web', $sess_array);

        redirect(base_url() . "mentor");


    }

    public function receiver1()
    {

        if (isset($_GET['oauth_problem'])) {
            session_unset();
            $this->session->set_flashdata(
                'linkedinError',
                [
                    'type' => 'error',
                    'msg'  => 'Sorry! Something went wrong this time. Please try again later.'
                ]
            );
            redirect('.');
            exit;
        }

        $this->load->library('linkedin', [
            'access' => $this->data['access'],//"<your Consumer Key / API Key goes here>",
            'secret' => $this->data['secret'],//"<your Consumer Secret / Secret Key goes here>" 
        ]);

        // get from session
        if (!$this->session->userdata('requestToken')) {
            redirect(base_url());
        }
        $requestToken = $this->session->userdata('requestToken');

        if ($this->input->get('oauth_verifier')) {
            $oauthVerifier                  = $this->input->get('oauth_verifier');
            $this->linkedin->request_token  = unserialize($requestToken);
            $this->linkedin->oauth_verifier = $oauthVerifier;
            $this->linkedin->getAccessToken($oauthVerifier);
            // set in session
            $this->session->set_userdata([
                'oauth_verifier'     => $oauthVerifier,
                'oauth_access_token' => serialize($this->linkedin->access_token)
            ]);
        } else {
            $oauthVerifier                  = $this->session->userdata('oauth_verifier');
            $oauthAccessToken               = $this->session->userdata('oauth_verifier');
            $this->linkedin->request_token  = unserialize($requestToken);
            $this->linkedin->oauth_verifier = $oauthVerifier;
            $this->linkedin->access_token   = unserialize($oauthAccessToken);
        }

        if ($this->input->get('oauth_verifier')) {
            $userData = $this->linkedin->getUserInfo(
                serialize($this->linkedin->request_token),
                $this->session->userdata('oauth_verifier'),
                $this->session->userdata('oauth_access_token')
            );

        } else {
            $userData['status'] = 404;
        }

        if (isset($userData['email-address'])) {
            $result = $this->user->GetUSERbYeMAIL($userData['email-address']);
            if (!$result) {
                if (isset($userData["first-name"])) {
                    $data['prenom'] = $userData["first-name"];
                }
                if (isset($userData["last-name"])) {
                    $data['nom'] = $userData["last-name"];
                }
                if (isset($userData["id"])) {
                    $data['uid'] = $userData["id"];
                }
                if (isset($userData["email-address"])) {
                    $data['email'] = $userData["email-address"];
                }
                if (isset($userData["public-profile-url"])) {
                    $data['public_profile_url'] = $userData["public-profile-url"];
                }
                if (isset($userData["picture-url"])) {
                    $data['avatar'] = $userData["picture-url"];
                }
                $data['type_sociaux'] = "linkedin";
                //create image facebook

                //create alias user
                if (isset($userData["first-name"])) {
                    $string        = $userData["first-name"] . "." . $userData["last-name"];
                    $data['alias'] = $this->create_alias($string);
                }
                $data['email_verified'] = true;

                //add user sociaux facebook
                $element = $this->user->AddUserSociauxFacebook($data);
                $this->autologin1($element);
            } else {
                $this->autologin1($result);
            }
        }
    }

    private function create_alias($string)
    {


        $this->load->library('urlify');
        //$search = array ('@[éèêëÊË]@i','@[àâäÂÄ]@i','@[îïÎÏ]@i','@[ûùüÛÜ]@i','@[ôöÔÖ]@i','@[ç]@i','@[ ]@i','@[^a-zA-Z0-9_]@');
        //$replace = array ('e','a','i','u','o','c','_','');
        //$result=preg_replace($search, $replace, $in);
        $verifcation = $this->urlify->filter($string);
        $result      = $this->user->verifcationExistAlias($verifcation);
        if ($result) {
            $i   = 1;
            $old = $verifcation;
            while ($result) {
                $verifcation = $old . "." . $i;
                $result      = $this->user->verifcationExistAlias($verifcation);
                $i++;
            }

            return $verifcation;
        } else {
            return $verifcation;
        }

        return $verifcation;
    }

    public function mentor($REFERRED_BY = 0)
    {
        $this->data['callback'] = base_url() . "connect/receiver_m";
        $this->load->library('linkedin', $this->data);
        $this->linkedin->getRequestToken();
        $requestToken = serialize($this->linkedin->request_token);
        $this->session->set_userdata([
            'requestToken' => $requestToken
        ]);
        header("Location: " . $this->linkedin->generateAuthorizeUrl());

    }

    public function receiver_m()
    {
        if (isset($_GET['oauth_problem'])) {
            session_unset();
            $this->session->set_flashdata(
                'linkedinError',
                [
                    'type' => 'error',
                    'msg'  => 'Sorry! Something went wrong this time. Please try again later.'
                ]
            );
            redirect('.');
            exit;
        }

        $this->load->library('linkedin', [
            'access' => $this->data['access'],//"<your Consumer Key / API Key goes here>",
            'secret' => $this->data['secret'],//"<your Consumer Secret / Secret Key goes here>" 
        ]);

        // get from session
        if (!$this->session->userdata('requestToken')) {
            redirect(base_url());
        }
        $requestToken = $this->session->userdata('requestToken');

        if ($this->input->get('oauth_verifier')) {
            $oauthVerifier                  = $this->input->get('oauth_verifier');
            $this->linkedin->request_token  = unserialize($requestToken);
            $this->linkedin->oauth_verifier = $oauthVerifier;
            $this->linkedin->getAccessToken($oauthVerifier);
            // set in session
            $this->session->set_userdata([
                'oauth_verifier'     => $oauthVerifier,
                'oauth_access_token' => serialize($this->linkedin->access_token)
            ]);
        } else {
            $oauthVerifier                  = $this->session->userdata('oauth_verifier');
            $oauthAccessToken               = $this->session->userdata('oauth_verifier');
            $this->linkedin->request_token  = unserialize($requestToken);
            $this->linkedin->oauth_verifier = $oauthVerifier;
            $this->linkedin->access_token   = unserialize($oauthAccessToken);
        }

        if ($this->input->get('oauth_verifier')) {
            $userData = $this->linkedin->getUserInfo(
                serialize($this->linkedin->request_token),
                $this->session->userdata('oauth_verifier'),
                $this->session->userdata('oauth_access_token')
            );

        } else {
            $userData['status'] = 404;
        }
        var_dump($userData);
        if (isset($userData['email-address'])) {
            $this->load->library('simple_html_dom');
            if (isset($userData["first-name"])) {
                $data['nom'] = $userData["first-name"];
            }
            if (isset($userData["last-name"])) {
                $data['prenom'] = $userData["last-name"];
            }
            if (isset($userData["id"])) {
                $data['uid'] = $userData["id"];
            }
            if (isset($userData["email-address"])) {
                $data['email'] = $userData["email-address"];
            }
            if (isset($userData["public-profile-url"])) {
                $data['facebook'] = $userData["public-profile-url"];
            }

            $html = file_get_html($userData["public-profile-url"]);

            redirect(base_url() . "mentor/etape1");

        }
    }

    public function dom()
    {
        $this->load->library('simple_html_dom');
        $html = file_get_html("http://www.linkedin.com/in/jarjinimohamed");
        echo $html;
        try{
            $content = file_get_contents('http://www.linkedin.com/in/jarjinimohamed');
            echo $content;
            if ($content === false) {
                // Handle the error
            }
        } catch (Exception $e){
            // Handle exception
        }


    }

}
