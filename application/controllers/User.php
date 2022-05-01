<?php

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->data['consumer_key']    = $this->config->item('api_key');
        $this->data['consumer_secret'] = $this->config->item('secret_key');
        $this->data['callback_url']    = site_url() . '/user/linkedin_submit';
    }

    function index()
    {
        echo anchor('user/linkedin', 'Sign in with Linkedin');
    }

    function linkedin()
    {
        $this->load->library('linkedin', $this->data);

        $token = $this->linkedin->get_request_token();

        $oauth_data = [
            'oauth_request_token'        => $token['oauth_token'],
            'oauth_request_token_secret' => $token['oauth_token_secret']
        ];


        $this->session->set_userdata($oauth_data);

        $request_link = $this->linkedin->get_authorize_URL($token);

        header("Location: " . $request_link);
    }

    /**
     * Get Access tokens
     */
    function linkedin_submit()
    {
        $this->data['oauth_token'] = $this->session->userdata('oauth_request_token');

        $this->data['oauth_token_secret'] = $this->session->userdata('oauth_request_token_secret');

        $this->load->library('linkedin', $this->data);

        $this->session->set_userdata('oauth_verifier', $this->input->get('oauth_verifier'));

        $tokens                        = $this->linkedin->get_access_token($this->input->get('oauth_verifier'));
        $this->linkedin->request_token = unserialize($this->data['oauth_token']);
        $access_data                   = [
            'oauth_access_token'        => $tokens['oauth_token'],
            'oauth_access_token_secret' => $tokens['oauth_token_secret']
        ];

        $this->session->set_userdata($access_data);

        /*
         * Store Linkedin info in a session
         */
        $auth_data = ['linked_in' => serialize($this->linkedin->token), 'oauth_secret' => $this->input->get('oauth_verifier')];

        $this->session->set_userdata(['auth' => $auth_data]);
        $userData = $this->linkedin->getUserInfo(
            serialize($this->linkedin->request_token),
            $this->input->get('oauth_verifier'),
            $tokens['oauth_token']
        );
        var_dump($userData);
        //   echo anchor('user/post', 'Post to Linkedin');
    }

    /**
     * Post a Status update to linkedin
     */
    function post()
    {
        $auth_data = $this->session->userdata('auth');

        $title      = "Trying out a Codeignier Linkedin Library";
        $comment    = "Trying out a Codeignier Linkedin Library created by Murrion Software. Get the code on Github.com";
        $target_url = "https://github.com/MurrionSoftware/codeigniter-linkedin-library";
        $image_url  = ""; // optional

        $this->load->library('linkedin', $this->data);

        $status_response = $this->linkedin->share($comment, $title, $target_url, $image_url, unserialize($auth_data['linked_in']));
        $userData        = $this->linkedin->getUserInfo(
            serialize($this->linkedin->request_token),
            $this->session->userdata('oauth_verifier'),
            $this->session->userdata('oauth_access_token')
        );
        if ($status_response == '201') {
            echo "Linkedin Comment posted successfully";
        } else {
            print_r($status_response);
        }
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */