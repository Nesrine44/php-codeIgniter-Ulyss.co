<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Edit_profil extends CI_Controller
{

    function __construct()
    {
        parent::__construct();


    }

    public function biographie($alias = "")
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $this->load->model('user_model', 'user');
            if ($this->input->post("biographie")) {
                $data_info['biographie'] = $this->input->post("biographie");
                $this->load->library('encrypt');
                $session = $this->session->userdata('logged_in_site_web');
                $id = $this->encrypt->decode($session['id']);
                $this->user->EditUser($id, $data_info);
            }
            $this->load->library('encrypt');
            $session = $this->session->userdata('logged_in_site_web');
            $id = $this->encrypt->decode($session['id']);
            $data['info_user'] = $this->user->GetUserByid($id);
            $this->load->view('template/header', $this->datas);
            $this->load->view('club/header_club-profil');
            $this->load->view('club/biographie', $data);
            $this->load->view('template/footer', $this->datas);

        }
    }

    public function apropos()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $this->load->library('encrypt');
            $session = $this->session->userdata('logged_in_site_web');
            $id = $this->encrypt->decode($session['id']);
            $this->load->model('user_model', 'user');
            $data['info_user'] = $this->user->GetUserByid($id);
            $data['formation'] = $this->user->GetUsersAproposByID($id, 'formation');
            $data['experience'] = $this->user->GetUsersAproposByID($id, 'experience');
            $data['expertise'] = $this->user->GetUsersAproposByID($id, 'expertise');
            $this->load->view('template/header', $this->datas);
            $this->load->view('club/header_club-profil');
            $this->load->view('club/apropos-profil', $data);
            $this->load->view('footer');
            $this->load->view('template/footer', $this->datas);
        }
    }

    public function index()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $this->load->model('user_model', 'user');
            //update form information
            if ($this->input->post("nom")) {
                $data_info['nom'] = $this->input->post("nom");
                $data_info['prenom'] = $this->input->post("prenom");
                $data_info['citation'] = $this->input->post("citation");
                $data_info['facebook'] = $this->input->post("facebook");
                $data_info['twitter'] = $this->input->post("twitter");
                $data_info['youtube'] = $this->input->post("youtube");
                $data_info['linkedin'] = $this->input->post("linkedin");
                $data_info['specialite'] = $this->input->post("specialite");
                if ($this->input->post("cover")) {
                    $data_info['cover'] = $this->input->post("cover");
                }

                if (isset($_FILES["file"]["name"]) && $_FILES["file"]["error"] == 0) {
                    $allowedExts = array("gif", "jpeg", "jpg", "png");
                    $temp = explode(".", $_FILES["file"]["name"]);
                    $extension = end($temp);
                    $_FILES["file"]["name"] = $this->_unique_field_name($_FILES["file"]["name"]);
                    $_FILES["file"]["name"] .= "." . $extension;
                    if ($_FILES["file"]["error"] > 0) {
                        echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                    } else {
                        //CB : Utilisation de la librairie s3File
                        if ($this->s3file->file_exists("uploads/users/avatar/" . $_FILES["file"]["name"])) {
                            $this->s3file->unlink("uploads/users/avatar/" . $_FILES["file"]["name"]);
                        }
                        $this->s3file->move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/users/avatar/" . $_FILES["file"]["name"]);
                        $data_info['avatar'] = $_FILES["file"]["name"];
                    }
                }

                $data_info['email'] = $this->input->post("email");
                $this->load->library('encrypt');
                $session = $this->session->userdata('logged_in_site_web');
                $id = $this->encrypt->decode($session['id']);
                $this->user->EditUser($id, $data_info);
                //change alias
                if ($this->input->post("prenom")) {
                    $result = $this->db->get_where("user", array("id" => $id))->row();
                    if ($id == $result->alias) {
                        $string = $this->input->post("nom") . "." . $this->input->post("prenom");
                        $this->create_alias($string, $id);
                    }
                }
            }
            //end
            $this->load->library('encrypt');
            $session = $this->session->userdata('logged_in_site_web');
            $id = $this->encrypt->decode($session['id']);

            $data['info_user'] = $this->user->GetUserByid($id);
            //get coverture users
            // $data['coverture_photo']=$this->user->GetCoverturePhoto();

            $this->load->view('template/header', $this->datas);
            $this->load->view('profil/compte/header_profile');
            $this->load->view('mon_compte', $data);
            $this->load->view('template/footer', $this->datas);

        }
    }

    function _unique_field_name($field_name)
    {
        return random_string('alnum', 20);  //This s is because is better for a string to begin with a letter and not a number
    }

    public function mot_de_passe()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $this->load->library('encrypt');
            $session = $this->session->userdata('logged_in_site_web');
            $id = $this->encrypt->decode($session['id']);
            $this->load->model('user_model', 'user');
            $data['info_user'] = $this->user->GetUserByid($id);
            $this->load->view('template/header', $this->datas);
            $this->load->view('club/header_club-profil');
            $this->load->view('club/mot_de_passe', $data);
            $this->load->view('footer');
            $this->load->view('template/footer', $this->datas);
        }
    }

    public function change_password()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $this->load->model('user_model', 'user');
            if ($this->input->post("nouveau")) {
                $this->load->library('encrypt');
                $session = $this->session->userdata('logged_in_site_web');
                $id = $this->encrypt->decode($session['id']);
                // $result=$this->user->GetUserByid($id);
                // $password=$this->encrypt->decode($result->password);
                if ($this->input->post("nouveau") != "") {
                    $data_info['password'] = $this->encrypt->encode($this->input->post("nouveau"));
                    $this->user->EditUser($id, $data_info);
                    $html['msg'] = "votre mot de passe est changé";
                    echo json_encode($html);
                } else {
                    $html['msg'] = "votre mot de passe actuel est incorrect";
                    echo json_encode($html);
                }

            }
        }
    }

    public function save_formation()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            if ($this->input->post("id") == 0) {
                $this->load->model('user_model', 'user');
                $this->load->library('encrypt');
                $session = $this->session->userdata('logged_in_site_web');
                $id = $this->encrypt->decode($session['id']);
                $data['type'] = $this->input->post("type");
                $data['description'] = $this->input->post("desc");
                $data['titre'] = $this->input->post("titre");
                $data['user_id'] = $id;
                $result = $this->user->addApropos($data);
                $html["id_element"] = $result;
                echo json_encode($html);

            } elseif ($this->input->post("id") != 0) {
                $this->load->model('user_model', 'user');
                $data['description'] = $this->input->post("desc");
                $data['titre'] = $this->input->post("titre");
                $this->user->EditApropos($data);
                $html["id_element"] = $this->input->post("id");
                echo json_encode($html);
            } else {

            }
        }
    }

    public function remove_apropos()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            if ($this->input->post("id")) {
                $this->db->delete('user_apropos', array('id' => $this->input->post("id")));
                $html["id_element"] = $this->input->post("id");
                echo json_encode($html);
            }
        }
    }

    private function create_alias($string, $id)
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $this->load->model('user_model', 'user');
            $this->load->library('urlify');
            //$search = array ('@[éèêëÊË]@i','@[àâäÂÄ]@i','@[îïÎÏ]@i','@[ûùüÛÜ]@i','@[ôöÔÖ]@i','@[ç]@i','@[ ]@i','@[^a-zA-Z0-9_]@');
            //$replace = array ('e','a','i','u','o','c','_','');
            //$result=preg_replace($search, $replace, $in);
            $verifcation = URLify::filter($string);
            $result = $this->user->verifcationExistAlias($verifcation);
            if ($result) {
                $i = 1;
                while ($result) {
                    $verifcation = $verifcation . "." . $i;
                    $result = $this->user->verifcationExistAlias($verifcation);
                    $i++;
                }
                $data['alias'] = $verifcation;
                $this->user->EditUser($id, $data);
            } else {
                $data['alias'] = $verifcation;
                $this->user->EditUser($id, $data);
            }
        }
        return true;
    }

    public function abonnement()
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $this->load->model('model_page', 'page');
            $data['seo_title'] = $this->config->item('seo_title');
            $data['seo_description'] = $this->config->item('seo_desc');
            $data['seo_keyword'] = $this->config->item('seo_keyword');
            $data['slogan'] = "";
            $data['seo_cover'] = "17874-2.jpg";
            $result_seo = $this->page->GetPaGeByid(10);
            if ($result_seo) {
                $data['seo_title'] = $result_seo->title;
                $data['seo_description'] = $result_seo->desc;
                $data['seo_keyword'] = $result_seo->keyword;
                $data['slogan'] = $result_seo->slogan;
                $data['seo_cover'] = $result_seo->photo;
            }
            $this->load->view('template/header', $this->datas);
            $this->load->view('header', $data);
            $this->load->view('club/abonnement');
            $this->load->view('footer');
            $this->load->view('template/footer', $this->datas);
        }
    }
}