<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Mailing {
public function __construct()
{
    $this->CI =& get_instance();
    $this->config_smtp=$this->CI->config->item("smtp_config");
}

public function oublie_password($email_to) {
                            $utilisateur=$this->CI->user->GetUtilisateurtByEmail($email_to);
                            if(empty($utilisateur)){
                             return false;
                                    }else{

                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(5);
                            $gabarit=$this->CI->user->GetConfigValue(5);

                            $code=random_string('alnum',16);
                            $data_r['code_reinitialiser']=$code;
                            $this->CI->user->EditUser($utilisateur->id,$data_r);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{code}}",$code,$gabarit); 
                            $gabarit = str_replace("{{name}}",$utilisateur->prenom.' '.$utilisateur->nom,$gabarit); 
                            $gabarit = str_replace("{{label}}",$subject,$gabarit); 
                            $gabarit = str_replace("{{year_c}}",date("Y"),$gabarit); 

                            $data_html['content']=$gabarit;
                            $data_html['label']=$subject;
                            $html=$this->CI->load->view('gabarit_email/gabarit',$data_html,true);
    
                    
                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,"Ulyss Team");
                            $this->CI->email->to($email_to);

                           $this->CI->email->subject(utf8_decode("Ulyss - Réinitialisation de votre mot de passe"));
                           $this->CI->email->message(utf8_decode($html));
                           $this->CI->email->send();
                           return true;
                           } 
} 
public function email_inscription($data) {
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(3);
                            $gabarit=$this->CI->user->GetConfigValue(3);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{code}}",$data['code_activation'],$gabarit); 
                            $gabarit = str_replace("{{name}}",$data['prenom'].' '.$data['nom'],$gabarit); 
                            $gabarit = str_replace("{{label}}",$subject,$gabarit); 
                            $gabarit = str_replace("{{year_c}}",date("Y"),$gabarit); 
                            $data_html['content']=$gabarit;
                            $data_html['label']=$subject;
                            $html=$this->CI->load->view('gabarit_email/gabarit',$data_html,true);

                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,"Ulyss Team");
                            $this->CI->email->to($data['email']);

                           $this->CI->email->subject(utf8_decode($subject));
                           $this->CI->email->message(utf8_decode($html));
                           $this->CI->email->send();
                           return true;
} 
public function email_add_talent($data) {
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(3);
                            $gabarit=$this->CI->user->GetConfigValue(39);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{email}}",$data['email'],$gabarit); 
                            $gabarit = str_replace("{{password}}",$data['my_pass'],$gabarit); 
                            $gabarit = str_replace("{{label}}",$subject,$gabarit); 
                            $gabarit = str_replace("{{year_c}}",date("Y"),$gabarit); 


                            $data_html['content']=$gabarit;
                            $data_html['label']=$subject;
                            $html=$this->CI->load->view('gabarit_email/gabarit',$data_html,true);

                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,utf8_decode("Ulyss:Votre compte coach partenaire vient d'être créé."));
                            $this->CI->email->to($data['email']);

                            $this->CI->email->subject($subject);
                            $this->CI->email->message(utf8_decode($html));
                            $this->CI->email->send();
                           return true;
} 
public function verified_email($data) {
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(15);
                            $gabarit=$this->CI->user->GetConfigValue(15);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{code}}",$data['code_activation'],$gabarit); 
                            $gabarit = str_replace("{{name}}",$data['prenom'].' '.$data['nom'],$gabarit); 
                            $gabarit = str_replace("{{label}}",$subject,$gabarit); 
                            $gabarit = str_replace("{{year_c}}",date("Y"),$gabarit); 


                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,utf8_decode($subject));
                            $this->CI->email->to($data['email']);

                           $this->CI->email->subject(utf8_decode($subject));
                           $this->CI->email->message(utf8_decode($gabarit));
                           $this->CI->email->send();
                           return true;
} 
/*Je reçois un message d’un autre membre*/
public function notifications_nouveau_msg_email($data){
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(20);
                            $gabarit=$this->CI->user->GetConfigValue(20);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{name}}",$data['name'],$gabarit); 
                            $gabarit = str_replace("{{sender}}",$data['sender'],$gabarit); 
                            $gabarit = str_replace("{{label}}",$subject,$gabarit); 
                            $gabarit = str_replace("{{year_c}}",date("Y"),$gabarit); 
                            $data_html['content']=$gabarit;
                            $data_html['label']=$subject;
                            $html=$this->CI->load->view('gabarit_email/gabarit',$data_html,true);
                            
                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,utf8_decode("Ulyss Team"));
                            $this->CI->email->to($data['email']);

                           $this->CI->email->subject(utf8_decode($subject));
                           $this->CI->email->message(utf8_decode($html));
                           $this->CI->email->send();
                           return true;
}  
/*nouveau sms twilio*/ 
public function notifications_nouveau_msg_sms($data=array()){
                   $this->CI->load->library('twilio');
                   $from="+15005550006";
                   $to=$data['phone'];
                   $message=$this->CI->user->GetConfigValue(21);
                   $message = str_replace("{{sender}}",$data['sender'],$message); 
                   $message = str_replace("{{name}}",$data['name'],$message); 
                   $response = $this->CI->twilio->sms($from, $to, $message);
                   if($response->IsError){
                     return true;
                    }else{
                    return false;
                    }
                }  

/*Une de mes demandes est acceptée ou refusée*/
public function notifications_refuse_demande_msg_email($data){
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(22);
                            $gabarit=$this->CI->user->GetConfigValue(22);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{name}}",$data['name'],$gabarit); 
                            $gabarit = str_replace("{{talent}}",$data['talent'],$gabarit); 
                            $gabarit = str_replace("{{client}}",$data['sender'],$gabarit); 
                            $gabarit = str_replace("{{label}}",$subject,$gabarit); 
                            $gabarit = str_replace("{{year_c}}",date("Y"),$gabarit);
                            if( isset($data['messageperso']) && $data['messageperso'] != '' )
                                $gabarit = str_replace("{{messageperso}}",'<br />Voici son message : <br />'.$data['messageperso'],$gabarit);
                            else
                                $gabarit = str_replace("{{messageperso}}",'',$gabarit);

                            $data_html['content']=$gabarit;
                            $data_html['label']=$subject;
                            $html=$this->CI->load->view('gabarit_email/gabarit',$data_html,true);

                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,utf8_decode($subject));
                            $this->CI->email->to($data['email']);

                           $this->CI->email->subject(utf8_decode($subject));
                           $this->CI->email->message(utf8_decode($html));
                           $this->CI->email->send();
                           return true;
}  

/*nouveau sms twilio*/ 
public function notifications_refuse_demande_msg_sms($data=array()){
                   $this->CI->load->library('twilio');
                   $from="+15005550006";
                   $to=$data['phone'];
                   $message=$this->CI->user->GetConfigValue(23);
                   $message = str_replace("{{client}}",$data['sender'],$message); 
                   $message = str_replace("{{name}}",$data['name'],$message); 
                   $message = str_replace("{{talent}}",$data['talent'],$message); 
                   $message = str_replace("{{date}}",$data['date'],$message); 
                   $message = str_replace("{{horaire}}",$data['horaire'],$message); 
                   $message = str_replace("{{lieu}}",$data['lieu'],$message); 
                   $response = $this->CI->twilio->sms($from, $to, $message);
                   if($response->IsError){
                     return true;
                    }else{
                    return false;
                    }
                }

/*Une de mes demandes est acceptée */
public function notifications_accepte_demande_msg_email($data){
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(24);
                            $gabarit=$this->CI->user->GetConfigValue(24);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{name}}",$data['name'],$gabarit); 
                            $gabarit = str_replace("{{talent}}",$data['talent'],$gabarit); 
                            $gabarit = str_replace("{{client}}",$data['sender'],$gabarit); 
                            $gabarit = str_replace("{{label}}",$subject,$gabarit); 

                            $data_html['content']=$gabarit;
                            $data_html['label']=$subject;
                            $html=$this->CI->load->view('gabarit_email/gabarit',$data_html,true);

                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,"Ulyss Team");
                            $this->CI->email->to($data['email']);

                           $this->CI->email->subject(utf8_decode($subject));
                           $this->CI->email->message(utf8_decode($html));
                           $this->CI->email->send();
                           return true;
}  
/*une demande valider par coach*/
public function notifications_valider_demande_msg_email($data){
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(40);
                            $gabarit=$this->CI->user->GetConfigValue(40);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{name}}",$data['name'],$gabarit); 
                            $gabarit = str_replace("{{id}}",$data['id'],$gabarit); 
                            $gabarit = str_replace("{{talent}}",$data['talent'],$gabarit); 
                            $gabarit = str_replace("{{client}}",$data['sender'],$gabarit); 
                            $gabarit = str_replace("{{label}}",$subject,$gabarit); 

                            $data_html['content']=$gabarit;
                            $data_html['label']=$subject;
                            $html=$this->CI->load->view('gabarit_email/gabarit',$data_html,true);

                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,"Ulyss Team");
                            $this->CI->email->to($data['email']);

                           $this->CI->email->subject(utf8_decode($subject));
                           $this->CI->email->message(utf8_decode($html));
                           $this->CI->email->send();
                           return true;
}
/*une demande valider par coach*/
public function notifications_valider_demande_msg_email_mentor($data){
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(49);
                            $gabarit=$this->CI->user->GetConfigValue(49);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit);
                            $gabarit = str_replace("{{telephone}}",$data['telephone'],$gabarit);
                            $gabarit = str_replace("{{user}}",$data['user'],$gabarit);
                            $gabarit = str_replace("{{name}}",$data['name'],$gabarit);
                            $gabarit = str_replace("{{label}}",$subject,$gabarit);

                            $data_html['content']=$gabarit;
                            $data_html['label']=$subject;
                            $html=$this->CI->load->view('gabarit_email/gabarit',$data_html,true);

                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,"Ulyss Team");
                            $this->CI->email->to($data['email']);

                           $this->CI->email->subject(utf8_decode($subject));
                           $this->CI->email->message(utf8_decode($html));
                           $this->CI->email->send();
                           return true;
}
/*nouveau sms twilio*/ 
public function notifications_accepte_demande_msg_sms($data=array()){
                   $this->CI->load->library('twilio');
                   $from="+15005550006";
                   $to=$data['phone'];
                   $message=$this->CI->user->GetConfigValue(25);
                   $message = str_replace("{{client}}",$data['sender'],$message); 
                   $message = str_replace("{{name}}",$data['name'],$message); 
                   $message = str_replace("{{talent}}",$data['talent'],$message); 
                   $response = $this->CI->twilio->sms($from, $to, $message);
                   if($response->IsError){
                     return true;
                    }else{
                    return false;
                    }
                } 

/*Je reçois une demande pour un de mes talents */
public function notifications_new_demande_msg_email($data){
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(26);
                            $gabarit=$this->CI->user->GetConfigValue(26);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{name}}",$data['name'],$gabarit); 
                            $gabarit = str_replace("{{talent}}",$data['talent'],$gabarit); 
                            $gabarit = str_replace("{{sender}}",$data['sender'],$gabarit); 
                            $gabarit = str_replace("{{label}}",$subject,$gabarit);
                            if( isset($data['id_demande_offre']) ){
                                $gabarit = str_replace("{{uri_message}}",'messages/conversation/'.$data['id_demande_offre'],$gabarit);
                            } else {
                                $gabarit = str_replace("{{uri_message}}",'messages',$gabarit);
                            }

                            $data_html['content']=$gabarit;
                            $data_html['label']=$subject;
                            $html=$this->CI->load->view('gabarit_email/gabarit',$data_html,true);

                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,utf8_decode($subject));
                            $this->CI->email->to($data['email']);

                           $this->CI->email->subject(utf8_decode($subject));
                           $this->CI->email->message(utf8_decode($html));
                           $this->CI->email->send();
                           return true;
}  
/*nouveau sms twilio*/ 
public function notifications_new_demande_msg_sms($data=array()){
                   $this->CI->load->library('twilio');
                   $from="+15005550006";
                   $to=$data['phone'];
                   $message=$this->CI->user->GetConfigValue(27);
                   $message = str_replace("{{client}}",$data['sender'],$message); 
                   $message = str_replace("{{name}}",$data['name'],$message); 
                   $message = str_replace("{{talent}}",$data['talent'],$message); 
                   $response = $this->CI->twilio->sms($from, $to, $message);
                   if($response->IsError){
                     return true;
                    }else{
                    return false;
                    }
                } 

/*new alerte*/
public function notifications_new_alerte_msg_email($data){
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(28);
                            $gabarit=$this->CI->user->GetConfigValue(28);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{name}}",$data['name'],$gabarit); 
                            $gabarit = str_replace("{{talent}}",$data['talent'],$gabarit); 
                            $gabarit = str_replace("{{wish}}",$data['wish'],$gabarit); 
                            $gabarit = str_replace("{{wanted}}",$data['sender'],$gabarit); 
                            $gabarit = str_replace("{{label}}",$subject,$gabarit); 
                            $gabarit = str_replace("{{year_c}}",date("Y"),$gabarit); 


                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,utf8_decode($subject));
                            $this->CI->email->to($data['email']);

                           $this->CI->email->subject(utf8_decode($subject));
                           $this->CI->email->message(utf8_decode($gabarit));
                           $this->CI->email->send();
                           return true;
}  
public function notifications_new_alerte_msg_sms($data=array()){
                   $this->CI->load->library('twilio');
                   $from="+15005550006";
                   $to=$data['phone'];
                   $message=$this->CI->user->GetConfigValue(29);
                   $message = str_replace("{{wanted}}",$data['sender'],$message); 
                   $message = str_replace("{{name}}",$data['name'],$message); 
                   $message = str_replace("{{talent}}",$data['talent'],$message); 
                   $message = str_replace("{{wish}}",$data['wish'],$message); 
                   $response = $this->CI->twilio->sms($from, $to, $message);
                   if($response->IsError){
                     return true;
                    }else{
                    return false;
                    }
                }
public function share($data){


                            $html=$this->CI->load->view('gabarit_email/share',$data,true);
                            $email=$this->CI->user->GetConfigValue(4);
                            $phras="Ulyss / ".$data['name'];
                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();
                            $this->CI->email->set_mailtype("html");
                            $this->CI->email->from($email,'Ulyss');
                            $this->CI->email->to($data['to']);
                             $this->CI->email->subject($phras);
                             $this->CI->email->message($html);
                             $this->CI->email->send();
                           return true;
                          
} 

/*refuser talent*/
public function refuserTalent($data){
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(37);
                            $gabarit=$this->CI->user->GetConfigValue(37);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{description}}",$data['text'],$gabarit); 



                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,utf8_decode($subject));
                            $this->CI->email->to($data['email']);

                           $this->CI->email->subject(utf8_decode($subject));
                           $this->CI->email->message(utf8_decode($gabarit));
                           $this->CI->email->send();
                           return true;
}
public function SendContact($data){
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(38);
                            $gabarit=$this->CI->user->GetConfigValue(38);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{file}}",$data['file'],$gabarit); 
                            $gabarit = str_replace("{{nom}}",$data['nom'],$gabarit); 
                            $gabarit = str_replace("{{email}}",$data['email'],$gabarit); 
                            $gabarit = str_replace("{{prenom}}",$data['prenom'],$gabarit); 
                            $gabarit = str_replace("{{ville}}",$data['ville'],$gabarit); 
                            $gabarit = str_replace("{{label}}",$subject,$gabarit); 
                            $gabarit = str_replace("{{year_c}}",date("Y"),$gabarit); 

                            $data_html['content']=$gabarit;
                            $data_html['label']=$subject;
                            $html=$this->CI->load->view('gabarit_email/gabarit',$data_html,true);

                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,"Ulyss Team");
                            $this->CI->email->to($email);

                           $this->CI->email->subject(utf8_decode($subject));
                           $this->CI->email->message(utf8_decode($html));
                           $this->CI->email->send();
                           return true;
} 
/*send email when payer coach*/
public function notifications_after_payer($data){
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(41);
                            $gabarit=$this->CI->user->GetConfigValue(41);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{name}}",$data['name'],$gabarit); 
                            $gabarit = str_replace("{{talent}}",$data['talent'],$gabarit); 
                            $gabarit = str_replace("{{date}}",$data['date'],$gabarit); 
                            $gabarit = str_replace("{{heure}}",$data['horaire'],$gabarit); 
                            $gabarit = str_replace("{{nom}}",$data['nom'],$gabarit); 
                            $gabarit = str_replace("{{prenom}}",$data['prenom'],$gabarit); 
                            $gabarit = str_replace("{{adresse}}",$data['adresse'],$gabarit); 
                            $gabarit = str_replace("{{tel}}",$data['tel'],$gabarit); 
                            $gabarit = str_replace("{{label}}",$subject,$gabarit); 

                            $data_html['content']=$gabarit;
                            $data_html['label']=$subject;
                            $html=$this->CI->load->view('gabarit_email/gabarit',$data_html,true);

                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,"Ulyss Team");
                            $this->CI->email->to($data['email']);

                           $this->CI->email->subject(utf8_decode($subject));
                           $this->CI->email->message(utf8_decode($html));
                           $this->CI->email->send();
                           return true;
} 
public function evaluer_or_faire_commentaire($data){
                            $email=$this->CI->user->GetConfigValue(4);
                            $subject=$this->CI->user->GetNameOrsubject(42);
                            $gabarit=$this->CI->user->GetConfigValue(42);

                            $gabarit = str_replace("{{base_url}}",base_url(),$gabarit); 
                            $gabarit = str_replace("{{name}}",$data['name'],$gabarit); 
                            $gabarit = str_replace("{{alias}}",$data['alias'],$gabarit); 
                            $gabarit = str_replace("{{id}}",$data['id'],$gabarit); 
                            $gabarit = str_replace("{{label}}",$subject,$gabarit); 

                            $data_html['content']=$gabarit;
                            $data_html['label']=$subject;
                            $html=$this->CI->load->view('gabarit_email/gabarit',$data_html,true);

                            $this->CI->load->library('email',$this->config_smtp);
                            $this->CI->load->library('parser');
                            $this->CI->email->clear();

                            $this->CI->email->from($email,"Ulyss Team");
                            $this->CI->email->to($data['email']);

                           $this->CI->email->subject(utf8_decode($subject));
                           $this->CI->email->message(utf8_decode($html));
                           $this->CI->email->send();
                           return true;
}  
}