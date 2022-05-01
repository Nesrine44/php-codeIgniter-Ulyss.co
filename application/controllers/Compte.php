<?php if(!defined('BASEPATH')) {
	exit('No direct script access allowed');
}
	
	class Compte extends CI_Controller
	{
		
		private $p_user, $p_businessuser;
		
		function __construct()
		{
			parent::__construct();
			$this->load->model('user_model', 'user');
			$this->load->model('demande_model', 'demande');
			$this->load->library('encrypt');
			$this->load->library('user_info');
			/*if (!$this->session->userdata('logged_in_site_web')) {
				redirect(base_url());
			}*/
			$this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
			$this->p_user         = $this->ModelUser->getById($this->id_user_decode);
			$this->p_businessuser = new BusinessUser($this->p_user);
		}
		
		public function index($bienvenue = null)
		{
			if(!$this->session->userdata('logged_in_site_web')) {
				redirect(base_url());
			}
			if($this->session->userdata('logged_in_site_web')) {
				$this->load->model('user_model', 'user');
				//update form information
				if($this->input->post("nom")) {
					$data_info['nom']    = $this->input->post("nom");
					$data_info['prenom'] = $this->input->post("prenom");
					
					
					$data_info['tel'] = "+33" . $this->input->post("tel");
					if($data_info['tel'] != $this->user_info->getTelUser()) {
						//                    $data_info['tel_verified'] = false;
					}
					// $data_info['adresse']   = $this->input->post("adresse");
					$data_info['ville']        = $this->input->post("ville");
					$data_info['presentation'] = $this->input->post("presentation");
					
					$data_info['sexe']           = $this->input->post("sexe");
					$data_info['date_naissance'] = $this->input->post("annee") . '-' . $this->input->post("mois") . '-' . $this->input->post("jour");
					//verification email
					if($this->input->post("email") != $this->user_info->getEmailUser()) {
						if(empty($this->user->GetUtilisateurtByEmail($this->input->post("email")))) {
							$data_info['email']           = $this->input->post("email");
							$data_info['hash']            = sha1($this->input->post("email") . ModelUserLinkedin::$hashString);
							$data_info['email_verified']  = false;
							$code                         = random_string('alnum', 16);
							$data_info['code_activation'] = $code;
							$this->load->library('mailing');
							$this->mailing->verified_email($data_info);
						}
					}
					
					$this->user->EditUser($this->id_user_decode, $data_info);
					//change alias
					if($this->input->post("prenom")) {
						$result = $this->user->GetUserByid($this->id_user_decode);
						if($this->id_user_decode == $result->alias) {
							$string = $this->input->post("nom") . "." . $this->input->post("prenom");
							$this->create_alias($string, $this->id_user_decode);
						}
					}
				}
				
				$this->datas['info_user']   = $this->user->GetUserByid($this->id_user_decode);
				$this->datas['list_villes'] = $this->user->GetVilles();
				$this->datas['bienvenue']   = false;
				if($bienvenue) {
					$this->datas['bienvenue'] = $bienvenue;
				}
				
				$this->load->view('template/header', $this->datas);
				$this->load->view('profil/compte/header_profile', $this->datas);
				$this->load->view('profil/compte/compte', $this->datas);
				$this->load->view('template/footer', $this->datas);
				
			}
		}
		
		
		public function monprofil()
		{
			if(!$this->session->userdata('logged_in_site_web')) {
				redirect(base_url());
			}
			if($this->session->userdata('logged_in_site_web')) {
				$data_info['BusinessUser']         = $this->getBusinessUser();
				$data_info['BusinessUserLinkedin'] = $this->getBusinessUser()->getBusinessUserLinkedin();
				
				/* Show page */
				$this->load->view('template/header', $this->datas);
				$this->load->view('profil/compte/header_profile', $this->datas);
				$this->load->view('profil/compte/profil', $data_info);
				$this->load->view('template/footer', $this->datas);
			}
		}
		
		function _unique_field_name($field_name)
		{
			return random_string('alnum', 20);  //This s is because is better for a string to begin with a letter and not a number
		}
		
		public function notifications()
		{
			$this->datas['notifications'] = $this->user->GetNotificationsUserByid($this->id_user_decode);
			$this->load->view('template/header', $this->datas);
			$this->load->view('profil/compte/header_profile', $this->datas);
			$this->load->view('profil/compte/compte_item/notifications', $this->datas);
			$this->load->view('profil/compte/compte_item/footer_compte');
			$this->load->view('template/footer', $this->datas);
		}
		
		public function fermeture_du_compte()
		{
			$this->datas['notifications'] = $this->user->GetNotificationsUserByid($this->id_user_decode);
			$this->load->view('template/header', $this->datas);
			$this->load->view('profil/compte/header_profile', $this->datas);
			$this->load->view('profil/compte/compte_item/fermeture_du_compte', $this->datas);
			$this->load->view('profil/compte/compte_item/footer_compte');
			$this->load->view('template/footer', $this->datas);
		}
		
		public function upload_avatar()
		{
			
			$avatar   = $this->input->post('avatar');
			$img      = str_replace('[removed]', '', $avatar);
			$img      = str_replace('data:image/png;base64,', '', $img);
			$data_img = base64_decode($img);
			$this->load->library('urlify');
			$name_user = $this->urlify->filter($this->session->userdata('logged_in_site_web')["name"]);
			$name      = $name_user . '_' . $this->_unique_field_name($this->session->userdata('logged_in_site_web')["name"]) . '.png';
			//$file = 'upload/avatar/'.$name;
			$file = $this->config->item('upload_avatar') . $name;
			//CB : Utilisation de la librairie s3File
			$success = $this->s3file->file_put_contents($file, $data_img);
			$datas   = ['avatar' => $name];
			//delete image in disk
			if($this->user_info->getPictureUser(1) != "default.jpg" && !strpos($this->user_info->getPictureUser(1), "http://")) {
				$this->s3file->unlink($this->config->item('upload_avatar') . $this->user_info->getPictureUser(1));
			}
			$this->user->EditUser($this->id_user_decode, $datas);
			echo json_encode($datas);
		}
		
		private function create_alias($string, $id)
		{
			if($this->session->userdata('logged_in_site_web')) {
				$this->load->model('user_model', 'user');
				$this->load->library('urlify');
				//$search = array ('@[éèêëÊË]@i','@[àâäÂÄ]@i','@[îïÎÏ]@i','@[ûùüÛÜ]@i','@[ôöÔÖ]@i','@[ç]@i','@[ ]@i','@[^a-zA-Z0-9_]@');
				//$replace = array ('e','a','i','u','o','c','_','');
				//$result=preg_replace($search, $replace, $in);
				$verifcation = $this->urlify->filter($string);
				$result      = $this->user->verifcationExistAlias($verifcation);
				if($result) {
					$i = 1;
					while($result) {
						$verifcation = $verifcation . "." . $i;
						$result      = $this->user->verifcationExistAlias($verifcation);
						$i++;
					}
					$datas['alias'] = $verifcation;
					$this->user->EditUser($id, $datas);
				} else {
					$datas['alias'] = $verifcation;
					$this->user->EditUser($id, $datas);
				}
			}
			
			return true;
		}
		
		public function change_coverture()
		{
			if($this->session->userdata('logged_in_site_web')) {
				if($this->input->post("id_coverture")) {
					$data_info['cover'] = $this->input->post("id_coverture");
					$this->user->EditUser($this->id_user_decode, $data_info);
					$html['msg'] = "<p class='succed_p'>Votre coverture est changer</p>";
					echo json_encode($html);
				}
			} else {
				$html['msg'] = "serveur not work";
				echo json_encode($html);
			}
		}
		
		public function change_coverture_talent()
		{
			if($this->session->userdata('logged_in_site_web')) {
				if($this->input->post("id_coverture")) {
					$data_info['coverture'] = $this->input->post("id_coverture");
					$this->load->model('talent_model', 'talent');
					$this->talent->EditTalentByiAndIduser($this->input->post("id_talent"), $this->id_user_decode, $data_info);
					$html['msg'] = "<p class='succed_p'>Votre coverture est changer</p>";
					echo json_encode($html);
				}
			} else {
				$html['msg'] = "serveur not work";
				echo json_encode($html);
			}
		}
		
		public function send_confirmation_a_nouveau()
		{
			$info_user = $this->user->GetUserByid($this->id_user_decode);
			
			$datas['email_verified']  = false;
			$code                     = random_string('alnum', 16);
			$datas['code_activation'] = $code;
			$this->user->EditUser($this->id_user_decode, $datas);
			
			$this->load->library('mailing');
			$datas['email']  = $info_user->email;
			$datas['nom']    = $info_user->nom;
			$datas['prenom'] = $info_user->prenom;
			if($this->mailing->verified_email($datas)) {
				redirect(base_url() . "compte/confirmation");
			}
		}
		
		public function confirmation_phone()
		{
			$BusinessUser = $this->getBusinessUser();
			$User         = $BusinessUser->getUser();
			//        $User['tel_verified']       = false;
			$User['code_phone'] = $BusinessUser->getCodePhone() == '' ? random_string('nozero', 4) : $BusinessUser->getCodePhone();
			$User->save($User);
			SendInBlue::sendSms($BusinessUser->getTelephone(), 'Bonjour, pour vérifier votre numéro, veuillez rentrer le code ' . $User['code_phone'] . ' sur le site ulyss.co');
			$respons['status'] = "ok";
			echo json_encode($respons);
		}
		
		
		public function do_confirmer_phone()
		{
			if($this->input->post("code")) {
				$codesaisit   = $this->input->post("code");
				$BusinessUser = $this->getBusinessUser();
				if($codesaisit == $BusinessUser->getCodePhone()) {
					$User['id']           = $BusinessUser->getId();
					$User['tel_verified'] = true;
					$this->ModelUser->save($User);
					$respons['status'] = "ok";
					echo json_encode($respons);
				} else {
					$respons['status'] = "no";
					echo json_encode($respons);
				}
			} else {
				$respons['status'] = "no1";
				echo json_encode($respons);
			}
		}
		
		public function do_confirmer_phone_mentor()
		{
			if($this->input->post("code")) {
				$codesaisit = $this->input->post("code");
				$User       = $this->session->userdata('InscriptionMentorInfo');
				if($codesaisit == $User['code_phone']) {
					$User['tel_verified'] = true;
					$this->session->set_userdata('InscriptionMentorInfo', $User);
					$respons['status'] = "ok";
					echo json_encode($respons);
				} else {
					$respons['status'] = "no";
					echo json_encode($respons);
				}
			} else {
				$respons['status'] = "no";
				echo json_encode($respons);
			}
		}
		
		
		public function do_confirmer_phone_sociaux()
		{
			if($this->input->post("tel")) {
				$datas['tel'] = "+33" . $this->input->post('tel');
				if($this->input->post('code') and $this->session->userdata('code_phone') and $this->input->post('code') == $this->session->userdata('code_phone')) {
					$datas['tel_verified'] = true;
					$this->session->unset_userdata('code_phone');
				}
				$info_user = $this->user->GetUserByid($this->id_user_decode);
				$this->user->EditUser($this->id_user_decode, $datas);
				
				$respons['status'] = "ok";
				echo json_encode($respons);
			} else {
				$respons['status'] = "no";
				echo json_encode($respons);
			}
		}
		
		public function modifications_notifications()
		{
			if($this->input->post("name")) {
				if($this->input->post("name") == "notifications_msg_membre") {
					$datas['notifications_msg_membre'] = $this->input->post("notification");
					$this->user->EditUser($this->id_user_decode, $datas);
				} else {
					if($this->input->post("name") == "notifications_demande_accepte_refuse") {
						$datas['notifications_demande_accepte_refuse'] = $this->input->post("notification");
						$this->user->EditUser($this->id_user_decode, $datas);
					} else {
						if($this->input->post("name") == "notifications_demande_pour_talent") {
							$datas['notifications_demande_pour_talent'] = $this->input->post("notification");
							$this->user->EditUser($this->id_user_decode, $datas);
						} else {
							if($this->input->post("name") == "notifcations_alertes") {
								$datas['notifcations_alertes'] = $this->input->post("notification");
								$this->user->EditUser($this->id_user_decode, $datas);
							} else {
								if($this->input->post("name") == "optin_news") {
									$datas['optin_news'] = $this->input->post("notification");
									$this->user->EditUser($this->id_user_decode, $datas);
								}
							}
						}
					}
				}
				$respons['status'] = "ok";
				echo json_encode($respons);
			}
			
		}
		
		public function fermer_mon_compte()
		{
			$datas['fermer'] = true;
			$this->user->EditUser($this->id_user_decode, $datas);
			//add raisons
			$data_r['user_id']        = $this->id_user_decode;
			$data_r['raisons']        = $this->input->post("raisons");
			$data_r['ameliorer']      = $this->input->post("ameliorer");
			$data_r['recommanderiez'] = ($this->input->post("recomandation") == "oui") ? true : false;
			$this->user->AddRaison($data_r);
			$this->session->unset_userdata('logged_in_site_web');
			$this->session->sess_destroy();
			$respons['status'] = "ok";
			$respons['msg']    = "Votre compte est bloqué";
			echo json_encode($respons);
		}
	}
