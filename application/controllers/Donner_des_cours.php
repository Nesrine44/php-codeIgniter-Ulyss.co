<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Donner_des_cours extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('talent_model', 'talent');
        $this->load->library('encrypt');
        $this->load->library('user_info');
        if ($this->session->userdata('logged_in_site_web')) {
            $this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
        }
    }

    public function index()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }
        $data['list_language'] = $this->user->GetListLangues();
        $data['list_tags'] = $this->user->GetListTags();
        $data['list_categories'] = $this->talent->GetCategoriesList();
        $this->load->view('template/header', $this->datas);
        $this->load->view('donner_des_cours', $data);
        $this->load->view('template/footer', $this->datas);
    }

    public function add()
    {

        if (!$this->session->userdata('logged_in_site_web')) {
            redirect(base_url());
        }

        if (!$this->input->post("titre")) {
            $this->index();
        }
        $data_info['titre'] = $this->input->post("titre");
        $data_info['ville'] = $this->input->post("ville");
        $data_info['description'] = $this->input->post("description");
        $data_info['prix'] = $this->input->post("prix");
        $data_info['pro'] = $this->input->post("pro");
        $data_info['reduction'] = $this->input->post("reduction");
        $data_info['reduction_heure'] = $this->input->post("reduction_heure");
        $data_info['reduction_personne'] = $this->input->post("reduction_personne");
        $data_info['centre_interet'] = $this->input->post("centre_interet");
        /*    $data_info['horaire']=$this->input->post("horaire");
            $data_info['horaire_de']=$this->input->post("horaire_de");
            $data_info['horaire_a']=$this->input->post("horaire_a");*/

        /*    $data_info['description_forfait']=$this->input->post("description_forfait");*/
        //  $data_info['prix_forfait']=$this->input->post("prix_forfait");
        $data_info['prix_journee'] = $this->input->post("prix_journee");


        $data_info['alias'] = $this->create_alias($this->input->post("titre"));
        $data_info['user_id'] = $this->id_user_decode;
        if (isset($_FILES["file"]["name"]) && $_FILES["file"]["error"] == 0) {
            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);
            $_FILES["file"]["name"] = $this->_unique_field_name($_FILES["file"]["name"]);
            $_FILES["file"]["name"] .= "." . $extension;
            if ($_FILES["file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
            } else {
                //CB : Utilisation du module S3File
                if ($this->s3file->file_exists("upload/talents/" . $_FILES["file"]["name"])) {
                    $this->s3file->unlink("upload/talents/" . $_FILES["file"]["name"]);
                }
                $this->s3file->move_uploaded_file($_FILES["file"]["tmp_name"], "upload/talents/" . $_FILES["file"]["name"]);
                $data_info['cover'] = $_FILES["file"]["name"];
            }
        }
        $id_t = $this->talent->AddTalent($data_info);
        /*add langue*/
        if ($this->input->post("langues")) {
            foreach ($this->input->post("langues") as $key => $value) {
                $data_lang['talent_id'] = $id_t;
                $data_lang['langue_id'] = $value;
                $this->talent->AddTalentLangue($data_lang);
            }
        }

        /*end*/
        /*add langue*/
        foreach ($this->input->post("tag") as $key => $value) {
            $data_tag['talent_id'] = $id_t;
            $data_tag['tag_id'] = $value;
            $this->talent->AddTalentTag($data_tag);
        }
        /*end*/

        /*add categorie*/
        foreach ($this->input->post("list_cat") as $key => $value) {
            $data_ca['talent_id'] = $id_t;
            $data_ca['categorie_id'] = $value;
            $this->talent->AddTalentCategorie($data_ca);
        }
        $data_horaire['talent_id'] = $id_t;
        $data_horaire['lundi_8_10'] = $this->input->post("lundi_8_10");
        $data_horaire['mardi_8_10'] = $this->input->post("mardi_8_10");
        $data_horaire['mercredi_8_10'] = $this->input->post("mercredi_8_10");
        $data_horaire['jeudi_8_10'] = $this->input->post("jeudi_8_10");
        $data_horaire['vendredi_8_10'] = $this->input->post("vendredi_8_10");
        $data_horaire['samedi_8_10'] = $this->input->post("samedi_8_10");
        $data_horaire['dimanche_8_10'] = $this->input->post("dimanche_8_10");

        $data_horaire['lundi_10_12'] = $this->input->post("lundi_10_12");
        $data_horaire['mardi_10_12'] = $this->input->post("mardi_10_12");
        $data_horaire['mercredi_10_12'] = $this->input->post("mercredi_10_12");
        $data_horaire['jeudi_10_12'] = $this->input->post("jeudi_10_12");
        $data_horaire['vendredi_10_12'] = $this->input->post("vendredi_10_12");
        $data_horaire['samedi_10_12'] = $this->input->post("samedi_10_12");
        $data_horaire['dimanche_10_12'] = $this->input->post("dimanche_10_12");

        $data_horaire['lundi_12_14'] = $this->input->post("lundi_12_14");
        $data_horaire['mardi_12_14'] = $this->input->post("mardi_12_14");
        $data_horaire['mercredi_12_14'] = $this->input->post("mercredi_12_14");
        $data_horaire['jeudi_12_14'] = $this->input->post("jeudi_12_14");
        $data_horaire['vendredi_12_14'] = $this->input->post("vendredi_12_14");
        $data_horaire['samedi_12_14'] = $this->input->post("samedi_12_14");
        $data_horaire['dimanche_12_14'] = $this->input->post("dimanche_12_14");

        $data_horaire['lundi_14_16'] = $this->input->post("lundi_14_16");
        $data_horaire['mardi_14_16'] = $this->input->post("mardi_14_16");
        $data_horaire['mercredi_14_16'] = $this->input->post("mercredi_14_16");
        $data_horaire['jeudi_14_16'] = $this->input->post("jeudi_14_16");
        $data_horaire['vendredi_14_16'] = $this->input->post("vendredi_14_16");
        $data_horaire['samedi_14_16'] = $this->input->post("samedi_14_16");
        $data_horaire['dimanche_14_16'] = $this->input->post("dimanche_14_16");


        $data_horaire['lundi_16_18'] = $this->input->post("lundi_16_18");
        $data_horaire['mardi_16_18'] = $this->input->post("mardi_16_18");
        $data_horaire['mercredi_16_18'] = $this->input->post("mercredi_16_18");
        $data_horaire['jeudi_16_18'] = $this->input->post("jeudi_16_18");
        $data_horaire['vendredi_16_18'] = $this->input->post("vendredi_16_18");
        $data_horaire['samedi_16_18'] = $this->input->post("samedi_16_18");
        $data_horaire['dimanche_16_18'] = $this->input->post("dimanche_16_18");


        $data_horaire['lundi_18_20'] = $this->input->post("lundi_18_20");
        $data_horaire['mardi_18_20'] = $this->input->post("mardi_18_20");
        $data_horaire['mercredi_18_20'] = $this->input->post("mercredi_18_20");
        $data_horaire['jeudi_18_20'] = $this->input->post("jeudi_18_20");
        $data_horaire['vendredi_18_20'] = $this->input->post("vendredi_18_20");
        $data_horaire['samedi_18_20'] = $this->input->post("samedi_18_20");
        $data_horaire['dimanche_18_20'] = $this->input->post("dimanche_18_20");

        $data_horaire['lundi_20_22'] = $this->input->post("lundi_20_22");
        $data_horaire['mardi_20_22'] = $this->input->post("mardi_20_22");
        $data_horaire['mercredi_20_22'] = $this->input->post("mercredi_20_22");
        $data_horaire['jeudi_20_22'] = $this->input->post("jeudi_20_22");
        $data_horaire['vendredi_20_22'] = $this->input->post("vendredi_20_22");
        $data_horaire['samedi_20_22'] = $this->input->post("samedi_20_22");
        $data_horaire['dimanche_20_22'] = $this->input->post("dimanche_20_22");
        $this->talent->AddTalentHoraire($data_horaire);
        /*add image*/
        $config['upload_path'] = 'upload/talents/portfolio/';
        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';
        $this->load->library('upload', $config);

        $files = $_FILES['image'];

        $cpt = count($_FILES['image']['name']);
        for ($i = 0; $i < $cpt - 1; $i++) {

            $_FILES['userfile']['name'] = $files['name'][$i];
            $_FILES['userfile']['type'] = $files['type'][$i];
            $_FILES['userfile']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['userfile']['error'] = $files['error'][$i];
            $_FILES['userfile']['size'] = $files['size'][$i];

            $this->upload->initialize($this->set_upload_options());
            $this->upload->do_upload();
            $upload_data = $this->upload->data();
            $data_img['image'] = $upload_data['file_name'];
            $data_img['titre'] = $upload_data['file_name'];
            $data_img['talent_id'] = $id_t;
            if ($i == 0) {
                $data_edit_talent['cover'] = $upload_data['file_name'];
                $this->talent->EditTalent($id_t, $data_edit_talent);
            }
            $this->talent->AjouterPortfolioTotalent($data_img);
        }
        if ($this->input->post("list_files")) {
            foreach ($this->input->post("list_files") as $key => $value) {
                $data_doc['document'] = $value;
                $data_doc['titre'] = $value;
                $data_doc['talent_id'] = $id_t;

                $this->talent->AjouterDocTotalent($data_doc);
            }
        }
        redirect(base_url() . 'donner_des_cours/success');
    }

    private function set_upload_options()
    {
        //upload an image options
        $config = array();
        $config['upload_path'] = 'upload/talents/portfolio/';
        $config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx';

        return $config;
    }

    public function success()
    {
        $this->load->view('template/header', $this->datas);
        $this->load->view('donner_des_cours_success');
        $this->load->view('template/footer', $this->datas);
    }

    private function create_alias($string)
    {
        if ($this->session->userdata('logged_in_site_web')) {
            $this->load->model('user_model', 'user');
            $this->load->library('urlify');
            $verifcation = $this->urlify->filter($string);
            $verifcation1 = $verifcation;
            $result = $this->talent->verifcationExistAlias($verifcation);
            if ($result) {
                $i = 1;
                while ($result) {
                    $verifcation = $verifcation1 . "." . $i;
                    $result = $this->talent->verifcationExistAlias($verifcation);
                    $i++;
                }

            }
        }
        return $verifcation;
    }

    public function ajouter_document()
    {

        $data = array();

        if ($this->session->userdata('logged_in_site_web')) {
            $status = "";
            $msg = "";
            $file_element_name = 'userfile';

            if ($status != "error") {
                $config['upload_path'] = 'upload/talents/portfolio/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|doc|txt|docx';
                $config['max_size'] = 1024 * 8;
                $config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload($file_element_name)) {
                    $status = 'error';
                    $msg = $this->upload->display_errors('', '');
                    echo json_encode(array('status' => $status, "error" => "problem upload"));

                } else {
                    $data = $this->upload->data();
                    $status = "success";
                    $msg = "File successfully uploaded";
                    @unlink($_FILES[$file_element_name]);

                    echo json_encode(array('status' => $status, 'value' => $data['file_name'], 'msg' => base_url() . $config['upload_path'] . $data['file_name']));
                }

            }
        }
    }

}

