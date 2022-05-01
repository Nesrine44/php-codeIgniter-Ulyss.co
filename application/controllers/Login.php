<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('user_model', 'user');

    }

    function verfy()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('password', 'mot de passe', 'required|callback_check_database');
        if ($this->form_validation->run() == false) {
            $data['erreur'] = 'on';
            $data['msg']    = validation_errors();
            echo json_encode($data);
        } else {
            if ($this->session->userdata('logged_in_site_web')) {
                $data['erreur'] = 'off';
                //sevenir les identifiants
                if ($this->input->post('sevenir')) {
                    $this->session->set_userdata("email_coke", $this->input->post('email'));
                    $this->session->set_userdata("password_coke", $this->input->post('password'));
                }
                echo json_encode($data);
            } elseif ($this->session->userdata('logged_in_site_web_bloquer')) {
                $data['erreur'] = 'bloquer';
                echo json_encode($data);
            } else {

            }
        }
    }

    function check_database($pass)
    {
        $this->load->library('encrypt');
        $this->load->model('user_model', 'user');
        $email  = $this->input->post('email');
        $result = $this->user->LoginWithEmail($email, $pass);
        if ($result) {
            $sess_array = [];
            $row        = $result[0];
            $id_decode  = $row->id;

            $id         = $this->encrypt->encode($id_decode);
            $sess_array = [
                'id'           => $id,
                'email'        => $row->email,
                'avatar'       => $row->avatar,
                'name'         => $row->prenom . ' ' . strtoupper(substr($row->nom, 0, 1)),
                'name_complet' => $row->prenom . ' ' . $row->nom
            ];
            if ($row->email_verified) {
                if ($row->fermer != 1) {
                    $this->session->set_userdata('logged_in_site_web', $sess_array);
                } else {
                    $this->session->set_userdata('logged_in_site_web_bloquer', $sess_array);
                }

                return true;
            } else {
                $this->form_validation->set_message('check_database', $this->lang->line("email_verified"));

                return false;
            }
        } else {
            $this->form_validation->set_message('check_database', $this->lang->line("error_password_or_email"));

            return false;
        }
    }

    public function mdp_oublie()
    {
        $email = $this->input->post('email');
        $query = $this->db->get_where('user', ['email' => $email]);
        if ($query->num_rows() > 0) {
            $result = $query->row();
            $email  = $result->email;
            $this->load->library('encrypt');
            $password = $this->encrypt->decode($result->password);
            $this->send_email_pasword_oublie($email, $password);
            $data['message'] = "le mot de passe a été envoyé a votre courriel adresse";
            echo json_encode($data);
        } else {
            $data['message'] = "adresse email non valide";
            echo json_encode($data);
        }
    }

    private function send_email_pasword_oublie($email1 = "", $password = "")
    {
        $id_gabrit = 6;
        $this->load->model('model_configuration', 'conf');
        $email = $this->conf->GetValue("email");

        $subject = $this->conf->GetSubject($id_gabrit);
        $gabarit = $this->conf->GetGabarit($id_gabrit);
        $gabarit = str_replace("{password}", $password, $gabarit);
        $gabarit = str_replace("{email}", $email1, $gabarit);

        //get info client
        $config['protocol'] = 'mail';
        $config['mailtype'] = 'html';
        $config['charset']  = 'utf-8';

        $this->load->library('email', $config);
        $this->load->library('parser');
        $this->email->clear();
        $this->email->from($email, 'Site TMTT.org');
        $this->email->to($email1);
        $this->email->subject($subject);
        $this->email->message($gabarit);
        $this->email->send();

        return true;
    }

    public function logout()
    {
        if ($this->session->userdata('ent_logged_in_site_web')) {
            $log   = [
                'etat_connexion' => '0'
            ];
            $email = $this->session->userdata('ent_logged_in_site_web')['email'];
            $this->ModelEntrepriseAdmin->update_profile($email, $log);
        }
        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }

    public function share()
    {
        if (!$this->input->post('to')) {
            $data['status'] = false;
            $data['msg']    = "entrez SVP un email";
            echo json_encode($data);
        }
        $this->load->library('mailing');
        $data['from']      = $this->input->post('from');
        $data['to']        = $this->input->post('to');
        $data['name_user'] = $this->input->post('name_user');
        $data['overview']  = $this->input->post('overview');
        $data['symbol']    = $this->input->post('symbol');
        $data['name']      = $this->input->post('name');
        if (!$this->mailing->share($data)) {
            $data['status'] = true;
            $data['msg']    = "entrez SVP un email";
            echo json_encode($data);
        } else {
            $data['status'] = false;
            $data['msg']    = "entrez SVP un email";
            echo json_encode($data);
        }

    }


}
