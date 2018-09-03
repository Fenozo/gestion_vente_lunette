<?php
namespace AppBundle\Engine;

class Dates {

    public static function compare($date1,$compare,$date2) {

        if($date1 instanceof \Datetime) {
            $date1 = $date1->format('Y-m-d');
            
        } else {
            $date1 = (new \DateTime($date1))->format('Y-m-d');
        }
        if($date2 instanceof \Datetime) {
            $date2 = $date2->format('Y-m-d');
        } else {
            $date2 = (new \DateTime($date2))->format('Y-m-d');
        }

            $response = false;

        if( $compare == "==") {
            if(strtotime($date1) == strtotime($date2)) {
                $response = true;
            }
        } else if( $compare == ">=") {
            if(strtotime($date1) >= strtotime($date2)) {
                $response = true;
            }
        }else if( $compare == ">") {
            if(strtotime($date1) > strtotime($date2)) {
                $response = true;
            }
        }else if( $compare == "<=") {
            if(strtotime($date1) <= strtotime($date2)) {
                $response = true;
            }
        }else if( $compare == "<") {
            if(strtotime($date1) < strtotime($date2)) {
                $response = true;
            }
        }
        return $response;
    }

    public static function interval_mois($mois,$annees = null) {
        $annees = ( $annees == null ) ? date('Y') : $annees;
        $mois = ( $mois == null ) ? date('m'):$mois;
        $date_debut = date('Y').'-'.$mois.'-01';
        $time = mktime(0, 0, 0, (int)$mois + 1, 1, $annees);
        $time--;
        $date_fin = date($annees.'-m-d', $time);
        
        return array('debut' => $date_debut, 'fin' => $date_fin ,'mois'=>$mois);
    }

    public static function interval_annees($annees = null) {
        $annees = ( $annees == null ) ? date('Y') : $annees;
        $date_debut = date($annees).'-01-01';
        $mois = 12;
        $time = mktime(0, 0, 0, (int)$mois + 1, 1, $annees);
        $time--;
        $date_fin = date($annees.'-m-d', $time);
        return array('debut' => $date_debut, 'fin' => $date_fin ,'mois'=>$mois);

    }

}