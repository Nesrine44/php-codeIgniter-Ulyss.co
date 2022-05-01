<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');

    /**
     * Created by PhpStorm.
     * User: Ryadh
     * Date: 06/08/2018
     * Time: 12:34
     */
}

class Update extends CI_Controller
{


    public function update_doublon()
    {
        $this->load->model('andafter/ModelUpdate');
        $entreprises = $this->ModelUpdate->recupEntrepriseAvecCode();


        foreach ($entreprises as $entreprise) {
            $doublon = $this->ModelUpdate->Doublon($entreprise->id, $entreprise->nom);
            if (count($doublon) !== 0 AND $doublon !== false) {
                foreach ($doublon as $doublonEntreprise) {

                    $this->ModelUpdate->SearchAndDestroyIdEntrepriseInExperience($entreprise->id, $doublonEntreprise->id);
                    $this->ModelUpdate->DestroyDoublon($entreprise->id, $doublonEntreprise->id);
                }
            }
        }

        $entrepriseSansCode  = $this->ModelUpdate->recupEntrepriseSansCode();
        $entrepriseSansCode2 = $this->ModelUpdate->recupEntrepriseSansCode();


        for ($i = 0; $i < sizeof($entrepriseSansCode); $i++) {

            $entreprise = $entrepriseSansCode[$i];

            if ($entreprise != null) {
                $doublon = $this->ModelUpdate->Doublon($entreprise->id, $entreprise->nom);


                if (count($doublon) !== 0 AND $doublon !== false) {
                    foreach ($doublon as $doublonEntreprise) {
                        $j = 0;
                        foreach ($entrepriseSansCode2 as $key) {

                            if ($key->id == $doublonEntreprise->id) {
                                $entrepriseSansCode[$j] = null;
                            }
                            $j++;
                        }

                        $this->ModelUpdate->SearchAndDestroyIdEntrepriseInExperience($entreprise->id, $doublonEntreprise->id);
                        $this->ModelUpdate->DestroyDoublon($entreprise->id, $doublonEntreprise->id);
                    }
                }
            }
        }
    }

    public function scrap_update()
    {


        $allUserLinkedin = $this->ModelUpdate->getAllUserLinkedin();
        $tabUsersNoPhoto = [];
        foreach ($allUserLinkedin as $user) {

            if (strpos($user->{'picture-url'}, 'default.jpg') || $user->{'picture-url'} == '') {
                $tabUsersNoPhoto[] = $user;
            } elseif ($this->url_exists($user->{'picture-url'}) == false) {
                $tabUsersNoPhoto[] = $user;
            }
        }
        echo '<pre>';
        var_dump('nombre de personne a scrapper : ' . count($tabUsersNoPhoto));
        echo '</pre>';
        if (count($tabUsersNoPhoto) != 0) {
            foreach ($tabUsersNoPhoto as $userNoPhoto) {
                echo '<pre>';
                var_dump($userNoPhoto);
                echo '</pre>';
                $nouvelleUrlPicture = $this->scrapPictureUrl($userNoPhoto->{'public-profile-url'});

                echo '<pre>';
                var_dump('nouvelle url : ' . $nouvelleUrlPicture);
                echo '</pre>';
                //Update
                $this->ModelUpdate->saveAvatarByIdInLinkedinTable($userNoPhoto->id_user, $nouvelleUrlPicture);
                $x = $this->ModelUpdate->saveAvatarById($userNoPhoto->id_user, $nouvelleUrlPicture);
                echo '<pre>';
                var_dump($x);
                echo '</pre>';
            }
        } else {
            echo '<pre>';
            var_dump('RAS , ok !');
            echo '</pre>';
        }

        die();


    }

    public function scrapPictureUrl($url)
    {

        $this->load->library('andafter/LinkedinScraping', ['BusinessUserLinkedin' => $this->getBusinessUserLinkedin()], 'LinkedinScraping');

        $url = str_replace('http:', 'https:', $url);

        $arrayProfile = $this->LinkedinScraping->getScrapUrlProfil($url);

        $new_url = '/upload/avatar/default.jpg';
        if ($arrayProfile === false) {

            return $new_url;
        }

        foreach ($arrayProfile as $itemProfile) {
            if (isset($itemProfile['$type']) && $itemProfile['$type'] == 'com.linkedin.voyager.identity.profile.Profile') {
                $array_items = $itemProfile;
            }

            if (isset($itemProfile['$type']) && $itemProfile['$type'] == 'com.linkedin.voyager.identity.shared.MiniProfile') {
                $array_profile[] = $itemProfile;
            }
        }

        foreach ($array_profile as $itemprofile_key => $itemprofile_label) {

            if (in_array($this->getValueInArray($array_items, 'miniProfile'), $itemprofile_label) == false) {
                continue;
            }

            /* Specific treatments */
            $pictureId = $this->getValueInArray($itemprofile_label, 'picture');
            $pictureId = is_array($pictureId) ? reset($pictureId) : $pictureId;

            foreach ($arrayProfile as $itemProfile) {
                /* get first part of URL media */
                if (isset($itemProfile['$id']) && $itemProfile['$id'] == $pictureId) {
                    $new_url      = $this->getValueInArray($itemProfile, 'rootUrl');
                    $pictureIdUri = $this->getValueInArray($itemProfile, 'artifacts');
                    $pictureIdUri = is_array($pictureIdUri) ? end($pictureIdUri) : $pictureIdUri;
                }
            }

            if (isset($pictureIdUri) && isset($new_url)) {
                foreach ($arrayProfile as $itemProfile) {
                    /* get last part of URL media */
                    if (isset($itemProfile['$id']) && $itemProfile['$id'] == $pictureIdUri) {
                        $new_url .= $this->getValueInArray($itemProfile, 'fileIdentifyingUrlPathSegment');
                    }
                }
            }
        }


        return $new_url;
    }

    public function url_to_image()
    {
        $allUser                     = $this->ModelUpdate->getAllUser();
        $tabUsersWithValidUrlPhoto   = [];
        $tabUsersWithNoValidUrlPhoto = [];
        foreach ($allUser as $user) {
            if ($this->url_exists($user->{'picture-url'}) == true) {
                $tabUsersWithValidUrlPhoto[] = $user;
            } else {
                $tabUsersWithNoValidUrlPhoto[] = $user;
            }
        }

        echo '<pre>';
        var_dump('user a qui on va telechgarger de photo : ' . count($tabUsersWithValidUrlPhoto));
        echo '</pre>';

        echo '<pre>';
        var_dump('user a qui on va les mettre en default.jpg : ' . count($tabUsersWithNoValidUrlPhoto));
        echo '</pre>';
        if (!empty($tabUsersWithValidUrlPhoto)) {
            foreach ($tabUsersWithValidUrlPhoto as $user) {
                echo '<pre>';
                var_dump($user->{'first-name'} . ' ' . $user->{'last-name'});
                echo '</pre>';
                if (copy($user->{'picture-url'}, './upload/avatar/' . $user->id_linkedin . '.jpg')) {
                    echo '<pre>';
                    var_dump('la création image DONE !!!');
                    echo '</pre>';
                    $nouvelleUrlPicture = '/upload/avatar/' . $user->id_linkedin . '.jpg';

                    echo '<pre>';
                    var_dump('nouvelle url : ' . $nouvelleUrlPicture);
                    echo '</pre>';

                    //Update
                    $x = $this->ModelUpdate->saveAvatarById($user->id_user, $nouvelleUrlPicture);

                    echo '<pre>';
                    var_dump('enregisrement BDD : ' . $x);
                    echo '</pre>';
                } else {
                    echo '<pre>';
                    var_dump('copy erreur FAIL !!!');
                    echo '</pre>';
                }
            }
        } else {
            echo '<pre>';
            var_dump('toute es bené  pour les url existant (voir en bas les default.jpg)!!!');
            echo '</pre>';
        }

        echo '<pre>';
        var_dump('-------------------------------------------------------------');
        var_dump('-------------------------------------------------------------');
        var_dump('-------------------------------------------------------------');
        echo '</pre>';
        if (!empty($tabUsersWithNoValidUrlPhoto)) {
            foreach ($tabUsersWithNoValidUrlPhoto as $user) {
                echo '<pre>';
                var_dump($user->{'first-name'} . ' ' . $user->{'last-name'});
                echo '</pre>';
                echo '<pre>';
                var_dump('nouvelle url : /upload/avatar/default.jpg');
                echo '</pre>';

                //Update
                $x = $this->ModelUpdate->saveAvatarById($user->id_user, '/upload/avatar/default.jpg');

                echo '<pre>';
                var_dump('enregisrement BDD : ' . $x);

                echo '</pre>';
            }
        } else {
            echo '<pre>';
            var_dump('toute es bené pour les default.jpg!!!');
            echo '</pre>';
        }

    }


    /**
     * @param $array
     * @param $key
     *
     * @return null
     */
    private
    function getValueInArray(
        $array,
        $key
    ){
        return isset($array[$key]) ? $array[$key] : null;
    }

    private function url_exists($url)
    {


        $headers = @get_headers($url);
        if (is_array($headers)) {
            if (strpos($headers[0], '403 Forbidden') || strpos($headers[0], '404 Not Found')) {
                return false;

            } else {
                return true;
            }
        } else {
            return false;
        }
    }


    //-------------------- SCRAP localisation ----------------------------

    public function scrap_localisationAndAllCompagnyInfo()
    {
        $allUserLinkedin = $this->ModelUpdate->getAllUserLinkedin();

        echo '<pre>';
        var_dump('nombre de personne a scrapper : ' . count($allUserLinkedin));
        echo '</pre>';
        if (count($allUserLinkedin) != 0) {
            foreach ($allUserLinkedin as $userLinkedin) {
                echo '<pre>';

                echo '</pre>';
                // je me suis aretté ici --- je recup les user un part un ,
                // il faut mtn passé au scrap par url du profil public de l'user
                // scrapper la localisation de chaque exp et em meme temps recuperer les info de l'entreprise


                $tabExpUser = $this->secrapLocation($userLinkedin->{'public-profile-url'});


                //Update
                foreach ($tabExpUser as $expUser) {

                    $x = $this->ModelUpdate->saveExpByIdInExpTabe($expUser->id_user, $expUser);
                    echo '<pre>';
                    var_dump($x);
                    echo '</pre>';
                }

            }
        } else {
            echo '<pre>';
            var_dump('RAS , ok !');
            echo '</pre>';
        }
    }

    public function secrapLocation($url)
    {

        $this->load->library('andafter/LinkedinScraping', ['BusinessUserLinkedin' => $this->getBusinessUserLinkedin()], 'LinkedinScraping');

        $url = str_replace('http:', 'https:', $url);

        $arrayProfile = $this->LinkedinScraping->getScrapUrlProfil($url);


    }

    public function industry()
    {
        $x = $this->ModelUpdate->getIndustry();

        foreach ($x AS $valeur) {
            $this->ModelUpdate->updateIndFr($valeur->id, $valeur->name);
        }

    }


    public function url_to_image_ent()
    {
        $allEnt                    = $this->ModelUpdate->getAllEnt();
        $tabEntWithValidUrlPhoto   = [];
        $tabEntWithNoValidUrlPhoto = [];
        foreach ($allEnt as $ent) {
            if ($this->url_exists($ent->logo) == true) {
                $tabEntWithValidUrlPhoto[] = $ent;
            } else {
                $tabEntWithNoValidUrlPhoto[] = $ent;
            }
        }

        echo '<pre>';
        var_dump('user a qui on va telechgarger de photo : ' . count($tabEntWithValidUrlPhoto));
        echo '</pre>';

        echo '<pre>';
        var_dump('user a qui on va les mettre en default.jpg : ' . count($tabEntWithNoValidUrlPhoto));
        echo '</pre>';
        if (!empty($tabEntWithValidUrlPhoto)) {
            foreach ($tabEntWithValidUrlPhoto as $entPic) {
                echo '<pre>';
                var_dump($entPic->nom);
                echo '</pre>';
                echo '<pre>';
                var_dump($entPic->logo);
                echo '</pre>';
                $secureID = sha1($entPic->id);
                if (copy($entPic->logo, './upload/logos/' . $secureID . '.jpg')) {
                    echo '<pre>';
                    var_dump('la création image DONE !!!');
                    echo '</pre>';
                    $nouvelleUrlPicture = '/upload/logos/' . $secureID . '.jpg';

                    echo '<pre>';
                    var_dump('nouvelle url : ' . $nouvelleUrlPicture);
                    echo '</pre>';

                    //Update
                    $x = $this->ModelUpdate->saveAvatarEntById($entPic->id, $nouvelleUrlPicture);

                    echo '<pre>';
                    var_dump('enregisrement BDD : ' . $x);
                    echo '</pre>';
                } else {
                    echo '<pre>';
                    var_dump('copy erreur FAIL !!!');
                    echo '</pre>';
                }
            }
        } else {
            echo '<pre>';
            var_dump('toute es bené  pour les url existant (voir en bas les default ent)!!!');
            echo '</pre>';
        }

        echo '<pre>';
        var_dump('-------------------------------------------------------------');
        var_dump('-------------------------------------------------------------');
        var_dump('-------------------------------------------------------------');
        echo '</pre>';
        if (!empty($tabEntWithNoValidUrlPhoto)) {
            foreach ($tabEntWithNoValidUrlPhoto as $entPic) {
                echo '<pre>';
                var_dump($entPic->nom);
                echo '</pre>';
                echo '<pre>';
                var_dump('nouvelle url : assets/img/entreprise.png');
                echo '</pre>';

                //Update
                $x = $this->ModelUpdate->saveAvatarEntById($entPic->id, '/assets/img/entreprise.png');

                echo '<pre>';
                var_dump('enregisrement BDD : ' . $x);

                echo '</pre>';
            }
        } else {
            echo '<pre>';
            var_dump('toute es bené pour les default ent!!!');
            echo '</pre>';
        }

    }


}
