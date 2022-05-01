<?php
/**
 * Created by PhpStorm.
 * User: Ryadh
 * Date: 22/08/2018
 * Time: 17:23
 */

/**
 * Class ModelMedia
 */
class ModelMedia extends CI_Model
{
    /**
     * ModelMedia constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /*
     * Fetch files data from the database
     * @param id returns a single record if specified, otherwise all records
     */
    public function getRows($id_ent = '')
    {
        $this->db->select('*');
        $this->db->from('images');
        if ($id_ent != '') {
            $this->db->where('id_entreprise', $id_ent);
            $query  = $this->db->get();
            $result = $query->result_array();
        };

        return !empty($result) ? $result : false;
    }

    /*
         * Insert file data into the database
         * @param array the data for inserting into the table
         */

    public function insert($data = [])
    {
        $insert = $this->db->insert_batch('images', $data);


        return $insert ? true : false;
    }


    function delete_image($id, $image_name)
    {
        unlink("upload/files/" . $image_name);

        $this->db->delete('images', ['id' => $id]);
    }

    function getImgId($id)
    {

        $this->db->select('*');
        $this->db->from('images');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();

    }

    public function uploadData($url)
    {

        $id = $this->input->post('id_ent');

        $data = [
            'image_name'    => $url,
            'id_entreprise' => $id
        ];

        $this->db->insert('images', $data);
    }

    public function insert_bg($name, $id_ent)
    {
        $this->db->set('background', $name);
        $this->db->where('id', $id_ent);
        $this->db->update('entreprise');
    }

    public function insert_logo($nameLogo, $id_ent)
    {
        $this->db->set('logo', $nameLogo);
        $this->db->where('id', $id_ent);
        $this->db->update('entreprise');
    }
    //******************************************** VIDEO ****************************

    /*
     * Fetch files data from the database
     * @param id returns a single record if specified, otherwise all records
     */
    public function getRowsVid($id_ent = '')
    {
        $this->db->select('*');
        $this->db->from('videos');
        if ($id_ent != '') {
            $this->db->where('entreprise_id', $id_ent);
            $query  = $this->db->get();
            $result = $query->result_array();
        };

        return !empty($result) ? $result : false;
    }

    /*
         * Insert file data into the database
         * @param array the data for inserting into the table
         */

    public function insertvideo($data = [])
    {
        $insert = $this->db->insert_batch('videos', $data);

        return $insert ? true : false;
    }


    function delete_video($id, $video_name)
    {
        unlink("upload/vids/" . $video_name);

        $this->db->delete('videos', ['id' => $id]);
    }

    function getVidId($id)
    {

        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();

    }

    public function uploadVideoData($url)
    {

        $id = $this->input->post('id_ent');

        $data = [
            'video_name'    => $url,
            'entreprise_id' => $id
        ];

        $this->db->insert('videos', $data);
    }

}
