<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
include_once(APPPATH . 'libraries/andafter/LinkedinAPI.php');

class Auth extends CI_Controller
{
    private $p_LinkedinAPI;

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('talent_model', 'talent');
        $this->load->library('encrypt');
        $this->load->library('user_info');
        if ($this->session->userdata('logged_in_site_web')) {
            $this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
        }

        $this->p_LinkedinAPI = new LinkedinAPI($this->config->item('api_key'),
            $this->config->item('secret_key'),
            $this->config->item('callback_url')
        );
    }

    /**
     * @return LinkedinAPI
     */
    private function getLinkedinApi()
    {
        return $this->p_LinkedinAPI;
    }

    public function index()
    {


    }

    public function logout()
    {
    }

    /**
     * http://www.ulyss.local/auth/linkedinConnect
     * https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=77h78f1geqcuz0&redirect_uri=http://www.ulyss.local/auth/callbacklinkedin&state=987654321&scope=r_basicprofile
     */
    public function linkedinConnect()
    {

        if (isset($_SERVER['HTTP_REFERER']) && strstr($_SERVER['HTTP_REFERER'], base_url())) {
            $this->session->set_userdata('last_v', $_SERVER['HTTP_REFERER']);
        }


        if ($this->input->get('callback', true) !== null) {
            $this->session->set_userdata('last_v', $this->input->get('callback', true));
        }


        $this->getLinkedinApi()->sendAuthorizationClient();
    }

    /**
     * https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=77h78f1geqcuz0&redirect_uri=http://www.ulyss.local/auth/callbacklinkedin&state=987654321&scope=r_basicprofile
     */
    public function callbackLinkedin()
    {
        $codeAuth     = $this->input->get('code');
        $error        = $this->input->get('error');
        $url_redirect = $this->session->userdata('last_v');

        if ($error == null) {
            $ResponseLinkedin = json_decode($this->getLinkedinApi()->createAccessToken($codeAuth), true);

            $access_token = isset($ResponseLinkedin['access_token']) ? $ResponseLinkedin['access_token'] : '';
            $expires_in   = isset($ResponseLinkedin['expires_in']) ? $ResponseLinkedin['expires_in'] : '';


            $BasicLiteLinkedin = $this->getLinkedinApi()->getLiteProfileUser();


            /* Parse Callback XML Linkedin */
            $this->load->library('format');


            $tabEmailAPI      = $this->format->factory($BasicLiteLinkedin[1], 'json')->to_array();
            $tabLiteAPI       = $this->format->factory($BasicLiteLinkedin[0], 'json')->to_array();
            $arrayLiteProfile = array_merge($tabLiteAPI, $tabEmailAPI);

            $User = $this->ModelUserLinkedin->updateProfileLinkedin($arrayLiteProfile);

            $this->autologin($User);

            $talent = $this->ModelUser->CheckIfUserIsTalentByUserId($User->id);
        }

        // redirection vers la page de l'inscription si c'est leur premiere fois
        if ($talent == null) {
            if ($url_redirect == 'inscription/insider') {
                redirect(base_url('inscription/insider'));
            } elseif ($url_redirect == 'inscription/etape1') {
                redirect(base_url('inscription'));
            }
        } elseif (isset($url_redirect) && $url_redirect != base_url() && $url_redirect != '/') {
            redirect(base_url($url_redirect));
        } else {
            redirect(base_url(), 'auto', '301');
        }

    }

    public function ulyssConnect()
    {

        $this->form_validation->set_rules(
            'email', 'email',
            'required|valid_email',
            [
                'required'    => 'Veuillez indiquer votre E-Mail.',
                'valid_email' => 'Le format de l\'adresse électronique n\'est pas respecté',
            ]
        );


        $this->form_validation->set_rules('password', 'Password',
            'required|min_length[6]|max_length[20]',
            [
                'required'   => 'Veuillez saisir votre mot de passe ',
                'min_length' => 'Votre mot de passe doit comprendre entre 6 à 20 caractères',
                'max_length' => 'Votre mot de passe doit comprendre entre 6 à 20 caractères'
            ]
        );

        if ($this->form_validation->run() == false) {
            $errors = $this->form_validation->error_array();

            $msg = '';

            foreach ($errors as $error) {
                $msg .= $error;
            }

            $this->session->set_flashdata('message_error', $msg);
            redirect(base_url());

        } else {

            $email    = $this->security->xss_clean($this->input->post('email'));
            $password = $this->security->xss_clean($this->input->post('password'));

            $User = $this->ModelUser->getUserByEmail($email);

            if ($User == null) {
                $this->session->set_flashdata('message_error', 'Identifiant ou mot de passe non valide !');
                redirect(base_url());
            }

            $passwordBdd = $this->encrypt->decode($User->password);

            if ($passwordBdd === $password && $User->email === $email) {

                if ($this->session->userdata('logged_in_site_web')) {
                    $this->session->unset_userdata('logged_in_site_web');
                } elseif ($this->session->userdata('ent_logged_in_site_web')) {
                    $this->session->unset_userdata('ent_logged_in_site_web');
                }


                if (isset($_SERVER['HTTP_REFERER']) && strstr($_SERVER['HTTP_REFERER'], base_url())) {
                    $this->session->set_userdata('last_v', $_SERVER['HTTP_REFERER']);
                }

                if ($this->input->get('callback', true) !== null) {
                    $this->session->set_userdata('last_v', $this->input->get('callback', true));
                }

                $this->session->set_flashdata('message_valid', 'Bienvenue, ' . $User->prenom);

                $this->autologin($User);

                redirect(base_url());
            } else {
                $this->session->set_flashdata('message_error', 'Identifiant ou mot de passe non valide !');
                redirect(base_url());
            }
        }

    }

    /**
     * @param $User
     */
    private function autologin($User)
    {
        if ($User == null) {
            redirect('/');
        }

        $this->load->library('encrypt');
        $id = $this->encrypt->encode($User->id);

        $sess_array = [
            'id'           => $id,
            'email'        => $User->email,
            'avatar'       => $User->avatar,
            'name_complet' => $User->prenom . ' ' . $User->nom,
            'tel'          => $User->tel,
            'name'         => $User->prenom . ' ' . strtoupper(substr($User->nom, 0, 1))
        ];

        $this->session->set_userdata('logged_in_site_web', $sess_array);
    }

    /**
     * @param $hash
     */
    public function autologinByHash($hash)
    {
        $uri = $this->input->get('referer') != '' ? $this->input->get('referer') : '/';
        if (strlen($hash) == 40) {
            $User = $this->ModelUser->getUserByHash($hash);
            if ($User != null && $User instanceof StdClass) {
                $this->autologin($User);
            }
        }
        redirect($uri, 'auto', '301');
    }
}
