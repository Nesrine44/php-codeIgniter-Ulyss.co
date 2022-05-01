<?php

/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 25/07/2018
 * Time: 14:46
 */

class Entreprises extends CI_Controller
{
    public function apropos($alias = null)
    {
        if (!$alias) {
            show_404();
        }
        $info = $this->ModelEntreprise->GetEntrepriseByAlias($alias);
        if (empty($info)) {
            show_404();
        }
        $this->load->model('user_model', 'user');
        $datas["categories"] = $this->user->getCategorieParent();


        $datas["info"]               = $info;
        $datas["alias"]              = $alias;
        $BusinessEntreprise          = new BusinessEntreprise($info);
        $datas["BusinessEntreprise"] = $BusinessEntreprise;

        //get les offres d'emplois
        $datas['offres_disponible'] = $BusinessEntreprise->getOffreDisponible();

        $datas['offres_all'] = $BusinessEntreprise->getAllOffre();
        if (empty($datas["offres_disponible"])) {
            $datas['msg_offre']         = 'Aucune offre d\'emplois pour cette entreprise pour le moment ...';
            $datas['offres_disponible'] = null;
        } else {
            $datas['msg_offre'] = null;
        };


        if (empty($datas['offres_all'])) {
            $datas['msg_offre_ent'] = 'Vous n\'avez crée aucune offre pour le moment ...';
            $datas['offres_all']    = null;
        } else {
            $datas['msg_offre_ent'] = null;
        };


        $datas["EntrepriseMontor"] = $BusinessEntreprise->getMentorProfil();
        if (empty($datas["EntrepriseMontor"])) {
            $datas['msg_Recherche'] = 'Aucune resultat pour l\'entreprise selectionné, Voici D\'autres Mentors qui sont susceptibles de vous intéresser';
        } else {
            $datas['msg_Recherche'] = null;
        };


        //get le nom du secteur avec l'id de se dernier
        $datas["secteur_name"] = $this->General_info->getSecteurNameById($BusinessEntreprise->getSecteurId());

        // Get tout les image de l'entreprise
        $datas["images"] = $BusinessEntreprise->getImages();

        // Get tout les videos de l'entreprise
        $datas["videos"] = $BusinessEntreprise->getVideos();

        // Get tout les sections
        $datas["sections"] = $BusinessEntreprise->getAllSections();

        // Get tout les dept france
        $datas["departements"] = $this->ModelGeneral->getDepartementFrance();

        if ($this->session->userdata('logged_in_site_web')) {
            $query = $this->General_info->get_client_ip_info();
            if ($query && $query['status'] == 'success' && $query['regionName']) {
                $daa_vues['region'] = $query['regionName'];
            } else {
                $daa_vues['region'] = null;
            }
            $daa_vues['entreprise_id'] = $BusinessEntreprise->getId();
            $daa_vues['talent_id']     = $this->getBusinessUser()->getProfileTalent()->getId();
            $this->ModelEntreprise->AddVueEntreprise($daa_vues);
        }

        //crée et parapétrer l'objet des stat et l'envoyer a la vue
        if ($this->companyIsAuthentificate() && $this->id_ent_decode == $BusinessEntreprise->getId()) {
            $datas["BusinessStat"] = new BusinessStat($this->getBusinessStat());
        }
        /* METAS SEO */
        $this->datas['SEO_title_page'] = 'ULYSS.CO : ' . $BusinessEntreprise->getNom();
        $this->datas['SEO_desc_page']  = $BusinessEntreprise->getNom() . ' l\'entreprise que vous convoitez. Découvrez dès aujourd\'hui le profil de celle-ci et convenez d\'un rendez-vous téléphonique avec l\'un de ces Montor.';

        $this->datas['header_class'] = 'h_r_comp';
        $this->datas['header_logo']  = 'logo_2';

        $this->load->view('template/header', $this->datas);
        $this->load->view('entreprises/header_entreprise', $datas);
        $this->load->view('entreprises/apropos_ent', $datas);
        $this->load->view('template/footer', $this->datas);


    }

    // edition du titre et de la desctipion de l'entreprise (presentation)
    public function editDescription()
    {
        $id                        = $this->input->post('id_ent');
        $data['description_titre'] = $this->input->post('titre_description_ent');
        $data['description']       = $this->input->post('description_ent');

        if ($this->ModelEntreprise->EditDescriptionByIdEntreprise($id, $data)) {
            $data['resultat'] = true;
        } else {
            $this->session->set_flashdata('message_error', 'Une erreur est survenue lors de l\'enregistrement de votre édition , veuillez réessayer dans quelques instants. ');
            $data['resultat'] = false;
        };

        echo json_encode($data);
    }

    // add section to database by json $ajax
    public function addSection()
    {
        $data['id_entreprise']       = $this->input->post('id_ent');
        $data['titre_sections']      = $this->input->post('titre_sections_desc');
        $data['descriptif_sections'] = $this->input->post('sections_desc');

        if ($this->ModelEntreprise_Sections->save($data)) {
            $this->session->set_flashdata('message_valid', 'Votre section a été bien enregistré. ');
        } else {
            $this->session->set_flashdata('message_error', 'Une erreur est survenue lors de l\'enregistrement de votre section , veuillez réessayer dans quelques instants. ');
        };
    }

    //edit section and save to database
    public function EditSection()
    {
        $data['id']                  = $this->input->post('id_sections_desc_modif');
        $data['titre_sections']      = $this->input->post('titre_sections_desc_modif');
        $data['descriptif_sections'] = $this->input->post('sections_desc_modif');
        $this->ModelEntreprise_Sections->save($data);
        echo json_encode($data);
    }

    // Delete section
    public function DeleteSection()
    {
        $id = $this->input->post('id');
        if ($this->ModelEntreprise_Sections->delete($id)) {
            $this->session->set_flashdata('message_valid', 'Votre section a été supprimer. ');
        } else {
            $this->session->set_flashdata('message_error', 'Une erreur est survenue lors de la suppressions de votre section , veuillez réessayer dans quelques instants. ');
        };
    }


    // ajoute ou enleve un ambassador , par rapport a sa valeur dans la base de données
    public function selectOrDeselectAmbassador()
    {
        // ont recupere l'id du mentor
        $talent_id = $this->input->post('id');
        $id_ent    = $this->encrypt->decode($this->session->userdata('ent_logged_in_site_web')['id_ent']);

        // on recuperer la valeur , on verifie si il est embassadeur ou pas
        $talent_info = $this->ModelTalent->getAmbassadorIfExiste($talent_id, $id_ent);

        if (isset($talent_info) && $talent_info != null) {
            $this->ModelTalent->deleteAmbassadeur($talent_info->id);
        } elseif ($talent_info == null) {
            $ambassadeur['talent_id']     = $talent_id;
            $ambassadeur['id_entreprise'] = $id_ent;
            $this->ModelTalent->saveAmbassadeur($ambassadeur);
        }
        $data['emb'] = $this->ModelEntreprise->getTotalAmbassadorByEntrepriseId($id_ent);
        echo json_encode($data);
    }

    public function addTwitter_link()
    {
        $id_ent    = $this->input->post('id_ent');
        $alias     = $this->ModelEntreprise->getAliasEntrepriseById($id_ent);
        $twitter   = $this->input->post('tw_link');
        $facebook  = $this->input->post('fb_link');
        $youtube   = $this->input->post('yt_link');
        $instagram = $this->input->post('insta_link');

        $msg = '';
        if ($twitter != '' && url_exists($twitter) && stristr($twitter, 'twitter.')) {
            $twitter = rtrim($twitter, "/ ");
            $this->ModelEntreprise->addSocial('twitter_link', $twitter, $id_ent);
        } elseif ($twitter != '') {
            $msg .= "votre lien twitter fourni n'existe pas !<br />";
        }
        if ($facebook != '' && stristr($facebook, 'facebook.')) {
            $facebook = rtrim($facebook, "/ ");
            $this->ModelEntreprise->addSocial('facebook_link', $facebook, $id_ent);

        } elseif ($facebook != '') {
            $msg .= "votre lien facebook fourni n'existe pas !<br />";
        }
        if ($youtube != '' && url_exists($youtube) && stristr($youtube, 'youtube.')) {
            $youtube = rtrim($youtube, "/ ");
            $this->ModelEntreprise->addSocial('youtube_link', $youtube, $id_ent);

        } elseif ($youtube != '') {
            $msg .= "votre lien youtube fourni n'existe pas !<br />";
        }
        if ($instagram != '' && url_exists($instagram) && stristr($instagram, 'instagram.')) {
            $instagram = rtrim($instagram, "/ ");
            $this->ModelEntreprise->addSocial('instagram_link', $instagram, $id_ent);

        } elseif ($instagram != '') {
            $msg .= "votre lien instagram fourni n'existe pas !<br />";;
        }

        if ($msg != '') {
            $this->session->set_flashdata('message_error', $msg);
        }


        redirect(base_url() . 'entreprise/' . $alias);
    }


    public function ciblage()
    {
        $id_ent = $this->input->post('id_ent');
        $alias  = $this->ModelEntreprise->getAliasEntrepriseById($id_ent);
        $cat    = $this->input->post('cat');
        $map    = $this->input->post('map');


        $datas['entreprise_id'] = $id_ent;

        // verification si l'offre a des ciblage ou pas selectionne depuis la page de creation de ciblage
        if (isset($cat) || isset($map)) {
            // verification si l'entreprise a des ciblage ou pas Dans la BDD dans les deux table
            //$Departement = $this->ModelEntreprise->getDepartementCiblage($id_ent);
            //$Region      = $this->ModelEntreprise->getRegionCiblage();

            if (isset($Departement) || isset($Region)) {


            } else {
                if (isset($cat)) {
                    foreach ($cat as $dep) {
                        $datas['departement_id'] = $dep;
                        $this->ModelEntreprise->AddCiblageDepEntreprise($datas);
                    }
                }

                if (isset($map)) {
                    foreach ($map as $region) {
                        $datas['region_nom_map'] = $region;
                        $this->ModelEntreprise->AddCiblageRegionEntreprise($datas);
                    }
                }
            }


            $this->session->set_flashdata('message_valid', 'Votre ciblage a été pris en compte. ');
        } else {
            $this->session->set_flashdata('message_error', 'Aucune selection. ');
        }

        redirect(base_url() . 'entreprise/' . $alias);
    }


    public function widgetGeneral($alias = null)
    {
        if (!$alias) {
            show_404();
        }
        $datas['line']                = $this->input->get('l');
        $datas['col']                 = $this->input->get('c');
        $info                         = $this->ModelEntreprise->GetEntrepriseByAlias($alias);
        $BusinessEntreprise           = new BusinessEntreprise($info);
        $datas['BusinessEntrepriseW'] = $BusinessEntreprise;
        $datas['picturesW']           = $BusinessEntreprise->getImages();
        $this->load->view('entreprises/widgetEntreprise', $datas);
    }

    public function widgetOffre($alias = null, $id_offre = null)
    {
        if (!$alias || !$id_offre) {
            show_404();
        }
        $datas['l']                   = $this->input->get('l');
        $datas['c']                   = $this->input->get('c');
        $info                         = $this->ModelEntreprise->GetEntrepriseByAlias($alias);
        $offre                        = $this->ModelOffre->getOffreById($id_offre);
        $BusinessEntreprise           = new BusinessEntreprise($info);
        $BusinessOffre                = new BusinessOffre($offre);
        $datas['BusinessEntrepriseW'] = $BusinessEntreprise;
        $datas['BusinessOffreW']      = $BusinessOffre;
        $this->load->view('entreprises/offres/widgetOffre', $datas);
    }

}