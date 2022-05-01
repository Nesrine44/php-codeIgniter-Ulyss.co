<?php

include_once "Entreprises.php";

class Jobs extends entreprises
{


    public function offres($alias = null)
    {
        if (!$alias) {
            show_404();
        }

        $this->load->model('user_model', 'user');
        $info                = $this->ModelEntreprise->GetEntrepriseByAlias($alias);
        $datas["categories"] = $this->user->getCategorieParent();

        if (empty($info)) {
            show_404();
        }

        $datas["info"]               = $info;
        $datas["alias"]              = $alias;
        $BusinessEntreprise          = new BusinessEntreprise($info);
        $datas["BusinessEntreprise"] = $BusinessEntreprise;

        //crée et parametrer l'objet des stat et l'envoyer a la vue
        if ($this->companyIsAuthentificate() && $this->id_ent_decode == $BusinessEntreprise->getId()) {
            $datas["BusinessStat"] = new BusinessStat($this->getBusinessStat());
        }

        // Get tout les image de l'entreprise
        $datas["images"] = $this->ModelMedia->getRows($BusinessEntreprise->getId());

        //get les offre d'emplois
        $datas['offres_disponible'] = $this->ModelEntreprise->getOffresPublic($BusinessEntreprise->getId());
        if (empty($datas["offres_disponible"])) {
            $datas['msg_offre']         = 'Aucune offre d\'emplois pour cette entreprise pour le moment ...';
            $datas['offres_disponible'] = null;
        } else {
            $datas['msg_offre'] = null;
        };

        //get les offres d'emplois disponible pour l'admin entrprise
        $datas['offres_all'] = $this->ModelEntreprise->getOffres($BusinessEntreprise->getId());

        if (empty($datas['offres_all'])) {
            $datas['msg_offre_ent'] = 'Vous n\'avez crée aucune offre pour le moment ...';
            $datas['offres_all']    = null;
        } else {
            $datas['msg_offre_ent'] = null;
        };


        //get les montors
        $datas["EntrepriseMontor"] = $this->ModelEntreprise->getAllProfilMentorById($BusinessEntreprise->getId());
        if (empty($datas["EntrepriseMontor"])) {
            $datas['msg_Recherche']    = 'Aucune resultat pour l\'entreprise selectionné, Voici D\'autres Mentors qui sont susceptibles de vous intéresser';
            $datas["EntrepriseMontor"] = null;
        } else {
            $datas['msg_Recherche'] = null;
        }

        /* METAS SEO */
        $this->datas['SEO_title_page'] = 'ULYSS.CO : Consultez les offre d\'emploi(s) et cree votre opportunité';
        $this->datas['SEO_desc_page']  = 'Des candidats souhaitent intégrer les entreprises où vous avez travaillé. Partagez votre expérience pour les aider à faire le bon choix de carrière. Vous souhaitez devenir mentor et aider les candidats ?';


        $this->datas['header_class'] = 'h_r_comp';
        $this->datas['header_logo']  = 'logo_2';

        $this->load->view('template/header', $this->datas);
        $this->load->view('entreprises/header_entreprise', $datas);

        $this->load->view('entreprises/offres/jobs', $datas);
        $this->load->view('template/footer', $this->datas);
    }

    public function createOffre()
    {

        if ($this->input->post()) {

            $this->load->model('andafter/ModelOffre');

            $offre['entreprise_alias'] = $this->input->post('ent_alias');
            $offre['entreprise_id']    = $this->input->post('ent_id');
            $offre['titre_offre']      = $this->input->post('Titre');
            $offre['type_offre']       = $this->input->post('type_contrat');
            $offre['lieu_offre']       = $this->input->post('Lieu');
            $offre['niveau']           = $this->input->post('niveau');
            $offre['salaire_offre']    = $this->input->post('salaire');
            $offre['descriptif_offre'] = $this->input->post('poste');
            $offre['profil_offre']     = $this->input->post('profil');
            $offre['departement_id']   = $this->input->post('departement');
            $offre['url_offre']        = $this->input->post('ent_postuler_url');


            if ($this->input->post('offre_id_modif')) {
                $offre['id'] = $this->input->post('offre_id_modif');
                $this->session->set_flashdata('message_valid', 'Votre offre ' . $offre['titre_offre'] . ' a ete Modifier !!');

            } else {

                $this->session->set_flashdata('message_valid', 'Votre offre ' . $offre['titre_offre'] . ' a ete crée !!');

            }

            $my_offre = $this->ModelOffre->save($offre);

            // redirection sur la page de l'offre d'emploi de l'entreprise
            if ($my_offre == true) {

                // verification si l'offre a des montor ou pas selectionne depuis la page de creation de l'offre
                $tabId_mentorOffre = $this->input->post('mentor');

                // verification si l'offre a des montor ou pas Dans la BDD
                $existeMontorOffres = $this->ModelOffre->getAllMentorOffre($my_offre->id);

                if (isset($tabId_mentorOffre) && $tabId_mentorOffre != null) {


                    // Si $existeMontorOffres existe alor c'est une update d'une offre existante sinon c'est une nouvelle offre
                    if (isset($existeMontorOffres) && !empty($existeMontorOffres)) {

                        foreach ($existeMontorOffres as $id_montorOffre) {
                            //on recuperer l'id des offre eistant dans la BDD pour la comparaison
                            $tabId_ExisteMontor[] = $id_montorOffre->id_mentor;
                        }

                        //on compare le tableau fourni par l'entreprise avec l'existant , qui nous donenra les montor a ajouter
                        $montorpour_ajouter = array_diff($tabId_mentorOffre, $tabId_ExisteMontor);

                        //on compare le tableau de notre BDD avec celui fourni par l'entreprise , qui nous donenra les montor a supprimer
                        $montorpour_supprimer = array_diff($tabId_ExisteMontor, $tabId_mentorOffre);


                        //on ajoute les montor a ajouter
                        if (isset($montorpour_ajouter) && !empty($montorpour_ajouter)) {
                            foreach ($montorpour_ajouter as $idMontorAjou) {
                                $this->ModelOffre->saveMontorOffre($my_offre->id, $idMontorAjou);

                            }
                        }
                        //on supprime les montor a supprimer
                        if (isset($montorpour_supprimer) && !empty($montorpour_supprimer)) {
                            foreach ($montorpour_supprimer as $idMontorSupp) {
                                $this->ModelOffre->deleteMentorOffre($my_offre->id, $idMontorSupp);
                            }
                        }

                    } else {
                        foreach ($tabId_mentorOffre as $id_montorOffre) {
                            // si il y a aucun montor pour l'offre selectionner alor on les sauvegarde tous un par un
                            $this->ModelOffre->saveMontorOffre($my_offre->id, $id_montorOffre);

                        }
                    }
                } elseif ($tabId_mentorOffre == null && isset($existeMontorOffres) && !empty($existeMontorOffres)) {
                    //sinon s'il n'y a pas de mentor selectionnés par l'entreprise
                    //et qu'on a des mentor dans la BDD
                    foreach ($existeMontorOffres as $id_montorOffre) {
                        // On supprime tout ses derniers
                        $this->ModelOffre->deleteMentorOffre($my_offre->id, $id_montorOffre->id_mentor);
                    }

                }
                redirect('entreprise/' . $offre['entreprise_alias'] . '/offresdemploi');
            } else {

                $this->session->set_flashdata('message_non_valid', 'offre non enregistrée.. :( ');
                redirect('entreprise/' . $offre['entreprise_alias'] . '/offresdemploi');
            }


        }
    }


    public function showOffre($idEntreprise, $idOffre)
    {
        $entreprise = $this->ModelEntreprise->GetEntrepriseByAlias($idEntreprise);

        $datas["categories"] = $this->user->getCategorieParent();

        $BusinessEntreprise          = new BusinessEntreprise($entreprise);
        $datas["BusinessEntreprise"] = $BusinessEntreprise;

        $offre = $this->ModelOffre->getOffreById($idOffre);

        if ($offre == false) {
            show_404();
        }

        $datas['offre'] = new BusinessOffre($offre);

        //get les offres d'emplois disponible pour l'admin entrprise
        $datas['offres_all'] = $this->ModelEntreprise->getOffres($idOffre);

        //crée et parapétrer l'objet des stat et l'envoyer a la vue
        if ($this->companyIsAuthentificate() && $this->id_ent_decode == $BusinessEntreprise->getId()) {
            $datas["BusinessStat"] = new BusinessStat($this->getBusinessStat());
        }


        //verifier si le visiteur a postuler ou pas a l'offre afficher
        if ($this->session->userdata('logged_in_site_web')) {
            $isCondidat = $this->ModelOffre->isCondidatOffre($idOffre, $this->getBusinessUser()->getProfileTalent()->getId());

            if ($isCondidat == true) {
                $datas['isCondidat'] = true;
            }
        }

        //get les offres d'emplois disponible pour l'admin entrprise
        $datas['offres_all'] = $this->ModelEntreprise->getOffres($BusinessEntreprise->getId());

        if (empty($datas['offres_all'])) {
            $datas['msg_offre_ent'] = 'Vous n\'avez crée aucune offre pour le moment ...';
            $datas['offres_all']    = null;
        } else {
            $datas['msg_offre_ent'] = null;
        };


        //recuperation des mentor affilier a l'offre
        $mentorOffre = $datas['offre']->getBusinessMontorAffiliated();
        if (isset($mentorOffre) && $mentorOffre != null) {
            $datas['mentorOffre'] = $mentorOffre;
        }


        //get les montors
        $datas["EntrepriseMontor"] = $this->ModelEntreprise->getAllProfilMentorById($BusinessEntreprise->getId());
        if (empty($datas["EntrepriseMontor"])) {
            $datas['msg_Recherche']    = 'Aucune resultat pour l\'entreprise selectionné, Voici D\'autres Mentors qui sont susceptibles de vous intéresser';
            $datas["EntrepriseMontor"] = null;
        } else {
            $datas['msg_Recherche'] = null;
        };


        $this->datas['SEO_title_page'] = 'ULYSS.CO : Consultez les offre d\'emploi(s) et cree votre opportunité';
        $this->datas['SEO_desc_page']  = 'Des candidats souhaitent intégrer les entreprises où vous avez travaillé. Partagez votre expérience pour les aider à faire le bon choix de carrière. Vous souhaitez devenir mentor et aider les candidats ?';


        $this->datas['header_class'] = 'h_r_comp';
        $this->datas['header_logo']  = 'logo_2';

        $this->load->view('template/header', $this->datas);
        $this->load->view('entreprises/header_entreprise', $datas);

        $this->load->view('entreprises/offres/loffre', $datas);
        $this->load->view('template/footer', $this->datas);
    }


    public
    function offrePublic()
    {
        if ($this->input->post()) {
            $idOffre       = $this->input->post('id');
            $data['value'] = $this->input->post('value');
            if ($data['value'] == 'true') {
                // met a jour instant dans la BDD
                $this->ModelOffre->updateOffrePublicById($idOffre, 0);
                $data['value'] = 'false';
                echo json_encode($data);
            } elseif ($data['value'] == 'false') {
                $this->ModelOffre->updateOffrePublicById($idOffre, 1);
                $data['value'] = 'true';
                echo json_encode($data);
            }
        }
    }

    public
    function editOffre()
    {
        if ($this->input->post('id')) {
            $idOffre = $this->input->post('id');
            $offre   = $this->ModelOffre->getById($idOffre);

            $offre = new BusinessOffre($offre);

            $data['offre_id_modif']           = $offre->getId();
            $data['Titre']                    = $offre->getTitre();
            $data['departement']              = $offre->getDepartement();
            $data['type_contrat']             = $offre->getTypeContrat();
            $data['Lieu']                     = $offre->getLieu();
            $data['salaire']                  = $offre->getSalaire();
            $data['niveau']                   = $offre->getNiveau();
            $data['profil']                   = $offre->getProfilDiscriptif();
            $data['poste']                    = $offre->getDescriptif();
            $data['tab_id_montor_affiliated'] = $offre->getIdMentorAffiliated();
            $data['url_candidature']          = $offre->getUrl();


            echo json_encode($data);


        }
    }

    public
    function deleteOffre()
    {

        if ($this->input->post('id')) {

            $idOffre = $this->input->post('id');
            $offre   = $this->ModelOffre->getById($idOffre);
            $offre   = new BusinessOffre($offre);

            $offre->DeleteOffre();
            $this->session->set_flashdata('message_valid', 'Votre offre ' . $offre->getTitre() . ' a ete Supprimer !');

        }
    }

    public
    function postOffre()
    {
        if ($this->session->userdata('logged_in_site_web') && $this->input->post('offre_id')) {

            $query = $this->General_info->get_client_ip_info();
            if ($query && $query['status'] == 'success' && $query['regionName']) {
                $region = $query['regionName'];
            } else {
                $region = null;
            }

            $datas = [
                'offre_id'  => $this->encrypt->decode($this->input->post('offre_id')),
                'talent_id' => $this->getBusinessUser()->getProfileTalent()->getId(),
                'region'    => $region
            ];

            $isCondidat = $this->ModelOffre->isCondidatOffre($datas['offre_id'], $datas['talent_id']);

            if ($isCondidat == false) {
                if ($this->ModelOffre->saveCondidature($datas) == true) {
                    $this->session->set_flashdata('message_valid', 'Votre profil Linkedin a été transféré à l\'entreprise !');

                    // A ajouter l'envoie de messagerie pour l'entreprise et un reacpitulatif de mail

                    redirect($this->session->userdata('last_page_visited'));
                } else {
                    $this->session->set_flashdata('message_valid', ' Une erreur est survenue lors du transfert de votre profil Linkedin à l\'entrepries !');
                    redirect($this->session->userdata('last_page_visited'));
                }
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }


}
