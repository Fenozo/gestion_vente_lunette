<?php
namespace AppBundle\Engine;

class StatistiqueCommande {


    private $commandes = [];

    public function init($commandes) {

        foreach($commandes as $commande) {
            for($i = 1; $i<=12; $i++) {
                $date = $commande->getCreatedAt();
                if ($date->format('m') == $i) {
                    $this->commandes[$date->format("Y")][$i][$commande->getType()][$commande->getEtat()][] = $commande->getQuantite();
                }
            }
        }
        
    }

    public function pourcentage() {
        dump($this->commandes);
    }
    
}