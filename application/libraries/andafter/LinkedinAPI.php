<?php
ob_start();

class LinkedinAPI
{

    private $p_apikey, $p_secret_key, $p_response, $p_state, $p_callbackurl, $p_accessToken;

    public function __construct($api_key, $secret_key, $callback_url)
    {
        $this->p_apikey       = $api_key;
        $this->p_secret_key   = $secret_key;
        $this->p_callbackurl  = $callback_url;
        $this->p_baseurlV1    = 'https://api.linkedin.com/v1/';
        $this->p_baseurlV2    = 'https://www.linkedin.com/oauth/v2/';
        $this->p_baseurlApiV2 = 'https://api.linkedin.com/v2/';
        $this->p_state        = 'fdge8g9495e6htè4egre9h44(4t9ggsdé';
    }

    public function setAccessToken($accessToken)
    {
        $this->p_accessToken = $accessToken;
    }

    /**
     * @return string
     */
    private function getUrlAPI_V1()
    {
        return $this->p_baseurlV1;
    }

    /**
     * @return string
     */
    private function getUrlAPI_V2()
    {
        return $this->p_baseurlV2;
    }

    /**
     * @return string
     */
    private function getUrlAPI_V2_2()
    {
        return $this->p_baseurlApiV2;
    }

    /**
     * @return string
     */
    private function getAPIKey()
    {
        return $this->p_apikey;
    }

    /**
     * @return string
     */
    private function getSecretKey()
    {
        return $this->p_secret_key;
    }

    /**
     * @return string
     */
    private function getState()
    {
        return $this->p_state;
    }

    /**
     * @return string
     */
    private function getCallbackUrl()
    {
        return $this->p_callbackurl;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->p_accessToken;
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->p_response;
    }

    public function sendRequest($METHOD = 'POST', $URL = '', $PARAMS = [], $HEADERS = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($METHOD == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($PARAMS));
        } else {
            if ($METHOD == 'GET') {
                curl_setopt($ch, CURLOPT_HEADER, false);
                if (is_array($HEADERS) && count($HEADERS) > 0) {
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $HEADERS);
                }
            }
        }
        $this->p_response = curl_exec($ch);
        curl_close($ch);
    }

    public function sendAuthorizationClient()
    {
        $linkAPI = $this->getUrlAPI_V2() . 'authorization?';
        $params  = [
            'response_type' => 'code',
            'client_id'     => $this->getAPIKey(),
            'redirect_uri'  => $this->getCallbackUrl(),
            'state'         => $this->getState(), /* Uniq complex string */
            'scope'         => 'r_liteprofile r_emailaddress'
        ];

        $url = $linkAPI . http_build_query($params);
        redirect($url);
    }

    /**
     * @return string
     */
    public function createAccessToken($codeAuth)
    {
        $linkAPI = $this->getUrlAPI_V2() . 'accessToken';
        $params  = [
            'grant_type'    => 'authorization_code',
            'code'          => $codeAuth,
            'redirect_uri'  => base_url() . 'auth/callbacklinkedin',
            'client_id'     => $this->getAPIKey(),
            'client_secret' => $this->getSecretKey()
        ];
        $this->sendRequest('POST', $linkAPI, $params);
        $jsonResponse = json_decode($this->getResponse(), true);

        if (isset($jsonResponse['error'])) {
            redirect('/', 'auto', '301');
            exit();
        }

        if (isset($jsonResponse['access_token'])) {
            $this->setAccessToken($jsonResponse['access_token']);
        }

        return $this->getResponse();
    }

    /**
     * @return string
     */
    public function getLiteProfileUser()
    {

        //'https://api.linkedin.com/v2/people/~:(
        //GET https://api.linkedin.com/v2/me?projection=(id,firstName,lastName,profilePicture(displayImage~:playableStreams))
        //$linkAPI =  'me?projection=(id,firstName,lastName,profilePicture(displayImage~:playableStreams)';

        $linkLiteProfil  = $this->getUrlAPI_V2_2() . 'me?projection=(id,firstName,lastName,profilePicture(displayImage~:playableStreams))';
        $linkEmailProfil = $this->getUrlAPI_V2_2() . 'emailAddress?q=members&projection=(elements*(handle~))';

        $headers = [
            'Connection: Keep-Alive',
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $this->getAccessToken(),
        ];

        $this->sendRequest('GET', $linkLiteProfil, $params = [], $headers);
        $APIRepense[] = $this->getResponse();
        $this->sendRequest('GET', $linkEmailProfil, $params = [], $headers);
        $APIRepense[] = $this->getResponse();

        /*var_dump($linkAPI);
        die();*/

        return $APIRepense;

    }
}
