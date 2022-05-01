<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Convertdate {

public function get_friendly_time_ago($distant_timestamp, $max_units = 3) {
    $i = 0;
    $time = time() - strtotime($distant_timestamp); // to get the time since that moment
    if($time > 86400) return utf8_encode(strftime("%d %B %Y",strtotime($distant_timestamp))).' a '.utf8_encode(strftime("%H",strtotime($distant_timestamp))); /// 18 decembre a 16h30
    $tokens = [
        31536000 => 'an',
        2592000 => 'mois',
        604800 => 'semaine',
        86400 => 'jour',
        3600 => 'heure',
        60 => 'minute',
        1 => 'seconde'
    ];

    $responses = [];
    while ($i < $max_units) {
        foreach ($tokens as $unit => $text) {
            if ($time < $unit) {
                continue;
            }
            $i++;
            $numberOfUnits = floor($time / $unit);

            $responses[] = $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
            $time -= ($unit * $numberOfUnits);
            break;
        }
    }

    if (!empty($responses)) {
        return  'Il y a '.implode(', ', $responses);
    }

    return 'Maintenant';
} 
function humanizeDateDiffference($otherDate=null,$offset=null){
    $now= time();
 

    return strftime("%d %B %Y",strtotime($otherDate)).' à '.date("H:i",strtotime($otherDate));
    if($otherDate != null){
        $offset = $now - strtotime($otherDate);
    }

    if($offset > 86400) return strftime("%d %B %Y",strtotime($otherDate)).' â '.date("H:I",strtotime($otherDate));
    if($offset != null){
        $deltaS = $offset%60;
        $offset /= 60;
        $deltaM = $offset%60;
        $offset /= 60;
        $deltaH = $offset%24;
        $offset /= 24;
        $deltaD = ($offset > 1)?ceil($offset):$offset;      
    } else{
        throw new Exception("Must supply otherdate or offset (from now)");
    }
    if($deltaD > 1){
        if($deltaD > 365){
            $years = ceil($deltaD/365);
            if($years ==1){
                return "last year"; 
            } else{
                return "<br>$years years ago";
            }   
        }
        if($deltaD > 6){
            return strftime('d-M',strtotime("$deltaD days ago"));
        }       
        return "$deltaD days ago";
    }
    if($deltaD == 1){
        return "hier";
    }
    if($deltaH == 1){
        return "dernière heure";
    }
    if($deltaM == 1){
        return "dernière minute";
    }
    if($deltaH > 0){
        return $deltaH." hours ago";
    }
    if($deltaM > 0){
        return $deltaM." minutes ago";
    }
    else{
        return "il ya quelques secondes";
    }
}  

}