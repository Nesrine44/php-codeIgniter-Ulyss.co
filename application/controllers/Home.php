<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}


class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('encrypt');
    }

    public function index()
    {
        /* METAS SEO */
        $this->datas['SEO_title_page'] = 'ULYSS.CO : Découvrez l\'entreprise, faites le bon choix de carrière';
        $this->datas['SEO_desc_page']  = '91% des recruteurs contactent les anciens employeurs des candidats ... et si on inversait les rôles? Un Mentor travaille ou a travaillé dans l\'entreprise que vous convoitez, il est prêt à vous conseiller. Contactez-le pour faire le bon choix';

        /* FACEBOOK SHARING */
        $this->datas['sharing']['facebook']['og:type']        = 'website';
        $this->datas['sharing']['facebook']['og:url']         = base_url();
        $this->datas['sharing']['facebook']['og:site_name']   = 'Ulyss.co';
        $this->datas['sharing']['facebook']['og:title']       = 'Ulyss.co';
        $this->datas['sharing']['facebook']['og:description'] = 'Un Mentor travaille dans la société que vous convoitez. Discutez directement avec lui afin de mieux connaitre l’entreprise et faire le bon choix de carrière.';
        $this->datas['sharing']['facebook']['og:image']       = base_url('assets/img/social/partage.jpg');

        /* TWITTER SHARING */
        $this->datas['sharing']['twitter']['twitter:card']        = 'summary_large_image';
        $this->datas['sharing']['twitter']['twitter:site']        = '@Ulyss.co';
        $this->datas['sharing']['twitter']['twitter:creator']     = '@Ulyss.co';
        $this->datas['sharing']['twitter']['twitter:title']       = $this->datas['sharing']['facebook']['og:title'];
        $this->datas['sharing']['twitter']['twitter:description'] = 'Vous êtes candidat? Faites le bon choix d\'entreprise en échangeant directement avec des employés sur Ulyss.co';
        $this->datas['sharing']['twitter']['twitter:image']       = $this->datas['sharing']['facebook']['og:image'];

        $this->load->view('template/header', $this->datas);
        $this->load->view('home', $this->datas);
        $this->load->view('template/footer', $this->datas);

    }

    public function employeur()
    {
        if ($this->input->post()) {
            $entreprise = $this->input->post('entreprise');
            $nom        = $this->input->post('nom');
            $email      = $this->input->post('email');
            $telephone  = $this->input->post('telephone');
            $message    = $this->input->post('message');

            SendInBlue::sendTemplateMail(SendInBlue::TEMPLATE_MAIL_CONTACT_EMPLOYEUR,
                'employeur@ulyss.co',
                [
                    'LASTNAME' => $nom,
                    'COMPANY'  => $entreprise,
                    'PHONE'    => $telephone,
                    'EMAIL'    => $email,
                    'MESSAGE'  => $message,
                ]
            );
            /* Pour éviter en cas de rechargement de page de renvoyer un mail (evite un second post mémorisé par le navigateur) */
            redirect('/employeur?message');
        }

        /* METAS SEO */
        $this->datas['SEO_title_page'] = 'ULYSS.CO : Vos collaborateurs sont vos meilleurs ambassadeurs';
        $this->datas['SEO_desc_page']  = '90% des candidats souhaitent contacter un employé avant de postuler. Mettez vos collaborateurs au centre de votre stratégie de Marque Employeur pour attirer les meilleurs talents. Vous êtes interessés par notre service ? Contactez-nous';

        $datas['messagesend'] = $this->input->get('message');
        $this->load->view('template/header', $this->datas);
        $this->load->view('employeur', $datas);
        $this->load->view('template/footer', $this->datas);
    }

    public function contact()
    {

        if ($this->input->post()) {
            $service   = $this->input->post('service');
            $prenom    = $this->input->post('prenom');
            $nom       = $this->input->post('nom');
            $email     = $this->input->post('email');
            $telephone = $this->input->post('telephone');
            $message   = $this->input->post('message');
            $check     = $this->input->post('accept');

            $mail
                = 'Bonjour,<br/><br/>
 
                Vous venez de recevoir une nouvelle demande de d\'utilisateur depuis la page Contact.<br/><br/>

                 Voici les informations saisies :<br/><br/>
                 Service : <strong>' . $service . '</strong><br/>
                 Nom : <strong>' . $nom . '</strong><br/>
                 prenom : <strong>' . $prenom . '</strong><br/>
                 Contact téléphonique : <strong>' . $telephone . '</strong><br/>
                 Contact email : <strong>' . $email . '</strong><br/>
                 Message : <strong>' . $message . '</strong><br/><br/>';

            if ($check == 'accept') {
                $mail .= "<strong>l'utilisateur accepte de recevoir toute l'actualité de ulyss.co</strong><br/><br/>";
            } else {
                $mail .= "<strong>l'utilisateur n'accepte pas de recevoir toute l'actualité de ulyss.co </strong><br/><br/>";
            }


            SendInBlue::sendEmail($service, 'Service Contact', 'Contact Utilisateur', $mail);
            /* Pour éviter en cas de rechargement de page de renvoyer un mail (evite un second post mémorisé par le navigateur) */

            $this->session->set_flashdata('message_valid', 'Votre message a été envoyé aux équipes Ulyss.co ');
            $datas['messagesend'] = $this->input->get('message');
            redirect('/home');
        }

        $datas['messagesend'] = $this->input->get('message');
        $this->load->view('template/header', $this->datas);
        $this->load->view('contact', $datas);
        $this->load->view('template/footer', $this->datas);

    }
}
