<?php
	
	class Backoffice extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('ulyssdev/ModelBackoffice', 'ModelBackoffice');
			$this->load->model('andafter/ModelEntreprise', 'ModelEntreprise');
			$this->load->model('andafter/ModelSearch', 'ModelSearch');
			$this->load->library('BusinessEntreprise');
			$this->load->library('encrypt');
		}
		
		public function index()
		{
			$adminEntLogged = $this->session->has_userdata('ent_logged_in_site_web');
			
			if($adminEntLogged == true) {
				$this->id_admin_ent_decode = $this->encrypt->decode($this->session->userdata('ent_logged_in_site_web')['id']);
				$this->id_ent_decode       = $this->encrypt->decode($this->session->userdata('ent_logged_in_site_web')['id_ent']);
				
				$entInfo                  = $this->ModelEntreprise->GetEntrepriseById($this->id_ent_decode);
				$BusinessEntreprise       = new BusinessEntreprise($entInfo);
				$data["EntrepriseMontor"] = $BusinessEntreprise->getMentorProfil();
				
				$last_connection = $this->session->userdata('ent_logged_in_site_web')['last_connection'];
				
				$stat = (object)
				[
					'id_ent'          => $this->id_ent_decode,
					'last_connection' => $last_connection
				];
				
				$data['BusinessStat'] = $stat;
				
				$this->load->view('template/header', $this->datas);
				$this->load->view('entreprises/header_adminEntreprise');
				$this->load->view('entreprises/admin_entreprise', $data);
				$this->load->view('template/footer', $this->datas);
			}
		}
		
		public function setFormOfSendMsg()
		{
			$this->form_validation->set_rules
			(
				'destinataire', 'destinataire',
				'required',
				[
					'required' => 'Veuillez choisir un destinataire.'
				]
			);
			
			$this->form_validation->set_rules
			(
				'titre', 'titre',
				'required|min_length[3]|max_length[72]',
				[
					'min_length' => 'Le titre doit contenir au moins 3 charactères.',
					'max_length' => 'Le titre ne doit pas contenir plus de 42 charactères.',
					'required'   => 'Veuillez indiquer un titre.'
				]
			);
			
			$this->form_validation->set_rules
			(
				'message', 'message',
				'required|min_length[3]|max_length[172]',
				[
					'min_length' => 'Le message doit contenir au moins 3 charactères.',
					'max_length' => 'Le message ne doit pas contenir plus de 172 charactères.',
					'required'   => 'Message vide !'
				]
			);
			
			if($this->form_validation->run() == false) {
				$this->load->view('template/header', $this->datas);
				$this->load->view('home');
				$this->load->view('template/footer', $this->datas);
			} else {
				if($this->input->post('login')) {
					$mailUser = $this->security->xss_clean($this->input->post('login'));
					$adminEnt = $this->ModelEntrepriseAdmin->getAdminEntByMail($mailUser);
					
					if($adminEnt == null) {
						$this->session->set_flashdata('message_error', 'Identifiant ou mot de passe non valide !');
						redirect(base_url() . 'employeur');
					}
					
					$password           = $this->security->xss_clean($this->input->post('password'));
					$passwordBdd        = $this->encrypt->decode($adminEnt->mot_de_passe);
					$entInfo            = $this->ModelEntreprise->GetEntrepriseById($adminEnt->id_entreprise);
					$BusinessEntreprise = new BusinessEntreprise($entInfo);
					
					if($passwordBdd === $password && $adminEnt->email_pro === $mailUser) {
						if(ModelEntrepriseAdmin::VALID_STATUT != $this->ModelEntrepriseAdmin->checkStatut($adminEnt->id)) {
							$this->session->set_flashdata('message_error', 'Veuillez contacter l\'equipe Ulyss.co pour l\'activation de votre compte.');
							redirect('entreprise/' . $BusinessEntreprise->getAlias());
						}
						
						$id     = $this->encrypt->encode($adminEnt->id);
						$id_ent = $this->encrypt->encode($adminEnt->id_entreprise);
						
						if($this->session->userdata('logged_in_site_web')) {
							$this->session->unset_userdata('logged_in_site_web');
						} else if($this->session->userdata('ent_logged_in_site_web')) {
							$this->session->unset_userdata('ent_logged_in_site_web');
						}
						
						$session
							= [
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
						$log
							= [
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
	}