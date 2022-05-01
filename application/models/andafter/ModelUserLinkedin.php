<?php

/**
 * Class ModelUserLinkedin
 */
Class ModelUserLinkedin extends CI_Model
{
    public static $hashString = 'E9sz.g-.@\mDE:z?+GZ~-KH`b5NnpCR-T7';
    private       $table      = 'user_linkedin';
    private       $p_user;
    private       $p_userLinkedin;

    public function __construct()
    {
        parent::__construct();
        $this->p_tablename = 'user_linkedin';
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    public function getUserByEmail($email)
    {
        if ($this->p_user === null) {
            $this->p_user = new stdClass();
            $this->p_user = $this->db
                ->get_where('user', ['email' => $email], 0, 1)
                ->row();
        }

        return $this->p_user;
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    public function getByIdUser($id)
    {
        $this->p_userLinkedin = new stdClass();
        $this->p_userLinkedin = $this->db
            ->get_where($this->table, ['id_user' => $id], 0, 1)
            ->row();

        return $this->p_userLinkedin;
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    public function getUserLinkedinByEmail($email)
    {
        if ($this->p_userLinkedin == null) {
            $this->p_userLinkedin = new stdClass();
            $this->p_userLinkedin = $this->db
                ->select($this->table . '.*')
                ->from($this->table)
                ->join('user', $this->table . '.id_user = user.id', 'INNER')
                ->where('email', $email)
                ->limit(1)
                ->get()
                ->row();
        }

        return $this->p_userLinkedin;
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    public function getUserLinkedinByIdLinkedin($id_linkedin)
    {
        if ($this->p_userLinkedin == null) {
            $this->p_userLinkedin = new stdClass();
            $this->p_userLinkedin = $this->db
                ->select($this->table . '.*')
                ->from($this->table)
                ->join('user', $this->table . '.id_user = user.id', 'INNER')
                ->where($this->table . '.id_linkedin', $id_linkedin)
                ->limit(1)
                ->get()
                ->row();
        }

        return $this->p_userLinkedin;
    }

    public function updateProfileLinkedin($arrayBasicProfile)
    {
        if (isset($arrayBasicProfile['elements']['0']['handle~']['emailAddress'])) {

            // A completer !!
            // NON COMPLET !!
            // A tester toute les condition
            $keyLocalized             = $arrayBasicProfile['firstName']['preferredLocale']['language'] . '_' . $arrayBasicProfile['firstName']['preferredLocale']['country'];
            $params                   = [
                'id_linkedin'      => isset($arrayBasicProfile['id']) ? $arrayBasicProfile['id'] : '',
                'first-name'       => isset($arrayBasicProfile['firstName']['localized'][$keyLocalized]) ? $arrayBasicProfile['firstName']['localized'][$keyLocalized] : '',
                'last-name'        => isset($arrayBasicProfile['lastName']['localized'][$keyLocalized]) ? $arrayBasicProfile['lastName']['localized'][$keyLocalized] : '',
                'email-address'    => isset($arrayBasicProfile['elements']['0']['handle~']['emailAddress']) ? $arrayBasicProfile['elements']['0']['handle~']['emailAddress'] : '',
                'location-country' => isset($arrayBasicProfile['firstName']['preferredLocale']['country']) ? $arrayBasicProfile['firstName']['preferredLocale']['country'] : '',
                'picture-url'      => isset($arrayBasicProfile['profilePicture']['displayImage~']['elements']['0']['identifiers']['0']['identifier']) ? $arrayBasicProfile['profilePicture']['displayImage~']['elements']['0']['identifiers']['0']['identifier'] : '',
            ];
            $params['formatted-name'] = $params['first-name'] . ' ' . $params['last-name'];

            $this->load->model('andafter/ModelUser');
            $UserLinkedin = $this->getUserLinkedinByIdLinkedin($params['id_linkedin']);

            if ($UserLinkedin == null) {
                $UserLinkedin = $this->getUserLinkedinByEmail($params['email-address']);
            }
            if ($UserLinkedin != null) {
                $User = $this->ModelUser->getById($UserLinkedin->id_user);
            } else {
                $User = $this->ModelUser->getUserByIdLinkedin($params['id_linkedin']);
                if ($User == null) {
                    $User = $this->ModelUser->getUserByEmail($params['email-address']);
                }
            }


            if ($UserLinkedin == null) {

                if ($User == null) {
                    $array = [
                        'nom'            => isset($params['last-name']) ? $params['last-name'] : '',
                        'prenom'         => isset($params['first-name']) ? $params['first-name'] : '',
                        'email'          => isset($params['email-address']) ? $params['email-address'] : '',
                        'uid'            => isset($params['id_linkedin']) ? $params['id_linkedin'] : '',
                        'avatar'         => trim($params['picture-url']) != '' ? $params['picture-url'] : '',
                        'type_sociaux'   => 'Linkedin',
                        'cover'          => 'default.jpg',
                        'fermer'         => '0',
                        'student'        => '0',
                        'hash'           => sha1($params['email-address'] . self::$hashString),
                        'alias'          => $this->create_alias($params['last-name'] . '-' . $params['first-name']),
                        'date_connexion' => date('Y-m-d H:i:s'),
                    ];
                    $this->getContext()->load->model('ModelUser');
                    $array['avatar'] = $this->GetLocalAvatar($params['id_linkedin'], $array['avatar']);
                    $User            = $this->ModelUser->save($array);

                    SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_MAIL_CREATION_COMPTE,
                        $User->email,
                        [
                            'HASH'      => $User->hash,
                            'FIRSTNAME' => $User->prenom
                        ]
                    );
                }

                $params['id_user'] = $User->id;
                $this->save($params);

            } else {
                $params['id'] = $UserLinkedin->id;
                $id_link      = $params['id_linkedin'];
                unset($params['id_linkedin']);
                $this->save($params);

                /* Mise à jour avatar */
                $data['id']     = $User->id;
                $avatar         = trim($params['picture-url']) != '' ? $params['picture-url'] : '';
                $data['avatar'] = $this->GetLocalAvatar($id_link, $avatar);

                $data['date_connexion'] = date('Y-m-d H:i:s');
                $User                   = $this->ModelUser->save($data);
            }

            return $User;
        }

        return null;
    }


    private function GetLocalAvatar($Id_linkedin, $avatar)
    {
        //**********************************************/
        // module de test et recup la photo sur le site /
        //**********************************************/
        $headers = @get_headers($avatar);
        $defalut = '/upload/avatar/default.jpg';
        if (is_array($headers) && isset($Id_linkedin)) {
            if (!strpos($headers[0], '403 Forbidden') || !strpos($headers[0], '404 Not Found')) {
                if (copy($avatar, './upload/avatar/' . $Id_linkedin . '.jpg')) {
                    return '/upload/avatar/' . $Id_linkedin . '.jpg';
                } else {
                    return $defalut;
                }
            } else {
                return $defalut;
            }
        } else {
            return $defalut;
        }
    }

    /**
     * @param $string
     *
     * @return string
     */
    private function create_alias($string)
    {
        $this->load->model('user_model', 'user');
        $this->load->library('urlify');
        $verifcation  = $this->getContext()->urlify->filter($string);
        $verifcation1 = $verifcation;
        $result       = $this->getContext()->user->verifcationExistAlias($verifcation);
        if ($result) {
            $i = 1;
            while ($result) {
                $verifcation = $verifcation1 . "." . $i;
                $result      = $this->getContext()->user->verifcationExistAlias($verifcation);
                $i++;
            }
        }

        return $verifcation;
    }
}

?>
