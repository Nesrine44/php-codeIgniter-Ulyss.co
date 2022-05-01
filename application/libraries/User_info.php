<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User_info
{
    public function __construct()
    {
        $this->CI            =& get_instance();
        $this->email_contact = "";
    }

    public function getDiffDate($stardate, $endate)
    {
        $date1 = new DateTime($stardate);
        $date2 = !empty($endate) ? new DateTime($endate) : new DateTime(date("Y-m-d"));


        $interval = $date1->diff($date2);
        $html     = "";
        if ($interval->y != 0) {
            $ans  = ($interval->y == 1) ? "an" : "ans";
            $html .= $interval->y . " " . $ans . ", ";
        }
        if ($interval->m != 0) {
            $html .= $interval->m . " mois, ";
        }
        if ($interval->d != 0) {
            // $html.=$interval->m . " jours";
        }

        return $html;

    }

    public function getPictureUser($id)
    {
        $info = $this->CI->user->GetUserByid($this->CI->id_user_decode);

        return $info->avatar;
    }

    public function getPictureOtherUser($id)
    {
        $info = $this->CI->user->GetUserByid($id);

        return !empty($info) ? $info->avatar : "default.jpg";
    }


    public function getTotalNonLus()
    {
        $number = $this->CI->user->getTotalNonLus($this->CI->id_user_decode);

        return ($number == 0) ? "" : "<em>" . $number . "</em>";
    }

    public function getcategories_talent($id)
    {
        $cat    = $this->CI->talent->GetCategoriesTalent($id);
        $result = "";
        foreach ($cat as $item) {
            $result .= "<span>" . $item->nom . "</span>";
        }

        return $result;
    }

    public function getAliasUser($id)
    {
        $info = $this->CI->user->GetUserByid($this->CI->id_user_decode);

        return $info->alias;
    }

    public function getconfig($id)
    {
        $val = $this->CI->user->GetConfigValue($id);

        return $val;
    }

    public function getconfigTitre($id)
    {
        $val = $this->CI->user->GetConfigName($id);

        return $val;
    }


    public function getVilleLanAndLAt($id)
    {
        $position = $this->CI->user->GetVilleInfo($id);

        return $position;
    }

    public function distance($lat1, $lon1, $lat2, $lon2, $unit = "K")
    {
        $theta = $lon1 - $lon2;
        $dist  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist  = acos($dist);
        $dist  = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit  = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else {
            if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    public function getCatName($id)
    {
        $name = $this->CI->talent->getCatRow($id);

        return !empty($name) ? $name->nom : "";
    }

    public function getSCatName($id)
    {
        $name = $this->CI->talent->getSCatRow($id);

        return !empty($name) ? $name->nom : "";
    }

    public function getSecteurName($id)
    {
        var_dump($this->CI);
        die();
        $name = $this->CI->talent->getSecteurName($id);

        return !empty($name) ? $name->nom : "";
    }

    public function getTagName($id)
    {
        $name = $this->CI->talent->getTagName($id);

        return !empty($name) ? $name->nom : "";
    }

    public function getVilleName($id)
    {
        $name = $this->CI->user->getVilleRow($id);

        return !empty($name) ? $name->ville_nom : "";
    }

    public function getVilleCodePostal($id)
    {
        $name = $this->CI->user->getVilleRow($id);

        return !empty($name) ? $name->ville_nom . ' ' . $name->ville_code_postal : "";
    }

    public function getNombreVote($id)
    {
        $nombre = $this->CI->wish->getNombreVote($id);

        return $nombre;
    }

    public function checkVote($id)
    {
        $check = $this->CI->wish->checkVote($id, $this->CI->id_user_decode);

        return !empty($check) ? true : false;
    }

    public function checkFavoris($id)
    {
        $check = $this->CI->user->checkFavoris($id, $this->CI->id_user_decode);

        return !empty($check) ? true : false;
    }

    public function getNameUserH($id)
    {
        $info = $this->CI->user->GetuserHunter($id);

        return !empty($info) ? $info->prenom . ' ' . $info->nom : "";
    }

    public function getNameUserH1($id)
    {
        $info = $this->CI->user->GetuserHunter($id);

        return !empty($info) ? $info->prenom . ' ' . strtoupper(substr($info->nom, 0, 1)) : "";
    }

    public function getNameUserW($id)
    {
        $info = $this->CI->user->GetuserWanted($id);

        return !empty($info) ? $info->prenom . ' ' . $info->nom : "";
    }

    public function getNameUserW1($id)
    {
        $info = $this->CI->user->GetuserWanted($id);

        return !empty($info) ? $info->prenom . ' ' . strtoupper(substr($info->nom, 0, 1)) : "";
    }


    public function getSommeByMoi($mois)
    {
        $somme = $this->CI->demande->getVenteByNumberMoisDemandes($this->CI->id_user_decode, $mois);

        return $somme;
    }

    public function getVenteByNumberMoisContractualiser($mois)
    {
        $somme = $this->CI->demande->getVenteByNumberMoisContractualiser($this->CI->id_user_decode, $mois);

        return $somme;
    }

    public function getWalletUser()
    {
        $info = $this->CI->user->GetUserByid($this->CI->id_user_decode);

        return $info->wallet;
    }

    public function getWalletUserById($id)
    {
        $info = $this->CI->user->GetUserByid($id);

        return $info->wallet;
    }

    public function getBankAccountUserById($id)
    {
        $info = $this->CI->user->GetUserByid($id);

        return $info->bank_account;
    }

    public function getCodePays($id)
    {
        $name = $this->CI->user->getCodePays($id);

        return !empty($name) ? $name->alpha2 : "";
    }

    public function getInfoUser($id, $colum)
    {
        $info = $this->CI->user->GetUserByid($this->CI->id_user_decode);

        return $info->$colum;
    }

    public function getVilleInfoAll($id)
    {
        $info = $this->CI->user->GetVilleInfo($id);

        return $info;
    }

    public function checkPaiement($id)
    {
        $check = $this->CI->demande->CheckPaiement($id);

        return $check;
    }

    public function getNameUser($id)
    {
        $info = $this->CI->user->GetUserByid($id);

        return !empty($info) ? $info->prenom . ' ' . $info->nom : "";
    }

    public function getVillebYuserID($id)
    {
        $info = $this->CI->user->getVillebYuserID($id);

        return !empty($info) ? $info->ville : "";
    }

    public function getListCoverture()
    {
        $list = $this->CI->user->getListCoverture();

        return $list;
    }

    public function getCovertureUser()
    {
        $info = $this->CI->user->GetUserByid($this->CI->id_user_decode);

        return $info->cover;
    }

    public function getCovertureTalent($id)
    {
        $info = $this->CI->talent->GetTalent($id);

        return $info->coverture;
    }

    public function getCovertureUserById($id)
    {
        $info = $this->CI->user->GetUserByid($id);

        return $info->cover;
    }

    public function getEmailUser()
    {
        $info = $this->CI->user->GetUserByid($this->CI->id_user_decode);

        return $info->email;
    }

    public function getTelUser()
    {
        $info = $this->CI->user->GetUserByid($this->CI->id_user_decode);

        return $info->tel;
    }

    public function getTypeNotificationsNewMsg($id)
    {
        $info = $this->CI->user->GetUserByid($id);

        return $info;
    }

    public function getUserIdByDemande($id)
    {
        $info = $this->CI->user->GetuserWanted($id);

        return !empty($info) ? $info->id : 0;
    }

    public function getNameTalent($id)
    {
        $info = $this->CI->talent->GetTalent($id);

        return $info->titre;
    }

    public function getMesTalents()
    {
        $info = $this->CI->user->GetTalentsUser($this->CI->id_user_decode);

        return !empty($info) ? true : false;
    }

    public function getNameEntreprise($id)
    {
        $info = $this->CI->talent->getNameEntreprise($id);

        return !empty($info) ? $info->nom : "--";
    }

    public function getLogoEntreprise($id)
    {
        $info = $this->CI->talent->getNameEntreprise($id);

        return !empty($info) && $info->logo != null && $info->logo != 'assets/img/entreprise.png' ? $info->logo : base_url() . 'assets/img/entreprise.png';
    }

    public function getEntrepriseName($id)
    {
        $info = $this->CI->talent->getNameEntreprise($id);

        return !empty($info) ? $info->nom : "";
    }

    public function getBlock($id)
    {
        $info = $this->CI->talent->getBlock($id);

        return $info;
    }


    public function getPictureEntreprise($list, $name)
    {
        foreach ($list as $key => $item) {
            //if($item["name_entreprise"]==$name){
            if (strpos(strtoupper($item["name_entreprise"]), strtoupper($name)) !== false or strtoupper($item["name_entreprise"]) == strtoupper($name)) {
                return "https://media.licdn.com/mpr/mpr/shrinknp_100_100/" . $item["name"];
            }

            # code...
        }

        return base_url() . "assets/img/entreprise.png";
    }

    /**
     * @return bool
     */
    public function isAuthentified()
    {
        return (bool)$this->CI->session->userdata('logged_in_site_web');
    }


}
