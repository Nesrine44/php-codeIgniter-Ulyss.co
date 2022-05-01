<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once("oAuth/OAuth.php");

class Linkedin
{

    public $base_url        = "https://api.linkedin.com";
    public $secure_base_url = "https://api.linkedin.com";
    public $oauth_callback  = "oob";
    public $consumer;
    public $request_token;
    public $access_token;
    public $oauth_verifier;
    public $signature_method;
    public $request_token_path;
    public $access_token_path;
    public $authorize_path;
    public $debug           = false;

    function __construct($options)
    {

        $consumer_key    = $options['access'];
        $consumer_secret = $options['secret'];
        $oauth_callback  = isset($options['callback']) ? $options['callback'] : null;

        if ($oauth_callback) {
            $this->oauth_callback = $oauth_callback;
        }

        $this->consumer           = new OAuthConsumer($consumer_key, $consumer_secret, $this->oauth_callback);
        $this->signature_method   = new OAuthSignatureMethod_HMAC_SHA1();
        $this->request_token_path = $this->secure_base_url . "/uas/oauth/requestToken?scope=r_basicprofile r_emailaddress";
        $this->access_token_path  = $this->secure_base_url . "/uas/oauth/accessToken";
        $this->authorize_path     = $this->secure_base_url . "/uas/oauth/authorize";
    }

    function getRequestToken()
    {
        $consumer = $this->consumer;
        $request  = OAuthRequest::from_consumer_and_token($consumer, null, "GET", $this->request_token_path);
        $request->set_parameter("oauth_callback", $this->oauth_callback);
        $request->sign_request($this->signature_method, $consumer, null);
        $headers  = [];
        $url      = $request->to_url();
        $response = $this->httpRequest($url, $headers, "GET");
        parse_str($response, $response_params);
        $this->request_token = new OAuthConsumer($response_params['oauth_token'], $response_params['oauth_token_secret'], 1);
    }

    function generateAuthorizeUrl()
    {
        $consumer      = $this->consumer;
        $request_token = $this->request_token;

        return $this->authorize_path . "?oauth_token=" . $request_token->key;
    }

    function getAccessToken($oauth_verifier)
    {
        $request = OAuthRequest::from_consumer_and_token($this->consumer, $this->request_token, "GET", $this->access_token_path);
        $request->set_parameter("oauth_verifier", $oauth_verifier);
        $request->sign_request($this->signature_method, $this->consumer, $this->request_token);
        $headers  = [];
        $url      = $request->to_url();
        $response = $this->httpRequest($url, $headers, "GET");
        parse_str($response, $response_params);
        if (isset($debug)) {
            echo $response . "\n";
        }
        $this->access_token = new OAuthConsumer($response_params['oauth_token'], $response_params['oauth_token_secret'], 1);
    }

    function getProfile($resource = "~")
    {
        $profile_url = $this->base_url . "/v1/people/" . $resource;
        $request     = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, "GET", $profile_url);
        $request->sign_request($this->signature_method, $this->consumer, $this->access_token);
        $auth_header = $request->to_header("https://api.linkedin.com");
        if (isset($debug)) {
            echo $auth_header;
        }
        // $response will now hold the XML document
        $response = $this->httpRequest($profile_url, $auth_header, "GET");

        return $response;
    }

    function getCompany($id)
    {

        $company_url = $this->base_url . "/v1/companies/" . $id . ":(id,name,ticker,description,employee-count-range,industries,company-type,logo-url,square-logo-url,locations:(address:(street1,street2,state,city,postal-code,country-code,region-code)))";
        $request     = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, "GET", $company_url);
        $request->sign_request($this->signature_method, $this->consumer, $this->access_token);
        $auth_header = $request->to_header("https://api.linkedin.com");
        if (isset($debug)) {
            echo $auth_header;
        }
        // $response will now hold the XML document
        $response = $this->httpRequest($company_url, $auth_header, "GET");

        return $response;
    }

    function setStatus($status)
    {
        $status_url = $this->base_url . "/v1/people/~/current-status";
        //echo "Setting status...\n";
        $xml = "<current-status>" . htmlspecialchars($status, ENT_NOQUOTES, "UTF-8") . "</current-status>";
        //echo $xml . "\n";
        $request = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, "PUT", $status_url);
        $request->sign_request($this->signature_method, $this->consumer, $this->access_token);
        $auth_header = $request->to_header("https://api.linkedin.com");
        if ($debug) {
            echo $auth_header . "\n";
        }
        $response = $this->httpRequest($status_url, $auth_header, "PUT", $xml);

        return $response;
    }

    # Parameters should be a query string starting with "?"
    # Example search("?count=10&start=10&company=linkedin");

    function search($parameters)
    {
        $search_url = $this->base_url . "/v1/people/" . $parameters;
        echo "Performing search for: " . $parameters . "\n";
        $request = OAuthRequest::from_consumer_and_token($this->consumer, $this->access_token, "GET", $search_url);
        $request->sign_request($this->signature_method, $this->consumer, $this->access_token);
        $auth_header = $request->to_header("https://api.linkedin.com");
        if ($debug) {
            echo $request->get_signature_base_string() . "\n";
            echo $auth_header . "\n";
        }
        $response = $this->httpRequest($search_url, $auth_header, "GET");

        return $response;
    }

    function httpRequest($url, $auth_header, $method, $body = null)
    {
        if (!$method) {
            $method = "GET";
        };

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        if (!is_array($auth_header)) {
            $auth_header = [$auth_header];
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $auth_header); // Set the headers.

        if ($body) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [$auth_header, "Content-Type: text/xml;charset=utf-8"]);
        }

        $data = curl_exec($curl);
        if ($this->debug) {
            echo $data . "\n";
        }
        curl_close($curl);

        return $data;
    }

    /**
     * Provides the userdetails from linkedin response xml
     *
     *
     * @return String
     */
    public function getUserInfo($requestToken = '', $oauthVerifier = '', $accessToken = '')
    {
        $this->request_token  = unserialize($requestToken);
        $this->oauth_verifier = $oauthVerifier;
        $this->access_token   = unserialize($accessToken);

        try{
            $profileStr = "~:(id,first-name,last-name,interests,publications,patents,languages,skills,date-of-birth,email-address,phone-numbers,im-accounts,main-address,twitter-accounts,headline,picture-url,picture-urls::(original),public-profile-url,industry,summary,specialties,positions,certifications,educations,courses,volunteer,num-recommenders,recommendations-received,job-bookmarks,honors-awards,primary-twitter-account,connections,group-memberships)";
            //  $profileStr="~:(id,first-name,last-name,headline,picture-url,industry,summary,specialties,positions:(id,title,summary,start-date,end-date,is-current,company:(id,name,type,size,industry,ticker)),educations:(id,school-name,field-of-study,start-date,end-date,degree,activities,notes),associations,interests,num-recommenders,date-of-birth,publications:(id,title,publisher:(name),authors:(id,name),date,url,summary),patents:(id,title,summary,number,status:(id,name),office:(name),inventors:(id,name),date,url),languages:(id,language:(name),proficiency:(level,name)),skills:(id,skill:(name)),certifications:(id,name,authority:(name),number,start-date,end-date),courses:(id,name,number),recommendations-received:(id,recommendation-type,recommendation-text,recommender),honors-awards,three-current-positions,three-past-positions,volunteer)";
            $xmlDoc = $this->getProfile($profileStr);
            $xml    = simplexml_load_string($xmlDoc);

            return $this->_XML2Array($xml);
        } catch (Exception $o){
            print_r($o);
        }
    }

    public function getCompanyInfo($requestToken = '', $oauthVerifier = '', $accessToken = '', $id)
    {
        $this->request_token  = unserialize($requestToken);
        $this->oauth_verifier = $oauthVerifier;
        $this->access_token   = unserialize($accessToken);

        try{
            $xmlDoc = $this->getCompany($id);
            $xml    = simplexml_load_string($xmlDoc);

            return $this->_XML2Array($xml);
        } catch (Exception $o){
            print_r($o);
        }
    }

    /**
     * Create an array for XML object
     *
     *
     * @param SimpleXMLElement $parent XML object
     *
     * @return array
     */
    private function _XML2Array(SimpleXMLElement $parent)
    {
        $array = [];
        foreach ($parent as $name => $element) {
            ($node = &$array[$name]) && (1 === count($node) ? $node = [$node] : 1) && $node = &$node[];
            $node = $element->count() ? $this->_XML2Array($element) : trim($element);
        }

        return $array;
    }

}
