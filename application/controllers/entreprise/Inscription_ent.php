<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Inscription_ent extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Register_ent()
    {
        $this->form_validation->set_rules('last_name', 'last_name', 'required|min_length[3]|max_length[15]',
            [
                'min_length' => 'Le prénom doit contenir au moins 3 charactères.',
                'max_length' => 'Le prénom ne doit pas contenir plus de 15 charactères.',
                'required'   => 'Veuillez indiquer un prénom.'
            ]);
        $this->form_validation->set_rules('first_name', 'first_name', 'required|min_length[3]|max_length[15]',
            [
                'min_length' => 'Le nom doit contenir au moins 3 charactères.',
                'max_length' => 'Le nom ne doit pas contenir plus de 15 charactères.',
                'required'   => 'Veuillez indiquer un nom.'
            ]);
        $this->form_validation->set_rules('email', 'Adresse mail', 'trim|required|valid_email|is_unique[admin_employeur.Email_pro]',
            [
                'required'    => 'Veuillez indiquer une adresse mail.',
                'valid_email' => 'Adresse mail non valide.',
                'is_unique'   => 'L\'adresse mail est déjà utilisée.'
            ]);

        $this->form_validation->set_rules('entrepriselabel', 'Nom entreprise', 'required',
            [
                'required' => 'Veuillez sélectionner votre entreprise dans menu déroulant.',
            ]);

        $this->form_validation->set_rules('entreprise', 'Id entreprise', 'required',
            [
                'required' => 'Veuillez sélectionner votre entreprise dans menu déroulant.',
            ]);

        $this->form_validation->set_rules('function', 'Poste actuel', 'trim|required',
            [
                'required' => 'Veuillez renseigner votre fonction'
            ]);

        //$this->form_validation->set_rules('site', 'Site web', 'required');
        $this->form_validation->set_rules('nbr_employes', 'Nombre demployes', 'trim|required|alpha_numeric',
            [
                'required'      => 'Veuillez indiquer une confirmation de mot de passe.',
                'alpha_numeric' => 'Veuillez saisir uniquement un nombre.',
            ]);

        $this->form_validation->set_rules('tel', 'Telephone', 'required|min_length[10]|max_length[15]|alpha_numeric',
            [
                'min_length'    => 'Le numéro de téléphone doit contenir au moins 10 charactères.',
                'max_length'    => 'Le mot de passe  ne doit pas contenir plus de 15 charactères.',
                'required'      => 'Veuillez indiquer un numéro de téléphone.',
                'alpha_numeric' => 'Numéro de téléphone non valide.',
            ]);

        $this->form_validation->set_rules('mdp', 'Mot de passe', 'required|min_length[3]|max_length[72]',
            [
                'min_length' => 'Le mot de passe doit contenir au moins 3 charactères.',
                'max_length' => 'Le mot de passe  ne doit pas contenir plus de 72 charactères.',
                'required'   => 'Veuillez indiquer un mot de passe.'
            ]);
        $this->form_validation->set_rules('mdp_confirm', 'Confirmation Mot de passe', 'required|matches[mdp]|min_length[3]|max_length[72]',
            [
                'min_length' => 'Le mot de passe doit contenir au moins 3 charactères.',
                'max_length' => 'Le mot de passe  ne doit pas contenir plus de 72 charactères.',
                'required'   => 'Veuillez indiquer une confirmation de mot de passe.',
                'matches'    => 'Le mot de passe et sa confirmation ne correspondent pas.',
            ]);
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message_error', 'Veuillez remplir les champs obligatoires ci-dessous. ');
            $this->load->view('template/header', $this->datas);
            $this->load->view('employeur');
            $this->load->view('template/footer', $this->datas);
        } else {
            $data['nom']            = $this->security->xss_clean($this->input->post('last_name'));
            $data['prenom']         = $this->security->xss_clean($this->input->post('first_name'));
            $data['tel']            = $this->security->xss_clean($this->input->post('tel'));
            $data['email_pro']      = $this->security->xss_clean($this->input->post('email'));
            $data['id_entreprise']  = $this->security->xss_clean($this->input->post('entreprise'));
            $data['nom_entreprise'] = $this->security->xss_clean($this->input->post('entrepriselabel'));
            $data['fonction']       = $this->security->xss_clean($this->input->post('function'));
            $data['nbr_employes']   = $this->security->xss_clean($this->input->post('nbr_employes'));
            $data['mot_de_passe']   = $this->encrypt->encode($this->security->xss_clean($this->input->post('mdp')));
            $insertEntreprise       = $this->ModelEntrepriseAdmin->save($data);

            if ($insertEntreprise) {
                $mail
                    = 'Bonjour,<br/><br/>
 
                Vous venez de recevoir une nouvelle demande de d\'utilisateur depuis la page Contact.<br/><br/>

                 Voici les informations saisies :<br/><br/>
                 id employeur : <strong>' . $insertEntreprise->id . '</strong><br/>
                 nom entreprise : <strong>' . $data['nom_entreprise'] . '</strong><br/>
                 id entreprise : <strong>' . $data['id_entreprise'] . '</strong><br/>
                 nom : <strong>' . $data['nom'] . '</strong><br/>
                 prenom : <strong>' . $data['prenom'] . '</strong><br/>               
                 Contact téléphonique : <strong>' . $data['tel'] . '</strong><br/>
                 Contact email pro : <strong>' . $data['email_pro'] . '</strong><br/>
                 fonction : <strong>' . $data['fonction'] . '</strong><br/><br/>';

                SendInBlue::sendEmail('ryadh@ulyss.co', 'Service employeur', 'Inscription employeur', $mail);
                SendInBlue::sendEmail('employeur@ulyss.co', 'Service employeur', 'Inscription employeur', $mail);
                SendInBlue::sendEmail('radhoine@ulyss.co', 'Service employeur', 'Inscription employeur', $mail);
                $this->session->set_flashdata('message_valid', "Votre demande de compte employeur a été entregistrée et sera etudiée par l'equipe Ulyss.co !");
                redirect(base_url() . 'employeur');
            } else {
                $this->session->set_flashdata('message_error', 'Une erreur technique est survenue veuillez réessayer dans quelques instants. ');
                redirect(base_url() . 'employeur');
            }
        }
    }

}

?>