<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class twilio_demo extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->load->library('twilio');

        $from = '+33975184207';
        $to = '+33647843451';
        $message = 'This is a test...easylearn';

        $response = $this->twilio->sms($from, $to, $message);


        if ($response->IsError)
            echo 'Error: ' . $response->ErrorMessage;
        else
            echo 'Sent message to ' . $to;
    }

}

/* End of file twilio_demo.php */