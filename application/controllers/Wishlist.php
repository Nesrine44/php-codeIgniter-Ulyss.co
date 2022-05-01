<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wishlist extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('wishlist_model', 'wish');
        $this->load->library('encrypt');
        $this->load->library('pagination');
        $this->load->model('talent_model', 'talent');
        $this->load->library('user_info');
        if ($this->session->userdata('logged_in_site_web')) {
            $this->id_user_decode = $this->encrypt->decode($this->session->userdata('logged_in_site_web')['id']);
        }
    }

    public function index()
    {

        if ($this->input->post('rechercher')) {
            $this->session->set_userdata('quoi', $this->input->post('quoi'));
        }
        if ($this->input->post('filter')) {

            $this->session->set_userdata('scat_w', $this->input->post('scat'));
            $this->session->set_userdata('ville_w', $this->input->post('ville'));
            $this->session->set_userdata('categorie_w', $this->input->post('groupe_cat'));
        }

        $data['ville'] = !empty($this->session->userdata('ville_w')) ? $this->session->userdata('ville_w') : 0;
        $data['quoi'] = !empty($this->session->userdata('quoi')) ? $this->session->userdata('quoi') : NULL;
        $data['scat'] = !empty($this->session->userdata('scat_w')) ? $this->session->userdata('scat_w') : array();
        $data['categorie'] = !empty($this->session->userdata('categorie_w')) ? $this->session->userdata('categorie_w') : array();
        /*pagination*/
        $data['order'] = ($this->input->get("sort")) ? $this->input->get("sort") : "date";
        $data['result_count'] = $this->wish->getWishlistBysearch($data);
        $config['base_url'] = base_url() . 'wishlist?quoi=' . $data['quoi'] . '&sort=' . $data['order'];
        $config['total_rows'] = count($data['result_count']);
        $config['per_page'] = $this->user_info->getconfig(2);
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['first_tag_open'] = '<span>';
        $config['first_tag_close'] = '</span>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<span class="prev">';
        $config['prev_tag_close'] = '</span>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<span>';
        $config['next_tag_close'] = '</span>';
        $config['last_tag_open'] = '<span>';
        $config['last_tag_close'] = '</span>';
        $config['cur_tag_open'] = '<span class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></span>';
        $config['num_tag_open'] = '<span>';
        $config['num_tag_close'] = '</span>';
        $this->pagination->initialize($config);
        $page = ($this->input->get("per_page") && $this->input->get("per_page") != 1) ? ($this->input->get("per_page") * $config['per_page']) - $config['per_page'] : 0;
        $data['result'] = $this->wish->getWishlistBysearchWithOffset($data, $config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
        $data['list_groupe'] = $this->talent->GetGroupCategorie();

        $data['list_selectionne'] = "";
        if (!empty($data['categorie']) and count($data['categorie']) > 0) {
            $salect = "";
            foreach ($data['categorie'] as $key => $value) {
                $list = $this->talent->getsousCategories($value);
                foreach ($list as $sous_cat) {
                    $checked = "";
                    if (!empty($data['scat'])) {
                        if (in_array($sous_cat->id, $data['scat'])) {
                            $checked = "checked";
                        }
                    }
                    $salect .= ' <div class="col-md-12 checkbox reste_con list_s_' . $value . '" ><label><input value="' . $sous_cat->id . '" name="scat[]" lid="' . $value . '" type="checkbox" ' . $checked . '> ' . $sous_cat->nom . '</label></div>';
                }
            }
            $data['list_selectionne'] = $salect;
        }

        $this->load->view('template/header', $this->datas);
        $this->load->view('wishlist', $data);
        $this->load->view('template/footer', $this->datas);
    }

    public function get_sous_categorie()
    {
        $id_parent = $this->input->get("id");
        $salect = "";
        $list = $this->talent->getsousCategories($id_parent);
        foreach ($list as $sous_cat) {
            $salect .= ' <div class="col-md-12 checkbox reste_con list_s_' . $id_parent . '" ><label><input value="' . $sous_cat->id . '" name="scat[]" lid="' . $id_parent . '" type="checkbox" checked> ' . $sous_cat->nom . '</label></div>';
        }
        echo $salect;
    }

    public function like($id = NULL)
    {
        if (!$id) {
            show_404();
        }
        if (!$this->session->userdata('logged_in_site_web')) {
            show_404();
        }
        if ($this->user_info->checkVote($id)) {
            redirect(base_url() . "wishlist");
        } else {
            $data['user_id'] = $this->id_user_decode;
            $data['wishlist_id'] = $id;
            $this->wish->addVote($data);
            redirect(base_url() . "wishlist");
        }
    }

    public function dislike($id = NULL)
    {
        if (!$id) {
            show_404();
        }
        if (!$this->session->userdata('logged_in_site_web')) {
            show_404();
        }
        if (!$this->user_info->checkVote($id)) {
            redirect(base_url() . "wishlist");
        } else {
            $this->wish->deleteVote($id, $this->id_user_decode);
            redirect(base_url() . "wishlist");
        }
    }

    public function get_info()
    {
        $id = $this->input->get("id");
        $salect = "";
        $wishlist = $this->wish->getWishById($id);
        if (!empty($wishlist)) {
            $data['info'] = $wishlist;
            $data['msg'] = "yes";
            echo json_encode($data);
        } else {
            $data['msg'] = "no";
            echo json_encode($data);
        }
    }

    public function ajouter()
    {
        if (!$this->session->userdata('logged_in_site_web')) {
            show_404();
        }
        if (!$this->input->post()) {
            show_404();
        }

        $data['user_id'] = $this->id_user_decode;
        $data['categorie_id'] = $this->input->post('scat');
        $data['titre'] = $this->input->post('titre');
        $data['description'] = $this->input->post('description');
        $data['ville_id'] = $this->input->post('ville');
        $id_wish = $this->wish->addWish($data);
        $data_w['user_id'] = $this->id_user_decode;
        $data_w['wishlist_id'] = $id_wish;
        $this->wish->addVote($data_w);
        redirect(base_url() . "wishlist");

    }
}

