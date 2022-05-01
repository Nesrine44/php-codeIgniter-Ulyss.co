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
 * Model Class
 *
 * @package        CodeIgniter
 * @subpackage     Libraries
 * @category       Libraries
 * @author         EllisLab Dev Team
 * @link           http://codeigniter.com/user_guide/libraries/config.html
 * @property CI_DB_query_builder $db                           This is the platform-independent base Active Record implementation class.
 * @property CI_DB_forge         $dbforge                      Database Utility Class
 * @property CI_Benchmark        $benchmark                    This class enables you to mark points and calculate the time difference between them.<br />  Memory consumption can also be displayed.
 * @property CI_Calendar         $calendar                     This class enables the creation of calendars
 * @property CI_Cart             $cart                         Shopping Cart Class
 * @property CI_Config           $config                       This class contains functions that enable config files to be managed
 * @property CI_Controller       $controller                   This class object is the super class that every library in.<br />CodeIgniter will be assigned to.
 * @property CI_Email            $email                        Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encrypt          $encrypt                      Provides two-way keyed encoding using XOR Hashing and Mcrypt
 * @property CI_Exceptions       $exceptions                   Exceptions Class
 * @property CI_Form_validation  $form_validation              Form Validation Class
 * @property CI_Ftp              $ftp                          FTP Class
 * @property CI_Hooks            $hooks                        Provides a mechanism to extend the base system without hacking.
 * @property CI_Image_lib        $image_lib                    Image Manipulation class
 * @property CI_Input            $input                        Pre-processes global input data for security
 * @property CI_Lang             $lang                         Language Class
 * @property CI_Loader           $load                         Loads views and files
 * @property CI_Log              $log                          Logging Class
 * @property CI_Model            $model                        CodeIgniter Model Class
 * @property CI_Output           $output                       Responsible for sending final output to browser
 * @property CI_Pagination       $pagination                   Pagination Class
 * @property CI_Parser           $parser                       Parses pseudo-variables contained in the specified template view,<br />replacing them with the data in the second param
 * @property CI_Profiler         $profiler                     This class enables you to display benchmark, query, and other data<br />in order to help with debugging and optimization.
 * @property CI_Router           $router                       Parses URIs and determines routing
 * @property CI_Session          $session                      Session Class
 * @property CI_Sha1             $sha1                         Provides 160 bit hashing using The Secure Hash Algorithm
 * @property CI_Table            $table                        HTML table generation<br />Lets you create tables manually or from database result objects, or arrays.
 * @property CI_Trackback        $trackback                    Trackback Sending/Receiving Class
 * @property CI_Typography       $typography                   Typography Class
 * @property CI_Unit_test        $unit_test                    Simple testing class
 * @property CI_Upload           $upload                       File Uploading Class
 * @property CI_URI              $uri                          Parses URIs and determines routing
 * @property CI_User_agent       $user_agent                   Identifies the platform, browser, robot, or mobile devise of the browsing agent
 * @property CI_Validation       $validation                   //dead
 * @property CI_Xmlrpc           $xmlrpc                       XML-RPC request handler class
 * @property CI_Xmlrpcs          $xmlrpcs                      XML-RPC server class
 * @property CI_Zip              $zip                          Zip Compression Class
 * @property CI_Javascript       $javascript                   Javascript Class
 * @property CI_Jquery           $jquery                       Jquery Class
 * @property CI_Utf8             $utf8                         Provides support for UTF-8 environments
 * @property CI_Security         $security                     Security Class, xss, csrf, etc...
 * @property User_model          $user                         User Model
 */
class CI_Model
{

    protected $p_tablename;

    /**
     * Class constructor
     *
     * @return    void
     */
    public function __construct()
    {
        log_message('info', 'Model Class Initialized');
    }

    // --------------------------------------------------------------------

    /**
     * __get magic
     *
     * Allows models to access CI's loaded classes using the same
     * syntax as controllers.
     *
     * @param    string $key
     */
    public function __get($key)
    {
        // Debugging note:
        //	If you're here because you're getting an error message
        //	saying 'Undefined Property: system/core/Model.php', it's
        //	most likely a typo in your model code.
        return get_instance()->$key;
    }

    /**
     * @param $propertyName
     *
     * @return null
     */
    protected function getPropertyStdClass(StdClass $StdClass, $propertyName)
    {
        return property_exists($StdClass, $propertyName) ? $StdClass->{$propertyName} : null;
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
     * @param $id
     *
     * @return bool|StdClass
     */
    public function getById($id)
    {
        if ($id < 1) {
            return false;
        }

        $sql = ' SELECT * FROM ' . $this->p_tablename . '
                        WHERE id = :id
                        LIMIT 0,1
                      ';
        /* @var $stmt PDOStatement */
        $stmt = $this->db->conn_id->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $array_fields
     *
     * @return stdClass
     */
    public function save($array_fields)
    {
        $fields = $this->db->list_fields($this->p_tablename);

        /* Control fields */
        foreach ($array_fields as $key => $array_field) {
            if (in_array($key, $fields) == false) {
                unset($array_fields[$key]);
            }
        }

        if (count($array_fields) > 0) {
            /* Udpate OR Insert table */
            if (array_key_exists('id', $array_fields)) {
                $id = $array_fields['id'];
                unset($array_fields['id']);
                if (isset($array_fields['update_date']) == false && in_array('update_date', $fields)) {
                    $array_fields['update_date'] = date('Y-m-d H:i:s');
                }
                $this->db->where('id', $id);
                $this->db->update($this->p_tablename, $array_fields);
            } else {
                if (isset($array_fields['creation_date']) == false && in_array('creation_date', $fields)) {
                    $array_fields['creation_date'] = date('Y-m-d H:i:s');
                }
                // on recupere la date de la creation
                if (isset($array_fields['update_date']) == false && in_array('update_date', $fields)) {
                    $array_fields['update_date'] = date('Y-m-d H:i:s');
                }
                $this->db->insert($this->p_tablename, $array_fields);
                $id = $this->db->insert_id();
            }

            return $this->getById($id);
        }
    }

    /**
     * @param        $value
     * @param string $field_table
     *
     * @return bool
     */
    public function delete($value, $field_table = 'id')
    {
        return $this->db->delete($this->p_tablename, [$field_table => $value]);
    }

    protected function debugRequete()
    {
        $retour = $this->queryString;
        $trouve = false;
        foreach ($this->p_params as $param) {
            switch ($param["data_type"]) {
                case PDO::PARAM_STR:
                    $t = $this->replaceParam(":" . $param["parameter"], addslashes($param["variable"]), $retour);
                    if ($t == false) {
                        $t = $this->replaceParam($param["parameter"], addslashes($param["variable"]), $retour);
                        if ($t != false) {
                            $trouve = true;
                            $retour = $t;
                        }
                    } else {
                        $trouve = true;
                        $retour = $t;
                    }
                    break;
                default:
                    $t = $this->replaceParam(":" . $param["parameter"], ($param["variable"]), $retour);
                    if ($t == false) {
                        $t = $this->replaceParam($param["parameter"], ($param["variable"]), $retour);
                        if ($t != false) {
                            $trouve = true;
                            $retour = $t;
                        }
                    } else {
                        $trouve = true;
                        $retour = $t;
                    }
                    break;
            }
            if (!$trouve) {
                // -
            }
        }

        return $retour;
    }
}
