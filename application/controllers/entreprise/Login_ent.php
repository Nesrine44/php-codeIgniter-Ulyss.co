<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_ent extends CI_Controller
{


    public function index()
    {


        $this->form_validation->set_rules(
            'login', 'login',
            'required|min_length[3]|max_length[50]',
            [
                'required'   => 'Veuillez indiquer un identifiant.',
                'min_length' => 'Identifiant non valide.',
                'max_length' => 'Identifiant non valide.'
            ]
        );


        $this->form_validation->set_rules('password', 'Password',
            'required|min_length[3]|max_length[72]',
            [
                'min_length' => 'Le mot de passe doit contenir au moins 3 charactères.',
                'max_length' => 'Le mot de passe  ne doit pas contenir plus de 72 charactères.',
                'required'   => 'Veuillez indiquer un mot de passe.'
            ]
        );


        if ($this->form_validation->run() == false) {

            $this->load->view('template/header', $this->datas);
            $this->load->view('home');
            $this->load->view('template/footer', $this->datas);

        } else {

            if ($this->input->post('login')) {

                $mailUser = $this->security->xss_clean($this->input->post('login'));
                $adminEnt = $this->ModelEntrepriseAdmin->getAdminEntByMail($mailUser);

                if ($adminEnt == null) {
                    $this->session->set_flashdata('message_error', 'Identifiant ou mot de passe non valide !');
                    redirect(base_url() . 'employeur');
                }

                $password = $this->security->xss_clean($this->input->post('password'));


                $passwordBdd        = $this->encrypt->decode($adminEnt->mot_de_passe);
                $entInfo            = $this->ModelEntreprise->GetEntrepriseById($adminEnt->id_entreprise);
                $BusinessEntreprise = new BusinessEntreprise($entInfo);

                if ($passwordBdd === $password && $adminEnt->email_pro === $mailUser) {

                    if (ModelEntrepriseAdmin::VALID_STATUT != $this->ModelEntrepriseAdmin->checkStatut($adminEnt->id)) {

                        $this->session->set_flashdata('message_error', 'Veuillez contacter l\'equipe Ulyss.co pour l\'activation de votre compte.');
                        redirect('entreprise/' . $BusinessEntreprise->getAlias());

                    }

                    $id     = $this->encrypt->encode($adminEnt->id);
                    $id_ent = $this->encrypt->encode($adminEnt->id_entreprise);

                    if ($this->session->userdata('logged_in_site_web')) {
                        $this->session->unset_userdata('logged_in_site_web');
                    } elseif ($this->session->userdata('ent_logged_in_site_web')) {
                        $this->session->unset_userdata('ent_logged_in_site_web');
                    }

                    $session = [
                        'id'              => $id,
                        'nom'             => $adminEnt->nom,
                        'prenom'          => $adminEnt->prenom,
                        'tel'             => $adminEnt->tel,
                        'email'           => $adminEnt->email_pro,
                        'id_ent'          => $id_ent,
                        'statut'          => $adminEnt->statut,
                        'last_connection' => $adminEnt->update_date,
                        'logged_in'       => true
                    ];

                    $this->session->set_userdata('ent_logged_in_site_web', $session);
                    $log = [
                        'etat_connexion' => '1',
                        'update_date'    => date('Y-m-d H:i:s')
                    ];

                    $this->ModelEntrepriseAdmin->update_profile($adminEnt->email_pro, $log);

                    $this->session->set_flashdata('message_valid', 'Bienvenue ' . $adminEnt->nom . ' ' . $adminEnt->prenom . ' !');

                    redirect('entreprise/' . $BusinessEntreprise->getAlias());


                } else {
                    $this->session->set_flashdata('message_error', 'Identifiant ou mot de passe non valide !');
                    redirect(base_url() . 'employeur');
                }

            } else {
                $this->session->set_flashdata('message_error', 'Identifiant ou mot de passe non valide !');
                redirect(base_url() . 'employeur');
            }

        }
    }

    public function mdp_oublier()
    {
        $email     = $this->input->post("email_oublier");
        $admin_ent = $this->ModelEntrepriseAdmin->getAdminEntByMail($email);

        if ($admin_ent != null) {
            $respons['operation'] = true;
            $respons['msg']       = "Votre mot de passe vous a été transmis par e-mail !";

            SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_MOT_DE_PASSE_OUBLIER,
                $email,
                [
                    'FIRSTNAME' => $admin_ent->prenom,
                    'LOGIN'     => $admin_ent->email_pro,
                    'PASSWORD'  => $this->encrypt->decode($admin_ent->mot_de_passe),
                ]
            );
            echo json_encode($respons);
        } else {
            $respons['operation'] = false;
            $respons['msg']       = "Votre adresse mail n'existe pas";
            echo json_encode($respons);
        }
    }
}
