<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class General_info
{
    public function __construct()
    {
        $this->CI =& get_instance();
    }


    public function getSecteurNameById($id)
    {
        $name = $this->CI->ModelGeneral->getSecteurNameByIdBdd($id);

        return !empty($name) ? $name : "";
    }

    public function getDepartementNameById($id)
    {
        $name = $this->CI->ModelGeneral->getDepartementNameByIdBdd($id);

        return !empty($name) ? $name : "";
    }


    public function getVilleNameById($id)
    {
        $name = $this->CI->user->getVilleRow($id);

        return !empty($name) ? $name->ville_nom : "";
    }

    public function getVilleCodePostalById($id)
    {
        $name = $this->CI->user->getVilleRow($id);

        return !empty($name) ? $name->ville_nom . ' ' . $name->ville_code_postal : "";
    }


    public function get_client_ip_info()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                if (isset($_SERVER['HTTP_X_FORWARDED'])) {
                    $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
                } else {
                    if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
                        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
                    } else {
                        if (isset($_SERVER['HTTP_FORWARDED'])) {
                            $ipaddress = $_SERVER['HTTP_FORWARDED'];
                        } else {
                            if (isset($_SERVER['REMOTE_ADDR'])) {
                                $ipaddress = $_SERVER['REMOTE_ADDR'];
                            } else {
                                $ipaddress = 'UNKNOWN';
                            }
                        }
                    }
                }
            }
        }

        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ipaddress));

        return $query;
    }


}