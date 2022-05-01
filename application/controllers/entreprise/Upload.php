<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 22/08/2018
 * Time: 17:03
 */

class Upload extends CI_Controller
{
    function UploadImg()
    {
        // If file upload form submitted
        if ($this->input->post('fileSubmit') && !empty($_FILES['files']['name'])) {

            $alias      = $this->input->post('alias');
            $filesCount = count($_FILES['files']['name']);
            $id_ent     = $this->input->post('id_ent');
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['files']['error'][$i];
                $_FILES['file']['size']     = $_FILES['files']['size'][$i];

                // File upload configuration
                $uploadPath              = 'upload/files/';
                $config['upload_path']   = $uploadPath;
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_size']      = '0';
                $config['encrypt_name']  = true;
                $config['width']         = 75;

                // Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                // Upload file to server
                if ($this->upload->do_upload('file')) {

                    // Uploaded file data
                    $fileData                        = $this->upload->data();
                    $uploadData[$i]['image_name']    = $fileData['file_name'];
                    $uploadData[$i]['uploaded_on']   = date("Y-m-d H:i:s");
                    $uploadData[$i]['id_entreprise'] = $id_ent;

                }
            }

            if (!empty($uploadData)) {
                // Insert files data into the database
                $insert = $this->ModelMedia->insert($uploadData);

                // Upload status message
                $statusMsg = $insert ? 'Files uploaded successfully.' : 'Some problem occurred, please try again.';
                $this->session->set_flashdata('statusMsg', $statusMsg);
            }


            $this->session->set_flashdata('message_valid', 'Votre image a été ajouté !!');

            //renvoi page apropos_ent
            redirect('entreprise/' . $alias);
        }


    }

    public function deleteImage()
    {
        $myId = $this->input->post('id');

        if (isset($myId) && $myId > 0) {

            $img = $this->ModelMedia->getImgId($myId);

            $this->ModelMedia->delete_image($img->id, $img->image_name);

            $this->session->set_flashdata('message_valid', 'Votre image a été supprimée !');
        }
    }

    function addBackground()
    {

        if ($this->input->post('bgSubmit') && !empty($_FILES['bgimg'])) {
            $alias  = $this->input->post('alias');
            $id_ent = $this->input->post('id_ent');

            // File upload configuration
            $uploadPath              = 'upload/background';
            $config['upload_path']   = $uploadPath;
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size']      = '0';
            $config['encrypt_name']  = true;

            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('bgimg')) {

                // Uploaded file data
                $fileData = $this->upload->data();
                $this->ModelMedia->insert_bg($fileData['file_name'], $id_ent);
            }

            $this->session->set_flashdata('message_valid', 'Votre image a été changé !');

            //renvoi page apropos_ent
            redirect('entreprise/' . $alias);
        }
    }

    function addLogo()
    {
        if ($this->input->post('logoSubmit') && !empty($_FILES['bglogo'])) {
            $alias  = $this->input->post('alias');
            $id_ent = $this->input->post('id_ent');

            // File upload configuration
            $uploadPath              = 'upload/logos';
            $config['upload_path']   = $uploadPath;
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size']      = '0';
            $config['encrypt_name']  = true;

            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // Upload file to server
            if ($this->upload->do_upload('bglogo')) {

                // Uploaded file data
                $fileData = $this->upload->data();
                $this->ModelMedia->insert_logo($fileData['file_name'], $id_ent);
            }


            //renvoi page apropos_ent
            redirect('entreprise/' . $alias);
        }
    }


    function UploadVideo()
    {
        // If file upload form submitted
        if ($this->input->post('videoSubmit') && !empty($_FILES['files']['name'])) {

            $alias      = $this->input->post('alias');
            $filesCount = count($_FILES['files']['name']);
            $id_ent     = $this->input->post('id_ent');
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['files']['error'][$i];
                $_FILES['file']['size']     = $_FILES['files']['size'][$i];

                // File upload configuration
                $uploadPath              = 'upload/vids/';
                $config['upload_path']   = $uploadPath;
                $config['allowed_types'] = 'avi|mpeg|mp3|mp4|3gp';
                $config['max_size']      = '0';
                $config['encrypt_name']  = true;
                $config['width']         = 20;
                $config['height']        = 20;

                // Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                // Upload file to server
                if ($this->upload->do_upload('file')) {

                    // Uploaded file data
                    $fileData                             = $this->upload->data();
                    $uploadVideoData[$i]['video_name']    = $fileData['file_name'];
                    $uploadVideoData[$i]['uploaded_on']   = date("Y-m-d H:i:s");
                    $uploadVideoData[$i]['entreprise_id'] = $id_ent;
                }
            }

            if (!empty($uploadVideoData)) {
                // Insert files data into the database
                $insert = $this->ModelMedia->insertvideo($uploadVideoData);

                // Upload status message
                $statusMsg = $insert ? 'Files uploaded successfully.' : 'Some problem occurred, please try again.';
                $this->session->set_flashdata('statusMsg', $statusMsg);
            }

            $this->session->set_flashdata('message_valid', 'Votre vidéo a été ajoutée !');

            //renvoi page apropos_ent
            redirect('entreprise/' . $alias);
        }
    }


    public
    function deleteVideo()
    {
        $myId = $this->input->post('id');

        if (isset($myId) && $myId > 0) {

            $vid = $this->ModelMedia->getVidId($myId);

            $this->ModelMedia->delete_video($vid->id, $vid->video_name);

            $this->session->set_flashdata('message_valid', 'Votre video a été supprimée !');
        }
    }

}


